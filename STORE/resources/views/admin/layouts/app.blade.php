<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - STORE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --ink: #151515;
            --muted: #6b7280;
            --line: #e5e7eb;
            --panel: #ffffff;
            --soft: #f7f7f5;
        }

        body {
            background: var(--soft);
            color: var(--ink);
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            letter-spacing: 0;
        }

        .admin-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 260px 1fr;
        }

        .admin-sidebar {
            background: var(--ink);
            color: #f8f8f8;
            padding: 24px 18px;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .admin-brand {
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .admin-nav a {
            color: rgba(255, 255, 255, .74);
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            text-decoration: none;
            border-radius: 8px;
            font-size: .92rem;
        }

        .admin-nav a:hover,
        .admin-nav a.active {
            color: #fff;
            background: rgba(255, 255, 255, .1);
        }

        .admin-main {
            min-width: 0;
        }

        .admin-topbar {
            background: var(--panel);
            border-bottom: 1px solid var(--line);
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .admin-content {
            padding: 28px;
        }

        .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 8px;
        }

        .panel-pad {
            padding: 20px;
        }

        .stat-value {
            font-size: clamp(1.7rem, 3vw, 2.35rem);
            font-weight: 800;
        }

        .table {
            vertical-align: middle;
        }

        .table th {
            color: var(--muted);
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .btn,
        .form-control,
        .form-select {
            border-radius: 6px;
        }

        .btn-dark {
            background: var(--ink);
            border-color: var(--ink);
        }

        .badge {
            border-radius: 999px;
            font-weight: 600;
        }

        @media (max-width: 991.98px) {
            .admin-shell {
                display: block;
            }

            .admin-sidebar {
                position: static;
                height: auto;
            }

            .admin-nav {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 4px;
            }

            .admin-content,
            .admin-topbar {
                padding: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand mb-4">STORE CMS</div>
            @php
                $links = [
                    ['admin.dashboard', 'bi-speedometer2', 'Dashboard'],
                    ['admin.settings.index', 'bi-gear', 'Settings'],
                    ['admin.banners.index', 'bi-images', 'Banners'],
                    ['admin.pages.index', 'bi-file-earmark-text', 'Pages'],
                    ['admin.products.index', 'bi-bag', 'Products'],
                    ['admin.categories.index', 'bi-grid', 'Categories'],
                    ['admin.brands.index', 'bi-award', 'Brands'],
                    ['admin.variants.index', 'bi-box-seam', 'Variants'],
                    ['admin.orders.index', 'bi-receipt', 'Orders'],
                    ['admin.payments.index', 'bi-credit-card', 'Payments'],
                    ['admin.customers.index', 'bi-people', 'Customers'],
                    ['admin.coupons.index', 'bi-ticket-perforated', 'Coupons'],
                    ['admin.sizes.index', 'bi-rulers', 'Sizes'],
                    ['admin.colors.index', 'bi-palette', 'Colors'],
                ];
            @endphp
            <nav class="admin-nav d-grid gap-1">
                @foreach ($links as [$route, $icon, $label])
                    <a href="{{ route($route) }}" @class(['active' => request()->routeIs($route) || request()->routeIs(str_replace('.index', '.*', $route))])>
                        <i class="bi {{ $icon }}"></i>
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
                <a href="{{ route('home') }}">
                    <i class="bi bi-shop"></i>
                    <span>Storefront</span>
                </a>
            </nav>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <div>
                    <div class="text-muted small text-uppercase fw-bold">Admin Area</div>
                    <h1 class="h4 mb-0">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small">{{ auth()->user()?->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-dark btn-sm" type="submit">Logout</button>
                    </form>
                </div>
            </header>

            <main class="admin-content">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
