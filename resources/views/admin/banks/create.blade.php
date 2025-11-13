@extends('admin.layouts')

@section('title', 'Create Bank')


@section('content')
@include('admin.partials.alerts')

    <div class="app-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <h3>Add Bank</h3>
                                </div>
                            </div>
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
                </div>
            </div>
        </div>
    </div>
@endsection
