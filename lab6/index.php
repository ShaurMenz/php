<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акбаров Н.Х. | 241-352 | ЛР №6 | Тестирование</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
$rand_a = mt_rand(10, 100) / 10;
$rand_b = mt_rand(10, 100) / 10;
$rand_c = mt_rand(10, 100) / 10;

if(isset($_POST['A'])) $_POST['A'] = str_replace(',', '.', $_POST['A']);
if(isset($_POST['B'])) $_POST['B'] = str_replace(',', '.', $_POST['B']);
if(isset($_POST['C'])) $_POST['C'] = str_replace(',', '.', $_POST['C']);

if(isset($_POST['A']))
{
    if($_POST['TASK'] == 'mean')
    {
        $result = round(($_POST['A'] + $_POST['B'] + $_POST['C']) / 3, 2);
        $task_name = 'Среднее арифметическое';
    }
    else if($_POST['TASK'] == 'perimetr')
    {
        $result = round($_POST['A'] + $_POST['B'] + $_POST['C'], 2);
        $task_name = 'Периметр треугольника';
    }
    else if($_POST['TASK'] == 'area')
    {
        $p = ($_POST['A'] + $_POST['B'] + $_POST['C']) / 2;
        $result = round(sqrt($p * ($p - $_POST['A']) * ($p - $_POST['B']) * ($p - $_POST['C'])), 2);
        $task_name = 'Площадь треугольника (формула Герона)';
    }
    else if($_POST['TASK'] == 'volume')
    {
        $result = round($_POST['A'] * $_POST['B'] * $_POST['C'], 2);
        $task_name = 'Объем параллелепипеда';
    }
    else if($_POST['TASK'] == 'hypotenuse') 
    {
        $result = round(sqrt($_POST['A'] * $_POST['A'] + $_POST['B'] * $_POST['B']), 2);
        $task_name = 'Гипотенуза (A и B - катеты)';
    }
    else if($_POST['TASK'] == 'geometric')
    {
        $result = round(pow($_POST['A'] * $_POST['B'] * $_POST['C'], 1/3), 2);
        $task_name = 'Среднее геометрическое';
    }
    
    $out_text = '<div class="report">';
    $out_text .= '<p><b>ФИО:</b> ' . htmlspecialchars($_POST['FIO']) . '</p>';
    $out_text .= '<p><b>Группа:</b> ' . htmlspecialchars($_POST['GROUP']) . '</p>';
    
    if(!empty($_POST['ABOUT'])) {
        $out_text .= '<p><b>О себе:</b><br>' . nl2br(htmlspecialchars($_POST['ABOUT'])) . '</p>';
    }
    
    $out_text .= '<p><b>Решаемая задача:</b> ' . $task_name . '</p>';
    $out_text .= '<p><b>Входные данные:</b> A = ' . $_POST['A'] . ', B = ' . $_POST['B'] . ', C = ' . $_POST['C'] . '</p>';
    
    if(isset($_POST['result']) && $_POST['result'] !== '') {
        $user_result = str_replace(',', '.', $_POST['result']);
        $out_text .= '<p><b>Предполагаемый результат:</b> ' . $user_result . '</p>';
    } else {
        $user_result = null;
        $out_text .= '<p><b>Предполагаемый результат:</b> Задача самостоятельно решена не была</p>';
    }
    
    $out_text .= '<p><b>Вычисленный программой результат:</b> ' . $result . '</p>';
    
    if($user_result !== null && abs($result - $user_result) < 0.01) {
        $out_text .= '<p class="success"><b>ТЕСТ ПРОЙДЕН</b></p>';
        $test_passed = true;
    } else {
        $out_text .= '<p class="error"><b>ОШИБКА: ТЕСТ НЕ ПРОЙДЕН</b></p>';
        $test_passed = false;
    }
    
    $out_text .= '</div>';
    
    if(isset($_POST['VIEW']) && $_POST['VIEW'] == 'print') {
        echo '<div class="print-version">';
    }
    
    echo $out_text;
    
    if(isset($_POST['send_mail']) && !empty($_POST['MAIL']))
    {
        $text_mail = strip_tags(str_replace('<br>', "\r\n", str_replace('</p>', "\r\n", str_replace('<p>', '', $out_text))));
        
        mail(
            $_POST['MAIL'],
            'Результат тестирования',
            $text_mail,
            "From: auto@test.ru\r\n" . "Content-Type: text/plain; charset=utf-8\r\n"
        );
        
        echo '<p>Результаты теста были автоматически отправлены на e-mail ' . htmlspecialchars($_POST['MAIL']) . '</p>';
    }
    
    if(!isset($_POST['VIEW']) || $_POST['VIEW'] == 'browser') {
        echo '<a href="?FIO=' . urlencode($_POST['FIO']) . '&GROUP=' . urlencode($_POST['GROUP']) . '" id="back_button">Повторить тест</a>';
    }
    
    if(isset($_POST['VIEW']) && $_POST['VIEW'] == 'print') {
        echo '</div>';
    }
}
else 
{
    $fio_value = isset($_GET['FIO']) ? htmlspecialchars($_GET['FIO']) : '';
    $group_value = isset($_GET['GROUP']) ? htmlspecialchars($_GET['GROUP']) : '';
?>

<header>
    <div class="header-content">
        <img src="fotos/logo.jpg" alt="Логотип университета" class="logo">
        <div class="header-text">
            <h1>Акбаров Н.Х.</h1>
            <p>Группа 241-352 | Лабораторная работа №6 | Тестирование</p>
        </div>
    </div>
</header>

<main>
    <div class="form-container">
        <form name="form" method="post" action="">
            <div class="form-row">
                <label for="fio">ФИО:</label>
                <input type="text" id="fio" name="FIO" value="<?php echo $fio_value; ?>" required>
            </div>
            
            <div class="form-row">
                <label for="group">Номер группы:</label>
                <input type="text" id="group" name="GROUP" value="<?php echo $group_value; ?>" required>
            </div>
            
            <div class="form-row">
                <label for="a">Значение А:</label>
                <input type="text" id="a" name="A" value="<?php echo $rand_a; ?>" required>
            </div>

            <div class="form-row">
                <label for="b">Значение В:</label>
                <input type="text" id="b" name="B" value="<?php echo $rand_b; ?>" required>
            </div>

            <div class="form-row">
                <label for="c">Значение С:</label>
                <input type="text" id="c" name="C" value="<?php echo $rand_c; ?>" required>
            </div>

            <div class="form-row">
                <label for="result">Ваш ответ:</label>
                <input type="text" id="result" name="result">
            </div>

            <div class="form-row">
                <label for="about">Немного о себе:</label>
                <textarea id="about" name="ABOUT"></textarea>
            </div>
            
            <div class="form-row">
                <label for="task">Выберите задачу:</label>
                <select id="task" name="TASK">
                    <option value="mean">Среднее арифметическое</option>
                    <option value="perimetr">Периметр треугольника</option>
                    <option value="area">Площадь треугольника</option>
                    <option value="volume">Объем параллелепипеда</option>
                    <option value="hypotenuse">Гипотенуза</option>
                    <option value="geometric">Среднее геометрическое</option>
                </select>
            </div>

            <div class="form-row checkbox-row">
                <input type="checkbox" id="send_mail" name="send_mail" onclick="
                    obj=document.getElementById('mail_block');
                    if (this.checked)
                        obj.style.display='block';
                    else
                        obj.style.display='none';">
                <label for="send_mail">отправить результат теста по e-mail</label>
            </div>

            <div id="mail_block" class="form-row" style="display:none;">
                <label for="mail">Ваш e-mail:</label>
                <input type="email" id="mail" name="MAIL">
            </div>

            <div class="form-row">
                <label for="view">Версия отображения:</label>
                <select id="view" name="VIEW">
                    <option value="browser">версия для просмотра в браузере</option>
                    <option value="print">версия для печати</option>
                </select>
            </div>

            <div class="form-row">
                <input type="submit" value="Проверить" class="submit-btn">
            </div>
        </form>
    </div>
</main>

<?php
} 
?>

<footer>
    Лабораторная работа №6 • Тестирование • <?php echo date('d.m.Y H:i:s'); ?>
</footer>

</body>
</html>