# Fashion Ecommerce CMS Architecture

## 1. System Direction

This project is being expanded from a single fashion store into a reusable Fashion Ecommerce CMS.

Target uses:

- Graduation project
- Professional portfolio
- Source code product for multiple clients
- Freelance client base
- Future SaaS foundation

Core principle: do not hardcode client-specific content such as logo, hotline, email, colors, banners, footer, policies, menus, and website copy. These must move into Admin CMS configuration.

## 2. Main Modules

- Frontend Website
- Admin CMS
- REST API
- Theme System
- Settings System
- SEO System
- Blog System
- Banner System
- Coupon System
- Review System
- Wishlist System
- Notification System
- Shipping and Payment Method System

## 3. Database Extension

Existing ecommerce tables are preserved.

New CMS tables:

- `settings`
- `themes`
- `banners`
- `pages`
- `blogs`
- `blog_categories`
- `reviews`
- `wishlists`
- `notifications`
- `menus`
- `menu_items`
- `shipping_methods`
- `payment_methods`

SQL file:

- `database/sql/2026_06_06_cms_extensions.sql`

## 4. Role Model

Roles:

- `super_admin`: source owner / SaaS operator
- `admin`: store admin
- `staff`: operational staff
- `customer`: shopper

Middleware:

- `auth`
- `guest`
- `admin`
- `super_admin`
- `staff`

## 5. Theme Structure

Future theme folders:

- `resources/views/themes/zara`
- `resources/views/themes/korean`
- `resources/views/themes/streetwear`
- `resources/views/themes/editorial`

Active theme is selected from `themes.is_active`.

## 6. Settings System

Settings are key/value records grouped by context:

- `general`: site name, hotline, email, address
- `social`: Facebook, Instagram, TikTok, Zalo
- `footer`: footer description/content
- `theme`: primary color, accent color
- `seo`: default meta title, default meta description

## 7. CMS Admin Direction

Admin should manage:

- Website settings
- Theme selection
- Menu builder
- Banners
- CMS pages
- Blog categories and posts
- Reviews approval
- Shipping methods
- Payment methods
- Notifications

## 8. API Direction

API response shape:

```json
{
  "success": true,
  "message": "Success",
  "data": {}
}
```

API modules:

- Authentication
- Product
- Category
- Brand
- Cart
- Order
- Review
- Wishlist
- Notification

## 9. Security Checklist

- CSRF for web forms
- Eloquent/query builder to avoid SQL injection
- Form Request validation
- Upload MIME and file size validation
- Role middleware
- Transaction rollback for checkout
- Rate limiting for auth/API later
- Escaped Blade output by default

## 10. Next Implementation Steps

1. Add CMS models and relationships.
2. Add `super_admin` and `staff` middleware.
3. Add admin controllers/routes/views for settings, themes, banners, pages, blogs, reviews, menus, shipping, payment methods.
4. Replace frontend hardcoded site identity with `settings`.
5. Add seeders/factories for CMS foundation.
6. Add installer and documentation.
