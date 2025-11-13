@extends('admin.layouts')
 
@section('title', 'Add Currency')
 
 
@section('content')
 
    {{-- Global alert messages --}}
    @include('admin.partials.alerts')
 
    <div class="app-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <h3>Add Currency</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body col-md-6">
                            <form action="{{ route('currencies.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    <!-- @error('name')<small class="text-danger">{{ $message }}</small>@enderror -->
                                </div>
                                <div class="mb-3">
                                    <label>Symbol</label>
                                    <input type="text" name="symbol" class="form-control" value="{{ old('symbol') }}">
                                    <!-- @error('symbol')<small class="text-danger">{{ $message }}</small>@enderror -->
                                </div>
                                <div class="mb-3">
                                    <label>Code</label>
                                    <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                                    <!-- @error('code')<small class="text-danger">{{ $message }}</small>@enderror -->
                                </div>
                                <button class="btn btn-primary">Save</button>
                                <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection