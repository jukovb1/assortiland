<?php
/**
 * index.php (admin)
 *
 * Главный контроллер админки
 *
 * Данный файл является частью системы управления контентом
 * разработанной студией Дериво
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
/* подключаем инициирующий файл */
require_once($_SERVER['DOCUMENT_ROOT']."/init/auto.php");
$lang_text = global_v::print_lang_text_from_files('.global','admin');
$auth_class = new auth('admin');

/* объявляем и определяем переменные */

// раздел по-умолчанию (главная страница)
$default_area="dashboard";

// список глобальных констант
$global_constants1 = global_m::get_constants_data(1);
$global_constants2 = global_m::get_constants_data(2);
$global_constants = array_merge($global_constants1,$global_constants2);

// путь к корню сайта
$path_index = (!empty($global_constants['path_index']))?$global_constants['path_index']:'/';

// папка админки (из файла настроек)
$adm_folder = $GLOBALS["admin_folder"];

// путь к контроллеру главного меню
$main_menu_path = $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/system/main_menu/main_menu_c.php";

// получаем все глобальные js для раздела
$global_js_scripts_list = global_v::print_global_js_in_header('admin');

// защищаемся от склероза, потому тут объявляем переменные, в которых будет список js для модуля
$js_for_module = array();
$local_js_scripts_list = NULL;
$show_lang_tabs_for_mod = false; // по-умолчанию не показываем языковые вкладки
// кол-во отображаемых в таблице строк
$num_of_rows_per_page =15;
// разрешённые для загрузки файлы
$current_file_types = array(
    'image/jpeg','image/png','image/gif',
    'application/pdf','application/x-download',
);

$msg_for_user = '';
$msg_color_for_user = 'inherit';

// объявляем массив темплейта
$global_template = array(
    'for_title'      => false,
    'for_title_text' => NULL,
    'for_head'       => NULL,
    'for_content'    => NULL,
);

if (isset($_COOKIE['msg_for_user'])){
    $msg_color_for_user = 'msg_ok';
    $msg_for_user = $_COOKIE['msg_for_user'];
    setcookie('msg_for_user','',time(),'/');
}


/* Определяем модуль, к которому обращаемся (по URL)*/
$_cur_area_sub = NULL;
$sub_area_path = NULL;
if (!is_null($friendly_url->url_sub_page)){
    $_cur_area=$friendly_url->url_page;
    $_cur_area_sub=$friendly_url->url_sub_page;
    $sub_area_path=$_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/".$_cur_area."_v_sub_page.$_cur_area_sub.php";
}elseif (!is_null($friendly_url->url_page)){
    $_cur_area=$friendly_url->url_page;
} else {
    $_cur_area=$default_area;
}

// инициируем файл дополнительных строк в head для модуля
$dop_head = $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_to_head_v.php";

$area_path=$_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/".$_cur_area."_c.php";
$error_path=$_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/404/404_c.php";


// todo ash-9 здесь реализовать поиск
//if (isset($_GET['q'])){
//    $search_q = $_GET['q'];
//} else {
//    $search_q = false;
//}
//
//if (isset($GLOBALS['url_command'])){
//    if (isset($GLOBALS['url_command']['search'])){
//        $area_path = $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/commands/search/search_c.php";
//    } else {
//        require_once($error_path);
//    }
//}

// объявляем модули, у которых могут быть подстраницы
$module_with_subpages['options']=true;
$module_with_subpages['content']=true;
$module_with_subpages['adm_products']=true;
$module_with_subpages['adm_users']=true;
$module_with_subpages['statistic']=true;

// проверка наличия раздела в файловой системе, в случае ошибки, выдаём страницу 404
if (file_exists($area_path)) {
    if (!is_null($sub_area_path) && !file_exists($sub_area_path)){
        // todo ash-0 тут была специфичная обработка ошибки URL
        // не уверен, что она будет нужна для всех проектов,
        // но пока оставлю это условие
        if (!isset($module_with_subpages[$_cur_area])){
            // получаем массив текстов для текущего раздела и языка
            $lang_text = global_v::print_lang_text_from_files('404','admin');
            require_once($error_path);
        } else {

            // получаем массив текстов для текущего раздела и языка
            $lang_text = global_v::print_lang_text_from_files($_cur_area,'admin');
            if ($auth_class->show_form || ($auth_class->cur_user_group!=1 && $auth_class->cur_user_group!=2)){//ash-9 + проверку по правам
                require_once($auth_class->auth_form_path);
            } else {
                require_once($area_path);
            }

        }
    } else {
        // получаем массив текстов для текущего раздела и языка
        $lang_text = global_v::print_lang_text_from_files($_cur_area,'admin');
        if ($auth_class->show_form || ($auth_class->cur_user_group!=1 && $auth_class->cur_user_group!=2)){
            require_once($auth_class->auth_form_path);
        } else {
            require_once($area_path);
        }

    }
} else {
    // получаем массив текстов для текущего раздела и языка
    $lang_text = global_v::print_lang_text_from_files('404','admin');
    require_once($error_path);
}




/* подключаем файл представления*/
require_once($_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/global_v.php");





/*  код для дебага */

ash_debug($lang_text);

ash_debug($no_language_keys,'Не существующие языковые ключи');
/* конец кода дебага */
/*контроль времени загрузки*/control_time::add_to_log("После html",__FILE__,__LINE__,true);
