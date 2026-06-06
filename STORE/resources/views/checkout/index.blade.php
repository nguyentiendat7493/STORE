@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
    <div class="container-wide py-5">
        <div class="eyebrow mb-2">Checkout</div>
        <h1 class="section-title mb-4">Thanh toán</h1>
        <div class="row g-5">
            <div class="col-lg-7">
                <form class="sidebar-box" method="POST" action="{{ route('checkout.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tên người nhận</label>
                        <input class="form-control" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input class="form-control" name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ nhận hàng</label>
                        <textarea class="form-control" name="customer_address" rows="4" required>{{ old('customer_address', auth()->user()->address) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã giảm giá</label>
                        <input class="form-control" name="coupon_code" value="{{ old('coupon_code') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phương thức thanh toán</label>
                        <select class="form-select" name="payment_method" required>
                            <option value="cod">COD</option>
                            <option value="bank_transfer">Chuyển khoản</option>
                            <option value="momo">MoMo</option>
                            <option value="vnpay">VNPay</option>
                        </select>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Xác nhận đơn hàng</button>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="sidebar-box">
                    <div class="eyebrow mb-2">Order Summary</div>
                    <h2 class="h4 mb-3" style="font-family: var(--font-editorial);">Đơn hàng</h2>
                    @foreach ($cart->items as $item)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <div>
                                <div class="fw-semibold">{{ $item->productVariant->product->name }}</div>
                                <div class="small text-muted">{{ $item->productVariant->size?->name }} / {{ $item->productVariant->color?->name }} x {{ $item->quantity }}</div>
                            </div>
                            <div>{{ $item->display_subtotal }}</div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-between pt-3">
                        <strong>Tổng</strong>
                        <strong>{{ $cart->display_total }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
