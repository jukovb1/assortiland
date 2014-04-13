<?php
/**
 * products_v.function.php (admin)
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


function print_group_tree_table($content_by_group){
    foreach ($content_by_group as $content_id => $content_data_arr) {
        $content_data = $content_data_arr['data'];
        $action = 0;
        $action_text = lang_text('{action_hide}');
        $action_text_alt = lang_text('{action_show}');
        $status = lang_text('{status_show}');
        $status_alt = lang_text('{status_hide}');
        $hide_class = "";
        $status_class = 'drv-date-status';
        if ($content_data['group_status'] == 0){
            $action = 1;
            $action_text = lang_text('{action_show}');
            $action_text_alt = lang_text('{action_hide}');
            $hide_class = "hide_row";
            $status = lang_text('{status_hide}');
            $status_alt = lang_text('{status_show}');
            $status_class = 'drv-date-status-hide';
        }
        ?>
        <tr data-parent="<?=$content_data['group_parent_group']?>" data-cont_id="<?=$content_id?>" class="<?=$hide_class?> tr_<?=$content_id?>">
            <td class="sh2_<?=$content_id?>" data-cont_id="<?=$content_id?>" data-cur_status="<?=$content_data['group_status']?>"><input type="checkbox" name="chbx[<?=$content_id?>]" value="1" class="check_item niceCheck" id="chbx_<?=$content_id?>" tabindex="1" /></td>
            <?
            $content_data_nesting = adm_products_m::check_group_nesting($content_id,0) - 1;
            $w = ($content_data_nesting>=3)?$content_data_nesting*3:$content_data_nesting*2;
            $space = ($content_data_nesting>1)?"<div class='paragraph2' style='width: {$w}5px'></div>":"";
            $paragraph = ($content_data_nesting>0)?"$space<div class='paragraph'></div>":"";

            $name_for_dop_td = $content_data['group_full_name'];
            $dop_data = " <div class='drv-item-edit' data-cont_id='{$content_id}'>";
            $dop_data .= "<a href='#' class='drv-button-edit change_status sh_$content_id' data-action='$action' data-cur_status='{$content_data['group_status']}' data-alt_text='$action_text_alt'/>$action_text</a>";
            $dop_data .= " | <a href='?id=$content_id' class='drv-button-edit' />".lang_text('{action_edit}')."</a>";
            $dop_data .= " | <a href='#' class='drv-button-delete change_status' data-action='-1' data-cur_status='{$content_data['group_status']}'/>".lang_text('{action_del}')."</a>";
            $dop_data .= "</div>\r\n";

            ?>
            <td>
                <?=$paragraph.$content_data['group_full_name'].$dop_data?>
            </td>
            <td>
                <?="<div class='$status_class status_txt_$content_id' data-alt_text='$status_alt'>$status</div>\r\n"?>
            </td>
            <td class="del_status"><?="$paragraph \"$name_for_dop_td\" - <div style='display:inline-block;' class='drv-item-edit visi' data-cont_id='{$content_id}'><span>".lang_text('{status_del}')."</span> | <a href='#' data-action='{$content_data['group_status']}' class='drv-button-edit change_status' data-cur_status='-1'/>".lang_text('{action_recovery}')."</a></div>"?></td>
        </tr>
        <?
        if (count($content_data_arr['child'])>0){
            print_group_tree_table($content_data_arr['child']);
        }
    }
}
function print_group_tree_options($current_id,$parent_id,$content_by_group){

    foreach($content_by_group as $dd){
        if(!is_null($current_id) && $dd['data']['group_id'] != $current_id){
            $selected = "";
            if ($dd['data']['group_id'] == $parent_id){
                $selected = "selected='selected'";
            }
            $content_data_nesting = adm_products_m::check_group_nesting($dd['data']['group_id'],0)-1;
            $w = ($content_data_nesting==0)?"|__":str_repeat("".str_repeat("&nbsp",4),$content_data_nesting)."|__";

            echo "<option $selected value='{$dd['data']['group_id']}'> $w {$dd['data']['group_full_name']}</option>\r\n";

            if (count($dd['child'])>0){
                print_group_tree_options($current_id,$parent_id,$dd['child']);
            }
        }
    }
}
