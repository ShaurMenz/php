<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акбаров Н.Х. | 241-352 | ЛР №7 | Ввод массива</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Дополнительные стили для страницы ввода массива */
        .array-table {
            width: auto;
            min-width: 400px;
            margin-bottom: 20px;
            background: white;
        }
        
        .array-table th {
            background: #0E51A7;
            color: white;
            padding: 10px;
            text-align: center;
        }
        
        .array-table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #0E51A7;
        }
        
        .array-table .index-cell {
            font-weight: bold;
            background: #f0f0f0;
            width: 60px;
        }
        
        .array-table input[type="text"] {
            width: 150px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            text-align: center;
        }
        
        .add-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 25px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            margin-right: 10px;
        }
        
        .add-btn:hover {
            background: #218838;
        }
        
        .sort-btn {
            background: #0E51A7;
            color: white;
            border: none;
            padding: 12px 40px;
            cursor: pointer;
            font-size: 18px;
            border-radius: 5px;
            font-weight: bold;
        }
        
        .sort-btn:hover {
            background: #0a3a7a;
        }
        
        .algorithm-select {
            width: 100%;
            max-width: 400px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin: 15px 0;
        }
        
        .info-text {
            background: #e7f3ff;
            border-left: 4px solid #0E51A7;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .button-group {
            margin-top: 25px;
            text-align: center;
        }
        
        .elements-count {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            font-weight: bold;
            color: #0E51A7;
        }
    </style>
    <script>
    function setHTML(element, txt)
    {
        if(element.innerHTML)
            element.innerHTML = txt;
        else {
            var range = document.createRange();
            range.selectNodeContents(element);
            range.deleteContents();
            var fragment = range.createContextualFragment(txt);
            element.appendChild(fragment);
        }
    }

    function addElement(table_name)
    {
        var t = document.getElementById(table_name);
        var index = t.rows.length - 1; // минус заголовок таблицы
        
        var row = t.insertRow(t.rows.length);
        
        // Ячейка с номером
        var cel1 = row.insertCell(0);
        cel1.className = 'index-cell';
        cel1.style.textAlign = 'center';
        cel1.style.fontWeight = 'bold';
        setHTML(cel1, index);
        
        // Ячейка с полем ввода
        var cel2 = row.insertCell(1);
        cel2.style.textAlign = 'center';
        var celcontent = '<input type="text" name="element' + index + '" placeholder="Введите число">';
        setHTML(cel2, celcontent);
        
        // Обновляем скрытое поле с количеством элементов
        document.getElementById('arrLength').value = t.rows.length - 1;
        
        // Обновляем отображение количества элементов
        document.getElementById('countDisplay').innerHTML = 'Количество элементов: ' + (t.rows.length - 1);
    }
    
    // Инициализация при загрузке страницы
    window.onload = function() {
        document.getElementById('countDisplay').innerHTML = 'Количество элементов: 1';
    }
    </script>
</head>
<body>

<header>
    <div class="header-content">
        <img src="fotos/logo.jpg" alt="Логотип университета" class="logo">
        <div class="header-text">
            <h1>Акбаров Н.Х.</h1>
            <p>Группа 241-352 | Лабораторная работа №7 | Сортировка массивов</p>
        </div>
    </div>
</header>

<main>
    <div class="form-container">
        <h2 style="color: #0E51A7; margin-bottom: 20px; border-bottom: 2px solid #0E51A7; padding-bottom: 10px;">
            Ввод элементов массива для сортировки
        </h2>
        
        <div class="info-text">
            <strong>Инструкция:</strong> введите числовые значения в поля ниже. 
            Нажмите «Добавить элемент» чтобы увеличить размер массива. 
            Выберите алгоритм сортировки и нажмите «Сортировать массив».
        </div>
        
        <form name="arrayForm" method="post" action="sort_array.php" target="_blank">
            <div class="elements-count" id="countDisplay">Количество элементов: 1</div>
            
            <table id="elements" class="array-table">
                <thead>
                    <tr>
                        <th>№ элемента</th>
                        <th>Значение</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="index-cell">0</td>
                        <td style="text-align: center;">
                            <input type="text" name="element0" placeholder="Введите число" value="">
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <input type="hidden" id="arrLength" name="arrLength" value="1">
            
            <div style="margin: 20px 0;">
                <button type="button" onclick="addElement('elements');" class="add-btn">
                    Добавить еще один элемент
                </button>
            </div>
            
            <div style="margin: 25px 0;">
                <label for="algoritm" style="display: block; font-weight: bold; margin-bottom: 10px; color: #333;">
                    Выберите алгоритм сортировки:
                </label>
                <select id="algoritm" name="algoritm" class="algorithm-select">
                    <option value="0">Сортировка выбором</option>
                    <option value="1">Пузырьковый алгоритм</option>
                    <option value="2">Алгоритм Шелла</option>
                    <option value="3">Алгоритм садового гнома</option>
                    <option value="4">Быстрая сортировка</option>
                    <option value="5">Встроенная функция PHP (sort)</option>
                </select>
            </div>
            
            <div class="button-group">
                <button type="submit" class="sort-btn">
                    ▶ Сортировать массив
                </button>
            </div>
            
            <div style="margin-top: 20px; font-size: 14px; color: #666; text-align: center;">
                Результат откроется в новой вкладке
            </div>
        </form>
    </div>
</main>

<footer>
    Лабораторная работа №7 • Сортировка массивов • <?php echo date('d.m.Y H:i:s'); ?>
</footer>

</body>
</html>