@extends('admin.layouts')

@section('title', 'POS')

@section('content')
<div class="app-content">
  <div class="container-fluid">

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
      <div class="col-md-12">
        <div class="card mb-12">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">POS</h3>
            <a href="{{ route('pos.create') }}" class="btn btn-sm btn-primary">Add POS</a>
          </div>

          <div class="card-body">
            @include('admin.pos._table', ['poses' => $poses])
          </div>

          <div class="card-footer">
            {{ $poses->withQueryString()->links() }}
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
