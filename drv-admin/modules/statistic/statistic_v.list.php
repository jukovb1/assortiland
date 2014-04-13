<?php
/**
 * statistic_v.php (admin)
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
        <h3 style="display: inline-block"><?=lang_text('{current_module}')?>:
             <span style="color: <?=$statuses[$current_status]?>">
                <?=lang_text("{{$current_statistic_type}}")?>
            </span>

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
            <?
            if ($_cur_area_sub=='statistic-0'){
                echo ' <option>N/A</option>';
            }

            if($_cur_area_sub!='statistic-0'){
                ?>
                <option value="0" style="color: <?=$statuses[0]?>"><?=lang_text('{action_0}')?></option>
                <?
            }
            if($_cur_area_sub=='statistic-2'){
                ?>
                <option value="3" style="color: <?=$statuses[3]?>"><?=lang_text('{action_3}')?></option>
                <?
            }
            if($_cur_area_sub=='statistic-3'){
                ?>
                <option value="4" style="color: <?=$statuses[4]?>"><?=lang_text('{action_4}')?></option>
                <?
            }
            ?>
        </select>
        <button class="drv-save confirm_action"><?=lang_text('{action_button}')?></button>
    </div>
    <div class="drv-common-pag">
        <?=$page_nav['nav_menu'];?>

    </div>
</div>
<table class="drv-content-table align_top_table" style="width:100%">
    <thead>
    <tr class="drv-table-header">
        <th style="width:1%"><input type="checkbox" id="chbx_top_select_all_chbx" value="1" class="niceCheck select_all_chbx" tabindex="1" /></th>
        <th style='width:auto'><?=lang_text("{order_index}")?></th>
        <th style='width:auto'><?=lang_text("{order_product}")?></th>
        <th style='width:auto'><?=lang_text("{order_buyer}")?></th>
        <th style='width:auto'><?=lang_text("{order_seller}")?></th>
        <th style='width:auto'><?=lang_text("{order_partner}")?></th>
        <th style='width:auto'><?=lang_text("{order_dates}")?></th>
    </tr>
    </thead>
    <tbody>
    <?
    if ($statistic_by_group['result']==false){
        ?>
        <tr>
            <td class="no_data_td"><?=lang_text($statistic_by_group['result_msg'])?></td>
        </tr>
    <?
    } else {
        foreach ($statistic_by_group['result_data'] as $statistic_data) {
            $statistic_id = $statistic_data['order_id'];
            $action = 0;
            $action_text = lang_text('{action_hide}');
            $action_text_alt = lang_text('{action_show}');
            $status = lang_text('{status_show}');
            $status_alt = lang_text('{status_hide}');
            $hide_class = "";
            $status_class = 'drv-date-status';
            if ($statistic_data['order_status'] == 0){
                $action = 1;
                $action_text = lang_text('{action_show}');
                $action_text_alt = lang_text('{action_hide}');
                $hide_class = "hide_row";
                $status = lang_text('{status_hide}');
                $status_alt = lang_text('{status_show}');
                $status_class = 'drv-date-status-hide';
            }

            $cur_percents = $cur_percents_text = $statistic_data['order_product_customer_percent'];
            $total_price = $statistic_data['order_product_price']*$statistic_data['order_product_count'];
            if ($statistic_data['order_partner_user_id']>0){
                $cur_percents = $statistic_data['order_product_customer_percent']/2;
                $cur_percents_text = $statistic_data['order_product_customer_percent']."% / 2 = $cur_percents";
            }
            $profit_site = ceil($total_price/100*$cur_percents);
            $profit_seller = $total_price - ceil($total_price/100*$statistic_data['order_product_customer_percent']);
            ?>
            <tr class="<?=$hide_class?> tr_<?=$statistic_id?>">
                <td class="sh2_<?=$statistic_id?>" data-cont_id="<?=$statistic_id?>" data-cur_status="<?=$statistic_data['order_status']?>"><input type="checkbox" name="chbx[<?=$statistic_id?>]" value="1" class="check_item niceCheck" id="chbx_<?=$statistic_id?>" tabindex="1" /></td>
                <td>
                    <?=$statistic_data['order_index']?>
                    <br>
                    <a class="show_order_info" href='#' title="">
                        <?=lang_text("{statistic_fulltext}")?>
                    </a>
                    <div class="hidden_info">
                        <h3>
                            <?=$statistic_data['order_index']?>
                            <span style="color: <?=$statuses[$statistic_data['order_status']]?>">
                                (<?=lang_text('{action_'.$statistic_data['order_status'].'}')?>)
                            </span>
                        </h3>
                        <?=$statistic_data['order_fulltext']?>
                    </div>
                </td>
                <td>
                    <a target='_blank' href='/product/<?=$statistic_data['order_product_article']?>'>
                        <?=$statistic_data['order_product_title']?>
                        <br>
                        (<?=$statistic_data['order_product_article']?>)
                    </a>
                    <br>
                    <br>
                    <div title="<?=lang_text("{statistic_price_title}")?>">
                        <?=lang_text("{statistic_price}")?>: <?=$statistic_data['order_product_price']?> ₴
                    </div>
                    <div>
                        <?=lang_text("{statistic_count}")?>: <?=$statistic_data['order_product_count']?> <?=lang_text("{statistic_item}")?>
                    </div>
                    <div>
                        <?=lang_text("{statistic_price_all}")?>: <?=$total_price?> ₴
                    </div>
                    <div title="<?=lang_text("{statistic_percent_title}")?>">
                        <?=lang_text("{statistic_percent}")?>: <?=$cur_percents_text?>%
                    </div>
                    <div title="<?=lang_text("{statistic_profit_site_title}")?>">
                        <?=lang_text("{statistic_profit_site}")?>: <?=$profit_site?> ₴
                    </div>
                </td>
                <td>
                    <?
                    $user_data_arr = global_m::get_user_data_by_id($statistic_data['order_user_id']);
                    if ($user_data_arr['result']){
                        $user_data = $user_data_arr['result_data'];
                        $group_data = $user_data['group_data'];
                        echo "<a target='_blank' href='/profile/{$user_data['user_login']}' style='color: {$group_data['us_group_color']}'>";
                        echo $group_data['us_group_prefix'].$user_data['user_fullname'].$group_data['us_group_sufix'];
                        echo "</a>";
                    } else {
                        echo lang_text("{user_not_found}");
                    }
                    ?>
                </td>
                <td>
                    <?
                    $user_data_arr = global_m::get_user_data_by_id($statistic_data['order_owner_user_id']);
                    if ($user_data_arr['result']){
                        $user_data = $user_data_arr['result_data'];
                        $group_data = $user_data['group_data'];

                        echo "<a target='_blank' href='/profile/{$user_data['user_login']}' title='{$group_data['us_group_title'][$friendly_url->url_lang['id']]}' style='color: {$group_data['us_group_color']}'>";
                        echo $group_data['us_group_prefix'].$user_data['user_fullname'].$group_data['us_group_sufix'];
                        echo "</a>";
                        echo "<br>";
                        ?>
                        <div title="<?=lang_text("{statistic_profit_seller_title}")?>">
                        <?=lang_text("{statistic_profit_seller}")?>: <?=$profit_seller?> ₴
                        </div>
                        <?
                    } else {
                        echo lang_text("{user_not_found}");
                    }
                    ?>
                </td>
                <td>
                    <?
                    if ($statistic_data['order_partner_user_id']>0){
                        $user_data_arr = global_m::get_user_data_by_id($statistic_data['order_partner_user_id']);
                        if ($user_data_arr['result']){
                            $user_data = $user_data_arr['result_data'];
                            $group_data = $user_data['group_data'];
                            echo "<a target='_blank' href='/profile/{$user_data['user_login']}' style='color: {$group_data['us_group_color']}'>";
                            echo $group_data['us_group_prefix'].$user_data['user_fullname'].$group_data['us_group_sufix'];
                            echo "</a>";
                            echo "<br>";
                            ?>
                            <div title="<?=lang_text("{statistic_profit_partner_title}")?>">
                                <?=lang_text("{statistic_profit_partner}")?>: <?=$profit_site?> ₴
                            </div>
                        <?
                        } else {
                            echo lang_text("{user_not_found}");
                        }
                    } else {
                        echo lang_text("{empty_statistic}");
                    }
                    ?>
                </td>
                <td>
                    <?
                    echo lang_text("{date_add}").": ";
                    $date_add = strtotime($statistic_data['order_date_add']);
                    $date_add = date("d.m.Y H:i", $date_add);
                    echo $date_add;
                    if ($statistic_data['order_date_add'] != $statistic_data['order_date_updt']){
                        echo "<br>";
                        echo lang_text("{date_edit}").": ";
                        $date_upd = strtotime($statistic_data['order_date_updt']);
                        $date_upd = date("d.m.Y H:i", $date_upd);
                        echo $date_upd;
                    }
                    ?>
                </td>

                <td class="del_status"><?="\"$name_for_dop_td\" - <div style='display:inline-block;' class='drv-item-edit visi' data-cont_id='{$statistic_id}'><span>".lang_text('{status_del}')."</span> | <a href='#' data-action='{$statistic_data['order_status']}' class='drv-button-edit change_status' data-cur_status='-1'/>".lang_text('{action_recovery}')."</a></div>"?></td>
            </tr>
        <?
        }

    }
    ?>
    </tbody>
    <tfoot>
    </tfoot>
</table>