@extends('merchant.layouts')

@section('title', 'Transaction Details')

@section('content')
<div class="app-content">
    <div class="container mt-3">

        @include('merchant.partials.alerts') <!-- show success/error messages -->

        <div class="card p-4 mb-3">
            <h4>Transaction #{{ $transaction->id }}</h4>
            <p><strong>Invoice ID:</strong> {{ $transaction->invoice_id }}</p>
            <p><strong>Order ID:</strong> {{ $transaction->order_id }}</p>
            <p><strong>Gross:</strong> ${{ number_format($transaction->gross, 2) }}</p>
            <p><strong>Net:</strong> ${{ number_format($transaction->net, 2) }}</p>
            <p><strong>Fee:</strong> ${{ number_format($transaction->fee, 2) }}</p>
            <p><strong>Refunded Amount:</strong> ${{ number_format($transaction->refunded_amount, 2) }}</p>
            <p><strong>Settlement Date:</strong> {{ $transaction->settlement_date ?? 'N/A' }}</p>
        </div>

        <!-- Update Transaction Status Form -->
        <div class="card p-4 mb-3">
            <h5>Update Transaction Status</h5>
            <form action="{{ route('merchant.transactions.updateStatus', $transaction->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="transaction_state" class="form-label">Transaction State</label>
                    <select name="transaction_state" id="transaction_state" class="form-control" required>
                        @foreach(['Completed', 'Pending', 'Refunded', 'Partial Refunded', 'Failed'] as $state)
                            <option value="{{ $state }}" {{ $transaction->transaction_state === $state ? 'selected' : '' }}>
                                {{ $state }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Status</button>
                <a href="{{ route('merchant.transactions.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>

    </div>
</div>
@endsection
