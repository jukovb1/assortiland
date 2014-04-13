<?php
/**
 * product_c.ajax.php (front)
 *
 * Контроллер единицы продукции из каталога (ajax)
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

require_once('product_m.class.php');
require_once('product_c.functions.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/profile/profile_m.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/catalog/catalog_m.class.php');

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
    	$invalid_index = false;

		if (!is_null($_cur_sub_area)){
		    // проверяем наличие такого продукта
		    $article_array = explode(',',$_cur_sub_area); // это заглушка на случай, если в других проектах нужно будет сравнение товаров
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
            $product_arr = product_m::get_product_by_article($isset_product);
            $action = $_POST['action'];
            if ($action=='add_dignity') {
                if ($product_arr['result']) {
                    // получаем данные о продукте
                    $product_data = $product_arr['result_data'];

                    $current_product_id = $isset_product[0];
                    $product_dignities = get_product_data(7);
                    if ($auth_class->cur_user_group!=0){
                        $check_like = product_m::check_like($current_product_id);
                        if ($check_like){
                            // уменьшаем кол-во лайков
                            $product_dignities--;
                            $class_db->delete_from_table('users_likes',"like_user_id={$auth_class->cur_user_id} AND like_type=1 AND like_item_id = {$current_product_id}");
                        } else {
                            // увеличиваем количество лайков
                            $product_dignities++;
                            $class_db->insert_array_to_table('users_likes',array("like_user_id"=>$auth_class->cur_user_id,"like_type"=>1,"like_item_id" => $current_product_id));

                        }
                        product_m::update_product_number_and_string_param($current_product_id, 7, $product_dignities, $product_data);
                        $result['result'] = true;
                        $result['result_data'] = $product_dignities;
                    } else {
                        $result['result'] = false;
                        $result['result_msg'] = lang_text('{no_auth}');
                    }
                    exit(json_encode($result));
                }
            }elseif ($action=='add_to_cart') {

				// получаем данные о продукте с необходимыми дополнительными полями

				if ($product_arr['result']){
					$current_product_id = $isset_product[0];
                    if ($auth_class->cur_user_group==0){
                        if (isset($_COOKIE['unique_key'])){
                            $unique_key = $_COOKIE['unique_key'];
                        } else {
                            if (!isset($isset_product)){
                                $isset_product = rand(1,100);
                            }
                            $unique_key = md5(md5($current_product_id).md5(time()).md5(rand(100000,999999)));
                        }
                        $year = 1*365*24*60*60*1000;
                        setcookie('unique_key',$unique_key,$year,'/');

                        $isset_product_in_cart = product_m::check_product_in_guest_cart_by_product_id($unique_key, $current_product_id);

                        // если такой товар найден в корзине
                        // увеличиваем колличество
                        if($isset_product_in_cart['result']) {
                            $products_cart = profile_m::get_products_from_guest_cart($unique_key);
                            $products_cart_count = $products_cart['result_data'][$isset_product_in_cart['result_data']['cart_guest_id']]['cart_guest_product_count'];
                            $products_cart_count++;

                            $product_cart_data = array(
                                'cart_guest_product_count' => $products_cart_count,
                                'cart_guest_date' => date('Y-m-d H:i:s')
                            );
                            $upd = $isset_product_in_cart['result_data']['cart_guest_id'];
                        } else {
                            // если покупаем товар
                            $product_data = $product_arr['result_data'];
                            $product_cart_data = array(
                                'cart_guest_unique_key' => $unique_key,
                                'cart_guest_owner_user_id' => get_product_data('product_user_id'),
                                'cart_guest_product_id' => get_product_data('product_id'),
                                'cart_guest_product_count' => 1,
                                'cart_guest_status' => 1,
                                'cart_guest_date' => date('Y-m-d H:i:s')
                            );
                            $upd = NULL;
                        }
                        $result = product_m::add_product_to_guest_cart($product_cart_data,$upd);
                        $result['result_msg'] = lang_text($result['result_msg']);
                    } else {
                        $isset_product_in_cart = product_m::check_product_in_cart_by_product_id($auth_class->cur_user_id, $current_product_id);
                        // если такой товар найден в корзине
                        // увеличиваем колличество
                        if($isset_product_in_cart['result']) {
                            $products_cart = profile_m::get_products_from_cart($auth_class->cur_user_id);
                            $products_cart_count = $products_cart['result_data'][$isset_product_in_cart['result_data']['cart_id']]['cart_product_count'];
                            $products_cart_count++;

                            $product_cart_data = array(
                                'cart_product_count' => $products_cart_count,
                                'cart_date' => date('Y-m-d H:i:s')
                            );
                            $result = product_m::add_product_to_cart($product_cart_data, $isset_product_in_cart['result_data']['cart_id']);
                            $result['result_msg'] = lang_text($result['result_msg']);
                        } else {
                            // если покупаем товар
                            $product_data = $product_arr['result_data'];
                            $product_cart_data = array(
                                'cart_user_id' => $auth_class->cur_user_id,
                                'cart_owner_user_id' => get_product_data('product_user_id'),
                                'cart_product_id' => get_product_data('product_id'),
                                'cart_product_count' => 1,
                                'cart_status' => 1,
                                'cart_date' => date('Y-m-d H:i:s')
                            );

                            $result = product_m::add_product_to_cart($product_cart_data);
                            $result['result_msg'] = lang_text($result['result_msg']);
                        }
                    }
					exit(json_encode($result));
				}
			}elseif ($action=='add_to_partner') {

				// получаем данные о продукте с необходимыми дополнительными полями

				if ($product_arr['result']){
					$current_product_id = $isset_product[0];

                    $partners_products = NULL;
                    if ($auth_class->cur_user_group==5 && $auth_class->cur_user_status_in_group==1){
                        $partners_products = catalog_m::partner_products($auth_class->cur_user_id);
                    }
                    if (!is_null($partners_products) && isset($partners_products[$current_product_id])){
                        $result['result'] = false;
                        $result['result_msg'] = lang_text("{IE_2x101}");
                    } else {
                        $product_cart_data = array(
                            'p_product_id' => $current_product_id,
                            'p_partner_user_id' => $auth_class->cur_user_id,
                            'p_date_add' => date("Y-m-d H:i"),
                            'p_status' => 1,
                        );
                        $result = product_m::add_product_to_partner_catalog($product_cart_data);
                        $result['result_msg'] = lang_text($result['result_msg']);
                    }
					exit(json_encode($result));
				}
			}elseif ($action=='del_from_partner') {
                $current_product_id = $isset_product[0];
                $partners_products = NULL;
                if ($auth_class->cur_user_group==5 && $auth_class->cur_user_status_in_group==1){
                    $partners_products = catalog_m::partner_products($auth_class->cur_user_id);
                }
                if (!is_null($partners_products) && isset($partners_products[$current_product_id])){
                    $condition = "p_partner_user_id = {$auth_class->cur_user_id} AND p_product_id = $current_product_id";
                    $result = catalog_m::delete_partner_product($condition);
                    $result['result_msg'] = lang_text($result['result_msg']);
                } else {
                    $result['result'] = false;
                    $result['result_msg'] = lang_text("{IE_2x103}");
                }
                exit(json_encode($result));
			}

		}
	}
}