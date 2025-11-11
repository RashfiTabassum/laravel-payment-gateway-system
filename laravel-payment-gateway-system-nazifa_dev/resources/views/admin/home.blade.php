@extends('admin.layouts')

@section('title', 'Dashboard')

@section('content')
  @php $user = auth()->user(); @endphp

  <h2 class="mb-2">Admin Dashboard</h2>
  <p class="text-muted">Welcome, <strong>{{ $user->name }}</strong>.</p>

  {{-- If you want to show a banks preview here, include the table PARTIAL with data you pass from controller --}}
  {{-- @include('admin.banks._table', ['banks' => $banks]) --}}
@endsection
