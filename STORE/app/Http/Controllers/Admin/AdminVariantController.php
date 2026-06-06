<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminVariantController extends Controller
{
    public function index(Request $request): View
    {
        $variants = ProductVariant::with(['product', 'size', 'color'])
            ->search($request->string('q')->toString())
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.variants.index', compact('variants'));
    }

    public function create(): View
    {
        return view('admin.variants.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        ProductVariant::create($this->validatedData($request));

        return redirect()->route('admin.variants.index')->with('success', 'Đã thêm biến thể.');
    }

    public function edit(ProductVariant $variant): View
    {
        return view('admin.variants.edit', $this->formData() + compact('variant'));
    }

    public function update(Request $request, ProductVariant $variant): RedirectResponse
    {
        $variant->update($this->validatedData($request, $variant));

        return redirect()->route('admin.variants.index')->with('success', 'Đã cập nhật biến thể.');
    }

    public function destroy(ProductVariant $variant): RedirectResponse
    {
        $variant->delete();

        return back()->with('success', 'Đã xóa biến thể.');
    }

    public function stock(Request $request, ProductVariant $variant): RedirectResponse
    {
        $data = $request->validate([
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $variant->update($data);

        return back()->with('success', 'Đã cập nhật tồn kho.');
    }

    private function formData(): array
    {
        return [
            'products' => Product::orderBy('name')->get(),
            'sizes' => Size::orderBy('name')->get(),
            'colors' => Color::orderBy('name')->get(),
        ];
    }

    private function validatedData(Request $request, ?ProductVariant $variant = null): array
    {
        return $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'size_id' => ['required', 'exists:sizes,id'],
            'color_id' => ['required', 'exists:colors,id'],
            'sku' => ['required', 'string', 'max:100', Rule::unique('product_variants', 'sku')->ignore($variant?->id)],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);
    }
}
