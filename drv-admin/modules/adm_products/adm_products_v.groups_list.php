<?php
/**
 * products_v.groups_list.php (admin)
 *
 * Представление страницы групп товаров
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
<div class="drv-top-wrapper">
    <div class="drv-common-wrapper">
        <h3 style="display: inline-block"><?=lang_text('{current_module}')?>: <?=lang_text('{'.$current_type.'}')?></h3>
        <button class="drv-button redirect_button" data-redirect="?id=add" type="button"><?=lang_text('{add_button}')?></button>

    </div>
    <form class="search-form" action="/search" method="get">
        <fieldset>
            <div class="row">
                <input type="text" name="keywords" placeholder="<?=lang_text('{search_value}')?>" value="" class="">
                <div id="searchsubmit"></div>
            </div>
        </fieldset>
    </form>
</div>
<div class="drv-top-wrapper">
    <div class="drv-common-sort">
        <select id="sort" name="sort" class="wid100">
            <option value="NULL"><?=lang_text('{action_default}')?></option>
            <option value="1"><?=lang_text('{action_show}')?></option>
            <option value="0"><?=lang_text('{action_hide}')?></option>
            <option style="color: red" value="-1"><?=lang_text('{action_del}')?></option>
        </select>
        <button class="drv-save confirm_action"><?=lang_text('{action_button}')?></button>
    </div>
    <div class="drv-common-pag">
        <? // todo ash-0 тут должна быть пагинация, но думаю, что для этого раздела она не нужна?>
    </div>
</div>
<table class="drv-content-table" style="width:100%">
    <thead>
    <tr class="drv-table-header">
        <th style="width:1%"><input type="checkbox" id="chbx_top_select_all_chbx" value="1" class="niceCheck select_all_chbx" tabindex="1" /></th>
        <th style='width:auto;'><?=lang_text('{table_group_name}')?></th>
        <th style='width:15%'><?=lang_text('{table_group_status}')?></th>
    </tr>
    </thead>
    <tbody>
    <?
    if (count($content_by_group)<=0){
        ?>
        <tr>
            <?
            ?>
            <td class="no_data_td"><?=lang_text('{IE_1x102}')?></td>
        </tr>
    <?
    } else {

        print_group_tree_table($content_by_group);

    }
    ?>
    </tbody>
    <tfoot>
    </tfoot>
</table>