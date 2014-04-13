<?php
/**
 * statistic_m.php (admin)
 *
 * Файл модели главного меню админки
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

$types = array(
    // числовые
    'num'   => array(
        'number'    =>  '', // число
        'range'     =>  '', // ползунок
        'hidden'    =>  '', // скрытое числовое поле
    ),
    // дата
    'date'   => array(
        'date'     =>  '', // дата
        'time'     =>  '', // время
        'datetime-local' =>  '', // дата и время (!!!не поддерживает хром, потому сделаю собственный обработчик для date и time)
        'month'    =>  '', // месяц года
        'week'     =>  '', // неделя года (есть тонкости с передаваемым значением)
    ),
    // строковые
    'string'   => array(
        'text'      =>  '', // текст
        'password'  =>  '', // пароль
        'hidden'    =>  '', // скрытое поле
        'email'     =>  '', // email
        'url'       =>  '', // адрес сайта с http://
        'search'    =>  '', // поиск
        'color'     =>  '', // цвет (#00ff00)
    ),
    // текстовые
    'text'   => array(
        'textarea'  =>  '', // текстовое поле
    ),
    // выборные
    'select'   => array(
        'single'    =>  '', // выпадающий список
        'multiple'  =>  '', // множественный выбор
    ),
    // логические
    'bool'   => array(
        'checkbox' =>  '', // чекбокс
        'radio'    =>  '', // радио переключатель
    ),
    // кнопки
    'actions'   => array(
        'submit'   =>  '', // отправить
        'button'   =>  '', // кнопка
        'reset'    =>  '', // сброс
    ),
    // логические
    'file'   => array(
        'single'   =>  '', // один файл
        'multiple' =>  '', // много файлов
    ),
);


$field_sets['cont_id'] = array(
    'save_place'=>1,
    'type'=>"num",
    'subtype'=>"hidden",
);
$field_sets['cont_type'] = array(
    'save_place'=>1,
    'type'=>"num",
    'subtype'=>"hidden",
);
$field_sets['cont_group_id'] = array(
    // todo ash-9 возможно изменить, пока не знаю
    'save_place'=>1,
    'type'=>"select",
    'subtype'=>"multiple",
);
$field_sets['cont_url'] = array(
    'save_place'=>1,
    'type'=>"string",
    'subtype'=>"text",
);
$field_sets['cont_title'] = array(
    'save_place'=>2,
    'type'=>"string",
    'subtype'=>"text",
);
$field_sets['cont_desc'] = array(
    'save_place'=>2,
    'type'=>"text",
    'subtype'=>"textarea",
);
$field_sets['cont_statistic'] = array(
    'save_place'=>2,
    'type'=>"text",
    'subtype'=>"textarea",
);
$field_sets['cont_date'] = array(
    'save_place'=>1,
    'type'=>"date",
    'subtype'=>"datetime-local",
);
$field_sets['cont_user_id'] = array(
    'save_place'=>1,
    'type'=>"select",
    'subtype'=>"single",
);
$field_sets['cont_status'] = array(
    'save_place'=>1,
    'type'=>"num",
    'subtype'=>"hidden",
);
$field_sets['cont_sort'] = array(
    'save_place'=>1,
    'type'=>"num",
    'subtype'=>"range",
);
$field_sets['cont_files'] = array(
    'save_place'=>1,
    'type'=>"file",
    'subtype'=>"multiple",
);
$field_sets['cont_likes'] = array(
    'save_place'=>1,
    'type'=>"num",
    'subtype'=>"number",
);
$field_sets['cont_views'] = array(
    'save_place'=>1,
    'type'=>"num",
    'subtype'=>"number",
);
$field_sets['cont_seo_title'] = array(
    'save_place'=>2,
    'type'=>"string",
    'subtype'=>"text",
);
$field_sets['cont_seo_desc'] = array(
    'save_place'=>2,
    'type'=>"text",
    'subtype'=>"textarea",
);
$field_sets['cont_seo_keys'] = array(
    'save_place'=>2,
    'type'=>"string",
    'subtype'=>"text",
);
$field_sets['cont_seo_canonical'] = array(
    'save_place'=>2,
    'type'=>"string",
    'subtype'=>"text",
);
$field_sets['cont_allow_comment'] = array(
    'save_place'=>1,
    'type'=>"bool",
    'subtype'=>"checkbox",
);
$field_sets['cont_show_slider'] = array(
    'save_place'=>1,
    'type'=>"bool",
    'subtype'=>"checkbox",
);
$field_sets['cont_menu_item'] = array(
    'save_place'=>1,
    'type'=>"bool",
    'subtype'=>"checkbox",
);
$field_sets['cont_dop_field_1'] = array(
    'save_place'=>1,
    'type'=>"string",
    'subtype'=>"text",
);
$field_sets['cont_dop_field_2'] = array(
    'save_place'=>2,
    'type'=>"string",
    'subtype'=>"text",
);
$field_sets['cont_dop_field_3'] = array(
    'save_place'=>2,
    'type'=>"text",
    'subtype'=>"textarea",
);