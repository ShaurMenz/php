<?php
require_once 'config.php';
require_once 'menu.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акбаров Н.Х. | 241-352 | ЛР №9 | Записная книжка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="header-content">
        <img src="fotos/logo.jpg" alt="Логотип университета" class="logo">
        <div class="header-text">
            <h1>Акбаров Н.Х.</h1>
            <p>Группа 241-352 | Лабораторная работа №9 | Записная книжка</p>
        </div>
    </div>
</header>

<main>
    <div class="form-container">
        <h2 style="color: #0E51A7; margin-bottom: 20px; border-bottom: 2px solid #0E51A7; padding-bottom: 10px;">
            Мои контакты
        </h2>

        <?php
        // Вывод меню
        echo getMenu();

        // Подключение модулей с контентом
        $page = isset($_GET['p']) ? $_GET['p'] : 'viewer';
        $allowed_pages = ['viewer', 'add', 'edit', 'delete'];
        
        if (in_array($page, $allowed_pages) && file_exists($page . '.php')) {
            include $page . '.php';
        } else {
            include 'viewer.php';
        }
        ?>
    </div>
</main>

<footer>
    Лабораторная работа №9 • Записная книжка • 2026
</footer>

</body>
</html>