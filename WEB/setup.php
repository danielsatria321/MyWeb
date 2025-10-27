<?php
require 'config.php';

// Membuat tabel users
$pdo->exec("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') NOT NULL DEFAULT 'user'
)
");

// Membuat tabel articles
$pdo->exec("
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)
");

// Membuat tabel likes
$pdo->exec("
CREATE TABLE IF NOT EXISTS likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    article_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_like (user_id, article_id)
)
");

// Membuat admin default
$username = "admin";
$password = "admin123";
$hash = password_hash($password, PASSWORD_DEFAULT);

$check = $pdo->prepare("SELECT * FROM users WHERE username=?");
$check->execute([$username]);

if (!$check->fetch()) {
    $insert = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
    $insert->execute([$username, $hash]);
    echo "✅ Admin berhasil dibuat. Username: <b>admin</b> | Password: <b>admin123</b><br>";
} else {
    echo "ℹ️ Admin sudah ada.<br>";
}

echo "Setup selesai!";
