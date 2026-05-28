<?php
$pageTitle = 'Cart';
require_once __DIR__ . '/includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove'])) {
        removeFromCart(intval($_POST['remove']));
    }
    if (!empty($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $id => $quantity) {
            setCartQuantity(intval($id), intval($quantity));
        }
    }
    redirect(BASE_URL . 'cart.php');
}

$items = getCartItems();
$total = cartTotal($items);
?>
<section class="section">
    <div class="section-title">Your Cart</div>
    <?php if (empty($items)): ?>
        <div class="card card-body">Your cart is empty. <a href="<?= BASE_URL ?>products.php">Browse products</a>.</div>
    <?php else: ?>
        <form method="post" class="card card-body">
            <div style="display:grid; gap:18px;">
                <?php foreach ($items as $item): ?>
                    <div style="display:grid; gap:12px; padding:16px; border:1px solid var(--border); border-radius:20px; background: var(--surface-strong);">
                        <div style="display:flex; gap:16px; align-items:center;">
                            <img src="<?= sanitize($item['image_url']) ?>" alt="<?= sanitize($item['title']) ?>" style="width:90px; border-radius:18px; object-fit:cover;">
                            <div>
                                <h3 style="margin:0;"><?= sanitize($item['title']) ?></h3>
                                <p style="margin:8px 0 0; color: var(--muted);"><?= CURRENCY . number_format($item['price'], 2) ?> each</p>
                            </div>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap;">
                            <label style="display:flex; gap:8px; align-items:center;">
                                Qty
                                <input type="number" name="quantities[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" style="width:80px; padding:10px 12px;">
                            </label>
                            <span style="font-weight:700;">Subtotal: <?= CURRENCY . number_format($item['price'] * $item['quantity'], 2) ?></span>
                            <button type="submit" name="remove" value="<?= $item['id'] ?>" class="button button-secondary" style="padding:10px 16px;">Remove</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div style="display:flex; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-top:24px; align-items:center;">
                <div><strong>Total:</strong> <?= CURRENCY . number_format($total, 2) ?></div>
                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    <button type="submit" class="button">Update Cart</button>
                    <a href="<?= BASE_URL ?>checkout.php" class="button button-secondary">Checkout</a>
                </div>
            </div>
        </form>
    <?php endif; ?>
</section>
<?php require_once __DIR__ . '/includes/footer.php';
