<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акбаров Н.Х. | 241-352 | ЛР №8 | Результат анализа</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .src_text {
            background: #f9f9f9;
            border-left: 4px solid #0E51A7;
            padding: 20px;
            margin: 20px 0;
            font-style: italic;
            color: #333;
            border-radius: 5px;
            font-size: 16px;
            line-height: 1.5;
        }
        
        .src_error {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            font-size: 18px;
        }
        
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
        }
        
        .stats-table th {
            background: #0E51A7;
            color: white;
            padding: 12px;
            text-align: left;
            border: 1px solid #0E51A7;
        }
        
        .stats-table td {
            padding: 10px;
            border: 1px solid #0E51A7;
        }
        
        .stats-table tr:nth-child(even) {
            background: #f2f2f2;
        }
        
        .section-title {
            color: #0E51A7;
            margin: 25px 0 15px 0;
            border-bottom: 2px solid #0E51A7;
            padding-bottom: 8px;
        }
        
        .another-btn {
            display: inline-block;
            background: #0E51A7;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }
        
        .another-btn:hover {
            background: #0a3a7a;
            text-decoration: none;
        }
        
        .info-row {
            padding: 8px;
            margin: 5px 0;
            background: white;
            border-radius: 3px;
        }
        
        .word-list {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<header>
    <div class="header-content">
        <img src="fotos/logo.jpg" alt="Логотип университета" class="logo">
        <div class="header-text">
            <h1>Акбаров Н.Х.</h1>
            <p>Группа 241-352 | Лабораторная работа №8 | Результат анализа</p>
        </div>
    </div>
</header>

<main>
    <div class="form-container">
        <h2 style="color: #0E51A7; margin-bottom: 20px; border-bottom: 2px solid #0E51A7; padding-bottom: 10px;">
            Результаты анализа текста
        </h2>

<?php

// Функция для подсчета символов
function test_symbs($text)
{
    $symbs = array();
    $l_text = strtolower($text);
    
    for($i = 0; $i < strlen($l_text); $i++) {
        $char = $l_text[$i];
        if(isset($symbs[$char])) {
            $symbs[$char]++;
        } else {
            $symbs[$char] = 1;
        }
    }
    
    return $symbs;
}

// Основная функция анализа текста
function test_it($text)
{
    // Перекодируем текст в CP1251 для корректной работы стандартных функций
    $text_cp1251 = iconv("UTF-8", "CP1251//IGNORE", $text);
    
    // Массив цифр
    $cifra = array(
        '0' => true, '1' => true, '2' => true, '3' => true, '4' => true,
        '5' => true, '6' => true, '7' => true, '8' => true, '9' => true
    );
    
    // Массив знаков препинания
    $punctuation = array(
        '.' => true, ',' => true, '!' => true, '?' => true, ';' => true,
        ':' => true, '-' => true, '"' => true, "'" => true, '(' => true,
        ')' => true, '[' => true, ']' => true, '{' => true, '}' => true
    );
    
    // Переменные для подсчета
    $cifra_amount = 0;
    $punctuation_amount = 0;
    $letters_amount = 0;
    $lower_letters = 0;
    $upper_letters = 0;
    $word = '';
    $words = array();
    
    // Русские буквы в CP1251
    // Строчные: а-я (224-255), ё (184)
    // Заглавные: А-Я (192-223), Ё (168)
    
    // Английские буквы: a-z (97-122), A-Z (65-90)
    
    $len = strlen($text_cp1251);
    
    // Подсчет символов, цифр, букв и знаков препинания
    for($i = 0; $i < $len; $i++) {
        $char = $text_cp1251[$i];
        $char_code = ord($char);
        
        // Проверка на цифру
        if(isset($cifra[$char])) {
            $cifra_amount++;
        }
        
        // Проверка на знак препинания
        if(isset($punctuation[$char])) {
            $punctuation_amount++;
        }
        
        // Проверка на букву
        $is_letter = false;
        $is_upper = false;
        $is_lower = false;
        
        // Русские строчные (а-я, ё)
        if(($char_code >= 224 && $char_code <= 255) || $char_code == 184) {
            $is_letter = true;
            $is_lower = true;
        }
        // Русские заглавные (А-Я, Ё)
        elseif(($char_code >= 192 && $char_code <= 223) || $char_code == 168) {
            $is_letter = true;
            $is_upper = true;
        }
        // Английские строчные (a-z)
        elseif($char_code >= 97 && $char_code <= 122) {
            $is_letter = true;
            $is_lower = true;
        }
        // Английские заглавные (A-Z)
        elseif($char_code >= 65 && $char_code <= 90) {
            $is_letter = true;
            $is_upper = true;
        }
        
        if($is_letter) {
            $letters_amount++;
            if($is_lower) $lower_letters++;
            if($is_upper) $upper_letters++;
        }
    }
    
    // Подсчет слов
    $separators = array_merge(
        array_keys($punctuation),
        array(' ', "\n", "\r", "\t")
    );
    
    for($i = 0; $i < $len; $i++) {
        $char = $text_cp1251[$i];
        
        $is_separator = false;
        foreach($separators as $sep) {
            if($char === $sep) {
                $is_separator = true;
                break;
            }
        }
        
        if($is_separator || $i == $len - 1) {
            // Если это последний символ и не разделитель - добавляем его к слову
            if($i == $len - 1 && !$is_separator) {
                $word .= $char;
            }
            
            if($word !== '') {
                // Приводим к нижнему регистру для учёта повторов
                $word_lower = strtolower($word);
                if(isset($words[$word_lower])) {
                    $words[$word_lower]['count']++;
                } else {
                    $words[$word_lower] = array(
                        'original' => $word,
                        'count' => 1
                    );
                }
                $word = '';
            }
        } else {
            $word .= $char;
        }
    }
    
    // Сортировка слов по алфавиту
    ksort($words);
    
    // Вывод результатов (перекодируем строки обратно в UTF-8 при необходимости)
    echo '<div class="section-title"><h3>📊 Общая статистика</h3></div>';
    echo '<table class="stats-table">';
    echo '<tr><th>Параметр</th><th>Значение</th></tr>';
    echo '<tr><td>Количество символов (включая пробелы)</td><td>' . $len . '</td></tr>';
    echo '<tr><td>Количество букв</td><td>' . $letters_amount . '</td></tr>';
    echo '<tr><td>Количество строчных букв</td><td>' . $lower_letters . '</td></tr>';
    echo '<tr><td>Количество заглавных букв</td><td>' . $upper_letters . '</td></tr>';
    echo '<tr><td>Количество знаков препинания</td><td>' . $punctuation_amount . '</td></tr>';
    echo '<tr><td>Количество цифр</td><td>' . $cifra_amount . '</td></tr>';
    echo '<tr><td>Количество слов</td><td>' . count($words) . '</td></tr>';
    echo '</table>';
    
    // Вывод статистики по символам
    echo '<div class="section-title"><h3>🔤 Частота вхождения символов</h3></div>';
    
    $symbs = test_symbs($text_cp1251);
    ksort($symbs);
    
    echo '<table class="stats-table">';
    echo '<tr><th>Символ</th><th>Количество вхождений</th></tr>';
    
    foreach($symbs as $char => $count) {
        // Пропускаем пробельные символы для читаемости
        if($char == ' ') {
            $display_char = '␣ (пробел)';
        } elseif($char == "\n") {
            $display_char = '↵ (перевод строки)';
        } elseif($char == "\r") {
            $display_char = '↵ (возврат каретки)';
        } elseif($char == "\t") {
            $display_char = '→ (табуляция)';
        } else {
            $display_char = iconv("CP1251", "UTF-8", $char);
        }
        echo '<tr><td>' . htmlspecialchars($display_char) . '</td><td>' . $count . '</td></tr>';
    }
    echo '</table>';
    
    // Вывод списка слов
    echo '<div class="section-title"><h3>📝 Список слов и частота вхождений</h3></div>';
    
    if(count($words) > 0) {
        echo '<div class="word-list">';
        echo '<table class="stats-table">';
        echo '<tr><th>Слово</th><th>Количество вхождений</th></tr>';
        
        foreach($words as $word_lower => $info) {
            // Перекодируем слово обратно в UTF-8 для отображения
            $original_utf8 = iconv("CP1251", "UTF-8", $info['original']);
            echo '<tr><td>' . htmlspecialchars($original_utf8) . '</td><td>' . $info['count'] . '</td></tr>';
        }
        echo '</table>';
        echo '</div>';
    } else {
        echo '<p style="padding: 15px; background: #f8f9fa; border-radius: 5px;">Слов не найдено</p>';
    }
}

// Основная логика
if(isset($_POST['data']) && $_POST['data'] !== '') {
    // Вывод исходного текста
    echo '<div class="section-title"><h3>📄 Исходный текст</h3></div>';
    echo '<div class="src_text">' . nl2br(htmlspecialchars($_POST['data'])) . '</div>';
    
    // Анализ текста
    test_it($_POST['data']);
    
} else {
    // Нет текста для анализа
    echo '<div class="src_error">Нет текста для анализа</div>';
}
?>

        <div style="text-align: center; margin-top: 30px;">
            <a href="index.html" class="another-btn">
                🔄 Другой анализ
            </a>
        </div>
        
    </div>
</main>

<footer>
    Лабораторная работа №8 • Анализ текста • <?php echo date('d.m.Y H:i:s'); ?>
</footer>

</body>
</html>