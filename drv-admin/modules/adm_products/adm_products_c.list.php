<?php
/**
 * products_c.list.php (admin)
 *
 * Контроллер категорий продукции
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


if (isset($_GET['id'])){
    $multiple_checkbox = new multiple_checkbox();
    $group_arr = adm_products_m::get_products_groups();
    $group_list_for_product = adm_products_m::get_list_products_group_for_product(intval($_GET['id']));
    $group_list_for_product = (!empty($group_list_for_product))?$group_list_for_product:array(intval($_GET['id'])=>array());

    $action_for_content = 'edit';
    if ($_GET['id']=='add'){
        $action_for_content = 'add';
        $content_by_id_data = adm_products_m::get_products_by_id();
        $content_by_id_data['result_data']['products'][0]['product_user_id'] = $user_id;
        $content_by_id_data['result_data']['products'][0]['product_date'] = date("Y-m-d H:i");

    } else {
        //        $content_ids = explode(',',$_GET['id']);
        //        foreach($content_ids as $d_id){
        //            $content_id[] = intval($d_id);
        //        }
        $content_id = intval($_GET['id']);
        $content_by_id_data = adm_products_m::get_products_by_id($content_id);
    }

    if(!empty($_POST)) {
        $post_group_list_for_product = (isset($_POST['select_products_groups']))?$_POST['select_products_groups']:array();
        unset($_POST['select_products_groups']);
        $group_list_for_product[intval($_GET['id'])] = array_flip($post_group_list_for_product);

        $prep_post_data = adm_products_c::product_data_save_prepare($_POST,$_FILES);
        if (!$prep_post_data['result']){
            $msg_color_for_user = 'msg_err';
            $msg_for_user = lang_text($prep_post_data['result_msg']);
            $content_by_id_data['result'] = true;
            $content_by_id_data['result_msg'] = 'error';
            $content_by_id_data['result_data'] = $prep_post_data['result_data'];
        } else {

            $save_result = adm_products_m::product_save($prep_post_data['result_data']);
            if ($save_result['result']) {
                $save_group_data = adm_products_m::save_groups_data_for_product($post_group_list_for_product,$save_result['return_product']);
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

    $content_v = $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.product_edit.php";
} else {
    $content_v = $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/$_cur_area/{$_cur_area}_v.products_list.php";
    $dop_fields_for_table_list = adm_products_m::get_list_params_by_group(1);
    $count_items = adm_products_m::count_products();
    $page_nav  = page_navigation::get_page_by_num_for_adm($count_items,'товаров',$num_of_rows_per_page);
    $content_by_group = adm_products_m::get_products_list($dop_fields_for_table_list,$page_nav['nav_start_position'],$page_nav['nav_limit']);
}




