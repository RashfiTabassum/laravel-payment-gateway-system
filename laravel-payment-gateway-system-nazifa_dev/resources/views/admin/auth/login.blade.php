@extends('admin.auth-shell')


@section('title', 'Login')

@section('content')
<h1>Login</h1>

@if ($errors->any())
  <div class="alert">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
  @csrf

  <label>Email</label>
  <input type="email" name="email" value="{{ old('email') }}" required autofocus>

  <label>Password</label>
  <input type="password" name="password" required>

  <button type="submit" class="btn">Login</button>
</form>

<p class="muted">
  Don't have an account?
  <a href="{{ route('register') }}">Register</a>
</p>
@endsection
