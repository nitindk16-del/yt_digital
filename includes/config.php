<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

define('DB_HOST', 'localhost');
define('DB_NAME', 'ybt_digital');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

define('SITE_TITLE', 'YBT Digital');
define('BASE_URL', '/YBT DIGITAL/');
define('CURRENCY', '₹');
define('TAX_RATE', 18); // GST/VAT percentage

define('ADMIN_EMAIL', 'admin@ybt.digital');

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$db = db_connect();
