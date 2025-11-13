@extends('merchant.layouts')

@section('title', 'Profile')

@section('content')
    <div class="app-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mt-3 p-3">
                        <h3 class="mb-3">My Profile</h3>

                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Address:</strong> {{ $merchant->address ?? 'N/A' }}</p>
                        <p><strong>User Type:</strong> Merchant</p>
                        <p><strong>Status:</strong>
                            @if($user->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </p>

                        <div class="mt-3">
                            <a href="{{ route('merchant.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
