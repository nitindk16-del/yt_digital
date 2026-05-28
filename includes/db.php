<?php
function db_connect() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die('Database connection failed: ' . $conn->connect_error);
    }
    $conn->set_charset('utf8mb4');
    ensure_product_featured_column($conn);
    return $conn;
}

function ensure_product_featured_column($conn) {
    $result = $conn->query("SHOW COLUMNS FROM products LIKE 'featured'");
    if ($result && $result->num_rows === 0) {
        $conn->query("ALTER TABLE products ADD COLUMN featured TINYINT(1) NOT NULL DEFAULT 0");
    }
}

function db_query($sql, $params = []) {
    global $db;
    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        die('Database prepare failed: ' . $db->error);
    }
    if (!empty($params)) {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_double($param) || is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt;
}

function db_fetch_all($sql, $params = []) {
    $stmt = db_query($sql, $params);
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function db_fetch($sql, $params = []) {
    $stmt = db_query($sql, $params);
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function db_execute($sql, $params = []) {
    $stmt = db_query($sql, $params);
    return $stmt->affected_rows;
}
