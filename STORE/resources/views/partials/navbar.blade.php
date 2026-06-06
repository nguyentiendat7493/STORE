<nav class="navbar navbar-expand-lg bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand brand-mark" href="{{ route('home') }}">STORE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Sản phẩm</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Đơn hàng</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('profile.index') }}">Hồ sơ</a></li>
                @endauth
            </ul>
            <form class="d-flex me-lg-3 mb-3 mb-lg-0" action="{{ route('products.index') }}" method="GET">
                <input class="form-control me-2" type="search" name="q" value="{{ request('q') }}" placeholder="Tìm sản phẩm">
                <button class="btn btn-outline-dark" type="submit">Tìm</button>
            </form>
            <div class="d-flex gap-2 align-items-center">
                @auth
                    <a class="btn btn-outline-dark" href="{{ route('cart.index') }}">Giỏ hàng</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-dark" type="submit">Đăng xuất</button>
                    </form>
                @else
                    <a class="btn btn-outline-dark" href="{{ route('login') }}">Đăng nhập</a>
                    <a class="btn btn-primary" href="{{ route('register') }}">Đăng ký</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
