<?php
/**
 * main_menu_v.functions.php
 *
 * ?
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

/**
 * print_menu_by_class($menu_array,$menu_class = '')
 * @description Формирует список с пунктами меню
 *
 * @var $menu_array array - массив элементов
 * @var $menu_class string - css класс
 * @return string
 * Возвращает строку с сформированным меню
 * для текущего языка
 */  
function print_menu_by_class($menu_array,$menu_class=''){
	global $friendly_url;
    $lang_to_link = $friendly_url->lang_to_link;
	if(!isset($menu_array) || empty($menu_array)) return false;

	// создаем переменную для будущей результирующей строки меню
	$menu_result_string = "<ul class='{$menu_class}'>\n";


    foreach ($menu_array as $item_array){

		// проверяем какой пункт меню активен
        $active = "drv-menu-item";
        if ((strpos($_SERVER['REQUEST_URI'],$item_array['url'])!==false && $item_array['url']!="/")
            || $_SERVER['REQUEST_URI']==$item_array['url']
            || $_SERVER['REQUEST_URI']==$lang_to_link.$item_array['url']){
            $active = "drv-menu-current";
        }

		// формируем ряд значений из массива и языкового файла
		$link = $lang_to_link.(isset($item_array['url']) ? $item_array['url'] : '');
		$lang_label = (isset($item_array['lang_label']) ? lang_text('{'.$item_array['lang_label'].'}') : '');
		$sub_title = (isset($item_array['sub_title']) ? '<span>'.lang_text('{'.$item_array['sub_title'].'}').'</span>' : '');
		
		$menu_result_string .= "<li>";
			$menu_result_string .= "<a href='{$link}' class='{$active}'>{$lang_label} {$sub_title}</a>";
		$menu_result_string .= "</li>";
		
		unset($active, $link, $lang_label, $sub_title);
	}
	
	$menu_result_string .= "</ul>";
	
	return $menu_result_string;
}

function print_menu_from_constants($menu_array, $menu_class='') {
	global $friendly_url;
    $lang_to_link = $friendly_url->lang_to_link;
	if(!isset($menu_array) || empty($menu_array)) return false;

	// создаем переменную для будущей результирующей строки меню
	$menu_result_string = "<ul class='{$menu_class}'>\n";

    foreach ($menu_array as $label => $url){

		// проверяем какой пункт меню активен
        $active = "drv-menu-item";
		if(isset($url) && $url != '') {
	        if ((strpos($_SERVER['REQUEST_URI'],$url)!==false && $url!="/")
	            || $_SERVER['REQUEST_URI']==$url
	            || $_SERVER['REQUEST_URI']==$lang_to_link.$url){
	            $active = "drv-menu-current";
	        }
	
			// формируем ряд значений из массива и языкового файла
            $link = (strpos($url,"http")===false)?$lang_to_link.$url:$url;
			$lang_label = (isset($label) ? $label : '');
			
			$menu_result_string .= "<li>";
				$menu_result_string .= "<a href='{$link}' class='{$active}'>{$lang_label}</a>";
			$menu_result_string .= "</li>";
			
			unset($active, $link, $lang_label);
		}
	}
	
	$menu_result_string .= "</ul>";
	
	return $menu_result_string;
}

function print_auth_menu($menu_array, $menu_class='') {
	global $friendly_url;
    $lang_to_link = $friendly_url->lang_to_link;
	if(!isset($menu_array) || empty($menu_array)) return false;
	// создаем переменную для будущей результирующей строки меню
	$menu_result_string = "<ul class='{$menu_class}'>\n";
	$menu_result_string .= "<li><span class='icon'></span></li>\n";
    foreach ($menu_array as $item_array){

        // проверяем какой пункт меню активен
        $active = "drv-menu-item";
        if ((strpos($_SERVER['REQUEST_URI'],$item_array['url'])!==false && $item_array['url']!="/")
            || $_SERVER['REQUEST_URI']==$item_array['url']
            || $_SERVER['REQUEST_URI']==$lang_to_link.$item_array['url']){
            $active = "drv-menu-current";
        }

        // формируем ряд значений из массива и языкового файла
        $link = $lang_to_link.(isset($item_array['url']) ? $item_array['url'] : '');
        $lang_label = (isset($item_array['anchor']) ? $item_array['anchor']: '');
        $sub_title = (isset($item_array['sub_title']) ? '<span>'.lang_text('{'.$item_array['sub_title'].'}').'</span>' : '');

        $menu_result_string .= "<li>";
        $menu_result_string .= "<a href='{$link}' class='{$active}'>$lang_label </a>";
        $menu_result_string .= "</li>";

        unset($active, $link, $lang_label, $sub_title);
    }

	$menu_result_string .= "</ul>";

	return $menu_result_string;
}