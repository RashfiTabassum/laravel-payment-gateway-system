@extends('admin.layouts')

@section('title', 'View Currency')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h3>Currency Details</h3>
            <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
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
                    <td>{{ $currency->created_at?->format('Y-m-d H:i:s') ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $currency->updated_at?->format('Y-m-d H:i:s') ?? '—' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
