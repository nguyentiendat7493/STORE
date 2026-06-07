@csrf
@isset($item)
    @method('PUT')
@endisset

<div class="row g-3">
    <div class="col-lg-6">
        <label class="form-label">Title</label>
        <input class="form-control" name="title" value="{{ old('title', $item?->title ?? '') }}" required>
    </div>
    <div class="col-lg-6">
        <label class="form-label">URL</label>
        <input class="form-control" name="url" value="{{ old('url', $item?->url ?? '') }}" placeholder="/products" required>
    </div>
    <div class="col-lg-4">
        <label class="form-label">Parent</label>
        <select class="form-select" name="parent_id">
            <option value="">No parent</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}" @selected(old('parent_id', $item?->parent_id ?? '') == $parent->id)>{{ $parent->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-4">
        <label class="form-label">Target</label>
        <select class="form-select" name="target" required>
            <option value="_self" @selected(old('target', $item?->target ?? '_self') === '_self')>Same tab</option>
            <option value="_blank" @selected(old('target', $item?->target ?? '_self') === '_blank')>New tab</option>
        </select>
    </div>
    <div class="col-lg-4">
        <label class="form-label">Sort order</label>
        <input class="form-control" type="number" min="0" name="sort_order" value="{{ old('sort_order', $item?->sort_order ?? 0) }}" required>
    </div>
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" name="status" value="1" @checked(old('status', $item?->status ?? true))>
            <label class="form-check-label">Active</label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button class="btn btn-dark" type="submit">Save Menu Item</button>
    <a class="btn btn-outline-dark" href="{{ route('admin.menus.edit', $menu) }}">Cancel</a>
</div>
