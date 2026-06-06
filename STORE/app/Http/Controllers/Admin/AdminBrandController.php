<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBrandRequest;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminBrandController extends Controller
{
    public function index(Request $request): View
    {
        $brands = Brand::search($request->string('q')->toString())
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.brands.index', compact('brands'));
    }

    public function create(): View
    {
        return view('admin.brands.create');
    }

    public function store(StoreBrandRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['status'] = $request->boolean('status', true);

        Brand::create($data);

        return redirect()->route('admin.brands.index')->with('success', 'Đã thêm thương hiệu.');
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(StoreBrandRequest $request, Brand $brand): RedirectResponse
    {
        $data = $request->validated();

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['status'] = $request->boolean('status');

        $brand->update($data);

        return redirect()->route('admin.brands.index')->with('success', 'Đã cập nhật thương hiệu.');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();

        return back()->with('success', 'Đã xóa thương hiệu.');
    }
}
