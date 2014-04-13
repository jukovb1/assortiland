<?php
/**
 * content_c.ajax.php (admin)
 *
 * Контроллер ajax запросов контента
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

if (!isset($_POST['action'])){
    $error['result'] = false;
    $error['result_msg'] = "Не указано действие запроса";
    exit(json_encode($error));
} else {
    $action = $_POST['action'];
    if ($action=='status'){
        // изменение статуса (скрыть/показать/удалить)
        $cont_id = $_POST['id'];
        $new_status[$cont_id]['cont_status'] = $_POST['new_status'];
        $old_status = $_POST['old_status'];
        $change_status = content_m::change_content_status($new_status,$old_status);
        if ($change_status['result']){
            if ($old_status == -1) {
                $change_status['result_msg'] = lang_text('{IE_recovery_ok}');
            } elseif ($new_status[$cont_id]['cont_status'] == -1) {
                $change_status['result_msg'] = lang_text('{IE_del_ok}');
            } elseif ($new_status[$cont_id]['cont_status'] == 0) {
                $change_status['result_msg'] = lang_text('{IE_hide_ok}');
            } elseif ($new_status[$cont_id]['cont_status'] == 1) {
                $change_status['result_msg'] = lang_text('{IE_show_ok}');
            }
        } else {
            $change_status['result_msg'] = lang_text($change_status['result_msg']);
        }
        exit(json_encode($change_status));
    } elseif ($action=='check_url'){
        $result = content_m::check_url($_cur_area,$_POST['url'],$_POST['cont_id']);
        if (!$result['result']){
            $result['result_msg'] = lang_text($result['result_msg']);
        }
        exit(json_encode($result));
    }
}