<?php
/**
 * users_v.groups_edit.php (admin)
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
        if (isset($cont_data['us_group_id']) && $cont_data['us_group_id']!='new'){
            echo "<input class='drv-lines' hidden type='number' name='us_group_id' value='{$cont_data['us_group_id']}'>";
        }
        $tmp_cont_id = $cont_data['us_group_id'];

        $star = '<span style="color:#e65400">*</span>';
        $star_text = "<div class='show_required_text'>".lang_text("{required_text}")."</div>";
        $required = 'required';

        $field_key = 'us_group_title';
        foreach ($langs_data['by_id'] as $lang_id => $lang_d) {
            if ($lang_id == $langs_data['default_lang']['lang_id']){
                $display = 'block';
            } else {
                $display = 'none';
            }
            echo "<div data-lang_id='$lang_id' style='display: {$display};' class='field_lang_area_{$lang_id}'>\r\n";
            $flag = print_lang_flag($show_lang_tabs_for_mod,$lang_d);
            echo "<label title='".strip_tags($star_text)."' class='drv-lines-label' for='{$field_key}_{$lang_d['lang_abbr']}'>$star ".lang_text('{'.$field_key.'_edit}')." $flag</label>\r\n";
            echo "<input $required class='drv-lines' name='{$field_key}[{$lang_id}]' value='{$cont_data[$field_key][$lang_id]}' id='{$field_key}_{$lang_d['lang_abbr']}' type='text'>\r\n$star_text";
            echo "</div>\r\n";
        }



        $star = '';
        $required = '';
        $field_key = 'us_group_desc';
        foreach ($langs_data['by_id'] as $lang_id => $lang_d) {
            if ($lang_id == $langs_data['default_lang']['lang_id']){
                $display = 'block';
            } else {
                $display = 'none';
            }
            echo "<div data-lang_id='$lang_id' style='display: {$display};' class='field_lang_area_{$lang_id}'>\r\n";
            $flag = print_lang_flag($show_lang_tabs_for_mod,$lang_d);
            echo "<label title='".strip_tags($star_text)."' class='drv-lines-label' for='{$field_key}_{$lang_d['lang_abbr']}'>$star ".lang_text('{'.$field_key.'_edit}')." $flag</label>\r\n";
            echo "<textarea class='drv-lines' name='{$field_key}[{$lang_id}]' id='{$field_key}_{$lang_d['lang_abbr']}'>{$cont_data[$field_key][$lang_id]}</textarea>\r\n";
            echo "</div>\r\n";
        }



        ?>
        <?=lang_text('{us_group_view_edit}')?>
        <table class="us_group_view">
            <tr>
                <td>
                    <?
                    $field_key = 'us_group_color';
                    echo "<label class='drv-lines-label' for='{$field_key}'> ".lang_text('{'.$field_key.'_edit}')."</label>\r\n";
                    $kostil = '';
                    if (!empty($_POST)){
                        $kostil = "style='min-height: 30px;'";
                    }
                    echo "<input $kostil class='drv-colors' name='{$field_key}' value='{$cont_data[$field_key]}' id='{$field_key}' type='color'>\r\n";
                    ?>
                </td>
                <td>
                    <?
                    $field_key = 'us_group_prefix';
                    echo "<label class='drv-lines-label' for='{$field_key}'> ".lang_text('{'.$field_key.'_edit}')."</label>\r\n";
                    echo "<input class='drv-colors' name='{$field_key}' value='{$cont_data[$field_key]}' id='{$field_key}' type='text'>\r\n";
                    ?>
                </td>
                <td>
                    <?
                    $field_key = 'us_group_sufix';
                    echo "<label class='drv-lines-label' for='{$field_key}'> ".lang_text('{'.$field_key.'_edit}')."</label>\r\n";
                    echo "<input class='drv-colors' name='{$field_key}' value='{$cont_data[$field_key]}' id='{$field_key}' type='text'>\r\n";
                    ?>
                </td>
            </tr>
        </table>
        <?




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