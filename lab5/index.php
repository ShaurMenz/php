<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акбаров Н.Х. | 241-352 | ЛР №5 | Таблица умножения</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
// Функция преобразует число в ссылку (если число от 2 до 9)
function outNumAsLink($x) {
    if ($x >= 2 && $x <= 9) {
        // Проверяем, был ли передан параметр html_type для сохранения в ссылке
        $html_type_param = '';
        if (isset($_GET['html_type'])) {
            $html_type_param = '&html_type=' . $_GET['html_type'];
        }
        return '<a href="?content=' . $x . $html_type_param . '">' . $x . '</a>';
    } else {
        return $x;
    }
}

function outRow($n) {
    for ($i = 2; $i <= 9; $i++) {
        echo outNumAsLink($n) . 'x' . outNumAsLink($i) . '=' . outNumAsLink($i * $n) . '<br>';
    }
}
?>

<header>
    <div class="header-content">
        <img src="fotos/logo.jpg" alt="Логотип университета" class="logo">
        <div class="header-text">
            <h1>Акбаров Н.Х.</h1>
            <p>Группа 241-352 | Лабораторная работа №5 | Таблица умножения</p>
        </div>
    </div>
</header>

<div id="header_menu">
    <?php
    echo '<a href="?html_type=TABLE';
    if (isset($_GET['content'])) {
        echo '&content=' . $_GET['content'];
    }
    echo '"';
    if (isset($_GET['html_type']) && $_GET['html_type'] == 'TABLE') {
        echo ' class="selected"';
    }
    echo '>Табличная верстка</a>';
    
    echo '<a href="?html_type=DIV';
    if (isset($_GET['content'])) {
        echo '&content=' . $_GET['content'];
    }
    echo '"';
    if (isset($_GET['html_type']) && $_GET['html_type'] == 'DIV') {
        echo ' class="selected"';
    }
    echo '>Блочная верстка</a>';
    ?>
    <div class="clear"></div>
</div>

<div id="main_menu">
    <?php
    echo '<a href="?';
    if (isset($_GET['html_type'])) {
        echo 'html_type=' . $_GET['html_type'];
    }
    echo '"';
    if (!isset($_GET['content'])) {
        echo ' class="selected"';
    }
    echo '>Всё</a>';
    
    // Ссылки от 2 до 9
    for ($i = 2; $i <= 9; $i++) {
        echo '<a href="?content=' . $i;
        if (isset($_GET['html_type'])) {
            echo '&html_type=' . $_GET['html_type'];
        }
        echo '"';
        if (isset($_GET['content']) && $_GET['content'] == $i) {
            echo ' class="selected"';
        }
        echo '>' . $i . '</a>';
    }
    ?>
</div>

<div id="content">
    <?php
    $html_type = 'TABLE';
    if (isset($_GET['html_type']) && $_GET['html_type'] == 'DIV') {
        $html_type = 'DIV';
    }
    
    if ($html_type == 'TABLE') {
        echo '<table>';
        
        if (!isset($_GET['content'])) {
            echo '<tr>';
            for ($j = 2; $j <= 9; $j++) {
                echo '<td>';
                ob_start();
                outRow($j);
                echo ob_get_clean();
                echo '</td>';
            }
            echo '</tr>';
        } else {
            echo '<tr><td>';
            ob_start();
            outRow($_GET['content']);
            echo ob_get_clean();
            echo '</td></tr>';
        }
        
        echo '</table>';
    } else {
        if (!isset($_GET['content'])) {
            for ($j = 2; $j <= 9; $j++) {
                echo '<div class="ttRow">';
                outRow($j);
                echo '</div>';
            }
        } else {
            echo '<div class="ttSingleRow">';
            outRow($_GET['content']);
            echo '</div>';
        }
    }
    ?>
</div>

<div class="clear"></div>

<footer>
    <?php
    if (!isset($_GET['html_type']) || $_GET['html_type'] == 'TABLE') {
        $s = 'Табличная верстка. ';
    } else {
        $s = 'Блочная верстка. ';
    }
    
    if (!isset($_GET['content'])) {
        $s .= 'Таблица умножения полностью. ';
    } else {
        $s .= 'Столбец таблицы умножения на ' . $_GET['content'] . '. ';
    }
    
    echo $s . date('d.m.Y H:i:s');
    ?>
</footer>

</body>
</html>