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
            <div class="dropdown<?= in_array($current, ['task1.php','task2.php','task3.php']) ? ' here' : '' ?>">
                <a href="#" class="drop-toggle"><?= t('nav_tasks') ?> &#9662;</a>
                <div class="drop-menu">
                    <a href="task1.php"><?= t('nav_task1') ?></a>
                    <a href="task2.php"><?= t('nav_task2') ?></a>
                    <a href="task3.php"><?= t('nav_task3') ?></a>
                </div>
            </div>
            <a href="contact.php"<?= $current === 'contact.php' ? ' class="here"' : '' ?>><?= t('nav_contact') ?></a>
            <a class="lang-btn" href="?lang=<?= $otherLang ?>"><?= t('lang_switch') ?></a>
        </nav>
    </header>
