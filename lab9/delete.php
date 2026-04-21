<?php
// delete.php

// Обработка удаления
if (isset($_GET['del_id'])) {
    $id = (int)$_GET['del_id'];
    
    // Получаем фамилию перед удалением для сообщения
    $res = mysqli_query($mysqli, "SELECT surname FROM friends WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    $surname = $row['surname'];
    
    $sql = "DELETE FROM friends WHERE id=$id";
    if (mysqli_query($mysqli, $sql)) {
        echo '<div class="message success">Запись с фамилией ' . htmlspecialchars($surname) . ' удалена</div>';
    } else {
        echo '<div class="message error">Ошибка при удалении записи</div>';
    }
}

// Вывод списка всех записей для удаления
$res = mysqli_query($mysqli, "SELECT id, surname, name, patronymic FROM friends ORDER BY surname, name");
if (!$res) {
    echo '<p class="error">Ошибка базы данных</p>';
} else {
    echo '<div id="delete_links">';
    echo '<p>Выберите запись для удаления:</p>';
    while ($row = mysqli_fetch_assoc($res)) {
        // Формируем инициалы
        $initials = '';
        if ($row['name']) $initials .= mb_substr($row['name'], 0, 1) . '.';
        if ($row['patronymic']) $initials .= mb_substr($row['patronymic'], 0, 1) . '.';
        
        $display_text = $row['surname'] . ' ' . $initials;
        echo '<a href="?p=delete&del_id=' . $row['id'] . '" onclick="return confirm(\'Вы уверены, что хотите удалить эту запись?\');">' . htmlspecialchars($display_text) . '</a>';
    }
    echo '</div>';
}
?>