<?php
/**
 * comments_c.php
 *
 * Контроллер комментариев
 *
 * Данный файл НЕ является частью системы управления контентом
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
if (!defined('IN_APP')) {
    die("not in app");
}

if (isset($allow_comments) && $allow_comments){
    if ($_cur_area=='product'){
        $id_for_comments = get_product_data('product_id');
    } else {
        // все остальные случаи расцениваем, как раздел content
        $id_for_comments = $cont_data['cont_id'];
    }
    require_once($_SERVER["DOCUMENT_ROOT"].'/global_scripts/comments/comments.class.php');

    $comments_class = new comments($_cur_area,$id_for_comments);

    // выведение блока комментариев
    function comment_block(){
        global $comments_class;
        return $comments_class->print_comments_block(3);
    }
} else {
    // заглушка на случай запрета комментирования
    function comment_block(){
        return lang_text('{no_comments}');
    }
}


