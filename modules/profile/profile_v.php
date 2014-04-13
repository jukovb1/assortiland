<?php
/**
 * profile_v.php (front)
 *
 * Представление профиля пользователя
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

<div class="profile-wrap" style="margin: 20px auto 0 auto">
    <h1><?=lang_text('{module_name}')?></h1>
</div>
<div class="profile-wrap">
    <div class="table_row">
        <div class="prof-left-wrap table_cell">
            <ul class="prof-menu">
                <?
                foreach($current_profile_left_menu as $menu_key) {
                    if(isset($left_menu_fields_data['menu'][$menu_key])) {
                        $lang_to_link = $friendly_url->lang_to_link;
                        $menu = $left_menu_fields_data['menu'][$menu_key];
                        $menu['url'] = str_replace('{USER_LOGIN}', $auth_class->cur_user_login, $menu['url']);

                        $active_class = "";
                        if ($_SERVER['REQUEST_URI']==$menu['url']
                            || $_SERVER['REQUEST_URI']==$lang_to_link.$menu['url']){
                            $active_class = "profile_menu_active_item";
                        }
                        $menu['url'] = $lang_to_link.$menu['url'];
                        echo "<li><a class='$active_class' href='{$menu['url']}'>{$menu['title']}</a></li>";
                    }
                }
                ?>
            </ul>
        </div>
        <div class="prof-right-wrap table_cell">
            <?
            if($auth_class->cur_user_status==0 && $auth_class->cur_user_group>0){
                echo  err_field(lang_text("{auth_activate_profile_msg}"));
            }
            if($current_user_profile && ($auth_class->cur_user_group==4 || $auth_class->cur_user_group==5) && $auth_class->cur_user_status_in_group==0){
                echo err_field(lang_text("{profile_join_already_applied}::{:GROUP_NAME:}={$friendly_url->url_user_data['user_default_group_name']}::{:SITE_NAME:}=".get_constant($global_constants,'site_name')));
            }
            if (file_exists($profile_v_right)){
                require_once($profile_v_right);
            }
            ?>
        </div>
    </div>

</div>