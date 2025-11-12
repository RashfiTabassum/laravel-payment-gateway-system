@extends('admin.layouts')

@section('title', 'Edit POS')

@section('content')
<div class="app-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-12">
          <div class="card-header">
            <h3 class="card-title">Edit POS</h3>
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
