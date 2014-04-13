<?php
/**
 * catalog_m.class.php (front)
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

class catalog_m extends global_m
{
    /**
     * get_products_list($dop_fields_for_table_list,$pos=NULL,$lim=NULL,$special=NULL,$resort_products=false)
     * @type static public
     * @description Получение списка товаров
     * @param $dop_fields_for_table_list array - массив параметров для отображения в таблице списка
     * @param $ids array - массив id товаров, которые нужны. Если пустой, выводятся все.
     * @param $pos number - стартовая позиция
     * @param $lim number - кол-во записей
     * @param $special string - специальное условие
     * @param $resort_products boolean or number - пересортировка
     *
     * @return array
     * Возвращает массив списка товаров
     */
    static public function get_products_list($dop_fields_for_table_list,$ids=array(),$pos=NULL,$lim=NULL,$special=NULL,$resort_products=false) {
        global $class_db;
        $dop_field_sql = $and_ids = '';
        if (count($ids)>0){
            $and_ids = "AND o.product_id IN (".implode(',',$ids).")";
        }
        if (is_null($pos) || is_null($lim)){
            $limit = NULL;
        } else {
            $limit = "LIMIT $pos,$lim";
        }
        $for_dop_conditional = array();

        if (count($dop_fields_for_table_list)>0){
            foreach($dop_fields_for_table_list as $param_id => $param_data){
                if ($param_data['param_type']==2){
                    $dop_select = "(SELECT param_number_val FROM specs_params_number_val WHERE spec_id = os.spec_id AND param_id = $param_id)";
                    $for_dop_conditional["dop_field_$param_id"] = $dop_select;
                    $dop_field_sql .= ", $dop_select AS dop_field_$param_id";
                } elseif ($param_data['param_type']==3){
                    $dop_select = "(SELECT param_text_val FROM specs_params_text_val WHERE spec_id = os.spec_id AND param_id = $param_id)";
                    $for_dop_conditional["dop_field_$param_id"] = $dop_select;
                    $dop_field_sql .= ", $dop_select AS dop_field_$param_id";
                } elseif ($param_data['param_type']==4){
                    $dop_select = "(SELECT option_id FROM specs_params_options WHERE spec_id = os.spec_id AND param_id = $param_id)";
                    $for_dop_conditional["dop_field_$param_id"] = $dop_select;
                    $dop_field_sql .= ", $dop_select AS dop_field_$param_id";
                } elseif ($param_data['param_type']==8){
                    $dop_select = "(CONCAT((SELECT param_file_path FROM specs_params_files WHERE spec_id = os.spec_id AND param_id = $param_id),(SELECT param_file_name FROM specs_params_files WHERE spec_id = os.spec_id AND param_id = $param_id)))";
                    $for_dop_conditional["dop_field_$param_id"] = $dop_select;
                    $dop_field_sql .= ", $dop_select AS dop_field_$param_id";
                }
            }
        }
        if (!is_null($special)){
            if (!is_array($special)){
                $tmp[] = $special;
                unset($special);
                $special = $tmp;
            }
            $dop_order = '';
            $dop_condition_arr = array();
            foreach ($special as $k=>$speci){
                $special_arr = explode('|',$speci);
                if ($special_arr[0]!='NULL'){
                    $skobka_1 = ($special_arr[0]=="OR")?"(":"";
                    $skobka_2 = ($special_arr[0]=="OR")?")":"";
                    if (isset($for_dop_conditional[$special_arr[1]])){
                        $dop_condition_arr[$k] = " {$special_arr[0]} $skobka_1".$for_dop_conditional[$special_arr[1]].$special_arr[2].$skobka_2;
                    } else {
                        $dop_condition_arr[$k] = " {$special_arr[0]} $skobka_1".$special_arr[1].$special_arr[2].$skobka_2;
                    }
                    if($special_arr[0]=="OR"){
                        $dop_condition_arr[$k] = str_replace('OR (','OR ',$dop_condition_arr[$k]);
                        $dop_condition_arr[$k-1] = substr_replace($dop_condition_arr[$k-1], 'AND (', 1, strlen('AND'));
                    }
                } else {
                    $dop_condition_arr[$k] = NULL;
                }
                $dop_order .= ($special_arr[3]!='NULL')?$special_arr[3].",":NULL;
                unset($special_arr);
            }
            $dop_condition = implode('',$dop_condition_arr);
        } else {
            $dop_condition = $dop_order = NULL;
        }

        if ($resort_products==2){
            $sort = "dop_field_2, o.product_date DESC,";
        } elseif ($resort_products==3){
            $sort = "dop_field_4 DESC, o.product_date DESC,";
        } elseif ($resort_products==4){
            $sort = "dop_field_4, o.product_date DESC,";
        } else {
            $sort = "o.product_date DESC,";
        }
        $sql = "
                SELECT o.*,os.*$dop_field_sql
                FROM products AS o
                , products_specs AS os
                WHERE o.product_id=os.product_id
                $and_ids
                $dop_condition
                AND o.product_status>0
                ORDER BY $dop_order $sort o.product_status DESC,o.product_article,o.product_id DESC
                $limit
						";
        $products=$class_db->select_from_table($sql);
        $ret_products = array();
        if ($products){

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

                $ret_products[$obj['product_id']]['spec_id'][$obj['spec_id']] = $obj['spec_id'];
            }
        }

        return $ret_products;
    }

	/**
     * get_top_products_list($dop_fields_for_table_list,$pos=NULL,$lim=NULL,$special=NULL,$resort_products=false)
     * @type static public
     * @description Получение списка товаров
     * @param $dop_fields_for_table_list array - массив параметров для отображения в таблице списка
     * @param $ids array - массив id товаров, которые нужны. Если пустой, выводятся все.
     * @param $pos number - стартовая позиция
     * @param $lim number - кол-во записей
     * @param $special string - специальное условие
     * @param $resort_products boolean or number - пересортировка
     *
     * @return array
     * Возвращает массив списка товаров
     */
    static public function get_top_products_list($dop_fields_for_table_list,$ids=array(),$pos=NULL,$lim=NULL,$special=NULL,$resort_products=false) {
        global $class_db;
        $dop_field_sql = $and_ids = '';
        if (count($ids)>0){
            $and_ids = "AND o.product_id IN (".implode(',',$ids).")";
        }
        if (is_null($pos) || is_null($lim)){
            $limit = NULL;
        } else {
            $limit = "LIMIT $pos,$lim";
        }
        $for_dop_conditional = array();

        if (count($dop_fields_for_table_list)>0){
            foreach($dop_fields_for_table_list as $param_id => $param_data){
                if ($param_data['param_type']==2){
                    $dop_select = "(SELECT param_number_val FROM specs_params_number_val WHERE spec_id = os.spec_id AND param_id = $param_id)";
                    $for_dop_conditional["dop_field_$param_id"] = $dop_select;
                    $dop_field_sql .= ", $dop_select AS dop_field_$param_id";
                } elseif ($param_data['param_type']==3){
                    $dop_select = "(SELECT param_text_val FROM specs_params_text_val WHERE spec_id = os.spec_id AND param_id = $param_id)";
                    $for_dop_conditional["dop_field_$param_id"] = $dop_select;
                    $dop_field_sql .= ", $dop_select AS dop_field_$param_id";
                } elseif ($param_data['param_type']==4){
                    $dop_select = "(SELECT option_id FROM specs_params_options WHERE spec_id = os.spec_id AND param_id = $param_id)";
                    $for_dop_conditional["dop_field_$param_id"] = $dop_select;
                    $dop_field_sql .= ", $dop_select AS dop_field_$param_id";
                } elseif ($param_data['param_type']==8){
                    $dop_select = "(CONCAT((SELECT param_file_path FROM specs_params_files WHERE spec_id = os.spec_id AND param_id = $param_id),(SELECT param_file_name FROM specs_params_files WHERE spec_id = os.spec_id AND param_id = $param_id)))";
                    $for_dop_conditional["dop_field_$param_id"] = $dop_select;
                    $dop_field_sql .= ", $dop_select AS dop_field_$param_id";
                }
            }
        }
        if (!is_null($special)){
            if (!is_array($special)){
                $tmp[] = $special;
                unset($special);
                $special = $tmp;
            }
            $dop_order = '';
            $dop_condition_arr = array();
            foreach ($special as $k=>$speci){
                $special_arr = explode('|',$speci);
                if ($special_arr[0]!='NULL'){
                    $skobka_1 = ($special_arr[0]=="OR")?"(":"";
                    $skobka_2 = ($special_arr[0]=="OR")?")":"";
                    if (isset($for_dop_conditional[$special_arr[1]])){
                        $dop_condition_arr[$k] = " {$special_arr[0]} $skobka_1".$for_dop_conditional[$special_arr[1]].$special_arr[2].$skobka_2;
                    } else {
                        $dop_condition_arr[$k] = " {$special_arr[0]} $skobka_1".$special_arr[1].$special_arr[2].$skobka_2;
                    }
                    if($special_arr[0]=="OR"){
                        $dop_condition_arr[$k] = str_replace('OR (','OR ',$dop_condition_arr[$k]);
                        $dop_condition_arr[$k-1] = substr_replace($dop_condition_arr[$k-1], 'AND (', 1, strlen('AND'));
                    }
                } else {
                    $dop_condition_arr[$k] = NULL;
                }
                $dop_order .= ($special_arr[3]!='NULL')?$special_arr[3].",":NULL;
                unset($special_arr);
            }
            $dop_condition = implode('',$dop_condition_arr);
        } else {
            $dop_condition = $dop_order = NULL;
        }

        if ($resort_products==2){
            $sort = "dop_field_2, o.product_date DESC,";
        } elseif ($resort_products==3){
            $sort = "dop_field_4 DESC, o.product_date DESC,";
        } elseif ($resort_products==4){
            $sort = "dop_field_4, o.product_date DESC,";
        } else {
            $sort = "o.product_date DESC,";
        }
        $sql = "
                SELECT o.*,os.*$dop_field_sql,pg.group_parent_group
                FROM products AS o
                , products_specs AS os
                , products_groups_products AS pgp
                , products_groups AS pg
                WHERE o.product_id=os.product_id
                AND o.product_id=pgp.product_id
                AND pg.group_id=pgp.group_id
                $and_ids
                $dop_condition
                AND o.product_status>0
                GROUP BY o.product_id
                ORDER BY o.product_id ASC, $dop_order $sort o.product_status DESC,o.product_article,o.product_id DESC
                $limit
						";
        $products=$class_db->select_from_table($sql);
        $ret_products = array();
        if ($products){

            foreach ($products as $obj) {
                $ret_products[$obj['product_id']]['product_id'] = $obj['product_id'];
                $ret_products[$obj['product_id']]['product_article'] = $obj['product_article'];
                $ret_products[$obj['product_id']]['product_date'] = $obj['product_date'];
                $ret_products[$obj['product_id']]['parent_group_id'] = $obj['group_parent_group'];
                if (count($dop_fields_for_table_list)>0){
                    foreach($dop_fields_for_table_list as $param_id2 => $tmp){
                        if (array_key_exists('dop_field_'.$param_id2,$obj)){
                            $ret_products[$obj['product_id']]['dop_field_'.$param_id2] = $obj['dop_field_'.$param_id2];
                        }
                    }
                }
                $ret_products[$obj['product_id']]['product_status'] = $obj['product_status'];

                $ret_products[$obj['product_id']]['spec_id'][$obj['spec_id']] = $obj['spec_id'];
            }
        }

        return $ret_products;
    }

	/**
     * get_products_list_by_user_id($user_id, $dop_fields_for_table_list,$pos=NULL,$lim=NULL,$special=NULL,$resort_products=false)
     * @type static public
     * @description Получение списка товаров
	 * @param $user_id number - идентификатор пользователя
     * @param $dop_fields_for_table_list array - массив параметров для отображения в таблице списка
     * @param $pos number - стартовая позиция
     * @param $lim number - кол-во записей
     * @param $special string - специальное условие
     * @param $resort_products boolean or number - пересортировка
     *
     * @return array
     * Возвращает массив списка товаров
     */
    static public function get_products_list_by_user_id($user_id, $dop_fields_for_table_list,$pos=NULL,$lim=NULL,$special=NULL,$resort_products=false) {
        global $class_db;
        $dop_field_sql = $and_ids = '';
		
		if(!isset($user_id) || $user_id <= 0){
			return false;
		}

        if (is_null($pos) || is_null($lim)){
            $limit = NULL;
        } else {
            $limit = "LIMIT $pos,$lim";
        }
        $for_dop_conditional = array();

        if (count($dop_fields_for_table_list)>0){
            foreach($dop_fields_for_table_list as $param_id => $param_data){
                if ($param_data['param_type']==2){
                    $dop_select = "(SELECT param_number_val FROM specs_params_number_val WHERE spec_id = os.spec_id AND param_id = $param_id)";
                    $for_dop_conditional["dop_field_$param_id"] = $dop_select;
                    $dop_field_sql .= ", $dop_select AS dop_field_$param_id";
                } elseif ($param_data['param_type']==3 || $param_data['param_type']==7){
                    $dop_select = "(SELECT param_text_val FROM specs_params_text_val WHERE spec_id = os.spec_id AND param_id = $param_id)";
                    $for_dop_conditional["dop_field_$param_id"] = $dop_select;
                    $dop_field_sql .= ", $dop_select AS dop_field_$param_id";
                } elseif ($param_data['param_type']==4){
                    $dop_select = "(SELECT option_id FROM specs_params_options WHERE spec_id = os.spec_id AND param_id = $param_id)";
                    $for_dop_conditional["dop_field_$param_id"] = $dop_select;
                    $dop_field_sql .= ", $dop_select AS dop_field_$param_id";
                } elseif ($param_data['param_type']==8){
                    $dop_select = "(CONCAT((SELECT param_file_path FROM specs_params_files WHERE spec_id = os.spec_id AND param_id = $param_id ORDER BY param_sort LIMIT 1),(SELECT param_file_name FROM specs_params_files WHERE spec_id = os.spec_id AND param_id = $param_id ORDER BY param_sort LIMIT 1)))";
                    $for_dop_conditional["dop_field_$param_id"] = $dop_select;
                    $dop_field_sql .= ", $dop_select AS dop_field_$param_id";
                }
            }
        }
        if (!is_null($special)){
            if (!is_array($special)){
                $tmp[] = $special;
                unset($special);
                $special = $tmp;
            }
            $dop_order = '';
            $dop_condition_arr = array();
            foreach ($special as $k=>$speci){
                $special_arr = explode('|',$speci);
                if ($special_arr[0]!='NULL'){
                    $skobka_1 = ($special_arr[0]=="OR")?"(":"";
                    $skobka_2 = ($special_arr[0]=="OR")?")":"";
                    if (isset($for_dop_conditional[$special_arr[1]])){
                        $dop_condition_arr[$k] = " {$special_arr[0]} $skobka_1".$for_dop_conditional[$special_arr[1]].$special_arr[2].$skobka_2;
                    } else {
                        $dop_condition_arr[$k] = " {$special_arr[0]} $skobka_1".$special_arr[1].$special_arr[2].$skobka_2;
                    }
                    if($special_arr[0]=="OR"){
                        $dop_condition_arr[$k] = str_replace('OR (','OR ',$dop_condition_arr[$k]);
                        $dop_condition_arr[$k-1] = substr_replace($dop_condition_arr[$k-1], 'AND (', 1, strlen('AND'));
                    }
                } else {
                    $dop_condition_arr[$k] = NULL;
                }
                $dop_order .= ($special_arr[3]!='NULL')?$special_arr[3].",":NULL;
                unset($special_arr);
            }
            $dop_condition = implode('',$dop_condition_arr);
        } else {
            $dop_condition = $dop_order = NULL;
        }

        if ($resort_products==2){
            $sort = "dop_field_2, o.product_date DESC,";
        } elseif ($resort_products==3){
            $sort = "dop_field_4 DESC, o.product_date DESC,";
        } elseif ($resort_products==4){
            $sort = "dop_field_4, o.product_date DESC,";
        } else {
            $sort = "o.product_date DESC,";
        }
        $sql = "
                SELECT o.*,os.*$dop_field_sql
                FROM products AS o
                , products_specs AS os
                WHERE o.product_id=os.product_id
                $dop_condition
                AND o.product_status != -1
                AND o.product_user_id = '$user_id'
                ORDER BY $dop_order $sort o.product_status DESC,o.product_article,o.product_id DESC
                $limit
						";
        $products=$class_db->select_from_table($sql);
        $ret_products = array();
        if ($products){
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
                $ret_products[$obj['product_id']]['spec_id'][$obj['spec_id']] = $obj['spec_id'];
            }
        }

        return $ret_products;
    }

	/**
     * get_products_count_by_user_id($user_id)
     * @type static public
     * @description Получение колличества товаров для пользователя
	 * @param $user_id number - идентификатор пользователя
     *
     * @return array
     * Возвращает массив списка товаров
     */
    static public function get_products_count_by_user_id($user_id) {
        global $class_db;
        $dop_field_sql = $and_ids = '';
		
		if(!isset($user_id) || $user_id <= 0){
			return false;
		}

        $sql = "
                SELECT COUNT(o.product_id) as products_count
                FROM products AS o
                WHERE o.product_status>=0
                AND o.product_user_id = '$user_id'
                ORDER BY o.product_status DESC,o.product_article,o.product_id DESC
						";
        $products=$class_db->select_from_table($sql);
        if ($products){
        	return $products[0]['products_count'];
        } else {
        	return 0;
        }
    }

    /**
     * get_products_list_special($dop_fields_for_table_list,$pos=NULL,$lim=NULL)
     * @type static public
     * @description Получение спец.списка товаров
     * @param $dop_fields_for_table_list array - массив параметров для отображения в таблице списка
     * @param $ids array - массив id товаров, которые нужны. Если пустой, выводятся все.
     * @param $pos number - стартовая позиция
     * @param $lim number - кол-во записей
     *
     * @return array
     * Возвращает массив списка товаров
     */
    static public function get_products_list_special($dop_fields_for_table_list,$ids=array(),$pos=NULL,$lim=NULL) {

        $products['act'] = self::get_products_list($dop_fields_for_table_list,$ids,$pos,$lim,'AND|dop_field_8|=1|dop_field_8 DESC');
        $products['new'] = self::get_products_list($dop_fields_for_table_list,$ids,$pos,$lim);
        $products['top'] = self::get_products_list($dop_fields_for_table_list,$ids,$pos,$lim,'NULL|NULL|NULL|dop_field_7 DESC');
        return $products;
    }

    /**
     * get_list_params_by_group($group_id)
     * @type static public
     * @description Получение списка продуктов для группы (сортировка по id продукта)
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
     * check_products_group_by_url($url)
     * @type static public
     * @description Проверка наличия группы (категории) по url
     *
     * @var $url string - url категории
     * @return array
     * Возвращает массив списка групп
     */
    static public function check_products_group_by_url($url) {
        global $class_db;
        $isset_group=$class_db->select_from_table("
                SELECT *
                FROM products_groups
                WHERE group_status > 0
                AND group_short_name = '$url'
                LIMIT 1
        ");
        if ($isset_group) {
            return $isset_group[0];
        } else {
            return false;
        }
    }

    /**
     * check_products_group_by_id($id)
     * @type static public
     * @description Проверка наличия группы (категории) по id
     *
     * @var $id string - $id категории
     * @return array
     * Возвращает массив списка групп
     */
    static public function check_products_group_by_id($id) {
        global $class_db;
        $isset_group=$class_db->select_from_table("
                SELECT *
                FROM products_groups
                WHERE group_status > 0
                AND group_id = $id
                LIMIT 1
        ");
        if ($isset_group) {
            return $isset_group[0];
        } else {
            return false;
        }
    }

    /**
     * count_product_by_all_child_group($parent_id,$first_call=true) {
     * @type static public
     * @description Рекурсивный подсчёт товаров в категории, включая дочерние
     *
     * @var $parent_id number - id родителя
     * @param $first_call boolean - первый вызов
     * @return number
     * Возвращает количество товаров
     */
    static public function count_product_by_all_child_group($parent_id,$first_call=true,$seller=NULL,$partner_id=NULL) {
        global $class_db;
        $and_seller = NULL;
        if (!is_null($seller)){
            $and_seller = "AND p.product_user_id = $seller";
        } elseif (!is_null($partner_id)){
            $partner_products = self::partner_products($partner_id);
            if (!is_null($partner_products)){
                $and_seller = "AND p.product_id IN (".implode(',',$partner_products).")";
            } else {
                // если партнёрских товаров нет, делаем пустой вывод
                $and_seller = "AND p.product_id = 'NULL'";
            }
        }
        if ($first_call && $parent_id != 0){
            $products=$class_db->select_from_table("
                SELECT pg.group_id,p.product_id
                FROM products_groups AS pg
                LEFT JOIN products_groups_products AS pgp ON (pgp.group_id = pg.group_id)
                LEFT JOIN products AS p ON (p.product_id = pgp.product_id AND p.product_status > 0 $and_seller)
                WHERE  pg.group_status > 0
                AND pg.group_id = $parent_id
            ");
            if ($products) {
                $return = array();
                foreach($products as $product){
                    if (!is_null($product['product_id'])){
                        $return[$product['product_id']] = $product['product_id'];
                    }
                }
                $recursia = self::count_product_by_all_child_group($parent_id,false,$seller,$partner_id);

                if (!is_null($recursia)){
                    $return = $return + $recursia;
                }
                return $return;
            } else {
                return NULL;
            }
        } else {
            $products=$class_db->select_from_table("
                 SELECT pg.group_id,p.product_id
                FROM products_groups AS pg
                LEFT JOIN products_groups_products AS pgp ON (pgp.group_id = pg.group_id)
                LEFT JOIN products AS p ON (p.product_id = pgp.product_id AND p.product_status > 0 $and_seller)
                WHERE  pg.group_status > 0
                AND pg.group_parent_group = $parent_id
            ");
            if ($products) {
                $group = $return = array();
                foreach($products as $product){
                    $group[$product['group_id']] = $product['group_id'];
                    if (!is_null($product['product_id'])){
                        $return[$product['product_id']] = $product['product_id'];
                    }
                 }
                foreach($group as $group_id){
                    $recursia = self::count_product_by_all_child_group($group_id,false,$seller,$partner_id);

                    if (!is_null($recursia)){
                        $return = $return + $recursia;
                    }
                }
                asort($return);
                return $return;
            } else {
                return NULL;
            }
        }

    }
    
    /**
     * count_catalog_min_max_price()
     * @type static public
     * @description Подсчёт цен товаров
     *
     * @return number
     *  Возвращает цены
     */
    static public function count_catalog_min_max_price() {
        global $class_db;
        $search_stat=$class_db->select_from_table("
        	SELECT MIN(sp_p.param_number_val) as min, MAX(sp_p.param_number_val) as max
            FROM products AS p, specs_params_number_val as sp_p
            WHERE p.product_id=sp_p.spec_id
            AND sp_p.param_id=5 AND p.product_status>0
        ");
        if ($search_stat){			
            return $search_stat;
        } else {
            return 0;
        }
    }
	
    /**
     * partner_products($partner_id)
     * @type static public
     * @description Партнёрские товары
     *
     * @var $partner_id number - id партнёра
     * @return number
     *  Возвращает массив id товаров
     */
    static public function partner_products($partner_id) {
        global $class_db;
        $products = $class_db->select_from_table("
        	SELECT * FROM products_partners
        	  WHERE p_partner_user_id = $partner_id
        	  AND p_status>0
        ");
        if ($products){
            $return = array();
            foreach ($products as $d) {
                $return[$d['p_product_id']] = $d['p_product_id'];
            }
            return $return;
        } else {
            return NULL;
        }
    }

	/**
     * count_catalog_min_max_offers()
     * @type static public
     * @description Подсчёт вознаграждения
     *
     * @return number
     *  Возвращает вознаграждения
     */
    static public function count_catalog_min_max_offers() {
        global $class_db;
        $search_stat=$class_db->select_from_table("
        	SELECT MIN(sp_p.param_number_val)/2 as min, MAX(sp_p.param_number_val)/2 as max
            FROM products AS p, specs_params_number_val as sp_p
            WHERE p.product_id=sp_p.spec_id
            AND sp_p.param_id=11 AND p.product_status>0
        ");
        if ($search_stat){			
            return $search_stat;
        } else {
            return 0;
        }
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
							WHERE group_status > 0
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

    static public function delete_partner_product($condition){
        global $class_db;
        $result["result"]=true;
        $result["result_msg"]="{IE_0x102}";

        $res_save = $class_db->delete_from_table('products_partners',$condition);

        if (!$res_save){
            $result["result"]=false;
            $result["result_msg"]="IE_2x103";
        }
        return $result;
    }
}

