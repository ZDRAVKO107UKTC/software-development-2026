<?php
// HTML темплейт за писмото. Връща готовия HTML като текст.
// Inline стиловете се ползват, защото имейл клиентите не четат външен CSS.
function buildEmailTemplate($name, $message) {
    $name = htmlspecialchars($name);
    $message = nl2br(htmlspecialchars($message));
    $year = date('Y');

    return <<<HTML
<!DOCTYPE html>
<html lang="bg">
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#f2f2f2;font-family:Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f2f2f2;padding:20px 0;">
        <tr><td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;">
                <tr>
                    <td style="background:#3367d6;color:#ffffff;padding:24px;text-align:center;">
                        <h1 style="margin:0;font-size:22px;">Софтуерна разработка 2026</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:28px;color:#333333;">
                        <h2 style="margin-top:0;">Здравей, {$name}!</h2>
                        <p style="font-size:15px;line-height:1.6;">Получи ново съобщение:</p>
                        <div style="background:#f7f7f7;border-left:4px solid #3367d6;padding:14px 18px;font-size:15px;color:#444;">
                            {$message}
                        </div>
                        <p style="margin-top:24px;">
                            <a href="#" style="background:#3367d6;color:#fff;text-decoration:none;padding:10px 22px;border-radius:5px;display:inline-block;">Към сайта</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="background:#f2f2f2;color:#888888;padding:16px;text-align:center;font-size:12px;">
                        &copy; {$year} Софтуерна разработка 2026
                    </td>
                </tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
HTML;
}
