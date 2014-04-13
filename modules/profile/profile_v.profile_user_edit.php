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
$new_url = str_replace('/edit','',$_SERVER['REQUEST_URI']);
?>

<div class="prof">
	<h2><?=lang_text('{profile_user_edit}')?></h2>
	<div class="edit-prof">
		<img src="/assets/images/profile/back-but.png" /> <a href="<?=$new_url?>" title="<?=lang_text('{profile_user_edit}')?>" /><?=lang_text('{profile_user_return}')?></a>
	</div>
    <?
	if(!$current_user_profile) {
		echo lang_text('{IE_3x103}');
	} else {
    ?>
        <form action="" method="post">
            <fieldset>
                <input type='hidden' name='user_id' value='<?=$friendly_url->url_user_data["user_id"]?>'>
                <?=print_fields_set_by_user_group($fields_set,$fields_validation,$friendly_url->url_user_data,$fields_options); ?>
                <button type="submit" class="button save-but"><?=lang_text('{profile_user_button_save_edit}')?></button>
            </fieldset>
        </form>
	<?
        }
    ?>
</div>
<!--div class="prof-avatar-wrap">
	<div class="prof-avatar" title="Логотип компании DRV"></div>
	<button class="button load-but"><img src="../images/buttons/load-but.png"><span>Выбрать фотографию</span></button>
</div-->