<?php
session_start();

// switch language when ?lang= is passed, then remember it
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'bg'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$lang = $_SESSION['lang'] ?? 'en';

$translations = [
    'en' => [
        'site_name'    => 'Software Dev 2026',
        'nav_home'     => 'Home',
        'nav_about'    => 'About',
        'nav_contact'  => 'Contact',
        'nav_tasks'    => 'Tasks',
        'nav_task1'    => 'Task 1',
        'nav_task2'    => 'Task 2',
        'nav_task3'    => 'Task 3',

        'home_title'   => 'Software Development 2026',
        'home_lead'    => 'My class project, built with PHP, HTML and CSS.',
        'home_more'    => 'About this project',
        'home_php'     => 'PHP for the server-side parts and the page logic.',
        'home_html'    => 'HTML for the page structure and content.',
        'home_css'     => 'CSS (and Bootstrap) for the layout and design.',

        'about_title'  => 'About',
        'about_p1'     => 'This site is where I keep the tasks from my software development class.',
        'about_p2'     => 'Each task gets its own page. The first one uses Bootstrap for a responsive grid.',

        'contact_title'=> 'Contact',
        'contact_lead' => 'Drop me a message below.',
        'form_name'    => 'Name',
        'form_email'   => 'Email',
        'form_message' => 'Message',
        'form_send'    => 'Send',
        'form_ok'      => 'Thanks, your message was sent.',
        'err_name'     => 'Please enter your name.',
        'err_email'    => 'Please enter a valid email.',
        'err_message'  => 'Please write a message.',

        'task1_title'  => 'Task 1 - Bootstrap grid',
        'task1_intro'  => 'Two columns with text and an image, then a row of four columns. Everything stacks to full width on small screens.',
        'task1_text_h' => 'About the layout',
        'task1_text_p' => 'On the left there is some text, on the right an image. Resize the window and the two columns become one on top of the other.',
        'task1_box'    => 'Column',

        'task2_title'  => 'Task 2 - Coffee shop "Aromat"',
        'task3_title'  => 'Task 3 - Registration form',
        'lang_switch'  => 'БГ',
    ],
    'bg' => [
        'site_name'    => 'Софт. разработка 2026',
        'nav_home'     => 'Начало',
        'nav_about'    => 'За проекта',
        'nav_contact'  => 'Контакти',
        'nav_tasks'    => 'Задачи',
        'nav_task1'    => 'Задача 1',
        'nav_task2'    => 'Задача 2',
        'nav_task3'    => 'Задача 3',

        'home_title'   => 'Софтуерна разработка 2026',
        'home_lead'    => 'Моят проект за часа, направен с PHP, HTML и CSS.',
        'home_more'    => 'За проекта',
        'home_php'     => 'PHP за сървърната част и логиката на страниците.',
        'home_html'    => 'HTML за структурата и съдържанието.',
        'home_css'     => 'CSS (и Bootstrap) за подредбата и дизайна.',

        'about_title'  => 'За проекта',
        'about_p1'     => 'Тук пазя задачите от часа по софтуерна разработка.',
        'about_p2'     => 'Всяка задача е на отделна страница. Първата използва Bootstrap за адаптивна мрежа.',

        'contact_title'=> 'Контакти',
        'contact_lead' => 'Пиши ми съобщение по-долу.',
        'form_name'    => 'Име',
        'form_email'   => 'Имейл',
        'form_message' => 'Съобщение',
        'form_send'    => 'Изпрати',
        'form_ok'      => 'Благодаря, съобщението е изпратено.',
        'err_name'     => 'Моля въведи име.',
        'err_email'    => 'Моля въведи валиден имейл.',
        'err_message'  => 'Моля напиши съобщение.',

        'task1_title'  => 'Задача 1 - Bootstrap мрежа',
        'task1_intro'  => 'Две колони с текст и снимка, после ред с четири колони. На малък екран всичко минава на цял ред.',
        'task1_text_h' => 'За подредбата',
        'task1_text_p' => 'Вляво има текст, вдясно снимка. Намали прозореца и двете колони застават една под друга.',
        'task1_box'    => 'Колона',

        'task2_title'  => 'Задача 2 - Кафене "Аромат"',
        'task3_title'  => 'Задача 3 - Регистрационен формуляр',
        'lang_switch'  => 'EN',
    ],
];

function t($key) {
    global $translations, $lang;
    return $translations[$lang][$key] ?? $key;
}

// the language we switch TO when the button is clicked
$otherLang = $lang === 'en' ? 'bg' : 'en';
