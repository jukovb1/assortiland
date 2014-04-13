<?php
/**
 * statistic_m.class.php (admin)
 *
 * Класс модели контента админки
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

class statistic_m extends global_m
{

    /**
     * get_statistic_types()
     * @type static public
     * @description Получение списка типов контента и их свойств
     *
     * @return array
     * Возвращает одномерный массив списка типов
     * для текущего языка
     */
    static public function get_statistic_types() {
        global $class_db;
        $statistic_types=$class_db->select_from_table("
							SELECT *
							FROM statistic_types
							WHERE type_status >= 0
						");

        $return_statistic_types = array();
        foreach ($statistic_types as $statistic_data) {
            $return_statistic_types['statistic-'.$statistic_data['type_alias']]['type_id'] = $statistic_data['type_id'];
            $return_statistic_types['statistic-'.$statistic_data['type_alias']]['type_title'] = self::get_lang_text_by_index($statistic_data['type_title']);
            $type_main_field = explode(',',$statistic_data['type_main_field']);
            $arr_main_field = $arr_redactor = $arr_main_field_str = array();
            foreach ($type_main_field as $field) {
                $field2 = str_replace('*','',$field);
                $field2 = str_replace('^','',$field2);
                if (strpos($field,'*')!== false){
                    $arr_main_field[$field2] = true;
                } else {
                    $arr_main_field[$field2] = false;
                }
                if (strpos($field,'^')!== false){
                    $arr_redactor[$field2] = true;
                } else {
                    $arr_redactor[$field2] = false;
                }
                $field = str_replace('*','',$field);
                $field = str_replace('^','',$field);
                $arr_main_field_str[$field] = $field;
            }
            $return_statistic_types['statistic-'.$statistic_data['type_alias']]['type_main_field_str'] = implode(',',$arr_main_field_str);
            $return_statistic_types['statistic-'.$statistic_data['type_alias']]['type_main_field'] = $arr_main_field;
            $return_statistic_types['statistic-'.$statistic_data['type_alias']]['visual_editor'] = $arr_redactor;
            $type_field_for_table = explode(',',$statistic_data['type_field_for_table']);
            $return_statistic_types['statistic-'.$statistic_data['type_alias']]['type_field_for_table'] = array_flip($type_field_for_table);
            $type_field_names = explode(',',$statistic_data['type_field_names']);
            $arr_field_names = array();
            foreach ($type_field_names as $field) {
                $field_name_arr = explode('=',$field);
                $arr_field_names[$field_name_arr[0]] = self::get_lang_text_by_index($field_name_arr[1]);
            }
            $return_statistic_types['statistic-'.$statistic_data['type_alias']]['type_field_names'] = $arr_field_names;
            $return_statistic_types['statistic-'.$statistic_data['type_alias']]['type_status'] = $statistic_data['type_status'];
        }

        return $return_statistic_types;
    }

    /**
     * get_statistic_by_types($type_arr,$pos=NULL,$lim=NULL)
     * @type static public
     * @description Получение списка типов контента и их свойств
     * @var $type_arr - массив данных для текущего типа
     * @param $pos number - стартовая позиция
     * @param $lim number - кол-во записей
     *
     * @return array
     * Возвращает массив списка контента с нужными полями для текущего типа
     * для текущего языка
     */
    static public function get_statistic_by_types($type_arr,$pos=NULL,$lim=NULL) {
        global $class_db;
        if (is_null($pos) || is_null($lim)){
            $limit = NULL;
        } else {
            $limit = "LIMIT $pos,$lim";
        }
        $return_statistic_types['result'] = true;
        $return_statistic_types['result_msg'] = '';
        $statistic=$class_db->select_from_table("
                    SELECT *
                    FROM order_statistic
                    WHERE order_status = $type_arr
                    ORDER BY order_date_add DESC, order_product_title
                    $limit
                ");
        if (!$statistic){
            $return_statistic_types['result'] = false;
            $return_statistic_types['result_msg'] = '{IE_1x102}';
        } else {
            $return_statistic_types['result_data'] = $statistic;
        }

        return $return_statistic_types;
    }
    /**
     * get_order_by_index($index)
     * @type static public
     * @description поиск заказа по индексу
     *
     * @param $index string индекс заказа
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function get_order_by_index($index) {
        global $class_db;
        $result['result'] = true;
        $result['result_msg'] = '{IE_0x102}';

        $res = $class_db->select_from_table("
                SELECT *
                FROM order_statistic
                WHERE order_index = '$index'
                AND order_status != -1
                LIMIT 1
        ");
        if ($res){
            $result['result_data'] = $res[0];
        } else {
            $result['result'] = false;
            $result['result_msg'] = '{IE_1x102}';
        }
        return $result;
    }
    /**
     * get_order_by_id($index)
     * @type static public
     * @description поиск заказа по id
     *
     * @param $index string индекс заказа
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function get_order_by_id($index) {
        global $class_db;
        $result['result'] = true;
        $result['result_msg'] = '{IE_0x102}';

        $res = $class_db->select_from_table("
                SELECT *
                FROM order_statistic
                WHERE order_id = '$index'
                AND order_status != -1
                LIMIT 1
        ");
        if ($res){
            $result['result_data'] = $res[0];
        } else {
            $result['result'] = false;
            $result['result_msg'] = '{IE_1x102}';
        }
        return $result;
    }
    /**
     * count_statistic_by_types($type_arr)
     * @type static public
     * @description Подсчёт кол-ва контента
     * @var $type_arr - массив данных для текущего типа
     *
     * @return number
     * Возвращает количество записей
     */
    static public function count_statistic_by_types($status) {
        global $class_db;

        $search_stat=$class_db->select_from_table("
                    SELECT *
                    FROM order_statistic
                    WHERE order_status = $status
                    ORDER BY order_date_add DESC, order_product_title
        ");
        if ($search_stat){
            return count($search_stat);
        } else {
            return 0;
        }

    }

    /**
     * get_statistic_by_id($id)
     * @type static public
     * @description Получение данных контента по id
     * @var $id number - id контента
     *
     * @return array
     * Возвращает массив данных контента с нужными полями для текущего id
     * для всех языков
     */
    static public function get_statistic_by_id($id) {
        global $class_db;
        global $field_sets;
        $res = array();
        $return_statistic_types['result'] = true;
        $return_statistic_types['result_msg'] = '';
        $statistic=$class_db->select_from_table("
                    SELECT *
                    FROM statistic
                    WHERE cont_status >= 0
                    AND cont_id = $id
                ");
        if (!$statistic){
            $return_statistic_types['result'] = false;
            $return_statistic_types['result_msg'] = '{IE_1x102}';
        } else {

            $langs_list = self::get_langs_data();
            $cur_langs = $langs_list['by_id'];
            foreach ($statistic[0] as $cont_key=> $statistic_data) {
                if ($field_sets[$cont_key]['save_place']==1){
                    $res[$cont_key] = $statistic_data;
                } else {
                    foreach ($cur_langs as $cur_lang_id=>$cur_lang_data) {
                        $lang_val = self::get_lang_text_by_index("{$cont_key}[{$id}]",$cur_lang_id);
                        if (strpos($lang_val,"{$cont_key}[{$id}]")) {
                            $lang_val = "";
                        }
                        $res[$cont_key][$cur_lang_id]=$lang_val;
                    }
                }
            }
        }
        $return_statistic_types['result_data'] = $res;
        return $return_statistic_types;
    }

    /**
     * change_statistic_status($data_array)
     * @type static public
     * @description Изменение статуса контента
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function change_statistic_status($data_array) {
        global $class_db;
        $return['result'] = $rr = true;
        $return['result_msg'] = '{IE_0x103}';

        foreach ($data_array as $cont_id => $cont_data) {
            $add_res = $class_db->insert_array_to_table('order_statistic',$cont_data,'order_id',$cont_id);
            if (!$add_res) {
                $rr = false;
            }
        }
        if (!$rr) {
            $return['result'] = false;
            $return['result_msg'] = '{IE_2x103}';
        }
        return $return;
    }


    /**
     * update_statistic($data_array)
     * @type static public
     * @description Изменение  контента
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function update_statistic($data_array) {
        global $class_db;
        $return['result'] = $rr = true;
        $return['result_msg'] = '{IE_0x100}';

        $statistic_arr  = $data_array['statistic'];
        $cont_id = $statistic_arr['cont_id'];
        $add_res = $class_db->insert_array_to_table('statistic',$statistic_arr,'cont_id',$cont_id);
        if (!$add_res) {
            $rr = false;
        }

        if (isset($data_array['lang_texts'])){
            $lang_texts_arr = $data_array['lang_texts'];
            foreach ($lang_texts_arr as $text_index => $text_data) {
                foreach ($text_data as $lang_id => $text_statistic) {
                    $add_res = self::set_lang_text($text_index,$lang_id,$text_statistic);
                    if (!$add_res) {
                        $rr = false;
                    }
                }
            }
        }
        if (!$rr) {
            $return['result'] = false;
            $return['result_msg'] = '{IE_2x100}';
        }
        return $return;
    }

    /**
     * get_statistic_with_active_sliders($dop_statistic=array(),$cont_type=1)
     * @type static public
     * @description Возвращаем контент в котором присутсвуют слайдеры
     *
     * @var $dop_statistic  (массив дополнительного контента)
     * @var $cont_type number (тип контента, по-умолчанию 1 - страницы)
     *
     * @return array
     * Возвращает массив с url контента
     */
    static public function get_statistic_with_active_sliders($dop_statistic=array(),$cont_type=1) {
        global $class_db;

        $return_statistic['result'] = true;
        $return_statistic['result_msg'] = '';
        $return_statistic['result_data'] = array();
        if (count($dop_statistic)>0){
            foreach ($dop_statistic as $statistic) {
                $return_statistic['result_data'][] = $statistic;
            }
        }
        $cont_pages=$class_db->select_from_table("
                    SELECT cont_url
                    FROM statistic
                    WHERE cont_type = {$cont_type} AND cont_show_slider = 1 AND cont_status > 0
                    ORDER BY cont_url
        ");
        if (!$cont_pages && count($return_statistic['result_data'])==0){
            $return_statistic['result'] = false;
            $return_statistic['result_msg'] = '{IE_2x102}';
        } else {
            foreach ($cont_pages as $value) {
                $return_statistic['result_data'][] = $value['cont_url'];
            }
        }
        return $return_statistic;
    }
}