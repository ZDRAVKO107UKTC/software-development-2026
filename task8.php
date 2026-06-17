<?php
require 'includes/lang.php';
$pageTitle = t('task8_title');
$current = 'task8.php';
require 'includes/header.php';
?>

<style>
.game-wrap { max-width: 520px; margin: 30px auto; text-align: center; padding: 0 15px; }
.game-wrap h1 { margin-bottom: 4px; }
.game-wrap p.hint { color: #666; margin-top: 0; }
#board {
    background: #0d1b2a;
    border: 4px solid #1b263b;
    border-radius: 10px;
    display: block;
    margin: 14px auto;
    touch-action: none;
}
.scoreline {
    display: flex;
    justify-content: space-between;
    font-weight: bold;
    font-size: 18px;
    max-width: 400px;
    margin: 0 auto;
}
.game-btn {
    background: #3367d6;
    color: #fff;
    border: none;
    padding: 10px 22px;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 12px;
}
.game-btn:hover { background: #284e9e; }
#msg { color: #c0392b; font-weight: bold; height: 22px; }
</style>

<div class="game-wrap">
    <h1>🐍 Змия</h1>
    <p class="hint">Управлявай със стрелките (или WASD). Изяж червените ябълки и не се удряй в себе си!</p>

    <div class="scoreline">
        <span>Точки: <span id="score">0</span></span>
        <span>Рекорд: <span id="best">0</span></span>
    </div>

    <canvas id="board" width="400" height="400"></canvas>
    <div id="msg"></div>
    <button class="game-btn" id="startBtn">Старт / Нова игра</button>
</div>

<script>
const canvas = document.getElementById('board');
const ctx = canvas.getContext('2d');
const SIZE = 20;            // размер на едно квадратче
const CELLS = canvas.width / SIZE; // 20 клетки

let snake, dir, nextDir, food, score, best = 0, loop, alive = false;

function reset() {
    snake = [{x: 10, y: 10}];
    dir = {x: 1, y: 0};
    nextDir = dir;
    score = 0;
    placeFood();
    document.getElementById('score').textContent = score;
    document.getElementById('msg').textContent = '';
    alive = true;
    clearInterval(loop);
    loop = setInterval(tick, 110);
}

function placeFood() {
    do {
        food = { x: Math.floor(Math.random()*CELLS), y: Math.floor(Math.random()*CELLS) };
    } while (snake.some(s => s.x === food.x && s.y === food.y));
}

function tick() {
    dir = nextDir;
    const head = { x: snake[0].x + dir.x, y: snake[0].y + dir.y };

    // удар в стената или в тялото = край
    if (head.x < 0 || head.y < 0 || head.x >= CELLS || head.y >= CELLS ||
        snake.some(s => s.x === head.x && s.y === head.y)) {
        gameOver();
        return;
    }

    snake.unshift(head);

    if (head.x === food.x && head.y === food.y) {
        score++;
        document.getElementById('score').textContent = score;
        if (score > best) { best = score; document.getElementById('best').textContent = best; }
        placeFood();
    } else {
        snake.pop(); // махаме опашката, ако не сме яли
    }

    draw();
}

function draw() {
    ctx.fillStyle = '#0d1b2a';
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    if (!snake || !food) return; // още няма започната игра

    // храна
    ctx.fillStyle = '#e74c3c';
    ctx.fillRect(food.x*SIZE, food.y*SIZE, SIZE, SIZE);

    // змия
    snake.forEach((s, i) => {
        ctx.fillStyle = i === 0 ? '#2ecc71' : '#27ae60';
        ctx.fillRect(s.x*SIZE+1, s.y*SIZE+1, SIZE-2, SIZE-2);
    });
}

function gameOver() {
    clearInterval(loop);
    alive = false;
    document.getElementById('msg').textContent = 'Край! Натисни Старт за нова игра.';
}

// управление - стрелки и WASD, без обратен завой
document.addEventListener('keydown', e => {
    const k = e.key.toLowerCase();
    if ((k === 'arrowup' || k === 'w') && dir.y === 0)    nextDir = {x:0, y:-1};
    if ((k === 'arrowdown' || k === 's') && dir.y === 0)  nextDir = {x:0, y:1};
    if ((k === 'arrowleft' || k === 'a') && dir.x === 0)  nextDir = {x:-1, y:0};
    if ((k === 'arrowright' || k === 'd') && dir.x === 0) nextDir = {x:1, y:0};
    if (['arrowup','arrowdown','arrowleft','arrowright'].includes(k)) e.preventDefault();
});

document.getElementById('startBtn').addEventListener('click', reset);
draw(); // покажи празното поле в началото
</script>

<?php require 'includes/footer.php'; ?>
