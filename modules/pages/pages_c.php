<?php
/**
 * pages_c.php (front)
 *
 * Контроллер страниц для внешней части сайта
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

require_once($_SERVER['DOCUMENT_ROOT'].'/modules/pages/pages_m.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/pages/pages_c.functions.php');


// создаём список необходимых JS файлов
$js_for_module = array(
    'anythingslider', 'my'=>array('slider'),
    'front'=>array($_cur_area),
);
$local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);

$invalid_index = false;
$content_data = array();

// получаем слайдеры

if (!is_null($_cur_area_sub)){
    $content_data = pages_m::get_content_by_url(trim($_cur_area_sub));
    if (!$content_data['result']){
        $invalid_index = true;
    }
} else {
    $invalid_index = true;
}

// если найдена ошибка в обращении к модулю
if ($invalid_index){
    $lang_text = global_v::print_lang_text_from_files('404');
    require_once($error_path);
} else {
    // todo ash-1 mal-1 здесь напиши вызов функции добавления +1 к просмотрам страницы
    $page_sliders = get_page_slider_data($_cur_area_sub);
    $cont_data = $content_data['result_data'];
    $cur_lang = $friendly_url->url_lang['id'];
	$has_canonical = (!empty($cont_data['cont_seo_canonical'][$cur_lang]))?true:false;

    // собираем массив для включения в global_v
    $global_template['for_title'] = true;
    $global_template['for_title_text'] = $cont_data['cont_title'][$cur_lang];
    $global_template['for_content'] = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.php";
    $global_template['for_meta_desc'] = $cont_data['cont_seo_desc'][$cur_lang];
    $global_template['for_meta_keys'] = $cont_data['cont_seo_keys'][$cur_lang];
    $global_template['for_canonical'] = $has_canonical;
    $global_template['for_canonical_text'] = $cont_data['cont_seo_canonical'][$cur_lang];
}
