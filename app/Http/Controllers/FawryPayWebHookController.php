<?php

namespace App\Http\Controllers;

use App\Invoice;

use App\memberDetails;
use App\PaymentGatewayCredentials;
use App\Scopes\CompanyScope;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class FawryPayWebHookController extends Controller
{

    const PAYMENT_AUTHORIZED        = 'subscription.charged';
    const PAYMENT_FAILED            = 'payment.failed';
    const SUBSCRIPTION_CANCELLED    = 'subscription.cancelled';

    public function fawryCallback(Request $request)
    {
        if($request->has('merchantRefNumber'))
        {
            $validate_signature = $this->verifyCallBackSignature($request);
        }
        else
        {
            $validate_signature = 0;
        }
        if($request->has('merchantRefNumber') && $validate_signature == 1)
        {
            $invoiceId = $request['merchantRefNumber'];
            $invoice = Invoice::findOrFail($invoiceId);
            $amount = $request['orderAmount'] ;
            $projectId = $invoice->project_id;
            $companyId = $invoice->company_id;
            $transaction_id = $request['fawryRefNumber'] ?? '';
            $paymentMethod = $request['paymentMethod'] ?? '';

            // New, PAID, CANCELED, DELIVERED, REFUNDED, EXPIRED, PARTIAL_REFUNDED, FAILED
            if(strtolower($request['orderStatus']) === 'paid')
            {
                $invoice_status = 'paid';
                $payment_status = 'complete';
                $invoice->status = $invoice_status;
                $paid_on = Carbon::now();
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
                $payment_status = 'pending';
                $invoice_status = 'canceled';
                $invoice->status = $invoice_status;
                $invoice->save();
            }
            else
            {
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
            $payment->customer_id = $request['customerMerchantId'];
            $payment->amount = $amount;
            $payment->gateway = 'Fawry';
            $payment->currency_id = $invoice->currency_id;
            $payment->status  = $payment_status;
            if($payment_status == 'complete')
                $payment->paid_on = $paid_on;
            $payment->save();
            return response()->json(['success' => 'success'], 200);

        } else {
            return response()->json(['success' => 'success'], 401);
        }
    }

    public function verifyCallBackSignature($request): int
    {
        $invoiceId = $request['merchantRefNumber'];
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
            . ($request['paymentRefrenceNumber'] ?? "")
            . $merchantHashCode;
        $generated_signature = hash('sha256' , $signature_string);
        if($generated_signature === $messageSignature)
            return 1;
        else
            return 0;
    }
}
