@extends('merchant.layouts')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @php $user = auth()->user(); @endphp

            <h2 class="mb-2">Merchant Dashboard</h2>
            <p class="text-muted">Welcome, <strong>{{ $user->name }}</strong>.</p>
        </div>
    </div>
@endsection
