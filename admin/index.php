<?php
require_once __DIR__ . '/../includes/config.php';
if (isAdmin()) {
    redirect(BASE_URL . 'admin/dashboard.php');
}
redirect(BASE_URL . 'admin/login.php');
