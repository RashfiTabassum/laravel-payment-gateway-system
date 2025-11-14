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

                                    <div>
                                        <a href="{{ route('merchants.edit', $merchant) }}" class="btn btn-sm btn-primary">
                                            Edit
                                        </a>
                                        <a href="{{ route('merchants.index') }}" class="btn btn-sm btn-secondary">
                                            Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body col-md-6">
                            <table class="table table-hover table-bordered table-striped">

                                {{-- ID --}}
                                <tr>
                                    <th style="width: 180px;">ID</th>
                                    <td>{{ $merchant->id }}</td>
                                </tr>

                                {{-- USER ID --}}
                                <tr>
                                    <th>User ID</th>
                                    <td>{{ $merchant->user_id }}</td>
                                </tr>

                                {{-- STORE ID --}}
                                <tr>
                                    <th>Store ID</th>
                                    <td>{{ $merchant->store_id }}</td>
                                </tr>

                                {{-- NAME --}}
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $merchant->name }}</td>
                                </tr>

                                {{-- EMAIL --}}
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $merchant->email }}</td>
                                </tr>

                                {{-- ADDRESS --}}
                                <tr>
                                    <th>Address</th>
                                    <td>
                                        @if($merchant->address)
                                            {!! nl2br(e($merchant->address)) !!}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>

                                {{-- STATUS --}}
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

                                {{-- CREATED / UPDATED --}}
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
