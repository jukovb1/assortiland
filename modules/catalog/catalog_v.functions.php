<?php
/**
 * catalog_v.function.php (front)
 *
 * Функции представления каталога
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

/**
 * breadcrumbs_create()
 * @description Построение хлебных крошек
 *
 * @return array
 * Возвращает массив списка групп
 **/
function breadcrumbs_create($category_array,$cat_parent){
    global $catalog,$link_marketplace;
    $return = array();
    if ($cat_parent!=0){
        foreach($category_array as $cat_data){
            if (isset($cat_data[$cat_parent])){

                $return2 = breadcrumbs_create($category_array,$cat_data[$cat_parent]['group_parent_group']);
                if (!is_null($return2)) {
                    $return = $return + $return2;
                }
                $return[$cat_parent]=" <a href='/$catalog/{$cat_data[$cat_parent]['group_short_name']}/$link_marketplace'>{$cat_data[$cat_parent]['group_full_name']}</a> /";
            }
        }
        return $return;
    } else {
        return NULL;
    }


}