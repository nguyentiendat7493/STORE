<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Color;
use App\Models\Coupon;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Page;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\Setting;
use App\Models\ShippingMethod;
use App\Models\Size;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CoreDemoSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $admin = User::updateOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin',
                    'password' => 'Admin@123456',
                    'phone' => '0900000000',
                    'address' => 'Admin Office',
                    'role' => 'admin',
                ],
            );

            $customer = User::updateOrCreate(
                ['email' => 'customer@example.com'],
                [
                    'name' => 'Demo Customer',
                    'password' => 'Customer@123456',
                    'phone' => '0901234567',
                    'address' => '12 Nguyen Hue, District 1, Ho Chi Minh City',
                    'role' => 'customer',
                ],
            );

            $categories = collect([
                ['name' => 'Dresses', 'slug' => 'dresses', 'description' => 'Editorial dresses for daily and evening styling.'],
                ['name' => 'Outerwear', 'slug' => 'outerwear', 'description' => 'Blazers, coats and light jackets.'],
                ['name' => 'Tops', 'slug' => 'tops', 'description' => 'Shirts, knitwear and refined essentials.'],
                ['name' => 'Bottoms', 'slug' => 'bottoms', 'description' => 'Trousers, skirts and tailored separates.'],
            ])->mapWithKeys(fn (array $data) => [
                $data['slug'] => Category::updateOrCreate(
                    ['slug' => $data['slug']],
                    $data + ['status' => true],
                ),
            ]);

            $brands = collect([
                ['name' => 'Maison Noir', 'slug' => 'maison-noir', 'description' => 'Minimal luxury wardrobe pieces.'],
                ['name' => 'Atelier Seoul', 'slug' => 'atelier-seoul', 'description' => 'Korean minimal silhouettes.'],
                ['name' => 'Street Edit', 'slug' => 'street-edit', 'description' => 'Elevated streetwear basics.'],
            ])->mapWithKeys(fn (array $data) => [
                $data['slug'] => Brand::updateOrCreate(
                    ['slug' => $data['slug']],
                    $data + ['status' => true],
                ),
            ]);

            $sizes = collect(['XS', 'S', 'M', 'L', 'XL'])->mapWithKeys(fn (string $name) => [
                $name => Size::updateOrCreate(['name' => $name], ['name' => $name]),
            ]);

            $colors = collect([
                ['name' => 'Black', 'hex_code' => '#111111'],
                ['name' => 'Ivory', 'hex_code' => '#f4efe7'],
                ['name' => 'Taupe', 'hex_code' => '#a79787'],
                ['name' => 'Olive', 'hex_code' => '#5f6544'],
                ['name' => 'Denim', 'hex_code' => '#3f5f86'],
            ])->mapWithKeys(fn (array $data) => [
                $data['name'] => Color::updateOrCreate(['name' => $data['name']], $data),
            ]);

            $products = [
                [
                    'name' => 'Silk Column Dress',
                    'slug' => 'silk-column-dress',
                    'category' => 'dresses',
                    'brand' => 'maison-noir',
                    'price' => 1890000,
                    'sale_price' => 1590000,
                    'gender' => 'female',
                    'description' => 'A clean column silhouette with a soft drape and evening-ready finish.',
                    'variants' => [
                        ['size' => 'S', 'color' => 'Black', 'sku' => 'SKD-BLK-S', 'stock' => 12],
                        ['size' => 'M', 'color' => 'Black', 'sku' => 'SKD-BLK-M', 'stock' => 9],
                        ['size' => 'M', 'color' => 'Ivory', 'sku' => 'SKD-IVY-M', 'stock' => 7],
                    ],
                ],
                [
                    'name' => 'Oversized Tailored Blazer',
                    'slug' => 'oversized-tailored-blazer',
                    'category' => 'outerwear',
                    'brand' => 'maison-noir',
                    'price' => 2490000,
                    'sale_price' => null,
                    'gender' => 'unisex',
                    'description' => 'Structured shoulders, relaxed body and a sharp single-button front.',
                    'variants' => [
                        ['size' => 'M', 'color' => 'Black', 'sku' => 'OTB-BLK-M', 'stock' => 6],
                        ['size' => 'L', 'color' => 'Taupe', 'sku' => 'OTB-TPE-L', 'stock' => 5],
                    ],
                ],
                [
                    'name' => 'Ribbed Knit Top',
                    'slug' => 'ribbed-knit-top',
                    'category' => 'tops',
                    'brand' => 'atelier-seoul',
                    'price' => 790000,
                    'sale_price' => 690000,
                    'gender' => 'female',
                    'description' => 'Fine rib knit with a close fit and soft stretch.',
                    'variants' => [
                        ['size' => 'S', 'color' => 'Ivory', 'sku' => 'RKT-IVY-S', 'stock' => 18],
                        ['size' => 'M', 'color' => 'Olive', 'sku' => 'RKT-OLV-M', 'stock' => 11],
                    ],
                ],
                [
                    'name' => 'Wide Leg Trousers',
                    'slug' => 'wide-leg-trousers',
                    'category' => 'bottoms',
                    'brand' => 'atelier-seoul',
                    'price' => 1190000,
                    'sale_price' => null,
                    'gender' => 'unisex',
                    'description' => 'Wide-leg trousers with a high waist and clean pressed line.',
                    'variants' => [
                        ['size' => 'M', 'color' => 'Black', 'sku' => 'WLT-BLK-M', 'stock' => 10],
                        ['size' => 'L', 'color' => 'Taupe', 'sku' => 'WLT-TPE-L', 'stock' => 8],
                    ],
                ],
                [
                    'name' => 'Cropped Denim Jacket',
                    'slug' => 'cropped-denim-jacket',
                    'category' => 'outerwear',
                    'brand' => 'street-edit',
                    'price' => 1390000,
                    'sale_price' => 990000,
                    'gender' => 'unisex',
                    'description' => 'Cropped denim jacket with a boxy frame and washed blue tone.',
                    'variants' => [
                        ['size' => 'S', 'color' => 'Denim', 'sku' => 'CDJ-DNM-S', 'stock' => 13],
                        ['size' => 'M', 'color' => 'Denim', 'sku' => 'CDJ-DNM-M', 'stock' => 4],
                    ],
                ],
                [
                    'name' => 'Pleated Midi Skirt',
                    'slug' => 'pleated-midi-skirt',
                    'category' => 'bottoms',
                    'brand' => 'maison-noir',
                    'price' => 1290000,
                    'sale_price' => null,
                    'gender' => 'female',
                    'description' => 'Fluid pleats with a mid-length hem and subtle movement.',
                    'variants' => [
                        ['size' => 'S', 'color' => 'Black', 'sku' => 'PMS-BLK-S', 'stock' => 5],
                        ['size' => 'M', 'color' => 'Ivory', 'sku' => 'PMS-IVY-M', 'stock' => 6],
                    ],
                ],
            ];

            $seededVariants = collect();

            foreach ($products as $data) {
                $product = Product::updateOrCreate(
                    ['slug' => $data['slug']],
                    [
                        'category_id' => $categories[$data['category']]->id,
                        'brand_id' => $brands[$data['brand']]->id,
                        'name' => $data['name'],
                        'description' => $data['description'],
                        'price' => $data['price'],
                        'sale_price' => $data['sale_price'],
                        'gender' => $data['gender'],
                        'status' => true,
                    ],
                );

                foreach ($data['variants'] as $variantData) {
                    $variant = ProductVariant::updateOrCreate(
                        ['sku' => $variantData['sku']],
                        [
                            'product_id' => $product->id,
                            'size_id' => $sizes[$variantData['size']]->id,
                            'color_id' => $colors[$variantData['color']]->id,
                            'price' => $data['sale_price'] ?: $data['price'],
                            'stock' => $variantData['stock'],
                        ],
                    );

                    $seededVariants->push($variant->fresh(['product', 'size', 'color']));
                }
            }

            Coupon::updateOrCreate(
                ['code' => 'WELCOME10'],
                [
                    'discount_type' => 'percent',
                    'discount_value' => 10,
                    'start_date' => now()->subDay()->toDateString(),
                    'end_date' => now()->addMonths(3)->toDateString(),
                    'status' => true,
                ],
            );

            Coupon::updateOrCreate(
                ['code' => 'FREESHIP50'],
                [
                    'discount_type' => 'fixed',
                    'discount_value' => 50000,
                    'start_date' => now()->subDay()->toDateString(),
                    'end_date' => now()->addMonths(3)->toDateString(),
                    'status' => true,
                ],
            );

            if (Schema::hasTable('settings')) {
                foreach ([
                    ['key' => 'site_name', 'value' => 'STORE', 'type' => 'text', 'group_name' => 'general', 'is_public' => true],
                    ['key' => 'site_email', 'value' => 'support@store.local', 'type' => 'text', 'group_name' => 'general', 'is_public' => true],
                    ['key' => 'site_hotline', 'value' => '0900 000 000', 'type' => 'text', 'group_name' => 'general', 'is_public' => true],
                    ['key' => 'site_address', 'value' => '12 Nguyen Hue, District 1, Ho Chi Minh City', 'type' => 'textarea', 'group_name' => 'general', 'is_public' => true],
                    ['key' => 'footer_description', 'value' => 'Minimal fashion, editorial styling and modern ecommerce CMS controls.', 'type' => 'textarea', 'group_name' => 'footer', 'is_public' => true],
                    ['key' => 'site_facebook', 'value' => 'https://facebook.com/store', 'type' => 'text', 'group_name' => 'social', 'is_public' => true],
                    ['key' => 'site_instagram', 'value' => 'https://instagram.com/store', 'type' => 'text', 'group_name' => 'social', 'is_public' => true],
                    ['key' => 'site_tiktok', 'value' => '', 'type' => 'text', 'group_name' => 'social', 'is_public' => true],
                    ['key' => 'site_zalo', 'value' => '', 'type' => 'text', 'group_name' => 'social', 'is_public' => true],
                    ['key' => 'primary_color', 'value' => '#111111', 'type' => 'color', 'group_name' => 'theme', 'is_public' => true],
                    ['key' => 'accent_color', 'value' => '#D6C4A1', 'type' => 'color', 'group_name' => 'theme', 'is_public' => true],
                    ['key' => 'default_meta_title', 'value' => 'Fashion Ecommerce CMS', 'type' => 'text', 'group_name' => 'seo', 'is_public' => true],
                    ['key' => 'default_meta_description', 'value' => 'Premium fashion ecommerce storefront with configurable CMS settings.', 'type' => 'textarea', 'group_name' => 'seo', 'is_public' => true],
                ] as $setting) {
                    Setting::updateOrCreate(['key' => $setting['key']], $setting);
                }
            }

            if (Schema::hasTable('banners')) {
                foreach ([
                    [
                        'title' => 'Quiet Luxury For Every Day',
                        'subtitle' => 'Tailored essentials, soft silhouettes and seasonless layers for the modern wardrobe.',
                        'image' => 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=2200&q=85',
                        'button_text' => 'Explore Collection',
                        'button_url' => '/products',
                        'position' => 'home_hero',
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'Soft Tailoring',
                        'subtitle' => 'Blazers and trousers with relaxed structure.',
                        'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1000&q=85',
                        'button_text' => 'Shop Outerwear',
                        'button_url' => '/products',
                        'position' => 'home_promo',
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'The Minimal Dress',
                        'subtitle' => 'Clean lines for day-to-evening dressing.',
                        'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=1000&q=85',
                        'button_text' => 'Shop Dresses',
                        'button_url' => '/products',
                        'position' => 'home_promo',
                        'sort_order' => 2,
                    ],
                    [
                        'title' => 'Sale Edit',
                        'subtitle' => 'Selected wardrobe pieces at reduced prices.',
                        'image' => 'https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?auto=format&fit=crop&w=1000&q=85',
                        'button_text' => 'Shop Sale',
                        'button_url' => '/products',
                        'position' => 'home_promo',
                        'sort_order' => 3,
                    ],
                ] as $banner) {
                    Banner::updateOrCreate(
                        [
                            'position' => $banner['position'],
                            'sort_order' => $banner['sort_order'],
                        ],
                        $banner + [
                            'status' => true,
                            'starts_at' => null,
                            'ends_at' => null,
                        ],
                    );
                }
            }

            if (Schema::hasTable('pages')) {
                foreach ([
                    [
                        'title' => 'About STORE',
                        'slug' => 'about',
                        'excerpt' => 'A calm fashion storefront shaped around minimal design and practical CMS controls.',
                        'content' => "STORE is a fashion ecommerce CMS built for boutique retail experiences.\n\nIt combines an editorial storefront with admin controls for products, banners, pages, settings, orders and customer management.\n\nThe project is designed to work as a graduation project, portfolio piece and reusable client foundation.",
                        'template' => 'about',
                    ],
                    [
                        'title' => 'Contact',
                        'slug' => 'contact',
                        'excerpt' => 'Reach the STORE team for product, order and partnership questions.',
                        'content' => "Email: support@store.local\nHotline: 0900 000 000\nAddress: 12 Nguyen Hue, District 1, Ho Chi Minh City\n\nSupport hours: Monday to Saturday, 9:00 - 18:00.",
                        'template' => 'contact',
                    ],
                    [
                        'title' => 'Shipping Policy',
                        'slug' => 'shipping-policy',
                        'excerpt' => 'Domestic shipping information for orders placed through STORE.',
                        'content' => "Standard shipping usually takes 2-4 business days.\n\nOrders above the configured free-shipping threshold may receive discounted or free delivery depending on active shipping settings.\n\nDelivery timelines can vary during promotions and holidays.",
                        'template' => 'policy',
                    ],
                    [
                        'title' => 'Return Policy',
                        'slug' => 'return-policy',
                        'excerpt' => 'Return and exchange guidance for eligible products.',
                        'content' => "Products can be returned or exchanged when they are unused, unwashed and still include original tags.\n\nReturn requests should be sent within the configured return window.\n\nFinal sale items and damaged-by-use products may be excluded.",
                        'template' => 'policy',
                    ],
                    [
                        'title' => 'FAQ',
                        'slug' => 'faq',
                        'excerpt' => 'Common questions about shopping with STORE.',
                        'content' => "How do I track my order?\nYou can view your orders after logging in.\n\nCan I change my shipping address?\nPlease contact support before the order enters shipping status.\n\nWhich payment methods are supported?\nThe demo supports COD, bank transfer, MoMo and VNPay-ready payment tracking.",
                        'template' => 'faq',
                    ],
                ] as $page) {
                    Page::updateOrCreate(
                        ['slug' => $page['slug']],
                        $page + [
                            'meta_title' => $page['title'].' - STORE',
                            'meta_description' => $page['excerpt'],
                            'canonical_url' => null,
                            'og_image' => null,
                            'status' => 'published',
                            'published_at' => now(),
                        ],
                    );
                }
            }

            if (Schema::hasTable('blog_categories') && Schema::hasTable('blogs')) {
                $journalCategories = collect([
                    ['name' => 'Style Notes', 'slug' => 'style-notes', 'description' => 'Practical styling ideas for everyday dressing.'],
                    ['name' => 'Lookbook', 'slug' => 'lookbook', 'description' => 'Editorial outfit stories and seasonal edits.'],
                    ['name' => 'Care Guide', 'slug' => 'care-guide', 'description' => 'How to care for fabrics and wardrobe staples.'],
                ])->mapWithKeys(fn (array $data) => [
                    $data['slug'] => BlogCategory::updateOrCreate(
                        ['slug' => $data['slug']],
                        $data + ['status' => true],
                    ),
                ]);

                foreach ([
                    [
                        'category' => 'style-notes',
                        'title' => 'How to Build a Minimal Work Wardrobe',
                        'slug' => 'minimal-work-wardrobe',
                        'excerpt' => 'Start with sharp trousers, a quiet blazer and tops that layer easily.',
                        'content' => "A minimal work wardrobe begins with repeatable shapes.\n\nChoose trousers with a clean line, a blazer that works open or closed, and knit tops that can layer under outerwear without bulk.\n\nKeep the palette tight: black, ivory, taupe and one seasonal accent are enough for a strong week of outfits.",
                        'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1400&q=85',
                    ],
                    [
                        'category' => 'lookbook',
                        'title' => 'The Soft Tailoring Edit',
                        'slug' => 'soft-tailoring-edit',
                        'excerpt' => 'Relaxed structure, tonal layers and a little movement.',
                        'content' => "Soft tailoring is about ease without losing shape.\n\nPair an oversized blazer with wide-leg trousers, then ground the look with a ribbed knit or silk dress.\n\nThe result feels polished but still comfortable enough for real daily movement.",
                        'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=1400&q=85',
                    ],
                    [
                        'category' => 'care-guide',
                        'title' => 'Caring for Knitwear and Delicate Fabrics',
                        'slug' => 'care-for-knitwear-delicates',
                        'excerpt' => 'Small care habits help your favorite pieces last longer.',
                        'content' => "Wash delicate fabrics in cold water and avoid aggressive spin cycles.\n\nKnitwear should be dried flat to preserve shape. Store folded rather than hanging when the fabric is heavy or stretchy.\n\nA fabric shaver, garment bag and gentle detergent are simple tools that make a visible difference.",
                        'image' => 'https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?auto=format&fit=crop&w=1400&q=85',
                    ],
                ] as $post) {
                    Blog::updateOrCreate(
                        ['slug' => $post['slug']],
                        [
                            'blog_category_id' => $journalCategories[$post['category']]->id,
                            'user_id' => $admin->id,
                            'title' => $post['title'],
                            'excerpt' => $post['excerpt'],
                            'content' => $post['content'],
                            'image' => $post['image'],
                            'meta_title' => $post['title'].' - STORE Journal',
                            'meta_description' => $post['excerpt'],
                            'canonical_url' => null,
                            'og_image' => $post['image'],
                            'status' => 'published',
                            'published_at' => now()->subDays(rand(1, 14)),
                        ],
                    );
                }
            }

            if (Schema::hasTable('menus') && Schema::hasTable('menu_items')) {
                foreach ([
                    [
                        'menu' => ['name' => 'Header Menu', 'slug' => 'header-menu', 'location' => 'header'],
                        'items' => [
                            ['title' => 'Women', 'url' => '/products?gender=female', 'sort_order' => 1],
                            ['title' => 'Men', 'url' => '/products?gender=male', 'sort_order' => 2],
                            ['title' => 'New Arrival', 'url' => '/products?sort=newest', 'sort_order' => 3],
                            ['title' => 'Sale', 'url' => '/products', 'sort_order' => 4],
                            ['title' => 'Journal', 'url' => '/journal', 'sort_order' => 5],
                        ],
                    ],
                    [
                        'menu' => ['name' => 'Footer Service Menu', 'slug' => 'footer-service-menu', 'location' => 'footer_service'],
                        'items' => [
                            ['title' => 'Contact', 'url' => '/pages/contact', 'sort_order' => 1],
                            ['title' => 'Shipping', 'url' => '/pages/shipping-policy', 'sort_order' => 2],
                            ['title' => 'Returns', 'url' => '/pages/return-policy', 'sort_order' => 3],
                            ['title' => 'FAQ', 'url' => '/pages/faq', 'sort_order' => 4],
                            ['title' => 'Journal', 'url' => '/journal', 'sort_order' => 5],
                        ],
                    ],
                    [
                        'menu' => ['name' => 'Footer Account Menu', 'slug' => 'footer-account-menu', 'location' => 'footer_account'],
                        'items' => [
                            ['title' => 'Login', 'url' => '/login', 'sort_order' => 1],
                            ['title' => 'Register', 'url' => '/register', 'sort_order' => 2],
                            ['title' => 'Orders', 'url' => '/orders', 'sort_order' => 3],
                            ['title' => 'Cart', 'url' => '/cart', 'sort_order' => 4],
                        ],
                    ],
                ] as $group) {
                    $menu = Menu::updateOrCreate(
                        ['slug' => $group['menu']['slug']],
                        $group['menu'] + ['status' => true],
                    );

                    foreach ($group['items'] as $item) {
                        MenuItem::updateOrCreate(
                            [
                                'menu_id' => $menu->id,
                                'title' => $item['title'],
                            ],
                            $item + [
                                'parent_id' => null,
                                'target' => '_self',
                                'status' => true,
                            ],
                        );
                    }
                }
            }

            if (Schema::hasTable('shipping_methods')) {
                foreach ([
                    [
                        'name' => 'Standard Shipping',
                        'code' => 'standard',
                        'description' => 'Domestic delivery in 2-4 business days.',
                        'fee' => 30000,
                        'min_order_value' => 1500000,
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Express Shipping',
                        'code' => 'express',
                        'description' => 'Priority delivery in 1-2 business days.',
                        'fee' => 60000,
                        'min_order_value' => 2500000,
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Store Pickup',
                        'code' => 'pickup',
                        'description' => 'Pick up at the showroom after confirmation.',
                        'fee' => 0,
                        'min_order_value' => 0,
                        'sort_order' => 3,
                    ],
                ] as $method) {
                    ShippingMethod::updateOrCreate(
                        ['code' => $method['code']],
                        $method + ['status' => true],
                    );
                }
            }

            if (Schema::hasTable('payment_methods')) {
                foreach ([
                    [
                        'code' => 'cod',
                        'name' => 'Cash on Delivery',
                        'description' => 'Pay when the order arrives.',
                        'config' => [],
                        'sort_order' => 1,
                    ],
                    [
                        'code' => 'bank_transfer',
                        'name' => 'Bank Transfer',
                        'description' => 'Transfer to the store account after placing the order.',
                        'config' => [
                            'bank_name' => 'Demo Bank',
                            'account_number' => '123456789',
                            'account_name' => 'STORE COMPANY',
                        ],
                        'sort_order' => 2,
                    ],
                    [
                        'code' => 'momo',
                        'name' => 'MoMo',
                        'description' => 'MoMo wallet payment tracking for demo orders.',
                        'config' => [
                            'phone' => '0900000000',
                            'account_name' => 'STORE',
                        ],
                        'sort_order' => 3,
                    ],
                    [
                        'code' => 'vnpay',
                        'name' => 'VNPay',
                        'description' => 'VNPay-ready payment method configuration.',
                        'config' => [
                            'terminal_code' => 'DEMO_STORE',
                            'sandbox' => true,
                        ],
                        'sort_order' => 4,
                    ],
                ] as $method) {
                    PaymentMethod::updateOrCreate(
                        ['code' => $method['code']],
                        $method + ['status' => true],
                    );
                }
            }

            $cart = Cart::firstOrCreate(['user_id' => $customer->id]);
            foreach ($seededVariants->take(2) as $variant) {
                CartItem::updateOrCreate(
                    [
                        'cart_id' => $cart->id,
                        'product_variant_id' => $variant->id,
                    ],
                    ['quantity' => 1],
                );
            }

            foreach (Product::query()->take(3)->get() as $product) {
                Wishlist::firstOrCreate([
                    'user_id' => $customer->id,
                    'product_id' => $product->id,
                ]);
            }

            $orderVariant = $seededVariants->first();
            if ($orderVariant) {
                $order = Order::updateOrCreate(
                    [
                        'user_id' => $customer->id,
                        'customer_phone' => '0901234567',
                        'status' => 'pending',
                    ],
                    [
                        'coupon_id' => null,
                        'customer_name' => 'Demo Customer',
                        'customer_address' => '12 Nguyen Hue, District 1, Ho Chi Minh City',
                        'shipping_method_code' => 'standard',
                        'shipping_method_name' => 'Standard Shipping',
                        'shipping_fee' => 0,
                        'total_price' => $orderVariant->price,
                        'discount_amount' => 0,
                        'final_price' => $orderVariant->price,
                    ],
                );

                $order->details()->delete();
                $order->details()->create([
                    'product_variant_id' => $orderVariant->id,
                    'product_name' => $orderVariant->product->name,
                    'size_name' => $orderVariant->size?->name,
                    'color_name' => $orderVariant->color?->name,
                    'price' => $orderVariant->price,
                    'quantity' => 1,
                    'subtotal' => $orderVariant->price,
                ]);

                $order->payment()->updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'payment_method' => 'cod',
                        'payment_status' => 'unpaid',
                        'paid_at' => null,
                    ],
                );

                Notification::updateOrCreate(
                    [
                        'user_id' => $customer->id,
                        'type' => 'order',
                        'title' => 'Order received',
                    ],
                    [
                        'message' => 'Your demo order has been created and is waiting for confirmation.',
                        'data' => ['url' => '/orders/'.$order->id],
                        'read_at' => null,
                    ],
                );
            }

            Notification::updateOrCreate(
                [
                    'user_id' => null,
                    'type' => 'promotion',
                    'title' => 'WELCOME10 is active',
                ],
                [
                    'message' => 'Use WELCOME10 for 10% off selected wardrobe pieces.',
                    'data' => ['url' => '/products'],
                    'read_at' => null,
                ],
            );

            Notification::updateOrCreate(
                [
                    'user_id' => $admin->id,
                    'type' => 'system',
                    'title' => 'CMS setup checklist',
                ],
                [
                    'message' => 'Core demo data, settings, banners, pages, blog, reviews and wishlist modules are ready.',
                    'data' => ['url' => '/admin'],
                    'read_at' => now(),
                ],
            );

            foreach (Product::query()->take(4)->get() as $index => $product) {
                Review::updateOrCreate(
                    [
                        'user_id' => $customer->id,
                        'product_id' => $product->id,
                    ],
                    [
                        'order_id' => Order::where('user_id', $customer->id)->value('id'),
                        'rating' => [5, 5, 4, 4][$index] ?? 5,
                        'comment' => [
                            'The fabric feels refined and the fit is easy to style.',
                            'A clean wardrobe piece. The color is exactly what I expected.',
                            'Good tailoring and comfortable for all-day wear.',
                            'Nice silhouette, especially with simple layers.',
                        ][$index] ?? 'Great product.',
                        'images' => null,
                        'status' => $index === 3 ? 'pending' : 'approved',
                    ],
                );
            }

            $admin->touch();
        });
    }
}
