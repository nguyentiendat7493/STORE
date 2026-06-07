@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    @php
        $defaultShipping = $shippingMethods->first();
        $shippingFee = $defaultShipping
            ? (((float) $defaultShipping->min_order_value > 0 && (float) $cart->total >= (float) $defaultShipping->min_order_value) ? 0 : (float) $defaultShipping->fee)
            : 0;
    @endphp

    <div class="container-wide py-5">
        <div class="eyebrow mb-2">Checkout</div>
        <h1 class="section-title mb-4">Checkout</h1>
        <div class="row g-5">
            <div class="col-lg-7">
                <form class="sidebar-box" method="POST" action="{{ route('checkout.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Recipient name</label>
                        <input class="form-control" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input class="form-control" name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Shipping address</label>
                        <textarea class="form-control" name="customer_address" rows="4" required>{{ old('customer_address', auth()->user()->address) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Coupon code</label>
                        <input class="form-control" name="coupon_code" value="{{ old('coupon_code') }}">
                    </div>
                    @if ($shippingMethods->isNotEmpty())
                        <div class="mb-3">
                            <label class="form-label">Shipping method</label>
                            <select class="form-select" name="shipping_method">
                                @foreach ($shippingMethods as $method)
                                    @php($isFree = (float) $cart->total >= (float) $method->min_order_value && (float) $method->min_order_value > 0)
                                    <option value="{{ $method->code }}" @selected(old('shipping_method') === $method->code)>
                                        {{ $method->name }} - {{ $isFree ? 'Free' : number_format((float) $method->fee, 0, ',', '.').' VND' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    @if ($paymentMethods->isNotEmpty())
                        <div class="mb-3">
                            <label class="form-label">Payment method</label>
                            <select class="form-select" name="payment_method" required>
                                @foreach ($paymentMethods as $method)
                                    <option value="{{ $method->code }}" @selected(old('payment_method') === $method->code)>{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <button class="btn btn-primary w-100" type="submit">Place Order</button>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="sidebar-box">
                    <div class="eyebrow mb-2">Order Summary</div>
                    <h2 class="h4 mb-3" style="font-family: var(--font-editorial);">Your Order</h2>
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
                        <span>Subtotal</span>
                        <span>{{ $cart->display_total }}</span>
                    </div>
                    <div class="d-flex justify-content-between pt-2">
                        <span>Shipping</span>
                        <span>{{ number_format($shippingFee, 0, ',', '.') }} VND</span>
                    </div>
                    <div class="d-flex justify-content-between pt-3">
                        <strong>Total</strong>
                        <strong>{{ number_format((float) $cart->total + $shippingFee, 0, ',', '.') }} VND</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
