<?php
require_once __DIR__ . '/../includes/config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $admin = db_fetch('SELECT * FROM admins WHERE email = ?', [$email]);
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        redirect(BASE_URL . 'admin/dashboard.php');
    }
    $error = 'Invalid admin credentials.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize(SITE_TITLE) ?> Admin Login</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
<main class="container" style="padding-top:80px;">
    <div class="form-panel" style="max-width:420px; margin:auto;">
        <h1>Admin Login</h1>
        <?php if ($error): ?><div class="alert"><?= sanitize($error) ?></div><?php endif; ?>
        <form method="post" style="display:grid; gap:18px; margin-top:18px;">
            <div class="input-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="input-group"><label>Password</label><input type="password" name="password" required></div>
            <button type="submit" class="button">Login</button>
        </form>
    </div>
</main>
</body>
</html>
