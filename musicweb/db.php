<?php
$host = 'localhost';
$dbname = 'music_store';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('<div style="font-family:sans-serif;padding:20px;background:#1a1a2e;color:#e94560;">
        <h2>Грешка при свързване с базата данни</h2>
        <p>' . htmlspecialchars($e->getMessage()) . '</p>
        <p>Уверете се, че сте изпълнили <strong>db_setup.sql</strong> в phpMyAdmin.</p>
    </div>');
}
