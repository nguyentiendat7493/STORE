<footer class="footer mt-5 py-5">
    <div class="container-wide">
        <div class="row g-4 justify-content-between">
            <div class="col-lg-4">
                <div class="footer-brand mb-3">STORE</div>
                <div class="small">Thời trang tối giản, biên tập như tạp chí và được hoàn thiện cho nhịp sống hiện đại.</div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="eyebrow text-white mb-3">Dịch vụ</div>
                <div class="small d-grid gap-2">
                    <a class="text-decoration-none" href="#">Liên hệ</a>
                    <a class="text-decoration-none" href="#">Giao hàng</a>
                    <a class="text-decoration-none" href="#">Đổi trả</a>
                    <a class="text-decoration-none" href="#">FAQ</a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="eyebrow text-white mb-3">Tài khoản</div>
                <div class="small d-grid gap-2">
                    <a class="text-decoration-none" href="{{ route('login') }}">Đăng nhập</a>
                    <a class="text-decoration-none" href="{{ route('register') }}">Đăng ký</a>
                    <a class="text-decoration-none" href="{{ route('orders.index') }}">Đơn hàng</a>
                    <a class="text-decoration-none" href="{{ route('cart.index') }}">Giỏ hàng</a>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="eyebrow text-white mb-3">Newsletter</div>
                <form class="d-flex">
                    <input class="form-control" type="email" placeholder="Email của bạn">
                    <button class="btn btn-light" type="button">Gửi</button>
                </form>
            </div>
        </div>
        <div class="border-top border-secondary mt-5 pt-3 small d-flex justify-content-between flex-column flex-md-row gap-2">
            <span>© {{ date('Y') }} STORE</span>
            <span>Privacy Policy · Return Policy · Shipping Policy</span>
        </div>
    </div>
</footer>
