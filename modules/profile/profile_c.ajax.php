<?php
/**
 * profile_c.ajax.php (front)
 *
 * Контроллер профиля (ajax)
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

require_once('profile_m.php');
require_once('profile_m.class.php');
require_once('profile_c.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/product/product_m.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/product/product_c.functions.php');

if (!isset($_POST['action'])){
    $error['result'] = false;
    $error['result_msg'] = "Не указано действие запроса";
    exit(json_encode($error));
} else {
    if (is_null($_cur_sub_area)) {
        $error['result'] = false;
        $error['result_msg'] = "Не указана подобласть запроса";
        exit(json_encode($error));
    } else {
        // выбранное действие
        $action = $_POST['action'];
        $invalid_index = false;

        if($_cur_sub_area=='public_offer' && $action=='get_public_offer'){
            $offers_const = global_m::get_constants_data(11);
            $result['result'] = true;
            $result['result_msg'] = $offers_const['reg_page_assignments_public_offer'];
            exit(json_encode($result));
        } else if($_cur_sub_area=='change_subscribe_status') {
        	$status = profile_m::check_subscriber($auth_class->cur_user_id);
            $sbscrb_status = ($status['result_data'])?0:1;
            $upd = false;
			if($status['result']) {
                $upd = true;
			}
            $sbscr_array = array(
                'subscr_user_id'	=> $auth_class->cur_user_id,
                'subscr_status' 	=> $sbscrb_status,
                'subscr_date_add'	=> date('Y-m-d H:i:s')
            );
			$result = profile_m::update_subscribe_status($sbscr_array,$upd);
            $result['result_msg'] = lang_text($result['result_msg']);
			exit(json_encode($result));
        }

        // проверяем указанный товар
        if (!is_null($_cur_sub_area)){
            // проверяем наличие такого продукта
            $article_array = explode(',',$_cur_sub_area);
            $isset_product = product_m::check_product_by_article($article_array,1);
            if (!$isset_product){
                $invalid_index = true;
            }
        }

        if ($invalid_index){
            $error['result'] = false;
            $error['result_msg'] = "Не найден такой продукт";
            exit(json_encode($error));
        } else {
            // выбранное действие
            $action = $_POST['action'];
            // получаем данные о продукте с необходимыми дополнительными полями
            $product_arr = product_m::get_product_by_article($isset_product);

            if ($product_arr['result']){
                $current_product_id = $isset_product[0];
                // получаем данные о продукте
                $product_data = $product_arr['result_data'];

                // если удаляем товар
                if ($action=='delete_product_from_cart') {
                    $result = product_m::delete_product_from_cart(intval($_POST['cart_id']));
                    $result['result_msg'] = lang_text($result['result_msg']);
                    exit(json_encode($result));
                } elseif ($action=='change_product_state') {
                    $product_status = get_product_data('product_status')==1?0:1;
                    $product_seller_data = array(
                        'product_status' => $product_status,
                        'product_date' => date('Y-m-d H:i:s')
                    );

                    $result = product_m::update_product_for_seller($product_seller_data, get_product_data('product_id'));
                    $result['result_msg'] = lang_text($result['result_msg']);
                    $result['result_status'] = $product_status?lang_text("{seller_hide_position}"):lang_text("{seller_show_position}");
                    exit(json_encode($result));
                } elseif ($action=='delete_product_from_sellers_list') {
                    $product_seller_data = array(
                        'product_status' => '-1',
                        'product_date' => date('Y-m-d H:i:s')
                    );

                    $result = product_m::update_product_for_seller($product_seller_data, get_product_data('product_id'));
                    $result['result_msg'] = lang_text($result['result_msg']);
                    exit(json_encode($result));
                } elseif ($action=='update_product_count') {
                    if ($auth_class->cur_user_group==0){
                        if (isset($_COOKIE['unique_key'])){
                            $unique_key = $_COOKIE['unique_key'];
                        } else {
                            $unique_key = md5(md5(rand(1,1000)).md5(time()).md5(rand(100000,999999)));
                        }
                        $year = 1*365*24*60*60*1000;
                        setcookie('unique_key',$unique_key,$year,'/');

                        // новое количество продуктов
                        $products_cart_count = isset($_POST['products_cart_count'])?$_POST['products_cart_count']:0;
                        $isset_product_in_cart = product_m::check_product_in_guest_cart_by_product_id($unique_key, $current_product_id);

                        if($products_cart_count > 0) {
                            $product_cart_data = array(
                                'cart_guest_product_count' => $products_cart_count,
                                'cart_guest_date' => date('Y-m-d H:i:s')
                            );
                            $result = product_m::add_product_to_guest_cart($product_cart_data, $isset_product_in_cart['result_data']['cart_guest_id']);
                            $result['result_msg'] = lang_text($result['result_msg']);
                            exit(json_encode($result));
                        }
                    } else {
                        // новое количество продуктов
                        $products_cart_count = isset($_POST['products_cart_count'])?$_POST['products_cart_count']:0;
                        $isset_product_in_cart = product_m::check_product_in_cart_by_product_id($auth_class->cur_user_id, $current_product_id);

                        if($products_cart_count > 0) {
                            $product_cart_data = array(
                                'cart_product_count' => $products_cart_count,
                                'cart_date' => date('Y-m-d H:i:s')
                            );
                            $result = product_m::add_product_to_cart($product_cart_data, $isset_product_in_cart['result_data']['cart_id']);
                            $result['result_msg'] = lang_text($result['result_msg']);
                            exit(json_encode($result));
                        }

                    }
                }
            }
        }
    }
}