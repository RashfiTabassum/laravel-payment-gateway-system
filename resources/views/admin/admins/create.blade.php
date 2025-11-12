@extends('admin.layouts')
 
@section('title', 'Add Admin')
 
@section('content')
<div class="app-content">
  <div class="container-fluid">
    <div class="card mt-3">
      <div class="card-header">
        <h3 class="card-title mb-0">Add Admin</h3>
      </div>
 
      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
          </div>
        @endif
 
        <form method="POST" action="{{ route('admins.store') }}">
          @csrf
 
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
          </div>
 
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
          </div>
 
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
 
          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>
 
          {{-- If your users table has a "status" column --}}
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
              <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
          </div>
 
          <div class="d-flex gap-2">
            <button class="btn btn-primary">Save</button>
            <a href="{{ route('admins.index') }}" class="btn btn-outline-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
 