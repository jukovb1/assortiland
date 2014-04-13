<?php
/**
 * 404_c.php (admin)
 *
 * Контроллер страницы 404 админки
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
header('HTTP/1.0 404 Not Found');
header('Status: 404 Not Found');

// собираем массив для включения в global_v
$global_template = array(
    'for_title'      => true,
    'for_title_text' => lang_text('{error_404}'), //
    'for_head'       => NULL,
    'for_content'    => $_SERVER['DOCUMENT_ROOT']."/$adm_folder/modules/404/404_v.php",
);

$modul_content = '';