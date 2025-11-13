@extends('admin.layouts')
@section('title', 'View Merchant')
@section('content')
    <div class="app-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <h3>View Merchant</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body col-md-6">
                            <table class="table table-hover table-bordered .table-striped">
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
            </div>
        </div>
    </div>
@endsection
