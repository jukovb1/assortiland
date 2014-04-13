<?
if (!defined('IN_APP')) {
    die("not in app");
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin Panel Authorization</title>
    <link rel="stylesheet" type="text/css" href="/global_scripts/auth/css/auth_form_style.css">

</head>
<body>


<div class="loginForm">
    <div class="titleForm">
        <?=lang_text('{authorization}')?>
    </div>
    <div class="contentForm">
        <h3><?=($auth_class->result_msg)?lang_text('{auth_denied}'):"&nbsp;"?></h3>
        <div class="form">
            <h4 style="color:#ff0000;margin-top: -10px;text-align: center"><?=($auth_class->result_msg)?$auth_class->result_msg:"&nbsp;"?></h4>
            <form  method="post" name="form_auth" style="margin-right:20px;" >
                <input type="hidden" name="auth" value="1">
                <img src="/global_scripts/auth/img/key.png" class="key"/>
                <?=lang_text('{auth_logon}')?>:
                <input required="required" name="login" type="text" class="inputAuth" value="<?=(isset($f_login))?$f_login:NULL?>" onfocus='this.select()' ><br />
                <?=lang_text('{auth_pass}')?>:
                <input required="required" name="pass" type="password" class="inputAuth" onfocus='this.select()' /><br />
                <input name="join" type="submit" value="<?=lang_text('{auth_enter}')?>" class="buttonAuth" />
            </form>

        </div>
        Ash-DS &copy; 2008-<?=date('Y')?>
    </div>
</div>

</body>
</html>

<?
exit();





