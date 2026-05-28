<?php
$pageTitle = 'Forgot Password';
require_once __DIR__ . '/includes/header.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $user = db_fetch('SELECT id FROM users WHERE email = ?', [$email]);
    if ($user) {
        $token = bin2hex(random_bytes(16));
        db_execute('UPDATE users SET reset_token = ?, reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id = ?', [$token, $user['id']]);
        $message = 'A reset link has been generated. Use: ' . BASE_URL . 'reset.php?token=' . $token;
    } else {
        $message = 'If the email exists, a reset link has been sent.';
    }
}
?>
<section class="section">
    <div class="section-title">Forgot Password</div>
    <div class="form-panel" style="max-width:520px; margin:auto;">
        <?php if ($message): ?><div class="alert"><?= sanitize($message) ?></div><?php endif; ?>
        <form method="post" style="display:grid; gap:18px;">
            <div class="input-group"><label>Email</label><input type="email" name="email" required></div>
            <button type="submit" class="button">Send reset link</button>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php';
