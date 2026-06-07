@csrf
@isset($menu)
    @method('PUT')
@endisset

<div class="row g-3">
    <div class="col-lg-4">
        <label class="form-label">Name</label>
        <input class="form-control" name="name" value="{{ old('name', $menu?->name ?? '') }}" required>
    </div>
    <div class="col-lg-4">
        <label class="form-label">Slug</label>
        <input class="form-control" name="slug" value="{{ old('slug', $menu?->slug ?? '') }}" placeholder="Auto generated when blank">
    </div>
    <div class="col-lg-4">
        <label class="form-label">Location</label>
        <select class="form-select" name="location" required>
            @foreach (['header', 'footer_service', 'footer_account'] as $location)
                <option value="{{ $location }}" @selected(old('location', $menu?->location ?? 'header') === $location)>{{ $location }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" name="status" value="1" @checked(old('status', $menu?->status ?? true))>
            <label class="form-check-label">Active</label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button class="btn btn-dark" type="submit">Save Menu</button>
    <a class="btn btn-outline-dark" href="{{ route('admin.menus.index') }}">Cancel</a>
</div>
