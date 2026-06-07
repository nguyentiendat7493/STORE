@extends('admin.layouts.app')

@section('title', 'Payment #'.$payment->id)

@section('content')
    <div class="panel panel-pad" style="max-width: 720px">
        <form method="POST" action="{{ route('admin.payments.update', $payment) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Payment method</label>
                <select class="form-select" name="payment_method">
                    @foreach (['cod', 'bank_transfer', 'momo', 'vnpay'] as $method)
                        <option value="{{ $method }}" @selected($payment->payment_method === $method)>{{ $method }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Payment status</label>
                <select class="form-select" name="payment_status">
                    @foreach (['unpaid', 'paid', 'failed'] as $status)
                        <option value="{{ $status }}" @selected($payment->payment_status === $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Paid at</label>
                <input class="form-control" type="datetime-local" name="paid_at" value="{{ $payment->paid_at?->format('Y-m-d\\TH:i') }}">
            </div>
            <button class="btn btn-dark" type="submit">Update Payment</button>
            <a class="btn btn-outline-dark" href="{{ route('admin.orders.show', $payment->order) }}">Open Order</a>
        </form>
    </div>
@endsection
