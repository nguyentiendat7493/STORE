@csrf
@isset($paymentMethod)
    @method('PUT')
@endisset

@php
    $configValue = old(
        'config_json',
        isset($paymentMethod) ? json_encode($paymentMethod->config ?: [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '{}'
    );
@endphp

<div class="row g-3">
    <div class="col-lg-6">
        <label class="form-label">Name</label>
        <input class="form-control" name="name" value="{{ old('name', $paymentMethod?->name ?? '') }}" required>
    </div>
    <div class="col-lg-6">
        <label class="form-label">Code</label>
        <select class="form-select" name="code" required>
            @foreach ($codes as $code)
                <option value="{{ $code }}" @selected(old('code', $paymentMethod?->code ?? '') === $code)>{{ $code }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="3">{{ old('description', $paymentMethod?->description ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Config JSON</label>
        <textarea class="form-control font-monospace" name="config_json" rows="7">{{ $configValue }}</textarea>
        <div class="form-text">Use JSON for provider settings such as account number, QR URL, terminal code or sandbox keys.</div>
    </div>
    <div class="col-md-4">
        <label class="form-label">Sort order</label>
        <input class="form-control" type="number" min="0" name="sort_order" value="{{ old('sort_order', $paymentMethod?->sort_order ?? 0) }}" required>
    </div>
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" name="status" value="1" @checked(old('status', $paymentMethod?->status ?? true))>
            <label class="form-check-label">Active</label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button class="btn btn-dark" type="submit">Save Payment Method</button>
    <a class="btn btn-outline-dark" href="{{ route('admin.payment-methods.index') }}">Cancel</a>
</div>
