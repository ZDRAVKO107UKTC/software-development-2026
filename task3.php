<?php
require 'includes/lang.php';

// ----- Регулярни изрази (Regex) за валидация -----
$rules = [
    // само букви (латиница/кирилица) и интервал, 2-30 знака
    'name'  => '/^[A-Za-zА-Яа-яЁё ]{2,30}$/u',
    // стандартен имейл: нещо@нещо.домейн
    'email' => '/^[\w.\-]+@[\w\-]+\.[A-Za-z]{2,}$/',
    // български мобилен номер: 10 цифри, започва с 0 (напр. 0888123456)
    'phone' => '/^0[0-9]{9}$/',
    // парола: мин. 8 знака, поне една главна буква, една малка и една цифра
    'pass'  => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/',
];

$messages = [
    'name'  => 'Името трябва да съдържа само букви (2–30 знака).',
    'email' => 'Въведете валиден имейл адрес, напр. ime@mail.bg',
    'phone' => 'Телефонът трябва да е 10 цифри и да започва с 0.',
    'pass'  => 'Паролата трябва да е поне 8 знака с главна, малка буква и цифра.',
];

$values = ['name' => '', 'email' => '', 'phone' => '', 'pass' => ''];
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($rules as $field => $pattern) {
        $values[$field] = trim($_POST[$field] ?? '');
        if (!preg_match($pattern, $values[$field])) {
            $errors[$field] = $messages[$field];
        }
    }
    if (!$errors) {
        $success = true;
    }
}

$pageTitle = t('task3_title');
$current = 'task3.php';
$useBootstrap = true;
require 'includes/header.php';
?>

<main class="container my-4" style="max-width:620px">
    <h1 class="mb-1">Регистрация</h1>
    <p class="text-muted">Попълнете формуляра. Всички полета се проверяват с регулярни изрази (Regex).</p>

    <?php if ($success): ?>
        <div class="alert alert-success">✅ Регистрацията е успешна, добре дошъл/дошла, <?= htmlspecialchars($values['name']) ?>!</div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form method="post" novalidate>

                <!-- Поле 1: текст -->
                <div class="mb-3">
                    <label class="form-label">Име и фамилия</label>
                    <input type="text" name="name"
                           class="form-control <?= isset($errors['name']) ? 'is-invalid' : (($_SERVER['REQUEST_METHOD']==='POST') ? 'is-valid' : '') ?>"
                           value="<?= htmlspecialchars($values['name']) ?>" placeholder="Иван Иванов">
                    <?php if (isset($errors['name'])): ?>
                        <div class="invalid-feedback"><?= $errors['name'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Поле 2: имейл -->
                <div class="mb-3">
                    <label class="form-label">Имейл</label>
                    <input type="email" name="email"
                           class="form-control <?= isset($errors['email']) ? 'is-invalid' : (($_SERVER['REQUEST_METHOD']==='POST') ? 'is-valid' : '') ?>"
                           value="<?= htmlspecialchars($values['email']) ?>" placeholder="ime@mail.bg">
                    <?php if (isset($errors['email'])): ?>
                        <div class="invalid-feedback"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Поле 3: телефон -->
                <div class="mb-3">
                    <label class="form-label">Телефон</label>
                    <input type="tel" name="phone"
                           class="form-control <?= isset($errors['phone']) ? 'is-invalid' : (($_SERVER['REQUEST_METHOD']==='POST') ? 'is-valid' : '') ?>"
                           value="<?= htmlspecialchars($values['phone']) ?>" placeholder="0888123456">
                    <?php if (isset($errors['phone'])): ?>
                        <div class="invalid-feedback"><?= $errors['phone'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Поле 4: парола -->
                <div class="mb-3">
                    <label class="form-label">Парола</label>
                    <input type="password" name="pass"
                           class="form-control <?= isset($errors['pass']) ? 'is-invalid' : (($_SERVER['REQUEST_METHOD']==='POST') ? 'is-valid' : '') ?>"
                           placeholder="••••••••">
                    <?php if (isset($errors['pass'])): ?>
                        <div class="invalid-feedback"><?= $errors['pass'] ?></div>
                    <?php else: ?>
                        <div class="form-text">Поне 8 знака, главна и малка буква и цифра.</div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary w-100">Регистрирай се</button>
            </form>
        </div>
    </div>

    <!-- Кратко обяснение на използваните регулярни изрази -->
    <div class="card bg-light mt-4">
        <div class="card-body">
            <h2 class="h5">Използвани регулярни изрази</h2>
            <ul class="mb-0 small">
                <li><code>/^[A-Za-zА-Яа-яЁё ]{2,30}$/u</code> – само букви, 2–30 знака.</li>
                <li><code>/^[\w.\-]+@[\w\-]+\.[A-Za-z]{2,}$/</code> – формат на имейл.</li>
                <li><code>/^0[0-9]{9}$/</code> – 10 цифри, започва с 0.</li>
                <li><code>/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/</code> – силна парола.</li>
            </ul>
        </div>
    </div>
</main>

<?php require 'includes/footer.php'; ?>
