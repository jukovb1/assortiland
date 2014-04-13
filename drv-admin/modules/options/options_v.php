<?php
/**
 * option_v.php (admin)
 *
 * Представление страницы параметры
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
$group_name = $cur_group_txt = lang_text('{empty}');
?>
<div class="drv-top-wrapper">
    <small><?=lang_text('{select_module}')?></small>
    <select name="change_module_group" id="change_module_group">
        <?
        foreach ($groups_list as $group_index => $group_data) {
            if ($group_index == $current_option_group){
                $selected = "selected='selected'";
                if (!$invalid_index) {
                    $group_name = $group_data['group_name'];
                    $cur_group_txt = lang_text('{current_module}');
                }
            } else {
                $selected = "";
            }
            // todo ash-0 показ только для админов
            if ($group_data['group_id']==1){
                if ($user_group == 1) {
                    ?>
                    <option style="color: red" <?=$selected?> value="<?=$group_index?>"><?=$group_data['group_name']?></option>
                <?
                }
            } else {
                ?>
                <option <?=$selected?> value="<?=$group_index?>"><?=$group_data['group_name']?></option>
            <?
            }

        }
        ?>
    </select>
    <br>
    <br>
    <div class="drv-common-wrapper">
        <small><?=$cur_group_txt?></small> <h3><?=$group_name?></h3>
    </div>
</div>
<?
if ($invalid_index) {
    echo "<h4 class='error_info'>".lang_text('{invalid_index}')."</h4>";
} else {
    if (count($constants_by_group)<1){
        echo "<h4 class='error_info'>".lang_text('{empty_constants_list}')."</h4>";
    } else {
        if ($show_lang_tabs_for_mod) {
            echo "<div class='mod_lang_tab'>\r\n";
            foreach ($langs_data['by_id'] as $lang_id => $lang_d){
                if ($lang_id == $langs_data['default_lang']['lang_id']){
                    $active_class = ' mod_lang_tab_item_active';
                } else {
                    $active_class = '';
                }
                echo "<span class='mod_lang_tab_item{$active_class}' data-lang_id='{$lang_id}' id='lang_tab_{$lang_id}'>{$lang_d['lang_name']}</span>\r\n";
            }
            echo "<div class='mod_lang_area'>\r\n";
        }
        echo "<form method='post'>\r\n";
        foreach ($constants_by_group as $const_alias => $const_data) {
            if($const_data['const_type']==-1){
                // разделитель (запись с типом -1)
                foreach ($langs_data['by_id'] as $lang_id => $lang_d) {
                    if ($lang_id == $langs_data['default_lang']['lang_id']){
                        $display = 'block';
                    } else {
                        $display = 'none';
                    }
                    echo "<div style='display: {$display};' class='field_lang_area_{$lang_id}'>\r\n";
                    echo "<div class='option_separator'></div>\r\n";
                    echo "<div class='option_separator_text'>{$const_data['const_value'][$lang_id]}</div><br>\r\n";
                    echo "</div>\r\n";

                }
            } elseif($const_data['const_type']==1){
                // числовой тип
                echo "<label class='drv-lines-label' for='{$const_alias}'>{$const_data['const_name']}</label>\r\n";
                echo "<input class='drv-lines' name='{$const_alias}' value='{$const_data['const_value']}' id='{$const_alias}' type='number'>\r\n";
            } elseif($const_data['const_type']==11){
                // checkbox тип
                if ($const_data['const_value']>0){
                    $const_data['const_value'] = 1;
                    $checked = "checked='checked'";
                } else {
                    $const_data['const_value'] = 0;
                    $checked = "";
                }
                echo "<label class='drv-lines-label' for='{$const_alias}'>{$const_data['const_name']}</label>\r\n";
                echo "<input class='hidden_for_checkbox' name='{$const_alias}' value='{$const_data['const_value']}' type='number' hidden>\r\n";
                echo "<input $checked class='' name='{$const_alias}' value='1' id='{$const_alias}' type='checkbox'>\r\n";
            } elseif($const_data['const_type']==21){
                // строковый тип общий для всех языков
                echo "<label class='drv-lines-label' for='{$const_alias}'>{$const_data['const_name']}</label>\r\n";
                echo "<input class='drv-lines' name='{$const_alias}' value='{$const_data['const_value']}' id='{$const_alias}' type='text'>\r\n";
            } elseif($const_data['const_type']==22){
                // текстовый тип общий для всех языков
                echo "<label class='drv-lines-label' for='{$const_alias}'>{$const_data['const_name']}</label>\r\n";
                echo "<textarea class='drv-lines' name='{$const_alias}' id='{$const_alias}'>{$const_data['const_value']}</textarea>\r\n";
            } elseif($const_data['const_type']==23){
                // текстовый тип общий для всех языков + редактор
                echo "<label class='drv-lines-label' for='{$const_alias}'>{$const_data['const_name']}</label>\r\n";
                echo "<textarea class='drv-lines redactor' name='{$const_alias}' id='{$const_alias}'>{$const_data['const_value']}</textarea>\r\n";
            } else{
                foreach ($langs_data['by_id'] as $lang_id => $lang_d) {
                    if ($lang_id == $langs_data['default_lang']['lang_id']){
                        $display = 'block';
                    } else {
                        $display = 'none';
                    }
                    $flag = print_lang_flag($show_lang_tabs_for_mod,$lang_d);
                    echo "<div style='display: {$display};' class='field_lang_area_{$lang_id}'>\r\n";
                    if($const_data['const_type']==31){
                        // строковый тип для каждого языка
                        echo "<label class='drv-lines-label' for='{$const_alias}_{$lang_d['lang_abbr']}'>{$const_data['const_name']} $flag</label>\r\n";
                        echo "<input class='drv-lines' name='{$const_alias}[{$lang_id}]' value='{$const_data['const_value'][$lang_id]}' id='{$const_alias}_{$lang_d['lang_abbr']}' type='text'>\r\n";
                    } elseif($const_data['const_type']==32){
                        // текстовый тип для каждого языка
                        echo "<label class='drv-lines-label' for='{$const_alias}_{$lang_d['lang_abbr']}'>{$const_data['const_name']} $flag</label>\r\n";
                        echo "<textarea class='drv-lines' name='{$const_alias}[{$lang_id}]' id='{$const_alias}_{$lang_d['lang_abbr']}'>{$const_data['const_value'][$lang_id]}</textarea>\r\n";
                    } elseif($const_data['const_type']==33){
                        // текстовый тип для каждого языка + редактор
                        echo "<label class='drv-lines-label' for='{$const_alias}_{$lang_d['lang_abbr']}'>{$const_data['const_name']} $flag</label>\r\n";
                        echo "<textarea class='drv-lines redactor' name='{$const_alias}[{$lang_id}]' id='{$const_alias}_{$lang_d['lang_abbr']}'>{$const_data['const_value'][$lang_id]}</textarea>\r\n";
                    }
                    echo "</div>\r\n";

                }


            }
        }
        echo "<br><br><button class='drv-button'>Сохранить</button>\r\n";
        echo "</form>\r\n";
        if ($show_lang_tabs_for_mod) {
            echo '<br style="clear: both">';
            echo "</div>\r\n";
            echo "</div>\r\n";
        }
    }
}
