@extends('layouts.app')

@section('title', 'Đơn hàng #'.$order->id)

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Đơn hàng #{{ $order->id }}</h1>
                <div class="text-muted">{{ $order->created_at?->format('d/m/Y H:i') }}</div>
            </div>
            <span class="badge text-bg-secondary">{{ $order->status }}</span>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="table-responsive sidebar-box">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Biến thể</th>
                                <th>Giá</th>
                                <th>SL</th>
                                <th>Tạm tính</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->details as $detail)
                                <tr>
                                    <td>{{ $detail->product_name }}</td>
                                    <td>{{ $detail->size_name }} / {{ $detail->color_name }}</td>
                                    <td>{{ number_format((float) $detail->price, 0, ',', '.') }} VND</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>{{ $detail->display_subtotal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar-box mb-3">
                    <h2 class="h5">Người nhận</h2>
                    <div>{{ $order->customer_name }}</div>
                    <div>{{ $order->customer_phone }}</div>
                    <div>{{ $order->customer_address }}</div>
                </div>
                <div class="sidebar-box">
                    <div class="d-flex justify-content-between"><span>Tạm tính</span><span>{{ number_format((float) $order->total_price, 0, ',', '.') }} VND</span></div>
                    <div class="d-flex justify-content-between"><span>Giảm giá</span><span>{{ number_format((float) $order->discount_amount, 0, ',', '.') }} VND</span></div>
                    <hr>
                    <div class="d-flex justify-content-between fs-5"><strong>Tổng</strong><strong>{{ $order->display_final_price }}</strong></div>
                    <div class="small text-muted mt-2">Thanh toán: {{ $order->payment?->payment_method }} / {{ $order->payment?->payment_status }}</div>
                    @if ($order->can_cancel)
                        <form class="mt-3" method="POST" action="{{ route('orders.cancel', $order) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-outline-danger w-100" type="submit">Hủy đơn</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
