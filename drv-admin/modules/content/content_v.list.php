<?php
/**
 * content_v.php (admin)
 *
 * Представление страницы контента
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
        <h3 style="display: inline-block"><?=lang_text('{current_module}')?>: <?=$current_type['type_title']?></h3>
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
        <?
        $i=0;
        foreach($current_type['type_field_for_table'] as $key=>$tmp){
            $i++;
            $w = 'auto';
            if ($key == 'cont_date'
                || $key == 'cont_user_id') {
                $w = '15%';
            }
            $ths[] = "<th style='width:$w'>{$current_type['type_field_names'][$key]}</th>";
        }
        echo implode('',$ths);
        ?>
    </tr>
    </thead>
    <tbody>
    <?
    if ($content_by_group['result']==false){
        ?>
        <tr>
            <td class="no_data_td"><?=lang_text($content_by_group['result_msg'])?></td>
        </tr>
    <?
    } else {
        foreach ($content_by_group['result_data'] as $content_id => $content_data) {
            $action = 0;
            $action_text = lang_text('{action_hide}');
            $action_text_alt = lang_text('{action_show}');
            $status = lang_text('{status_show}');
            $status_alt = lang_text('{status_hide}');
            $hide_class = "";
            $status_class = 'drv-date-status';
            if ($content_data['cont_status'] == 0){
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
                <td class="sh2_<?=$content_id?>" data-cont_id="<?=$content_id?>" data-cur_status="<?=$content_data['cont_status']?>"><input type="checkbox" name="chbx[<?=$content_id?>]" value="1" class="check_item niceCheck" id="chbx_<?=$content_id?>" tabindex="1" /></td>
                <?
                $i=0;

                foreach($current_type['type_field_for_table'] as $key=>$tmp){
                    $i++;
                    if (is_array($content_data[$key])){
                        $field_data = $content_data[$key][$friendly_url->url_lang['id']];
                    } else {
                        $field_data = $content_data[$key];
                    }

                    $dop_data = '';
                    if ($key == 'cont_title') {
                        $name_for_dop_td = $field_data;
                        $dop_data .= "<div class='drv-item-edit' data-cont_id='{$content_id}'>";
                        $dop_data .= "<a href='#' class='drv-button-edit change_status sh_{$content_id}' data-action='$action' data-cur_status='{$content_data['cont_status']}' data-alt_text='$action_text_alt'/>$action_text</a>";
                        $dop_data .= " | <a href='?id=$content_id' class='drv-button-edit' />".lang_text('{action_edit}')."</a>";
                        $dop_data .= " | <a href='#' class='drv-button-delete change_status' data-action='-1' data-cur_status='{$content_data['cont_status']}'/>".lang_text('{action_del}')."</a>";
                        $dop_data .= "</div>\r\n";

                    } elseif ($key == 'cont_date') {
                        $field_data = strtotime($field_data);
                        $field_data = date("d.m.Y H:i", $field_data);
                        $dop_data .= "<div class='$status_class status_txt_$content_id' data-alt_text='$status_alt'>$status</div>\r\n";

                    } elseif ($key == 'cont_user_id') {
                        $field_data = global_m::get_user_data_by_id($field_data);
                        if ($field_data['result']) {
                            $field_data = $field_data['result_data']['user_login'];
                        } else {
                            $field_data = "";
                        }
                    }
                    ?>
                    <td>
                        <?=$field_data.$dop_data?>
                    </td>

                <?
                }
                $dop_data .= "";

                ?>
                <td class="del_status"><?="\"$name_for_dop_td\" - <div style='display:inline-block;' class='drv-item-edit visi' data-cont_id='{$content_id}'><span>".lang_text('{status_del}')."</span> | <a href='#' data-action='{$content_data['cont_status']}' class='drv-button-edit change_status' data-cur_status='-1'/>".lang_text('{action_recovery}')."</a></div>"?></td>
            </tr>
        <?
        }

    }
    ?>
    </tbody>
    <tfoot>
    </tfoot>
</table>