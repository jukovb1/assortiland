<?php
set_time_limit(6000);
require_once($_SERVER['DOCUMENT_ROOT']."/init/auto.php");
require_once("data.php");

$count_products = 100;
if(isset($_GET['count_new_products'])){
    $count_products = intval($_GET['count_new_products']);
}
$status_products = 0;
if(isset($_GET['status_products'])){
    $status_products = intval($_GET['status_products']);
}


if (!isset($_GET['update'])){
    ?>
    <div style="margin: 30px auto;border: 1px solid #000000;width: 1000px; padding: 10px" id="info">
        Нажав кнопку вы замените записи в БД, данными из массивов, представленных ниже
        <?
        ash_debug($params_ar);
        ash_debug($params_options);
        ?>
        <form style="text-align: center" action="" method="get">
            <input type="hidden" name="update" value="1"/>
            Кол-во продуктов
            <input type="text" name="count_new_products" value="100"/>
            <br>
            Создать опубликованными
            <input type="checkbox" name="status_products" value="1"/>
            <br>
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

    $vars[2]=array("ПРАЗДНИЧНЫЙ НАБОР ДЛЯ ДЕТСКОГО СЧАСТЬЯ","ПОНЧИКИ С КЛУБНИЧНОЙ НОЧИНКОЙ","НАБОР ИНСТРУМЕНТОВ ДЛЯ СТРОИТЕЛЕЙ","ТОРТ НАПОЛЕОН","СЛУЧАЙНОЕ НАЗВАНИЕ");
    $vars[3]=array("описание 1","описание 2","описание 3","описание 4","описание 5");
    $vars[9]=array("ab8130e.pdf","ee2244a.pdf");
    $vars[10]=array("Компания 1","Компания 2","Компания 3","Компания 4","Компания 5");

    //добавление условий в генератор
    // ash-0 ограничения
    $var_constraint_gen[4] = array(10,10000);
    $var_constraint_gen[5] = array(10,10000);
    $var_constraint_gen[7] = array(0,10000);
    $var_constraint_gen[8] = array(0,10000);
    $var_constraint_gen[6] = array(1,5);
    $var_constraint_gen[11] = array(10,20);





    $params_options_res=array();
    foreach($params_options as $params_option){
        $params_options_res[$params_option["param_id"]][]=$params_option["option_id"];
    }

    $params=array();
    foreach($params_ar as $param_ar){
        $params[$param_ar["param_id"]]=$param_ar["param_type"];
    }




    $tables[-8]="params_groups_params";
    $tables[-9]="params_groups";


    $tables[2]="specs_params_number_val";
    $tables[3]="specs_params_text_val";
    $tables[4]="specs_params_options";
    $tables[5]="specs_params_options";
    $tables[6]="specs_params_options";
    $tables[7]="specs_params_text_val";
    $tables[8]="specs_params_files";

    $tables[-6]="products_groups_products";
    $tables[-5]="products_groups";
    $tables[-4]="params";
    $tables[-3]="params_options";

    $tables[-2]="products_specs";
    $tables[-1]="products";




    $var_col[2]="param_number_val";
    $var_col[3]="param_text_val";
    $var_col[4]="option_id";
    $var_col[5]="option_id";
    $var_col[6]="option_id";
    $var_col[7]="param_text_val";
    $var_col[8]="param_file_name_real";

    $tables_for_del=$tables;
    rsort($tables_for_del);
    echo "------------------------------------------------------------------------<br>";
    echo "Очищаем таблицы";
    echo "<br>------------------------------------------------------------------------<br>";
    foreach($tables_for_del as $table){
        echo "- $table: ";
        $res = $class_db->delete_from_table($table,1);
        if ($res) {
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: red'>ПРОВАЛ</span>";
        }
        echo "<br>";
    }





    echo "<br>------------------------------------------------------------------------<br>";
    echo "Добавляем параметры";
    echo "<br>------------------------------------------------------------------------<br>";

    foreach($params_ar as $param){
        echo "- {$param['param_name']}: ";
        $res =       $class_db->insert_array_to_table("params",$param);
        if ($res) {
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: red'>ПРОВАЛ</span>";
        }
        echo "<br>";
    }

    echo "<br>------------------------------------------------------------------------<br>";
    echo "Добавляем группы параметров";
    echo "<br>------------------------------------------------------------------------<br>";

    foreach($params_groups as $group){
        $res =    $class_db->insert_array_to_table("params_groups",$group);
        echo "- $group: ";
        if ($res) {
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: red'>ПРОВАЛ</span>";
        }
        echo "<br>";
    }

    echo "<br>------------------------------------------------------------------------<br>";
    echo "Добавляем параметры в группы параметров";
    echo "<br>------------------------------------------------------------------------<br>";

    foreach($params_groups_params as $group_param){
        $res = $class_db->insert_array_to_table("params_groups_params",$group_param);
        echo "- $group_param: ";
        if ($res) {
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: red'>ПРОВАЛ</span>";
        }
        echo "<br>";
    }

    echo "<br>------------------------------------------------------------------------<br>";
    echo "Добавляем опции параметров";
    echo "<br>------------------------------------------------------------------------<br>";

    foreach($params_options as $params_option){
        $res = $class_db->insert_array_to_table("params_options",$params_option);
        echo "- для параметра {$params_option['param_id']} - {$params_option['option_str_val']}: ";
        if ($res) {
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: red'>ПРОВАЛ</span>";
        }
        echo "<br>";
    }

    echo "<br>------------------------------------------------------------------------<br>";
    echo "Добавляем группы товаров";
    echo "<br>------------------------------------------------------------------------<br>";

    foreach($products_groups as $product_group){
        $prod_gr_id[]=$product_group['group_id'];
        $res = $class_db->insert_array_to_table("products_groups",$product_group);
        echo "- группа {$product_group['group_short_name']}: ";
        if ($res) {
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: red'>ПРОВАЛ</span>";
        }
        echo "<br>";
    }
    // не перегенерировать = раскомментировать ниже
    //die();

    echo "<br>------------------------------------------------------------------------<br>";
    echo "Генерируем $count_products объектов";
    echo "<br>------------------------------------------------------------------------<br>";

    $last_spec_id=0;

    for($obj_id=1;$obj_id<=$count_products;$obj_id++){
        $specs_count=1;
        $best = 0;
        if(rand(0,20)==20){
            //$specs_count=2;
            $best = 1;
        }
        if(rand(0,100)==100){
            //$specs_count=3;
        }
        $rand_count_group = rand(1,20);
        if($rand_count_group<10 ){
            $count_group=1;
        }elseif($rand_count_group>=10 && $rand_count_group<20){
            $count_group=2;
        }else{
            $count_group=3;
        }
        for($tmp=1;$tmp<=$count_group;$tmp++){
            $best = 0;
            $rand_keys = array_rand($prod_gr_id, 1);
            if(rand(0,20)==20){
                $best = 1;
            }
            $class_db->insert_array_to_table("products_groups_products",array("product_id"=>$obj_id,"group_id"=>$prod_gr_id[$rand_keys],"product_best_deal"=>$best));

        }
        $data = date('Y-'.rand(1,10).'-'.rand(1,28).' 00:00');
        $sellers_list_arr = $user_list['sellers'];
        sort($sellers_list_arr);

        $user_added = $sellers_list_arr[rand(0,count($sellers_list_arr)-1)]['user_id'];
        $class_db->insert_array_to_table("products",array("product_id"=>$obj_id,"product_article"=>"product_".$obj_id,"product_date"=>$data,"product_user_id"=>$user_added,"product_status"=>$status_products));
        for($specs_npp=1;$specs_npp<=$specs_count;$specs_npp++){
            $cur_spec_id=$last_spec_id+$specs_npp;
            echo "- $obj_id: ";
            if ($specs_count == 1) {
                echo "<span style='color: green'>УСПЕХ</span><br>";
            } else {
                echo "== спек_$cur_spec_id: <span style='color: green'>УСПЕХ</span><br>";
            }
            $class_db->insert_array_to_table("products_specs",array("product_id"=>$obj_id,"spec_id"=>$cur_spec_id));

            foreach($params as $param_id=>$param_type){
                $add_val=array();
                $add_val["spec_id"]=$cur_spec_id;
                $add_val["param_id"]=$param_id;
                if($param_type==1){
                    continue;
                }elseif($param_type==4){
                    if(rand(1,4)==4){
                        $add_val[$var_col[$param_type]]=1;
                    }
                }elseif($param_type==2){
                    //ash-0 обработка ограничений
                    if (isset($var_constraint_gen[$param_id])) {
                        $add_val[$var_col[$param_type]]=rand($var_constraint_gen[$param_id][0],$var_constraint_gen[$param_id][1]);
                    } else {
                        $add_val[$var_col[$param_type]]=rand(1,1000);
                    }
                }elseif($param_type==5 || $param_type==6){
                    $add_val[$var_col[$param_type]]=$params_options_res[$param_id][rand(0,count($params_options_res[$param_id])-1)];
                }else{
                    if(rand(1,10)==10){
                        if (isset($vars[$param_id])){
                            $add_val[$var_col[$param_type]]=$vars[$param_id][rand(0,count($vars[$param_id])-1)];
                        }
                    }
                }

                if(isset($add_val[$var_col[$param_type]])){
                    $class_db->insert_array_to_table($tables[$param_type],$add_val);
                }
            }
            $last_spec_id=$cur_spec_id;
        }

    }
    ?>
    </div>
<?
}

