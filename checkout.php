<?php
$pageTitle = 'Checkout';
require_once __DIR__ . '/includes/header.php';

if (!isLoggedIn()) {
    $_SESSION['redirect_after_login'] = basename($_SERVER['SCRIPT_NAME']);
    redirect(BASE_URL . 'login.php');
}

$items = getCartItems();
if (empty($items)) {
    echo '<section class="section"><div class="card card-body">Your cart is empty. <a href="' . BASE_URL . 'products.php">Browse products</a>.</div></section>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$message = '';
$coupon = null;
$discount = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['coupon'])) {
        $coupon = applyCouponCode($_POST['coupon']);
        if (!$coupon) {
            $message = 'Invalid or expired coupon code.';
        } else {
            $message = 'Coupon applied successfully.';
        }
    }
    if (!empty($_POST['place_order'])) {
        $coupon = !empty($_POST['coupon']) ? applyCouponCode($_POST['coupon']) : null;
        $orderId = createOrder($_SESSION['user_id'], $items, $coupon, $_POST['payment_method'] ?? 'offline');
        redirect(BASE_URL . 'orders.php?created=' . $orderId);
    }
}

$subtotal = cartTotal($items);
$tax = round($subtotal * TAX_RATE / 100, 2);
?>
<section class="section">
    <div class="section-title">Checkout</div>
    <?php if ($message): ?>
        <div class="alert"><?= sanitize($message) ?></div>
    <?php endif; ?>
    <div class="profile-grid">
        <div class="card card-body">
            <h3>Order summary</h3>
            <div style="display:grid; gap:12px; margin-top:18px;">
                <?php foreach ($items as $item): ?>
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                        <span><?= sanitize($item['title']) ?> x<?= $item['quantity'] ?></span>
                        <span><?= CURRENCY . number_format($item['price'] * $item['quantity'], 2) ?></span>
                    </div>
                <?php endforeach; ?>
                <div style="display:flex; justify-content:space-between; padding-top:12px; border-top:1px solid var(--border);">
                    <strong>Subtotal</strong>
                    <strong><?= CURRENCY . number_format($subtotal, 2) ?></strong>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span>Tax (<?= TAX_RATE ?>%)</span>
                    <span><?= CURRENCY . number_format($tax, 2) ?></span>
                </div>
            </div>
        </div>
        <div class="card card-body">
            <h3>Payment</h3>
            <form method="post" style="display:grid; gap:18px;">
                <label class="input-group">
                    <span>Apply coupon</span>
                    <input type="text" name="coupon" placeholder="Enter code">
                </label>
                <label class="input-group">
                    <span>Payment gateway</span>
                    <select name="payment_method">
                        <option value="stripe">Stripe</option>
                        <option value="paypal">PayPal</option>
                        <option value="razorpay">Razorpay</option>
                        <option value="offline">Pay Later</option>
                    </select>
                </label>
                <div style="padding:18px; border-radius:20px; background: var(--surface-strong);">
                    <div style="display:flex; justify-content:space-between; margin-bottom:12px;"><span>Discount</span><span><?= $coupon ? CURRENCY . number_format($discount, 2) : '—' ?></span></div>
                    <div style="display:flex; justify-content:space-between; font-weight:700;"><span>Total</span><span><?= CURRENCY . number_format($subtotal + $tax - $discount, 2) ?></span></div>
                </div>
                <button type="submit" name="place_order" class="button">Place Order</button>
            </form>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php';
