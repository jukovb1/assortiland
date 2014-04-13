<?php
/**
 * products_to_head_v.php (admin)
 *
 * Дополнительная инициализация для товаров
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
$select_ids = '';
if(isset($content_by_id_data) && $content_by_id_data['result'] && isset($content_by_id_data['result_data']['params'])){
    foreach($content_by_id_data['result_data']['params'] as $param_id=>$param_data){
        if ($param_data['param_type']==5 || $param_data['param_type']==6){
            $select_ids .= ",#pr_edit_param_$param_id";
        }
    }
}
?>
<script>
    var params = {
        changedEl: "#sort,#product_user_id<?=$select_ids?>",
        scrollArrows: true
    };
    var global_percents = {};
    global_percents[0] = <?=$commercial_const['site_commerce_min']?>;
    global_percents[1] = <?=$commercial_const['site_commerce_middle']?>;
    global_percents[2] = <?=$commercial_const['site_commerce_high']?>;
</script>