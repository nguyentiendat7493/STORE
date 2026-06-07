@extends('layouts.app')

@section('title', ($siteSettings['site_name'] ?? 'STORE').' - Home')

@section('content')
    @php
        $heroImage = $heroBanner?->image
            ? (str_starts_with($heroBanner->image, 'http') ? $heroBanner->image : asset('storage/'.$heroBanner->image))
            : 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=2200&q=85';
    @endphp

    <section class="hero" style="background-image: linear-gradient(90deg, rgba(0,0,0,.48), rgba(0,0,0,.12)), url('{{ $heroImage }}');">
        <div class="container-wide">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <p class="eyebrow mb-3">New Season Collection</p>
                    <h1 class="editorial-title mb-4">{{ $heroBanner?->title ?? 'Quiet Luxury For Every Day' }}</h1>
                    <p class="lead mb-4 col-lg-7">{{ $heroBanner?->subtitle ?? 'Minimal silhouettes, refined materials and a modern wardrobe edited for daily life.' }}</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a class="btn btn-light btn-lg" href="{{ $heroBanner?->button_url ?: route('products.index') }}">{{ $heroBanner?->button_text ?: 'Explore Collection' }}</a>
                        <a class="btn btn-outline-light btn-lg" href="{{ route('products.index', ['sort' => 'newest']) }}">New Arrival</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($promoBanners->isNotEmpty())
        <section class="section-band soft-band">
            <div class="container-wide">
                <div class="row g-3">
                    @foreach ($promoBanners as $banner)
                        @php
                            $image = $banner->image
                                ? (str_starts_with($banner->image, 'http') ? $banner->image : asset('storage/'.$banner->image))
                                : 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=1000&q=85';
                        @endphp
                        <div class="col-md-4">
                            <a class="editorial-card d-block text-decoration-none text-dark h-100 overflow-hidden" href="{{ $banner->button_url ?: route('products.index') }}">
                                <img class="w-100" style="aspect-ratio: 16 / 10; object-fit: cover" src="{{ $image }}" alt="{{ $banner->title }}">
                                <div class="p-4">
                                    <div class="eyebrow text-muted mb-2">{{ str_replace('_', ' ', $banner->position) }}</div>
                                    <h2 class="h4 mb-2" style="font-family: var(--font-editorial);">{{ $banner->title }}</h2>
                                    @if ($banner->subtitle)
                                        <p class="text-muted mb-0">{{ $banner->subtitle }}</p>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section-band">
        <div class="container-wide">
            <div class="row g-4 align-items-end mb-4">
                <div class="col-lg-7">
                    <div class="eyebrow mb-2">Featured Collection</div>
                    <h2 class="section-title mb-0">Curated Collections</h2>
                </div>
                <div class="col-lg-5">
                    <p class="section-kicker mb-0">A magazine-minded approach to fashion: fewer choices, sharper edits, and a clearer point of view.</p>
                </div>
            </div>
            <div class="row g-3">
                @forelse ($categories as $category)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="editorial-card d-block text-decoration-none text-dark h-100 p-4">
                            <div class="eyebrow text-muted mb-4">{{ $category->products_count }} products</div>
                            <div class="h4 mb-0" style="font-family: var(--font-editorial);">{{ $category->name }}</div>
                        </a>
                    </div>
                @empty
                    <div class="col-12"><div class="empty-state">No categories yet.</div></div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section-band soft-band">
        <div class="container-wide">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <div class="eyebrow mb-2">New Arrival</div>
                    <h2 class="section-title mb-0">Just In</h2>
                </div>
                <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="btn btn-outline-dark">View All</a>
            </div>
            <div class="row g-4">
                @forelse ($newProducts as $product)
                    <div class="col-6 col-lg-3">@include('components.product-card', ['product' => $product])</div>
                @empty
                    <div class="col-12"><div class="empty-state">No products yet.</div></div>
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
                    <p class="section-kicker mb-4">A quiet European styling mood: sharp outerwear, straight-leg trousers and light layers with restraint.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">View Lookbook</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-band soft-band">
        <div class="container-wide">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <div class="eyebrow mb-2">Sale Edit</div>
                    <h2 class="section-title mb-0">On Sale</h2>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-outline-dark">Shop Deals</a>
            </div>
            <div class="row g-4">
                @forelse ($discountProducts as $product)
                    <div class="col-6 col-lg-3">@include('components.product-card', ['product' => $product])</div>
                @empty
                    <div class="col-12"><div class="empty-state">No discounted products yet.</div></div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section-band">
        <div class="container-wide text-center">
            <div class="eyebrow mb-3">Brand Story</div>
            <h2 class="section-title mx-auto mb-4" style="max-width: 820px;">Minimal does not mean less. It means keeping what deserves to stay.</h2>
            <p class="section-kicker mx-auto mb-4">STORE builds a seasonless wardrobe through calm design language, wearable fabrics and a dependable shopping experience.</p>
            <a class="btn btn-outline-dark" href="{{ route('products.index') }}">About The Edit</a>
        </div>
    </section>
@endsection
