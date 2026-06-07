@csrf
@isset($page)
    @method('PUT')
@endisset

<div class="row g-3">
    <div class="col-lg-8">
        <label class="form-label">Title</label>
        <input class="form-control" name="title" value="{{ old('title', $page?->title ?? '') }}" required>
    </div>
    <div class="col-lg-4">
        <label class="form-label">Slug</label>
        <input class="form-control" name="slug" value="{{ old('slug', $page?->slug ?? '') }}" placeholder="Auto generated when blank">
    </div>
    <div class="col-12">
        <label class="form-label">Excerpt</label>
        <textarea class="form-control" name="excerpt" rows="3">{{ old('excerpt', $page?->excerpt ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Content</label>
        <textarea class="form-control" name="content" rows="12">{{ old('content', $page?->content ?? '') }}</textarea>
        <div class="form-text">Plain text and basic line breaks are supported.</div>
    </div>
    <div class="col-md-4">
        <label class="form-label">Template</label>
        <select class="form-select" name="template" required>
            @foreach (['default', 'policy', 'contact', 'faq', 'about'] as $template)
                <option value="{{ $template }}" @selected(old('template', $page?->template ?? 'default') === $template)>{{ ucfirst($template) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select class="form-select" name="status" required>
            <option value="draft" @selected(old('status', $page?->status ?? 'draft') === 'draft')>Draft</option>
            <option value="published" @selected(old('status', $page?->status ?? 'draft') === 'published')>Published</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Published at</label>
        <input class="form-control" type="datetime-local" name="published_at" value="{{ old('published_at', $page?->published_at?->format('Y-m-d\\TH:i') ?? now()->format('Y-m-d\\TH:i')) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Meta title</label>
        <input class="form-control" name="meta_title" value="{{ old('meta_title', $page?->meta_title ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Canonical URL</label>
        <input class="form-control" name="canonical_url" value="{{ old('canonical_url', $page?->canonical_url ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Meta description</label>
        <textarea class="form-control" name="meta_description" rows="3">{{ old('meta_description', $page?->meta_description ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Open Graph image URL</label>
        <input class="form-control" name="og_image" value="{{ old('og_image', $page?->og_image ?? '') }}">
    </div>
</div>

<div class="mt-4">
    <button class="btn btn-dark" type="submit">Save Page</button>
    <a class="btn btn-outline-dark" href="{{ route('admin.pages.index') }}">Cancel</a>
</div>
