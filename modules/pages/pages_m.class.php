<?php
/**
 * pages_m.class.php (front)
 *
 * Класс модели страниц для внешней части сайта
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

class pages_m extends global_m
{
    /**
     * get_content_types()
     * @type static public
     * @description Получение списка типов контента и их свойств
     *
     * @return array
     * Возвращает одномерный массив списка типов
     * для текущего языка
     */
    static public function get_content_types() {
        global $class_db;
        $content_types=$class_db->select_from_table("
							SELECT *
							FROM content_types
							WHERE type_status >= 0
						");

        $return_content_types = array();
        foreach ($content_types as $content_data) {
            $return_content_types['content-'.$content_data['type_alias']]['type_id'] = $content_data['type_id'];
            $return_content_types['content-'.$content_data['type_alias']]['type_title'] = self::get_lang_text_by_index($content_data['type_title']);
            $type_main_field = explode(',',$content_data['type_main_field']);
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
            $return_content_types['content-'.$content_data['type_alias']]['type_main_field_str'] = implode(',',$arr_main_field_str);
            $return_content_types['content-'.$content_data['type_alias']]['type_main_field'] = $arr_main_field;
            $return_content_types['content-'.$content_data['type_alias']]['visual_editor'] = $arr_redactor;
            $type_field_for_table = explode(',',$content_data['type_field_for_table']);
            $return_content_types['content-'.$content_data['type_alias']]['type_field_for_table'] = array_flip($type_field_for_table);
            $type_field_names = explode(',',$content_data['type_field_names']);
            $arr_field_names = array();
            foreach ($type_field_names as $field) {
                $field_name_arr = explode('=',$field);
                $arr_field_names[$field_name_arr[0]] = self::get_lang_text_by_index($field_name_arr[1]);
            }
            $return_content_types['content-'.$content_data['type_alias']]['type_field_names'] = $arr_field_names;
            $return_content_types['content-'.$content_data['type_alias']]['type_status'] = $content_data['type_status'];
        }

        return $return_content_types;
    }
	
    /**
     * get_content_by_id($id)
     * @type static public
     * @description Получение данных контента по id
     * @var $id number - id контента
     *
     * @return array
     * Возвращает массив данных контента с нужными полями для текущего id
     * для всех языков
     */
    /*static public function get_content_by_id($id) {
        global $class_db;
        global $field_sets;
        $res = array();
        $return_content_types['result'] = true;
        $return_content_types['result_msg'] = '';
        $content=$class_db->select_from_table("
                    SELECT *
                    FROM content
                    WHERE cont_status >= 0
                    AND cont_id = $id
                ");
        if (!$content){
            $return_content_types['result'] = false;
            $return_content_types['result_msg'] = '{IE_1x102}';
        } else {

            $langs_list = self::get_langs_data();
            $cur_langs = $langs_list['by_id'];
            foreach ($content[0] as $cont_key=> $content_data) {
                if ($field_sets[$cont_key]['save_place']==1){
                    $res[$cont_key] = $content_data;
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
		
        $return_content_types['result_data'] = $res;
        return $return_content_types;
    }*/
}