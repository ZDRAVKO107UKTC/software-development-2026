<?php
require 'includes/lang.php';

$logFile = __DIR__ . '/data/calc_history.txt';
if (!is_dir(__DIR__ . '/data')) {
    mkdir(__DIR__ . '/data', 0777, true);
}

$result = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['do'] ?? '') === 'calc') {
    $a  = $_POST['a'] ?? '';
    $b  = $_POST['b'] ?? '';
    $op = $_POST['op'] ?? '+';

    if (!is_numeric($a) || !is_numeric($b)) {
        $error = 'Моля въведете две числа.';
    } else {
        $a = (float)$a;
        $b = (float)$b;
        switch ($op) {
            case '+': $result = $a + $b; break;
            case '-': $result = $a - $b; break;
            case '*': $result = $a * $b; break;
            case '/':
                if ($b == 0) { $error = 'Не може да се дели на нула!'; }
                else { $result = $a / $b; }
                break;
        }

        // Записваме изчислението във файл (всеки ред = едно изчисление)
        if ($error === '') {
            $line = sprintf("[%s] %s %s %s = %s\n", date('Y-m-d H:i:s'), $a, $op, $b, $result);
            file_put_contents($logFile, $line, FILE_APPEND);
        }
    }
}

// Изчистване на историята
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['do'] ?? '') === 'clear') {
    @unlink($logFile);
    header('Location: task7.php');
    exit;
}

// Прочитаме последните 10 записа от файла
$history = [];
if (file_exists($logFile)) {
    $lines = array_filter(explode("\n", trim(file_get_contents($logFile))));
    $history = array_slice(array_reverse($lines), 0, 10);
}

$pageTitle = t('task7_title');
$current = 'task7.php';
require 'includes/header.php';
?>

<style>
/* Собствен, различен дизайн за калкулатора - тъмен "неон" стил */
.calc-wrap { max-width: 760px; margin: 30px auto; padding: 0 15px; }
.calc {
    background: #11131a;
    border: 1px solid #2a2f45;
    border-radius: 16px;
    padding: 28px;
    color: #e6e6e6;
    box-shadow: 0 12px 40px rgba(0,0,0,.4);
}
.calc h1 { margin: 0 0 6px; font-size: 24px; color: #00e5ff; letter-spacing: 1px; }
.calc .sub { color: #7a86b8; margin-bottom: 20px; font-size: 14px; }
.calc .screen {
    background: #05060a;
    border-radius: 10px;
    padding: 18px 20px;
    font-size: 30px;
    text-align: right;
    color: #00e5ff;
    margin-bottom: 20px;
    min-height: 36px;
    word-break: break-all;
    box-shadow: inset 0 0 12px rgba(0,229,255,.15);
}
.calc-row { display: flex; gap: 12px; margin-bottom: 14px; }
.calc input, .calc select {
    flex: 1;
    background: #1b1f2e;
    border: 1px solid #2a2f45;
    color: #fff;
    padding: 14px;
    border-radius: 10px;
    font-size: 18px;
    outline: none;
}
.calc input:focus, .calc select:focus { border-color: #00e5ff; }
.calc select { max-width: 90px; text-align: center; }
.calc button.go {
    width: 100%;
    background: linear-gradient(135deg,#00e5ff,#7a5cff);
    border: none;
    color: #05060a;
    font-weight: 700;
    font-size: 18px;
    padding: 15px;
    border-radius: 10px;
    cursor: pointer;
}
.calc button.go:hover { filter: brightness(1.1); }
.calc .err { color: #ff5d6c; margin-bottom: 14px; }
.history { margin-top: 26px; background:#11131a; border:1px solid #2a2f45; border-radius:14px; padding:20px; color:#cfd3e6;}
.history h2 { color:#7a5cff; font-size:18px; margin-top:0; }
.history ul { list-style:none; padding:0; margin:0; font-family: "Consolas",monospace; font-size:14px; }
.history li { padding:7px 0; border-bottom:1px solid #20243a; }
.history .clear { margin-top:14px; background:transparent; border:1px solid #ff5d6c; color:#ff5d6c; padding:7px 14px; border-radius:8px; cursor:pointer; }
</style>

<div class="calc-wrap">
    <div class="calc">
        <h1>NEON КАЛКУЛАТОР</h1>
        <div class="sub">Изчислява с PHP и записва всяко действие във файл.</div>

        <div class="screen"><?= $result !== null ? rtrim(rtrim(number_format($result, 4, '.', ''), '0'), '.') : '0' ?></div>

        <?php if ($error): ?><div class="err"><?= htmlspecialchars($error) ?></div><?php endif; ?>

        <form method="post">
            <input type="hidden" name="do" value="calc">
            <div class="calc-row">
                <input type="text" name="a" placeholder="Число 1" value="<?= htmlspecialchars($_POST['a'] ?? '') ?>">
                <select name="op">
                    <?php foreach (['+','-','*','/'] as $o): ?>
                        <option value="<?= $o ?>" <?= (($_POST['op'] ?? '')===$o)?'selected':'' ?>><?= $o ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="b" placeholder="Число 2" value="<?= htmlspecialchars($_POST['b'] ?? '') ?>">
            </div>
            <button type="submit" class="go">Изчисли =</button>
        </form>
    </div>

    <div class="history">
        <h2>История (последни 10)</h2>
        <?php if ($history): ?>
            <ul>
                <?php foreach ($history as $h): ?>
                    <li><?= htmlspecialchars($h) ?></li>
                <?php endforeach; ?>
            </ul>
            <form method="post"><input type="hidden" name="do" value="clear">
                <button class="clear">Изчисти историята</button>
            </form>
        <?php else: ?>
            <p style="color:#7a86b8;margin:0">Все още няма изчисления. Файлът се създава при първото действие.</p>
        <?php endif; ?>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
