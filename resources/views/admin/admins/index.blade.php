@extends('admin.layouts')

@section('title', 'Admins')

@section('content')
<div class="app-content">
  <div class="container-fluid">
    @if (session('ok'))
      <div class="alert alert-success mt-3">{{ session('ok') }}</div>
    @endif
    @if (session('err'))
      <div class="alert alert-danger mt-3">{{ session('err') }}</div>
    @endif

    <div class="card mt-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Admins</h3>
        <a href="{{ route('admins.create') }}" class="btn btn-primary btn-sm">Add Admin</a>
      </div>

      <div class="card-body table-responsive">
        <table class="table table-hover table-bordered">
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
                @if((int)($a->status ?? 1) === 1)
                  <span class="badge bg-success">Active</span>
                @else
                  <span class="badge bg-danger">Inactive</span>
                @endif
              </td>
              <td>{{ $a->created_at?->format('Y-m-d') ?? '—' }}</td>
              <td>
                <a href="{{ route('admins.edit', $a) }}" class="btn btn-sm btn-secondary">Edit</a>
                <form action="{{ route('admins.destroy', $a) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Delete this admin?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center text-muted">No admins found.</td></tr>
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
@endsection
