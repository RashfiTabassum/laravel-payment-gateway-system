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
                                    <h3>Currencies</h3>
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
@endsection
