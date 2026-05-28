<?php
$pageTitle = 'Products';
require_once __DIR__ . '/../includes/config.php';
if (!isAdmin()) {
    redirect(BASE_URL . 'admin/login.php');
}
$products = db_fetch_all('SELECT * FROM products ORDER BY created_at DESC');
require_once __DIR__ . '/../includes/admin-header.php';
?>
<section class="section">
    <div class="section-title">Product Management</div>
    <a href="#" class="button" style="margin-bottom:18px; display:inline-block;">Add New Product</a>
    <div class="card card-body" style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; min-width:800px;">
            <thead>
                <tr style="text-align:left; color: var(--muted);">
                    <th style="padding:12px 16px;">Title</th>
                    <th style="padding:12px 16px;">Category</th>
                    <th style="padding:12px 16px;">Price</th>
                    <th style="padding:12px 16px;">Status</th>
                    <th style="padding:12px 16px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr style="border-top:1px solid var(--border);">
                        <td style="padding:14px 16px;"><?= sanitize($product['title']) ?></td>
                        <td style="padding:14px 16px;"><?= sanitize($product['category']) ?></td>
                        <td style="padding:14px 16px;"><?= CURRENCY . number_format($product['price'], 2) ?></td>
                        <td style="padding:14px 16px;"><?= $product['status'] ? 'Active' : 'Inactive' ?></td>
                        <td style="padding:14px 16px;"><a href="#" class="button button-secondary">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/admin-footer.php';
