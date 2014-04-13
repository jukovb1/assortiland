<?php
/**
 * adm_users_c.class.php (admin)
 *
 * Класс контроллера модуля пользователей
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
class adm_users_c
{
    /**
     * group_data_save_prepare($posted_ar)
     * @type static public
     * @description Проверка передаваямых данных перед сохранением
     *
     * @return array
     * Возвращает одномерный массив списка групп
     * для текущего языка
     */
    static public function group_data_save_prepare($posted_ar) {
        global $_cur_area;

        $result['result'] = true;
        $result['result_msg'] = '';
        foreach ($posted_ar as $field_name => $field_data) {
            if ($field_name != "us_group_id"){
                if (is_array($field_data)){
                    $field_data_arr = $field_data;
                    unset($field_data);
                    foreach ($field_data_arr as $lang_id => $fd) {
                        $fd = trim($fd);
                        if ($field_name == "us_group_title" && empty($fd)){
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
            if (!isset($posted_ar['us_group_id'])){
                $rnd = "new_".rand(1,100000);
                $cur_id=$class_db->insert_array_to_table('users_groups',array('us_group_title'=>$rnd));
                $result['result_data']['users_groups']['us_group_id'] = $cur_id;
            } else {
                $cur_id = intval($posted_ar['us_group_id']);
            }

            foreach ($posted_ar as $field_name => $field_data) {
                if (!is_array($field_data)){
                    // моноязычные поля
                    $result['result_data']['users_groups'][$field_name] = mysql_real_escape_string($field_data);
                } else {
                    // мультиязычные поля
                    $result['result_data']['users_groups'][$field_name] = $field_name."[$cur_id]";
                    foreach ($field_data as $lang_id => $field_data_to_lang_text) {
                        $result['result_data']['lang_texts'][$field_name."[$cur_id]"][$lang_id] = trim(stripcslashes($field_data_to_lang_text));
                    }
                }
            }
        }
        return $result;
    }




    /**
     * user_data_save_prepare($posted_ar,$fields_set,$fields_validation,$fd=false)
     * @type static public
     * @description Проверка передаваямых данных перед сохранением
     *
     * @param $posted_ar array Массив $_POST
     * @param $fields_set array - набор полей
     * @param $fields_validation array - образец для проверки
     * @param $fd boolean - дополнительные данные
     *
     * @return array
     */
    static public function user_data_save_prepare($posted_ar,$fields_set,$fields_validation,$fd=false) {
        $result['result'] = true;
        $result['result_msg'] = '';
        if ($fd==false){
            $field_data_id = intval($posted_ar['user_id']);
            if ($field_data_id==0){
                $field_data_id = 'new';
                $result['result_data']['user_date_add'] = date('Y-m-d H:i:s');
            }
            $result['result_data']['user_date_edit'] = date('Y-m-d H:i:s');
            $result['result_data']['user_id'] = $field_data_id;

            if (isset($posted_ar['user_login'])) {
                if (empty($posted_ar['user_login'])){
                    $result['result'] = false;
                    $result['result_msg'] = '{IE_2x101}';
                } else {
                    // проверка уникальности логина
                    $field_login = mysql_real_escape_string($posted_ar['user_login']);
                    $result['result_data']['user_login'] = $field_login;
                    unset($posted_ar['user_login']);
                    $isset_article = adm_users_m::check_login($field_login,$field_data_id);
                    if (!$isset_article["result"]) {
                        $result['result'] = false;
                        $result['result_msg'] = $isset_article['result_msg'];
                    }
                }

            } 
        }
        

        foreach ($fields_set as $field_name => $na) {
            $space_field = false;
            if (isset($fields_validation[$field_name]) && isset($posted_ar[$field_name])){
                if (isset($fields_validation[$field_name]['required']) && empty($posted_ar[$field_name])){
                    $result['result'] = false;
                    $result['result_msg'] = '{IE_2x101}';
                }
                $min = (isset($fields_validation[$field_name]['min']))?$fields_validation[$field_name]['min']:NULL;
                $max = (isset($fields_validation[$field_name]['max']))?$fields_validation[$field_name]['max']:NULL;
                $size = "{$min},{$max}";
                $pattern = NULL;

                if ($fields_validation[$field_name]['type']==2
                    || $fields_validation[$field_name]['type']==4
                    || $fields_validation[$field_name]['type']==5){
                    $pattern = (!is_null($min)||!is_null($max))?"/^[0-9]{{$size}}$/":NULL;
                    $val = intval($posted_ar[$field_name]);
                } elseif ($fields_validation[$field_name]['type']==3){
                    $pattern = (!is_null($min)||!is_null($max))?"/^[\s\d\w,.]{{$size}}$/":NULL;
                    $val = mysql_real_escape_string($posted_ar[$field_name]);
                    if ($field_name=='user_pass'){
                        if (!empty($posted_ar[$field_name])
                            && $posted_ar[$field_name]!=$posted_ar['user_pass_confirm']){
                            $result['result'] = false;
                            $result['result_msg'] = '{IE_3x102}';
                        } elseif (empty($posted_ar[$field_name])) {
                            $space_field = true;
                        } else {
                            $val = md5($posted_ar[$field_name]);
                        }
                    }
                } elseif ($fields_validation[$field_name]['type']==7){
                    $val = trim($posted_ar[$field_name]);
                } else {
                    $val = $posted_ar[$field_name];
                }
                if (!is_null($pattern) && preg_match("$pattern",$val)===false) {
                    $result['result'] = false;
                    $result['result_msg'] = $fields_validation[$field_name]['err'];
                }

                if (!$space_field){
                    $result['result_data'][$field_name] = $val;
                }

            } elseif($field_name=='full_data'){
                $tmp_full_data = self::user_data_save_prepare($posted_ar,$fields_set['full_data'],$fields_validation,true);
                if ($tmp_full_data['result']==false){
                    $result['result'] = false;
                    $result['result_msg'] = $tmp_full_data['result_msg'];
                } else {
                    $result['result_data'][$field_name] = $tmp_full_data['result_data'];
                }

            }
        }
        return $result;
    }


}
