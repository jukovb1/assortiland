<?php
/**
 * sellers_m.class.php (front)
 *
 * Класс модели продавцов
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

class sellers_m extends global_m
{
    /**
     * get_sellers_list($pos=NULL,$lim=NULL)
     * @type static public
     * @description Получение списка продавцов
     * @param $pos number - стартовая позиция
     * @param $lim number - кол-во записей
     *
     * @return array
     * Возвращает массив списка продавцов
     */
    static public function get_sellers_list($pos=NULL,$lim=NULL) {
        global $class_db;
        if (is_null($pos) || is_null($lim)){
            $limit = NULL;
        } else {
            $limit = "LIMIT $pos,$lim";
        }
        $sql = "
                SELECT us.*, count(o.product_id) as products_count
                    FROM users AS us, products AS o
                    WHERE o.product_user_id=us.user_id
                    AND o.product_status > 0
                    AND us.user_status>0 AND us.user_status_in_group=1
                    AND us.user_default_group=4
                    GROUP BY us.user_id
                     ORDER BY products_count DESC
                $limit
						";

        $users=$class_db->select_from_table($sql);

        $ret_users = array();
        if ($users){
            foreach ($users as $obj) {
                $ret_users[$obj['user_id']] = $obj;
            }
        }
        return $ret_users;
    }
	
}