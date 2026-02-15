<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акбаров Н.Х. | 241-352 | ЛР №2 | Вариант 1</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="header-content">
        <img src="fotos/logo.jpg" alt="Логотип университета" class="logo">
        <div class="header-text">
            <h1>Акбаров Н.Х.</h1>
            <p>Группа 241-352 | Лабораторная работа №2 | Вариант 1</p>
        </div>
    </div>
</header>

<main>
<h2>Динамический сайт (PHP)</h2>

<?php
$x0 = -10;        
$step = 2;        
$count = 20;     
$type = 'A';      

$min_limit = -1000; 
$max_limit = 1000; 

$x = $x0;
$sum = 0;
$min = null;
$max = null;
$n = 0;

switch ($type) {
    case 'B': echo "<ul>"; break;
    case 'C': echo "<ol>"; break;
    case 'D':
        echo "<table border='1' cellspacing='0' cellpadding='5'>
                <tr>
                    <th>№</th>
                    <th>x</th>
                    <th>f(x)</th>
                </tr>";
        break;
    case 'E':
        echo "<div style='overflow:hidden'>";
        break;
}

for ($i = 1; $i <= $count; $i++) {
    if ($x <= 10) {
        $f = 10 * $x - 5;
    } elseif ($x < 20) {
        $f = ($x + 3) * ($x ** 2);
    } else {
        if ($x == 25) {
            $f = "error";
        } else {
            $f = 3 / ($x - 25) + 2;
        }
    }

    if ($f !== "error") {
        $f = round($f, 3);

        $sum += $f;
        $min = ($min === null) ? $f : min($min, $f);
        $max = ($max === null) ? $f : max($max, $f);
        $n++;

        if ($f < $min_limit || $f > $max_limit) {
            break;
        }
    }

    switch ($type) {
        case 'A':
            echo "f($x) = $f<br>";
            break;
        case 'B':
        case 'C':
            echo "<li>f($x) = $f</li>";
            break;
        case 'D':
            echo "<tr><td>$i</td><td>$x</td><td>$f</td></tr>";
            break;
        case 'E':
            echo "<div style='float:left; border:2px solid red; margin:8px; padding:10px;'>
                    f($x) = $f
                  </div>";
            break;
    }

    $x += $step;
}

switch ($type) {
    case 'B': echo "</ul>"; break;
    case 'C': echo "</ol>"; break;
    case 'D': echo "</table>"; break;
    case 'E': echo "</div>"; break;
}

$avg = ($n > 0) ? round($sum / $n, 3) : 0;

echo "<h3>Статистика</h3>";
echo "<p>Сумма: $sum</p>";
echo "<p>Минимум: $min</p>";
echo "<p>Максимум: $max</p>";
echo "<p>Среднее: $avg</p>";
?>

</main>

<footer>
    Тип верстки: <?php echo $type; ?>
</footer>

</body>
</html>