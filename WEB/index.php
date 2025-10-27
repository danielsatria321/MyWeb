<?php
require 'config.php';


$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE title LIKE ? ORDER BY created_at DESC");
    $stmt->execute(["%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC");
}

$articles = $stmt->fetchAll();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple CMS - Artikel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #eef2f3, #ffffff);
            font-family: "Inter", sans-serif;
        }

        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(15, 23, 42, 0.9);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .search-bar input {
            border-radius: 10px;
            box-shadow: none !important;
            border: 1px solid #e2e8f0;
        }

        .search-bar input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .btn-primary {
            background-color: #6366f1;
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #4f46e5;
        }

        .card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
        }

        .card img {
            height: 220px;
            object-fit: cover;
        }

        h2 {
            font-weight: 700;
            color: #111827;
        }

        footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            background: rgba(0, 0, 0, 0.05);
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">📰 Simple CMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php if (is_logged_in()): ?>
                        <li class="nav-item me-3 text-white">
                            👋 <?= htmlspecialchars($_SESSION['user']['username']) ?>
                        </li>
                        <?php if (is_admin()): ?>
                            <li class="nav-item me-2">
                                <a class="btn btn-outline-light btn-sm" href="admin_dashboard.php">Admin Panel</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-light btn-sm" href="login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container" style="margin-top: 100px;">
        <h2 class="mb-4 text-center">✨ Daftar Artikel</h2>


        <form method="get" class="search-bar d-flex mb-5 justify-content-center">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari artikel..." style="max-width: 400px;"
                value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
        </form>

        <?php if ($search): ?>
            <p class="text-center text-muted">Hasil pencarian untuk: <strong>"<?= htmlspecialchars($search) ?>"</strong></p>
        <?php endif; ?>

        <div class="row">
            <?php if (count($articles) === 0): ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Tidak ada artikel ditemukan.</p>
                </div>
            <?php endif; ?>

            <?php foreach ($articles as $article): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if ($article['image']): ?>
                            <img src="<?= htmlspecialchars($article['image']) ?>" alt="Gambar Artikel">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($article['title']) ?></h5>
                            <p class="card-text text-muted">
                                <?= nl2br(htmlspecialchars(substr($article['content'], 0, 100))) ?>...
                            </p>
                            <a href="view_article.php?id=<?= $article['id'] ?>" class="btn btn-primary btn-sm mt-auto">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        &copy; <?= date('Y') ?> Made by Daniel
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>