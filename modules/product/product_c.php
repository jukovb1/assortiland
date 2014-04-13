<?php
/**
 * product_c.php (front)
 *
 * Контроллер единицы продукции из каталога
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

require_once($_SERVER['DOCUMENT_ROOT'].'/modules/catalog/catalog_m.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/catalog/catalog_v.functions.php');
require_once('product_m.class.php');
require_once('product_c.functions.php');
// по-умолчанию запрещаем комментарии


$_catalog_area = 'catalog';

// создаём список необходимых JS файлов
$js_for_module = array(
    'ui', 'anythingslider', 'jcarousel', 'my'=>array('slider', 'catalog', 'product'),
    'front'=>array($_cur_area),
);

$invalid_index = true;

if (!is_null($_cur_area_sub)){
    $invalid_index = false;
    // проверяем наличие такого продукта
    $article_array = explode(',',$_cur_area_sub); // это заглушка на случай, если в других проектах нужно будет сравнение товаров
    $isset_product = product_m::check_product_by_article($article_array,1);
    if (!$isset_product){
        $invalid_index = true;
    }
}

if ($invalid_index){
    $lang_text = global_v::print_lang_text_from_files('404');
    require_once($error_path);
} else {
    $seller_id = $seller_name = NULL;
    $partner_id = $partner_name = NULL;
    $link_marketplace = '';
    $seller_marketplace = $partner_marketplace = false;
    if (isset($friendly_url->url_command['marketplace'])){
        $link_marketplace = "marketplace={$friendly_url->url_command['marketplace']}";
        $seller_data = global_m::get_user_data_by_login(trim($friendly_url->url_command['marketplace']));
        if ($seller_data['result']){
            $seller_id = $seller_data['result_data']['user_id'];
            $seller_name = $seller_data['result_data']['user_fullname'];
            if($seller_data['result_data']['user_default_group']==4) {
                $seller_marketplace = true;
            }
        }
    }elseif (isset($friendly_url->url_command['marketplace_p'])){
        $link_marketplace = "marketplace={$friendly_url->url_command['marketplace_p']}";
        $partner_data = global_m::get_user_data_by_login(trim($friendly_url->url_command['marketplace_p']));
        if ($partner_data['result']){
            $partner_id = $partner_data['result_data']['user_id'];
            $partner_name = $partner_data['result_data']['user_fullname'];
            if($partner_data['result_data']['user_default_group']==5) {
                $partner_marketplace = true;
            }
        }
    }
    // мин/макс значение цен
    $prices_default = catalog_m::count_catalog_min_max_price();
    $prices_default = $prices_default[0];

    // мин/макс значение вознаграждения
    $offers_default = catalog_m::count_catalog_min_max_offers();
    $offers_default = $offers_default[0];
    $current_product_id = $isset_product[0];

    $local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);
    $params_for_product_list = catalog_m::get_list_params_by_group(2);
	
	$category_array = catalog_m::get_products_groups();

    // Определяемся с хлебными крошками и т.к. товар может быть в нескольких категориях,
    // тут изврат с определением категории для хлебных крошек с учётом HTTP_REFERER
    $definition_product_group = false;
    if (isset($_SERVER['HTTP_REFERER'])){
        $referer = parse_url($_SERVER['HTTP_REFERER']);
        if (isset($referer['path']) && !empty($referer['path'])){
            $referer = explode('/',trim($referer['path'],'/'));
            if ($referer[0] == 'catalog' && isset($referer[1])){
                $cat_data = catalog_m::check_products_group_by_url(mysql_real_escape_string($referer[1]));
            } else {
                $definition_product_group = true;
            }    
        } else {
            $definition_product_group = true;
        }
    } else {
        $definition_product_group = true;
    }
    $partners_products = NULL;
    if ($auth_class->cur_user_group==5 && $auth_class->cur_user_status_in_group==1){
        $partners_products = catalog_m::partner_products($auth_class->cur_user_id);
    }
    if ($definition_product_group){
        $cat_arr_for_product = catalog_m::get_list_products_group_for_product($current_product_id);
        $cat_id_for_product = key($cat_arr_for_product[$current_product_id]);
        $cat_data = catalog_m::check_products_group_by_id($cat_id_for_product);
    }

    $search_word = NULL;
    $search_get_index = 'search_product';
    if (isset($_GET[$search_get_index])){
        $search_word = mysql_real_escape_string($_GET[$search_get_index]);
    }

	// получаем данные о продукте с необходимыми дополнительными полями
	$product_arr = product_m::get_product_by_article($isset_product);
    if ($product_arr['result']){
    	// получаем данные о продукте
        $product_data = $product_arr['result_data'];
        // комментарии
        $allow_comments = true;
        require_once($comments_path);

        $product_article = get_product_data('product_article');
        $product_name = get_product_data(2);
		
		$product_views = get_product_data(6);
		product_m::update_product_number_and_string_param($current_product_id, 6, $product_views+1, $product_data);
		// получаем данные о владельце продукта
		$product_owner_result = global_m::get_user_data_by_id(get_product_data('product_user_id'));
		$product_owner_data = ($product_owner_result['result'])?$product_owner_result['result_data']:NULL;

        // собираем массив для включения в global_v
        $global_template['for_title'] = true;
        $global_template['for_title_text'] = "$product_name ($product_article)";
        $global_template['for_content'] = $_SERVER['DOCUMENT_ROOT']."/modules/catalog/catalog_v.php";
    } else {
        // на всякий случай ещё раз перестраховываемся и если нет товара редиректимся на 404
        $lang_text = global_v::print_lang_text_from_files('404');
        require_once($error_path);
    }
    // ash-1 написать получение топа продаж
}

