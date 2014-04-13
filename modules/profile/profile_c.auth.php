<?php
/**
 * profile_c.auth.php (admin)
 *
 * Контроллер авторизации
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

require_once('profile_m.php');
require_once('profile_v.functions.php');

$fields_validation = $user_fields_data['validation'];
$fields_options = $user_fields_data['options'];
$fields_set = $user_fields_data['registration'];
$friendly_url->url_user_data['user_default_group'] = 3;
$captcha_path = '/modules/system/captcha/captcha.php';
$show_captcha = false;

if(!empty($_POST) && isset($friendly_url->url_command['registration'])){
    $show_captcha = $reg_form = true;
    $_POST['user_fullname'] = $_POST['user_login'];
    $prep_post_data = profile_c::user_data_save_prepare($_POST,$fields_set,$fields_validation);

    if (!$prep_post_data['result']){
        $msg_color_for_user = 'msg_err';
        $gr = $friendly_url->url_user_data['user_default_group'];
        $msg_for_user = lang_text($prep_post_data['result_msg']);
        $friendly_url->url_user_data = $prep_post_data['result_data'];
        $friendly_url->url_user_data['user_default_group'] = $gr;
    } else {
    	unset($prep_post_data['result_data']['captcha'], $_POST['captcha'], $_SESSION);
        $user_key_activated = md5(time().rand(100,10000));
        $prep_post_data['result_data']['user_key_activated'] = $user_key_activated;
		// подписаться на рассылку
    	if (isset($_POST['reg_subscribe'])){
    		$prep_post_data['result_data']['subscribe_status'] = true;
    	}
        $save_result = profile_m::user_save($prep_post_data['result_data']);
        if ($save_result['result']) {
            if (isset($_COOKIE['unique_key'])){
                profile_m::save_guest_cart_in_user_cart($_COOKIE['unique_key'],$save_result['result_data']['user_id']);
            }
            $mail_to = $prep_post_data['result_data']['user_email'];
			$mail_username = !isset($prep_post_data['result_data']['user_fullname'])?$prep_post_data['result_data']['user_login']:$prep_post_data['result_data']['user_fullname'];
            $mail_button = global_v::create_button_for_email_msg("http://{$_SERVER['SERVER_NAME']}/profile/auth/activate={$save_result['result_data']['user_id']},$user_key_activated/",lang_text('{email_action_activate}'));
            $mail_subject = lang_text('{email_action_required_confirm}');
            $mail_msg = lang_text('{email_msg_for_activated}::{:SITE_NAME:}='.get_constant($global_constants,'site_name').'::{:BUTTON:}='.$mail_button.'::{:USER_NAME:}='.$mail_username);

            $_POST['auth'] = 1;
            $_POST['login'] = $prep_post_data['result_data']['user_login'];
            $_POST['pass'] = $_POST['user_pass'];

            $auth_after_reg = new auth();
            // письмо пользователю
            global_v::send_msg_to_email($mail_to,$mail_subject,$mail_msg);

            // письмо администратору
            if (get_constant($global_constants,'email_support_reg')==1){
                $email_variables = "{:USER_NAME:}={$prep_post_data['result_data']['user_fullname']}::{:SITE_NAME:}=".get_constant($global_constants,'site_name');
                $email_reg_msg = lang_text("{email_for_admin_new_registration_text}::$email_variables");
                global_v::send_msg_to_email(get_constant($global_constants,'email_support'),lang_text("{email_for_admin_new_registration_subject}"),$email_reg_msg);

            }

            $msg_color_for_user = 'msg_ok';

            $add_msg_user = (isset($_COOKIE['msg_for_user']))?$_COOKIE['msg_for_user']."<br>":NULL;
            setcookie('msg_for_user_color',$msg_color_for_user,time()+60,'/');
            setcookie('msg_for_user',$add_msg_user.lang_text($save_result['result_msg']),time()+60,'/');
            $url = parse_url($_SERVER['REQUEST_URI']);
            $new_url = "http://{$_SERVER['HTTP_HOST']}/profile";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: $new_url");
        } else{
            $gr = $friendly_url->url_user_data['user_default_group'];
            $friendly_url->url_user_data = $prep_post_data['result_data'];
            $friendly_url->url_user_data['user_default_group'] = $gr;
            $msg_color_for_user = 'msg_err';
        }
        $msg_for_user = lang_text($save_result['result_msg']);
    }
}
if(!empty($_POST) && isset($friendly_url->url_command['recovery_password'])){
    if (isset($_POST['user_email'])) {
        if (empty($_POST['user_email'])){
            $msg_color_for_user = 'msg_err';
        	$msg_for_user = lang_text("{required_text}");
        } else {
            // проверка уникальности email
            $field_email = mysql_real_escape_string($_POST['user_email']);
            unset($_POST['user_email']);
            $isset_article = profile_m::check_email($field_email, 0);
            if ($isset_article["result"]) {
            	$msg_color_for_user = 'msg_err';
                $msg_for_user = lang_text("{IE_3x106}");
            } else {
            	$user_data = profile_m::get_user_data_by_email($field_email);
							
            	$mail_to = $field_email;
				$mail_user_login = $user_data['result_data']['user_login'];
				$mail_username = !isset($user_data['result_data']['user_fullname'])&&strlen($user_data['result_data']['user_fullname'])>0?$user_data['result_data']['user_login']:$user_data['result_data']['user_fullname'];
	            $mail_button = global_v::create_button_for_email_msg("http://{$_SERVER['SERVER_NAME']}/profile/auth/recover_pass={$user_data['result_data']['user_id']}",lang_text('{email_action_password_recovery}'));
	            $mail_subject = lang_text('{email_action_password_recovery}');
	            $mail_msg = lang_text('{email_msg_for_password_recovery}::{:USER_NAME:}='.$mail_username.'::{:USER_MAIL:}='.$field_email.'::{:USER_LOGIN:}='.$mail_user_login.'::{:BUTTON:}='.$mail_button);
				
				// письмо пользователю
	            global_v::send_msg_to_email($mail_to,$mail_subject,$mail_msg);
	            // письмо администратору
                $email_variables = "{:USER_LOGIN:}={$mail_user_login}::{:SITE_NAME:}=".get_constant($global_constants,'site_name');
                $email_reg_msg = lang_text("{email_for_admin_new_password_recovery}::$email_variables");
                global_v::send_msg_to_email(get_constant($global_constants,'email_support'),lang_text("{email_action_password_recovery}"),$email_reg_msg);

				$msg_color_for_user = 'msg_ok';
                $msg_for_user = lang_text("{msg_password_recovery}");
			}
        }
    }
}

if (isset($friendly_url->url_command['recover_pass'])){
    // ash-1 to mal-1 по такой логике, можно сбросить пароль у любого пользователя, почему ты не использовал уникальный ключ, как при активации пользователя
	$user_id = $friendly_url->url_command['recover_pass'];
    $activate_error = false;
    $msg_color_for_user = 'msg_ok';
    $add_msg_user = (isset($_COOKIE['msg_for_user']))?$_COOKIE['msg_for_user']."<br>":NULL;	
    if (!isset($user_id) || $user_id<=0){
        $activate_error = true;
        $msg_color_for_user = 'msg_err';
        setcookie('msg_for_user',$add_msg_user.lang_text("{IE_1x111}"),time()+60,'/');
    }	
	if (!$activate_error) {
		$new_pass = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'),0,10);
        $activate_user['user_id'] = $user_id;
		$activate_user['user_pass'] = md5($new_pass);
        $result_activation = profile_m::user_password_recovery($activate_user);
        if (!$result_activation['result']){
            $msg_color_for_user = 'msg_err';
        } else {
        	// отправка подтвержения и нового пароля
        	$user_data = profile_m::get_user_data_by_id($user_id);
			
        	$mail_to = $user_data['result_data']['user_email'];
			$mail_user_login = $user_data['result_data']['user_login'];
			$mail_username = !isset($user_data['result_data']['user_fullname'])&&strlen($user_data['result_data']['user_fullname'])>0?$user_data['result_data']['user_login']:$user_data['result_data']['user_fullname'];
            $mail_button = global_v::create_button_for_email_msg("http://{$_SERVER['SERVER_NAME']}/profile/auth/",lang_text('{email_action_password_recovered_b}'));
            $mail_subject = lang_text('{email_action_password_recovered}');
            $mail_msg = lang_text('{email_msg_for_password_recovered}::{:USER_NAME:}='.$mail_username.'::{:USER_MAIL:}='.$mail_to.'::{:USER_LOGIN:}='.$mail_user_login.'::{:BUTTON:}='.$mail_button.'::{:USER_PASS:}='.$new_pass);
			
			// письмо пользователю
            global_v::send_msg_to_email($mail_to,$mail_subject,$mail_msg);
            // письмо администратору
            $email_variables = "{:USER_LOGIN:}={$mail_user_login}::{:SITE_NAME:}=".get_constant($global_constants,'site_name')."::{:USER_PASS:}=".$new_pass;
            $email_reg_msg = lang_text("{email_for_admin_new_password_recovered}::$email_variables");
            global_v::send_msg_to_email(get_constant($global_constants,'email_support'),lang_text("{email_action_password_recovery}"),$email_reg_msg);

			$msg_color_for_user = 'msg_ok';
            $add_msg_user = (isset($_COOKIE['msg_for_user']))?$_COOKIE['msg_for_user']."<br>":NULL;
            setcookie('msg_for_user_color',$msg_color_for_user,time()+60,'/');
            setcookie('msg_for_user',$add_msg_user.lang_text($user_data['result_msg']),time()+60,'/');
            $url = parse_url($_SERVER['REQUEST_URI']);
            $new_url = "http://{$_SERVER['HTTP_HOST']}/profile";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: $new_url");
        }
        setcookie('msg_for_user',$add_msg_user.lang_text($result_activation['result_msg']),time()+60,'/');
    }

    setcookie('msg_for_user_color',$msg_color_for_user,time()+60,'/');
    $new_url = "http://{$_SERVER['HTTP_HOST']}/profile";
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $new_url");
}
if (isset($friendly_url->url_command['activate']) && $auth_class->cur_user_group>0){
    $activate_arr = explode(',',$friendly_url->url_command['activate']);
    $activate_error = false;
    $msg_color_for_user = 'msg_ok';
    $add_msg_user = (isset($_COOKIE['msg_for_user']))?$_COOKIE['msg_for_user']."<br>":NULL;
    if (count($activate_arr)<2 || $auth_class->cur_user_id!=$activate_arr[0]){
        $activate_error = true;
        $msg_color_for_user = 'msg_err';
        setcookie('msg_for_user',$add_msg_user.lang_text("{IE_1x106}"),time()+60,'/');
    }
    if (!$activate_error) {
        $activate_user['user_id'] = $activate_arr[0];
        $activate_user['user_key_activated'] = $activate_arr[1];
        $activate_user['user_status'] = 1;
        $result_activation = profile_m::user_activate($activate_user);
        // ash-9 когда-нибудь дополнительную проверку на повторную активацию
        if (!$result_activation['result']){
            $msg_color_for_user = 'msg_err';
        }
        setcookie('msg_for_user',$add_msg_user.lang_text($result_activation['result_msg']),time()+60,'/');
    }
    setcookie('msg_for_user_color',$msg_color_for_user,time()+60,'/');
    $new_url = "http://{$_SERVER['HTTP_HOST']}/profile";
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $new_url");
} elseif (isset($friendly_url->url_command['recovery_password'])){
	$profile_v_right = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.recovery_password.php";
} elseif (isset($friendly_url->url_command['registration'])){
	$show_captcha = true;
    $profile_v_right = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.auth_reg_form.php";
} else {
    $profile_v_right = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.auth_form.php";
}
if ($auth_class->cur_user_group>0){
    $new_url = "http://{$_SERVER['HTTP_HOST']}/profile";
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $new_url");
}
