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
        // 🔹 Log the incoming request
        Log::info('Incoming Payment Request', [
            'request_body' => $request->all()
        ]);

        try {
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
                $response = [
                    'response_code' => 1,
                    'response_message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ];

                Log::warning('Validation Failed', $response); // 🔹 Log response before sending

                return response()->json($response, 422);
            }

            $merchant = Merchant::find($data['merchant_id']);
            if (!$merchant) {
                $response = ['response_code' => 2, 'response_message' => 'Merchant not found', 'data' => []];

                Log::warning('Merchant Not Found', $response);
                return response()->json($response, 422);
            }

            $pos = Pos::first();
            if (!$pos) {
                $response = ['response_code' => 3, 'response_message' => 'POS not found', 'data' => []];

                Log::warning('POS Not Found', $response);
                return response()->json($response, 422);
            }

            $bank = Bank::find($pos->bank_id);
            if (!$bank) {
                $response = ['response_code' => 4, 'response_message' => 'Bank not found', 'data' => []];

                Log::warning('Bank Not Found', $response);
                return response()->json($response, 422);
            }

            $currency = Currency::where('code', $data['currency_code'])->first();
            if (!$currency) {
                $response = ['response_code' => 5, 'response_message' => 'Invalid currency code', 'data' => []];

                Log::warning('Currency Not Found', $response);
                return response()->json($response, 422);
            }

            // Check duplicate invoice for same merchant
            $transaction = Transaction::where('invoice_id', $data['invoice_id'])
                                    ->where('merchant_id', $data['merchant_id'])
                                    ->first();

            if ($transaction) {
                $response = ['response_code' => 6, 'response_message' => 'Invoice already exists', 'data' => []];

                Log::warning('Duplicate Invoice Attempt', $response);
                return response()->json($response, 422);
            }

            // 🔹 Prepare payload for bank API
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

            Log::info("Sending request to Bank API", $payload);

            $bankResponse = Http::asForm()->post($bank->api_url, $payload);
            $bankResult = $bankResponse->json();

            Log::info("Bank API Response", $bankResult);

            $responseCode = $bankResult['code'] ?? 422;
            $responseMessage = $bankResult['message'] ?? 'Unknown error';
            $bankOrderId = $bankResult['data']['bank_order_id'] ?? null;
            $paymentAt = $bankResult['data']['payment_at'] ?? now();

            // Determine transaction state
            $transactionState = ($responseCode == 100) ? 'Completed' : 'Failed';

            // Fee Calculations
            $fee = ($data['amount'] * $pos->commission_percentage / 100)
                + $pos->commission_fixed
                + $pos->bank_fee;

            $net = $data['amount'] - $fee;

            // Save transaction
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

            $result = Transaction::create($transactionData);

            if (!$result) {
                $responseCode = 422;
                $responseMessage = "Payment Failed";
            }

            // Final response
            $finalResponse = [
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
                        'commission_percentage' => $pos->commission_percentage,
                        'commission_fixed'      => $pos->commission_fixed,
                        'bank_fee'              => $pos->bank_fee,
                    ]
                ]
            ];

            // 🔹 Log final response
            Log::info('Final Payment Response', $finalResponse);

            return response()->json($finalResponse);

        } catch (\Exception $e) {

            // Log the exception
            Log::error('Payment Processing Error', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'response_code' => 500,
                'response_message' => 'Internal Server Error'
            ], 500);
        }
    }

}
