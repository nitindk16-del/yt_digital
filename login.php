<?php
$pageTitle = 'Login';
require_once __DIR__ . '/includes/header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $user = db_fetch('SELECT * FROM users WHERE email = ?', [$email]);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $redirect = $_SESSION['redirect_after_login'] ?? BASE_URL;
        unset($_SESSION['redirect_after_login']);
        redirect($redirect);
    }
    $error = 'Invalid email or password.';
}
?>
<section class="section">
    <div class="section-title">Welcome back</div>
    <div class="form-panel" style="max-width:520px; margin:auto;">
        <?php if ($error): ?><div class="alert"><?= sanitize($error) ?></div><?php endif; ?>
        <form method="post" style="display:grid; gap:18px;">
            <div class="input-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="input-group"><label>Password</label><input type="password" name="password" required></div>
            <button type="submit" class="button">Login</button>
            <p style="color:var(--muted);">New here? <a href="<?= BASE_URL ?>register.php">Create account</a></p>
            <p style="color:var(--muted);"><a href="<?= BASE_URL ?>forgot.php">Forgot password?</a></p>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php';
