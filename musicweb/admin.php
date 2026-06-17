<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error   = '';
$success = '';

// Delete product
if (isset($_GET['delete'])) {
    $id   = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $success = 'Продуктът беше изтрит успешно.';
}

// Add product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $desc     = trim($_POST['description'] ?? '');
    $price    = trim($_POST['price'] ?? '');
    $category = trim($_POST['category'] ?? '');

    if (empty($name) || empty($price) || empty($category)) {
        $error = 'Моля, попълнете всички задължителни полета.';
    } elseif (!is_numeric($price) || $price < 0) {
        $error = 'Въведете валидна цена.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, category) VALUES (?,?,?,?)");
        $stmt->execute([$name, $desc, $price, $category]);
        $success = 'Продуктът беше добавен успешно!';
    }
}

$products = $pdo->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление - MelodyStore</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <a class="navbar-brand" href="index.php">🎵 Melody<span>Store</span></a>
    <div class="nav-links">
        <a href="index.php">Начало</a>
        <a href="products.php">Продукти</a>
        <a href="admin.php" class="active">Управление</a>
        <a href="profile.php">
            <?php if ($_SESSION['photo'] !== 'default.png'): ?>
                <img src="uploads/avatars/<?= htmlspecialchars($_SESSION['photo']) ?>" class="nav-avatar" alt="">
            <?php else: ?>
                👤
            <?php endif; ?>
            <?= htmlspecialchars($_SESSION['username']) ?>
        </a>
        <a href="logout.php" class="btn btn-outline btn-sm">Изход</a>
    </div>
</nav>

<div class="admin-container">
    <div class="admin-header">
        <div>
            <h1 style="font-size:1.8rem;font-weight:700;">⚙️ Управление на продукти</h1>
            <p style="color:var(--text-muted);margin-top:4px;">Добавяй и изтривай музикални продукти</p>
        </div>
        <a href="products.php" class="btn btn-outline btn-sm">← Виж магазина</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- Products Table -->
    <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:16px;color:var(--primary);">
        Списък с продукти (<?= count($products) ?>)
    </h3>

    <div class="admin-table-wrap">
        <?php if (empty($products)): ?>
            <div class="empty-state" style="padding:40px;">
                <div class="empty-icon">🎵</div>
                <p>Няма добавени продукти.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Продукт</th>
                        <th>Категория</th>
                        <th>Описание</th>
                        <th>Цена</th>
                        <th>Добавен</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td style="color:var(--text-muted);"><?= $p['id'] ?></td>
                            <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>
                            <td><span class="badge"><?= htmlspecialchars($p['category']) ?></span></td>
                            <td style="color:var(--text-muted);max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                <?= htmlspecialchars(mb_substr($p['description'], 0, 60)) ?>
                            </td>
                            <td style="color:var(--accent);font-weight:700;"><?= number_format($p['price'], 2) ?> лв.</td>
                            <td style="color:var(--text-muted);font-size:0.8rem;">
                                <?= date('d.m.Y', strtotime($p['created_at'])) ?>
                            </td>
                            <td>
                                <a href="admin.php?delete=<?= $p['id'] ?>"
                                   onclick="return confirm('Сигурен ли си, че искаш да изтриеш &quot;<?= htmlspecialchars(addslashes($p['name'])) ?>&quot;?')"
                                   class="btn btn-danger">🗑 Изтрий</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Add Product Form -->
    <div class="add-product-form">
        <h3>➕ Добави нов продукт</h3>
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Име на продукта *</label>
                    <input type="text" name="name" placeholder="напр. Fender Stratocaster"
                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Категория *</label>
                    <select name="category" required>
                        <option value="">-- Избери категория --</option>
                        <option value="Китари" <?= ($_POST['category'] ?? '') === 'Китари' ? 'selected' : '' ?>>🎸 Китари</option>
                        <option value="Пиана" <?= ($_POST['category'] ?? '') === 'Пиана' ? 'selected' : '' ?>>🎹 Пиана</option>
                        <option value="Барабани" <?= ($_POST['category'] ?? '') === 'Барабани' ? 'selected' : '' ?>>🥁 Барабани</option>
                        <option value="Духови" <?= ($_POST['category'] ?? '') === 'Духови' ? 'selected' : '' ?>>🎺 Духови</option>
                        <option value="Клавишни" <?= ($_POST['category'] ?? '') === 'Клавишни' ? 'selected' : '' ?>>🎹 Клавишни</option>
                        <option value="Струнни" <?= ($_POST['category'] ?? '') === 'Струнни' ? 'selected' : '' ?>>🎻 Струнни</option>
                        <option value="Друго" <?= ($_POST['category'] ?? '') === 'Друго' ? 'selected' : '' ?>>🎵 Друго</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Описание</label>
                <textarea name="description" placeholder="Кратко описание на продукта..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
            </div>

            <div class="form-group" style="max-width:200px;">
                <label>Цена (лв.) *</label>
                <input type="number" name="price" step="0.01" min="0"
                       placeholder="0.00" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">➕ Добави продукт</button>
        </form>
    </div>
</div>

<footer>
    <p>© 2024 <span>MelodyStore</span> — Твоят музикален магазин</p>
</footer>

</body>
</html>
