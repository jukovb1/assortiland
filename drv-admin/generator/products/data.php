<?
//  1 - !system
//  2 - number
//  3 - string
//  4 - boolean
//  5 - select (single)
//  6 - select (multy)
//  7 - textarea
//  8 - file

// параметры
$params_ar = array(
    array('param_id' => 1,'param_name' => '!system!','param_description' => '','param_type' => 1,'param_sort' => 0,'param_for_obj' => 1,'param_required' => 0,'param_attr' => ''),
    array('param_id' => 2,'param_name' => 'Название','param_description' => '','param_type' => 3,'param_sort' => 1,'param_for_obj' => 1,'param_required' => 1,'param_attr' => ''),
    array('param_id' => 3,'param_name' => 'Описание','param_description' => '','param_type' => 7,'param_sort' => 2,'param_for_obj' => 1,'param_required' => 0,'param_attr' => ''),
    array('param_id' => 4,'param_name' => 'Акционная цена','param_description' => '','param_type' => 2,'param_sort' => 9,'param_for_obj' => 1,'param_decimal' => 0,'param_required' => 0,'param_attr' => 'min="0"'),
    array('param_id' => 5,'param_name' => 'Розничная цена','param_description' => '','param_type' => 2,'param_sort' => 5,'param_for_obj' => 1,'param_decimal' => 0,'param_required' => 1,'param_attr' => 'min="1"'),
    array('param_id' => 6,'param_name' => 'Просмотры','param_description' => '','param_type' => 2,'param_sort' => 12,'param_for_obj' => 1,'param_decimal' => 0,'param_required' => 0,'param_attr' => 'min="0"'),
    array('param_id' => 7,'param_name' => 'Лайки','param_description' => '','param_type' => 2,'param_sort' => 13,'param_for_obj' => 1,'param_decimal' => 0,'param_required' => 0,'param_attr' => 'min="0"'),
    array('param_id' => 8,'param_name' => 'Акция','param_description' => '','param_type' => 4,'param_sort' => 8,'param_for_obj' => 1,'param_decimal' => 0,'param_required' => 0,'param_attr' => ''),
    array('param_id' => 9,'param_name' => 'Фото','param_description' => 'Если у вас современный браузер, вы можете двигать изображения и расставлять их в необходимом порядке','param_type' => 8,'param_sort' => 18,'param_for_obj' => 1,'param_decimal' => 0,'param_required' => 0,'param_attr' => 'accept="image/jpeg,image/jpg,image/png,image/gif"'),
    array('param_id' => 10,'param_name' => 'Владелец','param_description' => '','param_type' => 3,'param_sort' => 14,'param_for_obj' => 1,'param_decimal' => 0,'param_required' => 0,'param_attr' => ''),
	array('param_id' => 11,'param_name' => 'Индивидуальное вознаграждение (%)','param_description' => '','param_type' => 2,'param_sort' => 17,'param_for_obj' => 1,'param_required' => 0,'param_attr' => 'min="10" max="100" step="0.5"'),
	array('param_id' => 12,'param_name' => 'Преимущества товара','param_description' => 'Указать слово и нажать кнопку "Добавить"','param_type' => 3,'param_sort' => 3,'param_for_obj' => 1,'param_required' => 0,'param_attr' => ''),
	array('param_id' => 13,'param_name' => 'Начало акции','param_description' => '','param_type' => 3,'param_sort' => 10,'param_for_obj' => 1,'param_required' => 0,'param_attr' => ''),
	array('param_id' => 14,'param_name' => 'Конец акции','param_description' => '','param_type' => 3,'param_sort' => 11,'param_for_obj' => 1,'param_required' => 0,'param_attr' => ''),
	array('param_id' => 15,'param_name' => 'Оптовая цена','param_description' => '','param_type' => 2,'param_sort' => 6,'param_for_obj' => 1,'param_decimal' => 0,'param_required' => 0,'param_attr' => 'min="0"'),
	array('param_id' => 16,'param_name' => 'Количество (опт.)','param_description' => '','param_type' => 2,'param_sort' => 7,'param_for_obj' => 1,'param_decimal' => 0,'param_required' => 0,'param_attr' => 'min="0"'),
	array('param_id' => 17,'param_name' => 'Способы доставки','param_description' => 'Укажите доступные способы доставки для данного товара','param_type' => 6,'param_sort' => 4,'param_for_obj' => 1,'param_decimal' => 0,'param_required' => 1,'param_attr' => ''),
	array('param_id' => 18,'param_name' => 'TOP продаж','param_description' => '','param_type' => 4,'param_sort' => 15,'param_for_obj' => 1,'param_decimal' => 0,'param_required' => 0,'param_attr' => ''),
	array('param_id' => 19,'param_name' => 'Активировать продукт','param_description' => '','param_type' => 4,'param_sort' => 16,'param_for_obj' => 1,'param_decimal' => 0,'param_required' => 0,'param_attr' => ''),
	//array('param_id' => 17,'param_name' => 'Селект','param_description' => '','param_type' => 6,'param_sort' => 7,'param_for_obj' => 1,'param_decimal' => 0,'param_required' => 0,'param_attr' => ''),

);




