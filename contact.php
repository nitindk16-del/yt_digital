<?php
$pageTitle = 'Contact';
require_once __DIR__ . '/includes/header.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $messageText = trim($_POST['message'] ?? '');
    if ($name && $email && $messageText) {
        db_execute('INSERT INTO support_tickets (name, email, message, created_at) VALUES (?, ?, ?, NOW())', [$name, $email, $messageText]);
        $message = 'Your message has been received. Our team will respond shortly.';
    }
}
?>
<section class="section">
    <div class="section-title">Contact Support</div>
    <div class="form-panel" style="max-width:640px; margin:auto;">
        <?php if ($message): ?><div class="alert"><?= sanitize($message) ?></div><?php endif; ?>
        <form method="post" style="display:grid; gap:18px;">
            <div class="input-group"><label>Name</label><input type="text" name="name" required></div>
            <div class="input-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="input-group"><label>Message</label><textarea name="message" rows="6" required></textarea></div>
            <button type="submit" class="button">Send message</button>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php';
