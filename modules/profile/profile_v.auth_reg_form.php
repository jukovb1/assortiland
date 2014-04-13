<?php
/**
 * profile_v.auth_reg_form.php (admin)
 *
 * Представление страницы авторизации
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
$reg_form = true;
?>
<div>
    <div id="auth-block">
        <div class="edit-prof prof-right-wrap">
            <h2><?=lang_text("{reg_title}")?></h2>
        </div>
        <?
        if ($auth_class->cur_user_group>0){
            echo lang_text("{auth_error_double_auth}");
        } else {
            ?>
            <form action="" method="post">
                <fieldset>

                    <?=print_fields_set_by_user_group($fields_set,$fields_validation,$friendly_url->url_user_data,$fields_options); ?>
                    <?
                    	if(isset($show_captcha) && $show_captcha) {
                    ?>
                    <div class="captcha-wrapper">
                    	<div class="captcha-image-wrapper">
                    		<img src="<?=$captcha_path?>" id="captcha" />
	                    	<a class="captcha-delete-button" href="javascript:void(0)" onclick="document.getElementById('captcha').src='<?=$captcha_path?>?'+Math.random();">
		                        <img src="/assets/images/other/captcha_refresh.png">
		                    </a>
						</div>
						<div class="captcha-text-wrapper">
						<label title="<?=lang_text('{required_text}')?>" class="drv-lines-label" for="captcha"> <span style="color:#e65400">*</span> <?=lang_text('{edit_captcha}')?></label>
	                    <input id="captcha" required="" class="linesreg linesreg-captcha" name="captcha" value="" type="text" autocomplete="off">
	                   </div>
                    </div>
					<?
						}
					?>
                    
                    <div class="checkwrapper">
                    	<input id='reg_subscribe' name='reg_subscribe' value='0' type='checkbox'/>
                    	<?= lang_text("{reg_subscribe_fulltext}") ?>
                	</div>
                    <div class="checkwrapper">
                    	<input id='reg_public_offer_check' name='reg_public_offer_check' value='0' type='checkbox'/>
                    	<p><?= lang_text("{reg_agreement_offer_fulltext}") ?></p>
                	</div>
                    <br>
                    <br>
                    <button disabled type="submit" class="button-disabled reg-button"><?=lang_text('{profile_user_button_save}')?></button>
                </fieldset>

            </form>

        <?
        }
        ?>

    </div>
</div>

