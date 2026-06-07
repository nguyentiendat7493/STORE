<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminBlogCategoryController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $blogCategories = BlogCategory::query()
            ->withCount('blogs')
            ->search($request->string('q')->toString())
            ->filter($request->only(['status']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.blog-categories.index', compact('blogCategories'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        return view('admin.blog-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['status'] = $request->boolean('status', true);

        BlogCategory::create($data);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog category created.');
    }

    public function edit(Request $request, BlogCategory $blogCategory): View
    {
        abort_unless($request->user()?->is_admin, 403);

        return view('admin.blog-categories.edit', compact('blogCategory'));
    }

    public function update(Request $request, BlogCategory $blogCategory): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request, $blogCategory);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['status'] = $request->boolean('status');

        $blogCategory->update($data);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog category updated.');
    }

    public function destroy(Request $request, BlogCategory $blogCategory): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $blogCategory->delete();

        return back()->with('success', 'Blog category deleted.');
    }

    private function validatedData(Request $request, ?BlogCategory $blogCategory = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:150', Rule::unique('blog_categories', 'slug')->ignore($blogCategory?->id)],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);
    }
}
