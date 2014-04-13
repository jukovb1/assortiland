<?php
/**
 * content_v.php (admin)
 *
 * Представление страницы контента
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
<div class="drv-top-wrapper">
    <div class="drv-common-wrapper">
        <h3 style="display: inline-block"><?=lang_text('{current_module_'.$action_for_content.'}')?>: <?=$current_type['type_title']?></h3>
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
    //ash_debug($_POST);

    $cont_data = $content_by_id_data['result_data'];
    ?>
    <form method='post' enctype='multipart/form-data'>
        <?
        if (isset($cont_data['cont_id']) && $cont_data['cont_id']!='new'){
            echo "<input class='drv-lines' hidden type='number' name='cont_id' value='{$cont_data['cont_id']}'>";
        }
        ?>

        <input class='drv-lines' hidden type="number" name="cont_type" value="<?=$cont_data['cont_type']?>">
    <?
    foreach ($current_type['type_field_names'] as $field_key => $field_name) {
        $required = $star = $star_text = '';
        if ($current_type['type_main_field'][$field_key]){
            $required = 'required';
            $star = '<span style="color:#e65400">*</span>';
            $star_text = "<div class='show_required_text'>".lang_text("{required_text}")."</div>";
        }
        if ($field_sets[$field_key]['save_place']==1){
            if ($field_sets[$field_key]['subtype']!='hidden'){
                echo "<label title='".strip_tags($star_text)."' class='drv-lines-label' for='{$field_key}'>$star {$field_name}</label>\r\n";

            }
            if ($field_sets[$field_key]['type']=='text'){
                $redactor = '';
                if ($current_type['visual_editor'][$field_key]){
                    $redactor = 'redactor';
                }
                echo "<textarea $required class='drv-lines $redactor' name='{$field_key}' id='{$field_key}'>{$cont_data[$field_key]}</textarea>\r\n$star_text";
            } elseif ($field_sets[$field_key]['type']=='select'){

                echo "<select id='$field_key' name='$field_key' class='wid100'>\r\n";
                if ($field_key=='cont_user_id'){
                    foreach($admin_list['result_data'] as $admin){
                        $selected = "";
                        if ($admin['user_id'] == $cont_data[$field_key]){
                            $selected = "selected='selected'";
                        }
                        echo "<option $selected style='color: {$admin['us_group_color']}' value='{$admin['user_id']}'>{$admin['user_fullname']}</option>\r\n";
                    }
                }
                echo "</select>\r\n";
            } else {

                $input_class = 'drv-lines';
                $checked = $dop_input = '';
                $cont_data[$field_key] = (is_bool($cont_data[$field_key]))?'':$cont_data[$field_key];
                if ($field_sets[$field_key]['type']=='num' && $field_sets[$field_key]['subtype']=='hidden'){
                    $field_sets[$field_key]['subtype']='number';
                    $checked = "hidden='hidden'";
                } elseif ($field_sets[$field_key]['subtype']=='datetime-local') {
                    $cont_data[$field_key] = str_replace(' ','T',$cont_data[$field_key]);
                    $input_class = 'drv-lines-date';
                } elseif ($field_sets[$field_key]['subtype']=='checkbox') {
                    $input_class = 'niceCheck chbx_edit';
                    if ($cont_data[$field_key] == 1) {
                        $checked = "checked='checked'";
                    }
                    $dop_input = "<input hidden='' name='{$field_key}' value='{$cont_data[$field_key]}' type='text'>";
                    $cont_data[$field_key] = 1;
                } elseif ($field_sets[$field_key]['subtype']=='number') {
                    $checked = "min='0' ";
                    $input_class = 'drv-lines-number';

                } elseif ($field_sets[$field_key]['subtype']=='text') {
                    $input_class = 'drv-lines';
                } elseif ($field_sets[$field_key]['subtype']=='range') {
                    $input_class = 'drv-lines-range';
                    $dop_input = "<span class='range_info'>{$cont_data[$field_key]}</span>";
                    $checked = "min='-99' max='99' ";
                } elseif ($field_sets[$field_key]['type']=='file') {
                    $input_class = 'drv-lines-range';
                    $dop_input = "<br><input class='$input_class' name='{$field_key}' value='{$cont_data[$field_key]}' id='{$field_key}_2' type='text' placeholder='".lang_text('{or_enter_url}')."'><br>";
                    $dop_input .= (empty($cont_data[$field_key]))?NULL:"<div class='img_content'><img src='".global_v::check_img($cont_data[$field_key])."'></div>";
                    $checked = 'accept="image/jpeg,image/jpg,image/png,image/gif" ';
                    $field_sets[$field_key]['subtype']='file';
                } else{

                    echo "<span style='color: red'>--- !!! не написан обработчик !!! ---</span>";
                    // ash_debug($field_sets[$field_key]);
                }

                echo "<input  $required $checked class='$input_class' name='{$field_key}' value='{$cont_data[$field_key]}' id='{$field_key}' type='{$field_sets[$field_key]['subtype']}'>\r\n$star_text".$dop_input;

            }
        } else {
            foreach ($langs_data['by_id'] as $lang_id => $lang_d) {

                if ($lang_id == $langs_data['default_lang']['lang_id']){
                    $display = 'block';
                } else {
                    $display = 'none';
                }
                echo "<div data-lang_id='$lang_id' style='display: {$display};' class='field_lang_area_{$lang_id}'>\r\n";
                $flag = print_lang_flag($show_lang_tabs_for_mod,$lang_d);
                echo "<label title='".strip_tags($star_text)."' class='drv-lines-label' for='{$field_key}[$lang_id]'>$star {$field_name} $flag</label>\r\n";

                if ($field_sets[$field_key]['type']=='text'){
                    $redactor = '';
                    if ($current_type['visual_editor'][$field_key]){
                        $redactor = 'redactor';
                    }
                    echo "<textarea $required class='drv-lines $redactor' name='{$field_key}[$lang_id]' id='{$field_key}_{$lang_d['lang_abbr']}'>{$cont_data[$field_key][$lang_id]}</textarea>\r\n$star_text";
                } else {

                    $input_class = 'drv-lines';
                    $checked = $dop_input = '';
                    if ($field_sets[$field_key]['type']=='num' && $field_sets[$field_key]['subtype']=='hidden'){
                        $field_sets[$field_key]['subtype']='number';
                    } elseif ($field_sets[$field_key]['subtype']=='text') {
                        $input_class = 'drv-lines';

                    } else{
                        echo "<span style='color: red'>--- !!! не написан обработчик !!! ---</span>";
                    }

                    echo "<input $required $checked class='$input_class' name='{$field_key}[$lang_id]' value='{$cont_data[$field_key][$lang_id]}' id='{$field_key}_{$lang_d['lang_abbr']}' type='{$field_sets[$field_key]['subtype']}'>\r\n$star_text";
                    echo $dop_input;

                }

                echo "</div>\r\n";

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