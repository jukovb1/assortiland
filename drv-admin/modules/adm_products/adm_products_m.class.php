<?php
/**
 * adm_products_m.class.php (admin)
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

class adm_products_m extends global_m
{
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
							WHERE pg.group_status >= 0
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
     * get_options_by_param($param)
     * @type static public
     * @description Получение списка опций по id параметра
     *
     * @return array
     * Возвращает массив списка опций
     */
    static public function get_options_by_param($param) {
        global $class_db;
        $options=$class_db->select_from_table("
							SELECT *
							FROM params_options
							WHERE param_id = $param
							ORDER BY option_sort,option_str_val
						");
        return $options;
    }

    /**
     * check_use_option($param,$option_id)
     * @type static public
     * @description Проверка использования опции в спеке
     *
     * @return array
     * Возвращает true или false
     */
    static public function check_use_option($param,$option_id) {
        global $class_db;
        $options=$class_db->select_from_table("
							SELECT *
							FROM specs_params_options
							WHERE param_id = {$param}
							AND option_id = {$option_id}
							LIMIT 1
						");
        if ($options){
            return true;
        } else {
            return false;
        }
    }
    /**
     * del_option($param,$option_id)
     * @type static public
     * @description Удаление опции в спеке
     *
     */
    static public function del_option($param,$option_id) {
        global $class_db;
        $class_db->delete_from_table("specs_params_options","param_id = {$param} AND option_id = {$option_id}");
        $class_db->delete_from_table("params_options","param_id = {$param} AND option_id = {$option_id}");
    }

    /**
     * get_list_params_by_group($group_id)
     * @type static public
     * @description Получение списка параметров по группе (сортировка по param_sort параметра)
     * @var $group_id number
     *
     * @return array
     * Возвращает массив списка групп
     */
    static public function get_list_params_by_group($group_id) {

        global $class_db;
        $content_types=$class_db->select_from_table("
							SELECT pgp.param_id,pgp.param_name AS param_new_name,p.param_name,p.param_type
							FROM params_groups AS pg
							  , params_groups_params AS pgp
							  , params AS p
							WHERE pgp.params_group_id = $group_id
							AND pgp.params_group_id = pg.params_group_id
							AND p.param_id = pgp.param_id
							AND p.param_status > 0
							ORDER BY pgp.param_sort,param_new_name,p.param_name
						");

        $result_content_types = array();
        foreach ($content_types as $content_data) {
            $result_content_types[$content_data['param_id']] = $content_data;
        }

        return $result_content_types;
    }

    /**
     * change_products_group_status($data_array)
     * @type static public
     * @description Изменение статуса контента
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function change_products_group_status($data_array) {
        global $class_db;
        $result['result'] = $rr = true;
        $result['result_msg'] = '{IE_0x100}';

        foreach ($data_array as $cont_id => $cont_data) {
            $add_res = $class_db->insert_array_to_table('products_groups',$cont_data,'group_id',$cont_id);
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
     * get_products_group_by_id($id)
     * @type static public
     * @description Получение данных контента по id
     * @var $id number - id контента
     *
     * @return array
     * Возвращает массив данных контента с нужными полями для текущего id
     * для всех языков
     */
    static public function get_products_group_by_id($id) {
        global $class_db;
        $res = array();
        $result_content_types['result'] = true;
        $result_content_types['result_msg'] = '';
        $content=$class_db->select_from_table("
                    SELECT *
                    FROM products_groups
                    WHERE group_status >= 0
                    AND group_id = $id
                    LIMIT 1
                ");
        if (!$content){
            $result_content_types['result'] = false;
            $result_content_types['result_msg'] = '{IE_1x102}';
        } else {
            $result_content_types['result_data'] = $content[0];
        }
        return $result_content_types;
    }

    /**
     * update_products_group($data_array)
     * @type static public
     * @description Изменение  контента
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function update_products_group($data_array) {
        global $class_db;
        $result['result'] = $rr = true;
        $result['result_msg'] = '{IE_0x100}';

        $cont_id = (isset($data_array['group_id']))?$data_array['group_id']:"";
        $cont_id_field = (isset($data_array['group_id']))?"group_id":"";
        $add_res = $class_db->insert_array_to_table('products_groups',$data_array,$cont_id_field,$cont_id);
        if (!$add_res) {
            $result['result'] = false;
            $result['result_msg'] = '{IE_2x100}';
        }
        return $result;
    }

    /**
     * get_products_list($dop_fields_for_table_list,$pos=NULL,$lim=NULL)
     * @type static public
     * @description Получение списка товаров
     * @param $dop_fields_for_table_list array - массив параметров для отображения в таблице списка
     * @param $pos number - стартовая позиция
     * @param $lim number - кол-во записей
     *
     * @return array
     * Возвращает массив списка товаров
     */
    static public function get_products_list($dop_fields_for_table_list,$pos=NULL,$lim=NULL) {
        global $class_db;
        $dop_field_sql = '';
        if (is_null($pos) || is_null($lim)){
            $limit = NULL;
        } else {
            $limit = "LIMIT $pos,$lim";
        }
        if (count($dop_fields_for_table_list)>0){
            foreach($dop_fields_for_table_list as $param_id => $param_data){
                if ($param_data['param_type']==3){
                    $dop_field_sql .= ", (SELECT param_text_val FROM specs_params_text_val WHERE spec_id = os.spec_id AND param_id = $param_id) AS dop_field_$param_id";
                }
            }
        }
        $sql = "
                SELECT o.*,os.*$dop_field_sql
                FROM products AS o
                , products_specs AS os
                WHERE o.product_id=os.product_id
                AND o.product_status>=0
                ORDER BY o.product_date DESC, o.product_status DESC,o.product_article,o.product_id DESC
                $limit
						";

        $products=$class_db->select_from_table($sql);

        $ret_products = array();
        if ($products){
            $list_product_group_for_product = self::get_list_products_group_for_product();

            foreach ($products as $obj) {
                $ret_products[$obj['product_id']]['product_id'] = $obj['product_id'];
                $ret_products[$obj['product_id']]['product_article'] = $obj['product_article'];
                $ret_products[$obj['product_id']]['product_date'] = $obj['product_date'];
                if (count($dop_fields_for_table_list)>0){
                    foreach($dop_fields_for_table_list as $param_id2 => $tmp){
                        if (array_key_exists('dop_field_'.$param_id2,$obj)){
                            $ret_products[$obj['product_id']]['dop_field_'.$param_id2] = $obj['dop_field_'.$param_id2];
                        }
                    }
                }
                $ret_products[$obj['product_id']]['product_status'] = $obj['product_status'];
                $lpgfp = (isset($list_product_group_for_product[$obj['product_id']]))?$list_product_group_for_product[$obj['product_id']]:NULL;
                $ret_products[$obj['product_id']]['product_groups'] = $lpgfp;

                $ret_products[$obj['product_id']]['spec_id'][$obj['spec_id']] = $obj['spec_id'];
            }
        }
        return $ret_products;
    }



    /**
     * change_products_status($data_array)
     * @type static public
     * @description Изменение статуса контента
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function change_products_status($data_array) {
        global $class_db;
        $result['result'] = $rr = true;
        $result['result_msg'] = '{IE_0x100}';

        foreach ($data_array as $cont_id => $cont_data) {
            $add_res = $class_db->insert_array_to_table('products',$cont_data,'product_id',$cont_id);
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
     * get_products_by_id($obj_ids=array(), $pre_save_objs_data=array())
     * @type static public
     * @description Получение данных контента по id
     * @var $obj_ids array - массив id контента
     * @var $pre_save_objs_data array - массив
     *
     * @return array
     * Возвращает массив данных контента с нужными полями для текущего id
     * для всех языков
     */
    static public function get_products_by_id($obj_ids=array(), $pre_save_objs_data=array()) {
        
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

        if(count($pre_save_objs_data)==0){
            if ($products){
                foreach ($products as $val_products) {
                    if ($obj_ids) {
                        $cur_id = array_search($val_products['product_id'],$obj_ids);
                        if ($cur_id >= 1 || $cur_id === 0) {
                            if(!isset($result_data_array["products"][$val_products['product_id']])){
                                $result_data_array["products"][$val_products['product_id']]=$val_products;
                            }
                            $result_data_array["products"][$val_products['product_id']]["specs"][$val_products['spec_id']]=$val_products['spec_id'];
                        }
                    } else {
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
                    $result_data_array['specs'][$param_val['spec_id']]["params"][$param_val['param_id']]=$param_val;
                }
            }
            if (count($obj_ids)==0 && count($pre_save_objs_data)==0) {
                $result_data_array['products'][0] = array(
                    'product_id' => "new",
                    'product_group'=> 0,
                    'product_article' => "",
                    'product_status' => 0,
                    'product_sort' => 0,
                    'spec_id' => 0,
                    'specs' => array("new")
                );

            } else {
                if ($no_product===false){
                    $result['result'] = false;
                    $result['result_msg'] = '{IE_1x104}';
                }
            }
        }else{
            $result_data_array['products']=$pre_save_objs_data["products"];
            $result_data_array['specs']=$pre_save_objs_data["specs"];
        }
        $result['result_data'] = $result_data_array;

        return $result;
    }

    /**
     * check_article($article,$product_id)
     * @type static public
     * @description Проверка уникальности артикла
     *
     * @param  $article string (артикл)
     * @param  $product_id number (id объекта)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function check_article($article,$product_id) {
        global $class_db;
        $result['result'] = true;
        $result['result_msg'] = '';
        $isset_article=$class_db->select_from_table("
                            SELECT * FROM products
                            WHERE product_article='$article'
                            AND product_id!='$product_id'
        ");
        if(count($isset_article)>0) {
            $result["result"] = false;
            $result["result_msg"] = "{IE_3x101}";
        }
        return $result;
    }
    /**
     * get_product_article_by_id($product_id)
     * @type static public
     * @description Проверка уникальности артикла
     *
     * @param  $product_id number (id объекта)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function get_product_article_by_id($product_id) {
        global $class_db;
        $article=$class_db->select_from_table("
                            SELECT product_article FROM products
                            WHERE product_id=$product_id
                            LIMIT 1
        ");
        if($article) {
            return $article[0]['product_article'];
        } else {
            return NULL;
        }
    }

    /**
     * check_group_nesting($group_id,$counter=0)
     * @type static public
     * @description Рекурсивная функция проверки глубины наследования групп
     *
     * @var $group_id number (id группы)
     * @var $counter number (счётчик)
     * @return number
     */
    static public function check_group_nesting($group_id,$counter=0) {
        global $class_db;
        $result = $counter;
        $parent_group_arr=$class_db->select_from_table("
                            SELECT group_parent_group FROM products_groups
                            WHERE group_id = $group_id
        ");
        if ($parent_group_arr){
            $counter++;
            $parent_group = $parent_group_arr[0]['group_parent_group'];
            $result = self::check_group_nesting($parent_group,$counter);
        }
        return $result;
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
                    foreach ($params_type as $param_id => $param_type) {
                        if ($param_type == 8) {
                            if (isset($objs['specs'][$spec_id_real]['params'][$param_id])) {
                                if (isset($objs['specs'][$spec_id_real]['params'][$param_id]['param_file_name'])){
                                    $class_db->delete_from_table("specs_params_files","spec_id=$spec_id_real AND param_id=$param_id");
                                }
                            }
                        }
                    }
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
                                $class_db->insert_array_to_table($param_tables[$params_type[$param_id]],$param_save);
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


}