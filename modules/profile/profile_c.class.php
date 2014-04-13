<?php
/**
 * profile_c.class.php (admin)
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
class profile_c
{
    /**
     * user_data_save_prepare($posted_ar,$fields_set,$fields_validation,$fd=false)
     * @type static public
     * @description Проверка передаваемых данных перед сохранением
     *
     * @param $posted_ar array Массив $_POST
     * @param $fields_set array - набор полей
     * @param $fields_validation array - образец для проверки
     * @param $fd boolean - дополнительные данные
     *
     * @return array
     */
    static public function user_data_save_prepare($posted_ar,$fields_set,$fields_validation,$fd=false) {
        global $reg_form,$show_captcha;
		
		if ($show_captcha) {
			session_start();
			global $_SESSION;
		}

        $result['result'] = true;
        $result['result_msg'] = '';
        if ($fd==false){
            if(isset($posted_ar['user_id'])){
                $field_data_id = intval($posted_ar['user_id']);
                if ($field_data_id==0){
                    $field_data_id = 'new';
                    $result['result_data']['user_date_add'] = date('Y-m-d H:i:s');
                }
                $result['result_data']['user_id'] = $field_data_id;
            } else {
                $field_data_id = 'new';
                $result['result_data']['user_date_add'] = date('Y-m-d H:i:s');
            }
            $result['result_data']['user_date_edit'] = date('Y-m-d H:i:s');

            if (isset($posted_ar['user_login'])) {
                if (empty($posted_ar['user_login'])){
                    $result['result'] = false;
                    $result['result_msg'] = '{IE_2x101}';
                } else {
                    // проверка уникальности логина
                    $field_login = mysql_real_escape_string($posted_ar['user_login']);
                    $result['result_data']['user_login'] = $field_login;
                    unset($posted_ar['user_login']);
                    $isset_article = profile_m::check_login($field_login,$field_data_id);
                    if (!$isset_article["result"]) {
                        $result['result'] = false;
                        $result['result_msg'] = $isset_article['result_msg'];
                    }
                }

            }
            if (isset($posted_ar['user_email'])) {
                if (empty($posted_ar['user_email'])){
                    $result['result'] = false;
                    $result['result_msg'] = '{IE_2x101}';
                } else {
                    // проверка уникальности логина
                    $field_email = mysql_real_escape_string($posted_ar['user_email']);
                    $result['result_data']['user_email'] = $field_email;
                    unset($posted_ar['user_email']);
                    $isset_article = profile_m::check_email($field_email,$field_data_id);
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
                if ((($field_name=='user_pass' && isset($reg_form)) || (isset($fields_validation[$field_name]['required']) && $fields_validation[$field_name]['required'])) && empty($posted_ar[$field_name])){
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
					// для региона записывает текстовое значение
					if($field_name!='user_delivery_region') {
                    	$val = intval($posted_ar[$field_name]);
					} else {
						$val = $posted_ar[$field_name];
					}
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
                    } elseif ($field_name=='captcha'){
                    	// если каптча не введена или не верна
                    	if(empty($_SESSION['captcha']) 
                    		|| trim(strtolower($posted_ar[$field_name])) != $_SESSION['captcha']) {
                    		$result['result'] = false;
							$result['result_msg'] = $fields_validation[$field_name]['err'];
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

    /**
     * user_data_save_prepare($posted_ar,$fields_set,$fields_validation,$fd=false)
     * @type static public
     * @description Подготовка массива заказа для сохранения
     *
     * @param $order_array array Массив данных из корзины
     *
     * @return array
     */
    static public function prep_array_for_order_table($order_array) {
        $prep_arr = array();

        foreach ($order_array as $i => $order_data) {
            $full_text_a = array();
            $prep_arr[$i]['order_index'] = $order_data['order_index'];
            $prep_arr[$i]['order_user_id'] = $order_data['buyer_info']['user_id'];
            $prep_arr[$i]['order_owner_user_id'] = $order_data['product_owner'];
            $prep_arr[$i]['order_partner_user_id'] = $order_data['product_partner'];
            $prep_arr[$i]['order_product_title'] = $order_data['product_title'];
            $prep_arr[$i]['order_product_article'] = $order_data['product_article'];
            $prep_arr[$i]['order_product_price'] = $order_data['product_price'];
            $prep_arr[$i]['order_product_count'] = $order_data['product_count'];
            $prep_arr[$i]['order_product_customer_percent'] = $order_data['product_percents'];
            $prep_arr[$i]['order_date_add'] = date("Y-m-d H:i:s");

            $full_text_a[] = "<h5>Покупатель</h5> ";
            $full_text_a[] = "ФИО: {$order_data['buyer_info']['user_fullname']}";
            $full_text_a[] = "E-mail: {$order_data['buyer_info']['user_email']}";
            $full_text_a[] = "Телефон: {$order_data['buyer_info']['user_phone']}";
            $full_text_a[] = "Адрес: {$order_data['buyer_info']['user_address']}";
            $full_text_a[] = " ";
            $full_text_a[] = " ";
            $full_text_a[] = "<h5>Заказ</h5> ";
            $full_text_a[] = "Артикул: {$order_data['product_article']}";
            $full_text_a[] = "Название: {$order_data['product_title']}";
            $full_text_a[] = "Цена: {$order_data['product_price']}";
            $full_text_a[] = "Кол-во: {$order_data['product_count']}";
            $total_price = $order_data['product_price'] * $order_data['product_count'];
            $full_text_a[] = "Стоимость: {$total_price}";
            $full_text_a[] = "Доставка: {$order_data['product_delivery']}";
            $full_text_a[] = "Примечание к доставке: {$order_data['product_delivery_info']}";
            if(isset($order_data['product_delivery_region']) && strlen($order_data['product_delivery_region'])>0) {
            	$full_text_a[] = "Регион доставки: {$order_data['product_delivery_region']}";
			}

            $prep_arr[$i]['order_fulltext'] = implode(" <br>",$full_text_a);

        }
        return $prep_arr;
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
        global $auth_class,$content_by_id_data;

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
        $result['result_data']['products'][$field_data_id]['product_user_id'] = $auth_class->cur_user_id;
        $result['result_data']['products'][$field_data_id]['product_date'] = date('Y-m-d H:i:s');

        if ($field_data_spec_id==0){
            $field_data_spec_id = 'new';
        }
        $result['result_data']['products'][$field_data_id]['specs'][$field_data_spec_id] = $field_data_spec_id;


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
				
				foreach($files_ar["product_edit_param"]['name'][$param_id_file] as $file_index=>$file_value) {
	                $name = $files_ar["product_edit_param"]['name'][$param_id_file][$file_index];
	                $type = $files_ar["product_edit_param"]['type'][$param_id_file][$file_index];
	                $size = $files_ar["product_edit_param"]['size'][$param_id_file][$file_index];
	                $tmp_name = $files_ar["product_edit_param"]['tmp_name'][$param_id_file][$file_index];
	                $error = $files_ar["product_edit_param"]['error'][$param_id_file][$file_index];
	
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
	                                $result["result_data"]["specs"][$field_data_spec_id]["params"][$param_id_file][$file_index]["param_file_name"]=$md5_name;
	                                $result["result_data"]["specs"][$field_data_spec_id]["params"][$param_id_file][$file_index]["param_file_name_real"]=$name;
	                                $result["result_data"]["specs"][$field_data_spec_id]["params"][$param_id_file][$file_index]["param_file_path"]=$path;
	                                $result["result_data"]["specs"][$field_data_spec_id]["params"][$param_id_file][$file_index]["spec_id"]=$field_data_spec_id;
	                                $result["result_data"]["specs"][$field_data_spec_id]["params"][$param_id_file][$file_index]["param_id"]=$param_id_file;
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
				
				// проверяем порядок сортировки
				$files_order = strlen($posted_ar['product_order_edit_param'][$param_id_file])>0?explode(',',$posted_ar['product_order_edit_param'][$param_id_file]):0;
				if($files_order!=0 && is_array($files_order)) {
					// формируем отсортированные данные массива файлов
					$result_temp = $result["result_data"]["specs"][$field_data_spec_id]["params"][$param_id_file];
					$result["result_data"]["specs"][$field_data_spec_id]["params"][$param_id_file] = array();
					
					foreach($files_order as $index=>$index_val) {
						if(isset($result_temp[$index_val])) {
							$result_temp[$index_val]['param_sort'] = $index;
							$result["result_data"]["specs"][$field_data_spec_id]["params"][$param_id_file][] = $result_temp[$index_val];
						}
					}
					
					unset($result_temp);
				}
            }
        }
        return $result;
    }


}
