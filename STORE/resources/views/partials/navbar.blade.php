<nav class="navbar navbar-expand-lg sticky-top luxury-nav">
    <div class="container-wide">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand brand-mark position-lg-absolute start-50 translate-lg-middle-x mx-lg-auto" href="{{ route('home') }}">STORE</a>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index', ['gender' => 'female']) }}">Women</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index', ['gender' => 'male']) }}">Men</a></li>
                <li class="nav-item dropdown position-static">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Collection</a>
                    <div class="dropdown-menu w-100 mt-0 rounded-0 border-0 p-0">
                        <div class="mega-panel py-4">
                            <div class="container-wide">
                                <div class="row g-4 align-items-start">
                                    <div class="col-md-3">
                                        <div class="eyebrow mb-3">Danh mục</div>
                                        <a class="d-block text-decoration-none mb-2" href="{{ route('products.index') }}">Tất cả sản phẩm</a>
                                        <a class="d-block text-decoration-none mb-2" href="{{ route('products.index', ['sort' => 'newest']) }}">New Arrival</a>
                                        <a class="d-block text-decoration-none mb-2" href="{{ route('products.index', ['sort' => 'price_desc']) }}">Premium Selection</a>
                                        <a class="d-block text-decoration-none" href="{{ route('products.index') }}">Sale Edit</a>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="eyebrow mb-3">Thương hiệu</div>
                                        <a class="d-block text-decoration-none mb-2" href="{{ route('products.index') }}">Massimo Mood</a>
                                        <a class="d-block text-decoration-none mb-2" href="{{ route('products.index') }}">COS Minimal</a>
                                        <a class="d-block text-decoration-none" href="{{ route('products.index') }}">Mango Evening</a>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=1000&q=80" alt="Fashion editorial">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index', ['sort' => 'newest']) }}">New Arrival</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Sale</a></li>
                @auth
                    <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('orders.index') }}">Đơn hàng</a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('profile.index') }}">Hồ sơ</a></li>
                @endauth
            </ul>
            <form class="d-flex me-lg-3 mb-3 mb-lg-0" action="{{ route('products.index') }}" method="GET" role="search">
                <input class="form-control me-2" type="search" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm">
                <button class="icon-btn" type="submit" aria-label="Tìm kiếm"><i class="bi bi-search"></i></button>
            </form>
            <div class="d-flex gap-2 align-items-center">
                @auth
                    <a class="icon-btn" href="{{ route('profile.index') }}" aria-label="Tài khoản"><i class="bi bi-person"></i></a>
                    <a class="icon-btn" href="#" aria-label="Yêu thích"><i class="bi bi-heart"></i></a>
                    <a class="icon-btn" href="{{ route('cart.index') }}" aria-label="Giỏ hàng"><i class="bi bi-bag"></i></a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-ghost" type="submit">Đăng xuất</button>
                    </form>
                @else
                    <a class="icon-btn" href="{{ route('login') }}" aria-label="Đăng nhập"><i class="bi bi-person"></i></a>
                    <a class="icon-btn" href="#" aria-label="Yêu thích"><i class="bi bi-heart"></i></a>
                    <a class="icon-btn" href="{{ route('login') }}" aria-label="Giỏ hàng"><i class="bi bi-bag"></i></a>
                @endauth
            </div>
        </div>
    </div>
</nav>
