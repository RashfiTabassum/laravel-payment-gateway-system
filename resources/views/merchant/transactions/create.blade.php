@extends('merchant.layouts')

@section('title', 'New Transaction')

@section('content')
@include('merchant.partials.alerts')
    <div class="app-content">
        <div class="container mt-3">
            <h3>Create Transaction</h3>
            <form action="{{ route('merchant.transactions.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Invoice ID</label>
                    <input type="text" name="invoice_id" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Order ID</label>
                    <input type="text" name="order_id" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Transaction State</label>
                    <select name="transaction_state" class="form-control" required>
                        <option value="Completed">Completed</option>
                        <option value="Pending">Pending</option>
                        <option value="Refunded">Refunded</option>
                        <option value="Partial Refunded">Partial Refunded</option>
                        <option value="Failed">Failed</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Gross Amount</label>
                    <input type="number" step="0.01" name="gross" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Net Amount</label>
                    <input type="number" step="0.01" name="net" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Fee</label>
                    <input type="number" step="0.01" name="fee" class="form-control">
                </div>

                <div class="mb-3">
                    <label>POS</label>
                    <select name="pos_id" class="form-control" required>
                        @foreach($posList as $pos)
                            <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Currency</label>
                    <select name="currency_id" class="form-control" required>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Settlement Date</label>
                    <input type="date" name="settlement_date" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Save Transaction</button>
            </form>
        </div>
    </div>
@endsection
