<?php
session_start();
require_once 'db.php';

$category = $_GET['cat'] ?? '';
$search   = trim($_GET['search'] ?? '');

$where  = [];
$params = [];

if ($category) {
    $where[]  = 'category = ?';
    $params[] = $category;
}

if ($search) {
    $where[]  = '(name LIKE ? OR description LIKE ?)';
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$sql = "SELECT * FROM products";
if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

$cats = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);

$icons = [
    'Китари'   => '🎸',
    'Пиана'    => '🎹',
    'Барабани' => '🥁',
    'Духови'   => '🎺',
    'Клавишни' => '🎹',
    'Струнни'  => '🎻',
];
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Продукти - MelodyStore</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <a class="navbar-brand" href="index.php">🎵 Melody<span>Store</span></a>
    <div class="nav-links">
        <a href="index.php">Начало</a>
        <a href="products.php" class="active">Продукти</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="admin.php">Управление</a>
            <a href="profile.php">
                <?php if ($_SESSION['photo'] !== 'default.png'): ?>
                    <img src="uploads/avatars/<?= htmlspecialchars($_SESSION['photo']) ?>" class="nav-avatar" alt="">
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

<div class="section">
    <h2 class="section-title">Нашите <span class="highlight">продукти</span></h2>
    <p class="section-subtitle">Качествени музикални инструменти за всеки стил и ниво</p>

    <!-- Search & Filter -->
    <div style="display:flex;gap:16px;margin-bottom:32px;flex-wrap:wrap;align-items:center;">
        <form method="GET" style="display:flex;gap:10px;flex:1;min-width:260px;">
            <?php if ($category): ?>
                <input type="hidden" name="cat" value="<?= htmlspecialchars($category) ?>">
            <?php endif; ?>
            <input type="text" name="search" placeholder="Търси продукт..." value="<?= htmlspecialchars($search) ?>"
                   style="flex:1;padding:10px 16px;background:var(--bg-card);border:1px solid var(--border);border-radius:10px;color:var(--text);font-size:0.9rem;">
            <button type="submit" class="btn btn-primary btn-sm">Търси</button>
            <?php if ($search || $category): ?>
                <a href="products.php" class="btn btn-outline btn-sm">Изчисти</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Category filters -->
    <?php if ($cats): ?>
    <div style="display:flex;gap:10px;margin-bottom:32px;flex-wrap:wrap;">
        <a href="products.php<?= $search ? '?search='.urlencode($search) : '' ?>"
           class="btn btn-sm <?= !$category ? 'btn-primary' : 'btn-outline' ?>">Всички</a>
        <?php foreach ($cats as $cat): ?>
            <a href="?cat=<?= urlencode($cat) ?><?= $search ? '&search='.urlencode($search) : '' ?>"
               class="btn btn-sm <?= $category === $cat ? 'btn-primary' : 'btn-outline' ?>">
               <?= ($icons[$cat] ?? '🎵') . ' ' . htmlspecialchars($cat) ?>
            </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Products grid -->
    <?php if (empty($products)): ?>
        <div class="empty-state">
            <div class="empty-icon">🎵</div>
            <p>Няма намерени продукти.</p>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="admin.php" class="btn btn-primary" style="margin-top:16px;">Добави продукт</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p style="color:var(--text-muted);font-size:0.88rem;margin-bottom:20px;">
            <?= count($products) ?> <?= count($products) === 1 ? 'продукт' : 'продукта' ?>
        </p>
        <div class="products-grid">
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <div class="product-card-img-placeholder">
                        <?= $icons[$p['category']] ?? '🎵' ?>
                    </div>
                    <div class="product-card-body">
                        <div class="product-category"><?= htmlspecialchars($p['category']) ?></div>
                        <div class="product-name"><?= htmlspecialchars($p['name']) ?></div>
                        <div class="product-desc"><?= htmlspecialchars($p['description']) ?></div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:16px;">
                            <div class="product-price"><?= number_format($p['price'], 2) ?> лв.</div>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="admin.php?delete=<?= $p['id'] ?>"
                                   onclick="return confirm('Изтрий <?= htmlspecialchars(addslashes($p['name'])) ?>?')"
                                   class="btn btn-danger btn-sm">🗑</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<footer>
    <p>© 2024 <span>MelodyStore</span> — Твоят музикален магазин</p>
</footer>

</body>
</html>
