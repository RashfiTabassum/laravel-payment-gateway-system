@extends('merchant.layouts')

@section('title', 'Transaction Details')

@section('content')
    <div class="app-content">
        <div class="container mt-3">
            <div class="card p-4">
                <h4>Transaction #{{ $transaction->id }}</h4>
                <p><strong>Invoice ID:</strong> {{ $transaction->invoice_id }}</p>
                <p><strong>Order ID:</strong> {{ $transaction->order_id }}</p>
                <p><strong>State:</strong> {{ $transaction->transaction_state }}</p>
                <p><strong>Gross:</strong> ${{ number_format($transaction->gross, 2) }}</p>
                <p><strong>Net:</strong> ${{ number_format($transaction->net, 2) }}</p>
                <p><strong>Fee:</strong> ${{ number_format($transaction->fee, 2) }}</p>
                <p><strong>Refunded Amount:</strong> ${{ number_format($transaction->refunded_amount, 2) }}</p>
                <p><strong>Settlement Date:</strong> {{ $transaction->settlement_date ?? 'N/A' }}</p>
                <a href="{{ route('merchant.transactions.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
