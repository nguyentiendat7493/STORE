@extends('layouts.app')

@section('title', $blog->seo_title)

@section('content')
    @php
        $image = $blog->image
            ? (str_starts_with($blog->image, 'http') ? $blog->image : asset('storage/'.$blog->image))
            : 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=1400&q=85';
    @endphp

    <article>
        <section class="section-band pb-4">
            <div class="container-wide">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('blogs.index') }}">Journal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $blog->title }}</li>
                    </ol>
                </nav>

                <div class="row justify-content-center text-center">
                    <div class="col-lg-9">
                        <div class="eyebrow mb-3">{{ $blog->category?->name ?? 'Journal' }}</div>
                        <h1 class="section-title mb-4">{{ $blog->title }}</h1>
                        @if ($blog->excerpt)
                            <p class="lead section-kicker mx-auto mb-4">{{ $blog->excerpt }}</p>
                        @endif
                        <div class="text-muted small">{{ $blog->published_at?->format('F j, Y') }} · {{ $blog->author?->name }}</div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container-wide">
            <img class="w-100" style="max-height: 620px; object-fit: cover" src="{{ $image }}" alt="{{ $blog->title }}">
        </div>

        <section class="section-band">
            <div class="container-wide">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="fs-5 lh-lg">{!! nl2br(e($blog->content)) !!}</div>
                    </div>
                </div>
            </div>
        </section>
    </article>

    @if ($relatedPosts->isNotEmpty())
        <section class="section-band soft-band">
            <div class="container-wide">
                <div class="eyebrow mb-2">Related</div>
                <h2 class="section-title mb-4">More from the journal</h2>
                <div class="row g-4">
                    @foreach ($relatedPosts as $post)
                        <div class="col-md-4">
                            <a class="editorial-card d-block text-decoration-none text-dark h-100 p-4" href="{{ route('blogs.show', $post) }}">
                                <div class="eyebrow text-muted mb-3">{{ $post->category?->name ?? 'Journal' }}</div>
                                <h3 class="h4" style="font-family: var(--font-editorial);">{{ $post->title }}</h3>
                                <p class="text-muted mb-0">{{ $post->excerpt }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
