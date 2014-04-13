<?php
/**
 * example_m.class.php (admin)
 *
 * Класс модели модуля example
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
class example_m extends global_m
{
    /**
     *
     * example
     *
     */
    static public function example() {
        global $class_db;
        $example=$class_db->select_from_table("
							sql запрос
						");

        $return_example = array();
        foreach ($example as $example_data) {
            $return_example[$example_data['const_group_id']]['group_id'] = $example_data['const_group_id'];
            $return_example[$example_data['const_group_id']]['group_name'] = self::get_lang_text_by_index($example_data['const_group_name']);
        }
        return $return_example;
    }

}
