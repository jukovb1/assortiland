<?php
/**
 * adm_products_c.class.php (admin)
 *
 * Класс контроллера модуля товаров
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
class adm_products_c
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
        $field_data_id = (isset($posted_ar['group_id']))?intval($posted_ar['group_id']):0;
        foreach ($posted_ar as $field_name => $field_data) {
            if ($field_name != "group_id"){
                $field_data = trim($field_data);
                $result['result_data'][$field_name] = $field_data;
                if ($field_name == "group_full_name"
                    || $field_name == "group_short_name"){

                    if (empty($field_data)) {
                        $result['result'] = false;
                        $result['result_msg'] = '{IE_2x101}';
                    }
                    if ($field_name == "group_short_name"){
                        $isset_url = adm_products_m::check_url($_cur_area,$field_data,$field_data_id);
                        if (!$isset_url["result"]) {
                            $result['result'] = false;
                            $result['result_msg'] = $isset_url['result_msg'];
                        }
                    }
                }

            } else {
                $field_data = intval($field_data);
                $result['result_data'][$field_name] = $field_data;
            }
        }

        return $result;
    }

    /**
     * product_data_save_prepare($posted_ar,$files_ar)
     * @type static public
     * @description Проверка передаваямых данных перед сохранением
     *
     * @var $posted_ar array Массив $_POST
     * @var $files_ar array Массив $_FILES
     *
     * @return array
     */
    static public function product_data_save_prepare($posted_ar,$files_ar) {
        global $class_db,$content_by_id_data;

        $params = $content_by_id_data['result_data']['params'];
        $result['result_data']['params'] = $params;
        $result['result'] = true;
        $result['result_msg'] = '';
        $field_data_id = intval($posted_ar['product_id']);
        $field_data_spec_id = intval($posted_ar['spec_id']);
        if ($field_data_id==0){
            $field_data_id = 'new';
        }
        $result['result_data']['products'][$field_data_id]['product_id'] = $field_data_id;

        if ($field_data_spec_id==0){
            $field_data_spec_id = 'new';
        }
        $result['result_data']['products'][$field_data_id]['specs'][$field_data_spec_id] = $field_data_spec_id;

        $field_date = str_replace("T"," ",trim($posted_ar['product_date']));
        $result['result_data']['products'][$field_data_id]['product_date'] = $field_date;
        if (empty($field_date)){
            $result['result'] = false;
            $result['result_msg'] = '{IE_2x101}';
        }

        $field_user_id = intval($posted_ar['product_user_id']);
        $result['result_data']['products'][$field_data_id]['product_user_id'] = $field_user_id;
        if (empty($posted_ar['product_user_id'])){
            $result['result'] = false;
            $result['result_msg'] = '{IE_2x101}';
        }

//        $field_article = trim($posted_ar['product_article']);
//        $result['result_data']['products'][$field_data_id]['product_article'] = $field_article;
//        if (empty($posted_ar['product_article'])){
//            $result['result'] = false;
//            $result['result_msg'] = '{IE_2x101}';
//        } else {
//            // проверка уникальности артикла
//            $isset_article = adm_products_m::check_article($field_article,$field_data_id);
//            if (!$isset_article["result"]) {
//                $result['result'] = false;
//                $result['result_msg'] = $isset_article['result_msg'];
//            }
//        }
        foreach ($posted_ar['product_edit_param'] as $param_id=> $field_data) {
            if ($params[$param_id]['param_required'] && empty($field_data)){
                $result['result'] = false;
                $result['result_msg'] = '{IE_2x101}';
            } else {
                // определяемся с дополнительными проверками
                $attr_arr = (!empty($params[$param_id]['param_attr']))?explode(' ',str_replace('"','',$params[$param_id]['param_attr'])):array();
                $min = $max = NULL;
                if (count($attr_arr)>0){
                    $check_field = array();
                    foreach($attr_arr as $attr){
                        if (!empty($attr)){
                            $attr_tmp = explode('=',$attr);
                            $check_field[$attr_tmp[0]]=$attr_tmp[1];
                        }
                    }
                    if (isset($check_field['min'])){
                        $min = $check_field['min'];
                    }
                    if (isset($check_field['max'])){
                        $max = $check_field['max'];
                    }
                }

                if ($params[$param_id]['param_type']==2){
                    // цифровое
                    $field_data = intval($field_data);
                    // решение плавающей точки
                    if($params[$param_id]['param_decimal']>0){
                        // Изврат с преобразованием числа через строку не трогать!!!
                        // т.к. intval(1,16*100)=115.....
                        $aa =(string)0.1;
                        $system_delimiter = $aa[1];
                        $field_data = preg_replace('/[^\.\d]{1}/',$system_delimiter,$field_data);
                        $field_data=intval((string)($field_data*pow(10,$params[$param_id]['param_decimal'])));
                    }

                    if(!is_null($min) && $field_data<$min){
                        $result['result'] = false;
                        $result['result_msg'] = "{IE_2x102}::{:MIN:}=$min";

                    } elseif(!is_null($max) && $field_data>$max){
                        $result['result'] = false;
                        $result['result_msg'] = "{IE_2x103}::{:MAX:}=$max";

                    }else{
                        if ($field_data!=0){
                            $result['result_data']['specs'][$field_data_spec_id]['params'][$param_id]["param_number_val"]=$field_data;
                        }
                    }
                } elseif ($params[$param_id]['param_type']==3
                    || $params[$param_id]['param_type']==7){
                    // текстовое
                    $field_data = trim($field_data);
                    $field_data_length = mb_strlen($field_data,'utf-8');
                    if(!is_null($min) && $field_data_length<$min){
                        $result['result'] = false;
                        $result['result_msg'] = "{IE_2x104}::{:MIN:}=$min";

                    } elseif(!is_null($max) && $field_data_length>$max){
                        $result['result'] = false;
                        $result['result_msg'] = "{IE_2x105}::{:MAX:}=$max";

                    }else{
                        if (!empty($field_data)){
                            $result['result_data']['specs'][$field_data_spec_id]['params'][$param_id]["param_text_val"]=$field_data;
                        }
                    }

                } elseif ($params[$param_id]['param_type']==4
                    || $params[$param_id]['param_type']==5){
                    // логическое и одинарный селект
                    $field_data = intval($field_data);
                    if($field_data>0){
                        $result['result_data']['specs'][$field_data_spec_id]['params'][$param_id]["option_id"]=$field_data;
                    }

                } elseif ($params[$param_id]['param_type']==6){
                    // множественный селект
                    if (count($field_data)>0){
                        $multy[$param_id] = true;
                        foreach($field_data as $v){
                            $v = intval($v);
                            if($field_data>0){
                                $result['result_data']['specs'][$field_data_spec_id]['params'][$param_id][$v]["option_id"]=$v;
                                $result['result_data']['specs'][$field_data_spec_id]['params'][$param_id][$v]["spec_id"]=$field_data_spec_id;
                                $result['result_data']['specs'][$field_data_spec_id]['params'][$param_id][$v]["param_id"]=$param_id;
                            }
                        }
                    }
                }

                if(!isset($multy[$param_id])
                    && isset($result['result_data']['specs'][$field_data_spec_id]['params'][$param_id])){
                    $result['result_data']['specs'][$field_data_spec_id]['params'][$param_id]["spec_id"]=$field_data_spec_id;
                    $result['result_data']['specs'][$field_data_spec_id]['params'][$param_id]["param_id"]=$param_id;
                }

            }
        }

        foreach($files_ar["product_edit_param"]['name'] as $param_id_file => $NA) {
            
            $files_attr_arr = (!empty($params[$param_id_file]['param_attr']))?explode(' ',str_replace('"','',$params[$param_id_file]['param_attr'])):array();
            $accept = NULL;
            if (count($files_attr_arr)>0){
                $check_field2 = array();
                foreach($files_attr_arr as $attr){
                    if (!empty($attr)){
                        $attr_tmp = explode('=',$attr);
                        $check_field2[$attr_tmp[0]]=$attr_tmp[1];
                    }
                }
                if (isset($check_field2['accept'])){
                    $accept = $check_field2['accept'];
                }
                // todo ash-0 могут быть другие условия (аттрибуты), потом можно дописать
            }
            
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

            //todo (Готово) Проверка загружаемого файла param_file_name
            //pdf 10mb md5 от имени (в папку)
            if (!empty($files_ar["product_edit_param"]['name']) && $params[$param_id_file]['param_type']==8) {
                $name = $files_ar["product_edit_param"]['name'][$param_id_file];
                $type = $files_ar["product_edit_param"]['type'][$param_id_file];
                $size = $files_ar["product_edit_param"]['size'][$param_id_file];
                $tmp_name = $files_ar["product_edit_param"]['tmp_name'][$param_id_file];
                $error = $files_ar["product_edit_param"]['error'][$param_id_file];

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
                            $dir_name = "adm_dop_files/upload_files_object";
                            $path = "/$dir_name/";//"http://".$_SERVER['HTTP_HOST']."/$dir_name/";
                            $move_files = $_SERVER['DOCUMENT_ROOT']."/$dir_name/$md5_name";
                            $move_status = move_uploaded_file($tmp_name, $move_files);

                            if (!$move_status) {
                                $result["result"] = false;
                                $result["result_msg"] = "{FS_110}";
                            } else {

                                $result["result_data"]["specs"][$field_data_spec_id]["params"][$param_id_file]["param_file_name"]=$md5_name;
                                $result["result_data"]["specs"][$field_data_spec_id]["params"][$param_id_file]["param_file_name_real"]=$name;
                                $result["result_data"]["specs"][$field_data_spec_id]["params"][$param_id_file]["param_file_path"]=$path;
                                $result["result_data"]["specs"][$field_data_spec_id]["params"][$param_id_file]["spec_id"]=$field_data_spec_id;
                                $result["result_data"]["specs"][$field_data_spec_id]["params"][$param_id_file]["param_id"]=$param_id_file;

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
        }
        return $result;
    }


}
