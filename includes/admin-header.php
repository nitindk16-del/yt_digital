<?php
require_once __DIR__ . '/config.php';
$admin = currentAdmin();
$activePage = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitize(SITE_TITLE) ?> Admin | <?= isset($pageTitle) ? sanitize($pageTitle) : 'Dashboard' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
<header class="site-header container admin-topbar">
    <div>
        <a class="site-logo" href="<?= BASE_URL ?>admin/dashboard.php">Admin Panel<small>Control center</small></a>
    </div>
    <nav class="nav-links admin-topnav">
        <a href="<?= BASE_URL ?>admin/logout.php" class="button">Logout</a>
    </nav>
</header>
<div class="admin-shell container">
    <aside class="admin-sidebar">
        <div class="sidebar-title">Navigation</div>
        <nav class="admin-nav">
            <a href="<?= BASE_URL ?>admin/dashboard.php" class="<?= $activePage === 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
            <a href="<?= BASE_URL ?>admin/products.php" class="<?= $activePage === 'products.php' ? 'active' : '' ?>">Products</a>
            <a href="<?= BASE_URL ?>admin/orders.php" class="<?= $activePage === 'orders.php' ? 'active' : '' ?>">Orders</a>
            <a href="<?= BASE_URL ?>admin/users.php" class="<?= $activePage === 'users.php' ? 'active' : '' ?>">Users</a>
            <a href="<?= BASE_URL ?>admin/settings.php" class="<?= $activePage === 'settings.php' ? 'active' : '' ?>">Settings</a>
        </nav>
    </aside>
    <main class="admin-content">
