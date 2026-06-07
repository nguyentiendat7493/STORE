@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container-wide py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('products.index') }}">Sản phẩm</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
        <div class="row g-5">
            <div class="col-lg-6">
                @php($main = $product->main_image)
                <img class="w-100 border" style="aspect-ratio:4/5;object-fit:cover" src="{{ $main ? asset('storage/'.$main) : 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $product->name }}">
                <div class="row g-2 mt-2">
                    @foreach ($product->images as $image)
                        <div class="col-3"><img class="w-100 border" style="aspect-ratio:1;object-fit:cover" src="{{ asset('storage/'.$image->image) }}" alt="{{ $product->name }}"></div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-sticky" style="top: 120px;">
                    <div class="eyebrow text-muted mb-3">{{ $product->category?->name }} {{ $product->brand ? ' / '.$product->brand->name : '' }}</div>
                    <h1 class="section-title mt-2 mb-3">{{ $product->name }}</h1>
                    <div class="fs-4 price mb-4">{{ $product->display_price }}</div>
                    <p class="section-kicker">{{ $product->description ?: 'Thiết kế tối giản, dễ phối và phù hợp cho nhiều hoàn cảnh trong ngày.' }}</p>
                    <div class="d-flex gap-2 flex-wrap mb-4">
                        <span class="badge badge-luxury rounded-0 px-3 py-2">SKU rõ ràng</span>
                        <span class="badge badge-luxury rounded-0 px-3 py-2">Kiểm tra tồn kho</span>
                        <span class="badge badge-luxury rounded-0 px-3 py-2">Đổi trả linh hoạt</span>
                    </div>

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
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="submit" @disabled($product->variants->sum('stock') <= 0)>Thêm vào giỏ</button>
                                <button class="btn btn-outline-dark" type="submit" formaction="{{ route('wishlist.store', $product) }}">Wishlist</button>
                            </div>
                        </form>
                    @else
                        <a class="btn btn-primary mt-3" href="{{ route('login') }}">Đăng nhập để mua hàng</a>
                    @endauth

                    <div class="accordion accordion-flush mt-4" id="productTabs">
                        <div class="accordion-item">
                            <h2 class="accordion-header"><button class="accordion-button px-0" type="button" data-bs-toggle="collapse" data-bs-target="#desc">Mô tả</button></h2>
                            <div id="desc" class="accordion-collapse collapse show" data-bs-parent="#productTabs"><div class="accordion-body px-0">{{ $product->description ?: 'Sản phẩm thuộc dòng tối giản cao cấp, dễ kết hợp trong nhiều bản phối.' }}</div></div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header"><button class="accordion-button collapsed px-0" type="button" data-bs-toggle="collapse" data-bs-target="#sizeGuide">Hướng dẫn chọn size</button></h2>
                            <div id="sizeGuide" class="accordion-collapse collapse" data-bs-parent="#productTabs"><div class="accordion-body px-0">Chọn size theo số đo cơ thể. Nếu nằm giữa hai size, hãy ưu tiên size lớn hơn cho cảm giác thoải mái.</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="section-band">
            <div class="row g-4 align-items-start">
                <div class="col-lg-5">
                    <div class="eyebrow mb-2">Customer Reviews</div>
                    <h2 class="section-title mb-3">What shoppers say</h2>
                    <div class="fs-4 mb-2">
                        <span class="text-warning">{{ str_repeat('★', (int) round($reviewSummary['average'])) }}</span><span class="text-muted">{{ str_repeat('☆', 5 - (int) round($reviewSummary['average'])) }}</span>
                    </div>
                    <p class="section-kicker">{{ $reviewSummary['count'] }} approved reviews · Average {{ number_format($reviewSummary['average'], 1) }}/5</p>

                    @auth
                        <form class="sidebar-box mt-4" method="POST" action="{{ route('reviews.store', $product) }}">
                            @csrf
                            <label class="form-label">Your rating</label>
                            <select class="form-select mb-3" name="rating" required>
                                @for ($rating = 5; $rating >= 1; $rating--)
                                    <option value="{{ $rating }}">{{ $rating }} stars</option>
                                @endfor
                            </select>
                            <label class="form-label">Your review</label>
                            <textarea class="form-control mb-3" name="comment" rows="4" placeholder="Share fit, fabric, styling notes or delivery feedback.">{{ old('comment') }}</textarea>
                            <button class="btn btn-primary w-100" type="submit">Submit Review</button>
                            <div class="form-text mt-2">Reviews appear after admin approval.</div>
                        </form>
                    @else
                        <a class="btn btn-outline-dark mt-3" href="{{ route('login') }}">Login to review</a>
                    @endauth
                </div>

                <div class="col-lg-7">
                    <div class="d-grid gap-3">
                        @forelse ($product->reviews as $review)
                            <article class="editorial-card p-4">
                                <div class="d-flex justify-content-between gap-3 mb-2">
                                    <div>
                                        <div class="fw-semibold">{{ $review->user?->name }}</div>
                                        <div class="text-muted small">{{ $review->created_at?->format('Y-m-d') }}</div>
                                    </div>
                                    <div class="text-warning">{{ str_repeat('★', $review->rating) }}<span class="text-muted">{{ str_repeat('☆', 5 - $review->rating) }}</span></div>
                                </div>
                                <p class="mb-0">{{ $review->comment }}</p>
                            </article>
                        @empty
                            <div class="empty-state">No approved reviews yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <section class="section-band">
            <div class="eyebrow mb-2">You may also like</div>
            <h2 class="section-title mb-4">Sản phẩm liên quan</h2>
            <div class="row g-4">
                @foreach ($relatedProducts as $related)
                    <div class="col-6 col-lg-3">@include('components.product-card', ['product' => $related])</div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
