-- YBT Digital database schema
CREATE DATABASE IF NOT EXISTS ybt_digital DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ybt_digital;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    reset_token VARCHAR(64) DEFAULT NULL,
    reset_expires DATETIME DEFAULT NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('super','editor') NOT NULL DEFAULT 'editor',
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(300) NOT NULL,
    file_path VARCHAR(300) NOT NULL,
    status TINYINT(1) NOT NULL DEFAULT 1,
    featured TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    transaction_id VARCHAR(120) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    tax_amount DECIMAL(10,2) NOT NULL,
    discount_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(80) NOT NULL DEFAULT 'Confirmed',
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS coupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(60) NOT NULL UNIQUE,
    type ENUM('flat','percentage') NOT NULL,
    value DECIMAL(10,2) NOT NULL,
    expires_at DATE NOT NULL,
    uses_left INT NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    value TEXT NOT NULL,
    updated_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO settings (name, value, updated_at) VALUES
('site_title', 'YBT Digital', NOW()),
('currency', 'INR', NOW()),
('tax_rate', '18', NOW()),
('stripe_key', 'sk_test_XXXX', NOW()),
('paypal_client_id', 'sb-XXXX', NOW()),
('razorpay_key', 'rzp_test_XXXX', NOW());

CREATE TABLE IF NOT EXISTS support_tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO admins (name, email, password, role, created_at) VALUES
('Super Admin', 'admin@ybt.digital', '$2y$10$hQ/8uCYp3rMg2gIYZoFfiOHspdiM8unYhI5XPY3E/GHHZkP2aNkP6', 'super', NOW());

INSERT INTO products (title, description, category, price, image_url, file_path, status, featured, created_at) VALUES
('Premium Landing Page Kit', 'A bundle of responsive HTML templates built for SaaS landing pages.', 'Templates', 999.00, 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=800&q=80', 'downloads/landing-kit.zip', 1, 1, NOW()),
('Growth Analytics Dashboard', 'A modern analytics dashboard UI ready for integration with any backend.', 'UI Kits', 1299.00, 'https://images.unsplash.com/photo-1556761175-4b46a572b786?auto=format&fit=crop&w=800&q=80', 'downloads/analytics-dashboard.zip', 1, 1, NOW()),
('Ebook Bundle for Creators', 'A set of ebooks, resources, and checklists for digital creators.', 'Ebooks', 499.00, 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=800&q=80', 'downloads/ebook-bundle.zip', 1, 0, NOW());

INSERT INTO coupons (code, type, value, expires_at, uses_left, created_at) VALUES
('WELCOME10', 'percentage', 10.00, DATE_ADD(CURDATE(), INTERVAL 30 DAY), 100, NOW());
