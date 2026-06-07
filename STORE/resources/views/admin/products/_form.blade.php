@csrf
@isset($product)
    @method('PUT')
@endisset

<div class="row g-3">
    <div class="col-lg-8">
        <label class="form-label">Name</label>
        <input class="form-control" name="name" value="{{ old('name', $product?->name ?? '') }}" required>
    </div>
    <div class="col-lg-4">
        <label class="form-label">Slug</label>
        <input class="form-control" name="slug" value="{{ old('slug', $product?->slug ?? '') }}" placeholder="Auto generated when blank">
    </div>
    <div class="col-lg-4">
        <label class="form-label">Category</label>
        <select class="form-select" name="category_id" required>
            <option value="">Select category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product?->category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-4">
        <label class="form-label">Brand</label>
        <select class="form-select" name="brand_id">
            <option value="">No brand</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" @selected(old('brand_id', $product?->brand_id ?? '') == $brand->id)>{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-4">
        <label class="form-label">Gender</label>
        <select class="form-select" name="gender" required>
            @foreach (['male' => 'Male', 'female' => 'Female', 'unisex' => 'Unisex', 'kids' => 'Kids'] as $value => $label)
                <option value="{{ $value }}" @selected(old('gender', $product?->gender ?? 'unisex') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Price</label>
        <input class="form-control" type="number" step="0.01" min="0" name="price" value="{{ old('price', $product?->price ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Sale price</label>
        <input class="form-control" type="number" step="0.01" min="0" name="sale_price" value="{{ old('sale_price', $product?->sale_price ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="5">{{ old('description', $product?->description ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Images</label>
        <input class="form-control" type="file" name="images[]" accept="image/*" multiple>
        @isset($product)
            @if ($product->images->isNotEmpty())
                <div class="row g-2 mt-2">
                    @foreach ($product->images as $image)
                        <div class="col-6 col-md-3">
                            <div class="border bg-light p-2 h-100">
                                <img class="w-100 mb-2" style="aspect-ratio: 1; object-fit: cover" src="{{ asset('storage/'.$image->image) }}" alt="{{ $product->name }}">
                                <div class="small text-muted">{{ $image->is_main ? 'Main image' : 'Gallery image' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endisset
    </div>
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" name="status" value="1" @checked(old('status', $product?->status ?? true))>
            <label class="form-check-label">Active</label>
        </div>
    </div>
</div>
<div class="mt-4">
    <button class="btn btn-dark" type="submit">Save Product</button>
    <a class="btn btn-outline-dark" href="{{ route('admin.products.index') }}">Cancel</a>
</div>
