<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminSizeController extends Controller
{
    public function index(Request $request): View
    {
        $sizes = Size::search($request->string('q')->toString())->paginate(20)->withQueryString();

        return view('admin.sizes.index', compact('sizes'));
    }

    public function create(): View
    {
        return view('admin.sizes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:20', Rule::unique('sizes', 'name')],
        ]);

        Size::create($data);

        return redirect()->route('admin.sizes.index')->with('success', 'Đã thêm size.');
    }

    public function edit(Size $size): View
    {
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(Request $request, Size $size): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:20', Rule::unique('sizes', 'name')->ignore($size->id)],
        ]);

        $size->update($data);

        return redirect()->route('admin.sizes.index')->with('success', 'Đã cập nhật size.');
    }

    public function destroy(Size $size): RedirectResponse
    {
        $size->delete();

        return back()->with('success', 'Đã xóa size.');
    }
}
