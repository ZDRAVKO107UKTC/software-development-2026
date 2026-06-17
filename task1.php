<?php
require 'includes/lang.php';
$pageTitle = t('task1_title');
$current = 'task1.php';
$useBootstrap = true;
require 'includes/header.php';
?>

<main class="container my-4">
    <h1 class="mb-2"><?= t('task1_title') ?></h1>
    <p class="text-muted"><?= t('task1_intro') ?></p>

    <!-- Row 1: two columns - text and image side by side -->
    <div class="row align-items-center g-4 mb-4">
        <div class="col-md-6">
            <h3><?= t('task1_text_h') ?></h3>
            <p><?= t('task1_text_p') ?></p>
        </div>
        <div class="col-md-6">
            <img src="https://picsum.photos/600/350" alt="" class="img-fluid rounded">
        </div>
    </div>

    <!-- Row 2: four columns -->
    <div class="row g-3">
        <?php for ($i = 1; $i <= 4; $i++): ?>
            <div class="col-md-3">
                <div class="p-4 bg-light border rounded text-center">
                    <?= t('task1_box') ?> <?= $i ?>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</main>

<?php require 'includes/footer.php'; ?>
