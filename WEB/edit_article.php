<?php
require 'config.php';
if (!is_admin()) {
    header("Location: index.php");
    exit;
}

// Ambil artikel berdasarkan ID
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    die("Artikel tidak ditemukan!");
}

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $article['image']; // default gambar lama

    // Jika admin upload gambar baru
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $newImage = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $newImage;

        // Pindahkan gambar baru ke folder uploads
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Hapus gambar lama (jika ada)
            if (!empty($article['image']) && file_exists('uploads/' . $article['image'])) {
                unlink('uploads/' . $article['image']);
            }

            $image = "uploads/" . $newImage; // simpan nama gambar baru
        }
    }

    // Update data ke database
    $stmt = $pdo->prepare("UPDATE articles SET title=?, content=?, image=? WHERE id=?");
    $stmt->execute([$title, $content, $image, $id]);

    header("Location: admin_dashboard.php");
    exit;
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Artikel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container my-5">
        <h2>✏️ Edit Artikel</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($article['title']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Artikel</label>
                <textarea name="content" class="form-control" rows="6" required><?= htmlspecialchars($article['content']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label><br>
                <?php if (!empty($article['image'])): ?>
                    <img src="<?= htmlspecialchars($article['image']) ?>" width="150" class="rounded mb-2"><br>
                    <small class="text-muted">Upload gambar baru untuk mengganti yang lama.</small>
                <?php else: ?>
                    <p class="text-muted">Tidak ada gambar.</p>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Ganti Gambar</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button class="btn btn-primary" type="submit">💾 Simpan Perubahan</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>