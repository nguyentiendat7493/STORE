<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminMenuItemController extends Controller
{
    public function create(Request $request, Menu $menu): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $parents = $menu->allItems()->whereNull('parent_id')->orderBy('sort_order')->get();

        return view('admin.menu-items.create', compact('menu', 'parents'));
    }

    public function store(Request $request, Menu $menu): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request, $menu);
        $data['status'] = $request->boolean('status', true);

        $menu->allItems()->create($data);

        return redirect()->route('admin.menus.edit', $menu)->with('success', 'Menu item created.');
    }

    public function edit(Request $request, MenuItem $item): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $menu = $item->menu;
        $parents = $menu->allItems()
            ->whereNull('parent_id')
            ->whereKeyNot($item->id)
            ->orderBy('sort_order')
            ->get();

        return view('admin.menu-items.edit', compact('item', 'menu', 'parents'));
    }

    public function update(Request $request, MenuItem $item): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request, $item->menu, $item);
        $data['status'] = $request->boolean('status');

        $item->update($data);

        return redirect()->route('admin.menus.edit', $item->menu)->with('success', 'Menu item updated.');
    }

    public function destroy(Request $request, MenuItem $item): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $menu = $item->menu;
        $item->delete();

        return redirect()->route('admin.menus.edit', $menu)->with('success', 'Menu item deleted.');
    }

    private function validatedData(Request $request, Menu $menu, ?MenuItem $item = null): array
    {
        return $request->validate([
            'parent_id' => [
                'nullable',
                Rule::exists('menu_items', 'id')->where('menu_id', $menu->id),
            ],
            'title' => ['required', 'string', 'max:120'],
            'url' => ['required', 'string', 'max:255'],
            'target' => ['required', 'in:_self,_blank'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
        ]);
    }
}
