<?php
session_start();
require_once 'db.php';

$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 6");
$featured = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MelodyStore - Музикален Магазин</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <a class="navbar-brand" href="index.php">🎵 Melody<span>Store</span></a>
    <div class="nav-links">
        <a href="index.php" class="active">Начало</a>
        <a href="products.php">Продукти</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="admin.php">Управление</a>
            <a href="profile.php">
                <?php if ($_SESSION['photo'] !== 'default.png'): ?>
                    <img src="uploads/avatars/<?= htmlspecialchars($_SESSION['photo']) ?>" class="nav-avatar" alt="Профил">
                <?php else: ?>
                    👤
                <?php endif; ?>
                <?= htmlspecialchars($_SESSION['username']) ?>
            </a>
            <a href="logout.php" class="btn btn-outline btn-sm">Изход</a>
        <?php else: ?>
            <a href="login.php">Вход</a>
            <a href="register.php" class="btn btn-primary btn-sm">Регистрация</a>
        <?php endif; ?>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <h1>Открий твоя <span class="highlight">музикален свят</span></h1>
    <p>Качествени музикални инструменти за всеки музикант — от начинаещи до професионалисти.</p>
    <a href="products.php" class="btn btn-primary">Разгледай продуктите</a>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="register.php" class="btn btn-outline" style="margin-left:12px;">Регистрирай се</a>
        <p class="hero-note">Вече имаш акаунт? <a href="login.php" style="color:var(--primary)">Влез тук</a></p>
    <?php endif; ?>
</section>

<!-- FEATURES -->
<div class="section">
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🎸</div>
            <h3>Китари</h3>
            <p>Акустични и електрически китари от водещи марки.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🎹</div>
            <h3>Клавишни</h3>
            <p>Пиана, синтезатори и MIDI контролери.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🥁</div>
            <h3>Барабани</h3>
            <p>Акустични и електронни барабанни комплекти.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🎺</div>
            <h3>Духови</h3>
            <p>Саксофони, тромпети, тромбони и флейти.</p>
        </div>
    </div>
</div>

<!-- FEATURED PRODUCTS -->
<div class="section" style="padding-top:0">
    <h2 class="section-title">Популярни <span class="highlight">продукти</span></h2>
    <p class="section-subtitle">Разгледай нашата колекция от музикални инструменти</p>

    <?php if (empty($featured)): ?>
        <div class="empty-state">
            <div class="empty-icon">🎵</div>
            <p>Все още няма добавени продукти.</p>
        </div>
    <?php else: ?>
        <div class="products-grid">
            <?php foreach ($featured as $p): ?>
                <div class="product-card">
                    <div class="product-card-img-placeholder">🎵</div>
                    <div class="product-card-body">
                        <div class="product-category"><?= htmlspecialchars($p['category']) ?></div>
                        <div class="product-name"><?= htmlspecialchars($p['name']) ?></div>
                        <div class="product-desc"><?= htmlspecialchars(mb_substr($p['description'], 0, 80)) ?>...</div>
                        <div class="product-price"><?= number_format($p['price'], 2) ?> лв.</div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align:center;margin-top:40px;">
            <a href="products.php" class="btn btn-primary">Виж всички продукти</a>
        </div>
    <?php endif; ?>
</div>

<footer>
    <p>© 2024 <span>MelodyStore</span> — Твоят музикален магазин</p>
</footer>

</body>
</html>
