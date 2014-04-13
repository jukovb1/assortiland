<?php
/**
 * content_m.class.php (admin)
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

class content_m extends global_m
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
     * get_content_by_types($type_arr,$pos=NULL,$lim=NULL)
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
    static public function get_content_by_types($type_arr,$pos=NULL,$lim=NULL) {
        global $class_db;
        if (is_null($pos) || is_null($lim)){
            $limit = NULL;
        } else {
            $limit = "LIMIT $pos,$lim";
        }
        $return_content_types['result'] = true;
        $return_content_types['result_msg'] = '';
        $content=$class_db->select_from_table("
                    SELECT cont_id,cont_status,cont_group_id,{$type_arr['type_main_field_str']}
                    FROM content
                    WHERE cont_status >= 0
                    AND cont_type = {$type_arr['type_id']}
                    ORDER BY cont_sort DESC, cont_date DESC, cont_title
                    $limit
                ");
        if (!$content){
            $return_content_types['result'] = false;
            $return_content_types['result_msg'] = '{IE_1x102}';
        } else {

            $langs_list = self::get_langs_data();
            $cur_langs = $langs_list['by_id'];

            foreach ($content as $content_data) {
                $return_content_types['result_data'][$content_data['cont_id']]['cont_id'] = $content_data['cont_id'];
                $return_content_types['result_data'][$content_data['cont_id']]['cont_status'] = $content_data['cont_status'];
                $return_content_types['result_data'][$content_data['cont_id']]['cont_group_id'] = $content_data['cont_group_id'];
                foreach ($type_arr['type_main_field'] as $field => $tmp) {
                    if(strpos($content_data[$field],'[')){
                        $field_data = array();
                        foreach ($cur_langs as $cur_lang_id=>$cur_lang_data) {
                            $lang_val = self::get_lang_text_by_index($content_data[$field],$cur_lang_id);
                            $field_data[$cur_lang_id]=$lang_val;
                        }
                    } else {
                        $field_data = $content_data[$field];
                    }
                    $return_content_types['result_data'][$content_data['cont_id']][$field] = $field_data;
                }

            }
        }

        return $return_content_types;
    }
    /**
     * count_content_by_types($type_arr)
     * @type static public
     * @description Подсчёт кол-ва контента
     * @var $type_arr - массив данных для текущего типа
     *
     * @return number
     * Возвращает количество записей
     */
    static public function count_content_by_types($type_arr) {
        global $class_db;

        $search_stat=$class_db->select_from_table("
                    SELECT *
                    FROM content
                    WHERE cont_status >= 0
                    AND cont_type = {$type_arr['type_id']}
                    ORDER BY cont_sort DESC, cont_date DESC, cont_title
        ");
        if ($search_stat){
            return count($search_stat);
        } else {
            return 0;
        }

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
    static public function get_content_by_id($id) {
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
    }

    /**
     * change_content_status($data_array)
     * @type static public
     * @description Изменение статуса контента
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function change_content_status($data_array) {
        global $class_db;
        $return['result'] = $rr = true;
        $return['result_msg'] = '{IE_0x100}';

        foreach ($data_array as $cont_id => $cont_data) {
            $add_res = $class_db->insert_array_to_table('content',$cont_data,'cont_id',$cont_id);
            if (!$add_res) {
                $rr = false;
            }
        }
        if (!$rr) {
            $return['result'] = false;
            $return['result_msg'] = '{IE_2x100}';
        }
        return $return;
    }


    /**
     * update_content($data_array)
     * @type static public
     * @description Изменение  контента
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function update_content($data_array) {
        global $class_db;
        $return['result'] = $rr = true;
        $return['result_msg'] = '{IE_0x100}';

        $content_arr  = $data_array['content'];
        $cont_id = $content_arr['cont_id'];
        $add_res = $class_db->insert_array_to_table('content',$content_arr,'cont_id',$cont_id);
        if (!$add_res) {
            $rr = false;
        }

        if (isset($data_array['lang_texts'])){
            $lang_texts_arr = $data_array['lang_texts'];
            foreach ($lang_texts_arr as $text_index => $text_data) {
                foreach ($text_data as $lang_id => $text_content) {
                    $add_res = self::set_lang_text($text_index,$lang_id,$text_content);
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
     * get_content_with_active_sliders($dop_content=array(),$cont_type=1)
     * @type static public
     * @description Возвращаем контент в котором присутсвуют слайдеры
     *
     * @var $dop_content  (массив дополнительного контента)
     * @var $cont_type number (тип контента, по-умолчанию 1 - страницы)
     *
     * @return array
     * Возвращает массив с url контента
     */
    static public function get_content_with_active_sliders($dop_content=array(),$cont_type=1) {
        global $class_db;

        $return_content['result'] = true;
        $return_content['result_msg'] = '';
        $return_content['result_data'] = array();
        if (count($dop_content)>0){
            foreach ($dop_content as $content) {
                $return_content['result_data'][] = $content;
            }
        }
        $cont_pages=$class_db->select_from_table("
                    SELECT cont_url
                    FROM content
                    WHERE cont_type = {$cont_type} AND cont_show_slider = 1 AND cont_status > 0
                    ORDER BY cont_url
        ");
        if (!$cont_pages && count($return_content['result_data'])==0){
            $return_content['result'] = false;
            $return_content['result_msg'] = '{IE_2x102}';
        } else {
            foreach ($cont_pages as $value) {
                $return_content['result_data'][] = $value['cont_url'];
            }
        }
        return $return_content;
    }
}