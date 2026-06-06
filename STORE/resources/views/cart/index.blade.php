@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
    <div class="container py-4">
        <h1 class="h3 mb-4">Giỏ hàng</h1>
        @if ($cart->items->isEmpty())
            <div class="empty-state">Giỏ hàng đang trống. <a href="{{ route('products.index') }}">Mua sắm ngay</a></div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Biến thể</th>
                            <th>Giá</th>
                            <th style="width:160px">Số lượng</th>
                            <th>Tạm tính</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart->items as $item)
                            <tr>
                                <td>{{ $item->productVariant->product->name }}</td>
                                <td>{{ $item->productVariant->size?->name }} / {{ $item->productVariant->color?->name }}</td>
                                <td>{{ $item->productVariant->display_price }}</td>
                                <td>
                                    <form class="d-flex gap-2" method="POST" action="{{ route('cart.update', $item) }}">
                                        @csrf
                                        @method('PUT')
                                        <input class="form-control" type="number" min="1" name="quantity" value="{{ $item->quantity }}">
                                        <button class="btn btn-outline-dark" type="submit">Lưu</button>
                                    </form>
                                </td>
                                <td>{{ $item->display_subtotal }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('cart.remove', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger" type="submit">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                <div class="sidebar-box" style="min-width:280px">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tổng tiền</span>
                        <strong>{{ $cart->display_total }}</strong>
                    </div>
                    <a class="btn btn-primary w-100" href="{{ route('checkout.index') }}">Thanh toán</a>
                </div>
            </div>
        @endif
    </div>
@endsection
