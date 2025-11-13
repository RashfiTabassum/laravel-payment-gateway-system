<div class="row">
    <div class="col-md-6">
        <label>Name</label>
        <input name="name" class="form-control" value="{{ old('name', $bank->name ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label>Issuer Name</label>
        <input name="issuer_name" class="form-control" value="{{ old('issuer_name', $bank->issuer_name ?? '') }}" required>
    </div>

    <div class="col-md-12">
        <label>API URL</label>
        <input name="api_url" class="form-control" value="{{ old('api_url', $bank->api_url ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label>Username</label>
        <input name="user_name" class="form-control" value="{{ old('user_name', $bank->user_name ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label>Password</label>
        <input name="user_password" class="form-control" value="{{ old('user_password', $bank->user_password ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label>Code</label>
        <input name="code" class="form-control" value="{{ old('code', $bank->code ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label>Branch</label>
        <input name="branch" class="form-control" value="{{ old('branch', $bank->branch ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label>Status</label>
        <select name="status" class="form-control" required>
             <option value="1" {{ old('status', $bank->status ?? '') == 1 ? 'selected' : '' }}>Active</option>
             <option value="0" {{ old('status', $bank->status ?? '') == 0 ? 'selected' : '' }}>Inactive</option>
        </select>


    </div>
</div>
