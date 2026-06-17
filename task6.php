<?php
require 'includes/lang.php';
require 'includes/email_template.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$result = null;
$previewHtml = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name      = trim($_POST['name'] ?? '');
    $message   = trim($_POST['message'] ?? '');
    $toEmail   = trim($_POST['to'] ?? '');
    $smtpHost  = trim($_POST['smtp_host'] ?? '');
    $smtpUser  = trim($_POST['smtp_user'] ?? '');
    $smtpPass  = $_POST['smtp_pass'] ?? '';

    // Сглобяваме писмото от HTML темплейта
    $previewHtml = buildEmailTemplate($name, $message);

    if (($_POST['mode'] ?? '') === 'send') {
        // Зареждаме PHPMailer (ръчно, без composer)
        require 'libs/PHPMailer/Exception.php';
        require 'libs/PHPMailer/PHPMailer.php';
        require 'libs/PHPMailer/SMTP.php';

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = $smtpHost;        // напр. smtp.gmail.com
            $mail->SMTPAuth   = true;
            $mail->Username   = $smtpUser;        // твоят имейл
            $mail->Password   = $smtpPass;        // app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->Timeout    = 10;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom($smtpUser, 'Софтуерна разработка 2026');
            $mail->addAddress($toEmail, $name);

            $mail->isHTML(true);                  // казваме, че тялото е HTML
            $mail->Subject = 'Ново съобщение от сайта';
            $mail->Body    = $previewHtml;        // HTML темплейтът
            $mail->AltBody = strip_tags($message);// текстова версия за стари клиенти

            $mail->send();
            $result = ['ok' => true, 'msg' => 'Писмото е изпратено успешно до ' . htmlspecialchars($toEmail) . '!'];
        } catch (Exception $e) {
            $result = ['ok' => false, 'msg' => 'Грешка при изпращане: ' . htmlspecialchars($mail->ErrorInfo)];
        }
    }
}

$pageTitle = t('task6_title');
$current = 'task6.php';
$useBootstrap = true;
require 'includes/header.php';
?>

<main class="container my-4">
    <h1 class="mb-3">Изпращане на имейл с PHPMailer</h1>

    <?php if ($result): ?>
        <div class="alert <?= $result['ok'] ? 'alert-success' : 'alert-danger' ?>"><?= $result['msg'] ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Форма -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h5 mb-3">Съобщение</h2>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Име на получателя</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($_POST['name'] ?? 'Иван') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Имейл на получателя</label>
                            <input type="email" name="to" class="form-control" value="<?= htmlspecialchars($_POST['to'] ?? '') ?>" placeholder="ime@mail.bg">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Текст на съобщението</label>
                            <textarea name="message" rows="3" class="form-control" required><?= htmlspecialchars($_POST['message'] ?? 'Здравей! Това е тестово писмо.') ?></textarea>
                        </div>

                        <details class="mb-3">
                            <summary class="mb-2">SMTP настройки (за реално изпращане)</summary>
                            <input type="text" name="smtp_host" class="form-control mb-2" placeholder="smtp.gmail.com" value="<?= htmlspecialchars($_POST['smtp_host'] ?? '') ?>">
                            <input type="text" name="smtp_user" class="form-control mb-2" placeholder="твоят имейл" value="<?= htmlspecialchars($_POST['smtp_user'] ?? '') ?>">
                            <input type="password" name="smtp_pass" class="form-control" placeholder="app password">
                        </details>

                        <div class="d-flex gap-2">
                            <button type="submit" name="mode" value="preview" class="btn btn-outline-primary">Покажи темплейта</button>
                            <button type="submit" name="mode" value="send" class="btn btn-primary">Изпрати имейл</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Преглед на HTML темплейта -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Преглед на HTML темплейта</h2>
                    <?php if ($previewHtml): ?>
                        <iframe srcdoc="<?= htmlspecialchars($previewHtml) ?>" style="width:100%;height:430px;border:1px solid #ddd;border-radius:6px;"></iframe>
                    <?php else: ?>
                        <p class="text-muted">Натисни „Покажи темплейта", за да видиш как изглежда писмото.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Теоретично обяснение -->
    <div class="card bg-light mt-4">
        <div class="card-body">
            <h2 class="h4">За какво служи PHPMailer и как се използва?</h2>
            <p>
                <strong>PHPMailer</strong> е популярна PHP библиотека за изпращане на имейли. За разлика от
                вградената функция <code>mail()</code>, той може да праща през <strong>SMTP</strong> сървър
                (напр. Gmail), да изпраща HTML писма, прикачени файлове и поддържа автентикация и криптиране.
            </p>
            <p class="mb-1"><strong>Стъпки за използване:</strong></p>
            <ol class="mb-0">
                <li>Инсталираш го (с <code>composer require phpmailer/phpmailer</code> или ръчно, както тук в <code>libs/</code>).</li>
                <li>Създаваш обект <code>new PHPMailer()</code> и викаш <code>isSMTP()</code>.</li>
                <li>Задаваш <code>Host</code>, <code>Username</code>, <code>Password</code>, <code>Port</code> и криптиране.</li>
                <li>Задаваш подател (<code>setFrom</code>) и получател (<code>addAddress</code>).</li>
                <li>С <code>isHTML(true)</code> и <code>Body</code> слагаш HTML темплейта на писмото.</li>
                <li>Извикваш <code>send()</code> вътре в <code>try/catch</code> за прихващане на грешки.</li>
            </ol>
        </div>
    </div>
</main>

<?php require 'includes/footer.php'; ?>
