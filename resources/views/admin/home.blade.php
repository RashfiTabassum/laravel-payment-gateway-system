@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')

  @php
    $user = auth()->user();
  @endphp

  
<div class="card" style="margin-bottom:18px;">
    <h2 style="margin:0 0 6px 0;">Admin Dashboard</h2>
    <p style="color:#6b7280;margin:0;">Welcome, <strong>{{ $user->name }}</strong>.</p>
</div>
        

@endsection

