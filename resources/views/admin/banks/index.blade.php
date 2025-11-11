@extends('admin.layouts')

@section('title', 'Banks')

@section('content')
  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-12">
            <div class="card-header">
              <h3 class="card-title">Banks</h3>
            </div>

            <div class="card-body">
              @include('admin.banks._table', ['banks' => $banks])
            </div>

            <div class="card-footer">
              {{ $banks->withQueryString()->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
