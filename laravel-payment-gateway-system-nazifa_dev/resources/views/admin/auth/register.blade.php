@extends('admin.auth-shell')


@section('title', 'Register')

@section('content')
<h1>Create Account</h1>

@if ($errors->any())
  <div class="alert">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('register') }}">
  @csrf

  <label>Full Name</label>
  <input type="text" name="name" value="{{ old('name') }}" required>

  <label>Email</label>
  <input type="email" name="email" value="{{ old('email') }}" required>

  <label>User Type</label>
  <select name="user_type" required>
    <option value="">Select type</option>
    <option value="1" {{ old('user_type') == 1 ? 'selected' : '' }}>Admin</option>
    <option value="2" {{ old('user_type') == 2 ? 'selected' : '' }}>Merchant</option>
  </select>

  <label>Password</label>
  <input type="password" name="password" required>

  <label>Confirm Password</label>
  <input type="password" name="password_confirmation" required>

  <button type="submit" class="btn">Register</button>
</form>

<p class="muted">
  Already have an account?
  <a href="{{ route('login') }}">Login</a>
</p>
@endsection
