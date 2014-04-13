<?php
/**
 * main_menu_c.functions.php
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
if (!defined('IN_APP')) {
    die("not in app");
}
/**
 * print_menu_by_place($menu_type, $menu_class='')
 * @param $menu_type string - индекс массива
 * @param $menu_class string - css класс
 * @description построение меню по индексу
 *
 * @return string
 */
function print_menu_by_place($menu_type, $menu_class=''){
    global $static_main_menu;

    if(isset($static_main_menu[$menu_type])) {
        return print_menu_by_class($static_main_menu[$menu_type], $menu_class);
    } else {
        return NULL;
    }
}

