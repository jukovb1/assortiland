<?php
/**
 * options_m.class.php (admin)
 *
 * Класс модели модуля парамеры
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
class options_m extends global_m
{
    /**
     * get_constants_groups()
     * @type static public
     * @description Получение списка групп констант
     *
     * @return array
     * Возвращает одномерный массив списка групп
     * для текущего языка
     */
    static public function get_constants_groups() {
        global $class_db;
        $constants_group=$class_db->select_from_table("
							SELECT *
							FROM constants_groups
						");

        $return_const = array();
        foreach ($constants_group as $const_data) {
            $return_const[$const_data['const_group_alias']]['group_id'] = $const_data['const_group_id'];
            $return_const[$const_data['const_group_alias']]['group_name'] = self::get_lang_text_by_index($const_data['const_group_name']);

        }
        return $return_const;
    }


    /**
     * get_constants_data_for_adm($group_id)
     * @type static public
     * @description Получение списка констант по группе
     *
     * @param $group_id number (id группы констант)(example: 1)
     * @return array
     * Возвращает одномерный массив констант выбранной группы
     * для текущего языка
     */
    static public function get_constants_data_for_adm($group_id) {
        global $class_db;
        $langs_list = self::get_langs_data();
        $cur_langs = $langs_list['by_id'];

        $constants=$class_db->select_from_table("
							SELECT *
							FROM constants
							WHERE const_group=$group_id
							ORDER BY const_sort ASC, const_id ASC
						");
        $return_const = array();

        foreach ($constants as $const_data) {
            $return_const[$const_data['const_alias']]['const_id']       = $const_data['const_id'];
            $return_const[$const_data['const_alias']]['const_type']     = $const_data['const_type'];
            $return_const[$const_data['const_alias']]['const_alias']    = $const_data['const_alias'];
            $return_const[$const_data['const_alias']]['const_name']     = self::get_lang_text_by_index($const_data['const_name']);
            if($const_data['const_type']==1 || $const_data['const_type']==11){
                $return_const[$const_data['const_alias']]['const_value']=$const_data['const_num_val'];
            }elseif($const_data['const_type']>20 && $const_data['const_type']<30){
                $return_const[$const_data['const_alias']]['const_value']=$const_data['const_txt_val'];
            }else {
                $return_const[$const_data['const_alias']]['const_value']['index']=$const_data['const_str_val'];
                foreach ($cur_langs as $cur_lang_id=>$cur_lang_data) {
                    $lang_val = self::get_lang_text_by_index($const_data['const_str_val'],$cur_lang_id);
                    if (strpos($lang_val,$const_data['const_str_val'])) {
                        $lang_val = "";
                    }
                    $return_const[$const_data['const_alias']]['const_value'][$cur_lang_id]=stripcslashes($lang_val);
                }
            }
        }
        return $return_const;
    }

    /**
     * update_constants($data_array)
     * @type static public
     * @description Изменение констант
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function update_constants($data_array) {
        global $class_db;
        $return['result'] = $rr = true;
        $return['result_msg'] = '{IE_0x100}';

        $constants_arr  = $data_array['constants'];


        foreach ($constants_arr as $const_id => $const_data) {
            $alt_add_res = true;
            if ($const_id==26){
                // сохранение в params_options
                $new_delivery_arr = explode(',',$const_data['const_txt_val']);
                if (count($new_delivery_arr)>0){
                    foreach ($new_delivery_arr as $delivery_name){
                        $delivery_name = trim($delivery_name);
                        if (!empty($delivery_name)){
                            $delivery_arr['param_id'] = 17;
                            $delivery_arr['option_str_val'] = $delivery_name;
                            $alt_add_res = $class_db->insert_array_to_table('params_options',$delivery_arr);
                            unset ($delivery_arr);
                        }
                    }
                }
                $const_data['const_txt_val'] = '';
            }
            $add_res = $class_db->insert_array_to_table('constants',$const_data,'const_id',$const_id);
            if (!$add_res || !$alt_add_res) {
                $rr = false;
            }
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
}
