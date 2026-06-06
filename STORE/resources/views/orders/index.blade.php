@extends('layouts.app')

@section('title', 'Đơn hàng')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Đơn hàng của tôi</h1>
            <form method="GET">
                <select class="form-select" name="status" onchange="this.form.submit()">
                    <option value="">Tất cả</option>
                    @foreach (['pending', 'confirmed', 'shipping', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        @if ($orders->isEmpty())
            <div class="empty-state">Bạn chưa có đơn hàng nào.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Mã</th>
                            <th>Người nhận</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->display_final_price }}</td>
                                <td><span class="badge text-bg-secondary">{{ $order->status }}</span></td>
                                <td>{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="text-end"><a class="btn btn-outline-dark" href="{{ route('orders.show', $order) }}">Chi tiết</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $orders->links() }}
        @endif
    </div>
@endsection
