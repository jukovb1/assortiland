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

<div class="prof-main-wrap">
	<?
		if($error_info_page) {
			echo "<p>{$info_page_content['result_msg']}</p>";
		} else {
			echo "<h2>{$info_page_content['result_data']['cont_title'][$friendly_url->url_lang['id']]}</h2><div class='edit-prof'></div>";
			echo "<div class='info'>{$info_page_content['result_data']['cont_content'][$friendly_url->url_lang['id']]}</div>";
		}
	?>
</div>