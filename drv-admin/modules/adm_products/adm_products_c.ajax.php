<?php
/**
 * products_c.ajax.php (admin)
 *
 * Контроллер ajax запросов товаров
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
require_once('adm_products_m.class.php');
require_once('adm_products_c.functions.php');

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
        if ($action=='status'){
            // изменение статуса (скрыть/показать/удалить)
            $cont_id = $_POST['id'];
            $old_status = $_POST['old_status'];
            $new_status2[$cont_id]['status'] = $_POST['new_status'];
            if ($_cur_sub_area == 'products-groups'){
                $new_status[$cont_id]['group_status'] = $_POST['new_status'];
                $change_status = adm_products_m::change_products_group_status($new_status);
            } else {
                $new_status[$cont_id]['product_status'] = $_POST['new_status'];
                $old_article = adm_products_m::get_product_article_by_id($cont_id);
                if ($_POST['new_status'] == -1){
                    $new_status[$cont_id]['product_article'] = "$old_article||del_".date("d_m_Y__H_i");
                } elseif($old_status == -1){
                    $old_article_a = explode('||',$old_article);
                    $new_article = $old_article_a[0];
                    $new_status[$cont_id]['product_article'] = $new_article;
                }
                $change_status = adm_products_m::change_products_status($new_status);
            }
            if ($change_status['result']){
                if ($old_status == -1) {
                    $change_status['result_msg'] = lang_text('{IE_recovery_ok}');
                } elseif ($new_status2[$cont_id]['status'] == -1) {
                    $change_status['result_msg'] = lang_text('{IE_del_ok}');
                } elseif ($new_status2[$cont_id]['status'] == 0) {
                    $change_status['result_msg'] = lang_text('{IE_hide_ok}');
                } elseif ($new_status2[$cont_id]['status'] == 1) {
                    $change_status['result_msg'] = lang_text('{IE_show_ok}');
                }
            } else {
                $change_status['result_msg'] = lang_text($change_status['result_msg']);
            }
            exit(json_encode($change_status));
        } elseif ($action=='check_article'){
            $result = adm_products_m::check_article($_POST['article'],$_POST['product_id']);
            if (!$result['result']){
                $result['result_msg'] = lang_text($result['result_msg']);
            }
            exit(json_encode($result));
        } elseif ($action=='check_url'){
            $result = adm_products_m::check_url($_cur_area,$_POST['url'],$_POST['group_id']);
            if (!$result['result']){
                $result['result_msg'] = lang_text($result['result_msg']);
            }
            exit(json_encode($result));
        }
    }
}