<?php
$pageTitle = 'Reset Password';
require_once __DIR__ . '/includes/header.php';
$token = $_GET['token'] ?? '';
$error = '';
if (!$token) {
    echo '<section class="section"><div class="card card-body">Invalid reset token.</div></section>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}
$user = db_fetch('SELECT * FROM users WHERE reset_token = ? AND reset_expires >= NOW()', [$token]);
if (!$user) {
    echo '<section class="section"><div class="card card-body">Reset token expired or invalid.</div></section>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';
    if ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        db_execute('UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?', [password_hash($password, PASSWORD_DEFAULT), $user['id']]);
        redirect(BASE_URL . 'login.php');
    }
}
?>
<section class="section">
    <div class="section-title">Reset Your Password</div>
    <div class="form-panel" style="max-width:520px; margin:auto;">
        <?php if ($error): ?><div class="alert"><?= sanitize($error) ?></div><?php endif; ?>
        <form method="post" style="display:grid; gap:18px;">
            <div class="input-group"><label>New Password</label><input type="password" name="password" required></div>
            <div class="input-group"><label>Confirm Password</label><input type="password" name="confirm" required></div>
            <button type="submit" class="button">Reset Password</button>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php';
