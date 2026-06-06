<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPaymentController extends Controller
{
    public function index(Request $request): View
    {
        $payments = Payment::with('order.user')
            ->status($request->string('payment_status')->toString())
            ->method($request->string('payment_method')->toString())
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment): View
    {
        $payment->load('order.user', 'order.details');

        return view('admin.payments.show', compact('payment'));
    }

    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $data = $request->validate([
            'payment_method' => ['required', 'in:cod,bank_transfer,momo,vnpay'],
            'payment_status' => ['required', 'in:unpaid,paid,failed'],
            'paid_at' => ['nullable', 'date'],
        ]);

        if ($data['payment_status'] === 'paid' && empty($data['paid_at'])) {
            $data['paid_at'] = now();
        }

        $payment->update($data);

        return back()->with('success', 'Đã cập nhật thanh toán.');
    }
}
