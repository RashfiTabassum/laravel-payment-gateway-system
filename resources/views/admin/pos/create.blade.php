@extends('admin.layouts')

@section('title', 'Add POS')

@section('content')
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
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
