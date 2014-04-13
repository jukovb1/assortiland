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
<script>
    var sub_area = 'products-list';
</script>
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
        <?=$page_nav['nav_menu'];?>
    </div>
</div>
<table class="drv-content-table" style="width:100%">
    <thead>
    <tr class="drv-table-header">
        <th style="width:1%"><input type="checkbox" id="chbx_top_select_all_chbx" value="1" class="niceCheck select_all_chbx" tabindex="1" /></th>
        <th style='width:auto;'><?=lang_text('{table_product_name}')?></th>
        <th style='width:15%'><?=lang_text('{table_product_groups}')?></th>
        <th style='width:15%'><?=(!empty($dop_fields_for_table_list[10]['param_new_name']))?$dop_fields_for_table_list[10]['param_new_name']:$dop_fields_for_table_list[10]['param_name']?></th>
        <th style='width:15%'><?=lang_text('{table_product_status}')?></th>
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
        foreach ($content_by_group as $content_id => $content_data) {
            $action = 0;
            $action_text = lang_text('{action_hide}');
            $action_text_alt = lang_text('{action_show}');
            $status = lang_text('{status_show}');

            $status_alt = lang_text('{status_hide}');
            $hide_class = "";
            $status_class = 'drv-date-status';
            if ($content_data['product_status'] == 0){
                $action = 1;
                $action_text = lang_text('{action_show}');
                $action_text_alt = lang_text('{action_hide}');
                $hide_class = "hide_row";
                $status = lang_text('{status_hide}');
                $status_alt = lang_text('{status_show}');
                $status_class = 'drv-date-status-hide';
            }
            ?>
            <tr class="<?=$hide_class?> tr_<?=$content_id?>">
                <td class="sh2_<?=$content_id?>" data-cont_id="<?=$content_id?>" data-cur_status="<?=$content_data['product_status']?>"><input type="checkbox" name="chbx[<?=$content_id?>]" value="1" class="check_item niceCheck" id="chbx_<?=$content_id?>" tabindex="1" /></td>
                <?

                $dop_data = "<div class='drv-item-edit' data-cont_id='{$content_id}'>";
                $dop_data .= "<a href='#' class='drv-button-edit change_status sh_$content_id' data-action='$action' data-cur_status='{$content_data['product_status']}' data-alt_text='$action_text_alt'/>$action_text</a>";
                $dop_data .= " | <a href='?id=$content_id' class='drv-button-edit' />".lang_text('{action_edit}')."</a>";
                $dop_data .= " | <a href='#' class='drv-button-delete change_status' data-action='-1' data-cur_status='{$content_data['product_status']}'/>".lang_text('{action_del}')."</a>";
                $dop_data .= "</div>\r\n";
                ?>
                <td>
                    <?=$content_data['dop_field_2'];?>
                    <?="(".$content_data['product_article'].")".$dop_data?>
                </td>
                <td>
                    <?
                    if (count($content_data['product_groups'])==0){
                        echo "<b style='color:red;'>".lang_text('{IE_1x103}')."</b>";
                    } elseif(count($content_data['product_groups'])<=2){
                        echo implode(', ',$content_data['product_groups']);
                    } else {
                        $group_list = $content_data['product_groups'];
                        sort($content_data['product_groups']);
                        echo "<div title='".implode(', ',$content_data['product_groups'])."'>{$content_data['product_groups'][0]}, {$content_data['product_groups'][1]}, ...</div>";
                    }
                    ?>

                </td>
                <td>
                    <?=$content_data['dop_field_10'];?>
                </td>
                <td>
                    <?
                    $field_data = strtotime($content_data['product_date']);
                    $field_data = date("d.m.Y H:i", $field_data);
                    ?>
                    <?="$field_data<div class='$status_class status_txt_$content_id' data-alt_text='$status_alt'>$status</div>\r\n"?>
                </td>


                <td class="del_status">
                    <?=$content_data['dop_field_2'];?> <?="(".$content_data['product_article'].")"?><?=" - <div style='display:inline-block;' class='drv-item-edit visi' data-cont_id='{$content_id}'><span>".lang_text('{status_del}')."</span> | <a href='#' data-action='{$content_data['product_status']}' class='drv-button-edit change_status' data-cur_status='-1'/>".lang_text('{action_recovery}')."</a></div>"?></td>
            </tr>
            <?
        }

    }
    ?>
    </tbody>
    <tfoot>
    </tfoot>
</table>