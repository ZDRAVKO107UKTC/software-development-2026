<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Моля, въведете имейл и парола.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email']    = $user['email'];
            $_SESSION['photo']    = $user['photo'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Грешен имейл или парола.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - MelodyStore</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <a class="navbar-brand" href="index.php">🎵 Melody<span>Store</span></a>
    <div class="nav-links">
        <a href="index.php">Начало</a>
        <a href="products.php">Продукти</a>
        <a href="login.php" class="active">Вход</a>
        <a href="register.php" class="btn btn-primary btn-sm">Регистрация</a>
    </div>
</nav>

<div class="form-container">
    <div class="form-card">
        <h2>🔐 Вход</h2>
        <p class="subtitle">Влез в своя акаунт в MelodyStore</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Имейл адрес</label>
                <input type="email" name="email" placeholder="ivan@example.com"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required autofocus>
            </div>
            <div class="form-group">
                <label>Парола</label>
                <input type="password" name="password" placeholder="Въведи паролата си" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Влез</button>
        </form>

        <div class="form-link">
            Нямаш акаунт? <a href="register.php">Регистрирай се</a>
        </div>
    </div>

    <div style="text-align:center;margin-top:16px;color:var(--text-muted);font-size:0.8rem;">
        🔒 Паролата се съхранява като bcrypt хеш за максимална сигурност
    </div>
</div>

<footer>
    <p>© 2024 <span>MelodyStore</span> — Твоят музикален магазин</p>
</footer>

</body>
</html>
