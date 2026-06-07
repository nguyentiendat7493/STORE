@extends('admin.layouts.app')

@section('title', 'Payments')

@section('content')
    <div class="panel panel-pad mb-3">
        <form class="row g-2" method="GET">
            <div class="col-md-5">
                <select class="form-select" name="payment_method">
                    <option value="">All methods</option>
                    @foreach (['cod', 'bank_transfer', 'momo', 'vnpay'] as $method)
                        <option value="{{ $method }}" @selected(request('payment_method') === $method)>{{ $method }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <select class="form-select" name="payment_status">
                    <option value="">All statuses</option>
                    @foreach (['unpaid', 'paid', 'failed'] as $status)
                        <option value="{{ $status }}" @selected(request('payment_status') === $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-dark w-100" type="submit">Filter</button></div>
        </form>
    </div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>ID</th><th>Order</th><th>Customer</th><th>Method</th><th>Status</th><th>Paid At</th><th></th></tr></thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>#{{ $payment->order_id }}</td>
                            <td>{{ $payment->order?->customer_name ?? $payment->order?->user?->name }}</td>
                            <td>{{ $payment->payment_method }}</td>
                            <td><span class="badge text-bg-light">{{ $payment->payment_status }}</span></td>
                            <td>{{ $payment->paid_at?->format('Y-m-d H:i') }}</td>
                            <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.payments.show', $payment) }}">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-muted p-4">No payments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-pad">{{ $payments->links() }}</div>
    </div>
@endsection
