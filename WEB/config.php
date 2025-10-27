<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// ⚙️ Konfigurasi Database
$DB_HOST = "localhost";
$DB_NAME = "simple_cms";
$DB_USER = "root";
$DB_PASS = "";

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

// 🧠 Fungsi Login
function is_logged_in()
{
    return isset($_SESSION['user']);
}

function is_admin()
{
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}
