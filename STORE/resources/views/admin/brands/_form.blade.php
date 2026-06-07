@csrf
@isset($brand)
    @method('PUT')
@endisset

<div class="mb-3">
    <label class="form-label">Name</label>
    <input class="form-control" name="name" value="{{ old('name', $brand?->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Slug</label>
    <input class="form-control" name="slug" value="{{ old('slug', $brand?->slug ?? '') }}" placeholder="Auto generated when blank">
</div>
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" name="description" rows="4">{{ old('description', $brand?->description ?? '') }}</textarea>
</div>
<div class="form-check form-switch mb-4">
    <input class="form-check-input" type="checkbox" role="switch" name="status" value="1" @checked(old('status', $brand?->status ?? true))>
    <label class="form-check-label">Active</label>
</div>
<button class="btn btn-dark" type="submit">Save Brand</button>
<a class="btn btn-outline-dark" href="{{ route('admin.brands.index') }}">Cancel</a>
