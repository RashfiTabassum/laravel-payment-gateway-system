<table class="table table-hover table-bordered .table-striped">
  <thead>
    <tr>
      <th style="width:60px">#</th>
      <th>Name</th>
      <th>Bank</th>
      <th>Currency</th>
      <th>Commission %</th>
      <th>Commission (Fixed)</th>
      <th>Bank Fee</th>
      <th>Settlement Day</th>
      <th>Status</th>
      <th>Created</th>
      <th style="width:160px">Actions</th>
    </tr>
  </thead>
  <tbody>
  @forelse ($poses as $po)
    <tr>
      <td>{{ $po->id }}</td>
      <td>{{ $po->name }}</td>
      <td>{{ $po->bank?->name ?? '—' }}</td>
      <td>{{ $po->currency?->code ?? '—' }}</td>
      <td>{{ number_format($po->commission_percentage, 2) }}</td>
      <td>{{ number_format($po->commission_fixed, 2) }}</td>
      <td>{{ number_format($po->bank_fee, 2) }}</td>
      <td>{{ $po->settlement_day }}</td>
      <td>
        @if((int)$po->status === 1)
          <span class="badge bg-success">Active</span>
        @else
          <span class="badge bg-danger">Inactive</span>
        @endif
      </td>
      <td>{{ $po->created_at?->format('Y-m-d') ?? '—' }}</td>
      <td>
        <a href="{{ route('pos.edit', $po) }}" class="btn btn-sm btn-secondary">Edit</a>
        <form action="{{ route('pos.destroy', $po) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Delete this POS?');">
          @csrf
          @method('DELETE')
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </td>
    </tr>
  @empty
    <tr>
      <td colspan="11" class="text-center text-muted">No POS found.</td>
    </tr>
  @endforelse
  </tbody>
</table>
