<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminBlogController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $blogs = Blog::query()
            ->with(['category', 'author'])
            ->search($request->string('q')->toString())
            ->filter($request->only(['blog_category_id', 'status']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $categories = BlogCategory::orderBy('name')->get();

        return view('admin.blogs.index', compact('blogs', 'categories'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $categories = BlogCategory::active()->orderBy('name')->get();

        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['user_id'] = $request->user()->id;
        $data['image'] = $this->storeImage($request) ?: $data['image'];

        Blog::create($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created.');
    }

    public function edit(Request $request, Blog $blog): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $categories = BlogCategory::active()->orderBy('name')->get();

        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request, $blog);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        if ($path = $this->storeImage($request)) {
            if ($blog->image && ! str_starts_with($blog->image, 'http')) {
                Storage::disk('public')->delete($blog->image);
            }

            $data['image'] = $path;
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated.');
    }

    public function destroy(Request $request, Blog $blog): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        if ($blog->image && ! str_starts_with($blog->image, 'http')) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return back()->with('success', 'Blog post deleted.');
    }

    private function validatedData(Request $request, ?Blog $blog = null): array
    {
        return $request->validate([
            'blog_category_id' => ['nullable', 'exists:blog_categories,id'],
            'title' => ['required', 'string', 'max:220'],
            'slug' => ['nullable', 'string', 'max:240', Rule::unique('blogs', 'slug')->ignore($blog?->id)],
            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'string', 'max:255'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    private function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('image_file')) {
            return null;
        }

        return $request->file('image_file')->store('blogs', 'public');
    }
}
