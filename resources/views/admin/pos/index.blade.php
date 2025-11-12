@extends('admin.layouts')

@section('title', 'POS')

@section('content')
<div class="row mb-3">
  <div class="col-md-12 d-flex justify-content-between align-items-center">
    <h3>POS</h3>
    <a href="{{ route('pos.create') }}" class="btn btn-primary">Add POS</a>
  </div>
</div>

@include('admin.partials.alerts')

<div class="card">
  <div class="card-body">
    {{-- Reuse your existing POS table partial --}}
    @include('admin.pos._table', ['poses' => $poses])
  </div>

  <div class="card-footer">
    {{ $poses->withQueryString()->links() }}
  </div>
</div>
@endsection
