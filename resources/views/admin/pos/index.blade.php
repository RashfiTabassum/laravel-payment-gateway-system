@extends('admin.layouts')

@section('title', 'POS')

@section('content')
<<<<<<< HEAD
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
                                    <h3>Pos</h3>
                                    <a href="{{ route('pos.create') }}" class="btn btn-primary">Add Pos</a>
                                </div>
                            </div>
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
>>>>>>> 25011be24d8e76f22c8f7a6bf92bc7ee7d04700f
@endsection
