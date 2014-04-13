<?php
/**
 * pages_v.php (front)
 *
 * Представление для отображения страниц админки
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


?>
<div id="staticwrapper">
    <h1><?= isset($cont_data['cont_title'][$cur_lang]) ? $cont_data['cont_title'][$cur_lang] : lang_text('{page_h1}')?></h1>
    <?=print_big_slider($page_sliders);?>
	<?= isset($cont_data['cont_content'][$cur_lang]) ? $cont_data['cont_content'][$cur_lang] : lang_text('{page_desc}') ?>
</div>