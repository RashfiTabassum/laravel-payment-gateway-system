@csrf
<div class="row g-3">

  {{-- POS Name --}}
  <div class="col-md-6">
    <label class="form-label">POS Name *</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $po->name ?? '') }}" required>
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- Status --}}
  <div class="col-md-6">
    <label class="form-label">Status *</label>
    <select name="status" class="form-select" required>
      <option value="1" {{ old('status', $po->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
      <option value="0" {{ old('status', $po->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- Bank --}}
  <div class="col-md-6">
    <label class="form-label">Bank *</label>
    <select name="bank_id" class="form-select" required>
      <option value="">-- Select Bank --</option>
      @foreach($banks as $bank)
        <option value="{{ $bank->id }}"
          {{ (int) old('bank_id', $po->bank_id ?? 0) === $bank->id ? 'selected' : '' }}>
          {{ $bank->name }}
        </option>
      @endforeach
    </select>
    @error('bank_id') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- Currency --}}
  <div class="col-md-6">
    <label class="form-label">Currency *</label>
    <select name="currency_id" class="form-select" required>
      <option value="">-- Select Currency --</option>
      @foreach($currencies as $currency)
        <option value="{{ $currency->id }}"
          {{ (int) old('currency_id', $po->currency_id ?? 0) === $currency->id ? 'selected' : '' }}>
          {{ $currency->code }} — {{ $currency->name }}
        </option>
      @endforeach
    </select>
    @error('currency_id') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- Commission % --}}
  <div class="col-md-4">
    <label class="form-label">Commission (%) *</label>
    <input type="number" name="commission_percentage" step="0.01" min="0" max="100"
           value="{{ old('commission_percentage', $po->commission_percentage ?? 0) }}"
           class="form-control" required>
    @error('commission_percentage') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- Commission Fixed --}}
  <div class="col-md-4">
    <label class="form-label">Commission (Fixed) *</label>
    <input type="number" name="commission_fixed" step="0.01" min="0"
           value="{{ old('commission_fixed', $po->commission_fixed ?? 0) }}"
           class="form-control" required>
    @error('commission_fixed') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- Bank Fee --}}
  <div class="col-md-4">
    <label class="form-label">Bank Fee *</label>
    <input type="number" name="bank_fee" step="0.01" min="0"
           value="{{ old('bank_fee', $po->bank_fee ?? 0) }}"
           class="form-control" required>
    @error('bank_fee') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  {{-- Settlement Day --}}
  <div class="col-md-4">
    <label class="form-label">Settlement Day *</label>
    <input type="number" name="settlement_day" step="1" min="0"
           value="{{ old('settlement_day', $po->settlement_day ?? 0) }}"
           class="form-control" required>
    @error('settlement_day') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

</div>

<div class="mt-3">
  <button type="submit" class="btn btn-primary">
    {{ $submitLabel ?? 'Save' }}
  </button>
  <a href="{{ route('pos.index') }}" class="btn btn-light">Cancel</a>
</div>
