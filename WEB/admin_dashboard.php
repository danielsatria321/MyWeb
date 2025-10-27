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
    <style>
        .img-thumb {
            width: 100px;
            height: 70px;
            object-fit: cover;
            border-radius: 6px;
        }

        .truncate {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
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

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Isi Artikel</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($articles) > 0): ?>
                    <?php foreach ($articles as $index => $article): ?>
                        <tr>
                            <td class="text-center"><?= $index + 1 ?></td>

                            <!-- Gambar Artikel -->
                            <td class="text-center">
                                <?php if (!empty($article['image'])): ?>
                                    <img src="<?= htmlspecialchars($article['image']) ?>" class="img-thumb" alt="Gambar">
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada</span>
                                <?php endif; ?>
                            </td>

                            <!-- Judul -->
                            <td><?= htmlspecialchars($article['title']) ?></td>

                            <!-- Isi artikel singkat -->
                            <td class="truncate"><?= htmlspecialchars(strip_tags($article['content'])) ?></td>

                            <!-- Tanggal -->
                            <td><?= $article['created_at'] ?></td>

                            <!-- Tombol Aksi -->
                            <td class="text-center">
                                <a href="view_article.php?id=<?= $article['id'] ?>" class="btn btn-info btn-sm">👁️</a>
                                <a href="edit_article.php?id=<?= $article['id'] ?>" class="btn btn-warning btn-sm">✏️</a>
                                <a href="delete_article.php?id=<?= $article['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus artikel ini?')">🗑️</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada artikel.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>