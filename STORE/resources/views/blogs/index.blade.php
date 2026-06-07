@extends('layouts.app')

@section('title', 'Journal')

@section('content')
    <section class="section-band">
        <div class="container-wide">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Journal</li>
                </ol>
            </nav>

            <div class="row g-4 align-items-end mb-5">
                <div class="col-lg-7">
                    <div class="eyebrow mb-2">Fashion Journal</div>
                    <h1 class="section-title mb-0">Stories, edits and styling notes</h1>
                </div>
                <div class="col-lg-5">
                    <form class="d-flex gap-2" method="GET">
                        <input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search journal">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
            </div>

            <div class="row g-4">
                <aside class="col-lg-3">
                    <div class="sidebar-box">
                        <div class="eyebrow mb-3">Categories</div>
                        <a class="d-block text-decoration-none mb-2" href="{{ route('blogs.index') }}">All posts</a>
                        @foreach ($categories as $category)
                            <a class="d-flex justify-content-between text-decoration-none mb-2" href="{{ route('blogs.index', ['blog_category_id' => $category->id]) }}">
                                <span>{{ $category->name }}</span>
                                <span class="text-muted">{{ $category->blogs_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </aside>

                <div class="col-lg-9">
                    <div class="row g-4">
                        @forelse ($posts as $post)
                            @php
                                $image = $post->image
                                    ? (str_starts_with($post->image, 'http') ? $post->image : asset('storage/'.$post->image))
                                    : 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=900&q=85';
                            @endphp
                            <div class="col-md-6 col-xl-4">
                                <article class="product-card h-100">
                                    <a class="text-decoration-none text-dark" href="{{ route('blogs.show', $post) }}">
                                        <div class="product-media">
                                            <img src="{{ $image }}" alt="{{ $post->title }}">
                                        </div>
                                        <div class="pt-3">
                                            <div class="eyebrow text-muted">{{ $post->category?->name ?? 'Journal' }}</div>
                                            <h2 class="h5 mt-2">{{ $post->title }}</h2>
                                            <p class="text-muted mb-0">{{ $post->excerpt }}</p>
                                        </div>
                                    </a>
                                </article>
                            </div>
                        @empty
                            <div class="col-12"><div class="empty-state">No journal posts found.</div></div>
                        @endforelse
                    </div>

                    <div class="mt-4">{{ $posts->links() }}</div>
                </div>
            </div>
        </div>
    </section>
@endsection
