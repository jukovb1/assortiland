<?php
/**
 * statistic_c.class.php (admin)
 *
 * Класс контроллера модуля контента
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
class statistic_c
{
    /**
     * statistic_save_prepare($posted_ar)
     * @type static public
     * @description Проверка передаваямых данных перед сохранением
     *
     * @return array
     * Возвращает одномерный массив списка групп
     * для текущего языка
     */
    static public function statistic_save_prepare($posted_ar) {
        global $current_type,$field_sets,$_cur_area;
        $type_main_field = $current_type['type_main_field'];
        $field_data_id = (isset($posted_ar['cont_id']))?intval($posted_ar['cont_id']):0;
        $result['result'] = true;
        $result['result_msg'] = '';
        foreach ($posted_ar as $field_name => $field_data) {
            if ($field_name != "cont_id"
                && $field_name != "cont_type"
                && $type_main_field[$field_name] == true){
                // проверяем обязательные поля
                if (!is_array($field_data)){
                    // моноязычные поля
                    $field_data = trim($field_data);
                    if (empty($field_data)) {
                        $result['result'] = false;
                        $result['result_msg'] = '{IE_2x101}';
                    }
                    if ($field_name == "cont_url"){
                        $isset_url = statistic_m::check_url($_cur_area,$field_data,$field_data_id);
                        if (!$isset_url["result"]) {
                            $result['result'] = false;
                            $result['result_msg'] = $isset_url['result_msg'];
                        }
                    }

                } else {
                    // мультиязычные поля
                    foreach($field_data as $fd){
                        $fd = trim($fd);
                        if (empty($fd)) {
                            $result['result'] = false;
                            $result['result_msg'] = '{IE_2x101}';
                        }
                    }
                }
            }
        }
        if (!$result['result']){
            return $result;
        }else{
            global $class_db;
            // создаём новый контент и сразу получаем его id
            if (!isset($posted_ar['cont_id'])){
                $rnd = "new_".rand(1,100000);
                $cur_id=$class_db->insert_array_to_table('statistic',array('cont_url'=>$rnd));
                $result['result_data']['statistic']['cont_id'] = $cur_id;
            } else {
                $cur_id = intval($posted_ar['cont_id']);
            }

            foreach ($posted_ar as $field_name => $field_data) {
                if (!is_array($field_data)){
                    // моноязычные поля
                    if ($field_sets[$field_name]['type'] == 'num'
                        || $field_sets[$field_name]['type'] == 'select'
                        || $field_sets[$field_name]['type'] == 'bool') {
                        $result['result_data']['statistic'][$field_name] = intval($field_data);
                    } elseif ($field_sets[$field_name]['type'] == 'date') {
                        $result['result_data']['statistic'][$field_name] = str_replace('T',' ',$field_data).":00";
                    } else{
                        $result['result_data']['statistic'][$field_name] = mysql_real_escape_string($field_data);
                    }
                } else {
                    // мультиязычные поля
                    $result['result_data']['statistic'][$field_name] = $field_name."[$cur_id]";
                    foreach ($field_data as $lang_id => $field_data_to_lang_text) {
                        $result['result_data']['lang_texts'][$field_name."[$cur_id]"][$lang_id] = trim(stripcslashes($field_data_to_lang_text));
                    }
                }
            }
        }
        return $result;
    }


}
