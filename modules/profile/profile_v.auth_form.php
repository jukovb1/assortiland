<?php
/**
 * profile_v.auth_form.php (admin)
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
$password_recovery_url = "http://{$_SERVER['SERVER_NAME']}/profile/auth/recovery_password";
?>
<div>
    <div id="auth-block">
        <div class="edit-prof prof-right-wrap">
            <h2><?=lang_text("{auth_title}")?></h2>
        </div>
        <?
        if ($auth_class->cur_user_group>0){
            echo lang_text("{auth_error_double_auth}");
        } else {
            ?>
            <fieldset>
                <form action="" method="post">
                    <input type="hidden" name="auth" value="1">

                    <label for="auth-pass"><?=lang_text("{auth_login}")?></label>
                    <input class="linesauth" name="login" type="text" placeholder="<?=lang_text("{auth_login_holder}")?>">
                    <label for="auth-pass"><?=lang_text("{auth_pass}")?></label>
                    <input class="linesauth" name="pass" type="password" placeholder="<?=lang_text("{auth_pass_holder}")?>">
                    <br>
                    <button class="mid-button "><?=lang_text("{auth_enter}")?></button>
                    <div class="checkwrapper auth-pass-wrapper">
                    	<a title="<?=lang_text("{password_recovery_fulltext}")?>" href="<?=$password_recovery_url?>"><?=lang_text("{password_recovery_fulltext}")?></a>
                	</div>
                </form>
            </fieldset>
        <?
        }
        ?>

    </div>
</div>

