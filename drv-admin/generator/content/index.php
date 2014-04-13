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

$lang_texts_arr = $content_types_arr = array();
require_once('data.php');



if (empty($_GET)){
    ?>
    <div style="margin: 30px auto;border: 1px solid #000000;width: 1000px; padding: 10px" id="info">
        <?
        if (isset($content_types_arr) && !empty($content_types_arr)){
            ?>
        <form style="text-align: left" action="?regenerate" method="post">
            <input type="submit" value="Перегенерировать ранее созданные типы контента"/>
        </form>
        <?
        }
        ?>
        <form style="text-align: left" action="?add_new" method="post">
            <input type="submit" value="Добавление нового типа контента"/>
        </form>
    </div>
    <?

} elseif(isset($_GET['regenerate'])) {
    ash_debug($content_types_arr);
    ash_debug($lang_texts_arr);
    ?>
    <div style="margin: 30px auto;border: 1px solid #000000;width: 1000px; padding: 10px" id="info">
        Проверьте массивы для перегенерирования
        <form style="text-align: left" action="?regenerate2" method="post">
            <input type="submit" value="Подтвердить"/>
        </form>
    </div>
<?
} elseif(isset($_GET['regenerate2'])) {
    ash_debug($content_types_arr);
    ash_debug($lang_texts_arr);
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
        echo "Очищаем таблицу с типами";
        echo "<br>------------------------------------------------------------------------<br>";
        $res = $class_db->delete_from_table('content_types',1);
        if ($res) {
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: red'>ПРОВАЛ</span>";
        }
        echo "<br>";
        echo "------------------------------------------------------------------------<br>";
        echo "Добавляем типы контента";
        echo "<br>------------------------------------------------------------------------<br>";
        foreach($content_types_arr as $id=>$type){
            echo "- {$type['type_alias']}: ";
            $type['type_id'] = $id;
            $sql_res = $class_db->insert_array_to_table('content_types',$type);
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


} elseif(isset($_GET['add_new'])) {

    ?>
    <div style="margin: 30px auto;border: 1px solid #000000;width: 1000px; padding: 10px" id="info">
        Добавление нового типа контента. Шаг 1/6.
        <br>
        <br>
        Укажите имя для типа контента и выберите все нужные для него поля:
        <br>
        <form style="text-align: left" action="?step2" method="post">
            <input required placeholder="ALIAS" type="text" name="type_alias" value=""/>
            <br>
            <input required placeholder="НАЗВАНИЕ" type="text" name="type_title" value=""/>
            <br>

            <?
            $trunk_2 = $class_db->select_from_table("SHOW COLUMNS FROM content");
            $default_fields = array();
            foreach($trunk_2 as $ii => $f){
                $default_fields[$f['Field']] = true;
                if ($ii != 0 && $ii != 1){
                    echo $ii+1 . " ";
                    ?>
                    <input type='checkbox' name='field[<?=$ii?>]' id='field_<?=$ii?>' value='<?=$f['Field']?>'> - <label for='field_<?=$ii?>'><?=$f['Field']?></label><br>
                <?
                }

            }
            ?>

            <input type="submit" value="Выбрать"/>

        </form>
    </div>

<?
} elseif (isset($_GET['step2'])) {
    ash_debug($_POST);

    ?>
    <div style="margin: 30px auto;border: 1px solid #000000;width: 1000px; padding: 10px" id="info">
        Добавление нового типа контента. Шаг 2/6.
        <br>
        <br>
        Уажите названия для выбранных полей:
        <br>
        <form style="text-align: left" action="?step3" method="post">
            <input required placeholder="ALIAS" type="text" name="type_alias" value="<?=$_POST['type_alias']?>"/>
            <br>
            <input required placeholder="НАЗВАНИЕ" type="text" name="type_title" value="<?=$_POST['type_title']?>"/>
            <br>

            <textarea required name="type_main_field" ><?=implode(',',$_POST['field'])?></textarea>
            <br>

            <?
            $trunk_2 = $class_db->select_from_table("SHOW COLUMNS FROM content");
            $default_fields = array();
            foreach($trunk_2 as $ii => $f){
                $default_fields[$f['Field']] = true;
                if (isset($_POST['field'][$ii])){
                    echo $ii+1 . " ";
                    ?>
                    <input required placeholder="<?=$f['Field']?>" type="text" name="field[<?=$f['Field']?>]" value=""/>
                    <br>
                <?
                }

            }
            ?>

            <input type="submit" value="Выбрать"/>

        </form>
    </div>

<?
} elseif (isset($_GET['step3'])) {
    ash_debug($_POST);

    ?>
    <div style="margin: 30px auto;border: 1px solid #000000;width: 1000px; padding: 10px" id="info">
        Добавление нового типа контента. Шаг 3/6.
        <br>
        <br>
        Уажите обязательные для заполнения поля:
        <br>
        <form style="text-align: left" action="?step4" method="post">
            <input required placeholder="ALIAS" type="text" name="type_alias" value="<?=$_POST['type_alias']?>"/>
            <br>
            <input required placeholder="НАЗВАНИЕ" type="text" name="type_title" value="<?=$_POST['type_title']?>"/>
            <br>
            <textarea required name="type_main_field" ><?=$_POST['type_main_field']?></textarea>
            <br>
            <?
            $qwe=array();
            foreach($_POST['field'] as $f=>$n){
                $qwe[$f] = "$f=$n";
            }
            ?>
            <textarea required name="type_field_names" ><?=implode(',',$qwe)?></textarea>
            <br>

            <?
            $trunk_2 = $class_db->select_from_table("SHOW COLUMNS FROM content");
            $default_fields = array();
            foreach($trunk_2 as $ii => $f){
                $default_fields[$f['Field']] = true;
                if (isset($_POST['field'][$f['Field']])){
                    echo $ii+1 . " ";
                    ?>
                    <input type='checkbox' name='field[<?=$ii?>]' id='field_<?=$ii?>' value='<?=$f['Field']?>'> - <label for='field_<?=$ii?>'><?=$_POST['field'][$f['Field']]?></label><br>
                <?
                }

            }
            echo "<br><br>И поля, в которых должен быть редактор<br>";
            foreach($trunk_2 as $ii => $f){
                $default_fields[$f['Field']] = true;

                if (isset($_POST['field'][$f['Field']]) && $f['Type']=='text' && $f['Field']!='cont_files' && $f['Field']!='cont_seo_desc'){
                    echo $ii+1 . " ";
                    ?>
                    <input type='checkbox' name='field2[<?=$ii?>]' id='field2_<?=$ii?>' value='<?=$f['Field']?>'> - <label for='field2_<?=$ii?>'><?=$_POST['field'][$f['Field']]?></label><br>
                <?
                }

            }
            ?>

            <input type="submit" value="Выбрать"/>

        </form>
    </div>

<?
} elseif (isset($_GET['step4'])) {
    ash_debug($_POST);

    ?>
    <div style="margin: 30px auto;border: 1px solid #000000;width: 1000px; padding: 10px" id="info">
        Добавление нового типа контента. Шаг 4/6.
        <br>
        <br>
        Уажите поля, для отображения в таблице админки:
        <br>
        <form style="text-align: left" action="?step5" method="post">
            <input required placeholder="ALIAS" type="text" name="type_alias" value="<?=$_POST['type_alias']?>"/>
            <br>
            <input required placeholder="НАЗВАНИЕ" type="text" name="type_title" value="<?=$_POST['type_title']?>"/>
            <br>
            <?
            $qwe=$_POST['type_main_field'];
            if (isset($_POST['field'])){
                foreach($_POST['field'] as $n){
                    $qwe = str_replace($n,"*$n",$qwe);
                }
            }
            if (isset($_POST['field2'])){
                foreach($_POST['field2'] as $n2){
                    $qwe = str_replace($n2,"$n2^",$qwe);
                }
            }
            ?>
            <textarea required name="type_main_field" ><?=$qwe?></textarea>
            <br>
            <textarea required name="type_field_names" ><?=$_POST['type_field_names']?></textarea>
            <br>

            <?
            $names = explode(',',$_POST['type_field_names']);
            foreach ($names as $nm) {
                $tmp_nm = explode('=',$nm);
                $name[$tmp_nm[0]] = $tmp_nm[1];
            }

            $trunk_2 = $class_db->select_from_table("SHOW COLUMNS FROM content");
            $default_fields = array();
            foreach($trunk_2 as $ii => $f){
                $default_fields[$f['Field']] = true;
                if (isset($name[$f['Field']])){
                    echo $ii+1 . " ";
                    ?>
                    <input type='checkbox' name='field[<?=$ii?>]' id='field_<?=$ii?>' value='<?=$f['Field']?>'> - <label for='field_<?=$ii?>'><?=$name[$f['Field']]?></label><br>
                <?
                }

            }
            ?>

            <input type="submit" value="Выбрать"/>

        </form>
    </div>

<?
} elseif (isset($_GET['step5'])) {
    ash_debug($_POST);

    ?>
    <div style="margin: 30px auto;border: 1px solid #000000;width: 1000px; padding: 10px" id="info">
        Добавление нового типа контента. Шаг 5/6.
        <br>
        <br>
        Проверьте правильность заполнения данных:
        <br>
        <form style="text-align: left" action="?step6" method="post">
            <input required placeholder="ALIAS" type="text" name="type_alias" value="<?=$_POST['type_alias']?>"/>
            <br>
            <input required placeholder="НАЗВАНИЕ" type="text" name="type_title" value="<?=$_POST['type_title']?>"/>
            <br>

            <textarea required name="type_main_field" ><?=$_POST['type_main_field']?></textarea>
            <br>
            <textarea required name="type_field_names" ><?=$_POST['type_field_names']?></textarea>
            <br>
            <textarea required name="type_field_for_table" ><?=(isset($_POST['field']))?implode(',',$_POST['field']):NULL?></textarea>
            <br>
            <input type="submit" value="Выбрать"/>
        </form>
    </div>

<?
} elseif (isset($_GET['step6'])) {
    $file=fopen ("data.php","w");


    $i = (isset($lang_texts_arr))?count($lang_texts_arr):0;
    $content_types['type_alias']    = $_POST['type_alias'];
    $content_types['type_title'] = 'type_title['.$_POST['type_alias'].']';
    $lang_texts_arr[$i]['text_lang_id'] = 1;
    $lang_texts_arr[$i]['text_index'] = 'type_title['.$_POST['type_alias'].']';
    $lang_texts_arr[$i]['text_content'] = $_POST['type_title'];
    $content_types['type_main_field'] = $_POST['type_main_field'];
    $content_types['type_field_for_table'] = $_POST['type_field_for_table'];

    $names = explode(',',$_POST['type_field_names']);
    foreach ($names as $nm) {
        $tmp_nm = explode('=',$nm);
        $name_to_lang[$tmp_nm[0]] = $tmp_nm[1];
        $name_to_type[$tmp_nm[0]] = $tmp_nm[0].'=type_field_names['.$_POST['type_alias'].']['.$tmp_nm[0].']';
    }
    $content_types['type_field_names'] = implode(',',$name_to_type);

    foreach ($name_to_lang as $field => $text) {
        $i++;
        $lang_texts_arr[$i]['text_lang_id'] = 1;
        $lang_texts_arr[$i]['text_index'] = 'type_field_names['.$_POST['type_alias'].']['.$field.']';
        $lang_texts_arr[$i]['text_content'] = $text;
    }


    ash_debug($content_types);
    ash_debug($lang_texts_arr);
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
        echo "Проверяем наличие такого типа контента";
        echo "<br>------------------------------------------------------------------------<br>";
        $sql_res = $class_db->select_from_table("
                SELECT * FROM content_types WHERE type_alias = '{$_POST['type_alias']}'
            ");
        if ($sql_res) {
            echo "<span style='color: red'>УЖЕ СУЩЕСТВУЕТ</span>";
            echo "<br>";
        } else {
            echo "<span style='color: green'>НЕТ ТАКОГО ТИПА</span>";
            echo "<br>";
            echo "------------------------------------------------------------------------<br>";
            echo "Добавляем тип контента";
            echo "<br>------------------------------------------------------------------------<br>";
            echo "- {$_POST['type_alias']}: ";
            fwrite ($file,"<?\r\n");
            fwrite ($file,"// Файл сгенерирован\r\n");


            $sql_res = $class_db->insert_array_to_table('content_types',$content_types);
            if ($sql_res) {
                echo "<span style='color: green'>УСПЕХ</span>";
                $content_types_arr[$sql_res] = $content_types;

                foreach($content_types_arr as $v){
                    fwrite ($file,'$content_types_arr[$sql_res] = unserialize(\'');
                    fwrite ($file,serialize($v));
                    fwrite ($file,'\');'."\r\n\r\n");
                }
                fwrite ($file,"\r\n\r\n");
            } else {
                echo "<span style='color: red'>ПРОВАЛ</span>";
            }
            echo "<br>";

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
            foreach($lang_texts_arr as $v2){
                fwrite ($file,'$lang_texts_arr[] = unserialize(\'');
                fwrite ($file,serialize($v2));
                fwrite ($file,'\');'."\r\n\r\n");
            }
            fwrite ($file,"\r\n\r\n");
            fclose ($file);

        }



        ?>
    </div>
<?

}




