<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminPageController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $pages = Page::query()
            ->search($request->string('q')->toString())
            ->filter($request->only(['template', 'status']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $templates = Page::query()
            ->select('template')
            ->distinct()
            ->orderBy('template')
            ->pluck('template');

        return view('admin.pages.index', compact('pages', 'templates'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        return view('admin.pages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page created.');
    }

    public function edit(Request $request, Page $page): View
    {
        abort_unless($request->user()?->is_admin, 403);

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request, $page);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated.');
    }

    public function destroy(Request $request, Page $page): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $page->delete();

        return back()->with('success', 'Page deleted.');
    }

    private function validatedData(Request $request, ?Page $page = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:220', Rule::unique('pages', 'slug')->ignore($page?->id)],
            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'template' => ['required', 'string', 'max:100'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'string', 'max:255'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
        ]);
    }
}
