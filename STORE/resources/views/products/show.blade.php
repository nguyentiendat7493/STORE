@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-6">
                @php($main = $product->main_image)
                <img class="w-100 rounded border" style="aspect-ratio:4/5;object-fit:cover" src="{{ $main ? asset('storage/'.$main) : 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $product->name }}">
                <div class="row g-2 mt-2">
                    @foreach ($product->images as $image)
                        <div class="col-3"><img class="w-100 rounded border" style="aspect-ratio:1;object-fit:cover" src="{{ asset('storage/'.$image->image) }}" alt="{{ $product->name }}"></div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-muted">{{ $product->category?->name }} {{ $product->brand ? ' / '.$product->brand->name : '' }}</div>
                <h1 class="h2 mt-2">{{ $product->name }}</h1>
                <div class="fs-4 price mb-3">{{ $product->display_price }}</div>
                <p>{{ $product->description }}</p>

                @auth
                    <form action="{{ route('cart.add') }}" method="POST" class="sidebar-box mt-4">
                        @csrf
                        <label class="form-label">Biến thể</label>
                        <select class="form-select mb-3" name="product_variant_id" required>
                            @foreach ($product->variants as $variant)
                                <option value="{{ $variant->id }}" @disabled($variant->stock <= 0)>
                                    {{ $variant->size?->name }} / {{ $variant->color?->name }} - {{ $variant->display_price }} - Tồn: {{ $variant->stock }}
                                </option>
                            @endforeach
                        </select>
                        <label class="form-label">Số lượng</label>
                        <input class="form-control mb-3" type="number" name="quantity" min="1" value="1">
                        <button class="btn btn-primary w-100" type="submit" @disabled($product->variants->sum('stock') <= 0)>Thêm vào giỏ</button>
                    </form>
                @else
                    <a class="btn btn-primary mt-3" href="{{ route('login') }}">Đăng nhập để mua hàng</a>
                @endauth
            </div>
        </div>

        <section class="mt-5">
            <h2 class="section-title mb-3">Sản phẩm liên quan</h2>
            <div class="row g-4">
                @foreach ($relatedProducts as $related)
                    <div class="col-6 col-lg-3">@include('components.product-card', ['product' => $related])</div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
