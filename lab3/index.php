<?php
session_start();

if (!isset($_SESSION['result'])) {
    $_SESSION['result'] = '';
    $_SESSION['clicks'] = 0;
}

if (isset($_GET['digit'])) {
    $_SESSION['result'] .= $_GET['digit'];
    $_SESSION['clicks']++;
    header("Location: index.php");
    exit;
}

if (isset($_GET['reset'])) {
    $_SESSION['result'] = '';
    $_SESSION['clicks']++;
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акбаров Н.Х. | 241-352 | ЛР №3 </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="header-content">
        <img src="fotos/logo.jpg" alt="Логотип университета" class="logo">
        <div class="header-text">
            <h1>Акбаров Н.Х.</h1>
            <p>Группа 241-352 | Лабораторная работа №3</p>
        </div>
    </div>
</header>

<main>
    <div class="result">
        <?= htmlspecialchars($_SESSION['result']) ?>
    </div>

    <div class="buttons">
        <?php for ($i = 1; $i <= 9; $i++): ?>
            <a href="?digit=<?= $i ?>" class="btn"><?= $i ?></a>
        <?php endfor; ?>
        <a href="?digit=0" class="btn">0</a>
    </div>

    <a href="?reset=1" class="reset">СБРОС</a>

</main>

<footer>
    Общее число нажатий: <?= $_SESSION['clicks'] ?>
</footer>

</body>
</html>