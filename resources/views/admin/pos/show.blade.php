@extends('admin.layouts')
 
@section('title', 'View POS')
 
@section('content')
    <div class="app-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <h3>View POS</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body col-md-8">
                            <table class="table table-hover table-bordered .table-striped">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $pos->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $pos->name }}</td>
                                </tr>
                                <tr>
                                    <th>Bank</th>
                                    <td>{{ $pos->bank?->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Currency</th>
                                    <td>
                                        {{ $pos->currency?->code ?? '—' }}
                                        @if($pos->currency?->name)
                                            ({{ $pos->currency->name }})
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Commission %</th>
                                    <td>{{ number_format($pos->commission_percentage, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Commission (Fixed)</th>
                                    <td>{{ number_format($pos->commission_fixed, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Bank Fee</th>
                                    <td>{{ number_format($pos->bank_fee, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Settlement Day</th>
                                    <td>{{ $pos->settlement_day }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($pos->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $pos->created_at?->format('Y-m-d') ?? '—' }}</td>
                                </tr>
                            </table>
 
                            <a href="{{ route('pos.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection