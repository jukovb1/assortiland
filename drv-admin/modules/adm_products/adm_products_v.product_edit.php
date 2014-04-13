<?php
/**
 * products_v.groups_edit.php (admin)
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
    <script>
        var sub_area = 'products-list';
    </script>
    <div class="drv-top-wrapper">
        <div class="drv-common-wrapper">
            <h3 style="display: inline-block"><?=lang_text('{current_module_'.$action_for_content.'}')?>: <?=lang_text('{'.$current_type.'}')?></h3>

        </div>
    </div>
<?
if ($show_lang_tabs_for_mod) {
    echo "<div class='mod_lang_tab'>\r\n";
    foreach ($langs_data['by_id'] as $lang_id => $lang_d){
        if ($lang_id == $langs_data['default_lang']['lang_id']){
            $active_class = ' mod_lang_tab_item_active';
        } else {
            $active_class = '';
        }
        echo "<span class='mod_lang_tab_item{$active_class}' data-lang_id='{$lang_id}' id='lang_tab_{$lang_id}'>{$lang_d['lang_name']}</span>\r\n";
    }
    echo "<div class='mod_lang_area'>\r\n";
}
if (!$content_by_id_data['result']){
    echo "<span class='no_data_td'>".lang_text($content_by_id_data['result_msg'])."</span>";
} else {

    $cont_data = $content_by_id_data['result_data'];
    ?>
    <form method='post' enctype="multipart/form-data">
        <?
        foreach($cont_data["products"] as $obj){
            echo "<input type='hidden' name='product_id' value='{$obj["product_id"]}'>";

            // Разместил
            echo "<label class='drv-lines-label' for='product_user_id'><span style='color:#e65400'>*</span> ".lang_text('{product_edit_user}')."</label>\r\n";
            //echo "<select id='product_user_id' name='product_user_id' class='wid100'>\r\n";
            echo "<select id='' name='product_user_id' class=''>\r\n";
            foreach($user_list['sellers'] as $user){
                $selected = "";
                if ($user['user_id'] == $obj["product_user_id"]){
                    $selected = "selected='selected'";
                }
                echo "<option $selected style='color: {$user['us_group_color']}' value='{$user['user_id']}'>{$user['user_fullname']}</option>\r\n";
            }
            echo "</select>\r\n<br><div class='show_required_text'>".lang_text("{required_text}")."</div><br>";

            // дата
            echo "<label title='".lang_text("{required_text}")."' class='drv-lines-label' for='product_date'><span style='color:#e65400'>*</span> ".lang_text('{product_edit_date}')."</label>\r\n";
            $obj["product_date"] = str_replace(' ','T',$obj["product_date"]);
            echo "<input id='product_date' required class='drv-lines-date' name='product_date' value='{$obj["product_date"]}' type='datetime-local'>\r\n<br><div class='show_required_text'>".lang_text("{required_text}")."</div>";
        ?>
            <br>
        <?

            // выбор группы для товара
            echo "<label class='drv-lines-label'><span style='color:#e65400'>*</span> ".lang_text('{product_edit_groups}')."</label>\r\n";
            $multiple_checkbox->set_indexes_for_branch_arr('group_id','group_parent_group','group_nesting','group_full_name');
            echo $multiple_checkbox->tree_print_final_table('select_groups','select_products_groups[]',$group_arr,$group_list_for_product[intval($obj["product_id"])]);
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
			
			// 15 - Оптовая цена
			// 10 - Владелец
			if($param_id != 10 && $param_id != 15) {
	            echo "<label title='".strip_tags($star_text)."' class='drv-lines-label' for='$field_id'>$star {$param_data["param_name"]}</label>\r\n";
	            echo "<br><small class='param_description'>{$param_data["param_description"]}</small>\r\n";
			}

            foreach($cont_data["products"] as $obj){
                foreach($obj["specs"] as $spec_id){

                    if($param_data["param_type"]==2){
                        if(isset($cont_data["specs"][$spec_id]["params"][$param_id])){
                            $cur_val=$cont_data["specs"][$spec_id]["params"][$param_id]["param_number_val"];
                        } else {
                            $cur_val=0;
                        }
						
						// 15 - Оптовая цена
						if($param_id != 15) {
                    		echo "<input $required class='drv-lines' id='pr_edit_param_$param_id' name='product_edit_param[$param_id]' value='{$cur_val}' type='number' {$param_data['param_attr']}>\r\n$star_text";
						}
                    }elseif($param_data["param_type"]==3){
                        if(isset($cont_data["specs"][$spec_id]["params"][$param_id])){
                            $cur_text=$cont_data["specs"][$spec_id]["params"][$param_id]["param_text_val"];
                        } else {
                            $cur_text='';
                        }

						// 10 - Владелец
						if($param_id != 10) {
                        	echo "<input $required class='drv-lines' value='{$cur_text}' id='pr_edit_param_$param_id' name='product_edit_param[$param_id]' type='text' {$param_data['param_attr']}>\r\n$star_text";
						}
                    }elseif($param_data["param_type"]==4){
                        $checked=NULL;
                        if(isset($cont_data["specs"][$spec_id]["params"][$param_id])
                            && $cont_data["specs"][$spec_id]["params"][$param_id]['option_id']==1){
                            $checked="checked='checked'";
                        }
                        echo "<input $checked class='niceCheck chbx_edit' id='pr_edit_param_$param_id' name='product_edit_param[$param_id]' value='1' type='checkbox' onchange='checkbox_status(this);'  {$param_data['param_attr']}>\r\n";
                        ?>
                        <input class='chbx_input' hidden type="number" name='product_edit_param[<?=$param_id?>]' value="<?=(!is_null($checked))?"1":"0";?>">
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
                        echo "<select $required id='pr_edit_param_$param_id' multiple='multiple' name='product_edit_param[$param_id][]' class='cusel2 wid100' {$param_data['param_attr']}>\r\n";
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
                        <textarea class="drv-lines" style="resize: none" id="pr_edit_param_$param_id" name="product_edit_param[<?=$param_id?>]" <?=$param_data['param_attr']?>><?=$cur_val?></textarea>
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
                        <input type="file" id="pr_edit_param_<?=$param_id?>" name="product_edit_param[<?=$param_id;?>]"  <?=$param_data['param_attr']?> data-cur_ext='<?=$current_file_ext?>'>
                        <br>
                        <?
                        if(isset($cont_data["specs"][$spec_id]["params"][$param_id])){
                            $cur_val=$cont_data["specs"][$spec_id]["params"][$param_id]["param_file_name_real"];
                            echo lang_text('{downloaded_photo}')." - ".$cur_val;
                        }
                    }
                }
            }
        }

        $url = parse_url($_SERVER['REQUEST_URI']);
        $new_url = "http://{$_SERVER['HTTP_HOST']}{$url['path']}";
        ?>
        <br>
        <br>
        <button type="submit" class='drv-button'><?=lang_text('{action_save}')?></button>
        <button type="button" class='drv-button redirect_button' data-redirect="<?=$new_url?>"><?=lang_text('{action_cancel}')?></button>
    </form>

<?
}



if ($show_lang_tabs_for_mod) {
    echo '<br style="clear: both">';
    echo "</div>\r\n";
    echo "</div>\r\n";
}