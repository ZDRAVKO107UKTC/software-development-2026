<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';
    $phone    = trim($_POST['phone'] ?? '');
    $photo    = 'default.png';

    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $error = 'Моля, попълнете всички задължителни полета.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Невалиден имейл адрес.';
    } elseif (strlen($password) < 6) {
        $error = 'Паролата трябва да е поне 6 символа.';
    } elseif ($password !== $confirm) {
        $error = 'Паролите не съвпадат.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Имейлът вече е регистриран.';
        } else {
            // Handle photo upload
            if (!empty($_FILES['photo']['name'])) {
                $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $maxSize = 5 * 1024 * 1024;
                $finfo   = finfo_open(FILEINFO_MIME_TYPE);
                $mime    = finfo_file($finfo, $_FILES['photo']['tmp_name']);
                finfo_close($finfo);

                if (!in_array($mime, $allowed)) {
                    $error = 'Разрешени формати: JPG, PNG, GIF, WEBP.';
                } elseif ($_FILES['photo']['size'] > $maxSize) {
                    $error = 'Снимката не може да е по-голяма от 5MB.';
                } else {
                    $ext   = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                    $photo = uniqid('avatar_') . '.' . $ext;
                    move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/avatars/' . $photo);
                }
            }

            if (empty($error)) {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, phone, photo) VALUES (?,?,?,?,?)");
                $stmt->execute([$username, $email, $hash, $phone, $photo]);
                $success = 'Регистрацията беше успешна! <a href="login.php">Влез в акаунта си</a>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - MelodyStore</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <a class="navbar-brand" href="index.php">🎵 Melody<span>Store</span></a>
    <div class="nav-links">
        <a href="index.php">Начало</a>
        <a href="products.php">Продукти</a>
        <a href="login.php">Вход</a>
        <a href="register.php" class="btn btn-primary btn-sm">Регистрация</a>
    </div>
</nav>

<div class="form-container" style="max-width:560px;">
    <div class="form-card">
        <h2>🎵 Регистрация</h2>
        <p class="subtitle">Създай своя акаунт в MelodyStore</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <?php if (empty($success)): ?>
        <form method="POST" enctype="multipart/form-data">
            <!-- Photo Upload -->
            <div class="form-group">
                <label>Профилна снимка</label>
                <div class="file-upload-wrap" onclick="document.getElementById('photoInput').click()">
                    <label class="file-upload-label">
                        <input type="file" name="photo" id="photoInput" accept="image/*">
                        <div id="uploadPlaceholder">
                            <div style="font-size:2rem;margin-bottom:8px;">📷</div>
                            <div>Кликни за да <span>качиш снимка</span></div>
                            <div style="font-size:0.8rem;color:var(--text-muted);margin-top:4px;">JPG, PNG, GIF до 5MB (незадължително)</div>
                        </div>
                        <div class="upload-preview" id="uploadPreview">
                            <img id="previewImg" src="" alt="Преглед">
                            <p style="margin-top:8px;font-size:0.85rem;color:var(--text-muted)">Снимката е избрана</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Потребителско име *</label>
                <input type="text" name="username" placeholder="Иван Иванов" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Имейл адрес *</label>
                <input type="email" name="email" placeholder="ivan@example.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Телефон</label>
                <input type="tel" name="phone" placeholder="+359 88 888 8888" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Парола *</label>
                    <input type="password" name="password" placeholder="Минимум 6 символа" required>
                </div>
                <div class="form-group">
                    <label>Потвърди парола *</label>
                    <input type="password" name="confirm_password" placeholder="Повтори паролата" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Регистрирай се</button>
        </form>
        <?php endif; ?>

        <div class="form-link">
            Вече имаш акаунт? <a href="login.php">Влез тук</a>
        </div>
    </div>
</div>

<footer>
    <p>© 2024 <span>MelodyStore</span> — Твоят музикален магазин</p>
</footer>

<script>
document.getElementById('photoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        document.getElementById('previewImg').src = ev.target.result;
        document.getElementById('uploadPlaceholder').style.display = 'none';
        document.getElementById('uploadPreview').style.display = 'block';
    };
    reader.readAsDataURL(file);
});
</script>
</body>
</html>
