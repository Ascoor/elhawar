<?php

namespace Modules\RestAPI\Http\Controllers;

use App\Events\NewInvoiceEvent;
use App\Events\PaymentReminderEvent;
use App\memberDetails;
use App\PaymentGatewayCredentials;
use App\Scopes\CompanyScope;
use App\User;
use Carbon\Carbon;
use GuzzleHttp;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\RestAPI\Entities\Invoice;
use Modules\RestAPI\Http\Requests\Invoice\IndexRequest;
use Modules\RestAPI\Http\Requests\Invoice\CreateRequest;
use Modules\RestAPI\Http\Requests\Invoice\ShowRequest;
use Modules\RestAPI\Http\Requests\Invoice\UpdateRequest;
use Modules\RestAPI\Http\Requests\Invoice\DeleteRequest;

class FawryPayController extends ApiBaseController
{

    protected $model = Invoice::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = CreateRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $showRequest = ShowRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function payUsingCard(Request $request): JsonResponse
    {
        $data = $request->all();
        $rules = [
            'invoiceId' => 'required|string',
            'cardNumber' => 'required|digits:16',
            'cardExpiryYear' => 'required|regex:/[0-9]{2}$/',
            'cardExpiryMonth' => 'required|regex:/[0-9]{2}$/',
            'cvv' => 'required|digits:3',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            $invoice = \App\Invoice::findOrFail($data['invoiceId']);
            $credential = PaymentGatewayCredentials::withoutGlobalScope(CompanyScope::class)
                ->where('company_id', $invoice->company_id)
                ->first();

            $charge_request['merchantCode'] = $credential->fawry_mode == 'live' ? $credential->live_merchant_code : $credential->sandbox_merchant_code;
            $charge_request['merchantRefNum'] = $invoice->id;
            $charge_request['cardNumber'] = $data['cardNumber'];
            $charge_request['cardExpiryYear'] = $data['cardExpiryYear'];
            $charge_request['cardExpiryMonth'] = $data['cardExpiryMonth'];
            $charge_request['cvv'] = $data['cvv'];
            $charge_request['customerMobile'] = $invoice->client->mobile;
            $charge_request['customerEmail'] = $invoice->client->email;
            $charge_request['customerName'] = $invoice->client->name;
            $charge_request['customerProfileId'] = $invoice->client->id;
            $charge_request['amount'] = number_format($invoice->sub_total  ,2 , '.' , '');
            $charge_request['paymentMethod'] = 'CARD';
            $charge_request['currencyCode'] = 'EGP';
            $charge_request['language'] = 'en-gb';
            $invoice_items = $invoice->items;
            $chargeItems = array();
            foreach ($invoice_items as $item)
            {
                $product['itemId'] = $item->id;
                $product['description'] = $item->item_name;
                $product['price'] = number_format($item->unit_price ,2 , '.' , '');
                $product['quantity'] = $item->quantity;
                array_push($chargeItems , $product);
            }
            $charge_request['chargeItems'] = $chargeItems;
            $charge_request['authCaptureModePayment'] = false;
            $charge_request['enable3DS'] = false;

            $api_url = $credential->fawry_mode == 'live' ? 'https://www.atfawry.com/' : 'https://atfawry.fawrystaging.com/';
            $url = $api_url . 'ECommerceWeb/Fawry/payments/charge';
            $signature = $this->GenerateSignature($credential , $charge_request);
            $charge_request['signature'] = $signature;
            $method = "POST";

            $response = $this->ApiConnect($method, $url, $charge_request);
            // Handling Fawry Response
            if($response['statusCode'] && $response['statusCode'] ==200)
            {
                $invoiceId = $response['merchantRefNumber'];
                $invoice = \App\Invoice::findOrFail($invoiceId);
                $amount = $response['orderAmount'] ;
                $projectId = $invoice->project_id;
                $companyId = $invoice->company_id;
                $transaction_id = $response['referenceNumber'] ?? '';
                $paymentMethod = $response['paymentMethod'] ?? '';
                $mobile_response['message'] = '';
                $mobile_response['status'] = 200;

                // New, PAID, CANCELED, DELIVERED, REFUNDED, EXPIRED, PARTIAL_REFUNDED, FAILED
                if(strtolower($response['orderStatus']) == 'paid')
                {
                    $mobile_response['message'] = 'Payment was successful. Thanks for your payment.';
                    $invoice_status = 'paid';
                    $payment_status = 'complete';
                    $invoice->status = $invoice_status;
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
                    $paid_on = Carbon::createFromTimestamp($request['paymentTime']);
                    $invoice->save();
                }
                else if(strtolower($request['orderStatus']) == 'canceled')
                {
                    $mobile_response['message'] = 'Invoice is still pending payment. Please continue the payment process.';
                    $mobile_response['referenceNumber'] = $response['referenceNumber'];
                    $payment_status = 'pending';
                    $invoice_status = 'canceled';
                    $invoice->status = $invoice_status;
                    $invoice->save();
                }
                else
                {
                    $mobile_response['message'] = 'Invoice is still pending payment. Please continue the payment process using the reference number at any Fawry POS.';
                    $mobile_response['referenceNumber'] = $response['referenceNumber'];
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
                if($payment_status == 'complete' && !empty($paid_on))
                    $payment->paid_on = $paid_on;
                $payment->save();
                return response()->json($mobile_response);

            } else {
                $mobile_response['message'] = 'Payment was not successful - Reason:' . $response['statusDescription'];
                $mobile_response['status'] = 302;
                return response()->json($mobile_response);
            }
        } else {
            $mobile_response['type'] = "ChargeResponse";
            $mobile_response['statusCode'] = 9946;
            $mobile_response['statusDescription'] = $validator->errors()->all();
            return response()->json($mobile_response);
        }
    }
    public function payUsingRefCode(Request $request)
    {
        $data = $request->all();
        $rules = [
            'invoiceId' => 'required|string',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            $invoice = \App\Invoice::findOrFail($data['invoiceId']);
            $credential = PaymentGatewayCredentials::withoutGlobalScope(CompanyScope::class)
                ->where('company_id', $invoice->company_id)
                ->first();
            $charge_request['merchantCode'] = $credential->fawry_mode == 'live' ? $credential->live_merchant_code : $credential->sandbox_merchant_code;
            $charge_request['merchantRefNum'] = $invoice->id;
            $charge_request['customerMobile'] = $invoice->client->mobile;
            $charge_request['customerEmail'] = $invoice->client->email;
            $charge_request['customerName'] = $invoice->client->name;
            $charge_request['customerProfileId'] = $invoice->client->id;
            $charge_request['amount'] = number_format($invoice->sub_total  ,2 , '.' , '');
            $charge_request['paymentMethod'] = 'PayAtFawry';
            $charge_request['language'] = 'en-gb';
            $charge_request['currencyCode'] = 'EGP';
            $invoice_items = $invoice->items;
            $chargeItems = array();
            foreach ($invoice_items as $item)
            {
                $product['itemId'] = $item->id;
                $product['description'] = $item->item_name;
                $product['price'] = number_format($item->unit_price ,2 , '.' , '');
                $product['quantity'] = $item->quantity;
                array_push($chargeItems , $product);
            }
            $charge_request['chargeItems'] = $chargeItems;
            $charge_request['authCaptureModePayment'] = false;

            $api_url = $credential->fawry_mode == 'live' ? 'https://www.atfawry.com/' : 'https://atfawry.fawrystaging.com/';
            $url = $api_url . 'ECommerceWeb/Fawry/payments/charge';
            $signature = $this->GenerateSignature($credential , $charge_request);
            $charge_request['signature'] = $signature;
            $method = "POST";
            $response = $this->ApiConnect($method, $url, $charge_request);
            // Handling Fawry Response
            if($response['statusCode'] && $response['statusCode'] ==200)
            {
                $invoiceId = $response['merchantRefNumber'];
                $invoice = \App\Invoice::findOrFail($invoiceId);
                $amount = $response['orderAmount'] ;
                $projectId = $invoice->project_id;
                $companyId = $invoice->company_id;
                $transaction_id = $response['referenceNumber'] ?? '';
                $paymentMethod = $response['paymentMethod'] ?? '';
                $mobile_response['message'] = '';
                $mobile_response['status'] = 200;

                // New, PAID, CANCELED, DELIVERED, REFUNDED, EXPIRED, PARTIAL_REFUNDED, FAILED
                if(strtolower($response['orderStatus']) == 'paid')
                {
                    $mobile_response['message'] = 'Payment was successful. Thanks for your payment.';
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
                else if(strtolower($request['orderStatus']) == 'canceled')
                {
                    $mobile_response['message'] = 'Invoice is still pending payment. Please continue the payment process.';
                    $mobile_response['referenceNumber'] = $response['referenceNumber'];
                    $payment_status = 'pending';
                    $invoice_status = 'canceled';
                    $invoice->status = $invoice_status;
                    $invoice->save();
                }
                else
                {
                    $mobile_response['message'] = 'Invoice is still pending payment. Please continue the payment process using the reference number at any Fawry POS.';
                    $mobile_response['referenceNumber'] = $response['referenceNumber'];
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
                if($payment_status == 'complete' && !empty($paid_on))
                    $payment->paid_on = $paid_on;
                $payment->save();
                return response()->json($mobile_response);

            } else {
                $mobile_response['message'] = 'Payment was not successful - Reason:' . $response['statusDescription'];
                $mobile_response['status'] = 302;
                return response()->json($mobile_response);
            }
        } else {
            $mobile_response['type'] = "ChargeResponse";
            $mobile_response['statusCode'] = 9946;
            $mobile_response['statusDescription'] = $validator->errors()->all();
            return json_encode($mobile_response);
        }
    }
    public function getPaymentStatus(Request $request)
    {

    }
    public function ApiConnect($method, $url, $params , $header=null )
    {
        //$httpClient = new Client(['http_errors' => false , 'verify' => false,  'exceptions' => false]); // guzzle 6.3
        $httpClient = new GuzzleHttp\Client(); // guzzle 6.3

        if($method == 'GET')
        {
            $query_encoded = http_build_query($params , null, '&', 2);
            $query = urldecode($query_encoded);
            $query = str_replace('%20' , ' ' , $query);
            try{
                $response = $httpClient->request($method ,$url. '?' . $query);
                $response = json_decode($response->getBody()->getContents(), true);
                return $response;
            }
            catch (GuzzleHttp\Exception\ClientException $e)
            {
                $response['status'] = 500;
                $response['error'] = "Internal Server Error";
                return $response;
            }
        }
        elseif ($method == 'POST')
        {
            $post_params = json_encode( $params, true);
            try{
                if ($header){
                    $response = $httpClient->post($url, [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept'       => 'application/json',
                            'Authorization'=> 'Bearer '.$header
                        ],
                        'body' => $post_params
                    ]);
                }
                else{
                    $response = $httpClient->post($url, [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept'       => 'application/json'
                        ],
                        'body' => $post_params
                    ]);
                }
                return json_decode($response->getBody()->getContents(), true);
            }
            catch (GuzzleHttp\Exception\ClientException $e)
            {
                $response['status'] = 500;
                $response['error'] = "Internal Server Error";
                return $response;
            }
        }
        elseif ($method == 'DELETE')
        {
            $query_encoded = http_build_query($params , null, '&', 2);
            $query = urldecode($query_encoded);
            $query = str_replace('%20' , ' ' , $query);
            try{
                $response = $httpClient->request($method ,$url. '?' . $query /*,[
                'headers' => [
                        'Content-Type' => 'text/plain',
                    ],
            ]*/
                );
                $response = json_decode($response->getBody()->getContents(), true);
                return $response;
            }
            catch (GuzzleHttp\Exception\ClientException $e)
            {
                $response['status'] = 500;
                $response['error'] = "Internal Server Error";
                return $response;
            }

        }
    }

    public function GenerateSignature($credential , $request_body)
    {
        $merchantCode    = $credential->fawry_mode == 'live' ? $credential->live_merchant_code : $credential->sandbox_merchant_code;
        $merchantRefNum  = array_key_exists('merchantRefNum', $request_body) ?   $request_body['merchantRefNum'] : '';
        $merchantRefNumber  = array_key_exists('merchantRefNumber', $request_body) ?   $request_body['merchantRefNumber'] : '';
        $customerProfileId  = array_key_exists('customerProfileId', $request_body) ?   $request_body['customerProfileId'] : '';
        $paymentMethod = array_key_exists('paymentMethod', $request_body) ?   $request_body['paymentMethod'] : '';
        $amount = array_key_exists('amount', $request_body) ?   $request_body['amount']  : '';
        $cardToken = array_key_exists('cardToken', $request_body) ?  $request_body['cardToken']  : '';
        $cardNumber = array_key_exists('cardNumber', $request_body) ?  $request_body['cardNumber']  : '';
        $cardExpiryYear = array_key_exists('cardExpiryYear', $request_body) ?  $request_body['cardExpiryYear'] : '';
        $cardExpiryMonth = array_key_exists('cardExpiryMonth', $request_body) ?  $request_body['cardExpiryMonth'] : '';
        $cvv = array_key_exists('cvv', $request_body) ?  $request_body['cvv'] : '';
        $installmentPlanId = array_key_exists('installmentPlanId', $request_body) ?  $request_body['installmentPlanId'] : '';
        $returnUrl = array_key_exists('returnUrl', $request_body) ?  $request_body['returnUrl'] : '';
        $debitMobileWalletNo = array_key_exists('debitMobileWalletNo', $request_body) ?  $request_body['debitMobileWalletNo'] : '';
        $valuCustomerCode = array_key_exists('valuCustomerCode', $request_body) ?  $request_body['valuCustomerCode'] : '';
        $merchant_sec_key = $credential->fawry_mode == 'live' ? $credential->live_merchant_hash : $credential->sandbox_merchant_hash;
        $signature_body = $merchantCode . $merchantRefNum . $merchantRefNumber . $customerProfileId .
            $paymentMethod . $amount . $cardToken . $cardNumber . $cardExpiryYear .
            $cardExpiryMonth . $cvv . $installmentPlanId . $debitMobileWalletNo . $valuCustomerCode . $returnUrl . $merchant_sec_key;
        return hash('sha256', $signature_body);
    }

//    public function testCreatePaymentAtFawry(Request $request)
//    {
//        $data = $request->all();
//        $rules = [
//            'invoiceId' => 'required|string',
//        ];
//        $validator = Validator::make($data, $rules);
//        if ($validator->passes()) {
//            $invoice = \App\Invoice::findOrFail($data['invoiceId']);
//            $credential = PaymentGatewayCredentials::withoutGlobalScope(CompanyScope::class)
//                ->where('company_id', $invoice->company_id)
//                ->first();
//            $charge_request['merchantCode'] = $credential->fawry_mode == 'live' ? $credential->live_merchant_code : $credential->sandbox_merchant_code;
//            $charge_request['merchantRefNum'] = $invoice->id;
//            $charge_request['customerMobile'] = $invoice->client->mobile;
//            $charge_request['customerEmail'] = $invoice->client->email;
//            $charge_request['customerName'] = $invoice->client->name;
//            $charge_request['customerProfileId'] = $invoice->client->id;
//            $charge_request['paymentMethod'] = 'PayAtFawry';
//            $invoice_items = $invoice->items;
//            $chargeItems = array();
//            foreach ($invoice_items as $item)
//            {
//                $product['itemId'] = $item->id;
//                $product['description'] = $item->item_name;
//                $product['price'] = $item->unit_price;
//                $product['quantity'] = $item->quantity;
//                array_push($chargeItems , $product);
//            }
//            $charge_request['chargeItems'] = $chargeItems;
//            $charge_request['authCaptureModePayment'] = false;
//
//            $api_url = $credential->fawry_mode == 'live' ? 'https://www.atfawry.com/' : 'https://atfawry.fawrystaging.com/';
//            $url = $api_url . 'fawrypay-api/Fawry/payments/charge';
//            $signature = $this->GenerateSignature($credential , $charge_request);
//            $charge_request['signature'] = $signature;
//            $method = "POST";
//            $response = $this->ApiConnect($method, $url, $charge_request);
//            // Handling Fawry Response
//            if($response->has('statusCode') && $response['statusCode'] ==200)
//            {
//                $invoiceId = $response['merchantRefNumber'];
//                $invoice = \App\Invoice::findOrFail($invoiceId);
//                $amount = $response['orderAmount'] ;
//                $projectId = $invoice->project_id;
//                $companyId = $invoice->company_id;
//                $transaction_id = $response['referenceNumber'] ?? '';
//                $paymentMethod = $response['paymentMethod'] ?? '';
//                $mobile_response['message'] = '';
//                $mobile_response['status'] = 200;
//
//                // New, PAID, CANCELED, DELIVERED, REFUNDED, EXPIRED, PARTIAL_REFUNDED, FAILED
//                if(strtolower($response['orderStatus']) == 'paid')
//                {
//                    $mobile_response['message'] = 'Payment was successful. Thanks for your payment.';
//                    $invoice_status = 'paid';
//                    $payment_status = 'complete';
//                    $invoice->status = $invoice_status;
//                    $paid_on = Carbon::createFromTimestamp($request['paymentTime']);
//                    $invoice->save();
//                }
//                else if(strtolower($request['orderStatus']) == 'canceled')
//                {
//                    $mobile_response['message'] = 'Invoice is still pending payment. Please continue the payment process.';
//                    $mobile_response['referenceNumber'] = $response['referenceNumber'];
//                    $payment_status = 'pending';
//                    $invoice_status = 'canceled';
//                    $invoice->status = $invoice_status;
//                    $invoice->save();
//                }
//                else
//                {
//                    $mobile_response['message'] = 'Invoice is still pending payment. Please continue the payment process using the reference number at any Fawry POS.';
//                    $mobile_response['referenceNumber'] = $response['referenceNumber'];
//                    $payment_status = 'pending';
//                    $invoice_status = 'unpaid';
//                    $invoice->status = $invoice_status;
//                    $invoice->save();
//                }
//                // Get invoice payment to update or create new payment
//                $payment = \App\Payment::where('invoice_id', $invoiceId)->firstOrNew();
//                $payment->company_id = $companyId;
//                $payment->project_id = $projectId;
//                $payment->invoice_id = $invoiceId;
//                $payment->transaction_id = $transaction_id;
//                $payment->customer_id = $request['customerProfileId'];
//                $payment->amount = $amount;
//                $payment->gateway = 'Fawry';
//                $payment->currency_id = $invoice->currency_id;
//                $payment->status  = $payment_status;
//                if($payment_status == 'complete' && !empty($paid_on))
//                    $payment->paid_on = $paid_on;
//                $payment->save();
//                return response()->json($mobile_response);
//
//            } else {
//                $mobile_response['message'] = 'Payment was not successful - Reason:' . $response['statusDescription'];
//                $mobile_response['status'] = 302;
//                return response()->json($mobile_response);
//            }
//        } else {
//            $mobile_response['type'] = "ChargeResponse";
//            $mobile_response['statusCode'] = 9946;
//            $mobile_response['statusDescription'] = $validator->errors()->all();
//            return json_encode($mobile_response);
//        }
//    }
//
//    public function testCreatePaymentCard(Request $request)
//    {
//        $data = $request->all();
//        $rules = [
//            'merchantCode' => 'required|string',
//            'merchantRefNum' => 'required|string',
//            'signature' => 'required|string|size:64|regex:/([A-Fa-f0-9]{64})$/',
//            'cardNumber' => 'required|digits:16',
//            'cardExpiryYear' => 'required|regex:/[0-9]{2}$/',
//            'cardExpiryMonth' => 'required|regex:/[0-9]{2}$/',
//            'cvv' => 'required|digits:3',
//            //'customerName' => 'required|string',
//            'customerEmail' => 'required|email',
//            'customerMobile' => 'required|regex:/(01)[0-9]{9}/',
//            //'customerProfileId' => 'required|integer',
//            //'amount' => 'required|regex:/^(?:[1-9]\d+|\d)(?:\,\d\d)?$/',
//            'amount' => 'required|string',
//            'chargeItems.0.itemId' => 'required|string',
//            'chargeItems.0.description' => 'required|string',
//            'chargeItems.0.price' => 'required|string',
//            'chargeItems.0.quantity' => 'required|string',
//            'paymentMethod' => 'required|string',
//            'description' => 'required|string',
//        ];
//        $validator = Validator::make($data, $rules);
//        if ($validator->passes()) {
//            $api_url = config('app.api_url');
//            $url = $api_url . 'Fawry/payments/charge';
//            $signature = $this->GenerateSignature($url , $data);
//            $data['signature'] = $signature;
//            $method = "POST";
//            $response = $this->ApiConnect($method, $url, $data);
//            return json_encode($response);
//        } else {
//            $response['type'] = "ChargeResponse";
//            $response['statusCode'] = 9946;
//            $response['statusDescription'] = $validator->errors()->all();
//            return json_encode($response);
//        }
//    }
//
//    public function testGetPaymentStatusV2(Request $request)
//    {
//        $data = $request->all();
//        $rules = [
//            'merchantCode' => 'required|string', //Must be a number and length of value is 8
//            'merchantRefNumber' => 'required|string',
//            'signature' => 'required|string|size:64|regex:/([A-Fa-f0-9]{64})$/',
//        ];
//        $validator = Validator::make($data, $rules);
//        if ($validator->passes()) {
//            //$merchantCode = "1tSa6uxz2nTwlaAmt38enA==";
//            //$merchantRefNumber = $data['merchantRefNumber'];
//            //$merchant_sec_key = "259af31fc2f74453b3a55739b21ae9ef";
//            //$signature = hash('sha256', $merchantCode . $merchantRefNumber . $merchant_sec_key);
//            //$data['merchantCode'] = $merchantCode;
//            //$data['signature'] = $signature;
//            $api_url = config('app.api_url');
//            $url = $api_url . 'Fawry/payments/status/v2';
//            $method = "GET";
//            if($data['merchantCode'] == "1tSa6uxz2nTwlaAmt38enA==" )
//            {
//                $signature = $this->GenerateSignature($url , $data);
//                $data['signature'] = $signature;
//            }
//            $response = $this->ApiConnect($method,$url,$data);
//            return json_encode($response);
//        } else {
//            //TODO Handle your error
//            $response['type'] = "ChargeResponse";
//            $response['statusCode'] = 9946;
//            $response['statusDescription'] = $validator->errors()->all();
//            return json_encode($response);
//        }
//    }

}
