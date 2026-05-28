<?php
require_once __DIR__ . '/config.php';
$user = currentUser();
$activePage = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize(SITE_TITLE) ?> | <?= isset($pageTitle) ? sanitize($pageTitle) : 'Digital Products' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
<header class="site-header container">
    <div>
        <a class="site-logo" href="<?= BASE_URL ?>">YBT Digital<small>Digital product marketplace</small></a>
    </div>
    <nav class="nav-links">
        <a href="<?= BASE_URL ?>">Home</a>
        <a href="<?= BASE_URL ?>products.php">Products</a>
        <a href="<?= BASE_URL ?>faq.php">FAQ</a>
        <a href="<?= BASE_URL ?>contact.php">Support</a>
        <?php if ($user): ?>
            <a href="<?= BASE_URL ?>orders.php">Orders</a>
            <a href="<?= BASE_URL ?>profile.php">Profile</a>
        <?php endif; ?>
        <?php if ($user): ?>
            <a href="<?= BASE_URL ?>logout.php" class="button">Logout</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>login.php" class="button">Login</a>
        <?php endif; ?>
        <button type="button" class="dark-toggle" data-theme-toggle>Theme</button>
    </nav>
</header>
<main class="container">