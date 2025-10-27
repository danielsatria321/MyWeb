<?php
require 'config.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    echo "Artikel tidak ditemukan.";
    exit;
}

// Menangani like
if (isset($_POST['like'])) {
    $pdo->prepare("UPDATE articles SET likes = likes + 1 WHERE id=?")->execute([$id]);
    header("Location: view_article.php?id=$id");
    exit;
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($article['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container my-5">
        <a href="index.php" class="btn btn-secondary mb-3">⬅️ Kembali</a>
        <div class="card shadow">
            <?php if ($article['image']): ?>
                <img src="<?= htmlspecialchars($article['image']) ?>" class="card-img-top" alt="Gambar Artikel">
            <?php endif; ?>
            <div class="card-body">
                <h3><?= htmlspecialchars($article['title']) ?></h3>
                <p class="text-muted">Dipublikasikan pada <?= $article['created_at'] ?></p>
                <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>

                <?php if (is_logged_in()): ?>
                    <form method="post">
                        <button type="submit" name="like" class="btn btn-outline-danger">❤️ Like (<?= $article['likes'] ?>)</button>
                    </form>
                <?php else: ?>
                    <p class="text-muted">Login untuk memberikan like.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>

</html>