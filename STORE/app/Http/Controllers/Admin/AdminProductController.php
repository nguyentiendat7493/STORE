<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with(['category', 'brand', 'images'])
            ->search($request->string('q')->toString())
            ->filter($request->only(['category_id', 'brand_id', 'gender']))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['status'] = $request->boolean('status', true);

        $product = Product::create($data);
        $this->storeImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Đã thêm sản phẩm.');
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'brand', 'images', 'variants.size', 'variants.color']);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $product->load('images');
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validatedData($request, $product);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['status'] = $request->boolean('status');

        $product->update($data);
        $this->storeImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Đã cập nhật sản phẩm.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return back()->with('success', 'Đã xóa sản phẩm.');
    }

    public function setMainImage(ProductImage $image): RedirectResponse
    {
        ProductImage::where('product_id', $image->product_id)->update(['is_main' => 0]);
        $image->update(['is_main' => 1]);

        return back()->with('success', 'Đã chọn ảnh chính.');
    }

    public function destroyImage(ProductImage $image): RedirectResponse
    {
        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Đã xóa ảnh sản phẩm.');
    }

    private function validatedData(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:220', Rule::unique('products', 'slug')->ignore($product?->id)],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lte:price'],
            'gender' => ['required', 'in:male,female,unisex,kids'],
            'status' => ['nullable', 'boolean'],
            'images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
    }

    private function storeImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');

            $product->images()->create([
                'image' => $path,
                'is_main' => $product->images()->doesntExist() && $index === 0,
            ]);
        }
    }
}
