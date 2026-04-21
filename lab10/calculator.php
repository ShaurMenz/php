<?php
// подключение сессий в самом начале
session_start();

// инициализация при первой загрузке
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = array();
    $_SESSION['iteration'] = 0;  // Начинаем с 0
}

// функция isnum()
function isnum($x) {
    if (!$x) return false;
    if ($x[0] == '.' || $x[0] == '0') return false;
    if ($x[strlen($x) - 1] == '.') return false;
    
    for ($i = 0, $point_count = false; $i < strlen($x); $i++) {
        if ($x[$i] != '0' && $x[$i] != '1' && $x[$i] != '2' && $x[$i] != '3' &&
            $x[$i] != '4' && $x[$i] != '5' && $x[$i] != '6' && $x[$i] != '7' &&
            $x[$i] != '8' && $x[$i] != '9' && $x[$i] != '.') {
            return false;
        }
        if ($x[$i] == '.') {
            if ($point_count) return false;
            else $point_count = true;
        }
    }
    return true;
}

// функция calculate()
function calculate($val) {
    // проверка на пустую строку
    if (!$val) return 'Выражение не задано!';
    
    // Удаляем пробелы для корректной работы
    $val = str_replace(' ', '', $val);
    
    // База рекурсии - если выражение число
    if (isnum($val)) return (float)$val;
    
    // СЛОЖЕНИЕ
    // разбиваем на слагаемые
    $args = explode('+', $val);
    if (count($args) > 1) {
        $sum = 0;
        for ($i = 0; $i < count($args); $i++) {
            // рекурсивный вызов для каждого слагаемого
            $arg = calculate($args[$i]);
            if (!isnum((string)$arg) && !is_numeric($arg)) return $arg;
            $sum += (float)$arg;
        }
        return $sum;
    }
    
    // ВЫЧИТАНИЕ
    $args = explode('-', $val);
    if (count($args) > 1) {
        $sub = calculate($args[0]);
        if (!isnum((string)$sub) && !is_numeric($sub)) return $sub;
        $sub = (float)$sub;
        for ($i = 1; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!isnum((string)$arg) && !is_numeric($arg)) return $arg;
            $sub -= (float)$arg;
        }
        return $sub;
    }
    
    // УМНОЖЕНИЕ
    // разбиваем на множители
    $args = explode('*', $val);
    if (count($args) > 1) {
        $sup = 1;
        for ($i = 0; $i < count($args); $i++) {
            $arg = $args[$i];
            // Листинг В-2.5 - проверка множителя
            if (!isnum($arg)) return 'Неправильная форма числа!';
            $sup *= (float)$arg;
        }
        return $sup;
    }
    
    // ДЕЛЕНИЕ (поддержка / и :)
    $args = explode('/', $val);
    if (count($args) == 1) {
        $args = explode(':', $val);
    }
    if (count($args) > 1) {
        $div = (float)$args[0];
        if (!isnum((string)$div) && !is_numeric($div)) return 'Неправильная форма числа!';
        for ($i = 1; $i < count($args); $i++) {
            $arg = $args[$i];
            if (!isnum($arg)) return 'Неправильная форма числа!';
            if ((float)$arg == 0) return 'Деление на ноль!';
            $div /= (float)$arg;
        }
        return $div;
    }
    
    // недопустимые символы
    return 'Недопустимые символы в выражении';
}

// функция SqValidator()
function SqValidator($val) {
    $open = 0;
    for ($i = 0; $i < strlen($val); $i++) {
        if ($val[$i] == '(') {
            $open++;
        } else if ($val[$i] == ')') {
            $open--;
            if ($open < 0) return false;
        }
    }
    if ($open !== 0) return false;
    return true;
}

// функция calculateSq()
function calculateSq($val) {
    // Удаляем пробелы
    $val = str_replace(' ', '', $val);
    
    // проверка корректности скобок
    if (!SqValidator($val)) return 'Неправильная расстановка скобок';
    
    // ищем первую открывающую скобку
    $start = strpos($val, '(');
    
    // если скобок нет
    if ($start === false) return calculate($val);
    
    // ищем соответствующую закрывающую скобку
    $end = $start + 1;
    $open = 1;
    
    while ($open && $end < strlen($val)) {
        if ($val[$end] == '(') $open++;
        if ($val[$end] == ')') $open--;
        $end++;
    }
    
    // формируем новое выражение
    $new_val = substr($val, 0, $start);
    $new_val .= calculateSq(substr($val, $start + 1, $end - $start - 2));
    $new_val .= substr($val, $end);
    
    // вычисляем новое выражение
    return calculateSq($new_val);
}

// обработка формы
$res = '';
$show_result = false;

