@csrf
@isset($shippingMethod)
    @method('PUT')
@endisset

<div class="row g-3">
    <div class="col-lg-6">
        <label class="form-label">Name</label>
        <input class="form-control" name="name" value="{{ old('name', $shippingMethod?->name ?? '') }}" required>
    </div>
    <div class="col-lg-6">
        <label class="form-label">Code</label>
        <input class="form-control" name="code" value="{{ old('code', $shippingMethod?->code ?? '') }}" required>
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="4">{{ old('description', $shippingMethod?->description ?? '') }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label">Fee</label>
        <input class="form-control" type="number" min="0" step="0.01" name="fee" value="{{ old('fee', $shippingMethod?->fee ?? 0) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Free shipping from</label>
        <input class="form-control" type="number" min="0" step="0.01" name="min_order_value" value="{{ old('min_order_value', $shippingMethod?->min_order_value ?? 0) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Sort order</label>
        <input class="form-control" type="number" min="0" name="sort_order" value="{{ old('sort_order', $shippingMethod?->sort_order ?? 0) }}" required>
    </div>
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" name="status" value="1" @checked(old('status', $shippingMethod?->status ?? true))>
            <label class="form-check-label">Active</label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button class="btn btn-dark" type="submit">Save Shipping Method</button>
    <a class="btn btn-outline-dark" href="{{ route('admin.shipping-methods.index') }}">Cancel</a>
</div>
