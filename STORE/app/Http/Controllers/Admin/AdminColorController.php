<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminColorController extends Controller
{
    public function index(Request $request): View
    {
        $colors = Color::search($request->string('q')->toString())->paginate(20)->withQueryString();

        return view('admin.colors.index', compact('colors'));
    }

    public function create(): View
    {
        return view('admin.colors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'hex_code' => ['nullable', 'string', 'max:20'],
        ]);

        Color::create($data);

        return redirect()->route('admin.colors.index')->with('success', 'Đã thêm màu sắc.');
    }

    public function edit(Color $color): View
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'hex_code' => ['nullable', 'string', 'max:20'],
        ]);

        $color->update($data);

        return redirect()->route('admin.colors.index')->with('success', 'Đã cập nhật màu sắc.');
    }

    public function destroy(Color $color): RedirectResponse
    {
        $color->delete();

        return back()->with('success', 'Đã xóa màu sắc.');
    }
}
