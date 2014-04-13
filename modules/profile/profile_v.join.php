<?php
/**
 * users_v.join.php (admin)
 *
 * Представление страницы подачи заявки на вступление в группу
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
$new_url = "/profile";
?>

<div class="prof">
	<h2><?=lang_text("{profile_join_group}::{:GROUP_NAME:}=$group_name")?></h2>
	<div class="edit-prof">
        <img src="/assets/images/profile/back-but.png" /> <a href="<?=$new_url?>" /><?=lang_text('{profile}')?></a>
    </div>
    <?=lang_text("{profile_join_info}");?>
    <br>
    <br>
        <form action="" method="post">
            <fieldset>
                <input type='hidden' name='user_id' value='<?=$friendly_url->url_user_data["user_id"]?>'>

                <?=print_fields_set_by_user_group($fields_set,$fields_validation,$friendly_url->url_user_data,$fields_options); ?>
                <button type="submit" class="button save-but"><?=lang_text('{profile_user_button_save}')?></button>
            </fieldset>

        </form>
</div>
