<?php
/**
 * products_c.function.php (admin)
 *
 * Ф-ции контроллера раздела товаров
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


function resort_array_groups_data($array,$parent_id){

    if(is_array($array) && isset($array[$parent_id])){
        foreach($array[$parent_id] as $cat){
            $tree[$cat['group_id']]['data'] = $cat;
            $tree[$cat['group_id']]['child'] = resort_array_groups_data($array,$cat['group_id']);
        }
        
        return $tree;

    } else {
        return null;
    }

}

