@extends('layouts.app')

@section('title', 'STORE - Trang chủ')

@section('content')
    <section class="hero">
        <div class="container-wide">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <p class="eyebrow mb-3">New Season Collection</p>
                    <h1 class="editorial-title mb-4">Quiet Luxury<br>For Every Day</h1>
                    <p class="lead mb-4 col-lg-7">Những phom dáng tối giản, chất liệu tinh tế và bảng màu được biên tập cho tủ đồ hiện đại.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a class="btn btn-light btn-lg" href="{{ route('products.index') }}">Khám phá bộ sưu tập</a>
                        <a class="btn btn-outline-light btn-lg" href="{{ route('products.index', ['sort' => 'newest']) }}">New Arrival</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-band">
        <div class="container-wide">
            <div class="row g-4 align-items-end mb-4">
                <div class="col-lg-7">
                    <div class="eyebrow mb-2">Featured Collection</div>
                    <h2 class="section-title mb-0">Bộ sưu tập được chọn lọc</h2>
                </div>
                <div class="col-lg-5">
                    <p class="section-kicker mb-0">Cách tiếp cận thời trang như một tạp chí: ít hơn, sắc hơn, và có chủ đích trong từng lựa chọn.</p>
                </div>
            </div>
            <div class="row g-3">
                @forelse ($categories as $category)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="editorial-card d-block text-decoration-none text-dark h-100 p-4">
                            <div class="eyebrow text-muted mb-4">{{ $category->products_count }} sản phẩm</div>
                            <div class="h4 mb-0" style="font-family: var(--font-editorial);">{{ $category->name }}</div>
                        </a>
                    </div>
                @empty
                    <div class="col-12"><div class="empty-state">Chưa có danh mục.</div></div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section-band soft-band">
        <div class="container-wide">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <div class="eyebrow mb-2">New Arrival</div>
                    <h2 class="section-title mb-0">Vừa ra mắt</h2>
                </div>
                <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="btn btn-outline-dark">Xem tất cả</a>
            </div>
            <div class="row g-4">
                @forelse ($newProducts as $product)
                    <div class="col-6 col-lg-3">@include('components.product-card', ['product' => $product])</div>
                @empty
                    <div class="col-12"><div class="empty-state">Chưa có sản phẩm.</div></div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section-band">
        <div class="container-wide">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <img class="w-100" style="aspect-ratio: 4 / 5; object-fit: cover;" src="https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=1200&q=85" alt="Editorial lookbook">
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="eyebrow mb-3">Lookbook</div>
                    <h2 class="section-title mb-4">The Editorial Wardrobe</h2>
                    <p class="section-kicker mb-4">Gợi ý phối đồ theo tinh thần tối giản châu Âu: áo khoác sắc nét, quần phom đứng và những lớp layer nhẹ.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Xem lookbook</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-band soft-band">
        <div class="container-wide">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <div class="eyebrow mb-2">Sale Edit</div>
                    <h2 class="section-title mb-0">Đang giảm giá</h2>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-outline-dark">Mua ưu đãi</a>
            </div>
            <div class="row g-4">
                @forelse ($discountProducts as $product)
                    <div class="col-6 col-lg-3">@include('components.product-card', ['product' => $product])</div>
                @empty
                    <div class="col-12"><div class="empty-state">Chưa có sản phẩm giảm giá.</div></div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section-band">
        <div class="container-wide text-center">
            <div class="eyebrow mb-3">Brand Story</div>
            <h2 class="section-title mx-auto mb-4" style="max-width: 820px;">Tinh giản không phải là ít đi, mà là giữ lại những gì xứng đáng.</h2>
            <p class="section-kicker mx-auto mb-4">STORE xây dựng tủ đồ vượt mùa với ngôn ngữ thiết kế điềm tĩnh, chất liệu dễ mặc và trải nghiệm mua sắm đáng tin cậy.</p>
            <a class="btn btn-outline-dark" href="#">Về chúng tôi</a>
        </div>
    </section>
@endsection
