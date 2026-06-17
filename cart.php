<?php
require 'includes/lang.php';
require 'includes/products.php';

// Количката се пази в сесията: масив [id на продукт => количество]
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Обработка на действията (добави / премахни / изчисти)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id'] ?? 0);

    if ($action === 'add' && isset($products[$id])) {
        // ако вече го има - увеличаваме количеството, иначе го слагаме с 1
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    } elseif ($action === 'remove') {
        unset($_SESSION['cart'][$id]);
    } elseif ($action === 'clear') {
        $_SESSION['cart'] = [];
    }

    // PRG (Post-Redirect-Get) - пренасочваме, за да не се добави пак при refresh
    header('Location: cart.php');
    exit;
}

// Изчисляваме общата сума
$total = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    if (isset($products[$id])) {
        $total += $products[$id]['price'] * $qty;
    }
}

$pageTitle = 'Количка';
$current = 'cart.php';
$useBootstrap = true;
require 'includes/header.php';
?>

<main class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Моята количка</h1>
        <a href="task4.php" class="btn btn-outline-secondary">← Обратно към продуктите</a>
    </div>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info">Количката е празна. Добавете продукти от <a href="task4.php">страницата с продукти</a>.</div>
    <?php else: ?>
        <table class="table align-middle bg-white shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Продукт</th>
                    <th>Цена</th>
                    <th class="text-center">Брой</th>
                    <th class="text-end">Сума</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $id => $qty): ?>
                    <?php if (!isset($products[$id])) continue; $p = $products[$id]; ?>
                    <tr>
                        <td>
                            <img src="<?= $p['img'] ?>" alt="" width="50" height="50" style="object-fit:cover" class="rounded me-2">
                            <?= htmlspecialchars($p['name']) ?>
                        </td>
                        <td><?= number_format($p['price'], 2) ?> лв</td>
                        <td class="text-center"><?= $qty ?></td>
                        <td class="text-end"><?= number_format($p['price'] * $qty, 2) ?> лв</td>
                        <td class="text-end">
                            <form method="post" class="d-inline">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button class="btn btn-sm btn-outline-danger">✕</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="fw-bold">
                    <td colspan="3">Общо</td>
                    <td class="text-end"><?= number_format($total, 2) ?> лв</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex gap-2">
            <form method="post">
                <input type="hidden" name="action" value="clear">
                <button class="btn btn-outline-danger">Изчисти количката</button>
            </form>
            <button class="btn btn-success" onclick="alert('Благодарим за поръчката!')">Поръчай</button>
        </div>
    <?php endif; ?>

    <!-- Обяснение как работи количката -->
    <div class="card bg-light mt-4">
        <div class="card-body">
            <h2 class="h5">Как е реализирана количката?</h2>
            <ul class="mb-0">
                <li>Продуктите са в общ масив във файла <code>includes/products.php</code>.</li>
                <li>Количката се пази в <code>$_SESSION['cart']</code> като двойки <code>id =&gt; количество</code>, затова се помни между страниците.</li>
                <li>Бутонът <strong>„Добави"</strong> в <code>task4.php</code> праща <code>POST</code> с <code>action=add</code> и <code>id</code> към <code>cart.php</code>.</li>
                <li><code>cart.php</code> обработва действията: <code>add</code> увеличава бройката, <code>remove</code> трие реда, <code>clear</code> изпразва.</li>
                <li>След обработка се прави пренасочване (<strong>Post-Redirect-Get</strong>), за да не се добавя пак при опресняване.</li>
                <li>Общата сума се смята като се обиколят продуктите и се умножи цена × количество.</li>
            </ul>
        </div>
    </div>
</main>

<?php require 'includes/footer.php'; ?>
