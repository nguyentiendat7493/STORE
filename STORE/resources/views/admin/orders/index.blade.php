@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-lg-7"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search customer name, phone, address"></div>
            <div class="col-lg-3">
                <select class="form-select" name="status">
                    <option value="">All statuses</option>
                    @foreach (['pending', 'confirmed', 'shipping', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2"><button class="btn btn-dark w-100" type="submit">Filter</button></div>
        </form>
    </div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>ID</th><th>Customer</th><th>Phone</th><th>Status</th><th>Payment</th><th>Total</th><th>Created</th><th></th></tr></thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->customer_name ?? $order->user?->name }}</td>
                            <td>{{ $order->customer_phone }}</td>
                            <td><span class="badge text-bg-light">{{ $order->status }}</span></td>
                            <td>{{ $order->payment?->payment_status ?? 'none' }}</td>
                            <td>{{ $order->display_final_price }}</td>
                            <td>{{ $order->created_at?->format('Y-m-d') }}</td>
                            <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.orders.show', $order) }}">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-muted p-4">No orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $orders->links() }}</div>
    </div>
@endsection
