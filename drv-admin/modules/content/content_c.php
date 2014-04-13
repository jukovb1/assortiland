<?php
/**
 * content_c.php (admin)
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


require_once('content_m.class.php');
require_once('content_c.class.php');
require_once('content_m.php');

// создаём список необходимых JS файлов
$js_for_module = array(
    'redactor',
    'anythingslider','cleditor',
    'migrate',
    'dropdown','my'=>array('checkbox','select'),
    'admin'=>array($_cur_area),
);
$local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);

// указываем тип по-умолчанию
$default_type = 'content-pages'; // Глобальные
$invalid_index = false;


$content_types = content_m::get_content_types();


if (!is_null($_cur_area_sub)){
    if (isset($content_types[$_cur_area_sub])){
        $current_content_type = $_cur_area_sub;
    } else {
        $current_content_type = $default_type;
        $invalid_index = true;
    }
} else {
    $current_content_type = $default_type;
}

if ($invalid_index){
    $lang_text = global_v::print_lang_text_from_files('404','admin');
    require_once($error_path);
} else {
    $current_type = $content_types[$current_content_type];
    $type_for_db = $current_type['type_id'];

    // определяемся показывать или нет вкладки для языков
    $show_lang_tabs_for_mod = false;
    if (count($langs_data['by_id'])>1) {
        $show_lang_tabs_for_mod = true;
    }


    if (isset($_GET['id'])){
        $action_for_content = 'edit';
        if ($_GET['id']=='add'){
            $action_for_content = 'add';
            $content_by_id_data['result'] = true;
            $content_by_id_data['result_msg'] = 'add';
            $content_by_id_data['result_data'] = $current_type['type_main_field'];
            $content_by_id_data['result_data']['cont_id'] = 'new';
            $content_by_id_data['result_data']['cont_type'] = $current_type['type_id'];
            $content_by_id_data['result_data']['cont_url'] = '';
            $content_by_id_data['result_data']['cont_date'] = date("Y-m-d H:i");
            $content_by_id_data['result_data']['cont_sort'] = 0;
            $content_by_id_data['result_data']['cont_show_slider'] = 0;
            $content_by_id_data['result_data']['cont_menu_item'] = 0;
            $content_by_id_data['result_data']['cont_views'] = 0;
            $content_by_id_data['result_data']['cont_user_id'] = 1; // todo ash-9 сделать id текущего админа

        } else {
            $content_id = intval($_GET['id']);
            $content_by_id_data = content_m::get_content_by_id($content_id);
        }

        if(!empty($_POST)) {
            $prep_post_data = content_c::content_save_prepare($_POST,$_FILES);

            if (!$prep_post_data['result']){
                $msg_color_for_user = 'msg_err';
                $msg_for_user = lang_text($prep_post_data['result_msg']);
                $content_by_id_data['result'] = true;
                $content_by_id_data['result_msg'] = 'error';
                $content_by_id_data['result_data'] = $_POST;
            } else {
                $save_result = content_m::update_content($prep_post_data['result_data']);
                if ($save_result['result']) {
                    $msg_color_for_user = 'msg_ok';
                    setcookie('msg_for_user',lang_text($save_result['result_msg']),time()+60,'/');
                    $url = parse_url($_SERVER['REQUEST_URI']);
                    $new_url = "http://{$_SERVER['HTTP_HOST']}{$url['path']}";
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: $new_url");
                } else{
                    $msg_color_for_user = 'msg_err';
                }
                $msg_for_user = lang_text($save_result['result_msg']);
            }
        }



        $content_v = $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.edit.php";
    } else {
        $content_v = $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.list.php";
    }

    $count_items = content_m::count_content_by_types($current_type);
    $page_nav  = page_navigation::get_page_by_num_for_adm($count_items,NULL,$num_of_rows_per_page);
    $content_by_group = content_m::get_content_by_types($current_type,$page_nav['nav_start_position'],$page_nav['nav_limit']);
    // собираем массив для включения в global_v
    $global_template = array(
        'for_title'      => true,
        'for_title_text' => $current_type['type_title'],
        'for_head'       => (file_exists($dop_head))?$dop_head:NULL,
        'for_content'    => $content_v,
    );
}
