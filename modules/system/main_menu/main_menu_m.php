<?php
/**
 * main_menu_m.php
 *
 * Модель главного меню фронта
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

$auth_menu[0]['auth'] = array(
    'url'   =>  "/profile/auth",
    'anchor'=>  lang_text('{auth_enter}'),
);
$auth_menu[0]['registration'] = array(
    'url'   =>  "/profile/auth/registration",
    'anchor'=>  lang_text('{auth_registration}'),
);
$auth_menu[0]['cart'] = array(
    'url'   =>  "/profile/cart",
    'anchor'=>  lang_text('{auth_cart}'),
);


$auth_menu[1]['profile'] = array(
    'url'   =>  "/profile",
    'anchor'=>  lang_text('{auth_profile}'),
);
$auth_menu[1]['cart'] = array(
    'url'   =>  "/profile/cart",
    'anchor'=>  lang_text('{auth_cart}'),
);
$auth_menu[1]['logout'] = array(
    'url'   =>  "/logout",
    'anchor'=>  lang_text('{auth_logout}'),
);


// main-menu меню
$static_main_menu['main']['main']=array(
    'url'       => '/',
    'lang_label'=> 'main_menu',
	'sub_title' => 'main_submenu',
);
$static_main_menu['main']['catalog']=array(
    'url'       => '/catalog',
    'lang_label'=> 'catalog_menu',
	'sub_title' => 'catalog_submenu',
);
$static_main_menu['main']['about']=array(
    'url'       => '/pages/about',
    'lang_label'=> 'about_menu',
	'sub_title' => 'about_submenu',
);
$static_main_menu['main']['sellers']=array(
    'url'       => '/sellers',
    'lang_label'=> 'sellers_menu',
	'sub_title' => 'sellers_submenu',
);
