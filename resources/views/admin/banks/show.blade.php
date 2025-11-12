@extends('admin.layouts')

@section('title', 'View Bank')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $bank->name }}</h3>
    </div>

    <div class="card-body">
        <p><strong>Issuer:</strong> {{ $bank->issuer_name }}</p>
        <p><strong>API URL:</strong> <a href="{{ $bank->api_url }}" target="_blank">{{ $bank->api_url }}</a></p>
        <p><strong>Username:</strong> {{ $bank->user_name }}</p>
        <p><strong>Branch:</strong> {{ $bank->branch }}</p>
        <p><strong>Code:</strong> {{ $bank->code }}</p>
        <p><strong>Status:</strong> 
            @if($bank->status == 'Active')
                <span class="badge bg-success">Active</span>
            @else
                <span class="badge bg-danger">Inactive</span>
            @endif
        </p>

        <div class="mt-3">
            <a href="{{ route('admin.banks.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
