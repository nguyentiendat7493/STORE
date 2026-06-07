# Model, Relationship Va Middleware

Tai lieu nay tiep noi sau `database-analysis.md` va `laravel-architecture.md`, tap trung vao cac model Eloquent, relationship, scope va middleware da co trong code hien tai.

## 1. Trang Thai Hien Tai

- Tat ca model nghiep vu core va CMS extension da ton tai trong `app/Models`.
- Cac model da co `$fillable` de phuc vu mass assignment tu controller/admin form.
- Cac cot tien te duoc cast `decimal:2`; cot boolean/status tinyint duoc cast `boolean`; cot JSON duoc cast `array` o cac model can thiet.
- Relationship chinh da duoc khai bao bang return type `BelongsTo`, `HasMany`, `HasOne`.
- Middleware role da co va da duoc dang ky alias trong `bootstrap/app.php`.

Kiem tra da chay:

```text
php -l app/Models/*.php
php artisan test
```

Ket qua: khong co loi syntax model; test hien co pass.

## 2. Model Ecommerce Core

| Model | Bang | Relationship chinh | Ghi chu su dung |
| --- | --- | --- | --- |
| `User` | `users` | `carts`, `orders`, `reviews`, `wishlists`, `notifications`, `blogs` | Co scope role/staff va accessor admin/staff |
| `Category` | `categories` | `products` | Co scope active, search, filter |
| `Brand` | `brands` | `products` | Co scope active, search, filter |
| `Product` | `products` | `category`, `brand`, `images`, `variants`, `reviews`, `wishlists` | Co filter theo category, brand, size, color, gender, price, sale |
| `ProductImage` | `product_images` | `product` | Co scope main |
| `Size` | `sizes` | `variants` | Khong dung `updated_at` theo schema |
| `Color` | `colors` | `variants` | Khong dung `updated_at` theo schema |
| `ProductVariant` | `product_variants` | `product`, `size`, `color`, `cartItems`, `orderDetails` | Co scope in stock, accessor display price |
| `Cart` | `carts` | `user`, `items` | Co accessor total va display total |
| `CartItem` | `cart_items` | `cart`, `productVariant` | Co accessor subtotal |
| `Coupon` | `coupons` | `orders` | Co scope active theo ngay bat dau/het han |
| `Order` | `orders` | `user`, `coupon`, `details`, `payment` | Co scope status/search/filter, accessor can cancel |
| `OrderDetail` | `order_details` | `order`, `productVariant` | Dung snapshot gia/so luong trong don |
| `Payment` | `payments` | `order` | Co scope payment status va method |

## 3. Model CMS Extension

| Model | Bang | Relationship chinh | Ghi chu su dung |
| --- | --- | --- | --- |
| `Setting` | `settings` | Khong co FK | Dung key/value theo group, co scope public/group/search/filter |
| `Theme` | `themes` | Khong co FK | Dung `is_active` de chon theme frontend, co search/filter |
| `Banner` | `banners` | Khong co FK | Co scope active theo status/date range, position/search/filter |
| `Page` | `pages` | Khong co FK | Co scope published, search/filter, SEO accessor |
| `BlogCategory` | `blog_categories` | `blogs` | Co scope active/search/filter |
| `Blog` | `blogs` | `category`, `author` | Co scope published/search/filter va SEO accessor |
| `Review` | `reviews` | `user`, `product`, `order` | Co scope approved/search/filter; `images` cast array |
| `Wishlist` | `wishlists` | `user`, `product` | Co search/filter phuc vu customer wishlist |
| `Notification` | `notifications` | `user` | Co scope unread/search/filter |
| `Menu` | `menus` | `items`, `allItems` | Co scope active/search/filter theo location/status |
| `MenuItem` | `menu_items` | `menu`, `parent`, `children` | Ho tro nested menu, active/search/filter |
| `ShippingMethod` | `shipping_methods` | Khong co FK | Co scope active/search/filter |
| `PaymentMethod` | `payment_methods` | Khong co FK | Co scope active/search/filter |

## 4. Relationship Quan Trong Can Dung Khi Query

### Product detail

```php
Product::query()
    ->with(['category', 'brand', 'images', 'variants.size', 'variants.color', 'reviews.user'])
    ->where('slug', $slug)
    ->firstOrFail();
```

### Cart

```php
$cart->load(['items.productVariant.product', 'items.productVariant.size', 'items.productVariant.color']);
```

### Order detail

```php
Order::query()
    ->with(['details.productVariant.product', 'payment', 'coupon'])
    ->whereBelongsTo($user)
    ->findOrFail($id);
```

### Menu frontend

```php
Menu::query()
    ->with(['items.children'])
    ->active()
    ->where('location', 'header')
    ->first();
```

## 5. Query Scope Nen Tai Su Dung

- `scopeSearch($query, ?string $keyword)`: dung chung cho admin list va API list.
- `scopeFilter($query, array $filters)`: gom cac dieu kien loc theo request.
- `scopeActive($query)`: dung cho category, brand, coupon, banner, menu, theme, shipping/payment method.
- `scopePublished($query)`: dung cho `Page` va `Blog`.
- `scopeApproved($query)`: dung cho review public.
- `scopeUnread($query)`: dung cho notification cua user/admin.

Nguyen tac: controller nen goi scope/model query de giu logic truy van nhat quan; cac phep tinh nghiep vu lon van nen dua vao service.

## 6. Middleware Role

Middleware hien co:

| Alias | Class | Role duoc phep |
| --- | --- | --- |
| `admin` | `AdminMiddleware` | `super_admin`, `admin` |
| `staff` | `StaffMiddleware` | `super_admin`, `admin`, `staff` |
| `super_admin` | `SuperAdminMiddleware` | `super_admin` |

Dang ky alias trong `bootstrap/app.php`:

```php
$middleware->alias([
    'admin' => AdminMiddleware::class,
    'super_admin' => SuperAdminMiddleware::class,
    'staff' => StaffMiddleware::class,
]);
```

Route admin nen dung:

```php
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'staff'])
    ->group(function (): void {
        // Admin dashboard, catalog, order va CMS routes.
    });
```

Voi route chi cho owner/source operator, them middleware `super_admin`.

## 7. Viec Con Nen Lam Tiep

1. Tao admin layout va view CRUD cho catalog core truoc.
2. Tao controller/view CMS: settings, themes, banners, pages, blogs, reviews, menus, shipping methods, payment methods.
3. Tach business logic gio hang/checkout/upload/settings sang service layer.
4. Bo sung `routes/api.php` va dang ky API route trong `bootstrap/app.php`.
