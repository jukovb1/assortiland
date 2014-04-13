<?php
/**
 * internal_errors.list.php
 *
 * Список и обработчик внутренних ошибок сайта
 *
 * Данный файл является частью системы управления контентом
 * разработанной студией Дериво
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
if (!defined('IN_APP')) {
    die("not in app");
}
// todo ash-9 пока не используется, м.б. потом, или удалить

// информация
$internal_error[0][100] = 'Успех при сохранении';

// ошибки по значимости от 1 до 3
$internal_error[1][100] = 'Нет соответствия языковому индексу в БД';
$internal_error[1][101] = 'Передано не предусмотренное поле';
$internal_error[1][102] = 'Нет сохранённых данных';

$internal_error[2][100] = 'Ошибка при сохранении';
$internal_error[2][101] = 'Не заполнены обязательные поля';


/**
 * show_internal_error($err_num)
 *
 * @param $err_num number (Номер ошибки)(example: 1)
 * @return string
 * Возвращает строку с номером и описанием ошибки
 */
function show_internal_error($err_num){
    global $internal_error;
    return "<span style='color: red;font-weight: bold;cursor: default' title='{$internal_error[$err_num]}'>Internal error №$err_num</span>";
}