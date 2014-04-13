<?php
/**
 * index.php (admin)
 *
 * Главный контроллер админки
 *
 * Данный файл является частью системы управления контентом
 * разработанной студией Дериво
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
/* подключаем инициирующий файл */
require_once($_SERVER['DOCUMENT_ROOT']."/init/auto.php");
require_once("data.php");



$lang_texts_arr = $constants_groups_arr = $constants_arr = array();



$i = 0;
foreach ($constants_groups as $const_group_id => $const_group_data) {
    $constants_groups_arr[$const_group_id]['const_group_id']    = $const_group_id;
    $constants_groups_arr[$const_group_id]['const_group_alias'] = $const_group_data['const_group_alias'];
    $constants_groups_arr[$const_group_id]['const_group_name']  = "const_group_name[{$const_group_data['const_group_alias']}]";
    foreach ($const_group_data['const_group_name'] as $lang_id => $text) {
        $i++;
        $lang_texts_arr[$i]['text_lang_id'] = $lang_id;
        $lang_texts_arr[$i]['text_index'] = "const_group_name[{$const_group_data['const_group_alias']}]";
        $lang_texts_arr[$i]['text_content'] = $text;
    }

}


foreach ($constants as $const_id => $const_data) {
    $constants_arr[$const_id]['const_id']    = $const_id;
    $alias = $const_data['const_alias'];
    if ($const_data['const_type']==-1){
        $alias = $const_data['const_alias']."_".$const_id;
    }
    $constants_arr[$const_id]['const_alias'] = $alias;
    $constants_arr[$const_id]['const_name']  = "const_name[{$alias}]";
    foreach ($const_data['const_name'] as $lang_id => $text) {
        $i++;
        $lang_texts_arr[$i]['text_lang_id'] = $lang_id;
        $lang_texts_arr[$i]['text_index'] = "const_name[{$alias}]";
        $lang_texts_arr[$i]['text_content'] = $text;
    }
    $constants_arr[$const_id]['const_group']    = $const_data['const_group'];
    $constants_arr[$const_id]['const_type']     = $const_data['const_type'];
    $constants_arr[$const_id]['const_num_val']  = 0;
    $constants_arr[$const_id]['const_txt_val']  = '';
    $constants_arr[$const_id]['const_str_val']  = '';

    if ($const_data['const_type'] >20 && $const_data['const_type']<30){
        if (isset($const_data['value'])){
            if (!is_array($const_data['value'])){
                $constants_arr[$const_id]['const_txt_val']  = $const_data['value'];
            }
        }

    } elseif ($const_data['const_type'] == 1) {
        if (isset($const_data['value'])){
            if (!is_array($const_data['value'])){
                $constants_arr[$const_id]['const_num_val']  = $const_data['value'];
            }
        }
    } else {
        $constants_arr[$const_id]['const_str_val']  = "const_str_val[{$alias}]";
        if (isset($const_data['value'])){
            if (is_array($const_data['value'])){
                foreach ($const_data['value'] as $lang_id => $text) {
                    $i++;
                    $lang_texts_arr[$i]['text_lang_id'] = $lang_id;
                    $lang_texts_arr[$i]['text_index'] = "const_str_val[{$alias}]";
                    $lang_texts_arr[$i]['text_content'] = $text;
                }
            }
        }

    }

}

if (!isset($_GET['update'])){
    ?>
    <div style="margin: 30px auto;border: 1px solid #000000;width: 1000px; padding: 10px" id="info">
        Нажав кнопку вы замените записи в БД, данными из массивов, представленных ниже
    <?

    ash_debug($constants_groups_arr,'Записи в таблице "constants_groups"');
    ash_debug($constants_arr,'Записи в таблице "constants"');
    ash_debug($lang_texts_arr,'Записи в таблице "lang_texts"');
    ?>
    <form style="text-align: center" action="" method="get">
        <input type="hidden" name="update" value="1"/>
        <input type="submit" value="Обновить"/>

    </form>
    </div>

<?
} else {

    ?>
    <script>
        window.onload = function(){
            var scrollinDiv = document.getElementById('info');
            setTimeout(function() {
                scrollinDiv.scrollTop = 9999;
            }, 100);
        }

    </script>


    <div style="margin: 30px auto;border: 3px double #000000;width: 500px; height: 400px; overflow: auto;padding: 10px" id="info">
        <?


        echo "------------------------------------------------------------------------<br>";
        echo "Очищаем таблицы";
        echo "<br>------------------------------------------------------------------------<br>";
        echo "- Группы констант: ";
        $trunk_1 = $class_db->unisql_query("TRUNCATE  constants_groups");
        if ($trunk_1) {
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: red'>ПРОВАЛ</span>";
        }
        echo "<br>";
        echo "- Константы: ";
        $trunk_2 = $class_db->unisql_query("TRUNCATE  constants");
        if ($trunk_2) {
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: red'>ПРОВАЛ</span>";
        }
        echo "<br>";
        echo "- Мультиязычный текст: ";
        //$trunk_3 = $class_db->unisql_query("TRUNCATE  lang_texts");
        if (isset($trunk_3) && $trunk_3) {
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: blue'>ПРОПУСК</span>";
        }
        echo "<br>------------------------------------------------------------------------<br>";
        echo "Добавляем группы констант";
        echo "<br>------------------------------------------------------------------------<br>";
        foreach ($constants_groups_arr as $gr => $arr) {
            echo "- группа: {$arr['const_group_alias']}: ";
            $sql_res = $class_db->insert_array_to_table('constants_groups',$arr);
            if ($sql_res) {
                echo "<span style='color: green'>УСПЕХ</span>";
            } else {
                echo "<span style='color: red'>ПРОВАЛ</span>";
            }
            echo "<br>";
        }
        echo "<br>------------------------------------------------------------------------<br>";
        echo "Добавляем константы";
        echo "<br>------------------------------------------------------------------------<br>";
        foreach ($constants_arr as $gr => $arr) {
            echo "- Константа: {$arr['const_alias']}: ";
            $sql_res = $class_db->insert_array_to_table('constants',$arr);
            if ($sql_res) {
                echo "<span style='color: green'>УСПЕХ</span>";
            } else {
                echo "<span style='color: red'>ПРОВАЛ</span>";
            }
            echo "<br>";
        }
        echo "<br>------------------------------------------------------------------------<br>";
        echo "Заменяем или добавляем текст для разных языков";
        echo "<br>------------------------------------------------------------------------<br>";
        foreach ($lang_texts_arr as $gr => $arr) {
            echo "- индекс {$arr['text_index']} для языка {$arr['text_lang_id']}: ";
            $sql_res = global_m::set_lang_text($arr['text_index'],$arr['text_lang_id'],$arr['text_content']);

            if ($sql_res['result']) {
                echo "<span style='color: green'>УСПЕХ</span>";
            } else {
                echo "<span style='color: red'>ПРОВАЛ</span>";
            }
            echo "<br>";
        }

        ?>
    </div>
<?

}




