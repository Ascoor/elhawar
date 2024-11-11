<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\memberDetails;
use App\PaymentGatewayCredentials;
use App\Scopes\CompanyScope;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


use Carbon\Carbon;

class FawryController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->pageTitle = 'FawryPay';
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function paymentWithFawry(Request $request, $invoiceId) : JsonResponse
    {
        $invoice = Invoice::findOrFail($invoiceId);
        $credential = PaymentGatewayCredentials::withoutGlobalScope(CompanyScope::class)
            ->where('company_id', $invoice->company_id)
            ->first();
        $response['chargeRequest']['merchantCode'] = $credential->fawry_mode == 'live' ? $credential->live_merchant_code : $credential->sandbox_merchant_code;
        $response['chargeRequest']['merchantRefNum'] = $invoice->id;
        $response['chargeRequest']['customerMobile'] = str_replace(' ', '',$invoice->client->mobile);
        $response['chargeRequest']['customerEmail'] = $invoice->client->email;
        $response['chargeRequest']['customerName'] = $invoice->client->name;
        $response['chargeRequest']['customerProfileId'] = $invoice->client->id;
        $invoice_items = $invoice->items;
        $chargeItems = array();
        foreach ($invoice_items as $item)
        {
            $product['itemId'] = $item->id;
            $product['description'] = $item->item_name;
            $product['price'] = number_format(floatval($item->unit_price) , 2 , '.' , '');
            $product['quantity'] = $item->quantity;
            $chargeItems[] = $product;
        }
        //$response['chargeRequest']['paymentExpiry'] = $invoice->id;
        $response['chargeRequest']['chargeItems'] = $chargeItems;
        $response['chargeRequest']['returnUrl'] = route('member.fawryPaymentReturn');
        $response['chargeRequest']['authCaptureModePayment'] = false;

        // Prepare Signature String
        $merchantCode = $credential->fawry_mode === 'live' ? $credential->live_merchant_code : $credential->sandbox_merchant_code;
        $merchantHashCode = $credential->fawry_mode === 'live' ? $credential->live_merchant_hash : $credential->sandbox_merchant_hash;
        $sorted_order_signature_string = $this->getSortedOrderSignatureString($invoice_items);
        $merchantRefNum = $invoice->id;
        $profile_id = $invoice->client->id;
        $return_url = route('member.fawryPaymentReturn');
        $signature = hash('sha256' ,
            $merchantCode
            . $merchantRefNum
            . ($profile_id  ?? "")
            . $return_url
            . $sorted_order_signature_string
            . $merchantHashCode);
        $response['chargeRequest']['signature'] = $signature;
        // End Fawry Signature

        $response['status'] = 'success';
        $response['message'] = 'Opening Fawry Checkout';
        return response()->json($response);
    }

    public function fawryPaymentReturn(Request $request) : RedirectResponse
    {
        if($request->has('merchantRefNumber'))
        {
            $redirectRoute = 'member.invoices.show';
            $validate_signature = $this->verifyURlSignature($request);
        } else {
            $redirectRoute = 'member.invoices.index';
            $validate_signature = 0;
        }

        if($request->has('statusCode') && $request['statusCode'] ==200 && $validate_signature == 1)
        {
            $invoiceId = $request['merchantRefNumber'];
            $invoice = Invoice::findOrFail($invoiceId);
            $amount = $request['orderAmount'] ;
            $projectId = $invoice->project_id;
            $companyId = $invoice->company_id;
            $transaction_id = $request['referenceNumber'] ?? '';
            $paymentMethod = $request['paymentMethod'] ?? '';

            // New, PAID, CANCELED, DELIVERED, REFUNDED, EXPIRED, PARTIAL_REFUNDED, FAILED
            if(strtolower($request['orderStatus']) === 'paid')
            {
                Session::put('success','Payment was successful. Thanks for your payment');
                $invoice_status = 'paid';
                $payment_status = 'complete';
                $invoice->status = $invoice_status;
                $paid_on = Carbon::createFromTimestamp($request['paymentTime']);
                $invoice->save();
                if($invoice->membership == 1)
                {
                    $member_id = $invoice->client->id;
                    $member_detail = memberDetails::where('user_id' , $member_id)->first();
                    if($member_detail)
                    {
                        $member_detail->renewal_status = 'renewed';
                        $member_detail->save();
                    }
                }
            }
            else if(strtolower($request['orderStatus']) === 'canceled')
            {
                Session::put('success','Invoice is still pending payment. Please continue the payment process.');
                $payment_status = 'pending';
                $invoice_status = 'canceled';
                $invoice->status = $invoice_status;
                $invoice->save();
            }
            else
            {
                Session::put('success','Invoice is still pending payment. Please continue the payment process.');
                $payment_status = 'pending';
                $invoice_status = 'unpaid';
                $invoice->status = $invoice_status;
                $invoice->save();
            }
            // Get invoice payment to update or create new payment
            $payment = \App\Payment::where('invoice_id', $invoiceId)->firstOrNew();
            $payment->company_id = $companyId;
            $payment->project_id = $projectId;
            $payment->invoice_id = $invoiceId;
            $payment->transaction_id = $transaction_id;
            $payment->customer_id = $request['customerProfileId'];
            $payment->amount = $amount;
            $payment->gateway = 'Fawry';
            $payment->currency_id = $invoice->currency_id;
            $payment->status  = $payment_status;
            if($payment_status == 'complete')
                $payment->paid_on = $paid_on;
            $payment->save();
            return Redirect::route($redirectRoute, $invoiceId);

        } else {
            Session::put('error','Payment was not successful - Reason:' . $request['statusDescription']);
            return Redirect::route($redirectRoute);
        }

    }

    public function verifyURlSignature($request): int
    {
        $invoiceId = $request['merchantRefNumber'] ?? '';
        $invoice = Invoice::findOrFail($invoiceId);
        $credential = PaymentGatewayCredentials::withoutGlobalScope(CompanyScope::class)
            ->where('company_id', $invoice->company_id)
            ->first();
        $merchantCode = $credential->fawry_mode === 'live' ? $credential->live_merchant_code : $credential->sandbox_merchant_code;
        $merchantHashCode = $credential->fawry_mode === 'live' ? $credential->live_merchant_hash : $credential->sandbox_merchant_hash;
        if($request->has('referenceNumber'))
            $refNumber = $request['referenceNumber'];
        else
            $refNumber = $request['fawryRefNumber']  ?? "";

        if($request->has('signature'))
            $messageSignature = $request['signature'];
        else
            $messageSignature = $request['messageSignature']  ?? "";

        $signature_string =   $refNumber
            . ($request['merchantRefNumber']  ?? "")
            . (number_format($request['paymentAmount']  , '2' , '.' , '') ?? "")
            . (number_format($request['orderAmount']   , '2' , '.' , '') ?? "")
            . ($request['orderStatus']  ?? "")
            . ($request['paymentMethod']  ?? "")
            . (($request->has('fawryFees'))? (number_format($request['fawryFees']  , '2' , '.' , '')) : "")
            . (($request->has('shippingFees'))? (number_format($request['shippingFees']  , '2' , '.' , '')) : "")
            . ($request['authNumber']  ?? "")
            . ($request['customerMail']  ?? "")
            . ($request['customerMobile']  ?? "")
            . ($request['paymentRefrenceNumber'] ?? "")
            . $merchantHashCode;
        $generated_signature = hash('sha256' , $signature_string);
        if($generated_signature === $messageSignature)
            return 1;
        else
            return 0;
    }

    public function getSortedOrderSignatureString($invoice_items): string
    {
        $order_items = array();
        $signature_string = '';
        foreach ($invoice_items as $item) {
            $order_items[] = [
                'itemId' => $item->id,
                'description' => $item->item_name,
                'quantity' => $item->quantity,
                'price' => number_format(floatval($item->unit_price) , 2 , '.' , ''),
            ];
        }
        $itemId = array_column($order_items, 'itemId');
        array_multisort($itemId, SORT_ASC, $order_items);
        foreach ($order_items as $order_item)
        {
            $signature_string .=   $order_item['itemId'] . $order_item['quantity'] . $order_item['price'] ;
        }
        return $signature_string;
    }


}
