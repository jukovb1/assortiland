<?php
/**
 * main_menu_m.class.php (admin)
 *
 * Класс модели главного меню админки
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

class main_menu_m extends global_m
{
    /**
     * get_content_types_for_sub_menu()
     * @type static public
     * @description Получение списка типов контента для субменю админки
     *
     * @return array
     * Возвращает одномерный массив списка типов
     * для текущего языка
     */
    static public function get_content_types_for_sub_menu() {
        global $class_db;
        $content_types=$class_db->select_from_table("
							SELECT type_alias,type_title
							FROM content_types
							WHERE type_status > 0
						");

        $return_content_types = array();
        foreach ($content_types as $content_data) {
            $return_content_types['content-'.$content_data['type_alias']]['s_item_name'] = self::get_lang_text_by_index($content_data['type_title']);

        }
        return $return_content_types;
    }
}