<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Pos;
use App\Models\Bank;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
                'response_code' => 422,
                'response_message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $merchant = Merchant::find($data['merchant_id']);
        if (!$merchant) {
            return response()->json(['response_code' => 422, 'response_message' => 'Merchant not found']);
        }

        $pos = Pos::first();
        if (!$pos) {
            return response()->json(['response_code' => 422, 'response_message' => 'POS not found']);
        }

        $bank = Bank::find($pos->bank_id);
        if (!$bank) {
            return response()->json(['response_code' => 422, 'response_message' => 'Bank not found']);
        }

        $currency = Currency::where('code', $data['currency_code'])->first();
        if (!$currency) {
            return response()->json(['response_code' => 422, 'response_message' => 'Invalid currency code']);
        }


        if ($bank->user_name !== 'dummybank' || $bank->user_password !== '!apple') {
            return response()->json([
                'response_code' => 422,
                'response_message' => 'Wrong bank credentials',
                'data' => [] 
            ]);
        }

        // Validate card info
        if (strlen($data['card_no']) < 16 || strlen($data['card_cvv']) < 3 || strlen($data['card_exp']) < 4) {
            return response()->json([
                'response_code' => 422,
                'response_message' => 'Card number or CVV number is invalid',
                'data' => []
            ]);
        }

        // Validate amount
        if ($data['amount'] <= 0) {
            return response()->json([
                'response_code' => 422,
                'response_message' => "Amount can't be less than or equal 0",
                'data' => []
            ]);
        }

        // Everything is OK, generate dummy bank order ID
        $bankOrderId = 'DBOI' . time() . rand(100, 999);
        $paymentAt = now()->format('Y-m-d H:i:s');

        $commissionPercentage = $pos->commission_percentage ?? 2.5; // example values like dummy-bank
        $commissionFixed = $pos->commission_fixed ?? 0.5;
        $bankFee = $pos->bank_fee ?? 0.2;

        $fee = ($data['amount'] * $commissionPercentage / 100) + $commissionFixed + $bankFee;
        $net = $data['amount'] - $fee;

        // Record transaction
        $transactionData = [
            'invoice_id'        => $data['invoice_id'],
            'order_id'          => $bankOrderId,
            'gross'             => $data['amount'],
            'net'               => $net,
            'fee'               => $fee,
            'refunded_amount'   => 0,
            'transaction_state' => 'Completed',
            'pos_id'            => $pos->id,
            'currency_id'       => $currency->id,
            'merchant_id'       => $merchant->id,
        ];

        Transaction::create($transactionData);

        // Return response in dummy-bank format
        return response()->json([
            'response_code' => 100,
            'response_message' => 'Success',
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
