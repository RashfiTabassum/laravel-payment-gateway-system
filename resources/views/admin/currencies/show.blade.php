@extends('admin.layouts')

@section('title', 'View Currency')

@section('content')
    <div class="app-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <h3>View Currency</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body col-md-6">
                            <table class="table table-hover table-bordered .table-striped">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $currency->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $currency->name }}</td>
                                </tr>
                                <tr>
                                    <th>Symbol</th>
                                    <td>{{ $currency->symbol }}</td>
                                </tr>
                                <tr>
                                    <th>Code</th>
                                    <td>{{ $currency->code }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $currency->created_at?->format('Y-m-d') ?? '—' }}</td>
                                </tr>
                            </table>
                            <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
