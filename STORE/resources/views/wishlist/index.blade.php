@extends('layouts.app')

@section('title', 'Wishlist')

@section('content')
    <section class="section-band">
        <div class="container-wide">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                </ol>
            </nav>

            <div class="row g-4 align-items-end mb-5">
                <div class="col-lg-8">
                    <div class="eyebrow mb-2">Account</div>
                    <h1 class="section-title mb-0">Your Wishlist</h1>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a class="btn btn-outline-dark" href="{{ route('products.index') }}">Continue Shopping</a>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($wishlists as $wishlist)
                    <div class="col-6 col-lg-3">
                        <div class="h-100">
                            @include('components.product-card', ['product' => $wishlist->product])
                            <form class="mt-3" method="POST" action="{{ route('wishlist.destroy', $wishlist->product) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-dark w-100" type="submit">Remove</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            Your wishlist is empty.
                            <a class="ms-2" href="{{ route('products.index') }}">Browse products</a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">{{ $wishlists->links() }}</div>
        </div>
    </section>
@endsection
