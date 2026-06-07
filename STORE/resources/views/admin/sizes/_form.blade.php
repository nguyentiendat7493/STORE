@csrf
@isset($size)
    @method('PUT')
@endisset

<div class="mb-4">
    <label class="form-label">Name</label>
    <input class="form-control" name="name" value="{{ old('name', $size?->name ?? '') }}" required>
</div>
<button class="btn btn-dark" type="submit">Save Size</button>
<a class="btn btn-outline-dark" href="{{ route('admin.sizes.index') }}">Cancel</a>
