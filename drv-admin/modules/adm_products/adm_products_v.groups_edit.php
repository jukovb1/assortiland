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
    //ash_debug($_POST);

    $cont_data = $content_by_id_data['result_data'];
    ?>
    <form method='post'>
        <?
        if (isset($cont_data['group_id']) && $cont_data['group_id']!='new'){
            echo "<input class='drv-lines' hidden type='number' name='group_id' value='{$cont_data['group_id']}'>";
        }
        $tmp_cont_id = $cont_data['group_id'];

        $star = '<span style="color:#e65400">*</span>';
        $star_text = "<div class='show_required_text'>".lang_text("{required_text}")."</div>";
        $required = 'required';

        $field_key = 'group_full_name';
        echo "<label title='".strip_tags($star_text)."' class='drv-lines-label' for='{$field_key}'>$star ".lang_text('{group_edit_name}')."</label>\r\n";
        echo "<input $required class='drv-lines' name='{$field_key}' value='{$cont_data[$field_key]}' id='{$field_key}' type='text'>\r\n$star_text";

        $field_key = 'group_short_name';

        echo "<label title='".strip_tags($star_text)."' class='drv-lines-label' for='{$field_key}'>$star ".lang_text('{group_edit_url}')." </label>\r\n";
        echo "<input $required class='drv-lines' name='{$field_key}' value='{$cont_data[$field_key]}' id='{$field_key}' type='text'>\r\n$star_text";

        $star = '';
        $required = '';
        $field_key = 'group_description';
        echo "<label title='".strip_tags($star_text)."' class='drv-lines-label' for='{$field_key}'>$star ".lang_text('{group_edit_desc}')."</label>\r\n";
        echo "<textarea class='drv-lines' name='{$field_key}' id='{$field_key}'>{$cont_data[$field_key]}</textarea>\r\n";

        $required = 'required';
        $star = '<span style="color:#e65400">*</span>';

        $field_key = 'group_parent_group';
        echo "<label title='".strip_tags($star_text)."' class='drv-lines-label' for='{$field_key}'>$star ".lang_text('{group_edit_parent}')."</label>\r\n";
        echo "<select id='$field_key' name='$field_key' class='wid100'>\r\n";
        $selected = "";
        if ($cont_data[$field_key] == 0){
            $selected = "selected='selected'";
        }
        echo "<option $selected value='0'>".lang_text('{root_category}')."</option>\r\n";
        print_group_tree_options($tmp_cont_id,$cont_data[$field_key],$content_by_group);
        echo "</select>\r\n";




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