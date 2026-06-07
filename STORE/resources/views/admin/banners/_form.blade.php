@csrf
@isset($banner)
    @method('PUT')
@endisset

<div class="row g-3">
    <div class="col-lg-8">
        <label class="form-label">Title</label>
        <input class="form-control" name="title" value="{{ old('title', $banner?->title ?? '') }}" required>
    </div>
    <div class="col-lg-4">
        <label class="form-label">Position</label>
        <select class="form-select" name="position" required>
            @foreach (['home_hero', 'home_promo', 'collection', 'sale', 'footer'] as $position)
                <option value="{{ $position }}" @selected(old('position', $banner?->position ?? 'home_hero') === $position)>{{ $position }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Subtitle</label>
        <textarea class="form-control" name="subtitle" rows="3">{{ old('subtitle', $banner?->subtitle ?? '') }}</textarea>
    </div>
    <div class="col-lg-8">
        <label class="form-label">Image URL</label>
        <input class="form-control" name="image" value="{{ old('image', $banner?->image ?? '') }}" placeholder="https://... or storage path">
    </div>
    <div class="col-lg-4">
        <label class="form-label">Upload image</label>
        <input class="form-control" type="file" name="image_file" accept="image/*">
    </div>
    @isset($banner)
        @if ($banner->image)
            <div class="col-12">
                <img class="border" style="width: min(100%, 520px); aspect-ratio: 16 / 9; object-fit: cover" src="{{ str_starts_with($banner->image, 'http') ? $banner->image : asset('storage/'.$banner->image) }}" alt="{{ $banner->title }}">
            </div>
        @endif
    @endisset
    <div class="col-md-6">
        <label class="form-label">Button text</label>
        <input class="form-control" name="button_text" value="{{ old('button_text', $banner?->button_text ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Button URL</label>
        <input class="form-control" name="button_url" value="{{ old('button_url', $banner?->button_url ?? '') }}" placeholder="/products">
    </div>
    <div class="col-md-4">
        <label class="form-label">Sort order</label>
        <input class="form-control" type="number" min="0" name="sort_order" value="{{ old('sort_order', $banner?->sort_order ?? 0) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Starts at</label>
        <input class="form-control" type="datetime-local" name="starts_at" value="{{ old('starts_at', $banner?->starts_at?->format('Y-m-d\\TH:i') ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Ends at</label>
        <input class="form-control" type="datetime-local" name="ends_at" value="{{ old('ends_at', $banner?->ends_at?->format('Y-m-d\\TH:i') ?? '') }}">
    </div>
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" name="status" value="1" @checked(old('status', $banner?->status ?? true))>
            <label class="form-check-label">Active</label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button class="btn btn-dark" type="submit">Save Banner</button>
    <a class="btn btn-outline-dark" href="{{ route('admin.banners.index') }}">Cancel</a>
</div>
