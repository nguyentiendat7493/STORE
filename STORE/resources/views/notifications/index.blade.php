@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <section class="section-band">
        <div class="container-wide">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                </ol>
            </nav>

            <div class="row g-4 align-items-end mb-5">
                <div class="col-lg-8">
                    <div class="eyebrow mb-2">Account</div>
                    <h1 class="section-title mb-0">Notifications</h1>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <form method="POST" action="{{ route('notifications.read-all') }}">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-outline-dark" type="submit">Mark All Read</button>
                    </form>
                </div>
            </div>

            <div class="d-grid gap-3">
                @forelse ($notifications as $notification)
                    <article class="editorial-card p-4 {{ $notification->read_at ? '' : 'border-dark' }}">
                        <div class="row g-3 align-items-start">
                            <div class="col-lg-9">
                                <div class="eyebrow text-muted mb-2">{{ $notification->type }}</div>
                                <h2 class="h5 mb-2">{{ $notification->title }}</h2>
                                <p class="mb-2">{{ $notification->message }}</p>
                                <div class="text-muted small">{{ $notification->created_at?->format('Y-m-d H:i') }} · {{ $notification->read_at ? 'Read' : 'Unread' }}</div>
                            </div>
                            <div class="col-lg-3 text-lg-end">
                                <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-primary" type="submit">{{ ! empty($notification->data['url']) ? 'Open' : 'Mark Read' }}</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">No notifications yet.</div>
                @endforelse
            </div>

            <div class="mt-4">{{ $notifications->links() }}</div>
        </div>
    </section>
@endsection
