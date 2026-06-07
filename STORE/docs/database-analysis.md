# Phan Tich Database Hien Co

Tai lieu nay tuong ung cac muc 1, 3 va 5 trong file yeu cau goc:

- Phan tich database hien co
- Nhung gi database da du
- Nhung gi nen bo sung

Ghi chu quan trong: da doc truc tiep database MySQL `website` qua cau hinh `.env` tai `127.0.0.1:3306`. Schema hien tai gom day du ecommerce core va cac bang CMS extension. Workspace khong can thiet ke lai database; cac phan tiep theo se bam theo schema dang chay nay.

## 1. Nguyen Tac Lam Viec Voi Database

- Khong thiet ke lai database tu dau.
- Khong doi ten bang hien co.
- Khong doi ten cot hien co.
- Khong tu y thay doi kieu du lieu hoac quan he hien co neu chua doi chieu voi `website.sql`.
- Laravel code phai bam theo schema dang co, thong qua model, relationship, request validation, service va repository.
- Cac bang/cot bo sung phai nam o lop extension CMS, khong pha vo ecommerce core.

## 2. Tong Quan Schema Da Doc Tu MySQL

Database hien tai gom 34 bang:

- Ecommerce core: `users`, `categories`, `brands`, `products`, `product_images`, `sizes`, `colors`, `product_variants`, `carts`, `cart_items`, `orders`, `order_details`, `payments`, `coupons`.
- CMS extension: `settings`, `themes`, `banners`, `pages`, `blog_categories`, `blogs`, `reviews`, `wishlists`, `notifications`, `menus`, `menu_items`, `shipping_methods`, `payment_methods`.
- Laravel system: `cache`, `cache_locks`, `sessions`, `jobs`, `job_batches`, `failed_jobs`.

Moi bang ecommerce va CMS dang dung primary key `id` dang `bigint` auto increment. Cac bang Laravel system giu schema mac dinh cua framework.

## 3. Nhom Bang Ecommerce Core

Database hien co duoc yeu cau bao gom:

| Bang | Vai tro nghiep vu | Quan he chinh du kien |
| --- | --- | --- |
| `users` | Tai khoan khach hang, admin, staff | 1-n `orders`, 1-n `carts`, 1-n `reviews`, 1-n `wishlists`, 1-n `notifications`, 1-n `blogs` |
| `categories` | Danh muc san pham | 1-n `products` |
| `brands` | Thuong hieu | 1-n `products` |
| `products` | San pham chinh | n-1 `categories`, n-1 `brands`, 1-n `product_images`, 1-n `product_variants` |
| `product_images` | Anh san pham | n-1 `products` |
| `sizes` | Size thoi trang | 1-n `product_variants` |
| `colors` | Mau sac | 1-n `product_variants` |
| `product_variants` | Bien the SKU theo size/mau | n-1 `products`, n-1 `sizes`, n-1 `colors`, 1-n `cart_items`, 1-n `order_details` |
| `carts` | Gio hang cua user | n-1 `users`, 1-n `cart_items` |
| `cart_items` | Dong san pham trong gio | n-1 `carts`, n-1 `product_variants` |
| `orders` | Don hang | n-1 `users`, n-1 `coupons`, 1-n `order_details`, 1-1 `payments` |
| `order_details` | Snapshot san pham trong don | n-1 `orders`, n-1 `product_variants` |
| `payments` | Thanh toan cua don | n-1 `orders` |
| `coupons` | Ma giam gia | 1-n `orders` |

## 4. Primary Key, Foreign Key Va Index Dang Co

### Khoa chinh

- Tat ca bang nghiep vu core va CMS co khoa chinh `id`.
- `sizes`, `colors`, `order_details`, `product_images`, `payments`, `coupons`, `wishlists` khong co day du `updated_at`; model hien tai da dat `$timestamps` hoac `UPDATED_AT` de phu hop.

### Khoa ngoai quan trong

