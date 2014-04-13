<?php
/**
 * adm_users_m.class.php (admin)
 *
 * Класс модели продукции админки
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

class adm_users_m extends global_m
{
    /**
     * get_users_group()
     * @type static public
     * @description Получение списка групп продуктов (категорий)
     *
     * @return array
     * Возвращает массив списка групп
     */
    static public function get_users_groups() {
        global $class_db;
        $content_types=$class_db->select_from_table("
							SELECT *
							FROM users_groups
							WHERE us_group_status >= 0
							ORDER BY us_group_id
						");

        $result_content_types = array();

        $langs_list = self::get_langs_data();
        $cur_langs = $langs_list['by_id'];

        foreach ($content_types as $content_data) {
            $result_content_types[$content_data['us_group_id']]['us_group_id'] = $content_data['us_group_id'];
            foreach ($cur_langs as $cur_lang_id=>$cur_lang_data) {
                $lang_val = self::get_lang_text_by_index($content_data['us_group_title'],$cur_lang_id);
                $result_content_types[$content_data['us_group_id']]['us_group_title'][$cur_lang_id]=$lang_val;
            }
            foreach ($cur_langs as $cur_lang_id=>$cur_lang_data) {
                $lang_val = self::get_lang_text_by_index($content_data['us_group_desc'],$cur_lang_id);
                $result_content_types[$content_data['us_group_id']]['us_group_desc'][$cur_lang_id]=$lang_val;
            }
            $result_content_types[$content_data['us_group_id']]['us_group_color'] = $content_data['us_group_color'];
            $result_content_types[$content_data['us_group_id']]['us_group_prefix'] = $content_data['us_group_prefix'];
            $result_content_types[$content_data['us_group_id']]['us_group_sufix'] = $content_data['us_group_sufix'];
            $result_content_types[$content_data['us_group_id']]['us_group_status'] = $content_data['us_group_status'];
        }

        return $result_content_types;
    }

    /**
     * change_users_group_status($data_array)
     * @type static public
     * @description Изменение статуса контента
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function change_users_group_status($data_array) {
        global $class_db;
        $result['result'] = $rr = true;
        $result['result_msg'] = '{IE_0x100}';

        foreach ($data_array as $cont_id => $cont_data) {
            $add_res = $class_db->insert_array_to_table('users_groups',$cont_data,'us_group_id',$cont_id);
            if (!$add_res) {
                $rr = false;
            }
        }
        if (!$rr) {
            $result['result'] = false;
            $result['result_msg'] = '{IE_2x100}';
        }
        return $result;
    }

    /**
     * get_users_group_by_id($id)
     * @type static public
     * @description Получение данных контента по id
     * @var $id number - id контента
     *
     * @return array
     * Возвращает массив данных контента с нужными полями для текущего id
     * для всех языков
     */
    static public function get_users_group_by_id($id) {
        global $class_db;
        $res = array();
        $result_content_types['result'] = true;
        $result_content_types['result_msg'] = '';
        $content=$class_db->select_from_table("
                    SELECT *
                    FROM users_groups
                    WHERE us_group_status >= 0
                    AND us_group_id = $id
                    LIMIT 1
                ");
        if (!$content){
            $result_content_types['result'] = false;
            $result_content_types['result_msg'] = '{IE_1x102}';
        } else {
            $langs_list = self::get_langs_data();
            $cur_langs = $langs_list['by_id'];
            $res = $content[0];
            unset($res['us_group_title']);
            unset($res['us_group_desc']);

            foreach ($cur_langs as $cur_lang_id=>$cur_lang_data) {
                $lang_val = self::get_lang_text_by_index($content[0]['us_group_title'],$cur_lang_id);
                $res['us_group_title'][$cur_lang_id]=$lang_val;
            }
            foreach ($cur_langs as $cur_lang_id=>$cur_lang_data) {
                $lang_val = self::get_lang_text_by_index($content[0]['us_group_desc'],$cur_lang_id);
                $res['us_group_desc'][$cur_lang_id]=$lang_val;
            }
            $result_content_types['result_data'] = $res;

        }
        return $result_content_types;
    }

    /**
     * update_users_group($data_array)
     * @type static public
     * @description Изменение  контента
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function update_users_group($data_array) {
        global $class_db;
        $result['result'] = $rr = true;
        $result['result_msg'] = '{IE_0x100}';
        $content_arr  = $data_array['users_groups'];
        $cont_id = (isset($content_arr['us_group_id']))?$content_arr['us_group_id']:"";
        $cont_id_field = (isset($content_arr['us_group_id']))?"us_group_id":"";
        $add_res = $class_db->insert_array_to_table('users_groups',$content_arr,$cont_id_field,$cont_id);
        if (!$add_res) {
            $rr = false;
        }
        if (isset($data_array['lang_texts'])){
            $lang_texts_arr = $data_array['lang_texts'];
            foreach ($lang_texts_arr as $text_index => $text_data) {
                foreach ($text_data as $lang_id => $text_content) {
                    $add_res = self::set_lang_text($text_index,$lang_id,$text_content);
                    if (!$add_res) {
                        $rr = false;
                    }
                }
            }
        }
        if (!$rr) {
            $return['result'] = false;
            $return['result_msg'] = '{IE_2x100}';
        }
        return $result;
    }

    /**
     * get_users_list($pos=NULL,$lim=NULL)
     * @type static public
     * @description Получение списка пользователей
     * @param $pos number - стартовая позиция
     * @param $lim number - кол-во записей
     *
     * @return array
     * Возвращает массив списка пользователей
     */
    static public function get_users_list($pos=NULL,$lim=NULL) {
        global $class_db;
        if (is_null($pos) || is_null($lim)){
            $limit = NULL;
        } else {
            $limit = "LIMIT $pos,$lim";
        }
        $sql = "
                SELECT *
                FROM users
                WHERE user_status>=0
                ORDER BY user_id,user_date_add DESC, user_login,user_gender DESC,user_id DESC
                $limit
						";

        $users=$class_db->select_from_table($sql);

        $ret_users = array();
        if ($users){
            $list_user_group_for_user = self::get_list_users_group_for_user();

            foreach ($users as $obj) {
                $ret_users[$obj['user_id']] = $obj;
                $lpgfp = (isset($list_user_group_for_user[$obj['user_id']]))?$list_user_group_for_user[$obj['user_id']]:NULL;
                $ret_users[$obj['user_id']]['user_groups'] = $lpgfp;
            }
        }
        return $ret_users;
    }
	
	/**
     * get_users_wait_list($pos=NULL,$lim=NULL)
     * @type static public
     * @description Получение списка пользователей ожидающих подтверждения
     * @param $pos number - стартовая позиция
     * @param $lim number - кол-во записей
     *
     * @return array
     * Возвращает массив списка пользователей ожидающих подтверждения
     */
    static public function get_users_wait_list($pos=NULL,$lim=NULL) {
        global $class_db;
        if (is_null($pos) || is_null($lim)){
            $limit = NULL;
        } else {
            $limit = "LIMIT $pos,$lim";
        }
        $sql = "
                SELECT *
                FROM users
                WHERE user_status>=0 AND user_status_in_group=0
                ORDER BY user_id,user_date_add DESC, user_login,user_gender DESC,user_id DESC
                $limit
						";

        $users=$class_db->select_from_table($sql);

        $ret_users = array();
        if ($users){
            $list_user_group_for_user = self::get_list_users_group_for_user();

            foreach ($users as $obj) {
                $ret_users[$obj['user_id']] = $obj;
                $lpgfp = (isset($list_user_group_for_user[$obj['user_id']]))?$list_user_group_for_user[$obj['user_id']]:NULL;
                $ret_users[$obj['user_id']]['user_groups'] = $lpgfp;
            }
        }
        return $ret_users;
    }

    /**
     * get_list_users_group_for_user($user_id=NULL)
     * @type static public
     * @description Получение списка групп для пользователя (сортировка по названию группы)
     *
     * @return array
     * Возвращает массив списка групп
     */
    static public function get_list_users_group_for_user($user_id=NULL) {
        $dop_and = NULL;
        if (!is_null($user_id)){
            $dop_and = "AND pgp.user_id = $user_id";
        }
        global $class_db;
        $content_types=$class_db->select_from_table("
							SELECT pg.*,pgp.user_id
							FROM users_groups AS pg
							  , users_group_users AS pgp
							WHERE pg.us_group_status >= 0
							$dop_and
							AND pgp.us_group_id = pg.us_group_id
							ORDER BY us_group_title
						");

        $result_content_types = array();
        $langs_list = self::get_langs_data();

        foreach ($content_types as $content_data) {
            $result_content_types[$content_data['user_id']][$content_data['us_group_id']] = self::get_lang_text_by_index($content_data['us_group_title'],$langs_list['default_lang']['lang_id']);
        }
        return $result_content_types;
    }

    /**
     * change_users_status($data_array)
     * @type static public
     * @description Изменение статуса контента
     *
     * @param $data_array array (массив для сохранения)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function change_users_status($data_array) {
        global $class_db;
        $result['result'] = $rr = true;
        $result['result_msg'] = '{IE_0x100}';

        foreach ($data_array as $cont_id => $cont_data) {
            $add_res = $class_db->insert_array_to_table('users',$cont_data,'user_id',$cont_id);
            if (!$add_res) {
                $rr = false;
            }
        }
        if (!$rr) {
            $result['result'] = false;
            $result['result_msg'] = '{IE_2x100}';
        }
        return $result;
    }

    /**
     * get_user_data_by_id($user_id)
     * @type static public
     * @description Получение информации о пользователе по id
     *
     * @param $user_id number (id пользователя)(example: 1)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function get_user_data_by_id($user_id) {
        global $class_db;
        $return['result'] = true;
        $return['result_msg'] = '';

        $user = $class_db->select_from_table("
							SELECT *
							FROM users
							WHERE user_id = $user_id
							LIMIT 1
						");
        if (!$user){
            $return['result'] = false;
            $return['result_msg'] = '';
        } else {
            $return['result_data']=$user[0];
            $user_fd = $class_db->select_from_table("
							SELECT *
							FROM users_full_data
							WHERE user_id = $user_id
							LIMIT 1
						");
            //$return['result_data']['user_groups'] = self::get_list_users_group_for_user($user_id);
            if ($user_fd){
                $return['result_data']['full_data']=$user_fd[0];
            }
        }
        return $return;
    }

























    // ash-1 проверить нужны-ли ф-ции ниже

    /**
     * check_article($article,$user_id)
     * @type static public
     * @description Проверка уникальности артикла
     *
     * @param  $article string (артикл)
     * @param  $user_id number (id объекта)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function check_user_login($article,$user_id) {
        global $class_db;
        $result['result'] = true;
        $result['result_msg'] = '';
        $isset_article=$class_db->select_from_table("
                            SELECT * FROM users
                            WHERE user_article='$article'
                            AND user_id!='$user_id'
        ");
        if(count($isset_article)>0) {
            $result["result"] = false;
            $result["result_msg"] = "{IE_3x101}";
        }
        return $result;
    }



    /**
     * user_save($objs)
     * @type static public
     * @description Сохранение товара
     *
     * @var $objs array (массив данных)
     * @return number
     */
    static public function user_save($array){
        global $class_db;

        $result["result"]=true;
        $result["result_msg"]="{IE_0x100}";
        $fd_array = array();

        $field_id = 'user_id';
        $user_id = $array['user_id'];
        if ($array['user_id']=='new'){
            unset($array['user_id']);
            $field_id = '';
            $user_id = '';
        }
        if (isset($array['full_data'])){
            $fd_array = $array['full_data'];
            unset($array['full_data']);
        }
        $res_save = $class_db->insert_array_to_table('users',$array,$field_id,$user_id);

        $res_save_fd = true;
        if ($res_save && count($fd_array)>0){
            $fd_array['user_id'] = (!empty($user_id))?$user_id:$res_save;
            $res_save_fd = $class_db->insert_array_to_table('users_fulldata',$fd_array,$field_id,$user_id);
        }
        if (!$res_save || !$res_save_fd){
            $result["result"]=false;
            $result["result_msg"]="IE_2x100";
        }
        return $result;
    }


    /**
     * save_groups_data_for_user($group_id,$counter=0)
     * @type static public
     * @description Рекурсивная функция проверки глубины наследования групп
     *
     * @var $group_id number (id группы)
     * @var $counter number (счётчик)
     * @return number
     */
    static public function save_groups_data_for_user($data_array,$id) {
        global $class_db;
        $result['result'] = $rr = true;
        $result['result_msg'] = '{IE_0x100}';

        $class_db->delete_from_table('users_groups_users',"user_id=$id");
        $for_bd = array();
        foreach($data_array as $i=>$data){
            $for_bd[$i]['group_id'] = $data;
            $for_bd[$i]['user_id'] = $id;
            $add_res[$i] = $class_db->insert_array_to_table('users_groups_users',$for_bd[$i]);
        }
        return $result;
    }


    /**
     * check_login($login,$user_id)
     * @type static public
     * @description Проверка уникальности артикла
     *
     * @param  $login string (логин)
     * @param  $user_id number (id пользователя)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function check_login($login,$user_id) {
        global $class_db;
        $result['result'] = true;
        $result['result_msg'] = '';
        $isset_login=$class_db->select_from_table("
                            SELECT * FROM users
                            WHERE user_login='$login'
                            AND user_id!='$user_id'
        ");
        if(count($isset_login)>0) {
            $result["result"] = false;
            $result["result_msg"] = "{IE_3x101}";
        }
        return $result;
    }

}