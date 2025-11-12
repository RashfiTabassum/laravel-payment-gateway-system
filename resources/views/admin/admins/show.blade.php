@extends('admin.layouts')
@section('title', 'View Admin')
@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h3>Admin Details</h3>
            <a href="{{ route('admins.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
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
                        @if((int)($admin->status ?? 1) === 1)
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
@endsection