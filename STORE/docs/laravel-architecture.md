# Kien Truc Laravel Va Cau Truc Thu Muc

Tai lieu nay tuong ung cac muc 7 va 9 trong file yeu cau goc:

- Kien truc Laravel
- Cau truc thu muc

Project hien tai dang chay Laravel 13.14.0 tren PHP 8.3.30, trong khi yeu cau goc ghi Laravel 12. Ve huong kien truc, cac lop controller, model, request, middleware, service va repository van ap dung tuong thich. Neu bat buoc dung Laravel 12 cho do an, can ha version framework rieng; con neu muc tieu la production moi nhat thi co the tiep tuc Laravel 13.

## 1. Huong Kien Truc Tong The

He thong duoc chia thanh 3 mat phang chinh:

| Mat phang | Vai tro | Thu muc chinh |
| --- | --- | --- |
| Frontend Website | Trai nghiem mua hang cua customer | `app/Http/Controllers/Frontend`, `resources/views` |
| Admin CMS | Quan tri catalog, don hang, CMS, cau hinh | `app/Http/Controllers/Admin`, `resources/views/admin` sau nay |
| REST API | API JSON cho frontend/mobile/integration | `app/Http/Controllers/Api`, `routes/api.php` sau nay |

Moi mat phang dung chung:

- `app/Models`: Eloquent model bam theo database hien co.
- `app/Http/Requests`: validation rieng theo use case.
- `app/Http/Middleware`: phan quyen role.
- `app/Services`: xu ly nghiep vu co transaction, tinh tien, upload, SEO, settings.
- `app/Repositories`: truy van co tai su dung, filter, pagination.

## 2. Luong Xu Ly Chuan

### Web request

1. Route nhan request.
2. Middleware kiem tra auth/role.
3. Form Request validate du lieu.
4. Controller dieu phoi use case.
5. Service xu ly nghiep vu.
6. Repository/Model doc ghi database.
7. Blade view render UI.

### API request

1. Route API nhan request.
2. Middleware auth/rate limit neu can.
3. Form Request validate du lieu.
4. Controller goi service/repository.
5. Response tra JSON theo chuan:

```json
{
  "success": true,
  "message": "Success",
  "data": {}
}
```

## 3. Cau Truc Thu Muc Hien Tai

```text
app/
  Http/
    Controllers/
      Admin/
      Api/
        Concerns/
      Frontend/
    Middleware/
    Requests/
      Admin/
      Auth/
      Frontend/
  Models/
  Providers/
bootstrap/
config/
database/
  migrations/
  seeders/
  factories/
  sql/
docs/
public/
resources/
  css/
  js/
  views/
    auth/
    cart/
    checkout/
    components/
    layouts/
    orders/
    partials/
    products/
    profile/
routes/
  web.php
tests/
```

## 4. Cau Truc Thu Muc Nen Bo Sung

De dat muc tieu commercial CMS, nen bo sung theo tung phan:

```text
app/
  Contracts/
  DTO/
  Http/
    Controllers/
      Admin/
      Api/
      Frontend/
      Installer/
    Requests/
      Admin/
      Api/
      Auth/
      Frontend/
      Installer/
  Policies/
  Repositories/
    Contracts/
    Eloquent/
  Services/
    Admin/
    Cart/
    Checkout/
    Cms/
    Seo/
    Theme/
    Upload/
resources/
  views/
    admin/
      layouts/
      dashboard/
      settings/
      themes/
      banners/
      pages/
      blogs/
      menus/
      reviews/
      shipping-methods/
      payment-methods/
    themes/
      zara/
      korean/
      streetwear/
      editorial/
routes/
  api.php
  web.php
docs/
  database-analysis.md
  laravel-architecture.md
  model-relationship-middleware.md
  api-documentation.md
  admin-guide.md
  install.md
```

## 5. Controller Layer

### Frontend controllers da co

- `AuthController`: dang ky, dang nhap, dang xuat.
- `HomeController`: trang chu.
- `ProductController`: danh sach va chi tiet san pham.
- `CartController`: gio hang.
- `CheckoutController`: dat hang.
- `OrderController`: lich su, chi tiet, huy don pending.
- `ProfileController`: ho so va mat khau.

