<div class="product-card">
    <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
        @php($image = $product->main_image)
        <div class="product-media">
            @if ($product->sale_price)
                <span class="product-badge">Sale</span>
            @else
                <span class="product-badge">New</span>
            @endif
            <div class="product-actions">
                <span class="product-action" aria-label="Yêu thích"><i class="bi bi-heart"></i></span>
                <span class="product-action" aria-label="Xem nhanh"><i class="bi bi-eye"></i></span>
            </div>
            <img src="{{ $image ? asset('storage/'.$image) : 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=700&q=80' }}" alt="{{ $product->name }}">
        </div>
    </a>
    <div class="pt-3">
        <div class="eyebrow text-muted">{{ $product->category?->name }} {{ $product->brand ? ' / '.$product->brand->name : '' }}</div>
        <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark fw-semibold d-block mt-2">{{ $product->name }}</a>
        <div class="mt-1">
            <span class="price">{{ $product->display_price }}</span>
            @if ($product->sale_price)
                <span class="old-price ms-2">{{ number_format((float) $product->price, 0, ',', '.') }} VND</span>
            @endif
        </div>
        @auth
            <form class="mt-3" method="POST" action="{{ route('wishlist.store', $product) }}">
                @csrf
                <button class="btn btn-outline-dark w-100" type="submit"><i class="bi bi-heart me-1"></i> Wishlist</button>
            </form>
        @endauth
    </div>
</div>
