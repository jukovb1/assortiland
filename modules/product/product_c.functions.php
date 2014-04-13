<?php
/**
 * product_c.functions.php (front)
 *
 * Ф-ции контроллера единицы продукции из каталога
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


function get_product_data($need_data,$show_index=false){
    global $product_data,$current_product_id;

    if (isset($product_data['products'][$current_product_id][$need_data])){
        return $product_data['products'][$current_product_id][$need_data];
    } else {
        $need_data_arr = explode('|',$need_data);
        $dop_need = (isset($need_data_arr[1]))?$need_data_arr[1]:NULL;
        $param_id = intval($need_data_arr[0]);
        if (isset($product_data['params'][$param_id])){
            $return = '';
            $param_data = $product_data['params'][$param_id];
            $spec_id = current($product_data['products'][$current_product_id]['specs']);

            if($param_data["param_type"]==2){
                if(isset($product_data["specs"][$spec_id]["params"][$param_id])){
                    $return=$product_data["specs"][$spec_id]["params"][$param_id]["param_number_val"];
                } else {
                    $return=0;
                }
            }elseif($param_data["param_type"]==3 || $param_data["param_type"]==7){
                $return="";
                if(isset($product_data["specs"][$spec_id]["params"][$param_id])){
                    $return=$product_data["specs"][$spec_id]["params"][$param_id]["param_text_val"];
                }
            }elseif($param_data["param_type"]==4){
                $checked=NULL;
                if(isset($product_data["specs"][$spec_id]["params"][$param_id])
                    && $product_data["specs"][$spec_id]["params"][$param_id]['option_id']==1){
                    $return = 1;
                } else {
                    $return = 0;
                }
            }elseif($param_data["param_type"]==5){
                if(isset($product_data["specs"][$spec_id]["params"][$param_id])
                    && $product_data["specs"][$spec_id]["params"][$param_id]['option_id']!=2){
                    $select_param_id=$product_data["specs"][$spec_id]["params"][$param_id]["option_id"];
                    $val = (!empty($param_data['params_options'][$select_param_id]['option_str_long_val']))? 'option_str_long_val':'option_str_val';
                    $return = $param_data['params_options'][$select_param_id][$val];
                } else {
                    $return = '';
                }
            }elseif($param_data["param_type"]==6){
                $return = array();
                if(isset($product_data["specs"][$spec_id]["params"][$param_id]) && is_array($product_data["specs"][$spec_id]["params"][$param_id])){
                    $arr_cur_val=$product_data["specs"][$spec_id]["params"][$param_id];
                    foreach($param_data['params_options'] as $option_id => $option_data){
                        if (isset($arr_cur_val[$option_id])){
                            $val = (!is_null($dop_need) && $dop_need=='long')? 'option_str_long_val':'option_str_val';
                            $return[$option_id] = $option_data[$val];
                        }
                    }
                }
            }elseif($param_data["param_type"]==8){
                $return = '';
                if(isset($product_data["specs"][$spec_id]["params"][$param_id])){
                    $return=$product_data["specs"][$spec_id]["params"][$param_id]["param_file_path"].$product_data["specs"][$spec_id]["params"][$param_id]["param_file_name"];
                }
            }
            
            return $return;
        } else {
            return ($show_index)?"{:$need_data:}":NULL;
        }
    }
}


