<?php
$pageTitle = 'Settings';
require_once __DIR__ . '/../includes/config.php';
if (!isAdmin()) {
    redirect(BASE_URL . 'admin/login.php');
}
$settings = db_fetch_all('SELECT * FROM settings');
require_once __DIR__ . '/../includes/admin-header.php';
?>
<section class="section">
    <div class="section-title">Settings</div>
    <div class="card card-body">
        <form style="display:grid; gap:18px;">
            <div class="input-group"><label>Payment gateway mode</label><select><option>Live</option><option selected>Test</option></select></div>
            <div class="input-group"><label>Stripe API key</label><input type="text" placeholder="sk_test_..." disabled></div>
            <div class="input-group"><label>PayPal client ID</label><input type="text" placeholder="..." disabled></div>
            <div class="input-group"><label>Currency</label><input type="text" value="INR" disabled></div>
            <div class="input-group"><label>Tax rate</label><input type="text" value="18%" disabled></div>
            <button type="button" class="button">Save settings</button>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/admin-footer.php';
