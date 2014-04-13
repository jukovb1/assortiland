<?php
set_time_limit(6000);
require_once($_SERVER['DOCUMENT_ROOT']."/init/auto.php");
require_once("data.php");

//echo rand_login(rand(5,8));
//echo rand_fullname(0);

$count_new_users = 100;
if(isset($_GET['count_new_users'])){
    $count_new_users = intval($_GET['count_new_users']);
}

$status_users = 0;
if(isset($_GET['status_users'])){
    $status_users = intval($_GET['status_users']);
}


$lang_texts_arr = $users_groups_arr = $users_taxes_system_arr = array();

$i = 0;
foreach ($users_groups as $const_group_id => $const_group_data) {
    $users_groups_arr[$const_group_id]  = $const_group_data;
    $users_groups_arr[$const_group_id]['us_group_title']  = "us_group_title[{$const_group_id}]";
    $users_groups_arr[$const_group_id]['us_group_desc']  = "us_group_desc[{$const_group_id}]";
    foreach ($const_group_data['us_group_title'] as $lang_id => $text) {
        $i++;
        $lang_texts_arr[$i]['text_lang_id'] = $lang_id;
        $lang_texts_arr[$i]['text_index'] = "us_group_title[{$const_group_id}]";
        $lang_texts_arr[$i]['text_content'] = $text;
    }
    foreach ($const_group_data['us_group_desc'] as $lang_id => $text) {
        $i++;
        $lang_texts_arr[$i]['text_lang_id'] = $lang_id;
        $lang_texts_arr[$i]['text_index'] = "us_group_desc[{$const_group_id}]";
        $lang_texts_arr[$i]['text_content'] = $text;
    }
}

foreach ($users_taxes_system as $const_group_id => $const_group_data) {
    $users_taxes_system_arr[$const_group_id]['taxes_id']    = $const_group_id;
    $users_taxes_system_arr[$const_group_id]['taxes_status'] = $const_group_data['taxes_status'];
    $users_taxes_system_arr[$const_group_id]['taxes_title']  = "taxes_title[{$const_group_id}]";
    foreach ($const_group_data['taxes_title'] as $lang_id => $text) {
        $i++;
        $lang_texts_arr[$i]['text_lang_id'] = $lang_id;
        $lang_texts_arr[$i]['text_index'] = "taxes_title[{$const_group_id}]";
        $lang_texts_arr[$i]['text_content'] = $text;
    }
}


