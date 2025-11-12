@extends('admin.layouts')

@section('title', 'Merchants')

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
                                    <h3>Merchants</h3>
                                    <a href="{{ route('merchants.create') }}" class="btn btn-primary">Add Merchant</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-hover table-bordered .table-striped">
                                <thead>
                                <tr>
                                    <th style="width:70px">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th style="width:110px">Status</th>
                                    <th style="width:180px">Created</th>
                                    <th style="width:180px">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($merchants as $a)
                                    <tr>
                                        <td>{{ $a->id }}</td>
                                        <td>{{ $a->name }}</td>
                                        <td>{{ $a->email }}</td>
                                        <td>
                                            @if((int)($a->status ?? 1) === 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $a->created_at?->format('Y-m-d') ?? '—' }}</td>
                                        <td>
                                            <a href="{{ route('merchants.show', $a) }}" class="btn btn-sm btn-primary">View</a>
                                            <a href="{{ route('merchants.edit', $a) }}"
                                               class="btn btn-sm btn-secondary">Edit</a>
                                            <form action="{{ route('merchants.destroy', $a->id) }}" method="POST"
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Delete this bank?')"
                                                        class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No merchants found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            {{ $merchants->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
