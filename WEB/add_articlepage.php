<?php
require 'config.php';
if (!is_admin()) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC");
$articles = $stmt->fetchAll();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Admin Panel</a>
            <div class="d-flex">
                <a href="index.php" class="btn btn-secondary me-2">🏠 Kembali</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>📋 Daftar Artikel</h2>
            <a href="add_articlecode.php" class="btn btn-success">➕ Tambah Artikel</a>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $index => $article): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($article['title']) ?></td>
                        <td><?= $article['created_at'] ?></td>
                        <td>
                            <a href="view_article.php?id=<?= $article['id'] ?>" class="btn btn-info btn-sm">👁️ Lihat</a>
                            <a href="edit_article.php?id=<?= $article['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                            <a href="delete_article.php?id=<?= $article['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">🗑️ Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>