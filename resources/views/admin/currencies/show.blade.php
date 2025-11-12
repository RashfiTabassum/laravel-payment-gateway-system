@extends('admin.layouts')

@section('title', 'View Currency')

@section('content')
<div class="row">
    <div class="col-md-6">
        <h3>Currency Details</h3>
        <table class="table table-bordered">
            <tr><th>ID</th><td>{{ $currency->id }}</td></tr>
            <tr><th>Name</th><td>{{ $currency->name }}</td></tr>
            <tr><th>Symbol</th><td>{{ $currency->symbol }}</td></tr>
            <tr><th>Code</th><td>{{ $currency->code }}</td></tr>
            <tr><th>Created At</th><td>{{ $currency->created_at?->format('Y-m-d') ?? '—' }}</td></tr>
        </table>
        <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
