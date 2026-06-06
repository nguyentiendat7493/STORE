@extends('layouts.app')

@section('title', 'Sản phẩm')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Sản phẩm</h1>
            <div class="text-muted small">{{ $products->total() }} kết quả</div>
        </div>

        <div class="row g-4">
            <aside class="col-lg-3">
                <form class="sidebar-box" method="GET" action="{{ route('products.index') }}">
                    <div class="mb-3">
                        <label class="form-label">Từ khóa</label>
                        <input class="form-control" name="q" value="{{ request('q') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select class="form-select" name="category_id">
                            <option value="">Tất cả</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thương hiệu</label>
                        <select class="form-select" name="brand_id">
                            <option value="">Tất cả</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @selected(request('brand_id') == $brand->id)>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col">
                            <label class="form-label">Giá từ</label>
                            <input class="form-control" name="min_price" value="{{ request('min_price') }}">
                        </div>
                        <div class="col">
                            <label class="form-label">Den</label>
                            <input class="form-control" name="max_price" value="{{ request('max_price') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giới tính</label>
                        <select class="form-select" name="gender">
                            <option value="">Tất cả</option>
                            @foreach (['male' => 'Nam', 'female' => 'Nữ', 'unisex' => 'Unisex', 'kids' => 'Trẻ em'] as $value => $label)
                                <option value="{{ $value }}" @selected(request('gender') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Size</label>
                        <select class="form-select" name="size_id">
                            <option value="">Tất cả</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}" @selected(request('size_id') == $size->id)>{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Màu</label>
                        <select class="form-select" name="color_id">
                            <option value="">Tất cả</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}" @selected(request('color_id') == $color->id)>{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sắp xếp</label>
                        <select class="form-select" name="sort">
                            <option value="newest" @selected(request('sort') === 'newest')>Mới nhất</option>
                            <option value="price_asc" @selected(request('sort') === 'price_asc')>Giá tăng dần</option>
                            <option value="price_desc" @selected(request('sort') === 'price_desc')>Giá giảm dần</option>
                        </select>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Lọc</button>
                </form>
            </aside>

            <div class="col-lg-9">
                <div class="row g-4">
                    @forelse ($products as $product)
                        <div class="col-6 col-xl-4">@include('components.product-card', ['product' => $product])</div>
                    @empty
                        <div class="col-12"><div class="empty-state">Không tìm thấy sản phẩm.</div></div>
                    @endforelse
                </div>
                <div class="mt-4">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
@endsection
