@extends('admin.layouts')

@section('title', 'Banks')

@section('content')
<div class="row mb-3">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h3>Banks</h3>
        <a href="{{ route('admin.banks.create') }}" class="btn btn-primary">Add Bank</a>
    </div>
</div>

{{-- Global alert messages --}}
@include('admin.partials.alerts')

<div class="card">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Issuer</th>
                    <th>API URL</th>
                    <th>Username</th>
                    <th>Branch</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th style="width: 200px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banks as $bank)
                    <tr>
                        <td>{{ $bank->id }}</td>
                        <td>{{ $bank->name }}</td>
                        <td>{{ $bank->issuer_name }}</td>
                        <td><a href="{{ $bank->api_url }}" target="_blank">{{ $bank->api_url }}</a></td>
                        <td>{{ $bank->user_name }}</td>
                        <td>{{ $bank->branch }}</td>
                        <td>{{ $bank->code }}</td>
                        <td>
                            @if($bank->status == 'Active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $bank->created_at?->format('Y-m-d') ?? '—' }}</td>
                        <td>
                            <a href="{{ route('admin.banks.show', $bank) }}" class="btn btn-sm btn-primary">View</a>
                            <a href="{{ route('admin.banks.edit', $bank) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('admin.banks.destroy', $bank) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">No banks found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
    {{ $banks->links('pagination::bootstrap-5') }}
</div>

</div>
@endsection
