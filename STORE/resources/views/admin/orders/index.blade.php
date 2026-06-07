@extends('admin.layouts.app')

@section('title', 'Đơn hàng')

@section('content')
    @php
        $statusLabels = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'shipping' => 'Đang giao',
            'completed' => 'Hoàn tất',
            'cancelled' => 'Đã hủy',
        ];

        $paymentLabels = [
            'unpaid' => 'Chưa thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thất bại',
        ];
    @endphp

    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-lg-7"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Tìm tên, số điện thoại, địa chỉ"></div>
            <div class="col-lg-3">
                <select class="form-select" name="status">
                    <option value="">Tất cả trạng thái</option>
                    @foreach ($statusLabels as $status => $label)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2"><button class="btn btn-dark w-100" type="submit">Lọc</button></div>
        </form>
    </div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>ID</th><th>Khách hàng</th><th>Điện thoại</th><th>Trạng thái</th><th>Thanh toán</th><th>Tổng tiền</th><th>Ngày tạo</th><th></th></tr></thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->customer_name ?? $order->user?->name }}</td>
                            <td>{{ $order->customer_phone }}</td>
                            <td><span class="badge text-bg-light">{{ $statusLabels[$order->status] ?? $order->status }}</span></td>
                            <td>{{ $paymentLabels[$order->payment?->payment_status] ?? 'Chưa có' }}</td>
                            <td>{{ $order->display_final_price }}</td>
                            <td>{{ $order->created_at?->format('d/m/Y') }}</td>
                            <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.orders.show', $order) }}">Xem</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-muted p-4">Chưa có đơn hàng nào.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $orders->links() }}</div>
    </div>
@endsection
