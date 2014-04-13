<?php
/**
 * main_menu_m.php (admin)
 *
 * Модель главного меню админки
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

// компоненты меню
$main_menu['dashboard']=array();
$main_menu['content'] = array(
    'sub_menu'=> (isset($content_sub_menu))?$content_sub_menu:NULL,
);
//$main_menu['comments'] = array();
$main_menu['adm_users'] = array(
    'sub_menu'=> array(
        'users-groups'=>array(),
        'users-rights'=>array(),
        'users-list'=>array(),
        'users-wait'=>array(),
    )
);
$main_menu['options'] = array();
//$main_menu['files'] = array();
$main_menu['adm_products'] = array(
    'sub_menu'=> array(
        'products-groups'=>array(),
        'products-list'=>array(),
    )
);
$main_menu['statistic'] = array(
    'sub_menu'=> array(
        'statistic-0'=>array(), // аннулированные
        'statistic-1'=>array(), // ожидают подтверждения
        'statistic-2'=>array(), // подтверждён
        'statistic-3'=>array(), // Оплачен
        'statistic-4'=>array(), // закрыт
        'order_input'=>array(), // закрыт
    )
);


// todo ash-0 для наглядности прогресса разработки, отображение готовности в меню

$module_completed['dashboard']=false;
$module_completed['options']=true;
$module_completed['content']=false;
$module_completed['adm_users']=false;
$module_completed['adm_products']=true;
