@extends('layouts.app')

@section('title', $page->seo_title)

@section('content')
    <section class="section-band">
        <div class="container-wide">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
                </ol>
            </nav>

            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">
                    <div class="eyebrow mb-3">{{ ucfirst($page->template) }}</div>
                    <h1 class="section-title mb-4">{{ $page->title }}</h1>
                    @if ($page->excerpt)
                        <p class="lead section-kicker mb-5">{{ $page->excerpt }}</p>
                    @endif
                    <article class="fs-5 lh-lg">
                        {!! nl2br(e($page->content)) !!}
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection
