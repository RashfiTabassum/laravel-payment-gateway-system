@extends('admin.layouts')
 
@section('title', 'Edit Currency')
 
@section('content')
 
{{-- Global alert messages --}}
@include('admin.partials.alerts')
<div class="row">
    <div class="col-md-6">
        <h3>Edit Currency</h3>
        <form action="{{ route('currencies.update', $currency) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $currency->name) }}">
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label>Symbol</label>
                <input type="text" name="symbol" class="form-control" value="{{ old('symbol', $currency->symbol) }}">
                @error('symbol')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="mb-3">
                <label>Code</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', $currency->code) }}">
                @error('code')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection



