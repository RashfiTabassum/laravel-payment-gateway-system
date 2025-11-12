@extends('admin.layouts')
@section('title', 'View Merchant')
@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h3>Merchant Details</h3>
            <a href="{{ route('merchants.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $merchant->id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $merchant->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $merchant->email }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if((int)($merchant->status ?? 1) === 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $merchant->created_at?->format('Y-m-d H:i:s') ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $merchant->updated_at?->format('Y-m-d H:i:s') ?? '—' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>  
@endsection