<?php
/**
 * global_m.class.php
 *
 * Основной класс модели (общий)
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
class global_m
{
    /**
     * get_langs_data()
     * @type static public
     * @description Получение списка всех языков для сайта
     *
     * @return array
     * Возвращает многоуровневый массив:
     * [default_lang] - данные языка по-умолчанию
     * [by_id]   - список языков доступных по lang_id
     * [by_abbr] - список языков доступных по lang_abbr
     */
    static public function get_langs_data() {
        global $class_db;

        $langs=$class_db->select_from_table("
							SELECT *
							FROM langs
							WHERE lang_status > 0
							ORDER BY lang_status ASC, lang_abbr ASC
						");
        $return_lang_data = array();

        foreach ($langs as $npp => $lang_data) {
            if ($npp==0){
                $return_lang_data['default_lang'] = $lang_data;
            }
            $return_lang_data['by_id'][$lang_data['lang_id']] = $lang_data;
            $return_lang_data['by_abbr'][$lang_data['lang_abbr']] = $lang_data;
        }
        return $return_lang_data;
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
                    WHERE us_group_status > 0
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
     * get_lang_text_by_index($index,$lang_id)
     * @type static private
     * @description Получение текста для текущего языка по индексу
     *
     * @param $index string (Индекс текста)(example: 'const_name[site_name]')
     * @param $lang_id number (Индекс языка, для текущего не указывать)(example: 1)
     * @return string
     * Возвращает запись для выбранного языка
     * ИЛИ запись для языка по-умолчанию
     * ИЛИ запрашиваемый индекс
     */
    static public function get_lang_text_by_index($index,$lang_id=NULL){
        global $class_db,$friendly_url;
        if (empty($index)){
            return false;
        }
        if (is_null($lang_id)){
            $cur_lang_id = $friendly_url->url_lang['id'];
        } else{
            $cur_lang_id = $lang_id;
        }
        $text=$class_db->select_from_table("
                    SELECT *
                    FROM lang_texts
                    WHERE text_index LIKE '%$index%'
                    AND text_lang_id = {$cur_lang_id}
                    LIMIT 1
        ");
        if ($text) {
            return $text[0]['text_content'];
        } else {
            global $langs_data;
            $text=$class_db->select_from_table("
                    SELECT *
                    FROM lang_texts
                    WHERE text_index LIKE '%$index%'
                    AND text_lang_id = {$langs_data['default_lang']['lang_id']}
                    LIMIT 1
            ");
            if ($text) {
                return $text[0]['text_content'];
            } else {
                return "{".$index."}";
            }
        }
    }


    /**
     * get_constants_data($group_id)
     * @type static public
     * @description Получение списка констант по группе
     *
     * @param $group_id number (id группы констант)(example: 1)
     * @return array
     * Возвращает одномерный массив констант выбранной группы
     * для текущего языка
     */
    static public function get_constants_data($group_id) {
        global $class_db;
        $constants=$class_db->select_from_table("
							SELECT *
							FROM constants
							WHERE const_group=$group_id
							AND const_type!=-1
							ORDER BY const_sort ASC, const_id ASC
						");
        $return_const = array();
        foreach ($constants as $const_data) {
            if($const_data['const_type']==1 || $const_data['const_type']==11){
                $return_const[$const_data['const_alias']][]=$const_data['const_num_val'];
            }elseif($const_data['const_type']>20 && $const_data['const_type']<30){
                $return_const[$const_data['const_alias']][]=$const_data['const_txt_val'];
            }elseif($const_data['const_type']>30){
                $return_const[$const_data['const_alias']][]=self::get_lang_text_by_index($const_data['const_str_val']);
            }
        }
        foreach ($constants as $const_data) {
            if (count($return_const[$const_data['const_alias']])==1) {
                $return_const[$const_data['const_alias']]=stripcslashes($return_const[$const_data['const_alias']][0]);
            }
        }
        return $return_const;
    }

    /**
     * get_contents_array_by_type($type_alias)
     * @type static public
     * @description Получение списка контента по типу
     *
     * @param $type_alias string (псевдоним типа контента)(example: clients)
     * @return array
     * Возвращает двумерный массив контента выбранного типа
     * для текущего языка
     */
    static public function get_contents_array_by_type($type_alias) {
        global $class_db,$admin_folder;
        // ash-9 когда-нибудь сделать выборку только нужных полей
        $contents=$class_db->select_from_table("
							SELECT cont.*
							FROM content as cont,content_types as ct
							WHERE cont.cont_type=ct.type_id
							AND ct.type_alias = '$type_alias'
							AND cont.cont_status>0
							ORDER BY cont.cont_sort ASC, cont.cont_title ASC
						");
        $return_const = array();
        require_once($_SERVER['DOCUMENT_ROOT']."/$admin_folder/modules/content/content_m.php");
        
        foreach ($contents as $i=>$cont_data) {
            foreach ($cont_data as $field_name => $field_data) {

                if($field_sets[$field_name]['save_place']==1){
                    $return_const[$i][$field_name]=$field_data;
                }else{
                    $return_const[$i][$field_name]=self::get_lang_text_by_index($field_data);
                }
            }
        }
        return $return_const;
    }

    /**
     * get_taxes_systems()
     * @type static public
     * @description Получение списка систем налогообложения
     *
     * @return array
     * Возвращает массив систем
     */
    static public function get_taxes_systems() {
        global $class_db;
        $taxes=$class_db->select_from_table("
							SELECT *
							FROM users_taxes_system
							WHERE taxes_status>0
							ORDER BY taxes_id
						");
        $return_const = array();

        foreach ($taxes as $taxes_data) {
            $return_const[$taxes_data['taxes_id']]=self::get_lang_text_by_index($taxes_data['taxes_title']);
        }
        return $return_const;
    }
	
	/**
     * get_delivery_regions()
     * @type static public
     * @description Получение списка регионов Украины
     *
     * @return array
     * Возвращает массив регионов
     */
    static public function get_delivery_regions() {
        global $class_db;
        $ukraine_regions = global_m::get_constants_data(12);
		if(isset($ukraine_regions['site_regions'])) {
			$ukraine_regions = explode(', ',$ukraine_regions['site_regions']);
			$temp_ukraine_regions = array();
			foreach($ukraine_regions as $ukraine_region) {
				$temp_ukraine_regions[$ukraine_region] = $ukraine_region;
			}
			$ukraine_regions = $temp_ukraine_regions;
		} else {
			$ukraine_regions = array();
		}
        return $ukraine_regions;
    }

    /**
     * set_lang_text($index,$lang_id,$text)
     * @type static public
     * @description Изменение/добавление текста для языка в БД
     *
     * @param $index string (индекс текста)(example: const_name[site_name])
     * @param $lang_id number (id языка)(example: 1)
     * @param $text string (текст для сохранения)(example: Любой текст)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function set_lang_text($index,$lang_id,$text) {
        global $class_db;
        $return['result'] = true;
        $return['result_msg'] = '';

        // проверим есть ли уже такой индекс для этого языка
        $check_index_for_lang=$class_db->select_from_table("
							SELECT *
							FROM lang_texts
							WHERE text_index = '$index'
							AND text_lang_id = $lang_id
							LIMIT 1
						");

        $where_field = '';
        $where_id = '';
        if ($check_index_for_lang) {
            $where_field = 'text_id';
            $where_id = $check_index_for_lang[0]['text_id'];
        }

        $arr_for_db = array(
            'text_lang_id'  => $lang_id,
            'text_index'    => $index,
            'text_content'  => $text
        );
        $add_res = $class_db->insert_array_to_table('lang_texts',$arr_for_db,$where_field,$where_id);
        if (!$add_res){
            $return['result'] = false;
            $return['result_msg'] = '';
        }
        return $return;
    }

    /**
     * get_user_list($group)
     * @type static public
     * @description Получение списка пользователей
     *
     * @param $group number (id группы)(example: 1)
     * @return array
     * Возвращает массив результата
     */
    static public function get_user_list($group=NULL) {
        global $class_db;
        if (is_null($group)){
            $where = '';
        } else {
            $where = "AND ug.us_group_id IN ($group)";
        }
        $return = array();
//        $users = $class_db->select_from_table("
//							SELECT u.*,ug.us_group_color
//							FROM users as u, users_groups as ug,users_group_users as usg
//							WHERE u.user_id = usg.user_id
//							AND u.us_group_id = ug.us_group_id
//							$where
//							ORDER BY ug.us_group_id, u.user_fullname
//						");
        $users = $class_db->select_from_table("
							SELECT u.*,ug.us_group_color,ug.us_group_prefix,ug.us_group_sufix
							FROM users as u, users_groups as ug
							WHERE u.user_default_group = ug.us_group_id
							$where
							ORDER BY ug.us_group_id, u.user_fullname
						");
        if ($users){
            foreach($users as $user){
                $return[$user['user_id']]=$user;
            }
        }
        return $return;
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
            $group_data = self::get_users_group_by_id($return['result_data']['user_default_group']);
            $return['result_data']['group_data']=$group_data['result_data'];
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
    
    /**
     * get_user_data_by_login($user_id)
     * @type static public
     * @description Получение информации о пользователе по login
     *
     * @param $user_login string (login пользователя)(example: Ashterix)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function get_user_data_by_login($user_login) {
        global $class_db;
        $return['result'] = true;
        $return['result_msg'] = '';

		$user_login = mysql_real_escape_string($user_login);
        $user = $class_db->select_from_table("
							SELECT *
							FROM users
							WHERE user_login = '$user_login'
							LIMIT 1
						");
        if (!$user){
            $return['result'] = false;
            $return['result_msg'] = '';
        } else {
            $return['result_data']=$user[0];
			$user_id = $user[0]['user_id'];
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

    /**
     * count_products($consider_hidden=NULL)
     * @type static public
     * @description Подсчёт кол-ва товаров
     * @var $consider_hidden boolean - учитывать скрытые
     *
     * @return number
     *  Возвращает количество записей
     */
    static public function count_products($consider_hidden=NULL) {
        global $class_db;
        if (is_null($consider_hidden)){
            $inequality = ">=";
        } else {
            $inequality = ">";
        }
        $search_stat=$class_db->select_from_table("
        SELECT o.*,os.*
                FROM products AS o
                , products_specs AS os
                WHERE o.product_id=os.product_id
                AND o.product_status $inequality 0
        ");
        if ($search_stat){
            return count($search_stat);
        } else {
            return 0;
        }
    }

    /**
     * count_users($consider_hidden=NULL)
     * @type static public
     * @description Подсчёт кол-ва товаров
     * @var $consider_hidden boolean - учитывать скрытые
     *
     * @return number
     *  Возвращает количество записей
     */
    static public function count_users($consider_hidden=NULL) {
        global $class_db;
        if (is_null($consider_hidden)){
            $inequality = ">=";
        } else {
            $inequality = ">";
        }
        $search_stat=$class_db->select_from_table("
        SELECT *
                FROM users
                WHERE user_status $inequality 0
        ");
        if ($search_stat){
            return count($search_stat);
        } else {
            return 0;
        }
    }
    /**
     * check_like()
     * @type static public
     * @description Проверка лайка от пользователя
     * @var $consider_hidden boolean - учитывать скрытые
     *
     * @return number
     *  Возвращает количество записей
     */
    static public function check_like($item_id,$type=1) {
        global $class_db,$auth_class;
        $search_stat=$class_db->select_from_table("
            SELECT *
                FROM users_likes
                WHERE like_user_id = {$auth_class->cur_user_id}
                AND like_type = {$type}
                AND like_item_id = {$item_id}
                LIMIT 1
        ");
        if ($search_stat){
            return true;
        } else {
            return false;
        }
    }

    /**
     * count_partners_sellers($consider_hidden=NULL)
     * @type static public
     * @description Подсчёт кол-ва партнеров и продавцов
     * @var $consider_hidden boolean - учитывать скрытые
	 * @var $group_type number - тип группы (по-умолчанию группа продавцов)
     *
     * @return number
     *  Возвращает количество записей
     */
    static public function count_partners_sellers($consider_hidden=NULL, $group_type=4) {
        global $class_db;
        if (is_null($consider_hidden)){
            $inequality = ">=";
        } else {
            $inequality = ">";
        }
        $search_stat=$class_db->select_from_table("
        SELECT *
                FROM users
                WHERE user_status $inequality 0
                AND user_default_group = $group_type
        ");
        if ($search_stat){
            return count($search_stat);
        } else {
            return 0;
        }
    }
    
    /**
     * count_products_groups($consider_hidden=NULL)
     * @type static public
     * @description Подсчёт кол-ва категорий товаров
     * @var $consider_hidden boolean - учитывать скрытые
     *
     * @return number
     *  Возвращает количество записей
     */
    static public function count_products_groups($consider_hidden=NULL) {
        global $class_db;
        if (is_null($consider_hidden)){
            $inequality = ">";
        } else {
            $inequality = "<";
        }
        $search_stat=$class_db->select_from_table("
            SELECT *
            FROM products_groups
            WHERE group_status $inequality 0
        ");
        if ($search_stat){
            return count($search_stat);
        } else {
            return 0;
        }
    }
    
    /**
     * count_users_wait($consider_hidden=NULL)
     * @type static public
     * @description Подсчёт кол-ва пользователей ожидающих подтверждения
     * @var $consider_hidden boolean - учитывать скрытые
     *
     * @return number
     *  Возвращает количество записей
     */
    static public function count_users_wait($consider_hidden=NULL) {
        global $class_db;
        if (is_null($consider_hidden)){
            $inequality = ">=";
        } else {
            $inequality = ">";
        }
        $search_stat=$class_db->select_from_table("
        SELECT *
                FROM users
                WHERE user_status $inequality 0 AND user_status_in_group=0
        ");
        if ($search_stat){
            return count($search_stat);
        } else {
            return 0;
        }
    }

    /**
     * check_url($url,$cont_id=NULL)
     * @type static public
     * @description Проверка уникальности url
     *
     * @param  $url string (url)
     * @param  $cont_id number (id контента)
     * @return array
     * Возвращает одномерный массив результата
     */
    static public function check_url($area,$url,$cont_id=NULL) {
        if ($area == 'adm_products'){
            $table = 'products_groups';
            $field_url = 'group_short_name';
            $field_id = 'group_id';
        } else {
            $table = 'content';
            $field_url = 'cont_url';
            $field_id = 'cont_id';
        }
        $and_url = '';
        if (!is_null($cont_id)){
            $and_url = "AND $field_id!='$cont_id'";
        }
        global $class_db;
        $result['result'] = true;
        $result['result_msg'] = '';
        $isset_url=$class_db->select_from_table("
                            SELECT * FROM $table
                            WHERE $field_url='$url'
                            AND $field_url!=''
                            $and_url
        ");
        if(count($isset_url)>0) {
            $result["result"] = false;
            $result["result_msg"] = "{IE_3x100}";
        }
        return $result;
    }

	/**
     * get_content_by_url($url)
     * @type static public
     * @description Получение данных контента по url
     * @var $url - словесный адрес для страницы контента
     *
     * @return array
     * Возвращает массив данных контента с нужными полями для текущего указанного $url
     * для всех языков
     */
    static public function get_content_by_url($url) {
        global $class_db;
        $res = array();
        $return_content_types['result'] = true;
        $return_content_types['result_msg'] = '';
		$url = mysql_real_escape_string($url);
        $content=$class_db->select_from_table("
                    SELECT *
                    FROM content
                    WHERE cont_status > 0
                    AND cont_url = '$url'
                    AND cont_type = 1
                ");
        if (!$content){
            $return_content_types['result'] = false;
            $return_content_types['result_msg'] = '{IE_1x102}';
        } else {

            $langs_list = self::get_langs_data();
            $cur_langs = $langs_list['by_id'];
			
			$cur_content_id = intval($content[0]['cont_id']);

			if($cur_content_id > 0) {
				foreach ($content[0] as $cont_key => $content_data) {
					foreach ($cur_langs as $cur_lang_id=>$cur_lang_data) {
						$lang_val = self::get_lang_text_by_index("{$cont_key}[{$cur_content_id}]",$cur_lang_id);
						if (strpos($lang_val,"{$cont_key}[{$cur_content_id}]")) {
							$lang_val = "";
						}
						$res[$cont_key][$cur_lang_id]=$lang_val;
					}
				}
			}
        }
        $return_content_types['result_data'] = $res;
        return $return_content_types;
    }
}
