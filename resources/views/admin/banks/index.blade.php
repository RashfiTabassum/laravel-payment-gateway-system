@extends('admin.layouts')

@section('title', 'Banks')

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Banks</h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-hover table-bordered .table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 60px">#</th>
                                    <th>Name</th>
                                    <th>Issuer</th>
                                    <th>API URL</th>
                                    <th>Username</th>
                                    <th>Branch</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($banks as $bank)
                                    <tr>
                                        <td>{{ $bank->id }}</td>
                                        <td>{{ $bank->name }}</td>
                                        <td>{{ $bank->issuer_name }}</td>
                                        <td>
                                            @if($bank->api_url)
                                                <a href="{{ $bank->api_url }}" target="_blank">
                                                    {{ \Illuminate\Support\Str::limit($bank->api_url, 30) }}
                                                </a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>{{ $bank->user_name }}</td>
                                        <td>{{ $bank->branch ?? '—' }}</td>
                                        <td>{{ $bank->code ?? '—' }}</td>
                                        <td>
                                            @if((int) $bank->status === 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $bank->created_at?->format('Y-m-d') ?? '—' }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary">View</a>
                                            <a href="#" class="btn btn-sm btn-secondary">Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
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
                            {{ $banks->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
