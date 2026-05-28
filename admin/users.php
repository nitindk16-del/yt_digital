<?php
$pageTitle = 'Users';
require_once __DIR__ . '/../includes/config.php';
if (!isAdmin()) {
    redirect(BASE_URL . 'admin/login.php');
}
$users = db_fetch_all('SELECT * FROM users ORDER BY created_at DESC');
require_once __DIR__ . '/../includes/admin-header.php';
?>
<section class="section">
    <div class="section-title">User Management</div>
    <div class="card card-body" style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; min-width:800px;">
            <thead>
                <tr style="text-align:left; color: var(--muted);">
                    <th style="padding:12px 16px;">Name</th>
                    <th style="padding:12px 16px;">Email</th>
                    <th style="padding:12px 16px;">Joined</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr style="border-top:1px solid var(--border);">
                        <td style="padding:14px 16px;"><?= sanitize($user['name']) ?></td>
                        <td style="padding:14px 16px;"><?= sanitize($user['email']) ?></td>
                        <td style="padding:14px 16px;"><?= sanitize(date('d M Y', strtotime($user['created_at']))) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/admin-footer.php';
