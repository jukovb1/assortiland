<?php
/**
 * profile_c.seller.php (front)
 *
 * Контроллер для отображения страниц товаров для профиля 
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
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/catalog/catalog_m.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/product/product_m.class.php');


$error_info_page = $can_read_info = false;
$num_of_rows_per_page_seller = 3;

if(isset($user_data['result_data']['user_default_group'])
    && isset($info_pages[$user_data['result_data']['user_default_group']])) {
	$can_read_info = true;
}

if(($auth_class->cur_user_group==1
    || $auth_class->cur_user_group==2
    || $auth_class->cur_user_group==4
    ) && $can_read_info) {
    // подтверждение наличия товара
    if (isset($friendly_url->url_command['confirm'])){
        $confirm_data = explode(',',$friendly_url->url_command['confirm']);
        $confirm_product = $confirm_data[0];
        $confirm_order_index = (isset($confirm_data[1]))?$confirm_data[1]:"empty";
        $confirm_action = (isset($confirm_data[2]))?$confirm_data[2]:'false';

        $new_status = ($confirm_action=='true')?2:0;

        $product_seller_data = array(
            'product_status' => 1,
            'product_date' => date('Y-m-d H:i:s')
        );
        if ($new_status==0){
            $product_seller_data = array(
                'product_status' => 0,
                'product_date' => date('Y-m-d H:i:s')
            );

        }
        $product_id = product_m::check_product_by_article(array($confirm_product),1);
        product_m::update_product_for_seller($product_seller_data, current($product_id));

        $res_upd = profile_m::check_order_by_index_and_change_status($confirm_order_index,$confirm_product,$auth_class->cur_user_id,$new_status);

        $msg_color_for_user = 'msg_err';
        if ($res_upd['result']){
            $user_data_arr = global_m::get_user_data_by_id($res_upd['result_data']['order_user_id']);
            if ($user_data_arr['result']){
                $user_data = $user_data_arr['result_data'];
                $msg_color_for_user = 'msg_ok';

                // письмо покупателю статус отменён
                $mail_to = $user_data['user_email'];
                $mail_subject = lang_text("{confirm_order_product_subject_{$confirm_action}}::{:NUMBER:}=$confirm_order_index");
                $total_cost = $res_upd['result_data']['order_product_price'] * $res_upd['result_data']['order_product_count'];
                $email_variables = "
                    {:USER_NAME:}={$user_data['user_fullname']}::
                    {:PRODUCT_NAME:}=<b>{$res_upd['result_data']['order_product_title']} <small>({$res_upd['result_data']['order_product_article']})</small></b>::
                    {:SITE_NAME:}=".get_constant($global_constants,'site_name')."::
                    {:PRICE:}={$res_upd['result_data']['order_product_price']}::
                    {:COUNT:}={$res_upd['result_data']['order_product_count']}::
                    {:TOTAL_PRICE:}={$total_cost}::
                    {:REQUISITES_OF_BANK:}=".nl2br(get_constant($commercial_const,'site_commerce_bank_requisites'))."::
                    {:NUMBER:}={$confirm_order_index}";
                $mail_msg = lang_text("{confirm_order_product_text_{$confirm_action}}::$email_variables");
                global_v::send_msg_to_email($mail_to,$mail_subject,$mail_msg);
            }


        }

        $add_msg_user = (isset($_COOKIE['msg_for_user']))?$_COOKIE['msg_for_user']."<br>":NULL;
        setcookie('msg_for_user_color',$msg_color_for_user,time()+60,'/');
        setcookie('msg_for_user',$add_msg_user.lang_text($res_upd['result_msg']),time()+60,'/');
        $new_url = "http://{$_SERVER['HTTP_HOST']}/profile";
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $new_url");
    } elseif (isset($friendly_url->url_command['edit']) || isset($friendly_url->url_command['add'])){
        $action_for_content = 'add';
        $multiple_checkbox = new multiple_checkbox();
        $group_arr = product_m::get_products_groups();

        if (isset($friendly_url->url_command['edit'])){
            $action_for_content = 'edit';
            $product_data = product_m::check_product_by_article_and_user(array(trim($friendly_url->url_command['edit'])));
            if (empty($product_data)){
                $msg_color_for_user = 'msg_err';
                $add_msg_user = (isset($_COOKIE['msg_for_user']))?$_COOKIE['msg_for_user']."<br>":NULL;
                setcookie('msg_for_user_color',$msg_color_for_user,time()+60,'/');
                setcookie('msg_for_user',$add_msg_user.lang_text("{action_denied}"),time()+60,'/');
                $new_url = "http://{$_SERVER['HTTP_HOST']}/profile/seller";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: $new_url");
            }

            $content_id = current($product_data);
            $content_by_id_data = product_m::get_product_by_article($content_id);

        } else {
            $content_id = 0;
            $content_by_id_data = product_m::get_product_by_article();
            $content_by_id_data['result_data']['products'][0]['product_id']=0;
            $content_by_id_data['result_data']['products'][0]['specs'][0]=0;
            $content_by_id_data['result_data']['specs'][0] = array();
        }
        $group_list_for_product = product_m::get_list_products_group_for_product($content_id);
        $group_list_for_product = (!empty($group_list_for_product))?$group_list_for_product:array($content_id=>array());

        if(!empty($_POST)) {
            $post_group_list_for_product = (isset($_POST['select_products_groups']))?$_POST['select_products_groups']:array();
            unset($_POST['select_products_groups']);
            $group_list_for_product[$content_id] = array_flip($post_group_list_for_product);

            $prep_post_data = profile_c::product_data_save_prepare($_POST,$_FILES);
            if (!$prep_post_data['result']){
                $msg_color_for_user = 'msg_err';
                $msg_for_user = lang_text($prep_post_data['result_msg']);
                $content_by_id_data['result'] = true;
                $content_by_id_data['result_msg'] = 'error';
                $content_by_id_data['result_data'] = $prep_post_data['result_data'];
            } else {

                $save_result = product_m::product_save($prep_post_data['result_data']);
                if ($save_result['result']) {
                    $save_group_data = product_m::save_groups_data_for_product($post_group_list_for_product,$save_result['return_product']);

                    $msg_color_for_user = 'msg_ok';

                    $add_msg_user = (isset($_COOKIE['msg_for_user']))?$_COOKIE['msg_for_user']."<br>":NULL;
                    setcookie('msg_for_user_color',$msg_color_for_user,time()+60,'/');
                    setcookie('msg_for_user',$add_msg_user.lang_text($save_result['result_msg']),time()+60,'/');
                    $url = parse_url($_SERVER['REQUEST_URI']);
                    $new_url = "http://{$_SERVER['HTTP_HOST']}/profile/seller";
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: $new_url");
                } else{
                    $msg_color_for_user = 'msg_err';
                }
                $msg_for_user = lang_text($save_result['result_msg']);
            }
        }
        $new_url = "http://{$_SERVER['HTTP_HOST']}/profile/seller";
        $profile_v_right = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.seller_edit.php";
    } else {
        $dop_special_condition_for_product_list = NULL;
        $resort_products = false;
        $group_id_for_list = 0;

        $params_for_product_list = catalog_m::get_list_params_by_group(3);
        $count_products_ids = catalog_m::get_products_count_by_user_id($auth_class->cur_user_id);
        $page_nav  = page_navigation::get_page_by_num_for_front($count_products_ids,$num_of_rows_per_page_seller);

        $products_list = catalog_m::get_products_list_by_user_id($auth_class->cur_user_id, $params_for_product_list,$page_nav['nav_start_position'],$page_nav['nav_limit'],$dop_special_condition_for_product_list,$resort_products);

        if($products_list == false) {
            $info_page_content['result'] = $error_info_page = true;
            $info_page_content['result_msg'] = lang_text('{IE_1x105}');
        }

        $add_url = "http://{$_SERVER['HTTP_HOST']}/profile/seller/add";
        $edit_url = "http://{$_SERVER['HTTP_HOST']}/profile/seller/edit=";
		$product_url = "http://{$_SERVER['HTTP_HOST']}/product/";
        $profile_v_right = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.seller.php";
    }
	
} else {
    if ($auth_class->cur_user_group>0){
        $msg_color_for_user = 'msg_err';
        $add_msg_user = (isset($_COOKIE['msg_for_user']))?$_COOKIE['msg_for_user']."<br>":NULL;
        setcookie('msg_for_user_color',$msg_color_for_user,time()+60,'/');
        setcookie('msg_for_user',$add_msg_user.lang_text("{action_denied}"),time()+60,'/');
        $new_url = "http://{$_SERVER['HTTP_HOST']}/profile";
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $new_url");
    } else {
        $new_url = "http://{$_SERVER['HTTP_HOST']}/profile/auth?ref=".$encode_referer;
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $new_url");
    }
}
