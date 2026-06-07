<footer class="footer mt-5 py-5">
    <div class="container-wide">
        <div class="row g-4 justify-content-between">
            <div class="col-lg-4">
                <div class="footer-brand mb-3">{{ $siteSettings['site_name'] ?? 'STORE' }}</div>
                <div class="small">{{ $siteSettings['footer_description'] ?? 'Minimal fashion, editorial styling and modern ecommerce CMS controls.' }}</div>
                <div class="small mt-3 d-grid gap-1">
                    @if (! empty($siteSettings['site_email']))
                        <span>{{ $siteSettings['site_email'] }}</span>
                    @endif
                    @if (! empty($siteSettings['site_hotline']))
                        <span>{{ $siteSettings['site_hotline'] }}</span>
                    @endif
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="eyebrow text-white mb-3">Service</div>
                <div class="small d-grid gap-2">
                    @forelse (($siteMenus['footer_service']?->items ?? collect()) as $menuItem)
                        <a class="text-decoration-none" href="{{ $menuItem->url }}" target="{{ $menuItem->target }}">{{ $menuItem->title }}</a>
                    @empty
                        <a class="text-decoration-none" href="{{ route('pages.show', 'contact') }}">Contact</a>
                        <a class="text-decoration-none" href="{{ route('pages.show', 'shipping-policy') }}">Shipping</a>
                        <a class="text-decoration-none" href="{{ route('pages.show', 'return-policy') }}">Returns</a>
                        <a class="text-decoration-none" href="{{ route('pages.show', 'faq') }}">FAQ</a>
                        <a class="text-decoration-none" href="{{ route('blogs.index') }}">Journal</a>
                    @endforelse
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="eyebrow text-white mb-3">Account</div>
                <div class="small d-grid gap-2">
                    @forelse (($siteMenus['footer_account']?->items ?? collect()) as $menuItem)
                        <a class="text-decoration-none" href="{{ $menuItem->url }}" target="{{ $menuItem->target }}">{{ $menuItem->title }}</a>
                    @empty
                        <a class="text-decoration-none" href="{{ route('login') }}">Login</a>
                        <a class="text-decoration-none" href="{{ route('register') }}">Register</a>
                        <a class="text-decoration-none" href="{{ route('orders.index') }}">Orders</a>
                        <a class="text-decoration-none" href="{{ route('cart.index') }}">Cart</a>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-3">
                <div class="eyebrow text-white mb-3">Newsletter</div>
                <form class="d-flex">
                    <input class="form-control" type="email" placeholder="Your email">
                    <button class="btn btn-light" type="button">Send</button>
                </form>
            </div>
        </div>
        <div class="border-top border-secondary mt-5 pt-3 small d-flex justify-content-between flex-column flex-md-row gap-2">
            <span>© {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'STORE' }}</span>
            <span><a class="text-decoration-none" href="{{ route('pages.show', 'about') }}">About</a> · <a class="text-decoration-none" href="{{ route('pages.show', 'return-policy') }}">Return Policy</a> · <a class="text-decoration-none" href="{{ route('pages.show', 'shipping-policy') }}">Shipping Policy</a></span>
        </div>
    </div>
</footer>
