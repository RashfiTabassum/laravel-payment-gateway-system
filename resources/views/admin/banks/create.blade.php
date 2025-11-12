@extends('admin.layouts')

@section('title', 'Create Bank')


@section('content')


@include('admin.partials.alerts')
<div class="card">

    <div class="card-header">
        <h3 class="card-title">Add Bank</h3>
    </div>

    <div class="card-body">

  

        <form method="POST" action="{{ route('admin.banks.store') }}">
            @csrf

            @include('admin.banks.form')

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('admin.banks.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
