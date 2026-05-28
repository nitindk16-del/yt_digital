<?php
$pageTitle = 'Profile';
require_once __DIR__ . '/includes/header.php';
if (!isLoggedIn()) {
    redirect(BASE_URL . 'login.php');
}
$user = currentUser();
$error = '';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($password) {
        db_execute('UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?', [$name, $email, password_hash($password, PASSWORD_DEFAULT), $user['id']]);
        $message = 'Profile updated successfully.';
    } else {
        db_execute('UPDATE users SET name = ?, email = ? WHERE id = ?', [$name, $email, $user['id']]);
        $message = 'Profile updated successfully.';
    }
    $user = currentUser();
}
?>
<section class="section">
    <div class="section-title">Your Profile</div>
    <div class="profile-grid">
        <div class="card card-body">
            <h3>Account details</h3>
            <?php if ($message): ?><div class="alert"><?= sanitize($message) ?></div><?php endif; ?>
            <form method="post" style="display:grid; gap:18px;">
                <div class="input-group"><label>Name</label><input type="text" name="name" value="<?= sanitize($user['name']) ?>" required></div>
                <div class="input-group"><label>Email</label><input type="email" name="email" value="<?= sanitize($user['email']) ?>" required></div>
                <div class="input-group"><label>Change password</label><input type="password" name="password" placeholder="Leave blank to keep current"></div>
                <button type="submit" class="button">Save changes</button>
            </form>
        </div>
        <div class="card card-body">
            <h3>Quick links</h3>
            <p style="color: var(--muted);">Use the links below to manage your orders and support.</p>
            <a href="<?= BASE_URL ?>orders.php" class="button button-secondary" style="width:100%; text-align:center;">View Orders</a>
            <a href="<?= BASE_URL ?>contact.php" class="button button-secondary" style="width:100%; text-align:center;">Contact Support</a>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php';
