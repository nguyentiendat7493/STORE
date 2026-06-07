@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="panel panel-pad">
                <div class="text-muted small text-uppercase fw-bold">Revenue</div>
                <div class="stat-value">{{ number_format((float) $totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="panel panel-pad">
                <div class="text-muted small text-uppercase fw-bold">Orders</div>
                <div class="stat-value">{{ $totalOrders }}</div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="panel panel-pad">
                <div class="text-muted small text-uppercase fw-bold">Customers</div>
                <div class="stat-value">{{ $totalCustomers }}</div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="panel panel-pad">
                <div class="text-muted small text-uppercase fw-bold">Products</div>
                <div class="stat-value">{{ $totalProducts }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="panel">
                <div class="panel-pad border-bottom">
                    <h2 class="h5 mb-0">Latest Orders</h2>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestOrders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->customer_name ?? $order->user?->name }}</td>
                                    <td><span class="badge text-bg-light">{{ $order->status }}</span></td>
                                    <td>{{ $order->display_final_price }}</td>
                                    <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.orders.show', $order) }}">View</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-muted">No orders yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="panel">
                <div class="panel-pad border-bottom">
                    <h2 class="h5 mb-0">Low Stock</h2>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Product</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lowStockVariants as $variant)
                                <tr>
                                    <td>{{ $variant->sku }}</td>
                                    <td>{{ $variant->product?->name }}</td>
                                    <td><span class="badge text-bg-warning">{{ $variant->stock }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-muted">No low stock variants.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
