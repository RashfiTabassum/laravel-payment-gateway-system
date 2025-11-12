@extends('admin.layouts')

@section('title', 'Currencies')

@section('content')
<div class="row mb-3">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h3>Currencies</h3>
        <a href="{{ route('currencies.create') }}" class="btn btn-primary">Add Currency</a>
    </div>
</div>

<!-- @if(session('message'))
    <div class="container mt-3">
        <div class="alert alert-{{ session('alert-type', 'info') }} alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif -->

{{-- Global alert messages --}}

@include('admin.partials.alerts')

<div class="card">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Symbol</th>
                    <th>Code</th>
                    <th>Created</th>
                    <th style="width: 200px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($currencies as $currency)
                    <tr>
                        <td>{{ $currency->id }}</td>
                        <td>{{ $currency->name }}</td>
                        <td>{{ $currency->symbol }}</td>
                        <td>{{ $currency->code }}</td>
                        <td>{{ $currency->created_at?->format('Y-m-d') ?? '—' }}</td>
                        <td>
                            <a href="{{ route('currencies.show', $currency) }}" class="btn btn-sm btn-primary">View</a>
                            <a href="{{ route('currencies.edit', $currency) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('currencies.destroy', $currency) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No currencies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $currencies->links() }}
    </div>
</div>
@endsection
