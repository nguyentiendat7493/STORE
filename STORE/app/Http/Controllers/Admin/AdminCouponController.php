<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminCouponController extends Controller
{
    public function index(Request $request): View
    {
        $coupons = Coupon::search($request->string('q')->toString())
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create(): View
    {
        return view('admin.coupons.create');
    }

    public function store(StoreCouponRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status', true);

        Coupon::create($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Đã thêm mã giảm giá.');
    }

    public function edit(Coupon $coupon): View
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(StoreCouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = $request->boolean('status', true);

        $coupon->update($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Đã cập nhật mã giảm giá.');
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        $coupon->delete();

        return back()->with('success', 'Đã xóa mã giảm giá.');
    }
}
