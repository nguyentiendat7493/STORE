@csrf
@isset($coupon)
    @method('PUT')
@endisset

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Code</label>
        <input class="form-control" name="code" value="{{ old('code', $coupon?->code ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Discount type</label>
        <select class="form-select" name="discount_type" required>
            @foreach (['percent' => 'Percent', 'fixed' => 'Fixed amount'] as $value => $label)
                <option value="{{ $value }}" @selected(old('discount_type', $coupon?->discount_type ?? 'percent') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Discount value</label>
        <input class="form-control" type="number" step="0.01" min="0" name="discount_value" value="{{ old('discount_value', $coupon?->discount_value ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Start date</label>
        <input class="form-control" type="date" name="start_date" value="{{ old('start_date', $coupon?->start_date?->format('Y-m-d') ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">End date</label>
        <input class="form-control" type="date" name="end_date" value="{{ old('end_date', $coupon?->end_date?->format('Y-m-d') ?? '') }}">
    </div>
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" name="status" value="1" @checked(old('status', $coupon?->status ?? true))>
            <label class="form-check-label">Active</label>
        </div>
    </div>
</div>
<div class="mt-4">
    <button class="btn btn-dark" type="submit">Save Coupon</button>
    <a class="btn btn-outline-dark" href="{{ route('admin.coupons.index') }}">Cancel</a>
</div>
