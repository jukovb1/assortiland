<?php
/**
 * profile_v.recovery_password.php (front)
 *
 * Представление страницы восстановления пароля
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
$html5 = 'text';
if(isset($fields_validation['user_email']['html5'])){
	$html5 = "html5='{$fields_validation['user_email']['html5']}'";
}
$password_recovery_url = "http://{$_SERVER['SERVER_NAME']}/profile/auth/recovery_password";
?>
<div>
    <div id="auth-block">
        <div class="edit-prof prof-right-wrap">
            <h2><?=lang_text("{password_recovery_title}")?></h2>
        </div>
        <?
        if ($auth_class->cur_user_group>0){
            echo lang_text("{auth_error_double_auth}");
        } else {
            ?>
            <fieldset>
                <form action="" method="post">
                    <label for="user_email"><span style="color:#e65400">*</span> <?=lang_text("{edit_user_email}")?></label>
                    <input required class="linesauth" name="user_email" type="<?=$html5?>">
                    <div class="show_required_text"><?=lang_text("{required_text}")?></div>
                    <br>
                    <button class="mid-button "><?=lang_text("{password_recovery_button}")?></button>
                </form>
            </fieldset>
        <?
        }
        ?>

    </div>
</div>

