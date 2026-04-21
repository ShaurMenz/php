<?php
// edit.php

// Обработка изменения записи
if (isset($_POST['button']) && $_POST['button'] == 'Изменить запись') {
    $id = (int)$_GET['id'];
    $surname = mysqli_real_escape_string($mysqli, $_POST['surname']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $patronymic = mysqli_real_escape_string($mysqli, $_POST['patronymic']);
    $gender = mysqli_real_escape_string($mysqli, $_POST['gender']);
    $birth_date = mysqli_real_escape_string($mysqli, $_POST['birth_date']);
    $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
    $address = mysqli_real_escape_string($mysqli, $_POST['address']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $comment = mysqli_real_escape_string($mysqli, $_POST['comment']);
    
    $sql = "UPDATE friends SET 
            surname='$surname', name='$name', patronymic='$patronymic', gender='$gender',
            birth_date='$birth_date', phone='$phone', address='$address', email='$email', comment='$comment'
            WHERE id=$id";
            
    if (mysqli_query($mysqli, $sql)) {
        echo '<div class="message success">Данные изменены</div>';
    } else {
        echo '<div class="message error">Ошибка при изменении данных</div>';
    }
}

// Получение данных о текущей записи
$currentROW = null;
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $res = mysqli_query($mysqli, "SELECT * FROM friends WHERE id=$id");
    $currentROW = mysqli_fetch_assoc($res);
}

if (!$currentROW) {
    // Если запись не найдена или не указана, берем первую
    $res = mysqli_query($mysqli, "SELECT * FROM friends ORDER BY surname, name LIMIT 1");
    $currentROW = mysqli_fetch_assoc($res);
}

// Вывод списка всех записей
$all_res = mysqli_query($mysqli, "SELECT id, surname, name FROM friends ORDER BY surname, name");
if (!$all_res) {
    echo '<p class="error">Ошибка базы данных</p>';
} else {
    echo '<div id="edit_links">';
    while ($row = mysqli_fetch_assoc($all_res)) {
        if ($currentROW && $row['id'] == $currentROW['id']) {
            echo '<div>' . htmlspecialchars($row['surname'] . ' ' . $row['name']) . '</div>';
        } else {
            echo '<a href="?p=edit&id=' . $row['id'] . '">' . htmlspecialchars($row['surname'] . ' ' . $row['name']) . '</a>';
        }
    }
    echo '</div>';
    
    // Вывод формы, если есть записи
    if ($currentROW) {
        ?>
        <form name="form_edit" method="post" action="?p=edit&id=<?php echo $currentROW['id']; ?>">
            <input type="text" name="surname" placeholder="Фамилия" value="<?php echo htmlspecialchars($currentROW['surname']); ?>" required>
            <input type="text" name="name" placeholder="Имя" value="<?php echo htmlspecialchars($currentROW['name']); ?>" required>
            <input type="text" name="patronymic" placeholder="Отчество" value="<?php echo htmlspecialchars($currentROW['patronymic']); ?>">
            <select name="gender" required>
                <option value="М" <?php if($currentROW['gender'] == 'М') echo 'selected'; ?>>Мужской</option>
                <option value="Ж" <?php if($currentROW['gender'] == 'Ж') echo 'selected'; ?>>Женский</option>
            </select>
            <input type="date" name="birth_date" value="<?php echo htmlspecialchars($currentROW['birth_date']); ?>">
            <input type="tel" name="phone" value="<?php echo htmlspecialchars($currentROW['phone']); ?>">
            <input type="text" name="address" value="<?php echo htmlspecialchars($currentROW['address']); ?>">
            <input type="email" name="email" value="<?php echo htmlspecialchars($currentROW['email']); ?>">
            <textarea name="comment"><?php echo htmlspecialchars($currentROW['comment']); ?></textarea>
            <input type="submit" name="button" value="Изменить запись">
        </form>
        <?php
    } else {
        echo '<p>Записей пока нет</p>';
    }
}
?>