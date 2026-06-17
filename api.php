<?php
// ===== Прост API с PHP, който връща данни във формат JSON =====
// Източник на данните (тук - PHP масив; може да е и база данни)
$books = [
    ['id' => 1, 'title' => 'Чисти код',          'author' => 'Робърт Мартин', 'year' => 2008, 'price' => 39.90],
    ['id' => 2, 'title' => 'PHP за начинаещи',     'author' => 'Иван Петров',    'year' => 2021, 'price' => 24.50],
    ['id' => 3, 'title' => 'JavaScript: добрите части', 'author' => 'Дъглас Крокфорд', 'year' => 2008, 'price' => 29.00],
    ['id' => 4, 'title' => 'Прагматичният програмист', 'author' => 'Хънт и Томас', 'year' => 1999, 'price' => 34.90],
    ['id' => 5, 'title' => 'Алгоритми',            'author' => 'Томас Кормен',   'year' => 2009, 'price' => 59.90],
];

// Казваме на браузъра, че връщаме JSON (а не HTML)
header('Content-Type: application/json; charset=utf-8');

// Ако е подаден ?id=, връщаме само една книга
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    foreach ($books as $book) {
        if ($book['id'] === $id) {
            echo json_encode($book, JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
    http_response_code(404);
    echo json_encode(['error' => 'Книгата не е намерена'], JSON_UNESCAPED_UNICODE);
    exit;
}

// Иначе връщаме целия списък
echo json_encode($books, JSON_UNESCAPED_UNICODE);
