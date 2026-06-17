<?php
require 'includes/lang.php';
$pageTitle = t('task2_title');
$current = 'task2.php';
$useBootstrap = true;
require 'includes/header.php';
?>

<!-- Тема: Кафене "Аромат". Текстовете са на български, снимките са в папка /images -->

<main class="container my-4">

    <h1 class="mb-1">Кафене „Аромат“</h1>
    <p class="text-muted">Уютно място за хубаво кафе и сладки изкушения в центъра на града.</p>

    <!-- КОМПОНЕНТ: Carousel (въртележка) -->
    <div id="glavenCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#glavenCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#glavenCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#glavenCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner rounded">
            <div class="carousel-item active">
                <img src="images/hero.jpg" class="d-block w-100" alt="Нашето кафене">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Добре дошли в „Аромат“</h5>
                    <p>Започни деня си с истинско италианско еспресо.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/shop2.jpg" class="d-block w-100" alt="Интериор">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Спокойна атмосфера</h5>
                    <p>Идеално място за работа или среща с приятели.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/shop3.jpg" class="d-block w-100" alt="Сладкиши">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Домашни сладкиши</h5>
                    <p>Печем всеки ден с любов и качествени продукти.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#glavenCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#glavenCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- КОМПОНЕНТ: Alert (съобщение) -->
    <div class="alert alert-warning" role="alert">
        🎉 Нова промоция: всяко второ кафе е с 50% намаление до края на месеца!
    </div>

    <!-- КОМПОНЕНТ: Cards (карти) в адаптивна мрежа -->
    <h2 class="mb-3">Нашето меню</h2>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <img src="images/espresso.jpg" class="card-img-top" alt="Еспресо">
                <div class="card-body">
                    <h5 class="card-title">Еспресо</h5>
                    <p class="card-text">Силно и ароматно кафе от подбрани зърна. <span class="badge bg-success">2.00 лв</span></p>
                    <a href="#" class="btn btn-dark">Поръчай</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <img src="images/latte.jpg" class="card-img-top" alt="Лате">
                <div class="card-body">
                    <h5 class="card-title">Кафе лате</h5>
                    <p class="card-text">Мляко на пара с нежен вкус на кафе. <span class="badge bg-success">3.50 лв</span></p>
                    <a href="#" class="btn btn-dark">Поръчай</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <img src="images/cake.jpg" class="card-img-top" alt="Торта">
                <div class="card-body">
                    <h5 class="card-title">Парче торта</h5>
                    <p class="card-text">Домашна торта по рецепта на баба. <span class="badge bg-success">4.00 лв</span></p>
                    <a href="#" class="btn btn-dark">Поръчай</a>
                </div>
            </div>
        </div>
    </div>

    <!-- КОМПОНЕНТ: Accordion (хармоника) -->
    <h2 class="mb-3">Често задавани въпроси</h2>
    <div class="accordion mb-4" id="faq">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q1">
                    Имате ли безплатен Wi-Fi?
                </button>
            </h2>
            <div id="q1" class="accordion-collapse collapse" data-bs-parent="#faq">
                <div class="accordion-body">Да, предлагаме безплатен и бърз интернет за всички гости.</div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2">
                    Работите ли в почивните дни?
                </button>
            </h2>
            <div id="q2" class="accordion-collapse collapse" data-bs-parent="#faq">
                <div class="accordion-body">Отворени сме всеки ден от 08:00 до 21:00 часа.</div>
            </div>
        </div>
    </div>

    <!-- КОМПОНЕНТ: List group (списък) -->
    <h2 class="mb-3">Работно време</h2>
    <ul class="list-group mb-4" style="max-width:400px">
        <li class="list-group-item d-flex justify-content-between">
            <span>Понеделник – Петък</span><span>08:00 – 21:00</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Събота – Неделя</span><span>09:00 – 22:00</span>
        </li>
    </ul>

    <!-- КОМПОНЕНТ: Обяснение на използваните компоненти -->
    <div class="card bg-light mb-4">
        <div class="card-body">
            <h2 class="h4">Използвани Bootstrap компоненти</h2>
            <ul class="mb-0">
                <li><strong>Navbar / Dropdown</strong> – менюто горе с падащ списък „Задачи“.</li>
                <li><strong>Carousel</strong> – въртележка със снимки в началото на страницата.</li>
                <li><strong>Alert</strong> – цветно съобщение за промоцията.</li>
                <li><strong>Card</strong> – картите с менюто (снимка, текст и бутон).</li>
                <li><strong>Badge</strong> – малките етикети с цените.</li>
                <li><strong>Button</strong> – бутоните „Поръчай“.</li>
                <li><strong>Accordion</strong> – сгъваемите въпроси и отговори.</li>
                <li><strong>List group</strong> – списъкът с работното време.</li>
                <li><strong>Grid (row / col)</strong> – адаптивната мрежа, която подрежда всичко.</li>
            </ul>
        </div>
    </div>

</main>

<!-- Bootstrap JS - нужен за carousel, accordion и др. -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php require 'includes/footer.php'; ?>
