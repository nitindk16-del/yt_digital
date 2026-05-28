<?php
$pageTitle = 'Orders';
require_once __DIR__ . '/includes/header.php';

if (!isLoggedIn()) {
    redirect(BASE_URL . 'login.php');
}
$userOrders = getUserOrders($_SESSION['user_id']);

if (isset($_GET['invoice'])) {
    $orderId = intval($_GET['invoice']);
    $order = db_fetch('SELECT * FROM orders WHERE id = ? AND user_id = ?', [$orderId, $_SESSION['user_id']]);
    $items = getOrderItems($orderId);
    if ($order) {
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="invoice-' . $orderId . '.txt"');
        echo "Invoice for Order #" . $orderId . "\n";
        echo "Date: " . $order['created_at'] . "\n";
        echo "Total: " . CURRENCY . number_format($order['total_amount'], 2) . "\n\n";
        foreach ($items as $item) {
            echo $item['title'] . " x" . $item['quantity'] . " @ " . CURRENCY . number_format($item['unit_price'], 2) . "\n";
        }
        exit;
    }
}

if (isset($_GET['download'])) {
    $orderId = intval($_GET['download']);
    $items = getOrderItems($orderId);
    if ($items) {
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="download-' . $orderId . '.txt"');
        foreach ($items as $item) {
            echo "Product: " . $item['title'] . "\n";
            echo "Download Path: " . $item['file_path'] . "\n\n";
        }
        exit;
    }
}
?>
<section class="section">
    <div class="section-title">Your Orders</div>
    <?php if (empty($userOrders)): ?>
        <div class="card card-body">No orders yet. <a href="<?= BASE_URL ?>products.php">Shop now</a>.</div>
    <?php else: ?>
        <div class="card-grid">
            <?php foreach ($userOrders as $order): ?>
                <div class="card card-body">
                    <div class="card-meta"><span>Order #<?= sanitize($order['id']) ?></span><span><?= sanitize($order['status']) ?></span></div>
                    <p style="margin:0 0 16px;color:var(--muted);">Placed on <?= sanitize(date('d M Y', strtotime($order['created_at']))) ?></p>
                    <p><strong>Total</strong> <?= CURRENCY . number_format($order['total_amount'], 2) ?></p>
                    <a href="<?= BASE_URL ?>orders.php?download=<?= $order['id'] ?>" class="button button-secondary">Download</a>
                    <a href="<?= BASE_URL ?>orders.php?invoice=<?= $order['id'] ?>" class="button">Invoice</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
<?php require_once __DIR__ . '/includes/footer.php';
