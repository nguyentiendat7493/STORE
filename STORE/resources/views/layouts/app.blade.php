<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'STORE')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --ink: #202124; --muted: #6f7782; --line: #e5e7eb; --soft: #f7f7f5; --accent: #136f63; }
        body { color: var(--ink); background: #fff; }
        .topbar { background: #111827; color: #fff; font-size: .875rem; }
        .navbar { border-bottom: 1px solid var(--line); }
        .brand-mark { font-weight: 800; letter-spacing: .08em; }
        .hero { min-height: 420px; background: linear-gradient(100deg, rgba(19,111,99,.95), rgba(32,33,36,.72)), url('https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=1800&q=80') center/cover; color: #fff; display: flex; align-items: center; }
        .section-title { font-size: 1.35rem; font-weight: 750; }
        .product-card { border: 1px solid var(--line); border-radius: 8px; overflow: hidden; height: 100%; background: #fff; }
        .product-card img { width: 100%; aspect-ratio: 4 / 5; object-fit: cover; background: var(--soft); }
        .price { color: var(--accent); font-weight: 750; }
        .old-price { color: var(--muted); text-decoration: line-through; font-size: .92rem; }
        .sidebar-box { border: 1px solid var(--line); border-radius: 8px; padding: 1rem; }
        .form-control, .form-select, .btn { border-radius: 6px; }
        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: #0f5d53; border-color: #0f5d53; }
        .footer { background: #111827; color: #d1d5db; }
        .empty-state { border: 1px dashed var(--line); border-radius: 8px; padding: 2rem; background: var(--soft); }
    </style>
</head>
<body>
    @include('partials.header')
    @include('partials.navbar')

    <main>
        @if (session('success'))
            <div class="container mt-3">
                <div class="alert alert-success mb-0">{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="container mt-3">
                <div class="alert alert-danger mb-0">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
