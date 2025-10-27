<?php
require 'config.php';
if (!is_admin()) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imagePath = null;

    // Upload gambar jika ada
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO articles (title, content, image, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$title, $content, $imagePath]);
    header("Location: admin_dashboard.php");
    exit;
}
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Artikel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container my-5">
        <h2>📝 Tambah Artikel</h2>
        <form method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Artikel</label>
                <textarea name="content" class="form-control" rows="6" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar (opsional)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>