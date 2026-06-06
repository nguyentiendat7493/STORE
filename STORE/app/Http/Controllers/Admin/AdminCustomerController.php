<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminCustomerController extends Controller
{
    public function index(Request $request): View
    {
        $customers = User::role('customer')
            ->search($request->string('q')->toString())
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer): View
    {
        abort_if($customer->role !== 'customer', 404);

        $customer->load(['orders' => fn ($query) => $query->latest()->take(20)]);

        return view('admin.customers.show', compact('customer'));
    }

    public function update(Request $request, User $customer): RedirectResponse
    {
        abort_if($customer->role !== 'customer', 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($customer->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        $customer->update($data);

        return back()->with('success', 'Đã cập nhật khách hàng.');
    }

    public function destroy(User $customer): RedirectResponse
    {
        abort_if($customer->role !== 'customer', 404);

        $customer->delete();

        return back()->with('success', 'Đã xóa khách hàng.');
    }
}
