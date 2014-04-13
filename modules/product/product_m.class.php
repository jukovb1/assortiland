<?php
/**
 * product_m.class.php (front)
 *
 * Класс модели каталога
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

class product_m extends global_m
{
    /**
     * get_products_by_id($obj_ids=array())
     * @type static public
     * @description Получение данных контента по id
     * @var $obj_ids array - массив id товаров
     *
     * @return array
     * Возвращает массив данных контента с нужными полями для текущего id
     * для всех языков
     */
    static public function get_product_by_article($obj_ids=array()) {

        global $class_db;
        $no_product = true;
        $result['result'] = true;
        $result['result_msg'] = '{IE_0x100}';
        if (!is_array($obj_ids)) {
            $tmp = $obj_ids;
            unset($obj_ids);
            $obj_ids[0] = $tmp;
        }
        $products=array();
        $specs_params_options = array();
        $specs_params_text_val = array();
        $specs_params_number_val = array();
        $specs_params_files = array();

        if(count($obj_ids)>0) {

            $products=$class_db->select_from_table("
                    SELECT *
                    FROM products as o, products_specs as os
                    WHERE o.product_id=os.product_id
                    AND o.product_id IN (".implode(',',$obj_ids).")
                    AND o.product_status >=0
                    ORDER BY product_sort, o.product_id DESC
            ");

            $specs_params_options=$class_db->select_from_table("
				SELECT *
				FROM specs_params_options
				WHERE spec_id IN (SELECT spec_id FROM products_specs WHERE product_id IN(".implode(',',$obj_ids)."))
			");

            $specs_params_text_val=$class_db->select_from_table("
				SELECT *
				FROM specs_params_text_val
				WHERE spec_id IN (SELECT spec_id FROM products_specs WHERE product_id IN(".implode(',',$obj_ids)."))
			");

            $specs_params_number_val=$class_db->select_from_table("
				SELECT *
				FROM specs_params_number_val
				WHERE spec_id IN (SELECT spec_id FROM products_specs WHERE product_id IN(".implode(',',$obj_ids)."))
			");

            $specs_params_files=$class_db->select_from_table("
				SELECT *
				FROM specs_params_files
				WHERE spec_id IN (SELECT spec_id FROM products_specs WHERE product_id IN(".implode(',',$obj_ids)."))
				ORDER BY param_sort
			");
        }

        $params=$class_db->select_from_table("
				SELECT *
				FROM params
				WHERE param_id>1
				ORDER BY param_sort ASC, param_id
			");

        $params_options=$class_db->select_from_table("
				SELECT *
				FROM params_options
				WHERE param_id>1
				ORDER BY option_sort, option_str_val
			");

        $result_data_array = array();

        foreach ($params as $val_params) {
            $result_data_array['params'][$val_params['param_id']] = $val_params;
        }
        foreach ($params_options as $option) {
            $result_data_array['params'][$option['param_id']]['params_options'][$option["option_id"]]=$option;
        }

        if ($products){
            foreach ($products as $val_products) {
                $cur_id = array_search($val_products['product_id'],$obj_ids);
                if ($cur_id >= 1 || $cur_id === 0) {
                    if(!isset($result_data_array["products"][$val_products['product_id']])){
                        $result_data_array["products"][$val_products['product_id']]=$val_products;
                    }
                    $result_data_array["products"][$val_products['product_id']]["specs"][$val_products['spec_id']]=$val_products['spec_id'];
                }

            }
        } else {
            $no_product = false;
        }
        if(count($obj_ids)>0) {
            foreach ($specs_params_options as $param_val) {
                if ($result_data_array['params'][$param_val['param_id']]['param_type'] == 5
                    || $result_data_array['params'][$param_val['param_id']]['param_type'] == 4) {
                    $result_data_array['specs'][$param_val['spec_id']]["params"][$param_val['param_id']]=$param_val;

                } elseif ($result_data_array['params'][$param_val['param_id']]['param_type'] == 6) {
                    $result_data_array['specs'][$param_val['spec_id']]["params"][$param_val['param_id']][$param_val['option_id']]=$param_val;
                }
            }

            foreach ($specs_params_text_val as $param_val) {
                $result_data_array['specs'][$param_val['spec_id']]["params"][$param_val['param_id']]=$param_val;
            }

            foreach ($specs_params_number_val as $param_val) {
                if($result_data_array['params'][$param_val['param_id']]["param_decimal"]>0){
                    $param_val["param_number_val"]=$param_val["param_number_val"]/pow(10,$result_data_array['params'][$param_val['param_id']]["param_decimal"]);
                }
                $result_data_array['specs'][$param_val['spec_id']]["params"][$param_val['param_id']]=$param_val;
            }

            foreach ($specs_params_files as $param_val) {
                $result_data_array['specs'][$param_val['spec_id']]["params"][$param_val['param_id']][]=$param_val;
            }
        }

        if ($no_product===false){
            $result['result'] = false;
            $result['result_msg'] = '{IE_1x104}';
        }

        $result['result_data'] = $result_data_array;

        return $result;
    }

    /**
     * check_product_by_article($article)
     * @type static public
     * @description Проверка наличия продукта по article
     *
     * @var $article string - article продукта
     * @return array
     * Возвращает массив списка групп
     */
    static public function check_product_by_article($article,$limit=NULL) {
        global $class_db;
        if (!is_null($limit)){
            $limit = "LIMIT $limit";
        }
        $isset_products=$class_db->select_from_table("
                SELECT product_id
                FROM products
                WHERE product_status != -1
                AND product_article IN ('". implode("','",$article)."')
                $limit
        ");
        $result = array();
        if ($isset_products) {
            foreach ($isset_products as $data) {
                $result[] = $data['product_id'];
            }
        }
        return $result;
    }
	
    /**
     * check_product_by_article($article)
     * @type static public
     * @description Проверка наличия продукта по article
     *
     * @var $article string - article продукта
     * @return array
     * Возвращает массив списка групп
     */
    static public function check_product_by_article_and_user($article,$limit=NULL) {
        global $class_db,$auth_class;
        if (!is_null($limit)){
            $limit = "LIMIT $limit";
        }
        $isset_products=$class_db->select_from_table("
                SELECT product_id
                FROM products
                WHERE product_status >= 0
                AND product_user_id = {$auth_class->cur_user_id}
                AND product_article IN ('". implode("','",$article)."')
                $limit
        ");
        $result = array();
        if ($isset_products) {
            foreach ($isset_products as $data) {
                $result[] = $data['product_id'];
            }
        }
        return $result;
    }

	/**
     * check_product_by_id($product_id)
     * @type static public
     * @description Проверка наличия продукта по article
     *
     * @var $product_id string - id продукта
     * @return array
     * Возвращает id продукта или false
     */
    static public function check_product_by_id($product_id,$limit=NULL) {
        global $class_db;
        if (!is_null($limit)){
            $limit = "LIMIT $limit";
        }
        $isset_products=$class_db->select_from_table("
                SELECT product_id
                FROM products
                WHERE product_status > 0
                AND product_id IN ('". implode("','",$product_id)."')
                $limit
        ");
        if ($isset_products) {
            $result = array();
            foreach ($isset_products as $data) {
                $result[] = $data['product_id'];
            }
            return $result;
        } else {
            return false;
        }
    }
	
	/**
     * update_product_number_and_string_param($product_id,$param_id,$param_value,$product_data)
     * @type static public
     * @description Изменение  контента
     *
     * @param $product_id - идентификатор продукта
	 * @param $param_id - идентификатор параметра
	 * @param $param_value - значение для параметра
	 * @param $product_data - массив со значениями
     * @return array
     * Возвращает одномерный массив результата
     */
     public static function update_product_number_and_string_param($product_id,$param_id,$param_value,$product_data) {
        global $class_db;
        $return['result'] = true;
        $return['result_msg'] = '';

        // список таблиц по типам данных
        $param_tables[2]="specs_params_number_val";
        $param_tables[3]="specs_params_text_val";
        $param_tables[7]="specs_params_text_val";

        // список полей для значения по типам данных
        $var_col[2]="param_number_val";
        $var_col[3]="param_text_val";
        $var_col[7]="param_text_val";

        $param_data = $product_data['params'][$param_id];
        $spec_id = current($product_data['products'][$product_id]['specs']);

        // проверяем, что это цифровые или текстовые данные
        if($param_data["param_type"]==2 || $param_data["param_type"]==3 || $param_data["param_type"]==7){
            $prep_value = $param_value; // ash-9 mal-9 когда-нибудь сделать валидацию данных перед сохранением
            $array_for_upd = array(
                'spec_id'=>$spec_id,
                'param_id'=>$param_id,
                $var_col[$param_data["param_type"]] => $prep_value,
            );
            // тут если сложное условие, то нужно делать такое условие
            $save_res=$class_db->insert_array_to_table($param_tables[$param_data["param_type"]],$array_for_upd,"","",0," spec_id = $spec_id AND param_id=$param_id");
            if (!$save_res){
                $return['result'] = false;
                $return['result_msg'] = 'Не сохранено';
            }
        }else{
            $return['result'] = false;
            $return['result_msg'] = 'Не поддерживаемый тип данных';
        }
        return $return;
    }
	
	/**
     * add_product_to_cart($objs)
     * @type static public
     * @description Добавление продукта в корзину
     *
     * @var $product array массив с данными продукта
     * @return number
     */
    static public function add_product_to_cart($product, $update = NULL){
        global $class_db;

        $result["result"]=true;
        $result["result_msg"]="{IE_0x100}";
		$field_id = $cart_id = '';
		
		if(!is_null($update)) {
			$field_id = 'cart_id';
			$cart_id = $update;
		}
		
        $res_save = $class_db->insert_array_to_table('users_cart',$product, $field_id, $cart_id);

        if (!$res_save){
            $result["result"]=false;
            $result["result_msg"]="IE_2x100";
        }
        return $result;
    }
	/**
     * add_product_to_partner_catalog($objs)
     * @type static public
     * @description Добавление продукта в корзину
     *
     * @var $product array массив с данными продукта
     * @return number
     */
    static public function add_product_to_partner_catalog($product){
        global $class_db;

        $result["result"]=true;
        $result["result_msg"]="{IE_0x101}";

        $res_save = $class_db->insert_array_to_table('products_partners',$product);

        if (!$res_save){
            $result["result"]=false;
            $result["result_msg"]="IE_2x102";
        }
        return $result;
    }

	/**
     * delete_product_from_cart($cart_id)
     * @type static public
     * @description Добавление продукта в корзину
     *
     * @var $cart_id number идентификатор записи в корзине
     * @return number
     */
    static public function delete_product_from_cart($cart_id){
        global $class_db,$auth_class;

        $result["result"]=true;
        $result["result_msg"]="{IE_0x102}";
		$condition = ($auth_class->cur_user_group==0)?"cart_guest_id = {$cart_id}":"cart_id = {$cart_id}";
		$table = ($auth_class->cur_user_group==0)?"users_cart_guests":"users_cart";

        $res_del = $class_db->delete_from_table($table,$condition);

        if (!$res_del){
            $result["result"]=false;
            $result["result_msg"]="IE_2x109";
        }
        return $result;
    }
	
	/**
     * check_product_in_cart_by_product_id($user_id, $product_id)
     * @type static public
     * @description Проверка уникальности артикла
     *
     * @param  $login string (логин)
     * @param  $user_id number (id пользователя)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function check_product_in_cart_by_product_id($user_id, $product_id) {
        global $class_db;
        $result['result'] = true;
        $result['result_msg'] = '';
        $isset_cart=$class_db->select_from_table("
                            SELECT cart_id FROM users_cart
                            WHERE cart_user_id='$user_id'
                            AND cart_product_id='$product_id'
                            AND cart_status = 1
                            LIMIT 1
        ");
        if($isset_cart==false) {
            $result["result"] = false;
            $result["result_msg"] = "{IE_3x100}";
        } else {
        	$result["result_data"]['cart_id'] = $isset_cart[0]['cart_id'];
        }
        return $result;
    }
	
	/**
     * update_product_for_seller($objs)
     * @type static public
     * @description Добавление или изменение продукта продавца
     *
     * @var $product array массив с данными продукта
     * @return number
     */
    static public function update_product_for_seller($product, $update = NULL){
        global $class_db;

        $result["result"]=true;
        $result["result_msg"]="{IE_0x100}";
		$field_id = $cart_id = '';
		
		if(!is_null($update)) {
			$field_id = 'product_id';
			$cart_id = $update;
		}
		
        $res_save = $class_db->insert_array_to_table('products',$product, $field_id, $cart_id);

        if (!$res_save){
            $result["result"]=false;
            $result["result_msg"]="IE_2x100";
        }
        return $result;
    }
    /**
     * get_list_products_group_for_product($product_id=NULL)
     * @type static public
     * @description Получение списка продуктов для группы (сортировка по id продукта)
     *
     * @return array
     * Возвращает массив списка групп
     */
    static public function get_list_products_group_for_product($product_id=NULL) {
        $dop_and = NULL;
        if (!is_null($product_id)){
            $dop_and = "AND pgp.product_id = $product_id";
        }
        global $class_db;
        $content_types=$class_db->select_from_table("
							SELECT pg.group_id, pg.group_full_name,pgp.product_id
							FROM products_groups AS pg
							  , products_groups_products AS pgp
							WHERE pg.group_status > 0
							$dop_and
							AND pgp.group_id = pg.group_id
							ORDER BY group_sort,group_full_name
						");

        $result_content_types = array();
        foreach ($content_types as $content_data) {
            $result_content_types[$content_data['product_id']][$content_data['group_id']] = $content_data['group_full_name'];
        }

        return $result_content_types;
    }

    /**
     * get_products_group()
     * @type static public
     * @description Получение списка групп продуктов (категорий)
     *
     * @return array
     * Возвращает массив списка групп
     */
    static public function get_products_groups() {
        global $class_db;
        $content_types=$class_db->select_from_table("
							SELECT *
							FROM products_groups
							WHERE group_status >= 0
							ORDER BY group_sort,group_full_name
						");

        $result_content_types = array();
        foreach ($content_types as $content_data) {
            $result_content_types[$content_data['group_parent_group']][$content_data['group_id']]['group_id'] = $content_data['group_id'];
            $result_content_types[$content_data['group_parent_group']][$content_data['group_id']]['group_parent_group'] = $content_data['group_parent_group'];
            $result_content_types[$content_data['group_parent_group']][$content_data['group_id']]['group_nesting'] = $content_data['group_nesting'];
            $result_content_types[$content_data['group_parent_group']][$content_data['group_id']]['group_short_name'] = $content_data['group_short_name'];
            $result_content_types[$content_data['group_parent_group']][$content_data['group_id']]['group_full_name'] = $content_data['group_full_name'];
            $result_content_types[$content_data['group_parent_group']][$content_data['group_id']]['group_sort'] = $content_data['group_sort'];
            $result_content_types[$content_data['group_parent_group']][$content_data['group_id']]['group_description'] = $content_data['group_description'];
            $result_content_types[$content_data['group_parent_group']][$content_data['group_id']]['group_img'] = $content_data['group_img'];
            $result_content_types[$content_data['group_parent_group']][$content_data['group_id']]['group_status'] = $content_data['group_status'];
            $result_content_types[$content_data['group_parent_group']][$content_data['group_id']]['group_param_1'] = $content_data['group_param_1'];
            $result_content_types[$content_data['group_parent_group']][$content_data['group_id']]['group_param_2'] = $content_data['group_param_2'];
            $result_content_types[$content_data['group_parent_group']][$content_data['group_id']]['group_param_3'] = $content_data['group_param_3'];
            $result_content_types[$content_data['group_parent_group']][$content_data['group_id']]['group_param_4'] = $content_data['group_param_4'];
        }

        return $result_content_types;
    }

    /**
     * product_save($objs)
     * @type static public
     * @description Сохранение товара
     *
     * @var $objs array (массив данных)
     * @return number
     */
    static public function product_save($objs){
        global $class_db;
        $param_tables[2]="specs_params_number_val";
        $param_tables[3]="specs_params_text_val";
        $param_tables[4]="specs_params_options";
        $param_tables[5]="specs_params_options";
        $param_tables[6]="specs_params_options";
        $param_tables[7]="specs_params_text_val";
        $param_tables[8]="specs_params_files";

        $params_type=array();

        foreach($objs['params'] as $param_ar){
            $params_type[$param_ar["param_id"]]=$param_ar["param_type"];
        }

        $result["result"]=true;
        $result["result_msg"]="{IE_0x100}";

        foreach($objs["products"] as $obj_id=>$obj){
            $cur_obj_specs=$obj["specs"];

            unset($obj["specs"]);
            unset($obj["product_id"]);

            if((substr($obj_id,0,3)=="new") || $obj_id==0){
                $obj_save_res=$class_db->insert_array_to_table("products",$obj);
                // ash-9 не помешало-бы добавить проверку на результат
                $obj_id_real=$obj_save_res;
                // создаём артикл из id и записываем его в БД
                $arr['product_article'] =  str_pad($obj_id_real, 7,"0",STR_PAD_LEFT);
                $save_article=$class_db->insert_array_to_table("products",$arr,"product_id",$obj_id_real);
            }else{
                $obj_save_res=$class_db->insert_array_to_table("products",$obj,"product_id",$obj_id);
                $obj_id_real=$obj_id;
            }
            $result["return_product"] = $obj_id_real;

            if(!$obj_save_res){
                $result["result"]=false;
                $result["result_msg"]="{IE_2x100}";
                $result["result_data"]=$objs;
                return $result;
            }
            //Сохраняем объект
            foreach($cur_obj_specs as $spec_id){
                //unset($obj["product_id"]);

                if((substr($spec_id,0,3)=="new")  or $spec_id==0){
                    $spec_save_ar=array("product_id"=>$obj_id_real);
                    // ash-9 не помешало-бы добавить проверку на результат
                    $spec_id_real=$class_db->insert_array_to_table("products_specs",$spec_save_ar);
                }else{
                    $spec_id_real=$spec_id;
                    // удаляем старые значения для этого спека из таблиц
                    $class_db->delete_from_table("specs_params_number_val","spec_id=$spec_id_real");
                    $class_db->delete_from_table("specs_params_options","spec_id=$spec_id_real");
                    $class_db->delete_from_table("specs_params_text_val","spec_id=$spec_id_real");

                    // запись о Файле удаляем только если загружен новый файл
                    /*foreach ($params_type as $param_id => $param_type) {
                        if ($param_type == 8) {
                            if (isset($objs['specs'][$spec_id_real]['params'][$param_id])) {
                                if (isset($objs['specs'][$spec_id_real]['params'][$param_id]['param_file_name'])){
                                    $class_db->delete_from_table("specs_params_files","spec_id=$spec_id_real AND param_id=$param_id");
                                }
                            }
                        }
                    }*/
                }

                //Сохраняем spec
                if(isset($objs["specs"])){
                    foreach ($params_type as $param_id => $param_type) {
                        if ($param_type == 8) {							
                            //если не передаётся новый файл
                            if (!isset($objs['specs'][$spec_id_real]['params'][$param_id])) {
                                // проверяем есть ли в БД сохранённый файл
                                $this_spec_file=$class_db->select_from_table("SELECT * FROM specs_params_files WHERE spec_id='$spec_id_real'");
                                // если нет
                                if (count($this_spec_file)<=0) {
                                    foreach ($objs['products'] as $obj => $obj_data) {
                                        //получаем номер объекта для этой спецификации
                                        if(isset($obj_data['specs'][$spec_id])
                                            && $obj_data['specs'][$spec_id] == $spec_id) {
                                            //получаем номер первой спецификации этого объекта
                                            $first_spec_this_obj = current($objs['products'][$obj]['specs']);
                                            // получаем запись о файле для неё
                                            $file_first_spec=$class_db->select_from_table("SELECT * FROM specs_params_files WHERE spec_id='$first_spec_this_obj'");
                                            //если есть
                                            if (count($file_first_spec)>0) {
                                                // перебираем массив и добавляем инфо в массив для записи
                                                foreach ($file_first_spec as $file_val) {
                                                    $objs['specs'][$spec_id]['params'][$param_id] = array(
                                                        "param_file_name" => $file_val['param_file_name'],
                                                        "param_file_name_real" => $file_val['param_file_name_real'],
                                                        "param_file_path" => $file_val['param_file_path'],
                                                        "spec_id" => $spec_id_real,
                                                        "param_id" => $file_val['param_id'],
                                                    );
                                                }
                                            } else {

                                                if (isset($objs['specs'][$spec_id_real]['params'][$param_id])) {
                                                    $file_data = $objs['specs'][$spec_id_real]['params'][$param_id];
                                                    if (isset($file_data)){
                                                        $objs['specs'][$spec_id]['params'][$param_id] = array(
                                                            "param_file_name" => $file_data['param_file_name'],
                                                            "param_file_name_real" => $file_data['param_file_name_real'],
                                                            "param_file_path" => $file_data['param_file_path'],
                                                            "spec_id" => $spec_id_real,
                                                            "param_id" => $param_id,
                                                        );
                                                    }
                                                    unset($file_data);
                                                }
                                            }

                                        }
                                    }

                                }
                            }
                        }
                    }

                    foreach($objs["specs"][$spec_id]["params"] as $param_id=>$param_save){
                        if($params_type[$param_id]==6){
                            if (is_array($param_save)){
                                $option_arr = $param_save;
                            } else {
                                $option_arr = array($param_save);
                            }
                            foreach ($option_arr as $option_val) {
                                //Сохраняем param
                                $param_save2 = $option_val;
                                $param_save2["spec_id"] = $spec_id_real;

                                if($param_save2["spec_id"]>0){
                                    $class_db->insert_array_to_table($param_tables[$params_type[$param_id]],$param_save2);
                                }
                            }
                        }else{
                            $param_save["spec_id"]=$spec_id_real;
                            if($param_save["spec_id"]>0){
                            	// необходимо обработать загружаемые файлы
								if($params_type[$param_id] == 8) {
									foreach($objs["specs"][$spec_id]["params"][$param_id] as $file_index=>$file_values) {
										$file_values["spec_id"] = $param_save["spec_id"];
										$class_db->insert_array_to_table($param_tables[$params_type[$param_id]],$file_values);
									}
								} else {
                                	$class_db->insert_array_to_table($param_tables[$params_type[$param_id]],$param_save);
								}
                            }
                        }
                    }
                }
            }
        }
        //return array("result"=>false,"message"=>"Не написана функция products_save");
        return $result;
    }

    /**
     * save_groups_data_for_product($group_id,$counter=0)
     * @type static public
     * @description Рекурсивная функция проверки глубины наследования групп
     *
     * @var $group_id number (id группы)
     * @var $counter number (счётчик)
     * @return number
     */
    static public function save_groups_data_for_product($data_array,$id) {
        global $class_db;
        $result['result'] = $rr = true;
        $result['result_msg'] = '{IE_0x100}';

        $class_db->delete_from_table('products_groups_products',"product_id=$id");
        $for_bd = array();
        foreach($data_array as $i=>$data){
            $for_bd[$i]['group_id'] = $data;
            $for_bd[$i]['product_id'] = $id;
            $add_res[$i] = $class_db->insert_array_to_table('products_groups_products',$for_bd[$i]);
        }
        return $result;
    }
    /**
     * check_product_in_guest_cart_by_product_id($user_key, $product_id)
     * @type static public
     * @description наличие товара в гостевой корзине
     *
     * @param  $user_key string уникальный ключ
     * @param  $product_id number (id товара)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function check_product_in_guest_cart_by_product_id($user_key, $product_id) {
        global $class_db;
        $result['result'] = true;
        $result['result_msg'] = '';
        $isset_cart=$class_db->select_from_table("
                            SELECT cart_guest_id FROM users_cart_guests
                            WHERE cart_guest_unique_key ='$user_key'
                            AND cart_guest_product_id='$product_id'
                            AND cart_guest_status = 1
                            LIMIT 1
        ");
        if($isset_cart==false) {
            $result["result"] = false;
            $result["result_msg"] = "{IE_3x100}";
        } else {
            $result["result_data"]['cart_guest_id'] = $isset_cart[0]['cart_guest_id'];
        }
        return $result;
    }

    /**
     * add_product_to_guest_cart($product)
     * @type static public
     * @description Добавление продукта в корзину
     *
     * @var $product array массив с данными продукта
     * @return number
     */
    static public function add_product_to_guest_cart($product, $update = NULL){
        global $class_db;

        $result["result"]=true;
        $result["result_msg"]="{IE_0x100}";
        $field_id = $cart_id = '';

        if(!is_null($update)) {
            $field_id = 'cart_guest_id';
            $cart_id = $update;
        }

        $res_save = $class_db->insert_array_to_table('users_cart_guests',$product, $field_id, $cart_id);

        if (!$res_save){
            $result["result"]=false;
            $result["result_msg"]="IE_2x100";
        }
        return $result;
    }

}


