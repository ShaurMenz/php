<?php
// viewer.php
function getFriendsList($type, $page) {
    global $mysqli;
    
    $limit = 10;
    $offset = $page * $limit;
    
    // Определение сортировки
    $order_by = "id ASC";
    if ($type == 'fam') {
        $order_by = "surname ASC, name ASC";
    } elseif ($type == 'birth') {
        $order_by = "birth_date ASC";
    }
    
    // Подсчет общего количества записей
    $count_res = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM friends");
    $count_row = mysqli_fetch_assoc($count_res);
    $total_records = $count_row['total'];
    
    if ($total_records == 0) {
        return "<p>В таблице пока нет данных.</p>";
    }
    
    $total_pages = ceil($total_records / $limit);
    
    // Корректировка номера страницы
    if ($page >= $total_pages) {
        $page = $total_pages - 1;
        $offset = $page * $limit;
    }
    
    // Выборка данных
    $sql = "SELECT * FROM friends ORDER BY $order_by LIMIT $offset, $limit";
    $res = mysqli_query($mysqli, $sql);
    
    if (!$res) {
        return "<p class='error'>Ошибка запроса: " . mysqli_error($mysqli) . "</p>";
    }
    
    $html = '<table>';
    $html .= '<tr>
                <th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Пол</th>
                <th>Дата рождения</th><th>Телефон</th><th>Адрес</th>
                <th>E-mail</th><th>Комментарий</th>
             </tr>';
    
    while ($row = mysqli_fetch_assoc($res)) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($row['surname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['patronymic']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['gender']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['birth_date']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['address']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['comment']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
    
    // Пагинация
    if ($total_pages > 1) {
        $html .= '<div id="pages">';
        $sort_param = isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : '';
        for ($i = 0; $i < $total_pages; $i++) {
            if ($i == $page) {
                $html .= '<span>' . ($i + 1) . '</span>';
            } else {
                $html .= '<a href="?p=viewer' . $sort_param . '&pg=' . $i . '">' . ($i + 1) . '</a>';
            }
        }
        $html .= '</div>';
    }
    
    return $html;
}

// === Основной код модуля ===
if (!isset($_GET['pg']) || !is_numeric($_GET['pg']) || $_GET['pg'] < 0) {
    $_GET['pg'] = 0;
}
if (!isset($_GET['sort']) || !in_array($_GET['sort'], ['byid', 'fam', 'birth'])) {
    $_GET['sort'] = 'byid';
}

echo getFriendsList($_GET['sort'], (int)$_GET['pg']);
?>