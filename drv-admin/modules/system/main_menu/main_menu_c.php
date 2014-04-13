<?php
/**
 * main_menu_c.php (admin)
 *
 * Контроллер главного меню админки
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

require_once('main_menu_m.class.php');
$content_sub_menu = main_menu_m::get_content_types_for_sub_menu();
require_once('main_menu_m.php');



require_once('main_menu_v.php');