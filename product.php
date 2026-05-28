<?php
$pageTitle = 'Product Details';
require_once __DIR__ . '/includes/header.php';
$productId = intval($_GET['id'] ?? 0);
$product = getProductById($productId);

if (!$product) {
    echo '<div class="section"><div class="card card-body">Product not found.</div></div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addToCart($productId, intval($_POST['quantity'] ?? 1));
    redirect(BASE_URL . 'cart.php');
}
?>
<section class="section">
    <div style="display:grid;grid-template-columns:1.2fr .8fr;gap:32px;align-items:start;">
        <div>
            <img class="product-image" src="<?= sanitize($product['image_url']) ?>" alt="<?= sanitize($product['title']) ?>">
            <h1 style="margin-top:24px;"><?= sanitize($product['title']) ?></h1>
            <p style="color: var(--muted); max-width: 760px;"><?= nl2br(sanitize($product['description'])) ?></p>
            <section style="margin-top:32px;">
                <h3>Product details</h3>
                <ul style="color: var(--muted); line-height:1.8;">
                    <li>Category: <?= sanitize($product['category']) ?></li>
                    <li>Status: <?= $product['status'] ? 'Active' : 'Inactive' ?></li>
                    <li>Instant digital download after purchase</li>
                </ul>
            </section>
        </div>
        <aside class="card card-body" style="position:sticky; top:24px;">
            <div class="card-meta"><span>Price</span><span><?= CURRENCY . number_format($product['price'], 2) ?></span></div>
            <form method="post" style="display:grid; gap:16px;">
                <div class="input-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" min="1" value="1">
                </div>
                <button type="submit" class="button">Add to Cart</button>
                <a href="<?= BASE_URL ?>checkout.php" class="button button-secondary">Buy Now</a>
            </form>
            <div style="margin-top:20px; color: var(--muted);">
                <strong>Related Products</strong>
                <p>Check the product listing to discover similar digital assets.</p>
            </div>
        </aside>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php';
