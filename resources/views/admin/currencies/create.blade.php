@extends('admin.layouts')
@section('title', 'Add Currency')


@section('content')

{{-- Global alert messages --}}
@include('admin.partials.alerts')

<div class="row">
    <div class="col-md-6">
        <h3>Add Currency</h3>
        <form action="{{ route('currencies.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
        </div>
    </div>
</div>
@endsection
