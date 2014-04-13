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
    <script>
        var sub_area = 'users-list';
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
        <input type='hidden' name='user_id' value='<?=$cont_data["user_id"]?>'>
        <?
        // группа по умолчанию
        echo "<label class='drv-lines-label' for='user_default_group'>".lang_text('{edit_user_default_group}')."</label>\r\n";
        echo "<select id='user_default_group' name='user_default_group' class='wid100'>\r\n";

        foreach($user_group_list as $group_id=>$user_group){

            $selected = "";
            if ($group_id == $cont_data["user_default_group"]){
                $selected = "selected='selected'";
            }
            echo "<option title='{$user_group['us_group_desc'][$friendly_url->url_lang['id']]}' $selected style='color: {$user_group['us_group_color']}' value='{$group_id}'>{$user_group['us_group_prefix']}{$user_group['us_group_title'][$friendly_url->url_lang['id']]}{$user_group['us_group_sufix']}</option>\r\n";
        }
        echo "</select>\r\n<br>";

        echo print_fields_set_by_user_group($fields_set,$fields_validation,$cont_data,$fields_options);

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