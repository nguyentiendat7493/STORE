@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
    @php
        $defaultShipping = $shippingMethods->first();
        $shippingFee = $defaultShipping
            ? (((float) $defaultShipping->min_order_value > 0 && (float) $cart->total >= (float) $defaultShipping->min_order_value) ? 0 : (float) $defaultShipping->fee)
            : 0;
    @endphp

    <div class="container-wide py-5">
        <div class="eyebrow mb-2">Thanh toán</div>
        <h1 class="section-title mb-4">Hoàn tất đơn hàng</h1>
        <div class="row g-5">
            <div class="col-lg-7">
                <form class="sidebar-box" method="POST" action="{{ route('checkout.store') }}">
                    @csrf
                    @if ($addresses->isNotEmpty())
                        <div class="mb-3">
                            <label class="form-label">Saved address</label>
                            <select class="form-select" name="address_id" id="checkout-address">
                                <option value="">Enter a new address</option>
                                @foreach ($addresses as $address)
                                    <option
                                        value="{{ $address->id }}"
                                        data-name="{{ $address->recipient_name }}"
                                        data-phone="{{ $address->phone }}"
                                        data-address="{{ $address->full_address }}"
                                        @selected(old('address_id', $address->is_default ? $address->id : null) == $address->id)
                                    >
                                        {{ $address->label }}{{ $address->is_default ? ' - Default' : '' }} - {{ $address->full_address }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Recipient name</label>
                        <input class="form-control" id="checkout-name" name="customer_name" value="{{ old('customer_name', $addresses->firstWhere('is_default', true)?->recipient_name ?? auth()->user()->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input class="form-control" id="checkout-phone" name="customer_phone" value="{{ old('customer_phone', $addresses->firstWhere('is_default', true)?->phone ?? auth()->user()->phone) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Shipping address</label>
                        <textarea class="form-control" id="checkout-address-text" name="customer_address" rows="4" required>{{ old('customer_address', $addresses->firstWhere('is_default', true)?->full_address ?? auth()->user()->address) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã giảm giá</label>
                        <input class="form-control" name="coupon_code" value="{{ old('coupon_code') }}">
                    </div>
                    @if ($shippingMethods->isNotEmpty())
                        <div class="mb-3">
                            <label class="form-label">Phương thức vận chuyển</label>
                            <select class="form-select" name="shipping_method">
                                @foreach ($shippingMethods as $method)
                                    @php($isFree = (float) $cart->total >= (float) $method->min_order_value && (float) $method->min_order_value > 0)
                                    <option value="{{ $method->code }}" @selected(old('shipping_method') === $method->code)>
                                        {{ $method->name }} - {{ $isFree ? 'Miễn phí' : number_format((float) $method->fee, 0, ',', '.').' VND' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    @if ($paymentMethods->isNotEmpty())
                        <div class="mb-3">
                            <label class="form-label">Phương thức thanh toán</label>
                            <select class="form-select" name="payment_method" required>
                                @foreach ($paymentMethods as $method)
                                    <option value="{{ $method->code }}" @selected(old('payment_method') === $method->code)>{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <button class="btn btn-primary w-100" type="submit">Đặt hàng</button>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="sidebar-box">
                    <div class="eyebrow mb-2">Tóm tắt đơn hàng</div>
                    <h2 class="h4 mb-3" style="font-family: var(--font-editorial);">Đơn hàng của bạn</h2>
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
                        <span>Tạm tính</span>
                        <span>{{ $cart->display_total }}</span>
                    </div>
                    <div class="d-flex justify-content-between pt-2">
                        <span>Phí vận chuyển</span>
                        <span>{{ number_format($shippingFee, 0, ',', '.') }} VND</span>
                    </div>
                    <div class="d-flex justify-content-between pt-3">
                        <strong>Tổng thanh toán</strong>
                        <strong>{{ number_format((float) $cart->total + $shippingFee, 0, ',', '.') }} VND</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const addressSelect = document.getElementById('checkout-address');

        if (addressSelect) {
            const nameInput = document.getElementById('checkout-name');
            const phoneInput = document.getElementById('checkout-phone');
            const addressInput = document.getElementById('checkout-address-text');

            addressSelect.addEventListener('change', () => {
                const selected = addressSelect.options[addressSelect.selectedIndex];

                if (!selected.value) {
                    return;
                }

                nameInput.value = selected.dataset.name || nameInput.value;
                phoneInput.value = selected.dataset.phone || phoneInput.value;
                addressInput.value = selected.dataset.address || addressInput.value;
            });
        }
    </script>
@endpush
