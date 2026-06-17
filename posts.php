<?php
require 'includes/lang.php';
require 'includes/db.php';

// четем всички записани текстове от базата (най-новите отгоре)
$posts = getDb()->query("SELECT * FROM posts ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = 'Записани текстове';
$current = 'posts.php';
$useBootstrap = true;
require 'includes/header.php';
?>

<main class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Записани текстове</h1>
        <a href="task9.php" class="btn btn-primary">+ Нов текст</a>
    </div>

    <?php if (!$posts): ?>
        <div class="alert alert-info">Все още няма записани текстове. Добави първия от <a href="task9.php">редактора</a>.</div>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <article class="card shadow-sm mb-3">
                <div class="card-body">
                    <h2 class="h4"><?= htmlspecialchars($post['title']) ?></h2>
                    <p class="text-muted small mb-2">Записан на <?= htmlspecialchars($post['created']) ?></p>
                    <div class="post-content">
                        <?= $post['content'] /* HTML от редактора - показва се форматиран */ ?>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

<?php require 'includes/footer.php'; ?>