if (!isset($_GET['update'])){
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <div style="margin: 30px auto;border: 1px solid #000000;width: 1000px; padding: 10px" id="info">
        Нажав кнопку, вы замените пользователей, сохранённых в БД, пользователями из массива, представленного ниже и вновь сгенерированными пользователями. Общее число новых записей - <?=$count_new_users?>
        <?
        ash_debug($users);
        ash_debug($lang_texts_arr);
        ?>
        <form style="text-align: center" action="" method="get">
            <input type="hidden" name="update" value="1"/>
            Кол-во пользователей
            <input type="text" name="count_new_users" value="100"/>
            <br>
            Создать активированными
            <input type="checkbox" name="status_users" value="1"/>
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

    $tables[-7]="users_taxes_system";
    $tables[-6]="users_group_users";
    $tables[-5]="users_groups";

    $tables[-2]="users_full_data";
    $tables[-1]="users";





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
    echo "Добавляем системы налогообложения";
    echo "<br>------------------------------------------------------------------------<br>";

    foreach($users_taxes_system_arr as $arr){
        echo "- Система: {$arr['taxes_title']}: ";
        $sql_res = $class_db->insert_array_to_table('users_taxes_system',$arr);
        if ($sql_res) {
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: red'>ПРОВАЛ</span>";
        }
        echo "<br>";
    }

    echo "<br>------------------------------------------------------------------------<br>";
    echo "Добавляем группы пользователей";
    echo "<br>------------------------------------------------------------------------<br>";

    foreach($users_groups_arr as $id=>$group){
        $user_gr_id[$id]=$group['us_group_id'];
        echo "- Группа: $id - {$group['us_group_title']}";
        $res =    $class_db->insert_array_to_table("users_groups",$group);
        if ($res) {
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




    echo "<br>------------------------------------------------------------------------<br>";
    echo "Добавляем $count_new_users пользователей";
    echo "<br>";
    echo "".count($users)." чел. из массива";
    echo "<br>------------------------------------------------------------------------<br>";
    $last_user_id = 0;
    foreach($users as $id=>$user){
        echo "- Пользователь: $id - {$user['user_login']}";
        $user = $user+array('user_status'=>$status_users);
        $res =    $class_db->insert_array_to_table("users",$user);
        if ($res) {
            $last_user_id = $res;
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: red'>ПРОВАЛ</span>";
        }
        echo "<br>";
    }
    echo "Размещаим их по группам";
    echo "<br>------------------------------------------------------------------------<br>";
    foreach($users_group_users as $user){
        echo "- Пользователь: {$user['user_id']}";
        $res =    $class_db->insert_array_to_table("users_group_users",$user);
        if ($res) {
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: red'>ПРОВАЛ</span>";
        }
        echo "<br>";
    }
    $gener_count = $count_new_users - count($users);
    echo "<br>------------------------------------------------------------------------<br>";
    echo "Остальные $gener_count чел. генерируем";
    echo "<br>------------------------------------------------------------------------<br>";


    for($user_id=count($users)+1;$user_id<=$count_new_users;$user_id++){
        $gender = rand(0,1);
        $rand_login = rand_login(rand(5,8));
        $data = date('Y-'.rand(8,11).'-'.rand(1,28).' '.rand(10,24).':'.rand(10,59));
        $domens = array('com','net','ru','ua',);
        $users = array(
            'user_id' => $user_id,'user_default_group' => rand(2,5),'user_gender' => $gender,'user_login' => $rand_login,
            'user_fullname' => rand_fullname($gender),'user_pass' => md5($pass_for_new_users),
            'user_email' => $rand_login.'@site_mail.com','user_avatar' => '','user_date_add' => $data,
            'user_date_edit' => date("Y-m-d H:i"),'user_homepage' => $rand_login.'.'.$domens[rand(0,count($domens)-1)],
            'user_status' => $status_users
        );

        echo "- Пользователь: $user_id - {$users['user_login']}";
        $res =    $class_db->insert_array_to_table("users",$users);
        if ($res) {
            echo "<span style='color: green'>УСПЕХ</span>";
        } else {
            echo "<span style='color: red'>ПРОВАЛ</span>";
        }
        echo "<br>";

        //$arr = array('us_group_id' => 3,'user_id' => $user_id,'in_g_temporarily'=>0,'in_g_added_user_id'=>1,'in_g_date_added'=>$data);
        //$class_db->insert_array_to_table("users_group_users",$arr);


        $rand_count_group = rand(1,20);
        if($rand_count_group>=10 && $rand_count_group<15){
            $arr = array('us_group_id' => $user_gr_id[rand(4,5)],'user_id' => $user_id,'in_g_temporarily'=>0,'in_g_added_user_id'=>1,'in_g_date_added'=>$data);
            $class_db->insert_array_to_table("users_group_users",$arr);
        }elseif($rand_count_group>=15 && $rand_count_group<18){

            $day = intval(date('d')) +1;
            $date2 = date('Y-m')."-$day ".date('H:i');
            $arr = array('us_group_id' => $user_gr_id[rand(6,8)],'user_id' => $user_id,'in_g_temporarily'=>1,'in_g_added_user_id'=>1,'in_g_date_added'=>$data,'in_g_date_exclusion'=>$date2);
            $class_db->insert_array_to_table("users_group_users",$arr);
        }elseif($rand_count_group>=18){
            $arr = array('us_group_id' => $user_gr_id[rand(9,count($user_gr_id)-1)],'user_id' => $user_id,'in_g_temporarily'=>0,'in_g_added_user_id'=>1,'in_g_date_added'=>$data);
            $class_db->insert_array_to_table("users_group_users",$arr);
        }

    }
    ?>
    </div>
<?
}

