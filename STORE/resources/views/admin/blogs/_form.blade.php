@csrf
@isset($blog)
    @method('PUT')
@endisset

<div class="row g-3">
    <div class="col-lg-8">
        <label class="form-label">Title</label>
        <input class="form-control" name="title" value="{{ old('title', $blog?->title ?? '') }}" required>
    </div>
    <div class="col-lg-4">
        <label class="form-label">Slug</label>
        <input class="form-control" name="slug" value="{{ old('slug', $blog?->slug ?? '') }}" placeholder="Auto generated when blank">
    </div>
    <div class="col-lg-4">
        <label class="form-label">Category</label>
        <select class="form-select" name="blog_category_id">
            <option value="">No category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('blog_category_id', $blog?->blog_category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-4">
        <label class="form-label">Status</label>
        <select class="form-select" name="status" required>
            <option value="draft" @selected(old('status', $blog?->status ?? 'draft') === 'draft')>Draft</option>
            <option value="published" @selected(old('status', $blog?->status ?? 'draft') === 'published')>Published</option>
        </select>
    </div>
    <div class="col-lg-4">
        <label class="form-label">Published at</label>
        <input class="form-control" type="datetime-local" name="published_at" value="{{ old('published_at', $blog?->published_at?->format('Y-m-d\\TH:i') ?? now()->format('Y-m-d\\TH:i')) }}">
    </div>
    <div class="col-12">
        <label class="form-label">Excerpt</label>
        <textarea class="form-control" name="excerpt" rows="3">{{ old('excerpt', $blog?->excerpt ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Content</label>
        <textarea class="form-control" name="content" rows="12">{{ old('content', $blog?->content ?? '') }}</textarea>
    </div>
    <div class="col-lg-8">
        <label class="form-label">Image URL</label>
        <input class="form-control" name="image" value="{{ old('image', $blog?->image ?? '') }}">
    </div>
    <div class="col-lg-4">
        <label class="form-label">Upload image</label>
        <input class="form-control" type="file" name="image_file" accept="image/*">
    </div>
    @isset($blog)
        @if ($blog->image)
            <div class="col-12">
                <img class="border" style="width: min(100%, 520px); aspect-ratio: 16 / 9; object-fit: cover" src="{{ str_starts_with($blog->image, 'http') ? $blog->image : asset('storage/'.$blog->image) }}" alt="{{ $blog->title }}">
            </div>
        @endif
    @endisset
    <div class="col-md-6">
        <label class="form-label">Meta title</label>
        <input class="form-control" name="meta_title" value="{{ old('meta_title', $blog?->meta_title ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Canonical URL</label>
        <input class="form-control" name="canonical_url" value="{{ old('canonical_url', $blog?->canonical_url ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Meta description</label>
        <textarea class="form-control" name="meta_description" rows="3">{{ old('meta_description', $blog?->meta_description ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Open Graph image URL</label>
        <input class="form-control" name="og_image" value="{{ old('og_image', $blog?->og_image ?? '') }}">
    </div>
</div>

<div class="mt-4">
    <button class="btn btn-dark" type="submit">Save Blog Post</button>
    <a class="btn btn-outline-dark" href="{{ route('admin.blogs.index') }}">Cancel</a>
</div>