// опции для параметров с селектом
$params_options = array(
    array('option_id' => 1,'param_id' => 1,'option_str_val' => 'Yes','option_sort' => 1),
    array('option_id' => 2,'param_id' => 1,'option_str_val' => 'No','option_sort' => 2),

    array('option_id' => 3,'param_id' => 17,'option_str_val' => 'НОВАЯ ПОЧТА (на почтовое отделение)','option_str_long_val' => 'Укажите номер и <a class="prod-in-cart-offices" target="_blank" href="http://novaposhta.ua/frontend/brunchoffices?lang=ukr">адрес почтового отделения</a>','option_sort' => 0),
    array('option_id' => 4,'param_id' => 17,'option_str_val' => 'НОВАЯ ПОЧТА (по адресу)','option_str_long_val' => 'Укажите город и адрес доставки','option_sort' => 0),
    array('option_id' => 5,'param_id' => 17,'option_str_val' => 'УКРПОЧТА','option_str_long_val' => 'Укажите индекс почтового отделения, город и ваш адрес','option_sort' => 0),

);



// группы параметров
$params_groups = array(
    array('params_group_id' => 1,'params_group_name' => 'Параметры в таблице админки'),
    array('params_group_id' => 2,'params_group_name' => 'Параметры в предпросмотре на фронте'),
    array('params_group_id' => 3,'params_group_name' => 'Параметры в предпросмотре каталога продавца'),
);

// параметры в группах параметров

$params_groups_params = array(
    array('params_group_id' => 1,'param_id' => 2,'param_sort' => 0,'param_name' => NULL),
    array('params_group_id' => 1,'param_id' => 10,'param_sort' => 0,'param_name' => NULL),

    array('params_group_id' => 2,'param_id' => 2,'param_sort' => 0,'param_name' => NULL),
    array('params_group_id' => 2,'param_id' => 9,'param_sort' => 0,'param_name' => NULL),
    array('params_group_id' => 2,'param_id' => 7,'param_sort' => 0,'param_name' => NULL),
    array('params_group_id' => 2,'param_id' => 6,'param_sort' => 0,'param_name' => NULL),
    array('params_group_id' => 2,'param_id' => 8,'param_sort' => 0,'param_name' => NULL),
    array('params_group_id' => 2,'param_id' => 4,'param_sort' => 0,'param_name' => NULL),
    array('params_group_id' => 2,'param_id' => 18,'param_sort' => 0,'param_name' => NULL),
    array('params_group_id' => 2,'param_id' => 11,'param_sort' => 0,'param_name' => NULL),

    array('params_group_id' => 3,'param_id' => 2,'param_sort' => 0,'param_name' => NULL),
    array('params_group_id' => 3,'param_id' => 9,'param_sort' => 0,'param_name' => NULL),
    array('params_group_id' => 3,'param_id' => 3,'param_sort' => 0,'param_name' => NULL),

);




// группы товаров (категории)
$products_groups = array(
    array('group_id' => 1,'group_parent_group'=>0,'group_nesting'=>0,'group_short_name' => 'group_1','group_full_name' => 'Строительные товары'),
    array('group_id' => 2,'group_parent_group'=>1,'group_nesting'=>1,'group_short_name' => 'group_2','group_full_name' => 'Инструменты'),
    array('group_id' => 3,'group_parent_group'=>1,'group_nesting'=>1,'group_short_name' => 'group_3','group_full_name' => 'Шурупы/Саморезы'),
    array('group_id' => 4,'group_parent_group'=>0,'group_nesting'=>0,'group_short_name' => 'group_4','group_full_name' => 'Одежда и Аксессуары'),
    array('group_id' => 5,'group_parent_group'=>4,'group_nesting'=>1,'group_short_name' => 'group_5','group_full_name' => 'Верхняя одежда'),
    array('group_id' => 6,'group_parent_group'=>4,'group_nesting'=>1,'group_short_name' => 'group_6','group_full_name' => 'Обувь'),
    array('group_id' => 7,'group_parent_group'=>6,'group_nesting'=>2,'group_short_name' => 'group_7','group_full_name' => 'Мужская обувь'),
    array('group_id' => 8,'group_parent_group'=>6,'group_nesting'=>2,'group_short_name' => 'group_8','group_full_name' => 'Женская обувь'),
    array('group_id' => 9,'group_parent_group'=>7,'group_nesting'=>3,'group_short_name' => 'group_9','group_full_name' => 'Кроссовки'),
    array('group_id' => 10,'group_parent_group'=>5,'group_nesting'=>2,'group_short_name' => 'group_10','group_full_name' => 'Зимняя одежда'),
);