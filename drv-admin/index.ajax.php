<?php
/**
 * index.ajax.php (admin)
 *
 * Контроллер ajax запросов админки
 *
 * Данный файл является частью системы управления контентом
 * разработанной студией Дериво
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
/* подключаем инициирующий файл */
require_once($_SERVER['DOCUMENT_ROOT']."/init/auto.php");

/* объявляем и определяем переменные */

// список глобальных констант
$global_constants1 = global_m::get_constants_data(1);
$global_constants2 = global_m::get_constants_data(2);
$global_constants = array_merge($global_constants1,$global_constants2);

// путь к корню сайта
$path_index = (!empty($global_constants['path_index']))?$global_constants['path_index']:'/';

// папка админки (из файла настроек)
$adm_folder = $GLOBALS["admin_folder"];



/* Определяем модуль, к которому обращаемся */
if (empty($_POST)){
    die("not in app");
} else {
    if (!isset($_POST['area'])){
        $error['result'] = false;
        $error['result_msg'] = "Не указана область запроса";
        exit(json_encode($error));
    } else {
        // ash-0 скорее всего не нужно
        //$GLOBALS['url_lang']['abbr'] = (isset($_POST['lang_abbr']))?$_POST['lang_abbr']:1;
        $_cur_area=$_POST['area'];
        $_cur_sub_area=(isset($_POST['sub_area']))?$_POST['sub_area']:NULL;
        $lang_text = global_v::print_lang_text_from_files($_cur_area,'admin');
        $area_path=$_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/".$_cur_area."_c.ajax.php";
        require_once($area_path);
    }
}

