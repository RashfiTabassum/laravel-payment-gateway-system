@extends('admin.layouts')

@section('title', 'Currencies')

@section('content')

    @include('admin.partials.alerts')

    <div class="app-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <h3>Currencies</h3>
                                    <a href="{{ route('currencies.create') }}" class="btn btn-primary">Add Currency</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-hover table-bordered .table-striped">
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
                                            <a href="{{ route('currencies.show', $currency) }}"
                                               class="btn btn-sm btn-primary">View</a>
                                            <a href="{{ route('currencies.edit', $currency) }}"
                                               class="btn btn-sm btn-secondary">Edit</a>
                                            <form action="{{ route('currencies.destroy', $currency) }}" method="POST"
                                                  class="d-inline-block" onsubmit="return confirm('Are you sure?');">
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
                </div>
            </div>
        </div>
    </div>
@endsection
