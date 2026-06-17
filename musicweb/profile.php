<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$productCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Моят профил - MelodyStore</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <a class="navbar-brand" href="index.php">🎵 Melody<span>Store</span></a>
    <div class="nav-links">
        <a href="index.php">Начало</a>
        <a href="products.php">Продукти</a>
        <a href="admin.php">Управление</a>
        <a href="profile.php" class="active">
            <?php if ($user['photo'] !== 'default.png'): ?>
                <img src="uploads/avatars/<?= htmlspecialchars($user['photo']) ?>" class="nav-avatar" alt="">
            <?php else: ?>
                👤
            <?php endif; ?>
            <?= htmlspecialchars($user['username']) ?>
        </a>
        <a href="logout.php" class="btn btn-outline btn-sm">Изход</a>
    </div>
</nav>

<div class="profile-container">
    <!-- Profile Header -->
    <div class="profile-header">
        <?php if ($user['photo'] !== 'default.png'): ?>
            <img src="uploads/avatars/<?= htmlspecialchars($user['photo']) ?>"
                 alt="Профилна снимка" class="profile-avatar">
        <?php else: ?>
            <div class="profile-avatar-placeholder">👤</div>
        <?php endif; ?>

        <div class="profile-info">
            <h2><?= htmlspecialchars($user['username']) ?></h2>
            <div class="email">📧 <?= htmlspecialchars($user['email']) ?></div>
            <div class="profile-badge">🎵 Член на MelodyStore</div>
        </div>
    </div>

    <!-- Profile Details -->
    <div class="profile-details">
        <h3>📋 Данни на потребителя</h3>

        <div class="detail-row">
            <span class="detail-label">🆔 ID</span>
            <span class="detail-value">#<?= $user['id'] ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">👤 Потребителско име</span>
            <span class="detail-value"><?= htmlspecialchars($user['username']) ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">📧 Имейл</span>
            <span class="detail-value"><?= htmlspecialchars($user['email']) ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">📱 Телефон</span>
            <span class="detail-value">
                <?= $user['phone'] ? htmlspecialchars($user['phone']) : '<span style="color:var(--text-muted)">Не е въведен</span>' ?>
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">🔐 Парола</span>
            <span class="detail-value" style="color:var(--text-muted);font-size:0.85rem;">
                bcrypt хеш (скрита)
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">📷 Профилна снимка</span>
            <span class="detail-value">
                <?= $user['photo'] !== 'default.png' ? '✅ Качена' : '❌ Не е качена' ?>
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">📅 Регистриран на</span>
            <span class="detail-value"><?= date('d.m.Y \в H:i', strtotime($user['created_at'])) ?></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">🎵 Продукти в магазина</span>
            <span class="detail-value" style="color:var(--accent);font-weight:700;"><?= $productCount ?></span>
        </div>
    </div>

    <!-- Actions -->
    <div style="display:flex;gap:12px;margin-top:24px;flex-wrap:wrap;">
        <a href="admin.php" class="btn btn-primary">⚙️ Управление на продукти</a>
        <a href="products.php" class="btn btn-outline">🎵 Виж продуктите</a>
        <a href="logout.php" class="btn btn-danger btn-sm" style="margin-left:auto;"
           onclick="return confirm('Сигурен ли си, че искаш да излезеш?')">Изход</a>
    </div>
</div>

<footer>
    <p>© 2024 <span>MelodyStore</span> — Твоят музикален магазин</p>
</footer>

</body>
</html>
