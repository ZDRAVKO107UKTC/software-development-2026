<?php
require 'includes/lang.php';
$pageTitle = t('task5_title');
$current = 'task5.php';
$useBootstrap = true;
require 'includes/header.php';
?>

<main class="container my-4">
    <h1 class="mb-3">API и JSON</h1>

    <!-- Теоретични въпроси -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h4">Какво е API?</h2>
                    <p>
                        <strong>API</strong> (Application Programming Interface) е „посредник", чрез който
                        две програми си говорят. То определя как да поискаме данни и какво ще получим в отговор,
                        без да знаем как точно работи другата програма отвътре.
                    </p>
                    <p class="mb-0">
                        Пример: нашият файл <code>api.php</code> е API – изпращаме му заявка и то ни връща списък с книги.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h4">Какво е JSON?</h2>
                    <p>
                        <strong>JSON</strong> (JavaScript Object Notation) е лек текстов формат за обмен на данни.
                        Записва данните като двойки <code>"ключ": стойност</code> и е лесен за четене както от хора, така и от програми.
                    </p>
                    <p class="mb-0">Това е най-използваният формат, в който API-тата връщат данни.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Вариант 1: данните идват от нашето PHP API (api.php) и се зареждат с JavaScript -->
    <h2 class="mb-1">Книжарница (данни от API)</h2>
    <p class="text-muted">Данните долу се зареждат от <code>api.php</code> с JavaScript (<code>fetch</code>).</p>

    <div id="status" class="text-muted mb-3">Зареждане...</div>
    <div id="books" class="row g-3"></div>
</main>

<script>
// Зареждаме данните от нашето PHP API
fetch('api.php')
    .then(response => response.json())   // превръщаме JSON текста в JS обекти
    .then(books => {
        document.getElementById('status').textContent = 'Заредени ' + books.length + ' книги от API.';
        const container = document.getElementById('books');
        books.forEach(book => {
            container.innerHTML += `
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">${book.title}</h5>
                            <h6 class="text-muted">${book.author}</h6>
                            <p class="mb-1">Година: ${book.year}</p>
                            <span class="badge bg-success">${book.price.toFixed(2)} лв</span>
                        </div>
                    </div>
                </div>`;
        });
    })
    .catch(() => {
        document.getElementById('status').textContent = 'Грешка при зареждане на данните.';
    });
</script>

<?php require 'includes/footer.php'; ?>
