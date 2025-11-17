<div class="row">
    <div class="col-md-6">
        <label>User</label>
        <select name="user_id" class="form-control" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $merchant->user_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label>Store ID</label>
        <input type="number" name="store_id" class="form-control" value="{{ old('store_id', $merchant->store_id ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $merchant->name ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $merchant->email ?? '') }}" required>
    </div>

    <div class="col-md-12">
        <label>Address</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $merchant->address ?? '') }}">
    </div>

    <div class="col-md-6">
        <label>Status</label>
        <select name="status" class="form-control" required>
            @foreach(\App\Models\Merchant::statusOptions() as $value => $label)
                <option value="{{ $value }}" {{ old('status', $merchant->status ?? '') == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>
</div>
