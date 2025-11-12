@extends('admin.layouts')

@section('title', 'View Bank')

@section('content')
    <div class="app-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <h3>View Bank</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body col-md-6">
                            <p><strong>Issuer:</strong> {{ $bank->issuer_name }}</p>
                            <p><strong>API URL:</strong> <a href="{{ $bank->api_url }}"
                                                            target="_blank">{{ $bank->api_url }}</a></p>
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
                </div>
            </div>
        </div>
    </div>
@endsection
