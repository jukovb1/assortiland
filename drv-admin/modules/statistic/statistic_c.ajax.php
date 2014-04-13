<?php
/**
 * statistic_c.ajax.php (admin)
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
require_once('statistic_m.class.php');

if (!isset($_POST['action'])){
    $error['result'] = false;
    $error['result_msg'] = "Не указано действие запроса";
    exit(json_encode($error));
} else {
    $action = $_POST['action'];
    if ($action=='status'){
        $cont_id = $_POST['id'];
        
        $new_status[$cont_id]['order_status'] = $_POST['new_status'];
        if ($_POST['new_status']==3){
            $isset_order = statistic_m::get_order_by_id($cont_id);
            if ($isset_order['result']){
                $order_data = $isset_order['result_data'];
                $user_data_arr = global_m::get_user_data_by_id($order_data['order_owner_user_id']);
                if ($user_data_arr['result']){
                    $user_data = $user_data_arr['result_data'];
                    // отправить продавцу подтверждение оплаты
                    $mail_to = $user_data['user_email'];
                    $mail_subject = lang_text("{order_paid_subject}");
                    $total_cost = $order_data['order_product_price'] * $order_data['order_product_count'];
                    $email_variables = "
                        {:USER_NAME:}={$user_data['user_fullname']}::
                        {:PRODUCT_NAME:}=<b>{$order_data['order_product_title']} <small>({$order_data['order_product_article']})</small></b>::
                        {:SITE_NAME:}=".get_constant($global_constants,'site_name')."::
                        {:PRICE:}={$order_data['order_product_price']}::
                        {:COUNT:}={$order_data['order_product_count']}::
                        {:TOTAL_PRICE:}={$total_cost}";
                    $mail_msg = lang_text("{order_paid_text}::$email_variables");
                    global_v::send_msg_to_email($mail_to,$mail_subject,$mail_msg);

                }
            }

        }
        $new_status[$cont_id]['order_date_updt'] = date("Y-m-d H:i:s");
        $old_status = $_POST['old_status'];
        $change_status = statistic_m::change_statistic_status($new_status);
        $change_status['result_msg'] = lang_text($change_status['result_msg']);
        exit(json_encode($change_status));
    } elseif ($action=='check_url'){
        $result = statistic_m::check_url($_cur_area,$_POST['url'],$_POST['cont_id']);
        if (!$result['result']){
            $result['result_msg'] = lang_text($result['result_msg']);
        }
        exit(json_encode($result));
    }
}