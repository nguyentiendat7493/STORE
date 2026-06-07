# Service Layer Va Repository Layer

Tai lieu nay tuong ung cac muc 17 va 19 trong file yeu cau goc:

- Service Layer
- Repository Layer

## 1. Muc Tieu

Service va repository duoc them de tach controller khoi logic query/nghiep vu:

- Controller nhan request, validate, tra response/view.
- Service xu ly use case va transaction nghiep vu.
- Repository gom query tai su dung va thao tac database lap lai.
- Model giu relationship, casts, accessor va scope gan voi tung bang.

## 2. Cau Truc Da Them

```text
app/
  Repositories/
    Contracts/
      ProductRepositoryInterface.php
      SettingRepositoryInterface.php
    Eloquent/
      ProductRepository.php
      SettingRepository.php
  Services/
    Catalog/
      ProductCatalogService.php
    Cms/
      SettingsService.php
```

Bindings duoc dang ky trong `app/Providers/AppServiceProvider.php`:

```php
$this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
$this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
```

## 3. Product Catalog

### `ProductRepositoryInterface`

Chuan hoa cac truy van catalog:

- `paginateActive(...)`: danh sach san pham active, co search/filter/sort/pagination.
- `related(...)`: san pham lien quan cung danh muc.
- `filterOptions()`: danh muc, thuong hieu, size, mau cho bo loc frontend/admin.

### `ProductCatalogService`

Dung repository de phuc vu frontend product flow:

- `paginate(...)`
- `related(...)`
- `filterOptions()`

`ProductController` frontend da duoc refactor sang dung service nay. Logic query catalog khong con nam truc tiep trong controller.

## 4. Settings CMS

### `SettingRepositoryInterface`

Chuan hoa truy cap settings:

- `public(?string $group = null)`: lay setting public theo group hoac tat ca.
- `value(string $key, mixed $default = null)`: lay gia tri mot setting.
- `updateMany(array $settings)`: update nhieu setting theo key.

### `SettingsService`

Them cache cho settings:

- Cache public settings theo group.
- Cache value theo key.
- Xoa cache sau khi admin update settings.

## 5. Nguyen Tac Mo Rong

Khi them service/repository moi:

- Tao contract trong `app/Repositories/Contracts`.
- Tao implementation trong `app/Repositories/Eloquent`.
- Bind contract vao implementation trong `AppServiceProvider`.
- Controller chi type-hint service, khong type-hint repository truc tiep neu co nghiep vu.
- Transaction dat trong service, khong dat trong repository.

## 6. Viec Can Lam Tiep

- Tach cart logic tu `CartController` sang `CartService`.
- Tach checkout transaction tu `CheckoutController` sang `CheckoutService`.
- Tao `OrderRepository` va `OrderService` cho admin/customer order flow.
- Tao `AdminCmsService` hoac cac service rieng cho settings, theme, banner, page, blog.
- Tao form request cho cac admin CMS CRUD.
