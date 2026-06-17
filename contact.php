<?php
require 'includes/lang.php';

$errors = [];
$sent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') $errors[] = t('err_name');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = t('err_email');
    if ($message === '') $errors[] = t('err_message');

    if (!$errors) $sent = true;
}

$pageTitle = t('contact_title');
$current = 'contact.php';
require 'includes/header.php';
?>

<main class="wrap">
    <h1><?= t('contact_title') ?></h1>
    <p><?= t('contact_lead') ?></p>

    <?php if ($sent): ?>
        <p class="ok"><?= t('form_ok') ?></p>
    <?php elseif ($errors): ?>
        <ul class="bad">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" class="form">
        <label><?= t('form_name') ?>
            <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </label>
        <label><?= t('form_email') ?>
            <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </label>
        <label><?= t('form_message') ?>
            <textarea name="message" rows="5"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        </label>
        <button type="submit" class="btn"><?= t('form_send') ?></button>
    </form>
</main>

<?php require 'includes/footer.php'; ?>
