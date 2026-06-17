<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <?php if (!empty($useBootstrap)): ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="topbar">
        <a class="brand" href="index.php"><?= t('site_name') ?></a>
        <nav>
            <a href="index.php"<?= $current === 'index.php' ? ' class="here"' : '' ?>><?= t('nav_home') ?></a>
            <a href="about.php"<?= $current === 'about.php' ? ' class="here"' : '' ?>><?= t('nav_about') ?></a>
            <?php $taskPages = ['task1.php','task2.php','task3.php','task4.php','cart.php','task5.php','task6.php','task7.php','task8.php','task9.php','posts.php']; ?>
            <div class="dropdown<?= in_array($current, $taskPages) ? ' here' : '' ?>">
                <a href="#" class="drop-toggle"><?= t('nav_tasks') ?> &#9662;</a>
                <div class="drop-menu">
                    <?php for ($i = 1; $i <= 9; $i++): ?>
                        <a href="task<?= $i ?>.php"><?= t('nav_task' . $i) ?></a>
                    <?php endfor; ?>
                </div>
            </div>
            <a href="musicweb/index.php"><?= t('nav_final') ?></a>
            <a href="contact.php"<?= $current === 'contact.php' ? ' class="here"' : '' ?>><?= t('nav_contact') ?></a>
            <span class="lang-switch">
                <a href="?lang=bg" class="<?= $lang === 'bg' ? 'on' : '' ?>">BG</a>
                <a href="?lang=en" class="<?= $lang === 'en' ? 'on' : '' ?>">EN</a>
            </span>
        </nav>
    </header>
