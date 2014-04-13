<?php
/**
 * global_v.php (admin)
 *
 * Главное представление админки
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

<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name='robots' content='none'>
    <title><?=$global_constants['site_name']?> | <?=($global_template['for_title'])?$global_template['for_title_text']:lang_text('{control_site}');?></title>

    <link rel="stylesheet" type="text/css" href="/assets/css/admin/drv-admin.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/admin/drv-flags.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/.global/editor.css">

    <link href='http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
    <?=$global_js_scripts_list?>
    <?=$local_js_scripts_list?>
    <?
    if(isset($global_template["for_head"])){
        echo "\n    <!-- Additional scripts -->\n";
        require_once($global_template["for_head"]);
    }

    // в нужных модулях подключатся js и css файлы для класса multiple_checkbox
    echo (isset($multiple_checkbox))?$multiple_checkbox->require_js_and_css_files():NULL;

    ?>

</head>
<body data-lang_abbr="<?=$friendly_url->url_lang['abbr']?>" data-confirm_text="<?=lang_text('{confirm_text}')?>" data-admin_folder="<?=$adm_folder?>">
<div class="dark_bg" style="display: <?=(!empty($msg_for_user))?"block":"none";?>">
    <div class="popup <?=($msg_color_for_user!="inherit")?$msg_color_for_user:"";?>" id="result_ajax"><?=(!empty($msg_for_user))?"$msg_for_user":NULL;?></div>
</div>
<div class="drv-wrapper">
    <div class="drv-menu-wrapper">
        <h1 class="a-logo"><a href="<?=$path_index?>" target="_blank" title="<?=$global_constants['site_name']?> <?=lang_text('{slogan}')?>"><?=$global_constants['site_name']?></a></h1>
        <?
        if(isset($main_menu_path)){
            require_once($main_menu_path);
        }
        ?>
    </div>
    <div class="hide_menu" title="<?=lang_text("{hide_menu}")?>" data-alt_title="<?=lang_text("{show_menu}")?>"><div></div></div>

    <div class="drv-content-wrapper">
        <div class="drv-body">
            <div class="drv-content">
                <div class="drv-content-header">
                    <?
                    $img_path = "/assets/images/admin/icon-$_cur_area-big.png";
                    if (!file_exists($_SERVER['DOCUMENT_ROOT'].$img_path)){
                        $img_path = "/assets/images/admin/icon-404-big.png";
                    }
                    ?>
                    <h1><img src="<?=$img_path?>" class="drv-header-iamge" /><?=lang_text('{module_name}')?></h1>
                </div>
                <div class="drv-common-posts">
                    <?
                    if(isset($global_template["for_content"])){
                        require_once($global_template["for_content"]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="drv-wrapper-copyright">
    <p><span><?=lang_text('{copy_thank}')?> <a target="_blank" href="http://derivo.com.ua/" title="Студия веб-дизайна и разработки &mdash; Derivo Creative Studio">Derivo Creative Studio</a>.</span></p>
</div>
</body>
</html>