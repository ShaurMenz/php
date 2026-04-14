<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акбаров Н.Х. | 241-352 | ЛР №4</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="fotos/logo.jpg" alt="Логотип" class="logo">
            <div class="header-text">
                <h1>Акбаров Н.Х.</h1>
                <p>Группа 241-352 | Лабораторная работа №4</p>
            </div>
        </div>
    </header>

    <main>
        <?php
        function getTR($stroka, $chisloKolonok)
        {
            if(trim($stroka) == '' || $stroka == '*')
                return '';
    
            $yacheyki = explode('*', $stroka);
    
            $estYacheyki = false;
            foreach($yacheyki as $y)
            {
                if(trim($y) != '')
                {
                    $estYacheyki = true;
                    break;
                }
            }
    
            if(!$estYacheyki)
                return '';
    
            $kod = '<tr>';
    
            for($i = 0; $i < $chisloKolonok; $i++)
            {
                if(isset($yacheyki[$i]) && trim($yacheyki[$i]) != '')
                    $kod .= '<td>' . $yacheyki[$i] . '</td>';
                else
                    $kod .= '<td>&nbsp;</td>';
            }
    
            return $kod . '</tr>';
        }

        function outTable($dannye, $chisloKolonok, $nomer)
        {
            echo '<h2>Таблица №' . $nomer . '</h2>';
            
            if($chisloKolonok == 0)
            {
                echo '<div class="error">Неправильное число колонок</div>';
                return;
            }
            
            $stroki = explode('#', $dannye);
            
            $estStroki = false;
            foreach($stroki as $s)
            {
                if(trim($s) != '')
                    $estStroki = true;
            }
            
            if(!$estStroki)
            {
                echo '<div class="error">В таблице нет строк</div>';
                return;
            }
            
            $tablica = '';
            $estYacheyki = false;
            
            foreach($stroki as $s)
            {
                $s = trim($s);
                if($s == '') continue;
                
                $strokaKod = getTR($s, $chisloKolonok);
                
                if($strokaKod != '')
                {
                    $estYacheyki = true;
                    $tablica .= $strokaKod;
                }
            }
            
            if(!$estYacheyki)
            {
                echo '<div class="error">В таблице нет строк с ячейками</div>';
                return;
            }
            echo '<table>' . $tablica . '</table>';
        }

        
        $chisloKolonok = 3;
        
        $tablitsy = array(
            '1*2*3#4*5*6#7*8*9',
            'Яблоко*Банан*Апельсин#Груша*Виноград*Киви',
            'Пн*Вт*Ср#Чт*Пт*Сб#Вс',
            '',
            'Красный*Синий*Зеленый#Желтый*Фиолетовый*Оранжевый',
            '#',
            'Раз*Два*Три#Четыре*Пять*Шесть',
            '*',
            'Зима*Весна*Лето#Осень',
            'Кошка*Собака*Попугай#Хомяк*Рыбки*Кролик'
        );
        
        for($i = 0; $i < count($tablitsy); $i++)
        {
            outTable($tablitsy[$i], $chisloKolonok, $i + 1);
        }
        ?>
    </main>

    <footer>
        Лабораторная работа №4 • Пользовательские функции
    </footer>
</body>
</html>