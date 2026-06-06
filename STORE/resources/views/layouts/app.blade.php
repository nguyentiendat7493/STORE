<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'STORE')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --brand-black: #111111;
            --brand-white: #ffffff;
            --neutral-50: #f8f7f4;
            --neutral-100: #f5f5f5;
            --neutral-200: #e5e5e5;
            --neutral-300: #d9d9d9;
            --muted: #6f6f6f;
            --accent: #d6c4a1;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --font-body: "Inter", system-ui, sans-serif;
            --font-editorial: "Cormorant Garamond", Georgia, serif;
        }

        body {
            color: var(--brand-black);
            background: var(--brand-white);
            font-family: var(--font-body);
            letter-spacing: 0;
        }

        a { color: inherit; }
        img { max-width: 100%; }
        .page-shell { min-height: 60vh; }
        .container-wide { width: min(100% - 32px, 1480px); margin-inline: auto; }
        .topbar { background: var(--brand-black); color: var(--brand-white); font-size: .78rem; letter-spacing: .06em; text-transform: uppercase; }
        .luxury-nav { border-bottom: 1px solid rgba(17,17,17,.08); background: rgba(255,255,255,.94); backdrop-filter: blur(18px); }
        .brand-mark { font-family: var(--font-editorial); font-size: 2rem; font-weight: 700; letter-spacing: .14em; line-height: 1; }
        .nav-link { font-size: .8rem; letter-spacing: .08em; text-transform: uppercase; }
        .icon-btn { width: 40px; height: 40px; display: inline-grid; place-items: center; border: 1px solid transparent; background: transparent; color: var(--brand-black); text-decoration: none; }
        .icon-btn:hover, .icon-btn:focus { border-color: var(--brand-black); color: var(--brand-black); }
        .mega-panel { border-top: 1px solid var(--neutral-200); border-bottom: 1px solid var(--neutral-200); background: var(--brand-white); }
        .mega-panel img { aspect-ratio: 16 / 9; object-fit: cover; filter: grayscale(18%); }

        .hero {
            min-height: calc(100vh - 98px);
            background: linear-gradient(90deg, rgba(0,0,0,.48), rgba(0,0,0,.12)), url('https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=2200&q=85') center/cover;
            color: var(--brand-white);
            display: flex;
            align-items: end;
            padding-block: clamp(4rem, 8vw, 7rem);
        }
        .eyebrow { font-size: .75rem; letter-spacing: .18em; text-transform: uppercase; font-weight: 700; }
        .editorial-title { font-family: var(--font-editorial); font-size: clamp(3.5rem, 9vw, 8.8rem); line-height: .86; font-weight: 600; letter-spacing: 0; }
        .section-title { font-family: var(--font-editorial); font-size: clamp(2.1rem, 4vw, 4.2rem); line-height: 1; font-weight: 600; }
        .section-kicker { color: var(--muted); max-width: 680px; }
        .section-band { padding-block: clamp(3.5rem, 7vw, 7rem); }
        .soft-band { background: var(--neutral-50); }

        .btn { border-radius: 0; text-transform: uppercase; letter-spacing: .08em; font-size: .78rem; padding: .85rem 1.25rem; }
        .btn-primary { background: var(--brand-black); border-color: var(--brand-black); color: var(--brand-white); }
        .btn-primary:hover { background: #2a2a2a; border-color: #2a2a2a; }
        .btn-outline-dark { border-color: var(--brand-black); color: var(--brand-black); }
        .btn-outline-dark:hover { background: var(--brand-black); color: var(--brand-white); }
        .btn-ghost { border-color: transparent; background: transparent; }
        .btn-ghost:hover { border-color: var(--neutral-300); }

        .form-control, .form-select {
            border-radius: 0;
            border-color: var(--neutral-300);
            padding: .8rem .9rem;
        }
        .form-control:focus, .form-select:focus { border-color: var(--brand-black); box-shadow: 0 0 0 .12rem rgba(17,17,17,.1); }
        .sidebar-box { border: 1px solid var(--neutral-200); padding: clamp(1rem, 2vw, 1.5rem); background: var(--brand-white); }
        .editorial-card { border: 1px solid var(--neutral-200); background: var(--brand-white); }

        .product-card { height: 100%; background: var(--brand-white); position: relative; }
        .product-media { position: relative; overflow: hidden; background: var(--neutral-100); }
        .product-card img { width: 100%; aspect-ratio: 3 / 4; object-fit: cover; transition: transform .65s ease, opacity .35s ease; }
        .product-card:hover img { transform: scale(1.035); }
        .product-actions { position: absolute; inset: .75rem .75rem auto auto; display: flex; gap: .5rem; opacity: 0; transform: translateY(-4px); transition: .25s ease; }
        .product-card:hover .product-actions { opacity: 1; transform: translateY(0); }
        .product-action { width: 38px; height: 38px; display: grid; place-items: center; border: 1px solid rgba(17,17,17,.12); background: rgba(255,255,255,.88); }
        .product-badge { position: absolute; left: .75rem; top: .75rem; background: var(--brand-white); border: 1px solid rgba(17,17,17,.12); padding: .35rem .55rem; font-size: .68rem; letter-spacing: .12em; text-transform: uppercase; }
        .price { color: var(--brand-black); font-weight: 700; }
        .old-price { color: var(--muted); text-decoration: line-through; font-size: .92rem; }
        .empty-state { border: 1px solid var(--neutral-200); padding: 2.5rem; background: var(--neutral-50); color: var(--muted); }

        .footer { background: var(--brand-black); color: #d6d6d6; }
        .footer-brand { font-family: var(--font-editorial); font-size: 2.4rem; letter-spacing: .12em; color: var(--brand-white); }
        .breadcrumb { --bs-breadcrumb-divider-color: var(--muted); font-size: .78rem; text-transform: uppercase; letter-spacing: .08em; }
        .badge-luxury { border: 1px solid var(--neutral-300); color: var(--brand-black); background: var(--brand-white); font-weight: 500; }

        @media (max-width: 991.98px) {
            .brand-mark { font-size: 1.6rem; }
            .hero { min-height: 78vh; }
            .product-actions { opacity: 1; }
        }

        @media (min-width: 992px) {
            .position-lg-absolute { position: absolute; }
            .translate-lg-middle-x { transform: translateX(-50%); }
        }
    </style>
</head>
<body>
    @include('partials.header')
    @include('partials.navbar')

    <main class="page-shell">
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
