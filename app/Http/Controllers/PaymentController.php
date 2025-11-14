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
            return response()->json(['response_code' => 2, 'response_message' => 'Merchant not found'], 422);
        }

        
        $pos = Pos::first();
        if (!$pos) {
            return response()->json(['response_code' => 3, 'response_message' => 'POS not found'], 422);
        }

        $bank = Bank::find($pos->bank_id);
        if (!$bank) {
            return response()->json(['response_code' => 4, 'response_message' => 'Bank not found'], 422);
        }

        $currency = Currency::where('code', $data['currency_code'])->first();
        if (!$currency) {
            return response()->json(['response_code' => 5, 'response_message' => 'Invalid currency code'], 422);
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

        
        try {
            $bankResponse = Http::asForm()->post($bank->api_url, $payload);
            $bankResult = $bankResponse->json();
        } catch (\Exception $e) {
            return response()->json([
                'response_code' => 500,
                'response_message' => 'Failed to connect to bank API',
                'error' => $e->getMessage()
            ], 500);
        }

        // Step 6: Determine transaction state
        $transactionState = 'Failed';
        if (isset($bankResult['response_code']) && $bankResult['response_code'] == 100) {
            $transactionState = 'Completed';
        } elseif (isset($bankResult['response_code']) && $bankResult['response_code'] == 1) {
            $transactionState = 'Pending';
        } elseif (isset($bankResult['response_code']) && $bankResult['response_code'] == 4) {
            $transactionState = 'Failed';
        }

        // Step 7: Calculate fee and net
        $commissionPercentage = $pos->commission_percentage ?? 2.5;
        $commissionFixed = $pos->commission_fixed ?? 0.5;
        $bankFee = $pos->bank_fee ?? 0.2;

        $fee = ($data['amount'] * $commissionPercentage / 100) + $commissionFixed + $bankFee;
        $net = $data['amount'] - $fee;

        // Step 8: Record transaction
        $transactionData = [
            'invoice_id'        => $data['invoice_id'],
            'order_id'          => $bankResult['order_id'] ?? 'DBOI' . time() . rand(100, 999),
            'gross'             => $data['amount'],
            'net'               => $net,
            'fee'               => $fee,
            'refunded_amount'   => 0,
            'transaction_state' => $transactionState,
            'pos_id'            => $pos->id,
            'currency_id'       => $currency->id,
            'merchant_id'       => $merchant->id,
        ];

        Transaction::create($transactionData);

        // Step 9: Return bank response
        $responseCode = $bankResult['code'] ?? 500;
        $responseMessage = $bankResult['message'] ?? 'Unknown error';
        $bankData = $bankResult['data'] ?? [];

        return response()->json([
            'response_code' => $responseCode,
            'response_message' => $responseMessage,
            'data' => $bankData
        ], 200);

    }
}