- `products.category_id` -> `categories.id`
- `products.brand_id` -> `brands.id`
- `product_images.product_id` -> `products.id`
- `product_variants.product_id` -> `products.id`
- `product_variants.size_id` -> `sizes.id`
- `product_variants.color_id` -> `colors.id`
- `carts.user_id` -> `users.id`
- `cart_items.cart_id` -> `carts.id`
- `cart_items.product_variant_id` -> `product_variants.id`
- `orders.user_id` -> `users.id`
- `orders.coupon_id` -> `coupons.id`
- `order_details.order_id` -> `orders.id`
- `order_details.product_variant_id` -> `product_variants.id`
- `payments.order_id` -> `orders.id`
- `reviews.user_id` -> `users.id`
- `reviews.product_id` -> `products.id`
- `reviews.order_id` -> `orders.id`
- `wishlists.user_id` -> `users.id`
- `wishlists.product_id` -> `products.id`
- `blogs.blog_category_id` -> `blog_categories.id`
- `blogs.user_id` -> `users.id`
- `notifications.user_id` -> `users.id`
- `menu_items.menu_id` -> `menus.id`
- `menu_items.parent_id` -> `menu_items.id`

### Index nen co

- Unique da co: `users.email`, `categories.slug`, `brands.slug`, `products.slug`, `product_variants.sku`, `coupons.code`, `sizes.name`.
- Unique CMS da co: `settings.key`, `themes.slug`, `pages.slug`, `blog_categories.slug`, `blogs.slug`, `menus.slug`, `shipping_methods.code`, `payment_methods.code`.
- FK/index da co cho cac cot quan he: `products.category_id`, `products.brand_id`, `product_variants.product_id`, `product_variants.size_id`, `product_variants.color_id`, `cart_items.cart_id`, `cart_items.product_variant_id`, `orders.user_id`, `orders.coupon_id`, `order_details.order_id`, `order_details.product_variant_id`, `payments.order_id`.
- Index nen can nhac bo sung sau, neu query lon: `products.status`, `products.gender`, `orders.status`, `orders.created_at`, `reviews.status`, `banners.position/status`.

## 5. Chi Tiet Cot Quan Trong

### `users`

- `name`, `email`, `password`, `phone`, `address`, `role`.
- `role` la enum `super_admin`, `admin`, `staff`, `customer`, mac dinh `customer`.
- Du cho authentication, profile, phan quyen admin/staff/customer.

### `products`

- `category_id`, `brand_id`, `name`, `slug`, `description`, `price`, `sale_price`, `gender`, `status`.
- `gender` la enum `male`, `female`, `unisex`, `kids`.
- Du cho catalog, SEO slug, loc san pham, sale price.

### `product_variants`

- `product_id`, `size_id`, `color_id`, `sku`, `price`, `stock`.
- `sku` unique, du de kiem tra ton kho theo bien the va tru hang khi checkout.

### `orders`

- `user_id`, `coupon_id`, thong tin nguoi nhan, tong tien, giam gia, thanh tien, `status`.
- `status` la enum `pending`, `confirmed`, `shipping`, `completed`, `cancelled`.
- Du cho lich su don, huy don pending, dashboard va workflow xu ly don.

### `payments`

- `order_id`, `payment_method`, `payment_status`, `paid_at`.
- `payment_method` gom `cod`, `bank_transfer`, `momo`, `vnpay`.
- `payment_status` gom `unpaid`, `paid`, `failed`.

## 6. Relationship Da Du De Lam Ecommerce

Schema core da du de xay dung cac chuc nang quan trong:

- Danh sach va chi tiet san pham.
- Loc theo danh muc, thuong hieu, size, mau, gioi tinh, trang thai.
- Bien the san pham theo SKU, size, mau va ton kho.
- Gio hang theo user.
- Checkout co coupon, snapshot san pham vao `order_details`.
- Lich su don hang va chi tiet don.
- Thanh toan co trang thai thanh toan rieng.
- Admin CRUD cho category, brand, product, size, color, variant, coupon, order, customer.

## 7. Nhung Diem Da Xac Nhan Sau Khi SQL Chay

