@extends('admin.layouts')
 
@section('title', 'Add POS')
 
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
                                    <h3>Add Pos</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('pos.store') }}">
                                @include('admin.pos._form', ['po' => null, 'submitLabel' => 'Create'])
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection