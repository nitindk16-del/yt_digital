<?php
$pageTitle = 'Register';
require_once __DIR__ . '/includes/header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['password_confirm'] ?? '';
    if ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (db_fetch('SELECT id FROM users WHERE email = ?', [$email])) {
        $error = 'Email already registered.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        db_execute('INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())', [$name, $email, $hash]);
        redirect(BASE_URL . 'login.php');
    }
}
?>
<section class="section">
    <div class="section-title">Create your account</div>
    <div class="form-panel" style="max-width:520px; margin:auto;">
        <?php if ($error): ?><div class="alert"><?= sanitize($error) ?></div><?php endif; ?>
        <form method="post" style="display:grid; gap:18px;">
            <div class="input-group"><label>Name</label><input type="text" name="name" required></div>
            <div class="input-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="input-group"><label>Password</label><input type="password" name="password" required></div>
            <div class="input-group"><label>Confirm Password</label><input type="password" name="password_confirm" required></div>
            <button type="submit" class="button">Sign Up</button>
            <p style="color:var(--muted);">Already have an account? <a href="<?= BASE_URL ?>login.php">Login</a></p>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php';
