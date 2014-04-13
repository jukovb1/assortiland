<?php
/**
 * statistic_c.php (admin)
 *
 * Контроллер контента
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


require_once('statistic_m.class.php');
require_once('statistic_c.class.php');
require_once('statistic_m.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/'.$admin_folder.'/modules/system/main_menu/main_menu_m.php');

// создаём список необходимых JS файлов
$js_for_module = array(
    'anythingslider','cleditor',
    'migrate',
    'dropdown','my'=>array('checkbox','select'),
    'admin'=>array($_cur_area),
);
$local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);

// указываем тип по-умолчанию
$default_type = 'statistic-1'; // Ожидают подтверждения
$invalid_index = $is_order = false;
// ash-1 написать аннулирование ожидающих больше суток

$statistic_types = $main_menu[$_cur_area]['sub_menu'];


if (!is_null($_cur_area_sub) && $_cur_area_sub!='order_input'){
    if (isset($statistic_types[$_cur_area_sub])){
        $current_statistic_type = $_cur_area_sub;
    } else {
        // поиск заказа по индексу
        $isset_order = statistic_m::get_order_by_index($_cur_area_sub);
        if ($isset_order['result']){
            $statistic_data = $isset_order['result_data'];
            $is_order = true;
        } else {
            $current_statistic_type = $default_type;
            $invalid_index = true;
        }
    }
} else {
    $current_statistic_type = $default_type;
}

if ($invalid_index){
    $lang_text = global_v::print_lang_text_from_files('404','admin');
    require_once($error_path);
} else {
    $statuses[0] = 'red';
    $statuses[1] = 'gray';
    $statuses[2] = 'black';
    $statuses[3] = 'blue';
    $statuses[4] = 'green';

    if ($is_order){

        $statistic_v = $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.order.php";
        // собираем массив для включения в global_v
        $global_template = array(
            'for_title'      => true,
            'for_title_text' => lang_text("{module_name}"). " " .$statistic_data['order_index'],
            'for_head'       => (file_exists($dop_head))?$dop_head:NULL,
            'for_content'    => $statistic_v,
        );
    } else {
        $current_type = explode("-",$current_statistic_type);
        $current_status = intval($current_type[1]);


        // определяемся показывать или нет вкладки для языков
        $show_lang_tabs_for_mod = false;
        if (count($langs_data['by_id'])>1) {
            $show_lang_tabs_for_mod = true;
        }
        $show_lang_tabs_for_mod = false;

        $count_items = statistic_m::count_statistic_by_types($current_status);
        $page_nav  = page_navigation::get_page_by_num_for_adm($count_items,NULL,$num_of_rows_per_page);
        $statistic_by_group = statistic_m::get_statistic_by_types($current_status,$page_nav['nav_start_position'],$page_nav['nav_limit']);

        $statistic_v = $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.list.php";

        // собираем массив для включения в global_v
        $global_template = array(
            'for_title'      => true,
            'for_title_text' => lang_text("{module_name}"). " " .lang_text("{{$current_statistic_type}}"),
            'for_head'       => (file_exists($dop_head))?$dop_head:NULL,
            'for_content'    => $statistic_v,
        );
    }
}
