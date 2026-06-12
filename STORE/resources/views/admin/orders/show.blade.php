@extends('admin.layouts.app')

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

    <div class="row g-4">
        <div class="col-xl-4">
            <div class="panel panel-pad mb-4">
                <h2 class="h5">Khách hàng</h2>
                <dl class="row mb-0">
                    <dt class="col-4">Tên</dt><dd class="col-8">{{ $order->customer_name ?? $order->user?->name }}</dd>
                    <dt class="col-4">Điện thoại</dt><dd class="col-8">{{ $order->customer_phone }}</dd>
                    <dt class="col-4">Địa chỉ</dt><dd class="col-8">{{ $order->customer_address }}</dd>
                    <dt class="col-4">Mã giảm giá</dt><dd class="col-8">{{ $order->coupon?->code ?? 'Không có' }}</dd>
                </dl>
            </div>
            <div class="panel panel-pad">
                <h2 class="h5">Trạng thái</h2>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <select class="form-select mb-3" name="status">
                        @foreach ($statusLabels as $status => $label)
                            <option value="{{ $status }}" @selected($order->status === $status)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <textarea class="form-control mb-3" name="note" rows="3" placeholder="Internal status note"></textarea>
                    <button class="btn btn-dark w-100" type="submit">Update Order</button>
                </form>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="panel mb-4">
                <div class="panel-pad border-bottom"><h2 class="h5 mb-0">Sản phẩm</h2></div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>Sản phẩm</th><th>Biến thể</th><th>Giá</th><th>SL</th><th>Tạm tính</th></tr></thead>
                        <tbody>
                            @foreach ($order->details as $detail)
                                <tr>
                                    <td>{{ $detail->productVariant?->product?->name }}</td>
                                    <td>{{ $detail->productVariant?->sku }}</td>
                                    <td>{{ number_format((float) $detail->price, 0, ',', '.') }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>{{ $detail->display_subtotal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-pad">
                <h2 class="h5">Tổng tiền</h2>
                <dl class="row mb-0">
                    <dt class="col-5">Tạm tính</dt><dd class="col-7">{{ number_format((float) $order->total_price, 0, ',', '.') }}</dd>
                    <dt class="col-5">Giảm giá</dt><dd class="col-7">{{ number_format((float) $order->discount_amount, 0, ',', '.') }}</dd>
                    <dt class="col-5">Phương thức vận chuyển</dt><dd class="col-7">{{ $order->shipping_method_name ?? 'Không có' }}</dd>
                    <dt class="col-5">Phí vận chuyển</dt><dd class="col-7">{{ $order->display_shipping_fee }}</dd>
                    <dt class="col-5">Tổng thanh toán</dt><dd class="col-7 fw-bold">{{ $order->display_final_price }}</dd>
                    <dt class="col-5">Trạng thái thanh toán</dt><dd class="col-7">{{ $order->payment?->payment_status ?? 'chưa có' }}</dd>
                </dl>
            </div>

            <div class="panel panel-pad mt-4">
                <h2 class="h5">Status Timeline</h2>
                @forelse ($order->statusHistories as $history)
                    <div class="border-top py-3">
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <div class="fw-semibold">
                                    {{ $history->from_status ? ucfirst($history->from_status).' to ' : '' }}{{ ucfirst($history->to_status) }}
                                </div>
                                @if ($history->note)
                                    <div class="text-muted small">{{ $history->note }}</div>
                                @endif
                                <div class="text-muted small">By {{ $history->changed_by_name ?? 'System' }}</div>
                            </div>
                            <div class="text-muted small text-end">{{ $history->created_at?->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-muted">No status history yet.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
