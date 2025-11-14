@extends('admin.layouts')

@section('title', 'View Admin')

@section('content')
    <div class="app-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3>View Admin</h3>
                            <a href="{{ route('admins.index') }}" class="btn btn-sm btn-secondary">Back</a>
                        </div>

                        <div class="card-body col-md-6">
                            <table class="table table-hover table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $admin->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $admin->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $admin->email }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($admin->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $admin->created_at?->format('Y-m-d H:i:s') ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $admin->updated_at?->format('Y-m-d H:i:s') ?? '—' }}</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
