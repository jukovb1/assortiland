<?php
/**
 * users_v.groups_list.php (admin)
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
    var sub_area = 'users-list';
</script>
<div class="drv-top-wrapper">
    <div class="drv-common-wrapper">
        <h3 style="display: inline-block"><?=lang_text('{current_module}')?>: <?=lang_text('{'.$current_type.'}')?></h3>
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
    <div class="drv-common-pag">
        <?=$page_nav['nav_menu'];?>
    </div>
</div>
<table class="drv-content-table" style="width:100%">
    <thead>
    <tr class="drv-table-header">
        <th style="width:1%"></th>
        <th style='width:auto;'><?=lang_text('{table_user_name}')?></th>
        <th style='width:15%;'><?=lang_text('{table_user_login}')?></th>
        <th style='width:15%'><?=lang_text('{table_user_email}')?></th>
        <th style='width:15%'><?=lang_text('{table_user_groups}')?></th>
        <th style='width:15%'><?=lang_text('{table_user_status}')?></th>
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
            $def_group_data = adm_users_m::get_users_group_by_id($content_data['user_default_group']);
            $def_group_data = $def_group_data['result_data'];
            $action = 0;
            $action_text = lang_text('{user_action_hide}');
            $action_text_alt = lang_text('{user_action_show}');
            $status = lang_text('{user_status_show}');

            $status_alt = lang_text('{user_status_hide}');
            $hide_class = "";
            $status_class = 'drv-date-status';
            if ($content_data['user_status'] == 0){
                $action = 1;
                $action_text = lang_text('{user_action_show}');
                $action_text_alt = lang_text('{user_action_hide}');
                $hide_class = "hide_row";
                $status = lang_text('{user_status_hide}');
                $status_alt = lang_text('{user_status_show}');
                $status_class = 'drv-date-status-hide';
            }
            ?>
            <tr class="<?=$hide_class?> tr_<?=$content_id?>">
                <td class="sh2_<?=$content_id?>" data-cont_id="<?=$content_id?>" data-cur_status="<?=$content_data['user_status']?>"></td>
                <?

                $dop_data = "<div class='drv-item-edit' data-cont_id='{$content_id}'>";
                $dop_data .= "<a href='#' class='drv-button-edit change_status sh_$content_id' data-action='$action' data-cur_status='{$content_data['user_status']}' data-alt_text='$action_text_alt'/>$action_text</a>";
                $dop_data .= " | <a href='?id=$content_id' class='drv-button-edit' />".lang_text('{action_edit}')."</a>";
                $dop_data .= " | <a href='#' class='drv-button-delete change_status' data-action='-1' data-cur_status='{$content_data['user_status']}'/>".lang_text('{action_del}')."</a>";
				$dop_data .= " | <br/><a href='#' class='drv-button-delete change_status_in_group' data-action='1'/>".lang_text('{action_user_confirm}')."</a>";
				$dop_data .= " | <a href='#' class='drv-button-delete change_status_in_group' data-action='-1'/>".lang_text('{action_user_reject}')."</a>";
                $dop_data .= "</div>\r\n";
                ?>
                <td>
                    <div class="gender_ico gender_<?=$content_data['user_gender'];?>"></div>
                    <div style="color: <?=$def_group_data['us_group_color']?>">
                        <?=$def_group_data['us_group_prefix'].$content_data['user_fullname'].$def_group_data['us_group_sufix'].$dop_data?>
                    </div>
                </td>
                <td style="color: <?=$def_group_data['us_group_color']?>">
                    <?=$def_group_data['us_group_prefix'].$content_data['user_login'].$def_group_data['us_group_sufix']?>
                </td>
                <td>
                    <?=$content_data['user_email'];?>
                </td>
                <td>
                    <div style="color: <?=$def_group_data['us_group_color']?>">
                        <?=$def_group_data['us_group_prefix'].$def_group_data['us_group_title'][$friendly_url->url_lang['id']].$def_group_data['us_group_sufix']?>
                    </div>
                    <?
//                    if (count($content_data['user_groups'])==0){
//                        echo "<b style='color:red;'>".lang_text('{IE_1x103}')."</b>";
//                    } elseif(count($content_data['user_groups'])<=2){
//                        echo implode(', ',$content_data['user_groups']);
//                    } else {
//                        $group_list = $content_data['user_groups'];
//                        sort($content_data['user_groups']);
//                        echo "<div title='".implode(', ',$content_data['user_groups'])."'>{$content_data['user_groups'][0]}, {$content_data['user_groups'][1]}, ...</div>";
//                    }
                    ?>

                </td>

                <td>
                    <?
                    $field_data = strtotime($content_data['user_date_add']);
                    $field_data = date("d.m.Y H:i", $field_data);
                    ?>
                    <?="$field_data<div class='$status_class status_txt_$content_id' data-alt_text='$status_alt'>$status</div>\r\n"?>
                </td>


                <td class="del_status">
                    <?=$content_data['user_fullname'];?> <?=" - <div style='display:inline-block;' class='drv-item-edit visi' data-cont_id='{$content_id}'><span>".lang_text('{user_status_del}')."</span> | <a href='#' data-action='{$content_data['user_status']}' class='drv-button-edit change_status' data-cur_status='-1'/>".lang_text('{action_recovery}')."</a></div>"?></td>
            </tr>
            <?
        }

    }
    ?>
    </tbody>
    <tfoot>
    </tfoot>
</table>