@extends('layouts.app')

@section('title', 'Đơn hàng #'.$order->id)

@section('content')
    @php
        $statusLabels = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'shipping' => 'Đang giao',
            'completed' => 'Hoàn tất',
            'cancelled' => 'Đã hủy',
        ];
    @endphp

    <div class="container-wide py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <div class="eyebrow mb-2">Chi tiết đơn hàng</div>
                <h1 class="section-title mb-1">Đơn hàng #{{ $order->id }}</h1>
                <div class="text-muted">{{ $order->created_at?->format('d/m/Y H:i') }}</div>
            </div>
            <span class="badge text-bg-secondary">{{ $statusLabels[$order->status] ?? $order->status }}</span>
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
                <div class="sidebar-box mt-3">
                    <h2 class="h5">Lịch sử đơn hàng</h2>
                    @forelse ($order->statusHistories as $history)
                        <div class="border-top py-3">
                            <div class="d-flex justify-content-between gap-3">
                                <div>
                                    <div class="fw-semibold">
                                        @if ($history->from_status)
                                            {{ $statusLabels[$history->from_status] ?? ucfirst($history->from_status) }} sang
                                        @endif
                                        {{ $statusLabels[$history->to_status] ?? ucfirst($history->to_status) }}
                                    </div>
                                    @if ($history->note)
                                        <div class="small text-muted">{{ $history->note }}</div>
                                    @endif
                                </div>
                                <div class="small text-muted text-end">{{ $history->created_at?->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">Chưa có lịch sử trạng thái.</div>
                    @endforelse
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
                    <div class="d-flex justify-content-between"><span>Phí vận chuyển</span><span>{{ $order->display_shipping_fee }}</span></div>
                    <div class="small text-muted mt-1">{{ $order->shipping_method_name ?? 'Không có phương thức vận chuyển' }}</div>
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
