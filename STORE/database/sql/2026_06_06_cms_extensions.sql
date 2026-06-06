-- Fashion Ecommerce CMS extension schema.
-- Safe to run multiple times. Existing ecommerce tables are not renamed.

ALTER TABLE users
MODIFY role ENUM('super_admin','admin','staff','customer') DEFAULT 'customer';

CREATE TABLE IF NOT EXISTS settings (
    id BIGINT NOT NULL AUTO_INCREMENT,
    `key` VARCHAR(150) NOT NULL,
    `value` LONGTEXT NULL,
    type VARCHAR(50) NOT NULL DEFAULT 'text',
    group_name VARCHAR(100) NOT NULL DEFAULT 'general',
    is_public TINYINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY settings_key_unique (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS themes (
    id BIGINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL,
    view_path VARCHAR(150) NOT NULL,
    config JSON NULL,
    is_active TINYINT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY themes_slug_unique (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS banners (
    id BIGINT NOT NULL AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    subtitle VARCHAR(255) NULL,
    image VARCHAR(255) NULL,
    button_text VARCHAR(100) NULL,
    button_url VARCHAR(255) NULL,
    position VARCHAR(100) NOT NULL DEFAULT 'home_hero',
    sort_order INT NOT NULL DEFAULT 0,
    status TINYINT NOT NULL DEFAULT 1,
    starts_at DATETIME NULL,
    ends_at DATETIME NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY banners_position_status_index (position, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS pages (
    id BIGINT NOT NULL AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL,
    excerpt TEXT NULL,
    content LONGTEXT NULL,
    template VARCHAR(100) NOT NULL DEFAULT 'default',
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    canonical_url VARCHAR(255) NULL,
    og_image VARCHAR(255) NULL,
    status ENUM('draft','published') NOT NULL DEFAULT 'draft',
    published_at DATETIME NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY pages_slug_unique (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS blog_categories (
    id BIGINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(120) NOT NULL,
    slug VARCHAR(150) NOT NULL,
    description TEXT NULL,
    status TINYINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY blog_categories_slug_unique (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS blogs (
    id BIGINT NOT NULL AUTO_INCREMENT,
    blog_category_id BIGINT NULL,
    user_id BIGINT NULL,
    title VARCHAR(220) NOT NULL,
    slug VARCHAR(240) NOT NULL,
    excerpt TEXT NULL,
    content LONGTEXT NULL,
    image VARCHAR(255) NULL,
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    canonical_url VARCHAR(255) NULL,
    og_image VARCHAR(255) NULL,
    status ENUM('draft','published') NOT NULL DEFAULT 'draft',
    published_at DATETIME NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY blogs_slug_unique (slug),
    KEY blogs_blog_category_id_index (blog_category_id),
    KEY blogs_user_id_index (user_id),
    CONSTRAINT blogs_blog_category_fk FOREIGN KEY (blog_category_id) REFERENCES blog_categories(id) ON DELETE SET NULL,
    CONSTRAINT blogs_user_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS reviews (
    id BIGINT NOT NULL AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    order_id BIGINT NULL,
    rating TINYINT NOT NULL,
    comment TEXT NULL,
    images JSON NULL,
    status ENUM('pending','approved','hidden') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY reviews_user_id_index (user_id),
    KEY reviews_product_id_index (product_id),
    KEY reviews_order_id_index (order_id),
    CONSTRAINT reviews_user_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT reviews_product_fk FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    CONSTRAINT reviews_order_fk FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS wishlists (
    id BIGINT NOT NULL AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY wishlists_user_product_unique (user_id, product_id),
    CONSTRAINT wishlists_user_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT wishlists_product_fk FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS notifications (
    id BIGINT NOT NULL AUTO_INCREMENT,
    user_id BIGINT NULL,
    type VARCHAR(100) NOT NULL DEFAULT 'system',
    title VARCHAR(200) NOT NULL,
    message TEXT NULL,
    data JSON NULL,
    read_at DATETIME NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY notifications_user_id_index (user_id),
    CONSTRAINT notifications_user_fk FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS menus (
    id BIGINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(120) NOT NULL,
    slug VARCHAR(150) NOT NULL,
    location VARCHAR(100) NOT NULL DEFAULT 'header',
    status TINYINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY menus_slug_unique (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS menu_items (
    id BIGINT NOT NULL AUTO_INCREMENT,
    menu_id BIGINT NOT NULL,
    parent_id BIGINT NULL,
    title VARCHAR(120) NOT NULL,
    url VARCHAR(255) NOT NULL,
    target VARCHAR(30) NOT NULL DEFAULT '_self',
    sort_order INT NOT NULL DEFAULT 0,
    status TINYINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY menu_items_menu_id_index (menu_id),
    KEY menu_items_parent_id_index (parent_id),
    CONSTRAINT menu_items_menu_fk FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE,
    CONSTRAINT menu_items_parent_fk FOREIGN KEY (parent_id) REFERENCES menu_items(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS shipping_methods (
    id BIGINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(120) NOT NULL,
    code VARCHAR(100) NOT NULL,
    description TEXT NULL,
    fee DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    min_order_value DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    status TINYINT NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY shipping_methods_code_unique (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS payment_methods (
    id BIGINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(120) NOT NULL,
    code VARCHAR(100) NOT NULL,
    description TEXT NULL,
    config JSON NULL,
    status TINYINT NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY payment_methods_code_unique (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO settings (`key`, `value`, type, group_name, is_public) VALUES
('site_name', 'STORE', 'text', 'general', 1),
('site_hotline', '0900 000 000', 'text', 'general', 1),
('site_email', 'support@store.local', 'text', 'general', 1),
('site_address', '', 'textarea', 'general', 1),
('site_facebook', '', 'text', 'social', 1),
('site_instagram', '', 'text', 'social', 1),
('site_tiktok', '', 'text', 'social', 1),
('site_zalo', '', 'text', 'social', 1),
('footer_description', 'Thời trang tối giản, biên tập như tạp chí và được hoàn thiện cho nhịp sống hiện đại.', 'textarea', 'footer', 1),
('primary_color', '#111111', 'color', 'theme', 1),
('accent_color', '#D6C4A1', 'color', 'theme', 1),
('default_meta_title', 'Fashion Ecommerce CMS', 'text', 'seo', 1),
('default_meta_description', 'Website thời trang cao cấp, tối giản và có thể cấu hình trong Admin CMS.', 'textarea', 'seo', 1);

INSERT IGNORE INTO themes (name, slug, view_path, is_active) VALUES
('Zara Luxury', 'zara', 'themes.zara', 1),
('Korean Minimal', 'korean', 'themes.korean', 0),
('Streetwear Dark', 'streetwear', 'themes.streetwear', 0),
('Fashion Editorial', 'editorial', 'themes.editorial', 0);

INSERT IGNORE INTO shipping_methods (name, code, description, fee, min_order_value, status, sort_order) VALUES
('Giao tiêu chuẩn', 'standard', 'Giao hàng tiêu chuẩn toàn quốc.', 30000.00, 0.00, 1, 1),
('Giao nhanh', 'express', 'Giao nhanh trong khu vực hỗ trợ.', 50000.00, 0.00, 1, 2),
('Miễn phí vận chuyển', 'free_shipping', 'Áp dụng cho đơn đạt giá trị tối thiểu.', 0.00, 500000.00, 1, 3);

INSERT IGNORE INTO payment_methods (name, code, description, status, sort_order) VALUES
('COD', 'cod', 'Thanh toán khi nhận hàng.', 1, 1),
('Chuyển khoản', 'bank_transfer', 'Thanh toán qua chuyển khoản ngân hàng.', 1, 2),
('VNPay', 'vnpay', 'Sẵn sàng mở rộng thanh toán VNPay.', 0, 3),
('MoMo', 'momo', 'Sẵn sàng mở rộng thanh toán MoMo.', 0, 4);