if (isset($_POST['val']) && $_POST['val'] !== '') {
    // проверка на обновление страницы
    if (!isset($_POST['iteration']) || $_POST['iteration'] == $_SESSION['iteration']) {
        // вычисляем результат
        $res = calculateSq($_POST['val']);
        $show_result = true;
        
        //  увеличиваем счётчик ТОЛЬКО при успешной обработке
        $_SESSION['iteration']++;
        
        // сохраняем в историю
        $_SESSION['history'][] = $_POST['val'] . ' = ' . $res;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акбаров Н.Х. | 241-352 | ЛР 10 | Калькулятор</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .calculator-container {
            background: white;
            padding: 30px;
            border-radius: 5px;
        }
        
        .expression-input {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            border: 2px solid #0E51A7;
            border-radius: 5px;
            margin-bottom: 20px;
            font-family: 'Courier New', monospace;
        }
        
        .calculate-btn {
            background: #0E51A7;
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }
        
        .calculate-btn:hover {
            background: #0a3a7a;
        }
        
        .result-block {
            background: #e7f3ff;
            border-left: 4px solid #0E51A7;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            font-size: 18px;
        }
        
        .result-success {
            color: #0E51A7;
            font-weight: bold;
            font-size: 24px;
        }
        
        .result-error {
            color: #d32f2f;
            font-weight: bold;
        }
        
        .history-block {
            margin-top: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        
        .history-title {
            color: #0E51A7;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 2px solid #0E51A7;
            padding-bottom: 10px;
        }
        
        .history-item {
            padding: 8px;
            margin: 5px 0;
            background: white;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            border-left: 3px solid #0E51A7;
        }
        
        .info-block {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .info-block ul {
            margin: 10px 0 0 20px;
        }
        
        .info-block li {
            margin: 5px 0;
        }
        
        .counter {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>

<header>
    <div class="header-content">
        <img src="fotos/logo.jpg" alt="Логотип университета" class="logo">
        <div class="header-text">
            <h1>Акбаров Н.Х.</h1>
            <p>Группа 241-352 | Лабораторная работа № 10 | Калькулятор с сессиями</p>
        </div>
    </div>
</header>

<main>
    <div class="form-container">
        <div class="calculator-container">
            <h2 style="color: #0E51A7; margin-bottom: 20px; border-bottom: 2px solid #0E51A7; padding-bottom: 10px;">
                Арифметический калькулятор
            </h2>
            
            <div class="info-block">
                <strong>Поддерживаемые операции:</strong>
                <ul>
                    <li>Сложение (+), вычитание (-), умножение (*), деление (/ или :)</li>
                    <li>Скобки () для группировки операций</li>
                    <li>Целые числа и десятичные дроби (например: 2.5, 10, 0.75)</li>
                    <li>Пример: (2+3)*4.5 или 10/3+2.5*4</li>
                </ul>
            </div>
            
            <form method="POST" action="">
                <label for="val" style="display: block; font-weight: bold; margin-bottom: 10px; color: #333;">
                    Введите выражение для вычисления:
                </label>
                <input type="text" 
                       id="val" 
                       name="val" 
                       class="expression-input" 
                       placeholder="Например: (2+3)*4.5"
                       value="<?php echo isset($_POST['val']) ? htmlspecialchars($_POST['val']) : ''; ?>"
                       autocomplete="off">
                
                <input type="hidden" name="iteration" value="<?php echo $_SESSION['iteration']; ?>">
                
                <button type="submit" class="calculate-btn">
                    = Вычислить
                </button>
            </form>
            
            <?php if ($show_result): ?>
                <div class="result-block">
                    <strong>Результат вычисления:</strong><br>
                    <?php if (is_numeric($res)): ?>
                        <span class="result-success">
                            <?php echo htmlspecialchars($_POST['val']); ?> = <?php echo $res; ?>
                        </span>
                    <?php else: ?>
                        <span class="result-error">
                            Ошибка: <?php echo htmlspecialchars($res); ?>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <div class="history-block">
                <div class="history-title">
                    История вычислений (сессия #<?php echo session_id(); ?>)
                </div>
                <?php if (count($_SESSION['history']) > 0): ?>
                    <?php foreach ($_SESSION['history'] as $item): ?>
                        <div class="history-item">
                            <?php echo htmlspecialchars($item); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #666; font-style: italic;">История пуста. Выполните вычисление.</p>
                <?php endif; ?>
            </div>
            
            <div class="counter">
                Счетчик загрузок: <?php echo $_SESSION['iteration']; ?>
            </div>
        </div>
    </div>
</main>

<footer>
    Лабораторная работа № 10 • Калькулятор с сессиями • <?php echo date('d.m.Y H:i:s'); ?>
</footer>

</body>
</html>