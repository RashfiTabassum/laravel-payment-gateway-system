@extends('admin.layouts')

@section('title', 'Banks')

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
                                    <h3>Banks</h3>
                                    <a href="{{ route('admin.banks.create') }}" class="btn btn-primary">Add Bank</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-hover table-bordered .table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Issuer</th>
                                    <th>Username</th>
                                    <th>Branch</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($banks as $bank)
                                    <tr>
                                        <td>{{ $bank->id }}</td>
                                        <td>{{ $bank->name }}</td>
                                        <td>{{ $bank->issuer_name }}</td>
                                        <td>{{ $bank->user_name }}</td>
                                        <td>{{ $bank->branch }}</td>
                                        <td>{{ $bank->code }}</td>
                                        <td>
                                            @if($bank->status == 'Active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $bank->created_at->format('Y-m-d') }}</td>

                                        <td>
                                            <a href="{{ route('admin.banks.show', $bank->id) }}"
                                               class="btn btn-primary btn-sm">View</a>
                                            <a href="{{ route('admin.banks.edit', $bank->id) }}"
                                               class="btn btn-secondary btn-sm">Edit</a>

                                            <form action="{{ route('admin.banks.destroy', $bank->id) }}" method="POST"
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
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Global alert messages --}}
@include('admin.partials.alerts')

<div class="card">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Issuer</th>
                    <th>API URL</th>
                    <th>Username</th>
                    <th>Branch</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th style="width: 200px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banks as $bank)
                    <tr>
                        <td>{{ $bank->id }}</td>
                        <td>{{ $bank->name }}</td>
                        <td>{{ $bank->issuer_name }}</td>
                        <td><a href="{{ $bank->api_url }}" target="_blank">{{ $bank->api_url }}</a></td>
                        <td>{{ $bank->user_name }}</td>
                        <td>{{ $bank->branch }}</td>
                        <td>{{ $bank->code }}</td>
                        <td>
                            @if($bank->status == 'Active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $bank->created_at?->format('Y-m-d') ?? '—' }}</td>
                        <td>
                            <a href="{{ route('admin.banks.show', $bank) }}" class="btn btn-sm btn-primary">View</a>
                            <a href="{{ route('admin.banks.edit', $bank) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('admin.banks.destroy', $bank) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">No banks found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
    {{ $banks->links('pagination::bootstrap-5') }}
</div>

</div>
@endsection
