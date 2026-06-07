<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminMenuController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $menus = Menu::query()
            ->withCount('allItems')
            ->search($request->string('q')->toString())
            ->filter($request->only(['location', 'status']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.menus.index', compact('menus'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        return view('admin.menus.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['status'] = $request->boolean('status', true);

        Menu::create($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created.');
    }

    public function edit(Request $request, Menu $menu): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $menu->load(['allItems.parent']);

        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request, $menu);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['status'] = $request->boolean('status');

        $menu->update($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated.');
    }

    public function destroy(Request $request, Menu $menu): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $menu->delete();

        return back()->with('success', 'Menu deleted.');
    }

    private function validatedData(Request $request, ?Menu $menu = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:150', Rule::unique('menus', 'slug')->ignore($menu?->id)],
            'location' => ['required', 'string', 'max:100'],
            'status' => ['nullable', 'boolean'],
        ]);
    }
}
