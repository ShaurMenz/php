<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акбаров Н.Х. | 241-352 | ЛР №7 | Результат сортировки</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .iteration-block {
            background: white;
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #0E51A7;
        }
        .array-display {
            font-family: monospace;
            font-size: 14px;
            padding: 5px;
            background: #f9f9f9;
            border-radius: 3px;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>

<header>
    <div class="header-content">
        <img src="fotos/logo.jpg" alt="Логотип университета" class="logo">
        <div class="header-text">
            <h1>Акбаров Н.Х.</h1>
            <p>Группа 241-352 | Лабораторная работа №7 | Результат сортировки</p>
        </div>
    </div>
</header>

<main>
<div class="form-container">

<?php

// Функция проверки: является ли аргумент НЕ числом
function arg_is_not_Num($arg)
{
    $arg = trim($arg);
    if($arg === '') return true; // пустая строка
    
    // Проверка на число (целое или дробное, включая отрицательные)
    for($i = 0; $i < strlen($arg); $i++) {
        $ch = $arg[$i];
        // Первый символ может быть минусом
        if($i == 0 && $ch == '-') continue;
        // Допускаем одну точку или запятую как десятичный разделитель
        if(($ch == '.' || $ch == ',') && $i > 0 && $i < strlen($arg)-1) continue;
        // Проверяем, что символ - цифра
        if($ch !== '0' && $ch !== '1' && $ch !== '2' && $ch !== '3' && $ch !== '4' &&
           $ch !== '5' && $ch !== '6' && $ch !== '7' && $ch !== '8' && $ch !== '9') {
            return true;
        }
    }
    return false;
}

// Глобальный счетчик итераций
$iteration_count = 0;

// Функция для вывода состояния массива
function printArrayState($arr, $iteration_num = null) {
    $output = '<span class="array-display">[';
    $parts = array();
    foreach($arr as $val) {
        $parts[] = $val;
    }
    $output .= implode(', ', $parts) . ']</span>';
    if($iteration_num !== null) {
        $output = '<strong>Итерация ' . $iteration_num . ':</strong> ' . $output;
    }
    return $output;
}

// 1. Сортировка выбором
function sorting_by_choice($arr) {
    global $iteration_count;
    $n = count($arr);
    
    echo '<div class="iteration-block">';
    echo '<h3>Ход сортировки выбором:</h3>';
    echo printArrayState($arr, 0) . '<br>';
    
    for($i = 0; $i < $n - 1; $i++) {
        $min = $i;
        for($j = $i + 1; $j < $n; $j++) {
            $iteration_count++;
            if($arr[$j] < $arr[$min]) {
                $min = $j;
            }
        }
        if($min != $i) {
            $temp = $arr[$i];
            $arr[$i] = $arr[$min];
            $arr[$min] = $temp;
        }
        echo printArrayState($arr, $iteration_count) . '<br>';
    }
    echo '</div>';
    return $arr;
}

// 2. Пузырьковый алгоритм
function bubble_sort($arr) {
    global $iteration_count;
    $n = count($arr);
    
    echo '<div class="iteration-block">';
    echo '<h3>Ход пузырьковой сортировки:</h3>';
    echo printArrayState($arr, 0) . '<br>';
    
    for($i = 0; $i < $n - 1; $i++) {
        for($j = 0; $j < $n - $i - 1; $j++) {
            $iteration_count++;
            if($arr[$j] > $arr[$j + 1]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
            }
            echo printArrayState($arr, $iteration_count) . '<br>';
        }
    }
    echo '</div>';
    return $arr;
}

// 3. Алгоритм Шелла (проверенная версия)
function ShellsSort($arr) {
    global $iteration_count;
    $n = count($arr);
    
    echo '<div class="iteration-block">';
    echo '<h3>Ход сортировки Шелла:</h3>';
    echo '<strong>Итерация 0:</strong> ' . printArrayState($arr, 0) . '<br>';
    
    $gap = floor($n / 2);
    
    while($gap > 0) {
        echo '<p style="color: #0E51A7;"><strong>→ Шаг сортировки: ' . $gap . '</strong></p>';
        
        for($i = $gap; $i < $n; $i++) {
            $temp = $arr[$i];
            $j = $i;
            
            while($j >= $gap && $arr[$j - $gap] > $temp) {
                $iteration_count++;
                $arr[$j] = $arr[$j - $gap];
                $j = $j - $gap;
                echo '<strong>Итерация ' . $iteration_count . ':</strong> ' . printArrayState($arr) . ' (сдвиг)<br>';
            }
            
            $arr[$j] = $temp;
            if($i != $j) {
                $iteration_count++;
                echo '<strong>Итерация ' . $iteration_count . ':</strong> ' . printArrayState($arr) . ' (вставка)<br>';
            }
        }
        
        $gap = floor($gap / 2);
    }
    
    echo '</div>';
    return $arr;
}

// 4. Алгоритм садового гнома (оптимизированная версия)
function gnomeSort($arr) {
    global $iteration_count;
    $n = count($arr);
    
    echo '<div class="iteration-block">';
    echo '<h3>Ход сортировки садового гнома:</h3>';
    echo printArrayState($arr, 0) . '<br>';
    
    $i = 1;
    $j = 2;
    while($i < $n) {
        if(!$i || $arr[$i - 1] <= $arr[$i]) {
            $iteration_count++;
            echo printArrayState($arr, $iteration_count) . ' (шаг вперёд)<br>';
            $i = $j;
            $j++;
        } else {
            $iteration_count++;
            $temp = $arr[$i];
            $arr[$i] = $arr[$i - 1];
            $arr[$i - 1] = $temp;
            $i--;
            echo printArrayState($arr, $iteration_count) . ' (шаг назад, обмен)<br>';
        }
    }
    echo '</div>';
    return $arr;
}

// 5. Быстрая сортировка
function quickSort(&$arr, $left, $right) {
    global $iteration_count;
    
    $l = $left;
    $r = $right;
    $point = $arr[floor(($left + $right) / 2)];
    
    do {
        while($arr[$l] < $point) $l++;
        while($arr[$r] > $point) $r--;
        
        if($l <= $r) {
            $iteration_count++;
            $temp = $arr[$l];
            $arr[$l] = $arr[$r];
            $arr[$r] = $temp;
            
            echo '<span class="array-display">[';
            $parts = array();
            foreach($arr as $val) $parts[] = $val;
            echo implode(', ', $parts) . ']</span> ';
            echo '(опорный: ' . $point . ', l=' . $l . ', r=' . $r . ')<br>';
            
            $l++;
            $r--;
        }
    } while($l <= $r);
    
    if($r > $left) quickSort($arr, $left, $r);
    if($l < $right) quickSort($arr, $l, $right);
}

function quickSortWrapper($arr) {
    global $iteration_count;
    
    echo '<div class="iteration-block">';
    echo '<h3>Ход быстрой сортировки:</h3>';
    echo '<strong>Итерация 0:</strong> <span class="array-display">[';
    $parts = array();
    foreach($arr as $val) $parts[] = $val;
    echo implode(', ', $parts) . ']</span><br>';
    
    quickSort($arr, 0, count($arr) - 1);
    
    echo '</div>';
    return $arr;
}

// ===== ОСНОВНАЯ ПРОГРАММА =====

if(!isset($_POST['element0'])) {
    echo '<div class="error-message">Массив не задан, сортировка невозможна</div>';
    echo '</div></main><footer>Лабораторная работа №7 • Сортировка массивов • ' . date('d.m.Y H:i:s') . '</footer></body></html>';
    exit();
}

// Формируем массив и проверяем валидность
$arr = array();
$has_error = false;
$error_element = '';

for($i = 0; $i < $_POST['arrLength']; $i++) {
    $element = str_replace(',', '.', $_POST['element' . $i]);
    if(arg_is_not_Num($element)) {
        $has_error = true;
        $error_element = $_POST['element' . $i];
        break;
    }
    $arr[] = (float)$element;
}

if($has_error) {
    echo '<div class="error-message">Элемент массива "' . htmlspecialchars($error_element) . '" - не число</div>';
    echo '</div></main><footer>Лабораторная работа №7 • Сортировка массивов • ' . date('d.m.Y H:i:s') . '</footer></body></html>';
    exit();
}

// Определяем название алгоритма
$algoritm_names = array(
    0 => 'Сортировка выбором',
    1 => 'Пузырьковый алгоритм',
    2 => 'Алгоритм Шелла',
    3 => 'Алгоритм садового гнома',
    4 => 'Быстрая сортировка',
    5 => 'Встроенная функция PHP (sort)'
);

$algoritm = isset($_POST['algoritm']) ? (int)$_POST['algoritm'] : 0;
echo '<h2>' . $algoritm_names[$algoritm] . '</h2>';

// Вывод исходного массива
echo '<h3>Входные данные:</h3>';
echo '<div style="background: white; padding: 15px; margin-bottom: 20px;">';
for($i = 0; $i < count($arr); $i++) {
    echo '<div class="arr_element" style="display: inline-block; padding: 5px 15px; margin: 5px; background: #e9e9e9; border-radius: 3px;">' . $i . ': ' . $arr[$i] . '</div>';
}
echo '</div>';

// Сообщение об успешной валидации
echo '<div class="success-message">Массив проверен, сортировка возможна</div>';

// Засекаем время и выполняем сортировку
$time_start = microtime(true);
$iteration_count = 0;

if($algoritm == 5) {
    // Встроенная функция
    echo '<div class="iteration-block">';
    echo '<h3>Сортировка встроенной функцией sort():</h3>';
    echo '<strong>Исходный массив:</strong> <span class="array-display">[' . implode(', ', $arr) . ']</span><br>';
    sort($arr);
    echo '<strong>Результат:</strong> <span class="array-display">[' . implode(', ', $arr) . ']</span><br>';
    echo '</div>';
    $iteration_count = 1;
} else {
    // Пользовательские алгоритмы
    switch($algoritm) {
        case 0:
            $arr = sorting_by_choice($arr);
            break;
        case 1:
            $arr = bubble_sort($arr);
            break;
        case 2:
            $arr = ShellsSort($arr);
            break;
        case 3:
            $arr = gnomeSort($arr);
            break;
        case 4:
            $arr = quickSortWrapper($arr);
            break;
    }
}

$time_end = microtime(true);
$time_diff = round($time_end - $time_start, 6);

// Вывод итогового сообщения
echo '<div class="success-message" style="background: #0E51A7; color: white;">';
echo '<strong>Сортировка завершена, проведено ' . $iteration_count . ' итераций. ';
echo 'Сортировка заняла ' . $time_diff . ' секунд.</strong>';
echo '</div>';

// Вывод отсортированного массива
echo '<h3>Отсортированный массив:</h3>';
echo '<div style="background: white; padding: 15px;">';
for($i = 0; $i < count($arr); $i++) {
    echo '<div class="arr_element" style="display: inline-block; padding: 5px 15px; margin: 5px; background: #d4edda; border-radius: 3px;">' . $i . ': ' . $arr[$i] . '</div>';
}
echo '</div>';

?>

</div>
</main>

<footer>
    Лабораторная работа №7 • Сортировка массивов • <?php echo date('d.m.Y H:i:s'); ?>
</footer>

</body>
</html>