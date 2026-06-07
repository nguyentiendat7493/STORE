<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminPaymentMethodController extends Controller
{
    private const ALLOWED_CODES = ['cod', 'bank_transfer', 'momo', 'vnpay'];

    public function index(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        $paymentMethods = PaymentMethod::query()
            ->search($request->string('q')->toString())
            ->filter($request->only(['status']))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.payment-methods.index', compact('paymentMethods'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->is_admin, 403);

        return view('admin.payment-methods.create', [
            'codes' => self::ALLOWED_CODES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request);
        $data['status'] = $request->boolean('status', true);

        PaymentMethod::create($data);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Payment method created.');
    }

    public function edit(Request $request, PaymentMethod $paymentMethod): View
    {
        abort_unless($request->user()?->is_admin, 403);

        return view('admin.payment-methods.edit', [
            'paymentMethod' => $paymentMethod,
            'codes' => self::ALLOWED_CODES,
        ]);
    }

    public function update(Request $request, PaymentMethod $paymentMethod): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $data = $this->validatedData($request, $paymentMethod);
        $data['status'] = $request->boolean('status');

        $paymentMethod->update($data);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Payment method updated.');
    }

    public function destroy(Request $request, PaymentMethod $paymentMethod): RedirectResponse
    {
        abort_unless($request->user()?->is_admin, 403);

        $paymentMethod->delete();

        return back()->with('success', 'Payment method deleted.');
    }

    private function validatedData(Request $request, ?PaymentMethod $paymentMethod = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'code' => [
                'required',
                'string',
                'max:100',
                Rule::in(self::ALLOWED_CODES),
                Rule::unique('payment_methods', 'code')->ignore($paymentMethod?->id),
            ],
            'description' => ['nullable', 'string'],
            'config_json' => ['nullable', 'json'],
            'status' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $configJson = $data['config_json'] ?? null;
        unset($data['config_json']);

        $data['config'] = $configJson ? json_decode($configJson, true) : [];

        return $data;
    }
}