### Admin controllers da co

- `AdminDashboardController`
- `AdminCategoryController`
- `AdminBrandController`
- `AdminProductController`
- `AdminSizeController`
- `AdminColorController`
- `AdminVariantController`
- `AdminOrderController`
- `AdminPaymentController`
- `AdminCouponController`
- `AdminCustomerController`

### Admin controllers can bo sung cho CMS

- `AdminSettingController`
- `AdminThemeController`
- `AdminBannerController`
- `AdminPageController`
- `AdminBlogCategoryController`
- `AdminBlogController`
- `AdminReviewController`
- `AdminMenuController`
- `AdminMenuItemController`
- `AdminShippingMethodController`
- `AdminPaymentMethodController`
- `AdminNotificationController`

## 6. Model Layer

Model hien tai da phu hop voi schema core va CMS extension. Nguyen tac tiep tuc:

- Moi model co `$fillable`.
- Cot tien te cast `decimal:2`.
- Cot JSON cast `array`.
- Cot status boolean cast `boolean` neu la tinyint.
- Relationship viet ro kieu tra ve `BelongsTo`, `HasMany`, `HasOne`.
- Query hay dung dua vao scope: `scopeSearch`, `scopeFilter`, `scopeActive`.

## 7. Service Layer

Service layer nen gom cac use case co nghiep vu that, vi du:

- `CartService`: them/xoa/cap nhat gio, tinh tong tien.
- `CheckoutService`: transaction dat hang, coupon, tru ton kho, tao payment.
- `ProductService`: filter, sort, gallery, related products.
- `SettingsService`: doc setting public, cache setting, update setting tu admin.
- `ThemeService`: lay active theme, doi theme.
- `SeoService`: tao meta, canonical, schema data.
- `UploadService`: validate va luu file anh.

Quy tac: controller khong nen chua logic tinh tien, tru kho, apply coupon, upload file phuc tap.

## 8. Repository Layer

Repository nen dung cho cac truy van co the tai su dung:

- `ProductRepository`: search/filter/sort/product detail.
- `OrderRepository`: query don hang theo user/status/date.
- `CategoryRepository`: active categories.
- `BrandRepository`: active brands.
- `SettingRepository`: lay setting theo group/key.
- `BlogRepository`: published posts, SEO slug.

Quy tac: repository khong xu ly transaction nghiep vu; service dieu phoi transaction.

## 9. Route Layer

### `routes/web.php`

Da co route frontend cho home, auth, products, cart, checkout, orders, profile.

Da bo sung group admin trong `routes/web.php`:

```php
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'staff'])
    ->group(function (): void {
        // dashboard, catalog CRUD, order, customer va payment routes
    });
```

Can bo sung tiep route cho CMS extension khi tao controller/view tuong ung: settings, themes, banners, pages, blogs, reviews, menus, shipping methods, payment methods.

### `routes/api.php`

Hien tai chua co file `routes/api.php` trong project, mac du da co controller API. Can bo sung o phan route API va dang ky trong `bootstrap/app.php`.

## 10. Blade Layer

Frontend views hien co:

- `layouts/app.blade.php`
- `partials/header.blade.php`
- `partials/navbar.blade.php`
- `partials/footer.blade.php`
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

Can bo sung:

- Admin layout va CRUD pages.
- Theme folders theo `themes.view_path`.
- CMS pages/blog views.
- Shared form components cho input, textarea, select, image upload, status badge.

## 11. Ket Luan Phan 7 Va 9

Project da co nen Laravel tot cho ecommerce core. Phan tiep theo nen lam theo thu tu:

1. Doi chieu them tai lieu `model-relationship-middleware.md` khi noi route/controller vao model.
2. Tao service/repository foundation.
3. Bo sung route web cho admin.
4. Tao Blade Admin layout va CMS CRUD dau tien, nen bat dau tu Settings System.
5. Bo sung `routes/api.php` va API route group.
