@extends('merchant.layouts')

@section('title', 'Transactions')

@section('content')
    <div class="app-content">
        <div class="container mt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>My Transactions</h3>
            </div>

            @include('merchant.partials.alerts')

            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice ID</th>
                        <th>Order ID</th>
                        <th>State</th>
                        <th>Gross</th>
                        <th>Net</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $txn)
                        <tr>
                            <td>{{ $txn->id }}</td>
                            <td>{{ $txn->invoice_id }}</td>
                            <td>{{ $txn->order_id }}</td>
                            <td><span class="badge 
                                @if($txn->transaction_state == 'Completed') bg-success 
                                @elseif($txn->transaction_state == 'Failed') bg-danger 
                                @else bg-warning @endif">
                                {{ $txn->transaction_state }}
                            </span></td>
                            <td>${{ number_format($txn->gross, 2) }}</td>
                            <td>${{ number_format($txn->net, 2) }}</td>
                            <td>{{ $txn->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('merchant.transactions.show', $txn->id) }}" class="btn btn-sm btn-secondary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">No transactions found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
