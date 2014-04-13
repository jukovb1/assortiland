<?php
/**
 * users_v.groups_list.php (admin)
 *
 * Представление страницы групп товаров
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
?>

<div class="prof-right-wrap">
    <h2><?=lang_text("{seller_product_".key($friendly_url->url_command)."}")?></h2>
    <div class="edit-prof">
        <img src="/assets/images/profile/back-but.png" />
        <a href="<?= $new_url ?>"/><?=lang_text("{action_go_back}")?></a>
    </div>
    <div class="add-product-wrapper">
        <form method='post' enctype="multipart/form-data" id="add-product-form">
            <?
            $cont_data = $content_by_id_data['result_data'];
            foreach($cont_data["products"] as $obj){
                echo "<input type='hidden' name='product_id' value='{$obj["product_id"]}'>";

                // выбор группы для товара
                echo "<label class='drv-lines-label'><span style='color:#e65400'>*</span> ".lang_text('{product_edit_groups}')."</label>\r\n";
                $multiple_checkbox->set_indexes_for_branch_arr('group_id','group_parent_group','group_nesting','group_full_name');
                echo $multiple_checkbox->tree_print_final_table('select_groups','select_products_groups[]',$group_arr,$group_list_for_product[intval($obj["product_id"])],true);
                echo "<div class='show_required_text'>".lang_text("{required_text}")."</div>";
            }
            ?>

            <br>
            <?
            foreach($cont_data["products"] as $obj){
                $temp_count = count($obj["specs"]);
                foreach($obj["specs"] as $k => $spec_id){
                    echo "<input type='hidden' name='spec_id' value='{$spec_id}'>";
                }
            }
            foreach($cont_data['params'] as $param_id=>$param_data){
                $field_id = "pr_edit_param_{$param_id}";
                $required = $star = $star_text = '';
                if ($param_data['param_required']){
                    $required = 'required';
                    $star = '<span style="color:#e65400">*</span>';
                    $star_text = "<div class='show_required_text'>".lang_text("{required_text}")."</div>";
                }

				// 6 - Просмотры
				// 7 - Лайки
				// 8 - Акция (чекбокс)
				// 10 - Владелец
				// 15 - Оптовая цена
				// 16 - Количество (опт.)
				// 18 - TOP продаж
				// 11 - Индивидуальное вознаграждение (%)
				// 19 - Активировать продукт
				if($param_id != 10 && $param_id!=8 && $param_id!=6 
					&& $param_id!=7 && $param_id!=15 && $param_id!=18
					&& $param_id!=11 && $param_id!=16 && $param_id!=19) {
	                echo "<label title='".strip_tags($star_text)."' class='drv-lines-label' for='$field_id'>$star {$param_data["param_name"]}</label>\r\n";
	                echo "<small class='param_description'>{$param_data["param_description"]}</small>\r\n";
				}

                foreach($cont_data["products"] as $obj){
                    foreach($obj["specs"] as $spec_id){
                        if($param_data["param_type"]==2){
                            if(isset($cont_data["specs"][$spec_id]["params"][$param_id])){
                                $cur_val=$cont_data["specs"][$spec_id]["params"][$param_id]["param_number_val"];
                            } else {
                                $cur_val=0;
                            }
							
							// 6 - Просмотры
							// 7 - Лайки
							// 15 - Оптовая цена
							// 16 - Количество (опт.)
							// 11 - Индивидуальное вознаграждение (%)
							if($param_id!=6 && $param_id!=7 && $param_id!=15 
								&& $param_id!=11 && $param_id!=16) {
								echo "<input $required class='drv-lines' id='pr_edit_param_$param_id' name='product_edit_param[$param_id]' value='{$cur_val}' type='number' {$param_data['param_attr']}>\r\n$star_text";
							}
                        }elseif($param_data["param_type"]==3 && $param_id != 10){
                            if(isset($cont_data["specs"][$spec_id]["params"][$param_id])){
                                $cur_text=$cont_data["specs"][$spec_id]["params"][$param_id]["param_text_val"];
                            } else {
                                $cur_text='';
                            }
							
							// 12 - Преимущества
							if($param_id!=12) {
                        		echo "<input $required class='drv-lines' value='{$cur_text}' id='pr_edit_param_$param_id' name='product_edit_param[$param_id]' type='text' {$param_data['param_attr']}>\r\n$star_text";
							} else {
								echo "<div class='multiple-checkbox-line-wrapper'>";
								echo "<input $required class='drv-lines multiple-checkbox-line-hidden' value='{$cur_text}' id='pr_edit_param_$param_id' name='product_edit_param[$param_id]' type='hidden' {$param_data['param_attr']}>";
								echo "<input $required class='drv-lines multiple-checkbox-line' value='' type='text'>\r\n$star_text";
								echo "<a class='multiple-checkbox-button' href='javascript:void(0)'>".lang_text('{multiple-checkbox-button}')."</a>";
								echo "</div>";
								if(strlen($cur_text)>0){
									$selected = 'selected';
									$options = explode(',',$cur_text);
								} else {
									$selected = "";
									$options = explode(',',lang_text('{multiple-checkbox-options}'));
								}
								echo "<select class='multiple-checkbox-line-select' multiple='multiple' name='multiple-product-bests[]'>";
								foreach($options as $option) {echo "<option {$selected} value='$option'>$option</option>";}
								echo "</select>";
							}
							
                        }elseif($param_data["param_type"]==4){
                            $checked=NULL;
                            if(isset($cont_data["specs"][$spec_id]["params"][$param_id])
                                && $cont_data["specs"][$spec_id]["params"][$param_id]['option_id']==1){
                                $checked="checked='checked'";
                            }
							// 8 - чекбокс Акций
							// 18 - чекбокс TOP продаж
							// 19 - чекбокс Активировать продукт
							if($param_id!=8 && $param_id!=18 && $param_id!=19) {
                            	echo "<input $checked class='niceCheck chbx_edit' id='pr_edit_param_$param_id' name='product_edit_param[$param_id]' value='1' type='checkbox' onchange='checkbox_status(this);'  {$param_data['param_attr']}>\r\n";
                            	/*if($param_id==19) {
                            		echo "<small class='param_description_action'>".lang_text("{edit_user_reward_desc}")."</small>";
                            	}*/
								echo "<input class='chbx_input' hidden type='number' name='product_edit_param[{$param_id}]' value='".((!is_null($checked))?"1":"0")."'>";
                        	}
                        ?>
                        <?
                        }elseif($param_data["param_type"]==5){
                            $cur_val=0;
                            if(isset($cont_data["specs"][$spec_id]["params"][$param_id])
                                && $cont_data["specs"][$spec_id]["params"][$param_id]['option_id']!=2){
                                $cur_val=$cont_data["specs"][$spec_id]["params"][$param_id]["option_id"];
                            }

                            echo "<select $required id='pr_edit_param_$param_id' name='product_edit_param[$param_id]' class='wid100' {$param_data['param_attr']}>\r\n";
                            ?>
                            <option value=0>--NA--</option>
                            <?
                            foreach ($param_data['params_options'] as $select_param_id => $options_data) {

                                if ($select_param_id == $cur_val) {
                                    $selected = "selected='select'";
                                } else {
                                    $selected = NULL;
                                }
                                ?>
                                <option title="<?=$options_data['option_str_long_val']?>" <?=$selected?> value="<?=$select_param_id?>"><?=$options_data['option_str_val']?></option>
                            <?
                            }
                            echo "</select>\r\n <br><br> $star_text";
                        }elseif($param_data["param_type"]==6){
                            if(isset($cont_data["specs"][$spec_id]["params"][$param_id]["option_id"]) && is_array($cont_data["specs"][$spec_id]["params"][$param_id]["option_id"])){
                                $cur_val=array(0);
                                $arr_cur_val=$cont_data["specs"][$spec_id]["params"][$param_id]["option_id"];
                                foreach($arr_cur_val as $sel_id){
                                    $cur_val[$sel_id]=$sel_id;
                                }
                            } else {
                                $cur_val=0;
                                if(isset($cont_data["specs"][$spec_id]["params"][$param_id])){
                                    $cur_val=$cont_data["specs"][$spec_id]["params"][$param_id];
                                }

                            }
                            echo "<select $required id='pr_edit_param_$param_id' multiple='multiple' name='product_edit_param[$param_id][]' class='drv-lines cusel2 wid100  multiple-checkbox-select' {$param_data['param_attr']}>\r\n";
                            foreach ($param_data['params_options'] as $select_option_id => $options_data) {
                                if (isset($cur_val[$select_option_id])) {
                                    $selected = "selected='select'";
                                } else {
                                    $selected = NULL;
                                }
                                ?>
                                <option <?=$selected?> value="<?=$select_option_id?>"><?=$options_data['option_str_val']?></option>
                            <?
                            }
                            echo "</select>\r\n $star_text";
                        }elseif($param_data["param_type"]==7){
                            $cur_val="";
                            if(isset($cont_data["specs"][$spec_id]["params"][$param_id])){
                                $cur_val=$cont_data["specs"][$spec_id]["params"][$param_id]["param_text_val"];
                            }
                            ?>
                            <textarea class="drv-lines" style="resize: none" id="pr_edit_param_<?=$param_id?>" name="product_edit_param[<?=$param_id?>]" <?=$param_data['param_attr']?>><?=$cur_val?></textarea>
                        <?
                        }elseif($param_data["param_type"]==8){

                            $files_attr_arr = (!empty($param_data['param_attr']))?explode(' ',str_replace('"','',$param_data['param_attr'])):array();
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
                            }
                            if (!is_null($accept)){
                                $current_file_types = explode(',',$accept);
                            }
                            $current_file_ext_arr = array();
                            foreach($current_file_types as $ext){
                                $ext_a = explode('/',$ext);
                                $cur_ext = ($ext_a[1]=='jpeg')?"jpeg,jpg":$ext_a[1];
                                $current_file_ext_arr[] = $cur_ext;
                            }
                            $current_file_ext = implode(',',$current_file_ext_arr);

                            ?>
                            <div class="dropzone" id="drv-dropzone"></div>
                            <div style="display:none" class="msg_err"><?=lang_text("{err_file_size}")?></div>
                            <?
                            /*if(isset($cont_data["specs"][$spec_id]["params"][$param_id])){
                                $cur_val=$cont_data["specs"][$spec_id]["params"][$param_id]["param_file_name_real"];
                                echo lang_text('{downloaded_photo}')." - ".$cur_val;
                            }*/
                            if(isset($cont_data["specs"][$spec_id]["params"][$param_id])
								&& !empty($cont_data["specs"][$spec_id]["params"][$param_id])) {
                            	echo "<ul id='dropzone-edit-files' style='display:none;'>";
                            	foreach($cont_data["specs"][$spec_id]["params"][$param_id] as $file) {
                            		$filepath = ($file['param_file_path'].$file['param_file_name']);
                            		echo "<li data-name='{$file['param_file_name']}'>{$filepath}</li>";
                            	}
								echo "</ul>";
                            }
                        }
                    }
                }
            }

            $url = parse_url($_SERVER['REQUEST_URI']);
            $new_url = "http://{$_SERVER['HTTP_HOST']}{$url['path']}";
            ?>
            <br>
            <button type="submit" class='button save-but'><?=lang_text('{action_save}')?></button>
            <button type="button" class='button save-but redirect_button' data-redirect="<?=$new_url?>"><?=lang_text('{action_cancel}')?></button>
        </form>
    </div>
</div>
