<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RefundController extends Controller
{
    public function refund(Request $request)
    {
        $data = $request->json()->all();

        // Validate request
        $validator = Validator::make($data, [
            'merchant_id'   => 'required|exists:merchants,id',
            'order_id'      => 'required|string|max:50',
            'refund_amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response_code' => 1, // Basic Validation
                'response_message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Fetch transaction, POS, Bank, Currency
        $transaction = Transaction::where('order_id', $data['order_id'])->where('merchant_id', $data['merchant_id'])->first();

        if (empty($transaction)) {
            return response()->json(['response_code' => 2, 'response_message' => 'Transaction not found'], 422);
        }

        $pos = $transaction->pos;
        $bank = $pos->bank;
        $currency = $transaction->currency;

        $amount = $transaction->gross;
        $refunded = $transaction->refunded_amount;
        $refundAmount = $data['refund_amount'];

        // Validate refund rules
        if ($refundAmount <= 0) {
            return response()->json(['response_code' => 3, 'response_message' => 'Refund amount must be greater than 0.'], 422);
        }

        if ($refundAmount > ($amount - $refunded)) {
            return response()->json(['response_code' => 4, 'response_message' => 'Refund amount cannot be greater than remaining transaction amount.'], 422);
        }

        // Prepare bank payload
        $payload = [
            'username'      => $bank->user_name,
            'password'      => $bank->user_password,
            'amount'        => $amount-$refunded,
            'refund_amount' => $refundAmount,
            'order_id'      => $transaction->order_id,
        ];

        // Call bank API
        try {
            $bank_refund_url = str_replace(".php", "-refund.php", $bank->api_url);
            $bankResponse = Http::asForm()->post($bank_refund_url, $payload)->json();
        } catch (\Exception $e) {
            return response()->json(['response_code' => 5, 'response_message' => 'Failed to connect to bank API', 'error' => $e->getMessage()], 500);
        }

        // Determine transaction state
        $success = isset($bankResponse['response_code']) && (int)$bankResponse['response_code'] === 100;

        // Update transaction & create refund record if successful
        if ($success) {
            $transaction->refunded_amount += $refundAmount;
            $transaction->transaction_state = ($transaction->refunded_amount == $transaction->gross)
                ? 'Refunded'
                : 'Partial Refunded';
            $transaction->save();

            Refund::create([
                'transaction_id'    => $transaction->id,
                'invoice_id'        => $transaction->invoice_id,
                'transaction_state' => $transaction->transaction_state,
                'amount'            => $refundAmount,
            ]);

        }

        // Prepare payment-style response
        $commissionPercentage = $pos->commission_percentage ?? 2.5;
        $commissionFixed = $pos->commission_fixed ?? 0.5;
        $bankFee = $pos->bank_fee ?? 0.2;

        $fee = ($refundAmount * $commissionPercentage / 100) + $commissionFixed + $bankFee;
        $net = $refundAmount - $fee;

        $paymentResponse = [
            'response_code'    => $bankResponse['response_code'] ?? 500,
            'response_message' => $bankResponse['response_message'] ?? ($success ? 'Refund successful' : 'Refund failed'),
            'data' => [
                'bank_order_id' => $bankResponse['data']['bank_order_id'] ?? null,
                'amount'        => $refundAmount,
                'currency_code' => $currency->code ?? 'BDT',
                'payment_at'    => $bankResponse['data']['payment_at'] ?? now()->format('Y-m-d H:i:s'),
                'fee_details'   => [
                    'commission_percentage' => $commissionPercentage,
                    'commission_fixed'      => $commissionFixed,
                    'bank_fee'              => $bankFee,
                ],
                'net_amount'    => $net,
            ],
        ];

        return response()->json($paymentResponse, 200);
    }
}