<?php
/**
 * error_control.functions.php
 *
 * Набор функций для контроля ошибок
 *
 * Данный файл НЕ является частью системы управления контентом
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
if (!defined('IN_APP')) {
    die("not in app");
}


if (!$GLOBALS["is_local_start"]) {
    ini_set('display_errors',0);
}

if (!isset($do_not_redirect_error_function)) {
    error_reporting(E_ALL);
    set_error_handler('my_error_log');
    register_shutdown_function("my_shutdown_function");
}

function my_error_log($errno, $errmsg, $file, $line, $errcontext="", $add_subj_data="")
{
    if(isset($GLOBALS["my_error_log_dont_process"]) and $GLOBALS["my_error_log_dont_process"]){
        return false;
    }
    // время события
    $timestamp = date("Y M d H:i:s");

    $error_texts[0]="MY_ERROR";
    $error_texts[1]="E_ERROR";
    $error_texts[2]="E_WARNING";
    $error_texts[4]="E_PARSE";
    $error_texts[8]="E_NOTICE";
    $error_texts[16]="E_CORE_ERROR";
    $error_texts[32]="E_CORE_WARNING";
    $error_texts[64]="E_COMPILE_ERROR";
    $error_texts[128]="E_COMPILE_WARNING";
    $error_texts[256]="E_USER_ERROR";
    $error_texts[512]="E_USER_WARNING";
    $error_texts[1024]="E_USER_NOTICE";
    $error_texts[2048]="E_STRICT";
    $error_texts[4096]="E_RECOVERABLE_ERROR";
    $error_texts[6143]="E_ALL";
    $error_texts[8192]="E_DEPRECATED";
    $error_texts[16384]="E_USER_DEPRECATED";

    if ($errno===2048) {
        return true;
    }

    if (isset($error_texts[$errno])){
        $error_text=$error_texts[$errno];
    }else {
        $error_text=$errno;
    }

    //формируем новую строку в логе
    $err_str = $error_text.' ';
    $err_str .= $add_subj_data.' ';
    $err_str .= $file.' ';
    $err_str .= $line.' ';
    $err_str .= htmlspecialchars($errmsg)."\n";


    //обрати внимание на функцию, которой мы пишем лог.
    error_log($err_str, 0);

    if ($GLOBALS["is_local_start"]) {
        echo nl2br($err_str);
    }else {
        $err_str .= "\nURL: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\n";
        if (isset($_SERVER["HTTP_REFERER"])) {
            $err_str .= "\nRefferer: ".$_SERVER["HTTP_REFERER"]."\n";
        }

        $client_ip = ( !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : ( ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : getenv('REMOTE_ADDR') );
        $err_str .= "\nFrom IP: ".$client_ip."\n";

        $mail_to=$GLOBALS["error_control_email"];
        $return_mail="server@".$_SERVER['SERVER_NAME'];
        $headers= "From: my_error_log <$return_mail>\n";
        $headers .= "X-Sender: <$return_mail>\n";
        $headers .= "X-Mailer: Robot\n";
        $headers .= "Return-Path: <$return_mail>\n";
        $headers.="Content-Type: text; charset=Windows-1251\n";
        $subject= $add_subj_data.' '.$error_text.' '.$file.' '.$line;
        $msg=$err_str;
        mail($mail_to, $subject, $timestamp." ".$err_str, $headers);
    }
    return true;
}

function my_shutdown_function() {
    //Ошибки которые не отлавливаются set_error_handler
    $haltCodes = array(E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING, 4096);

    $error = error_get_last();
    if ($error && in_array($error['type'], $haltCodes)) {
        my_error_log($error['type'], $error['message'], $error['file'], $error['line']);
    }
}

