<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Pos;
use App\Models\Bank;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'merchant_id'      => 'required|exists:merchants,id',
            'invoice_id'       => 'required|string|max:50',
            'currency_code'    => 'required|exists:currencies,code',
            'card_no'          => 'required|digits:16',
            'card_holder_name' => 'required|string|max:255',
            'card_cvv'         => 'required|digits:3',
            'card_exp'         => 'required|digits:4',
            'amount'           => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response_code' => 1, // Basic Validation
                'response_message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $merchant = Merchant::find($data['merchant_id']);
        if (!$merchant) {
            return response()->json(['response_code' => 2, 'response_message' => 'Merchant not found','data'=>[]], 422);
        }

        
        $pos = Pos::first();
        if (!$pos) {
            return response()->json(['response_code' => 3, 'response_message' => 'POS not found','data'=>[]], 422);
        }

        $bank = Bank::find($pos->bank_id);
        if (!$bank) {
            return response()->json(['response_code' => 4, 'response_message' => 'Bank not found','data'=>[]], 422);
        }

        $currency = Currency::where('code', $data['currency_code'])->first();
        if (!$currency) {
            return response()->json(['response_code' => 5, 'response_message' => 'Invalid currency code','data'=>[]], 422);
        }


        $transaction = Transaction::where('invoice_id', $data['invoice_id'])->where('merchant_id', $data['merchant_id'])->first();
        // dd($transaction);
        if (!empty($transaction)) {
            return response()->json(['response_code' => 6, 'response_message' => 'Invoice already exists','data'=>[]], 422);
        }

        
        $payload = [
            'username'          => $bank->user_name,
            'password'          => $bank->user_password,
            'card_no'           => $data['card_no'],
            'card_holder_name'  => $data['card_holder_name'],
            'card_cvv'          => $data['card_cvv'],
            'card_exp'          => $data['card_exp'],
            'amount'            => $data['amount'],
            'invoice_id'        => $data['invoice_id'],
        ];

        
        $bankResponse = Http::asForm()->post($bank->api_url, $payload);
        $bankResult = $bankResponse->json();

        

        $responseCode = $bankResult['code'] ?? 422;
        $responseMessage = $bankResult['message'] ?? 'Unknown error';
        $bankOrderId = $bankResult['data']['bank_order_id'] ?? null; 
        $paymentAt = $bankResult['data']['payment_at'] ?? now();

        // Step 6: Determine transaction state
        $transactionState = 'Failed';
        if (isset($bankResult['code']) && $bankResult['code'] == 100) {
            $transactionState = 'Completed';
        }

        // Step 7: Calculate fee and net
        $commissionPercentage = $pos->commission_percentage ?? 0.0;
        $commissionFixed = $pos->commission_fixed ?? 0.0;
        $bankFee = $pos->bank_fee ?? 0.0;
        // Log::info("")---> all action should be under try-catch 

        $fee = ($data['amount'] * $commissionPercentage / 100) + $commissionFixed + $bankFee;
        $net = $data['amount'] - $fee;

        // Step 8: Record transaction
        $transactionData = [
            'invoice_id'        => $data['invoice_id'],
            'order_id'          => $bankOrderId,
            'gross'             => $data['amount'],
            'net'               => $net,
            'fee'               => $fee,
            'refunded_amount'   => 0,
            'transaction_state' => $transactionState,
            'settlement_date'   => $paymentAt,
            'pos_id'            => $pos->id,
            'currency_id'       => $currency->id,
            'merchant_id'       => $merchant->id,
        ];


        $result=Transaction::create($transactionData);
        if(!$result){
            $responseCode=422;
            $responseMessage="Payment Failed";
        }
        
        


        return response()->json([
            'response_code' => $responseCode,
            'response_message' => $responseMessage,
            'data' => [
                'bank_order_id' => $bankOrderId,
                'order_id' => $bankOrderId,
                'invoice_id' => $data['invoice_id'],
                'amount' => $data['amount'],
                'currency_code' => $currency->code,
                'payment_at' => $paymentAt,
                'fee_details' => [
                    'commission_percentage' => $commissionPercentage,
                    'commission_fixed' => $commissionFixed,
                    'bank_fee' => $bankFee,
                ]
            ]
        ]);

    }
}
