@extends('admin.layouts.app')

@section('title', 'Customer Detail')

@section('content')
    <div class="row g-4">
        <div class="col-xl-4">
            <div class="panel panel-pad">
                <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="name" value="{{ old('name', $customer->name) }}"></div>
                    <div class="mb-3"><label class="form-label">Email</label><input class="form-control" name="email" value="{{ old('email', $customer->email) }}"></div>
                    <div class="mb-3"><label class="form-label">Phone</label><input class="form-control" name="phone" value="{{ old('phone', $customer->phone) }}"></div>
                    <div class="mb-3"><label class="form-label">Address</label><textarea class="form-control" name="address" rows="3">{{ old('address', $customer->address) }}</textarea></div>
                    <button class="btn btn-dark w-100" type="submit">Update Customer</button>
                </form>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="panel">
                <div class="panel-pad border-bottom"><h2 class="h5 mb-0">Recent Orders</h2></div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>ID</th><th>Status</th><th>Total</th><th>Created</th><th></th></tr></thead>
                        <tbody>
                            @forelse ($customer->orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->display_final_price }}</td>
                                    <td>{{ $order->created_at?->format('Y-m-d') }}</td>
                                    <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.orders.show', $order) }}">View</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-muted p-4">No orders for this customer.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
