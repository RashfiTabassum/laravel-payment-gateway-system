@extends('admin.layouts')

@section('title', 'Edit Merchant')

@section('content')
    {{-- Global alert messages --}}
    @include('admin.partials.alerts')

    <div class="app-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <h3>Edit Merchant</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <form method="POST" action="{{ route('merchants.update', $merchant) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ old('name', $merchant->name) }}"
                                           class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $merchant->email) }}"
                                           class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password (optional)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option
                                            value="1" {{ old('status', (int)($merchant->status ?? 1)) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option
                                            value="0" {{ old('status', (int)($merchant->status ?? 1)) == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('merchants.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
