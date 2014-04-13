<?php
/**
 * index.php
 *
 * Главный контроллер сайта
 *
 * Данный файл является частью системы управления контентом
 * разработанной студией Дериво
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
/* подключаем инициирующий файл */
require_once($_SERVER['DOCUMENT_ROOT']."/init/auto.php");
$lang_text = global_v::print_lang_text_from_files('.global');
$auth_class = new auth();
/* объявляем и определяем переменные */

// раздел по-умолчанию (главная страница)
$default_area="main";

// список глобальных констант
$global_constants1 = global_m::get_constants_data(1);
$global_constants2 = global_m::get_constants_data(2);
$global_constants = array_merge($global_constants1,$global_constants2);
// получаем список цитат
$quote_sliders = get_quote_slider_data();

// путь к корню сайта
$path_index = (!empty($global_constants['path_index']))?$global_constants['path_index']:'/';

// папка админки (из файла настроек)
$adm_folder = $GLOBALS["admin_folder"];

// путь к контроллерам меню
$main_menu_path = $_SERVER['DOCUMENT_ROOT']."/modules/system/main_menu/main_menu_c.php";
if(isset($main_menu_path)){
	require_once($main_menu_path);
}
// путь к контроллеру комментариев
$comments_path = $_SERVER['DOCUMENT_ROOT']."/modules/system/comments/comments_c.php";
// по-умолчанию запрещаем комментарии
$allow_comments = false;
// получаем все глобальные js для раздела
$global_js_scripts_list = global_v::print_global_js_in_header();

// защищаемся от склероза, потому тут объявляем переменные, в которых будет список js для модуля
$js_for_module = array();
$local_js_scripts_list = NULL;
// кол-во отображаемых в таблице строк ash-2 возможно не понадобится
$num_of_rows_per_page = 10;

$footer_statistic['products'] = global_m::count_products("кроме скрытых");
$footer_statistic['sellers'] = count($user_list['sellers']);
$footer_statistic['partners'] = count($user_list['partners']);

$msg_for_user = '';
$msg_color_for_user = 'inherit';

// объявляем массив темплейта
$global_template = array(
    'for_title'      => false,
    'for_title_text' => NULL,
    'for_head'       => NULL,
    'for_content'    => NULL,
    'for_meta_desc'	 => NULL,
    'for_meta_keys'	 => NULL,
    'for_canonical'  => false,
    'for_noindex'    => false,
    'for_canonical_text' => NULL,
);
if (isset($_COOKIE['msg_for_user'])){
    $msg_color_for_user = (isset($_COOKIE['msg_for_user_color']))?$_COOKIE['msg_for_user_color']:'msg_ok';
    $msg_for_user = $_COOKIE['msg_for_user'];
    setcookie('msg_for_user_color','',time(),'/');
    setcookie('msg_for_user','',time(),'/');
}



/* Определяем модуль, к которому обращаемся (по URL)*/
$_cur_area_sub = NULL;
$sub_area_path = NULL;
if (!is_null($friendly_url->url_sub_page)){
    $_cur_area=$friendly_url->url_page;
    $_cur_area_sub=$friendly_url->url_sub_page;
    $sub_area_path=$_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/".$_cur_area."_v_sub_page.$_cur_area_sub.php";
}elseif (!is_null($friendly_url->url_page)){
    $_cur_area=$friendly_url->url_page;
} else {
    $_cur_area=$default_area;
    if (!is_null($friendly_url->url_user_login)){
        $_cur_area='profile';
    }
}

// инициируем файл дополнительных строк в head для модуля
$dop_head = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_to_head_v.php";

$area_path=$_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/".$_cur_area."_c.php";
$error_path=$_SERVER['DOCUMENT_ROOT']."/modules/404/404_c.php";


// todo ash-9 здесь реализовать поиск
//if (isset($_GET['q'])){
//    $search_q = $_GET['q'];
//} else {
//    $search_q = false;
//}
//


if (count($friendly_url->url_command)>0){
    if (isset($friendly_url->url_command['search'])){
        //$area_path = $_SERVER['DOCUMENT_ROOT']."/modules/system/search/search_c.php";
    } else {
        //require_once($error_path);
    }
}

// объявляем модули, у которых могут быть подстраницы
$module_with_subpages['pages']=true;
$module_with_subpages['catalog']=true;
$module_with_subpages['product']=true;
$module_with_subpages['profile']=true;


// проверка наличия раздела в файловой системе, в случае ошибки, выдаём страницу 404
if (file_exists($area_path)) {
    if (!is_null($sub_area_path) && !file_exists($sub_area_path)){
        // todo ash-0 тут была специфичная обработка ошибки URL
        // не уверен, что она будет нужна для всех проектов,
        // но пока оставлю это условие
        if (!isset($module_with_subpages[$_cur_area])){
            // получаем массив текстов для текущего раздела и языка
            $lang_text = global_v::print_lang_text_from_files('404');
            require_once($error_path);
        } else {
            // получаем массив текстов для текущего раздела и языка
            $lang_text = global_v::print_lang_text_from_files($_cur_area);
            require_once($area_path);

        }
    } else {
        // получаем массив текстов для текущего раздела и языка
        $lang_text = global_v::print_lang_text_from_files($_cur_area);
        require_once($area_path);
    }
} else {
    // получаем массив текстов для текущего раздела и языка
    $lang_text = global_v::print_lang_text_from_files('404');
    require_once($error_path);
}

/* подключаем файл представления*/
require_once($_SERVER['DOCUMENT_ROOT']."/modules/global_v.php");





/*  код для дебага */

//ash_debug($lang_text);

//ash_debug($no_language_keys,'Не существующие языковые ключи');
/* конец кода дебага */
/*контроль времени загрузки*/control_time::add_to_log("После html",__FILE__,__LINE__,false);
