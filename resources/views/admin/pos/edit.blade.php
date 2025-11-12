@extends('admin.layouts')

@section('title', 'Edit POS')

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
                                    <h3>Edit Pos</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('pos.update', $po) }}">
                                @method('PUT')
                                @include('admin.pos._form', ['po' => $po, 'submitLabel' => 'Update'])
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
