<?php
require 'includes/lang.php';
require 'includes/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$notice = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $content = $_POST['content'] ?? '';

    // махаме евентуални <script> тагове за по-голяма сигурност
    $content = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $content);

    if ($title === '' || trim(strip_tags($content)) === '') {
        $notice = ['ok' => false, 'msg' => 'Моля въведете заглавие и текст.'];
    } else {
        // 1) записваме текста от редактора в базата
        $stmt = getDb()->prepare("INSERT INTO posts (title, content, created) VALUES (?, ?, ?)");
        $stmt->execute([$title, $content, date('Y-m-d H:i:s')]);

        // 2) БОНУС: ако е избрано, изпращаме текста и на имейл с PHPMailer
        $mailMsg = '';
        if (!empty($_POST['send_mail']) && !empty($_POST['to'])) {
            require 'libs/PHPMailer/Exception.php';
            require 'libs/PHPMailer/PHPMailer.php';
            require 'libs/PHPMailer/SMTP.php';
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = trim($_POST['smtp_host'] ?? '');
                $mail->SMTPAuth   = true;
                $mail->Username   = trim($_POST['smtp_user'] ?? '');
                $mail->Password   = $_POST['smtp_pass'] ?? '';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->Timeout    = 10;
                $mail->CharSet    = 'UTF-8';
                $mail->setFrom($mail->Username, 'HTML редактор');
                $mail->addAddress(trim($_POST['to']));
                $mail->isHTML(true);
                $mail->Subject = $title;
                $mail->Body    = $content;
                $mail->send();
                $mailMsg = ' Изпратено и на имейл.';
            } catch (Exception $e) {
                $mailMsg = ' (Грешка при имейла: ' . htmlspecialchars($mail->ErrorInfo) . ')';
            }
        }

        $notice = ['ok' => true, 'msg' => 'Текстът е записан в базата.' . $mailMsg];
    }
}

$pageTitle = t('task9_title');
$current = 'task9.php';
$useBootstrap = true;
require 'includes/header.php';
?>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

<main class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">HTML редактор</h1>
        <a href="posts.php" class="btn btn-outline-dark">Виж записаните текстове →</a>
    </div>

    <?php if ($notice): ?>
        <div class="alert <?= $notice['ok'] ? 'alert-success' : 'alert-danger' ?>"><?= $notice['msg'] ?></div>
    <?php endif; ?>

    <form method="post" id="editorForm" class="card shadow-sm">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Заглавие</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <label class="form-label">Съдържание</label>
            <div id="editor" style="height:220px;"></div>
            <!-- скрито поле, в което слагаме HTML кода от редактора преди изпращане -->
            <input type="hidden" name="content" id="content">

            <details class="mt-3">
                <summary>Бонус: изпрати текста и на имейл</summary>
                <div class="form-check my-2">
                    <input type="checkbox" class="form-check-input" name="send_mail" id="send_mail" value="1">
                    <label class="form-check-label" for="send_mail">Изпрати на имейл</label>
                </div>
                <input type="email" name="to" class="form-control mb-2" placeholder="имейл на получателя">
                <input type="text" name="smtp_host" class="form-control mb-2" placeholder="smtp.gmail.com">
                <input type="text" name="smtp_user" class="form-control mb-2" placeholder="твоят имейл">
                <input type="password" name="smtp_pass" class="form-control" placeholder="app password">
            </details>

            <button type="submit" class="btn btn-primary mt-3">Запази</button>
        </div>
    </form>

    <div class="card bg-light mt-4">
        <div class="card-body">
            <h2 class="h5">Как работи?</h2>
            <ol class="mb-0">
                <li>Използваме готовия HTML редактор <strong>Quill</strong> (зарежда се от CDN).</li>
                <li>Преди изпращане слагаме HTML кода от редактора в скрито поле.</li>
                <li>PHP записва заглавието и текста в базата (<strong>SQLite</strong>) с подготвена заявка.</li>
                <li>Страницата <code>posts.php</code> чете от базата и показва текстовете.</li>
                <li>По избор текстът се праща и на имейл чрез <strong>PHPMailer</strong>.</li>
            </ol>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
const quill = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Пиши тук... можеш да форматираш текста.',
    modules: { toolbar: [
        ['bold', 'italic', 'underline'],
        [{ header: [1, 2, false] }],
        [{ list: 'ordered' }, { list: 'bullet' }],
        ['link'],
        ['clean']
    ]}
});

// при изпращане копираме HTML-а от редактора в скритото поле
document.getElementById('editorForm').addEventListener('submit', function () {
    document.getElementById('content').value = quill.root.innerHTML;
});
</script>

<?php require 'includes/footer.php'; ?>
