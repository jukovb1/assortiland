<?php
/**
 * catalog_c.function.php (front)
 *
 * функции контроллера каталога
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

function group_by_recursion($current_id,$parent_id,$content_by_group){

//    foreach($content_by_group as $dd){
//        $new_arr[$parent_id] = $current_id;
//        if(!is_null($current_id) && $dd['data']['group_id'] != $current_id){
//            $selected = "";
//            if ($dd['data']['group_id'] == $parent_id){
//                $selected = "selected='selected'";
//            }
//            if (count($dd['child'])>0){
//                group_by_recursion($current_id,$dd['data']['group_id'],$dd['child']);
//            }
//        }
//    }
//    return $new_arr;
}
