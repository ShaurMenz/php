<?php
// add.php
$message = '';
$message_class = '';

if (isset($_POST['button']) && $_POST['button'] == 'Добавить запись') {
    $surname = mysqli_real_escape_string($mysqli, $_POST['surname']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $patronymic = mysqli_real_escape_string($mysqli, $_POST['patronymic']);
    $gender = mysqli_real_escape_string($mysqli, $_POST['gender']);
    $birth_date = mysqli_real_escape_string($mysqli, $_POST['birth_date']);
    $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
    $address = mysqli_real_escape_string($mysqli, $_POST['address']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $comment = mysqli_real_escape_string($mysqli, $_POST['comment']);
    
    $sql = "INSERT INTO friends (surname, name, patronymic, gender, birth_date, phone, address, email, comment)
            VALUES ('$surname', '$name', '$patronymic', '$gender', '$birth_date', '$phone', '$address', '$email', '$comment')";
            
    if (mysqli_query($mysqli, $sql)) {
        $message = 'Запись добавлена';
        $message_class = 'success';
    } else {
        $message = 'Ошибка: запись не добавлена';
        $message_class = 'error';
    }
}
?>

<?php if ($message): ?>
    <div class="message <?php echo $message_class; ?>"><?php echo $message; ?></div>
<?php endif; ?>

<form name="form_add" method="post" action="?p=add">
    <input type="text" name="surname" placeholder="Фамилия" required>
    <input type="text" name="name" placeholder="Имя" required>
    <input type="text" name="patronymic" placeholder="Отчество">
    <select name="gender" required>
        <option value="">Выберите пол</option>
        <option value="М">Мужской</option>
        <option value="Ж">Женский</option>
    </select>
    <input type="date" name="birth_date" placeholder="Дата рождения">
    <input type="tel" name="phone" placeholder="Телефон">
    <input type="text" name="address" placeholder="Адрес">
    <input type="email" name="email" placeholder="E-mail">
    <textarea name="comment" placeholder="Комментарий"></textarea>
    <input type="submit" name="button" value="Добавить запись">
</form>