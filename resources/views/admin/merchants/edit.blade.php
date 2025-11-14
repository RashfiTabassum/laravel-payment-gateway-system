@extends('admin.layouts')

@section('title', 'Edit Merchant')

@section('content')
    @include('admin.partials.alerts')

    <div class="app-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="card mt-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3>Edit Merchant</h3>
                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('merchants.update', $merchant->id) }}">
                                @csrf
                                @method('PUT')

                                {{-- USER ID --}}
                                <div class="mb-3">
                                    <label class="form-label">User ID</label>
                                    <input type="number" name="user_id"
                                           value="{{ old('user_id', $merchant->user_id) }}"
                                           class="form-control" required>
                                </div>

                                {{-- STORE ID --}}
                                <div class="mb-3">
                                    <label class="form-label">Store ID</label>
                                    <input type="text" name="store_id"
                                           value="{{ old('store_id', $merchant->store_id) }}"
                                           class="form-control" required>
                                </div>

                                {{-- NAME --}}
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name"
                                           value="{{ old('name', $merchant->name) }}"
                                           class="form-control" required>
                                </div>

                                {{-- EMAIL --}}
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email"
                                           value="{{ old('email', $merchant->email) }}"
                                           class="form-control" required>
                                </div>

                                {{-- ADDRESS --}}
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control"
                                              rows="3">{{ old('address', $merchant->address) }}</textarea>
                                </div>

                                {{-- NEW PASSWORD --}}
                                <div class="mb-3">
                                    <label class="form-label">New Password (optional)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                {{-- CONFIRM PASSWORD --}}
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>

                                {{-- STATUS --}}
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ $merchant->status == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ $merchant->status == 0 ? 'selected' : '' }}>
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
