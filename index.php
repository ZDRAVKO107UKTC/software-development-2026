<?php
require 'includes/lang.php';
$pageTitle = t('home_title');
$current = 'index.php';
require 'includes/header.php';
?>

<main class="wrap">
    <div class="intro">
        <h1><?= t('home_title') ?></h1>
        <p><?= t('home_lead') ?></p>
        <a class="btn" href="about.php"><?= t('home_more') ?></a>
    </div>

    <div class="cols">
        <div class="box">
            <h3>PHP</h3>
            <p><?= t('home_php') ?></p>
        </div>
        <div class="box">
            <h3>HTML</h3>
            <p><?= t('home_html') ?></p>
        </div>
        <div class="box">
            <h3>CSS</h3>
            <p><?= t('home_css') ?></p>
        </div>
    </div>
</main>

<?php require 'includes/footer.php'; ?>
