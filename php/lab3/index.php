<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акбаров Н.Х. | 241-352 | ЛР №3</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $store = $_GET['store'] ?? '';
    $counter = $_GET['counter'] ?? 0;
    
    if (isset($_GET['key'])) {
        $counter++;
        if ($_GET['key'] === 'reset') {
            $store = '';
        } else {
            $store .= $_GET['key'];
        }
    }
    ?>

    <header>
        <div class="header-content">
            <img src="fotos/logo.jpg" alt="Логотип" class="logo">
            <div class="header-text">
                <h1>Акбаров Н.Х.</h1>
                <p>Группа 241-352 | Лабораторная работа №3</p>
            </div>
        </div>
    </header>

    <main>
        <h2>Динамический сайт</h2>

        <div class="container">
            <div class="result"><?= htmlspecialchars($store) ?></div>
            
            <div class="buttons">
                <?php for ($i = 0; $i <= 9; $i++): ?>
                    <a href="?key=<?= $i ?>&store=<?= urlencode($store) ?>&counter=<?= $counter ?>" class="btn"><?= $i ?></a>
                <?php endfor; ?>
            </div>
            
            <a href="?key=reset&store=&counter=<?= $counter ?>" class="reset">СБРОС</a>
        </div>
    </main>

    <footer>
        Динамический сайт • ЛР №3 • Всего нажатий: <?= $counter ?>
    </footer>
</body>
</html>