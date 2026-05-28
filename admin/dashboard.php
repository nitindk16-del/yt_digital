<?php
$pageTitle = 'Dashboard';
require_once __DIR__ . '/../includes/config.php';
if (!isAdmin()) {
    redirect(BASE_URL . 'admin/login.php');
}
$usersCount = db_fetch('SELECT COUNT(*) AS total FROM users')['total'];
$productsCount = db_fetch('SELECT COUNT(*) AS total FROM products')['total'];
$ordersCount = db_fetch('SELECT COUNT(*) AS total FROM orders')['total'];
$totalRevenue = db_fetch('SELECT SUM(total_amount) AS total FROM orders')['total'] ?: 0;
require_once __DIR__ . '/../includes/admin-header.php';
?>
<section class="section admin-hero">
    <div class="admin-hero-panel">
        <div class="section-title">Welcome back, Admin</div>
        <p class="section-intro">Your store performance dashboard gives you instant visibility over users, orders, revenue, and product activity. Use the quick actions below to manage your digital catalog and support workflow.</p>
    </div>
    <div class="admin-hero-actions">
        <a href="<?= BASE_URL ?>admin/products.php" class="button">Add new product</a>
        <a href="<?= BASE_URL ?>admin/orders.php" class="button button-secondary">Review orders</a>
    </div>
</section>

<section class="section">
    <div class="section-title">Performance overview</div>
    <div class="stats-grid">
        <div class="stats-card"><h3><?= intval($usersCount) ?></h3><p>Registered users</p></div>
        <div class="stats-card"><h3><?= intval($productsCount) ?></h3><p>Active products</p></div>
        <div class="stats-card"><h3><?= intval($ordersCount) ?></h3><p>Orders placed</p></div>
        <div class="stats-card"><h3><?= CURRENCY . number_format($totalRevenue, 2) ?></h3><p>Total revenue</p></div>
    </div>
</section>

<section class="section">
    <div class="section-title">Quick actions</div>
    <div class="card-grid">
        <div class="card card-body"><h3>Catalog</h3><p style="color:var(--muted);margin-bottom:18px;">Upload products, add assets and adjust pricing.</p><a href="<?= BASE_URL ?>admin/products.php" class="button">Manage products</a></div>
        <div class="card card-body"><h3>Order pipeline</h3><p style="color:var(--muted);margin-bottom:18px;">Track orders, payment status and download access.</p><a href="<?= BASE_URL ?>admin/orders.php" class="button">View orders</a></div>
        <div class="card card-body"><h3>Customer accounts</h3><p style="color:var(--muted);margin-bottom:18px;">Review buyers and manage profile access.</p><a href="<?= BASE_URL ?>admin/users.php" class="button">Manage users</a></div>
        <div class="card card-body"><h3>Store settings</h3><p style="color:var(--muted);margin-bottom:18px;">Configure payment, tax, branding and email options.</p><a href="<?= BASE_URL ?>admin/settings.php" class="button">Open settings</a></div>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/admin-footer.php';
