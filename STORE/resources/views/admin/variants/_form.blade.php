@csrf
@isset($variant)
    @method('PUT')
@endisset

<div class="row g-3">
    <div class="col-lg-12">
        <label class="form-label">Product</label>
        <select class="form-select" name="product_id" required>
            <option value="">Select product</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected(old('product_id', $variant?->product_id ?? '') == $product->id)>{{ $product->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Size</label>
        <select class="form-select" name="size_id" required>
            <option value="">Select size</option>
            @foreach ($sizes as $size)
                <option value="{{ $size->id }}" @selected(old('size_id', $variant?->size_id ?? '') == $size->id)>{{ $size->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Color</label>
        <select class="form-select" name="color_id" required>
            <option value="">Select color</option>
            @foreach ($colors as $color)
                <option value="{{ $color->id }}" @selected(old('color_id', $variant?->color_id ?? '') == $color->id)>{{ $color->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">SKU</label>
        <input class="form-control" name="sku" value="{{ old('sku', $variant?->sku ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Price</label>
        <input class="form-control" type="number" step="0.01" min="0" name="price" value="{{ old('price', $variant?->price ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Stock</label>
        <input class="form-control" type="number" min="0" name="stock" value="{{ old('stock', $variant?->stock ?? 0) }}" required>
    </div>
</div>
<div class="mt-4">
    <button class="btn btn-dark" type="submit">Save Variant</button>
    <a class="btn btn-outline-dark" href="{{ route('admin.variants.index') }}">Cancel</a>
</div>
