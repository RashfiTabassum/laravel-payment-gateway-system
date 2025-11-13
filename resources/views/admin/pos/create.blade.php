@extends('admin.layouts')

@section('title', 'Add POS')

@section('content')
<<<<<<< HEAD
<div class="app-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-12">
          <div class="card-header">
            <h3 class="card-title" style="font-size: 1.75rem;">Add POS</h3>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('pos.store') }}">
              @include('admin.pos._form', ['po' => null, 'submitLabel' => 'Create'])
            </form>
          </div>
=======
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
>>>>>>> 25011be24d8e76f22c8f7a6bf92bc7ee7d04700f
        </div>
    </div>
@endsection
