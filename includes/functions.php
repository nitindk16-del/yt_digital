<?php
function url($path = '') {
    return rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/' . ltrim($path, '/');
}

function sanitize($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function redirect($path) {
    header('Location: ' . $path);
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['admin_id']);
}

function currentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    return db_fetch('SELECT * FROM users WHERE id = ?', [$_SESSION['user_id']]);
}

function currentAdmin() {
    if (!isAdmin()) {
        return null;
    }
    return db_fetch('SELECT * FROM admins WHERE id = ?', [$_SESSION['admin_id']]);
}

function getProducts($filters = []) {
    $sql = 'SELECT * FROM products WHERE status = 1';
    $params = [];
    if (!empty($filters['category'])) {
        $sql .= ' AND category = ?';
        $params[] = $filters['category'];
    }
    if (!empty($filters['search'])) {
        $sql .= ' AND (title LIKE ? OR description LIKE ?)';
        $params[] = '%' . $filters['search'] . '%';
        $params[] = '%' . $filters['search'] . '%';
    }
    if (!empty($filters['featured'])) {
        $sql .= ' AND featured = 1';
    }
    if (!empty($filters['limit'])) {
        $sql .= ' LIMIT ?';
        $params[] = intval($filters['limit']);
    }
    return db_fetch_all($sql, $params);
}

function getProductById($id) {
    return db_fetch('SELECT * FROM products WHERE id = ? AND status = 1', [$id]);
}

function getCategories() {
    return db_fetch_all('SELECT DISTINCT category FROM products WHERE status = 1 ORDER BY category');
}

function addToCart($productId, $quantity = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 0;
    }
    $_SESSION['cart'][$productId] += max(1, intval($quantity));
}

function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

function setCartQuantity($productId, $quantity) {
    if ($quantity < 1) {
        removeFromCart($productId);
    } else {
        $_SESSION['cart'][$productId] = intval($quantity);
    }
}

function getCartItems() {
    $items = [];
    if (empty($_SESSION['cart'])) {
        return $items;
    }
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "SELECT * FROM products WHERE id IN ($placeholders)";
    $stmt = db_query($sql, $ids);
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $row['quantity'] = $_SESSION['cart'][$row['id']];
        $items[] = $row;
    }
    return $items;
}

function cartTotal($items) {
    $total = 0;
    foreach ($items as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

function applyCouponCode($code) {
    $coupon = db_fetch('SELECT * FROM coupons WHERE code = ? AND expires_at >= CURDATE() AND uses_left > 0', [strtoupper($code)]);
    if (!$coupon) {
        return null;
    }
    return $coupon;
}

function createOrder($userId, $items, $coupon = null, $paymentMethod = 'offline') {
    $subtotal = cartTotal($items);
    $tax = round($subtotal * TAX_RATE / 100, 2);
    $discount = 0;
    if ($coupon) {
        if ($coupon['type'] === 'percentage') {
            $discount = round($subtotal * $coupon['value'] / 100, 2);
        } else {
            $discount = min($coupon['value'], $subtotal);
        }
        db_execute('UPDATE coupons SET uses_left = uses_left - 1 WHERE id = ?', [$coupon['id']]);
    }
    $total = round($subtotal + $tax - $discount, 2);
    $transactionId = 'TXN' . time() . rand(100, 999);
    db_execute('INSERT INTO orders (user_id, transaction_id, payment_method, subtotal, tax_amount, discount_amount, total_amount, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())', [$userId, $transactionId, $paymentMethod, $subtotal, $tax, $discount, $total, 'Confirmed']);
    $orderId = db_fetch('SELECT LAST_INSERT_ID() AS id')['id'];
    foreach ($items as $item) {
        db_execute('INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)', [$orderId, $item['id'], $item['quantity'], $item['price']]);
    }
    $_SESSION['cart'] = [];
    return $orderId;
}

function getUserOrders($userId) {
    return db_fetch_all('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC', [$userId]);
}

function getOrderItems($orderId) {
    return db_fetch_all('SELECT oi.*, p.title, p.file_path FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?', [$orderId]);
}
