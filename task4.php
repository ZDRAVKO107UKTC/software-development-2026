<?php
require 'includes/lang.php';
require 'includes/products.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$cartCount = array_sum($_SESSION['cart']);

$pageTitle = t('task4_title');
$current = 'task4.php';
$useBootstrap = true;
require 'includes/header.php';
?>

<main class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Продукти</h1>
        <a href="cart.php" class="btn btn-outline-dark">
            🛒 Количка <span class="badge bg-danger"><?= $cartCount ?></span>
        </a>
    </div>

    <div class="row g-4">
        <?php foreach ($products as $id => $p): ?>
            <div class="col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?= $p['img'] ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>" style="height:200px;object-fit:cover">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($p['name']) ?></h5>
                        <p class="card-text fw-bold text-success"><?= number_format($p['price'], 2) ?> лв</p>
                        <!-- Бутон "Добави" - праща id-то на продукта към cart.php -->
                        <form method="post" action="cart.php" class="mt-auto">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <button type="submit" class="btn btn-primary w-100">Добави в количката</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require 'includes/footer.php'; ?>
