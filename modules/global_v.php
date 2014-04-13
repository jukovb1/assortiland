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
// todo ash-1 вынести весь текст в языковые файлы
?>

<!DOCTYPE HTML>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Description" content="<?=(isset($global_template['for_meta_desc']))?$global_template['for_meta_desc']:$global_constants['site_description'];?>" />
    <meta name="Keywords" content="<?=(isset($global_template['for_meta_keys']))?$global_template['for_meta_keys']:$global_constants['site_keywords'];?>" />
    <?=($global_template['for_canonical']) ? "<link rel='canonical' href='{$global_template['for_canonical_text']}' />" : NULL; ?>
    <?=($global_template['for_noindex']) ? "<meta name='robots' content='none'>" : NULL; ?>

    <title><?=get_constant($global_constants,'site_name')?> | <?=($global_template['for_title'])?$global_template['for_title_text']:lang_text('{control_site}');?></title>

    <link rel="stylesheet" href="/assets/css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/anythingslider.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/.global/editor.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery-ui.css">

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
    echo (isset($comments_class))?$comments_class->require_js_and_css_files():NULL;

    ?>

</head>
<body data-lang_abbr="<?=$friendly_url->url_lang['abbr']?>">
<div class="dark_bg" style="display: <?=(!empty($msg_for_user))?"block":"none";?>">
    <div class="popup <?=($msg_color_for_user!="inherit")?$msg_color_for_user:"";?>" id="result_ajax"><?=(!empty($msg_for_user))?"$msg_for_user":NULL;?></div>
</div>
<div class="global">
    <div class="top">
        <div class="center">
            <?=(function_exists('print_menu_from_constants'))?print_menu_from_constants($site_main_menu, 'top-menu'):null;?>
            <?
            $auth_menu_set = ($auth_class->cur_user_group>0)?1:0;
            echo (function_exists('print_auth_menu'))?print_auth_menu($auth_menu[$auth_menu_set], 'auth'):null;
            ?>
        </div>
    </div>
    <div class="header">
        <div class="center">
            <h1 class="h-logo"><a href="/" title="<?=get_constant($global_constants,'site_name')?> <?=lang_text('{slogan}')?>"></a></h1>
            <div><?=print_menu_by_place('main', 'main-menu')?></div>
        </div>
    </div>
    <?
    if(isset($global_template["for_content"])){
        require_once($global_template["for_content"]);
    }
    // SEO поля для продвижения необходимых страниц
    // проверка была лишней, т.к. индекс for_meta_desc определён в контроллере
    echo '<div class="page-desc"><p>'.$global_template["for_meta_desc"].'</p></div>';
    ?>
    <!-- End Main Wrapper -->

    <div class="footer">
        <div class="prefooter">
            <div class="center">
                <div class="thfooter">
                    <div class="sub-title">
                        <?=get_constant($global_constants,'footer_info_title')?>
                    </div>
                    <div class="contacts">
                        <?=get_constant($global_constants,'footer_info_content')?>
                    </div>
                </div>
                <div class="thfooter">
                    <div class="sub-title"><?=lang_text('{footer_statistic_title}')?></div>
                    <ul>
                        <li class="f-c" title="Общее количество товаров">
                            <div class="qty"><?=$footer_statistic['products']?></div>
                            <div class="f-name"><?=lang_text('{footer_statistic_count_products}')?></div>
                        </li>
                        <li class="s-c" title="Общее количество продавцов">
                            <div class="qty"><?=$footer_statistic['sellers']?></div>
                            <div class="f-name"><?=lang_text('{footer_statistic_count_sellers}')?></div>
                        </li>
                        <li class="t-c" title="Общее количество зарегестрированных партнеров">
                            <div class="qty"><?=$footer_statistic['partners']?></div>
                            <div class="f-name"><?=lang_text('{footer_statistic_count_partners}')?></div>
                        </li>
                    </ul>
                </div>
                <div class="thfooter">
                    <div class="sub-title"><?=lang_text('{quotes_slider_name}')?></div>
                    <div class="quotes-slider-wrapper">
                        <?php
                        if(!empty($quote_sliders)) {
                            ?>
                            <ul id="quote-slider">
                                <?php
                                foreach($quote_sliders as $quote_name=>$quote_content) {
                                    ?>
                                    <li>
                                        <div class="l-q"></div>
                                        <p><?= $quote_content ?></p>
                                        <div class="r-q"></div>
                                        <h5 class="author"><?= $quote_name ?></h5>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottomfooter">
            <div class="center">
                <?=(function_exists('print_menu_from_constants'))?print_menu_from_constants($site_main_menu, 'top-menu'):null;?>
                <div class="copyright">
                    <a href="http://derivo.com.ua/" title="Студия веб-дизайна и разработки — Derivo Creative Studio">Разработка сайта <strong>Derivo</strong></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
