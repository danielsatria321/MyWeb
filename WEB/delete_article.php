<?php
require 'config.php';
if (!is_admin()) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM articles WHERE id=?");
$stmt->execute([$id]);
header("Location: admin_dashboard.php");
exit;
