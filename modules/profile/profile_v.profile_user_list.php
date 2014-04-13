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
$url = $_SERVER['REQUEST_URI'];
$new_url = ($url[strlen($url)-1]=='/')?$url."edit":$url."/edit";

?>

<div class="prof-main-wrap">
    <h2><?=$friendly_url->url_user_data['user_fullname'] ?></h2>
    <?
    if($current_user_profile) {
        ?>
        <div class="edit-prof"><img src="/assets/images/profile/edit-but.png" />
            <a href="<?=$new_url?>" title="<?=lang_text('{profile_edit}')?>" /><?=lang_text('{profile_edit}')?></a>
        </div>
    <?
    }
    ?>
    <div class="prof">
    	<div class="prof-list-wrapper">
	        <div class="info-line"><?=lang_text('{profile_group}')?>:</div>
	        <div class="info-answer">
	            <?= $friendly_url->url_user_data['user_default_group_name'] ?>
	        </div>
	        <?= print_profile_data_by_user_group($fields_set, $fields_validation,$friendly_url->url_user_data, $fields_options) ?>
        </div>
    </div>
    <!--div class="prof-avatar-wrap">
        <div class="prof-avatar" title="Логотип компании DRV"></div>
    </div-->
    <?
    if ($show_qr){
        ?>
        <div class="prof-qr">
            <h3><?=lang_text('{qr_title}')?>:</h3>
            <?=$qr_img?>
            <ul>
                <?
                foreach (explode('|', lang_text('{qr_text}')) as $text) {
                    echo "<li>$text</li>";
                }
                ?>
            </ul>
            <div class="partner-url-wrapper">
                <h3><?=lang_text('{qr_link_'.$friendly_url->url_user_data['user_default_group'].'}')?>:</h3>
                <div class="partner-url"><a class="partner-url-link" target="_blank" href="<?=$link_for_qr?>" data-link="<?=$link_for_qr?>"><?=lang_text('{qr_link_title}')?></a></div>
            </div>
        </div>
        <?
    }
    if($current_user_profile) {
        ?>
        <div class="checkwrapper prof-subscribe-wrapper">
            <a href="javascript:void(0)" data-alt_text="<?=($is_subscribed)?lang_text("{reg_subscribe}"):lang_text("{reg_unsubscribe}")?>" class="sbscrb-button"><?=(!$is_subscribed)?lang_text("{reg_subscribe}"):lang_text("{reg_unsubscribe}")?></a>
            <p class='subscribe' style="display: <?=(!$is_subscribed)?"inline":"none"?>"><?=lang_text("{reg_subscribe_fulltext}")?></p>
        </div>
    <?
    }
    ?>
</div>