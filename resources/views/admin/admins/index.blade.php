@extends('admin.layouts')

@section('title', 'Admins')

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
                                    <h3>Users</h3>
                                    <a href="{{ route('admins.create') }}" class="btn btn-primary">Add User</a>
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
                                @forelse ($admins as $a)
                                    <tr>
                                        <td>{{ $a->id }}</td>
                                        <td>{{ $a->name }}</td>
                                        <td>{{ $a->email }}</td>
                                       <td>
    @if($a->status) 
        <span class="badge bg-success">Active</span>
    @else
        <span class="badge bg-danger">Inactive</span>
    @endif
</td>

                                        <td>{{ $a->created_at?->format('Y-m-d') ?? '—' }}</td>
                                        <td>
<<<<<<< HEAD
                                            
=======
                                           <a href="{{ route('admins.show', $a) }}"class="btn btn-sm btn-primary">View</a>

>>>>>>> 1e3ddcb053295ce5e649656f66bc3b0e52722bb7
                                            <a href="{{ route('admins.edit', $a) }}"
                                               class="btn btn-sm btn-secondary">Edit</a>

                                            <form action="{{ route('admins.destroy', $a) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Delete this admin?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No admins found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            {{ $admins->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
