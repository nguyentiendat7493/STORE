@extends('layouts.app')

@section('title', 'STORE - Trang chủ')

@section('content')
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <p class="text-uppercase small fw-bold mb-2">New season</p>
                    <h1 class="display-5 fw-bold">STORE</h1>
                    <p class="lead mb-4">Quần áo hằng ngày với form dễ mặc, màu dễ phối và biến thể size/màu rõ ràng.</p>
                    <a class="btn btn-light btn-lg" href="{{ route('products.index') }}">Mua ngay</a>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-3">
            <h2 class="section-title mb-0">Danh mục nổi bật</h2>
            <a href="{{ route('products.index') }}" class="text-dark">Xem sản phẩm</a>
        </div>
        <div class="row g-3">
            @forelse ($categories as $category)
                <div class="col-6 col-md-3">
                    <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="sidebar-box d-block text-decoration-none text-dark h-100">
                        <div class="fw-semibold">{{ $category->name }}</div>
                        <div class="small text-muted">{{ $category->products_count }} sản phẩm</div>
                    </a>
                </div>
            @empty
                <div class="col-12"><div class="empty-state">Chưa có danh mục.</div></div>
            @endforelse
        </div>
    </section>

    <section class="container pb-5">
        <h2 class="section-title mb-3">Sản phẩm mới</h2>
        <div class="row g-4">
            @forelse ($newProducts as $product)
                <div class="col-6 col-lg-3">@include('components.product-card', ['product' => $product])</div>
            @empty
                <div class="col-12"><div class="empty-state">Chưa có sản phẩm.</div></div>
            @endforelse
        </div>
    </section>

    <section class="container pb-5">
        <h2 class="section-title mb-3">Đang giảm giá</h2>
        <div class="row g-4">
            @forelse ($discountProducts as $product)
                <div class="col-6 col-lg-3">@include('components.product-card', ['product' => $product])</div>
            @empty
                <div class="col-12"><div class="empty-state">Chưa có sản phẩm giảm giá.</div></div>
            @endforelse
        </div>
    </section>
@endsection
