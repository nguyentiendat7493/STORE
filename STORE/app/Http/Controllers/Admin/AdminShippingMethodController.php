<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminShippingMethodController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $shippingMethods = ShippingMethod::query()
            ->search($request->string('q')->toString())
            ->filter($request->only(['status']))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.shipping-methods.index', compact('shippingMethods'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        return view('admin.shipping-methods.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request);
        $data['status'] = $request->boolean('status', true);

        ShippingMethod::create($data);

        return redirect()->route('admin.shipping-methods.index')->with('success', 'Shipping method created.');
    }

    public function edit(Request $request, ShippingMethod $shippingMethod): View
    {
        abort_unless($request->user()?->is_admin, 403);

        return view('admin.shipping-methods.edit', compact('shippingMethod'));
    }

    public function update(Request $request, ShippingMethod $shippingMethod): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request, $shippingMethod);
        $data['status'] = $request->boolean('status');

        $shippingMethod->update($data);

        return redirect()->route('admin.shipping-methods.index')->with('success', 'Shipping method updated.');
    }

    public function destroy(Request $request, ShippingMethod $shippingMethod): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $shippingMethod->delete();

        return back()->with('success', 'Shipping method deleted.');
    }

    private function validatedData(Request $request, ?ShippingMethod $shippingMethod = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'code' => ['required', 'string', 'max:100', Rule::unique('shipping_methods', 'code')->ignore($shippingMethod?->id)],
            'description' => ['nullable', 'string'],
            'fee' => ['required', 'numeric', 'min:0'],
            'min_order_value' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);
    }
}
