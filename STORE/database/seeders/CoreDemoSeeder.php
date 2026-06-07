<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Color;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Setting;
use App\Models\ShippingMethod;
use App\Models\Size;
use App\Models\User;
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

            if (Schema::hasTable('shipping_methods')) {
                ShippingMethod::updateOrCreate(
                    ['code' => 'standard'],
                    [
                        'name' => 'Standard Shipping',
                        'description' => 'Domestic delivery in 2-4 business days.',
                        'fee' => 30000,
                        'min_order_value' => 1500000,
                        'status' => true,
                        'sort_order' => 1,
                    ],
                );
            }

            if (Schema::hasTable('payment_methods')) {
                PaymentMethod::updateOrCreate(
                    ['code' => 'cod'],
                    [
                        'name' => 'Cash on Delivery',
                        'description' => 'Pay when the order arrives.',
                        'config' => [],
                        'status' => true,
                        'sort_order' => 1,
                    ],
                );
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
            }

            $admin->touch();
        });
    }
}
