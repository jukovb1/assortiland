<?php
/**
 * options_c.class.php (admin)
 *
 * Класс контроллера модуля парамеры
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
class options_c
{
    /**
     * params_save_prepare()
     * @type static public
     * @description Проверка передаваямых данных перед сохранением
     *
     * @return array
     * Возвращает одномерный массив списка групп
     * для текущего языка
     */
    static public function params_save_prepare($posted_ar) {
        global $cur_group_id;
        $field_info = options_m::get_constants_data_for_adm($cur_group_id);

        $result = array();
        $result['result'] = true;
        $result['result_msg'] = '';

        foreach ($posted_ar as $field_name => $field_data) {
            if (isset($field_info[$field_name])) {
                if ($field_info[$field_name]['const_type'] == 1 || $field_info[$field_name]['const_type'] == 11){
                    $result['result_data']['constants'][$field_info[$field_name]['const_id']]['const_num_val'] = intval($field_data);
                }elseif($field_info[$field_name]['const_type']>20 && $field_info[$field_name]['const_type']<30){
                    $result['result_data']['constants'][$field_info[$field_name]['const_id']]['const_txt_val'] = mysql_real_escape_string($field_data);
                }elseif($field_info[$field_name]['const_type']>30){
                    foreach ($field_data as $lang_id => $field_data_to_lang_text) {
                        $result['result_data']['lang_texts'][$field_info[$field_name]['const_value']['index']][$lang_id] = mysql_real_escape_string($field_data_to_lang_text);
                    }
                    $result['result_data']['constants'][$field_info[$field_name]['const_id']]['const_str_val'] = mysql_real_escape_string($field_info[$field_name]['const_value']['index']);
                }
            }
        }
        return $result;
    }


}
