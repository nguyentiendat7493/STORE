# Premium Fashion UI Specification

## 1. Sitemap

Frontend:

- `/`: Trang chủ editorial
- `/products`: Danh sách sản phẩm, filter, sort, grid
- `/products/{product}`: Chi tiết sản phẩm
- `/cart`: Giỏ hàng
- `/checkout`: Thanh toán
- `/login`, `/register`: Tài khoản
- `/profile`: Hồ sơ
- `/orders`, `/orders/{order}`: Lịch sử và chi tiết đơn
- Future: wishlist, lookbook, blog, fashion journal, about, contact, FAQ, shipping, return, privacy, 404

Admin:

- `/admin`: Dashboard
- Future routes: products, categories, brands, orders, customers, coupons, inventory, payments, reviews, blog, analytics, settings

## 2. User Flow

- Khách vào trang chủ, xem hero collection, đi tới danh sách sản phẩm.
- Khách lọc theo category, brand, price, size, color, gender.
- Khách xem chi tiết sản phẩm, chọn biến thể, thêm giỏ.
- Khách đăng nhập hoặc đăng ký, vào giỏ, checkout, xem đơn hàng.
- Admin vào dashboard, quản lý sản phẩm, biến thể, tồn kho, đơn hàng và thanh toán.

## 3. Design System

Brand feeling: luxury minimal, editorial, European fashion, premium retail.

Colors:

- Primary: `#111111`
- Secondary: `#FFFFFF`
- Neutral: `#F5F5F5`, `#E5E5E5`, `#D9D9D9`
- Accent: `#D6C4A1`
- Success: `#22C55E`
- Warning: `#F59E0B`
- Danger: `#EF4444`

Typography:

- Logo and editorial headings: Cormorant Garamond
- Body and controls: Inter
- Headings use large editorial scale, no negative letter spacing.
- Controls use uppercase labels with moderate letter spacing.

## 4. Wireframe

Home:

- Sticky minimal header
- Full-screen editorial hero
- Featured collection grid
- New arrivals product grid
- Lookbook editorial split
- Sale edit
- Brand story
- Newsletter footer

Product listing:

- Breadcrumb
- Editorial page heading
- Sidebar filters
- Toolbar with result count and sort
- Product grid with hover actions

Product detail:

- Breadcrumb
- Large gallery
- Sticky purchase panel
- Variant selector
- Quantity selector
- Add to cart and wishlist
- Accordion content
- Related products

## 5. UI Component List

- Primary, outline, ghost, icon buttons
- Input, textarea, select, checkbox, radio, toggle
- Alert and empty state
- Sticky navbar and mega menu
- Breadcrumb and pagination
- Product card, category card, editorial card
- Modal/drawer placeholders for future search, cart, wishlist, size guide

## 6. Layout Structure

- Use `container-wide` for premium spacious layouts.
- Use `section-band` for vertical rhythm.
- Avoid marketplace density.
- Cards are reserved for repeated items, forms, and framed tools.
- Editorial image sections should be large and inspection-friendly.

## 7. Blade Structure

Current:

- `layouts/app.blade.php`
- `partials/header.blade.php`
- `partials/navbar.blade.php`
- `partials/footer.blade.php`
- `components/product-card.blade.php`
- `home.blade.php`
- `products/index.blade.php`
- `products/show.blade.php`
- `cart/index.blade.php`
- `checkout/index.blade.php`
- `orders/index.blade.php`
- `orders/show.blade.php`
- `profile/index.blade.php`
- `auth/login.blade.php`
- `auth/register.blade.php`

Future:

- `components/empty-state.blade.php`
- `components/breadcrumb.blade.php`
- `components/admin-stat-card.blade.php`
- `pages/lookbook.blade.php`
- `pages/journal.blade.php`
- `pages/policy.blade.php`

## 8. Tailwind Structure

If Tailwind is adopted later:

- Define tokens in `resources/css/app.css`.
- Map colors to CSS variables matching this spec.
- Create component classes for `.btn-primary`, `.btn-outline`, `.product-card`, `.section-band`.
- Keep Blade markup stable while migrating Bootstrap utilities gradually.

## 9. Responsive Rules

- Mobile: bottom-friendly actions, visible product actions, single-column checkout.
- Tablet: two-column product grids, compact filters.
- Desktop: wide editorial spacing, sticky product purchase panel.
- Ultra wide: cap content with `container-wide`.
- Text must wrap inside controls and never overlap.

## 10. UX Guidelines

- Avoid marketplace visuals such as loud badges, dense discount blocks, and crowded cards.
- Prioritize product photography, whitespace, and confident typography.
- All purchase actions must clearly show stock, price, and selected variant.
- Empty states should be calm and actionable.
- Filtering should preserve query strings and pagination.

## 11. UI Specification

Buttons:

- Primary: black background, white text.
- Outline: black border, transparent background.
- Ghost: transparent, subtle border on hover.
- Icon button: square, accessible label, Bootstrap Icon.

Product card:

- Large image, 3:4 ratio.
- Hover scale.
- Wishlist and quick-view actions.
- New/Sale badge.
- Category/brand eyebrow, name, price and sale price.

Forms:

- Square inputs.
- High contrast focus ring.
- Clear labels.
- Validation messages through alert block.

## 12. Admin UI Specification

Admin should feel clean, quiet, operational, and premium:

- Left sidebar navigation.
- Dense but readable stat cards.
- Tables with clear status badges.
- Revenue and order charts.
- Recent orders.
- Low stock variants.
- Quick actions for product, inventory, orders, payment.

Admin should not use hero sections or marketing layouts.
