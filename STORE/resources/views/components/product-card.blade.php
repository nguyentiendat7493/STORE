<div class="product-card">
    <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
        @php($image = $product->main_image)
        <img src="{{ $image ? asset('storage/'.$image) : 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=700&q=80' }}" alt="{{ $product->name }}">
    </a>
    <div class="p-3">
        <div class="small text-muted">{{ $product->category?->name }} {{ $product->brand ? ' / '.$product->brand->name : '' }}</div>
        <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark fw-semibold d-block mt-1">{{ $product->name }}</a>
        <div class="mt-2">
            <span class="price">{{ $product->display_price }}</span>
            @if ($product->sale_price)
                <span class="old-price ms-2">{{ number_format((float) $product->price, 0, ',', '.') }} VND</span>
            @endif
        </div>
    </div>
</div>
