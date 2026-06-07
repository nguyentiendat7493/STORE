@extends('admin.layouts.app')

@section('title', 'Order #'.$order->id)

@section('content')
    <div class="row g-4">
        <div class="col-xl-4">
            <div class="panel panel-pad mb-4">
                <h2 class="h5">Customer</h2>
                <dl class="row mb-0">
                    <dt class="col-4">Name</dt><dd class="col-8">{{ $order->customer_name ?? $order->user?->name }}</dd>
                    <dt class="col-4">Phone</dt><dd class="col-8">{{ $order->customer_phone }}</dd>
                    <dt class="col-4">Address</dt><dd class="col-8">{{ $order->customer_address }}</dd>
                    <dt class="col-4">Coupon</dt><dd class="col-8">{{ $order->coupon?->code ?? 'None' }}</dd>
                </dl>
            </div>
            <div class="panel panel-pad">
                <h2 class="h5">Status</h2>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <select class="form-select mb-3" name="status">
                        @foreach (['pending', 'confirmed', 'shipping', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-dark w-100" type="submit">Update Order</button>
                </form>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="panel mb-4">
                <div class="panel-pad border-bottom"><h2 class="h5 mb-0">Items</h2></div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>Product</th><th>Variant</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
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
                <h2 class="h5">Totals</h2>
                <dl class="row mb-0">
                    <dt class="col-5">Total price</dt><dd class="col-7">{{ number_format((float) $order->total_price, 0, ',', '.') }}</dd>
                    <dt class="col-5">Discount</dt><dd class="col-7">{{ number_format((float) $order->discount_amount, 0, ',', '.') }}</dd>
                    <dt class="col-5">Shipping method</dt><dd class="col-7">{{ $order->shipping_method_name ?? 'None' }}</dd>
                    <dt class="col-5">Shipping fee</dt><dd class="col-7">{{ $order->display_shipping_fee }}</dd>
                    <dt class="col-5">Final price</dt><dd class="col-7 fw-bold">{{ $order->display_final_price }}</dd>
                    <dt class="col-5">Payment status</dt><dd class="col-7">{{ $order->payment?->payment_status ?? 'none' }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
