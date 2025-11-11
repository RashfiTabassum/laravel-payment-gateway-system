@extends('admin.layouts')

@section('title', 'Edit Currency')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h3>Edit Currency</h3>
            <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('currencies.update', $currency) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $currency->name) }}" required>
                </div>
                <div class="mb-3">
                    <label>Symbol</label>
                    <input type="text" name="symbol" class="form-control" value="{{ old('symbol', $currency->symbol) }}" required>
                </div>
                <div class="mb-3">
                    <label>Code</label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $currency->code) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Currency</button>
            </form>
        </div>
    </div>
</div>
@endsection
