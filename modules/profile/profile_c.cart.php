<?php
/**
 * users_c.groups.php (admin)
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

require_once('profile_m.php');
require_once('profile_v.functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/product/product_m.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/product/product_c.functions.php');

$cart_has_products = false;
$user_delivery_regions = global_m::get_delivery_regions();

// для авторизированного пользователя
if($auth_class->cur_user_id) {
	// получаем продукты из корзины пользователя
	$products_cart = profile_m::get_products_from_cart($auth_class->cur_user_id, 1);
    $profile_v_right = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.cart.php";

	if($products_cart['result']) {
		$cart_products = array();
		$cart_has_products = true;
		
		$cur_user_delivery_region = profile_m::get_user_delivery_region($auth_class->cur_user_id);
		if($cur_user_delivery_region['result']) {
			$cur_user_delivery_region = $cur_user_delivery_region['result_data'];
		} else {
			$cur_user_delivery_region = '';
		}
        foreach ($products_cart['result_data'] as $cart_key => $cart_value) {
            // проверяем существование продукта
            $isset_product = product_m::check_product_by_id(explode(',', $cart_value['cart_product_id']),1);
            if($isset_product) {
                $current_product_id = $isset_product[0];
                // получаем данные о продукте с необходимыми дополнительными полями
                $product_arr = product_m::get_product_by_article($isset_product);

                $product_data = $product_arr['result_data'];
                // артикул товара
                $cart_products[$cart_key]['product_article'] = get_product_data('product_article');
                // название товара
                $cart_products[$cart_key]['product_img'] = get_product_data(9);
                $cart_products[$cart_key]['product_title'] = get_product_data(2);
                // цена товара
                $action_price = get_product_data(4);
                $general_price = get_product_data(5);
                if($action_price > 0) {
                    $cart_products[$cart_key]['product_price'] = $action_price;
                } else {
                    $cart_products[$cart_key]['product_price'] = $general_price;
                }
                // продавец
                $cart_products[$cart_key]['product_owner'] = $cart_value['cart_owner_user_id'];
				$cart_products[$cart_key]['product_owner_data'] = product_m::get_user_data_by_id($cart_value['cart_owner_user_id']);
                // кол-во
                $cart_products[$cart_key]['product_count'] = $cart_value['cart_product_count'];
                // итого
                $cart_products[$cart_key]['product_total'] = $cart_value['cart_product_count'] * $cart_products[$cart_key]['product_price'];
                $cart_products[$cart_key]['product_percents'] = get_product_data(11);
                $cart_products[$cart_key]['product_delivery'] = get_product_data(17);
                $cart_products[$cart_key]['product_delivery_long'] = get_product_data("17|long");

            }
        }

        if (!empty($_POST) && isset($_POST['order'])){

            $fields_set = $user_fields_data['for_cart'];

            $profile_v_right = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.cart_order.php";
            foreach ($cart_products as $cart_key => $cart_value) {
                if (!isset($cart_value['product_delivery'])
                    || !is_array($cart_value['product_delivery'])
                    || count($cart_value['product_delivery'])==0){
                    // удаление из корзины товара у которого ошибка доставки
                    product_m::delete_product_from_cart($cart_key);
                    // отправка сообщений об ошибке
                    // письмо продавцу
                    $seller_id = $cart_value['product_owner']; // id продавца
                    $seller_data_arr = global_m::get_user_data_by_id($seller_id);
                    $seller_data = $seller_data_arr['result_data']; // использовать user_email и user_fullname
                    $mail_to = $seller_data['user_email'];
                    $mail_subject = lang_text('{order_delivery_error_email_subject}');
                    $mail_button = global_v::create_button_for_email_msg("http://{$_SERVER['SERVER_NAME']}/profile/seller/edit/{$cart_value['product_article']}/",lang_text('{email_action_edit_product}'));
                    $email_variables = "
                        {:USER_NAME:}={$seller_data['user_fullname']}::
                        {:PRODUCT_NAME:}=<b>{$cart_value['product_title']} <small>({$cart_value['product_article']})</small></b>::
                        {:SITE_NAME:}=".get_constant($global_constants,'site_name')."::
                        {:BUTTON:}=$mail_button";
                    $mail_msg = lang_text("{order_delivery_error_email_text_seller}::$email_variables");
                    global_v::send_msg_to_email($mail_to,$mail_subject,$mail_msg);
                    // письмо администратору
                    if (get_constant($global_constants,'email_support_order_error')==1){
                        $mail_to = get_constant($global_constants,'email_support');
                        $email_variables = "{:PRODUCT_NAME:}=<b>{$cart_value['product_title']} <small>({$cart_value['product_article']})</small></b>";
                        $mail_msg = lang_text("{order_delivery_error_email_text_admin}::$email_variables");
                        global_v::send_msg_to_email($mail_to,$mail_subject,$mail_msg);
                    }
                }
            }
        }
        if (!empty($_POST) && isset($_POST['order_finish'])){

            $fields_set = $user_fields_data['for_cart'];
            $tmp_post = $_POST;
			
            unset($_POST['cart_data']);
            unset($_POST['delivery']);
            unset($_POST['delivery_info']);
			unset($_POST['delivery_region']);
            unset($_POST['order_finish']);
            $order_array = array();
            foreach ($cart_products as $cart_key => $cart_value) {
                unset($cart_value['product_delivery']);
                unset($cart_value['product_delivery_long']);
                $order_array[$cart_key] = $cart_value;
                $order_array[$cart_key]['cart_key'] = $cart_key;
                $order_array[$cart_key]['product_partner'] = 0; // ash-1 передавать id партнёра, если есть
                $order_array[$cart_key]['product_delivery'] = $tmp_post['delivery'][$cart_key];
                $order_array[$cart_key]['product_delivery_info'] = $tmp_post['delivery_info'][$cart_key];
				$order_array[$cart_key]['product_delivery_region'] = $tmp_post['delivery_region'][$cart_key];
                $order_array[$cart_key]['buyer_info'] = $_POST;
                $order_array[$cart_key]['buyer_info']['user_id'] = $auth_class->cur_user_id;
                // генерируем индекс заказа (дата и время - id покупателя - id продавца - id партнёра - артикл товара  )
                $order_index = time()."-".$auth_class->cur_user_id."-".$order_array[$cart_key]['product_owner']."-".$order_array[$cart_key]['product_partner']."-".$order_array[$cart_key]['product_article'];
                $order_array[$cart_key]['order_index'] = $order_index;


                // письмо-запрос продавцу
                $seller_id = $cart_value['product_owner']; // id продавца
                $seller_data_arr = global_m::get_user_data_by_id($seller_id);
                $seller_data = $seller_data_arr['result_data']; // использовать user_email и user_fullname
                $mail_to = $seller_data['user_email'];
                $mail_subject = lang_text('{order_confirm_isset_product_subject}');
                $mail_button_1 = global_v::create_button_for_email_msg("http://{$_SERVER['SERVER_NAME']}/profile/seller/confirm={$cart_value['product_article']},$order_index,true/",lang_text('{email_action_isset_product}'));
                $mail_button_2 = global_v::create_button_for_email_msg("http://{$_SERVER['SERVER_NAME']}/profile/seller/confirm={$cart_value['product_article']},$order_index,false/",lang_text('{email_action_isset_product_no}'));
                $email_variables = "
                    {:USER_NAME:}={$seller_data['user_fullname']}::
                    {:PRODUCT_NAME:}=<b>{$cart_value['product_title']} <small>({$cart_value['product_article']})</small></b>::
                    {:SITE_NAME:}=".get_constant($global_constants,'site_name')."::
                    {:COUNT:}={$order_array[$cart_key]['product_count']}::
                    {:BUTTON_1:}=$mail_button_1::
                    {:BUTTON_2:}=$mail_button_2";
                $mail_msg = lang_text("{order_confirm_isset_product_text}::$email_variables");
                global_v::send_msg_to_email($mail_to,$mail_subject,$mail_msg);

                // письмо покупателю
                $mail_to = $auth_class->cur_user_email;
                $mail_subject = lang_text("{order_product_subject}::{:NUMBER:}=$order_index");
                $total_cost = $order_array[$cart_key]['product_price'] * $order_array[$cart_key]['product_count'];
                $email_variables = "
                    {:USER_NAME:}={$auth_class->cur_user_name}::
                    {:PRODUCT_NAME:}=<b>{$cart_value['product_title']} <small>({$cart_value['product_article']})</small></b>::
                    {:SITE_NAME:}=".get_constant($global_constants,'site_name')."::
                    {:COUNT:}={$order_array[$cart_key]['product_count']}::
                    {:TOTAL_PRICE:}={$total_cost}::
                    {:NUMBER:}=$order_index";
                $mail_msg = lang_text("{order_product_text}::$email_variables");
                global_v::send_msg_to_email($mail_to,$mail_subject,$mail_msg);
            }

            $prep_order_arr = profile_c::prep_array_for_order_table($order_array);
            $add_order = profile_m::add_order($prep_order_arr);

            if ($add_order['result']){
                foreach($order_array as $cart_key=>$tmp){
                    product_m::delete_product_from_cart($cart_key);
                }
                $msg_color_for_user = 'msg_ok';
                $add_msg_user = (isset($_COOKIE['msg_for_user']))?$_COOKIE['msg_for_user']."<br>":NULL;
                setcookie('msg_for_user',$add_msg_user.lang_text($add_order['result_msg']),time()+60,'/');
                $new_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: $new_url");
            }

            $profile_v_right = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.cart.php";

        }

    }
} else { // для гостя
    $profile_v_right = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.cart.php";

    if (isset($_COOKIE['unique_key'])){
        $unique_key = $_COOKIE['unique_key'];
    } else {
        $unique_key = md5(md5(rand(1,1000)).md5(time()).md5(rand(100000,999999)));
    }
    $year = 1*365*24*60*60*1000;
    setcookie('unique_key',$unique_key,$year,'/');

    $products_cart = profile_m::get_products_from_guest_cart($unique_key);
    
    $cart_has_products = false;
    if ($products_cart['result']){


        $cart_has_products = true;
        foreach ($products_cart['result_data'] as $cart_key => $cart_value) {
            // проверяем существование продукта
            $isset_product = product_m::check_product_by_id(explode(',', $cart_value['cart_guest_product_id']),1);
            if($isset_product) {
                $current_product_id = current($isset_product);
                // получаем данные о продукте с необходимыми дополнительными полями
                $product_arr = product_m::get_product_by_article($isset_product);

                $product_data = $product_arr['result_data'];
                // артикул товара
                $cart_products[$cart_key]['product_article'] = get_product_data('product_article');
                // название товара
                $cart_products[$cart_key]['product_title'] = get_product_data(2);
                // цена товара
                $action_price = get_product_data(4);
                $general_price = get_product_data(5);
                if($action_price > 0) {
                    $cart_products[$cart_key]['product_price'] = $action_price;
                } else {
                    $cart_products[$cart_key]['product_price'] = $general_price;
                }
                // продавец
                $cart_products[$cart_key]['product_owner'] = $cart_value['cart_guest_owner_user_id'];
                // кол-во
                $cart_products[$cart_key]['product_count'] = $cart_value['cart_guest_product_count'];
                // итого
                $cart_products[$cart_key]['product_total'] = $cart_value['cart_guest_product_count'] * $cart_products[$cart_key]['product_price'];
                $cart_products[$cart_key]['product_percents'] = get_product_data(11);
                $cart_products[$cart_key]['product_delivery'] = get_product_data(17);
                $cart_products[$cart_key]['product_delivery_long'] = get_product_data("17|long");
            }
        }
        if (!empty($_POST) && isset($_POST['order'])){
            // переадресация на регистрацию
            $new_url = "http://{$_SERVER['HTTP_HOST']}/profile/auth/registration";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: $new_url");
        }

    }
}