- `users` da co `phone`, `address`, `role`.
- `products` da co `slug`, `sale_price`, `gender`, `status`.
- `product_images` da co `image`, `is_main`.
- `product_variants` da co `sku`, `price`, `stock`.
- `orders` da co `customer_name`, `customer_phone`, `customer_address`, `total_price`, `discount_amount`, `final_price`, `status`.
- `payments` da co `payment_method`, `payment_status`, `paid_at`.
- CMS extension da chay thanh cong va co day du bang nen tang.

## 8. Nhung Gi Database Da Du

Database core da du cho mot fashion ecommerce thuc te:

- Catalog: category, brand, product, image.
- Variant: size, color, SKU, stock.
- Cart va checkout: cart, cart item, order, order detail.
- Promotion co ban: coupon.
- Payment tracking co ban: payment.
- User account va role co the mo rong cho admin/staff/customer.

Voi cac bang nay, co the hoan thanh frontend shopping flow, admin CRUD san pham va don hang, REST API co ban, va dashboard doanh thu/don hang.

## 9. Nhung Gi Da Bo Sung De Thanh Commercial CMS

Database hien tai da co cac bang extension sau, khong doi ten bang/cot core:

| Bang bo sung | Ly do |
| --- | --- |
| `settings` | Cau hinh site name, logo, email, hotline, social, SEO mac dinh, footer |
| `themes` | Doi theme Zara Luxury, Korean Minimal, Streetwear, Editorial trong Admin |
| `banners` | Quan ly hero banner, promotion banner, collection banner |
| `pages` | CMS page: About, Contact, FAQ, Privacy, Shipping, Return, Terms |
| `blog_categories` | Danh muc blog/lookbook/fashion journal |
| `blogs` | Bai viet SEO, lookbook, fashion story |
| `reviews` | Danh gia san pham, anh review, duyet review |
| `wishlists` | San pham yeu thich cua customer |
| `notifications` | Thong bao don hang, coupon, khuyen mai, he thong |
| `menus` | Menu dong theo location |
| `menu_items` | Sub menu, mega menu, sort order |
| `shipping_methods` | Cau hinh phi ship va dieu kien mien phi |
| `payment_methods` | Bat/tat COD, bank transfer, VNPay, MoMo, ZaloPay ready |

File SQL extension da dung: `database/sql/2026_06_06_cms_extensions.sql`.

## 10. De Xuat Bo Sung Tiep Theo

Khong can bo sung them bang bat buoc o thoi diem nay. Cac de xuat sau chi nen lam khi trien khai module tuong ung:

- Them `logo`, `favicon`, `seo_keywords`, `copyright`, `working_time` vao `settings` bang seed du lieu, khong can them cot.
- Neu can review upload anh nhieu hon, giu `reviews.images` dang JSON nhu hien tai.
- Neu can SEO schema markup cho product/category/brand, co the them cot nullable sau khi hoan thanh CMS co ban; tam thoi co the dung `settings` va view composer.
- Neu can audit log/activity log, nen them bang moi `activity_logs` sau, khong chen vao bang core.
- Neu can SaaS multi-tenant, de rieng phase nang cap; chua nen sua schema core luc nay.

## 11. Ranh Gioi Bo Sung Khong Pha Vo Schema Cu

- Them bang moi bang `CREATE TABLE IF NOT EXISTS` khi can module moi.
- Neu can them cot vao bang cu, chi them khi schema hien tai thieu cot bat buoc cho Laravel/commercial flow.
- Moi thay doi `ALTER TABLE` phai co ghi chu ly do va cach rollback.
- Khong doi cac cot dang duoc du lieu cu su dung.
- Khong doi enum/status neu chua co migration chuyen doi du lieu.

## 12. Ket Luan Phan 1

Phan database core da du de tiep tuc xay dung Laravel theo huong ecommerce. Phan CMS extension cung da co trong database, nen co the tiep tuc sang kien truc Laravel, route, controller, view admin va seeder ma khong can thiet ke lai schema.

Buoc tiep theo theo danh sach output la phan 7 va 9: mo ta kien truc Laravel va cau truc thu muc, sau do tiep tuc den model/relationship/middleware da co trong code.
