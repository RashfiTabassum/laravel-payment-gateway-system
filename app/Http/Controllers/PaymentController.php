<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use App\Models\Bank;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
                'code'    => 422,
                'message' => $validator->errors(),
            ], 422);
        }

        $merchant = Merchant::find($data['merchant_id']);
        if (!$merchant) {
            return response()->json(['code' => 404, 'message' => 'Merchant not found']);
        }

        $pos = Pos::first();
        if (!$pos) {
            return response()->json(['code' => 404, 'message' => 'POS not found']);
        }

        $bank = Bank::find($pos->bank_id);
        if (!$bank) {
            return response()->json(['code' => 404, 'message' => 'Bank not found']);
        }

        $currency = Currency::where('code', $data['currency_code'])->first();
        if (!$currency) {
            return response()->json(['code' => 404, 'message' => 'Invalid currency code']);
        }

        $payload = [
            'username'          => $bank->user_name,
            'password'          => $bank->user_password,
            'card_no'           => $data['card_no'],
            'card_holder_name'  => $data['card_holder_name'],
            'card_cvv'          => $data['card_cvv'],
            'card_exp'          => $data['card_exp'],
            'amount'            => $data['amount'],
        ];

        try {
            $response = Http::asForm()->post($bank->api_url, $payload);
            $bankResponse = $response->json();

            //prepare array
            // Inject currency_code right after amount
            if (isset($bankResponse['data']) && is_array($bankResponse['data'])) {
                $bankResponse['data'] = array_merge(
                    [
                        'bank_order_id' => $bankResponse['data']['bank_order_id'] ?? null,
                        'amount'        => $bankResponse['data']['amount'] ?? $data['amount'],
                        'currency_code' => $currency->code
                    ],
                    array_diff_key($bankResponse['data'], ['bank_order_id'=>1,'amount'=>1])
                );
            } else {
                $bankResponse['data'] = [
                    'amount'        => $data['amount'],
                    'currency_code' => $currency->code
                ];
            }

        } catch (\Exception $e) {

            // Build a failed bank response with currency_code
            $bankResponse = [
                'code'    => 500,
                'message' => 'Bank API connection failed',
                'data'    => [
                    'amount'        => $data['amount'],
                    'currency_code' => $currency->code
                ]
            ];

            Transaction::create([
                'invoice_id'        => $data['invoice_id'],
                'order_id'          => Str::random(10),
                'transaction_state' => 'Failed',
                'gross'             => $data['amount'],
                'net'               => 0,
                'fee'               => 0,
                'refunded_amount'   => 0,
                'pos_id'            => $pos->id,
                'currency_id'       => $currency->id,
                'merchant_id'       => $merchant->id,
            ]);

            return response()->json([
                'code'    => 500,
                'message' => 'Failed to connect to bank API.',
                'data'    => [
                    'bank_response' => $bankResponse,
                    'invoice_id'    => $data['invoice_id'],
                    'fee_details'   => [
                        'commission_percentage' => $pos->commission_percentage ?? 0,
                        'commission_fixed'      => $pos->commission_fixed ?? 0,
                        'bank_fee'              => $pos->bank_fee ?? 0,
                    ],
                ],
            ]);
        }

        $status = (
            (isset($bankResponse['code']) && (int)$bankResponse['code'] === 100) ||
            (isset($bankResponse['message']) && strtolower($bankResponse['message']) === 'success')
        ) ? 'Completed' : 'Failed';

        $commissionPercentage = $pos->commission_percentage ?? 0;
        $commissionFixed      = $pos->commission_fixed ?? 0;
        $bankFee              = $pos->bank_fee ?? 0;

        $fee = ($data['amount'] * $commissionPercentage / 100) + $commissionFixed + $bankFee;
        $net = $data['amount'] - $fee;

        $transaction = Transaction::create([
            'invoice_id'        => $data['invoice_id'],
            'order_id'          => Str::random(10),
            'transaction_state' => $status,
            'gross'             => $data['amount'],
            'net'               => $net,
            'fee'               => $fee,
            'refunded_amount'   => 0,
            'pos_id'            => $pos->id,
            'currency_id'       => $currency->id,
            'merchant_id'       => $merchant->id,
        ]);

        return response()->json([
            'response_code'    => 200,
            'response_message' => 'Transaction recorded successfully.',
            'data' => [
                'bank_order_id'  => $bankResponse['data']['bank_order_id'] ?? null,
                'amount'         => $bankResponse['data']['amount'] ?? $data['amount'],
                'currency_code'  => $currency->code,
                'payment_at'     => $bankResponse['data']['payment_at'] ?? now()->format('Y-m-d H:i:s'),
                'fee_details'    => [
                    'commission_percentage' => $pos->commission_percentage ?? 0,
                    'commission_fixed'      => $pos->commission_fixed ?? 0,
                    'bank_fee'              => $pos->bank_fee ?? 0,
                ],
            ],
        ]);

    }
}
