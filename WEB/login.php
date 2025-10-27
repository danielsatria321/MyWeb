<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user'] = $user;
        if ($user['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Inter", sans-serif;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .login-card h3 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 14px;
        }

        .btn-primary {
            border-radius: 10px;
            font-weight: 600;
            background-color: #111827;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1f2937;
        }

        .error {
            text-align: center;
            background: rgba(255, 0, 0, 0.1);
            border-radius: 8px;
            color: #b91c1c;
            padding: 8px;
            margin-bottom: 15px;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .register-link a {
            text-decoration: none;
            font-weight: 600;
            color: #111827;
        }

        .register-link a:hover {
            color: #4f46e5;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h3>Sign in with email</h3>
        <p class="text-center text-muted mb-4" style="font-size: 14px;">Masuk untuk melanjutkan ke Simple CMS</p>

        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Email atau Username" required>
            </div>
            <div class="mb-3 position-relative">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <a href="#" class="position-absolute end-0 top-50 translate-middle-y me-3 text-muted" style="font-size: 13px;">Forgot?</a>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Get Started</button>
        </form>

        <div class="register-link">
            <p>Belum punya akun? <a href="register.php">Register</a></p>
        </div>
    </div>
</body>

</html>