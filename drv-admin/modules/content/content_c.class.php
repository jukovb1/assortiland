<?php
/**
 * content_c.class.php (admin)
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
class content_c
{
    /**
     * content_save_prepare($posted_ar)
     * @type static public
     * @description Проверка передаваямых данных перед сохранением
     *
     * @return array
     * Возвращает одномерный массив списка групп
     * для текущего языка
     */
    static public function content_save_prepare($posted_ar,$files_ar) {
        global $current_type,$field_sets,$_cur_area;
        $type_main_field = $current_type['type_main_field'];
        $field_data_id = (isset($posted_ar['cont_id']))?intval($posted_ar['cont_id']):0;
        $result['result'] = true;
        $result['result_msg'] = '';
        foreach ($posted_ar as $field_name => $field_data) {
            if (($field_name != "cont_id"
                && $field_name != "cont_type"
                && $type_main_field[$field_name] == true)
                && ($field_name == "cont_files" && !isset($files_ar["cont_files"]))
                ){
                // проверяем обязательные поля
                if (!is_array($field_data)){
                    // моноязычные поля
                    $field_data = trim($field_data);
                    if (empty($field_data)) {
                        $result['result'] = false;
                        $result['result_msg'] = '{IE_2x101}';
                    }
                    if ($field_name == "cont_url"){
                        $isset_url = content_m::check_url($_cur_area,$field_data,$field_data_id);
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
                $cur_id=$class_db->insert_array_to_table('content',array('cont_url'=>$rnd));
                $result['result_data']['content']['cont_id'] = $cur_id;
            } else {
                $cur_id = intval($posted_ar['cont_id']);
            }

            foreach ($posted_ar as $field_name => $field_data) {
                if (!is_array($field_data)){
                    // моноязычные поля
                    if ($field_sets[$field_name]['type'] == 'num'
                        || $field_sets[$field_name]['type'] == 'select'
                        || $field_sets[$field_name]['type'] == 'bool') {
                        $result['result_data']['content'][$field_name] = intval($field_data);
                    } elseif ($field_sets[$field_name]['type'] == 'date') {
                        $result['result_data']['content'][$field_name] = str_replace('T',' ',$field_data).":00";
                    } else{
                        $result['result_data']['content'][$field_name] = mysql_real_escape_string($field_data);
                    }
                } else {
                    // мультиязычные поля
                    $result['result_data']['content'][$field_name] = $field_name."[$cur_id]";
                    foreach ($field_data as $lang_id => $field_data_to_lang_text) {
                        $result['result_data']['lang_texts'][$field_name."[$cur_id]"][$lang_id] = trim(stripcslashes($field_data_to_lang_text));
                    }
                }
            }
        }

        if (!empty($files_ar)){
            $files_field = "cont_files";
            $accept = 'image/jpeg,image/jpg,image/png,image/gif';
            //foreach($files_ar[$files_field]['name'] as $param_id_file => $NA) {

                if (!is_null($accept)){
                    $current_file_types = explode(',',$accept);
                } else {
                    global $current_file_types;
                }
                $current_file_ext_arr = array();
                foreach($current_file_types as $ext){
                    $ext_a = explode('/',$ext);
                    $cur_ext = ($ext_a[1]=='jpeg')?"jpeg,jpg":$ext_a[1];
                    $current_file_ext_arr[] = $cur_ext;
                }
                $current_file_ext = implode(', ',$current_file_ext_arr);

                if (!empty($files_ar[$files_field]['name'])) {

                    $name = $files_ar[$files_field]['name'];//[$param_id_file];
                    $type = $files_ar[$files_field]['type'];//[$param_id_file];
                    $size = $files_ar[$files_field]['size'];//[$param_id_file];
                    $tmp_name = $files_ar[$files_field]['tmp_name'];//[$param_id_file];
                    $error = $files_ar[$files_field]['error'];//[$param_id_file];

                    if (!empty($name)) {
                        $temp_ar_name = explode('.',$name);
                        $exist = end($temp_ar_name);
                        $md5_name = md5_file($tmp_name).".".$exist;
                        if ($error != 4 && $error != 0) {
                            $result["result"] = false;
                            $result["result_msg"] = "{FS_10$error}";
                        } else {
                            if (array_search($type,$current_file_types)===false) {
                                $result["result"] = false;
                                $result["result_msg"] = "{FS_105}::{:EXTENSIONS:}=$current_file_ext";
                            } elseif ($size >= 10000000) {
                                $result["result"] = false;
                                $result["result_msg"] = "{FS_109}";
                            } else {
                                $dir_name = "adm_dop_files/upload_files_content";
                                $path = "/$dir_name/";//"http://".$_SERVER['HTTP_HOST']."/$dir_name/";
                                $move_files = $_SERVER['DOCUMENT_ROOT']."/$dir_name/$md5_name";
                                $move_status = move_uploaded_file($tmp_name, $move_files);

                                if (!$move_status) {
                                    $result["result"] = false;
                                    $result["result_msg"] = "{FS_110}";
                                } else {
                                    $result["result_data"]["content"][$files_field]=$path.$md5_name;
                                }
                            }
                        }
                    }
                    unset($name);
                    unset($type);
                    unset($size);
                    unset($tmp_name);
                    unset($error);
                }
            //}
        }
        return $result;
    }


}
