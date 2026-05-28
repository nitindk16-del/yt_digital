<?php
$pageTitle = 'Orders';
require_once __DIR__ . '/../includes/config.php';
if (!isAdmin()) {
    redirect(BASE_URL . 'admin/login.php');
}
$orders = db_fetch_all('SELECT o.*, u.email FROM orders o JOIN users u ON o.user_id = u.id ORDER BY created_at DESC');
require_once __DIR__ . '/../includes/admin-header.php';
?>
<section class="section">
    <div class="section-title">Order Management</div>
    <div class="card card-body" style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; min-width:800px;">
            <thead>
                <tr style="text-align:left; color: var(--muted);">
                    <th style="padding:12px 16px;">Order</th>
                    <th style="padding:12px 16px;">Customer</th>
                    <th style="padding:12px 16px;">Total</th>
                    <th style="padding:12px 16px;">Status</th>
                    <th style="padding:12px 16px;">Payment</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr style="border-top:1px solid var(--border);">
                        <td style="padding:14px 16px;">#<?= sanitize($order['id']) ?> <br><small><?= sanitize(date('d M Y', strtotime($order['created_at']))) ?></small></td>
                        <td style="padding:14px 16px;"><?= sanitize($order['email']) ?></td>
                        <td style="padding:14px 16px;"><?= CURRENCY . number_format($order['total_amount'], 2) ?></td>
                        <td style="padding:14px 16px;"><?= sanitize($order['status']) ?></td>
                        <td style="padding:14px 16px;"><?= sanitize($order['payment_method']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/admin-footer.php';
