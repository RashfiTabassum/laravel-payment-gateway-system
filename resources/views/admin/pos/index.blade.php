@extends('admin.layouts')
 
@section('title', 'POS List')
 
@section('content')
    <div class="app-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
 
                    {{-- Flash message --}}
                    @if(session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                    @endif
 
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-md-6 d-flex align-items-center">
                                    <h3 class="mb-0">Pos</h3>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a href="{{ route('pos.create') }}" class="btn btn-primary">
                                        Add Pos
                                    </a>
                                </div>
                            </div>
                        </div>
 
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Bank</th>
                                            <th>Currency</th>
                                            <th>Commission %</th>
                                            <th>Commission (Fixed)</th>
                                            <th>Bank Fee</th>
                                            <th>Settlement Day</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th style="width: 200px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($poses as $index => $pos)
                                            <tr>
                                                <td>{{ $poses->firstItem() + $index }}</td>
                                                <td>{{ $pos->name }}</td>
                                                <td>{{ $pos->bank?->name }}</td>
                                                <td>{{ $pos->currency?->code }}</td>
                                                <td>{{ number_format($pos->commission_percentage, 2) }}</td>
                                                <td>{{ number_format($pos->commission_fixed, 2) }}</td>
                                                <td>{{ number_format($pos->bank_fee, 2) }}</td>
                                                <td>{{ $pos->settlement_day }}</td>
                                                <td>
                                                    @if($pos->status)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $pos->created_at?->format('Y-m-d') ?? '—' }}</td>
                                                <td>
                                                    <a href="{{ route('pos.show', $pos) }}"
                                                       class="btn btn-primary btn-sm">
                                                        View
                                                    </a>
 
                                                    <a href="{{ route('pos.edit', $pos) }}"
                                                       class="btn btn-secondary btn-sm">
                                                        Edit
                                                    </a>
 
                                                    <form action="{{ route('pos.destroy', $pos) }}"
                                                          method="POST"
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure you want to delete this POS?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center">
                                                    No POS records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
 
                            {{-- Pagination --}}
                            <div class="mt-3">
                                {{ $poses->links() }}
                            </div>
                        </div>
                    </div>
 
                </div>
            </div>
        </div>
    </div>
@endsection