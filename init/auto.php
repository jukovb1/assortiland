<?php
/**
 * auto.php
 *
 * Файл инициализации сайта
 *
 * Данный файл является частью системы управления контентом
 * разработанной студией Дериво
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
header("Expires: " . date("D, d M Y") . " 00:00:00 GMT");
header("Last-Modified: " . date("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=UTF-8');
header("Pragma: no-cache");
define("IN_APP",true);

// подключение классов отладчиков
require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/time_control.class.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/internal_errors.list.php');


/*контроль времени загрузки*/control_time::add_to_log("Initialization",__FILE__,__LINE__);
$show_time_report=(isset($_GET['show_time_report']))?true:false;

// определяем локальный или сетевой запуск скрипта
if ((strtolower(substr($_SERVER["DOCUMENT_ROOT"],1,2))==":/")
    || (substr($_SERVER["HTTP_HOST"],-3)==".loc")
    || (substr($_SERVER["HTTP_HOST"],-5)==".here")
    || (substr($_SERVER["HTTP_HOST"],-6)==".shere")) {
    $GLOBALS["is_local_start"]=true;
}else {
    $GLOBALS["is_local_start"]=false;
}

// подключение настроек доступных пользователю
require_once('config_site.php');
// подключаем контроль ошибок
require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/error_control.functions.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/ash_debug.functions.php');
// подключаем класс базы данных
require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/db.class.php');
// подключаем глобальные классы и функции
require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/global_c.functions.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/global_m.class.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/global_v.class.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/global_v.functions.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/page_navigation.class.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/multiple_checkbox/multiple_checkbox.class.php');


// коннектимся к БД
if($GLOBALS["is_local_start"]){
    $class_db= new Database("127.0.0.1", "derivo", "par123derivo", "derivo");
}else{
    $class_db= new Database($db_settings['db_host'], $db_settings['db_user'], $db_settings['db_pass'], $db_settings['db_name']);
}

require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/auth/auth.class.php');

// todo ash-0 временно считаем всех суперадминами
$user_group = 1;
$user_id = 1;
if ($user_group == 1) {
    $show_time_report=true;
}

// todo ash-9 реализовать папку для подключения файлов сторонних скриптов + контроллер для автолоадера этих файлов

// подключаем контроль ЧПУ, url-команд и языка
$langs_data = global_m::get_langs_data();

require_once($_SERVER["DOCUMENT_ROOT"]."/global_scripts/friendly_url/friendly_url.class.php");
$friendly_url = new friendly_url();

// список пользователей с правами админов
$user_list['admins']   = global_m::get_user_list("1,2");
$user_list['sellers']  = global_m::get_user_list("4");
$user_list['partners'] = global_m::get_user_list("5");



