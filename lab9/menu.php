<?php
// menu.php
function getMenu() {
    // Проверка и установка параметра 'p' (пункт меню)
    if (!isset($_GET['p']) || !in_array($_GET['p'], ['viewer', 'add', 'edit', 'delete'])) {
        $_GET['p'] = 'viewer';
    }

    // Проверка и установка параметра 'sort' для подменю
    if ($_GET['p'] == 'viewer') {
        if (!isset($_GET['sort']) || !in_array($_GET['sort'], ['byid', 'fam', 'birth'])) {
            $_GET['sort'] = 'byid';
        }
    }

    $html = '<div id="menu">';
    
    // Пункт "Просмотр"
    $html .= '<a href="?p=viewer"';
    if ($_GET['p'] == 'viewer') $html .= ' class="selected"';
    $html .= '>Просмотр</a>';
    
    // Пункт "Добавление записи"
    $html .= '<a href="?p=add"';
    if ($_GET['p'] == 'add') $html .= ' class="selected"';
    $html .= '>Добавление записи</a>';
    
    // Пункт "Редактирование записи"
    $html .= '<a href="?p=edit"';
    if ($_GET['p'] == 'edit') $html .= ' class="selected"';
    $html .= '>Редактирование записи</a>';
    
    // Пункт "Удаление записи"
    $html .= '<a href="?p=delete"';
    if ($_GET['p'] == 'delete') $html .= ' class="selected"';
    $html .= '>Удаление записи</a>';
    
    // Подменю для "Просмотра"
    if ($_GET['p'] == 'viewer') {
        $html .= '<div id="submenu">';
        
        // Подпункт "По-умолчанию"
        $html .= '<a href="?p=viewer&sort=byid"';
        if ($_GET['sort'] == 'byid') $html .= ' class="selected"';
        $html .= '>По-умолчанию</a>';
        
        // Подпункт "По фамилии"
        $html .= '<a href="?p=viewer&sort=fam"';
        if ($_GET['sort'] == 'fam') $html .= ' class="selected"';
        $html .= '>По фамилии</a>';

        // Подпункт "По дате рождения"
        $html .= '<a href="?p=viewer&sort=birth"';
        if ($_GET['sort'] == 'birth') $html .= ' class="selected"';
        $html .= '>По дате рождения</a>';
        
        $html .= '</div>';
    }
    
    $html .= '</div>';
    return $html;
}
?>