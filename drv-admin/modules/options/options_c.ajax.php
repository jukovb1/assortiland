<?php
/**
 * options_c.ajax.php (admin)
 *
 * Контроллер ajax запросов опций
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

if ($GLOBALS["is_local_start"]) {
	$root_path = '';
} else {
	$root_path = $_SERVER['DOCUMENT_ROOT'];
}
require_once('options_m.php');
require_once('options_m.class.php');

if (!isset($_POST['action'])){
    $error['result'] = false;
    $error['result_msg'] = "Не указано действие запроса";
    exit(json_encode($error));
} else {
    if (is_null($_cur_sub_area)){
        $error['result'] = false;
        $error['result_msg'] = "Не указана подобласть запроса";
        exit(json_encode($error));
    } else {
        $action = $_POST['action'];
        if ($action=='get_lang_file_data'){
        	$result['result'] = true;
        	$result['result_data'] = global_v::print_lang_text_from_files($_cur_area,'admin');
			exit(json_encode($result));
        } elseif ($action=='get_delivery_data'){
            // запрос списка доставки
            require_once($_SERVER['DOCUMENT_ROOT'].'/'.$admin_folder.'/modules/adm_products/adm_products_m.class.php');
            $param = 17;
            $result['result'] = true;
        	$result['result_data'] = adm_products_m::get_options_by_param($param);
			exit(json_encode($result));
        } elseif ($action=='delete_delivery'){
            // удаление доставки из списка
            require_once($_SERVER['DOCUMENT_ROOT'].'/'.$admin_folder.'/modules/adm_products/adm_products_m.class.php');
            $param = 17;
            $option_id = intval($_POST['id']);
            $confirm = $_POST['is_confirm'];
            $use_option = adm_products_m::check_use_option($param,$option_id);

            if ($use_option && $confirm=='false') { // тут boolean должен быть кавычках
                $result['result'] = 'confirm';
                $result['result_msg'] = lang_text("{confirm_delete_use_delivery}");
            } else {
                adm_products_m::del_option($param,$option_id);
                $result['result'] = true;
                $result['result_msg'] = lang_text("{delivery_del_successful}");
            }
            exit(json_encode($result));
        } else if ($action=='get_content_and_sliders_data'){
        	require_once($_SERVER['DOCUMENT_ROOT'].'/'.$admin_folder.'/modules/content/content_m.class.php');
			
			$result['result'] = true;
			$result['result_data']['content'] = $result['result_data']['slides'] = array();
			
			// получаем контент у которого предусмотрен слайдер
			$content_with_active_sliders = content_m::get_content_with_active_sliders($dop_pages);
			if($content_with_active_sliders['result']) {
				$result['result_data']['content'] = array_unique($content_with_active_sliders['result_data']);
			}
			// получаем список слайдов
			$constants_slides = options_m::get_constants_data_for_adm(8);
			foreach ($constants_slides['site_slides']['const_value'] as $key => $constants_slide) {
				$slides = explode(';', $constants_slide);
				foreach ($slides as $value) {
					if(is_numeric($key)) $result['result_data']['slides'][$key][] = $value;	
				}
			}
			exit(json_encode($result));
        }
    }
}