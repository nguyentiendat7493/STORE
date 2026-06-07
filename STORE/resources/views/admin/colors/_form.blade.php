@csrf
@isset($color)
    @method('PUT')
@endisset

<div class="mb-3">
    <label class="form-label">Name</label>
    <input class="form-control" name="name" value="{{ old('name', $color?->name ?? '') }}" required>
</div>
<div class="mb-4">
    <label class="form-label">Hex code</label>
    <input class="form-control" name="hex_code" value="{{ old('hex_code', $color?->hex_code ?? '') }}" placeholder="#111111">
</div>
<button class="btn btn-dark" type="submit">Save Color</button>
<a class="btn btn-outline-dark" href="{{ route('admin.colors.index') }}">Cancel</a>
