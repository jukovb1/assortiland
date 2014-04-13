<?php
/**
 * profile_m.class.php (admin)
 *
 * Класс модели продукции админки
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

class profile_m extends global_m
{
    /**
     * get_users_group_by_id($id)
     * @type static public
     * @description Получение данных контента по id
     * @var $id number - id контента
     *
     * @return array
     * Возвращает массив данных контента с нужными полями для текущего id
     * для всех языков
     */
    static public function get_users_group_by_id($id) {
        global $class_db;
        $res = array();
        $result_content_types['result'] = true;
        $result_content_types['result_msg'] = '';
        $content=$class_db->select_from_table("
                    SELECT *
                    FROM users_groups
                    WHERE us_group_status >= 0
                    AND us_group_id = $id
                    LIMIT 1
                ");
        if (!$content){
            $result_content_types['result'] = false;
            $result_content_types['result_msg'] = '{IE_1x102}';
        } else {
            $langs_list = self::get_langs_data();
            $cur_langs = $langs_list['by_id'];
            $res = $content[0];
            unset($res['us_group_title']);
            unset($res['us_group_desc']);

            foreach ($cur_langs as $cur_lang_id=>$cur_lang_data) {
                $lang_val = self::get_lang_text_by_index($content[0]['us_group_title'],$cur_lang_id);
                $res['us_group_title'][$cur_lang_id]=$lang_val;
            }
            foreach ($cur_langs as $cur_lang_id=>$cur_lang_data) {
                $lang_val = self::get_lang_text_by_index($content[0]['us_group_desc'],$cur_lang_id);
                $res['us_group_desc'][$cur_lang_id]=$lang_val;
            }
            $result_content_types['result_data'] = $res;

        }
        return $result_content_types;
    }

    /**
     * get_user_data_by_login($user_id)
     * @type static public
     * @description Получение информации о пользователе по login
     *
     * @param $user_login string (login пользователя)(example: Ashterix)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function get_user_data_by_login($user_login) {
        global $class_db;
        $return['result'] = true;
        $return['result_msg'] = '';

        $user_login = mysql_real_escape_string($user_login);
        $user = $class_db->select_from_table("
							SELECT *
							FROM users
							WHERE user_login = '$user_login'
							AND user_status >= 0
							LIMIT 1
						");
        if (!$user){
            $return['result'] = false;
            $return['result_msg'] = '';
        } else {
            $return['result_data']=$user[0];
            $user_id = $user[0]['user_id'];
            $user_fd = $class_db->select_from_table("
							SELECT *
							FROM users_full_data
							WHERE user_id = $user_id
							LIMIT 1
						");
            //$return['result_data']['user_groups'] = self::get_list_users_group_for_user($user_id);
            if ($user_fd){
                $return['result_data']['full_data']=$user_fd[0];
            }
        }
        return $return;
    }
	
	/**
     * get_user_delivery_region($user_id)
     * @type static public
     * @description Получение информации о регионе доставки пользователя по id
     *
     * @param $user_id number (id пользователя)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function get_user_delivery_region($user_id) {
        global $class_db;
        $return['result'] = true;
        $return['result_msg'] = '';

        $user = $class_db->select_from_table("
						SELECT user_delivery_region
						FROM users_full_data
						WHERE user_id = $user_id
						LIMIT 1
					");
        if (!$user){
            $return['result'] = false;
            $return['result_msg'] = '';
        } else {
            $return['result_data']=$user[0]['user_delivery_region'];
        }
        return $return;
    }
	
	/**
     * get_user_data_by_email($user_email)
     * @type static public
     * @description Получение информации о пользователе по email
     *
     * @param $user_email string (email пользователя)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function get_user_data_by_email($user_email) {
        global $class_db;
        $return['result'] = true;
        $return['result_msg'] = '';

        $user_email = mysql_real_escape_string($user_email);
        $user = $class_db->select_from_table("
							SELECT *
							FROM users
							WHERE user_email = '$user_email'
							AND user_status >= 0
							LIMIT 1
						");
        if (!$user){
            $return['result'] = false;
            $return['result_msg'] = '';
        } else {
            $return['result_data']=$user[0];
            $user_id = $user[0]['user_id'];
            $user_fd = $class_db->select_from_table("
							SELECT *
							FROM users_full_data
							WHERE user_id = $user_id
							LIMIT 1
						");
            //$return['result_data']['user_groups'] = self::get_list_users_group_for_user($user_id);
            if ($user_fd){
                $return['result_data']['full_data']=$user_fd[0];
            }
        }
        return $return;
    }
	
	/**
     * check_subscriber($user_id)
     * @type static public
     * @description Проверка подписчика
     *
     * @param  $user_id number (id пользователя)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function check_subscriber($user_id) {
        global $class_db;
        $result['result'] = true;
        $result['result_data'] = false;
        $subscr=$class_db->select_from_table("
                            SELECT subscr_status FROM users_subscribe
                            WHERE subscr_user_id='$user_id'
                            LIMIT 1
        ");
        if($subscr) {
        	$result['result_data'] = ($subscr[0]['subscr_status']==1)?true:false;
        } else {
            $result['result'] = false;
            $result['result_data'] = false;
        }
        return $result;
    }

    /**
     * check_login($login,$user_id)
     * @type static public
     * @description Проверка уникальности артикла
     *
     * @param  $login string (логин)
     * @param  $user_id number (id пользователя)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function check_login($login,$user_id) {
        global $class_db;
        $result['result'] = true;
        $result['result_msg'] = '';
        $isset_login=$class_db->select_from_table("
                            SELECT * FROM users
                            WHERE user_login='$login'
                            AND user_id!='$user_id'
        ");
        if(count($isset_login)>0) {
            $result["result"] = false;
            $result["result_msg"] = "{IE_3x101}";
        }
        return $result;
    }

    /**
     * check_email($email,$user_id)
     * @type static public
     * @description Проверка уникальности артикла
     *
     * @param  $email string (email)
     * @param  $user_id number (id пользователя)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function check_email($email,$user_id) {
        global $class_db;
        $result['result'] = true;
        $result['result_msg'] = '';
        $isset_login=$class_db->select_from_table("
                            SELECT * FROM users
                            WHERE user_email='$email'
                            AND user_id!='$user_id'
        ");
        if(count($isset_login)>0) {
            $result["result"] = false;
            $result["result_msg"] = "{IE_3x104}";
        }
        return $result;
    }

    /**
     * user_save($objs)
     * @type static public
     * @description Сохранение пользователя
     *
     * @var $objs array (массив данных)
     * @return number
     */
    static public function user_save($array){
        global $class_db;

        $result["result"]=true;
        $result["result_msg"]="{IE_0x100}";
        $fd_array = $sbscr_array = array();

        $field_id = '';
        $user_id = '';
		$subscribe_status = false;
        if (isset($array['user_id'])){
            $field_id = 'user_id';
            $user_id = $array['user_id'];
        }
        if (isset($array['full_data'])){
            $fd_array = $array['full_data'];
            unset($array['full_data']);
        }
        if(isset($array['subscribe_status'])){
        	$subscribe_status = true;
        	unset($array['subscribe_status']);
    	}

        $res_save = $class_db->insert_array_to_table('users',$array,$field_id,$user_id);
        $result['result_data']['user_id']=$res_save;

        $res_save_fd = true;
        if ($res_save && count($fd_array)>0){
            $fd_array['user_id'] = (!empty($user_id))?$user_id:$res_save;
            $sql_2 = "SELECT * FROM users_full_data WHERE user_id = {$fd_array['user_id']}";
            $res_2 = $class_db->select_from_table($sql_2);
            $field_id = '';
            $user_id = '';
            if ($res_2){
                $field_id = 'user_id';
                $user_id = $fd_array['user_id'];
            }
            $res_save_fd = $class_db->insert_array_to_table('users_full_data',$fd_array,$field_id,$user_id);
        }
		if($subscribe_status){
			$sbscr_array['subscr_user_id'] = (!empty($user_id))?$user_id:$res_save;
			$res_save_sbscr = $class_db->insert_array_to_table('users_subscribe',$sbscr_array);
		}
		
        if (!$res_save || !$res_save_fd){
            $result["result"]=false;
            $result["result_msg"]="{IE_2x100}";
        }
        return $result;
    }

    /**
     * user_activate($data_array)
     * @type static public
     * @description Активация пользователя
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function user_activate($data_array) {
        global $class_db;
        $result['result'] = $rr = true;
        $result['result_msg'] = '{IE_0x101}';
        $add_res = $class_db->insert_array_to_table('users',$data_array,'','',0,"user_id={$data_array['user_id']} AND user_key_activated='{$data_array['user_key_activated']}' AND user_status!=-1");
        if ($add_res===false) {
            $result['result'] = false;
            $result['result_msg'] = '{IE_1x106}';
        }
        return $result;
    }
	
	/**
     * user_password_recovery($data_array)
     * @type static public
     * @description Восстановление пароля пользователя
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function user_password_recovery($data_array) {
        global $class_db;
        $result['result'] = $rr = true;
        $result['result_msg'] = '{IE_0x107}';
        $add_res = $class_db->insert_array_to_table('users',$data_array,'','',0,"user_id={$data_array['user_id']} AND user_status!=-1");
        if ($add_res===false) {
            $result['result'] = false;
            $result['result_msg'] = '{IE_1x111}';
        }
        return $result;
    }
	
    /**
     * add_order($data_array)
     * @type static public
     * @description добавление заказа и удаление товара из корзины
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function add_order($data_array) {
        global $class_db;
        $result['result'] = $rr = true;
        $result['result_msg'] = '{IE_0x103}';
        foreach ($data_array as $i => $data) {
            $add_res = $class_db->insert_array_to_table('order_statistic',$data);

            if ($add_res===false) {
                $result['result'] = false;
                $result['result_msg'] = '{IE_1x107}';
            } else {
                //$del_res = product_m::delete_product_from_cart($i);
                //if ($del_res['result']===false) {
                  //  $result['result'] = false;
                    //$result['result_msg'] = $del_res['result_msg'];
                //}
            }

        }
        return $result;
    }
	
	/**
     * update_subscribe_status($data_array)
     * @type static public
     * @description обновление статуса подписчика
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function update_subscribe_status($data_array,$upd=false) {
        global $class_db;
        $result['result'] = $rr = true;
        $result['result_msg'] = ($data_array['subscr_status']==1)?'{IE_0x106}':'{IE_0x108}';
		$field_id = $user_id = '';
        if ($upd) {
            $field_id = 'subscr_user_id';
            $user_id = $data_array['subscr_user_id'];
        }
        $add_res = $class_db->insert_array_to_table('users_subscribe',$data_array,$field_id,$user_id);
        if (!$add_res) {
            $result['result'] = false;
            $result['result_msg'] = '{IE_3x105}';
        }
        return $result;
    }
	
    /**
     * change_users_status($data_array)
     * @type static private
     * @description изменение статуса пользователя
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static private function change_users_status($data_array) {
        global $class_db;
        $result['result'] = $rr = true;
        $result['result_msg'] = '{IE_0x100}';

        foreach ($data_array as $cont_id => $cont_data) {
            $add_res = $class_db->insert_array_to_table('users',$cont_data,'user_id',$cont_id);
            if (!$add_res) {
                $rr = false;
            }
        }
        if (!$rr) {
            $result['result'] = false;
            $result['result_msg'] = '{IE_2x100}';
        }
        return $result;
    }

	/**
     * get_products_from_cart($user_id,$status=1)
     * @type static public
     * @description Получение продуктов из корзины по id пользователя
     *
     * @param $user_id number - идентификатор пользователя
	 * @param $status string or number - статус по которому нужно найти продукты
     * @return array
     * Возвращает массив списка товаров
     */
    static public function get_products_from_cart($user_id,$status=1) {
        global $class_db;

		$result["result"]=true;
		$result["result_msg"]='';
        $isset_products=$class_db->select_from_table("
                SELECT *
                FROM users_cart
                WHERE cart_user_id = {$user_id} AND cart_status IN ('{$status}')
        ");
		
        if ($isset_products) {
			foreach ($isset_products as $value) {
				$result["result_data"][$value['cart_id']]=$value;
			}
        } else {
        	$result["result"]=false;
			$result["result_msg"]=lang_text("{IE_2x108}");
        }

		return $result;
    }

	/**
     * get_products_from_guest_cart($unique_key,$status=1)
     * @type static public
     * @description Получение продуктов из корзины по id пользователя
     *
     * @param $unique_key string - уникальный ключ
	 * @param $status string | int - статус по которому нужно найти продукты
     * @return array
     * Возвращает массив списка товаров
     */
    static public function get_products_from_guest_cart($unique_key,$status=1) {
        global $class_db;

		$result["result"]=true;
		$result["result_msg"]='';
        $isset_products=$class_db->select_from_table("
                SELECT *
                FROM users_cart_guests
                WHERE cart_guest_unique_key = '{$unique_key}' AND cart_guest_status IN ('{$status}')
        ");

        if ($isset_products) {
            foreach ($isset_products as $value) {
                $result["result_data"][$value['cart_guest_id']]=$value;
            }
        } else {
            $result["result"]=false;
            $result["result_msg"]=lang_text("{IE_2x108}");
        }

        return $result;
    }

	/**
     * save_guest_cart_in_user_cart($unique_key,$status=1)
     * @type static public
     * @description Перенос гостевой корзины в пользовательскую
     *
     * @param $unique_key string - уникальный ключ
	 * @param $user_id - id пользователя
     * @return array
     * Возвращает массив списка товаров
     */
    static public function save_guest_cart_in_user_cart($unique_key,$user_id) {
        global $class_db;

		$result["result"]=true;
		$result["result_msg"]='';
        $isset_products=$class_db->select_from_table("
                SELECT *
                FROM users_cart_guests
                WHERE cart_guest_unique_key = '{$unique_key}' AND cart_guest_status > 0
        ");

        if ($isset_products) {
            foreach ($isset_products as $value) {
                $new_cart_data['cart_user_id'] = $user_id;
                $new_cart_data['cart_owner_user_id'] = $value['cart_guest_owner_user_id'];
                $new_cart_data['cart_product_id'] = $value['cart_guest_product_id'];
                $new_cart_data['cart_product_count'] = $value['cart_guest_product_count'];
                $new_cart_data['cart_status'] = $value['cart_guest_status'];
                $new_cart_data['cart_date'] = $value['cart_guest_date'];
                $class_db->insert_array_to_table('users_cart',$new_cart_data);
                $class_db->delete_from_table('users_cart_guests',"cart_guest_id = {$value['cart_guest_id']}");
                setcookie('unique_key',$unique_key,time()-1,'/');
            }
        }
        return $result;
    }

    /**
     * check_order_by_index_and_change_status($index,$article,$user_id,$new_status)
     * @type static public
     * @description добавление заказа и удаление товара из корзины
     *
     * @param $index string индекс заказа
     * @param $article string артикл товара
     * @param $user_id number id продавца
     * @param $new_status number новый статус
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function check_order_by_index_and_change_status($index,$article,$user_id,$new_status) {
        global $class_db;
        $result['result'] = true;
        $result['result_msg'] = ($new_status>0)?'{IE_0x104}':'{IE_0x105}';

        $res = $class_db->select_from_table("
                SELECT *
                FROM order_statistic
                WHERE order_index = '$index'
                AND order_owner_user_id = $user_id
                AND order_product_article = '$article'
                LIMIT 1
        ");

        if ($res){
            if ($res[0]['order_status']==-1){
                $result['result'] = false;
                $result['result_msg'] = '{IE_1x108}';
            } elseif ($res[0]['order_status']>1){
                $result['result'] = false;
                $result['result_msg'] = '{IE_1x110}';
            } elseif ($res[0]['order_status']==0){
                $result['result'] = false;
                $result['result_msg'] = '{IE_1x109}';
            } else {
                $result['result_data'] = $res[0];
                $status_arr['order_status'] = $new_status;
                $status_arr['order_date_updt'] = date("Y-m-d H:i:s");
                $res_upd = $class_db->insert_array_to_table('order_statistic',$status_arr,'order_id',$res[0]['order_id']);
                if (!$res_upd){
                    $result['result'] = false;
                    $result['result_msg'] = '{IE_2x111}';
                }
            }
        } else {
            $result['result'] = false;
            $result['result_msg'] = '{IE_1x108}';
        }
        return $result;
    }
}