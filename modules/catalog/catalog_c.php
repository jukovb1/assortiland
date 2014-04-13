<?php
/**
 * catalog_c.php (front)
 *
 * Контроллер каталога продукции
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
require_once('catalog_m.class.php');
require_once('catalog_c.function.php');
require_once('catalog_v.functions.php');
$catalog_constants = global_m::get_constants_data(4);

// собираем массив для включения в global_v
//
$global_template['for_title'] = true;
$global_template['for_title_text'] = lang_text('{module_name}');
$global_template['for_meta_keys'] = get_constant($catalog_constants,'catalog_seo_keywords');
$global_template['for_meta_desc'] = get_constant($catalog_constants,'catalog_seo_desc');
$global_template['for_content'] = $_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.php";

// создаём список необходимых JS файлов
$js_for_module = array(
    'ui', 'jcarousel', 'anythingslider', 'my'=>array('slider', 'catalog'),
    'front'=>array($_cur_area),
);


$invalid_index = false;


if (!is_null($_cur_area_sub)){
    // проверяем наличие такой группы
    $isset_category = catalog_m::check_products_group_by_url(mysql_real_escape_string($_cur_area_sub));
    $cat_data = $isset_category;
    if (!$isset_category){
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
        $link_marketplace = "marketplace_p={$friendly_url->url_command['marketplace_p']}";
        $partner_data = global_m::get_user_data_by_login(trim($friendly_url->url_command['marketplace_p']));
        if ($partner_data['result']){
            $partner_id = $partner_data['result_data']['user_id'];
            $partner_name = $partner_data['result_data']['user_fullname'];
			if($partner_data['result_data']['user_default_group']==5) {
                $partner_marketplace = true;
			}
        }
    }
    $resort_array[1] = lang_text('{sort_by_date}');
    $resort_array[2] = lang_text('{sort_by_name}');
    $resort_array[3] = lang_text('{sort_by_cost_max_to_min}');
    $resort_array[4] = lang_text('{sort_by_cost_min_to_max}');

    $resort_products = false;
    if (isset($_POST['select_resort']) && isset($resort_array[$_POST['select_resort']])){
        $resort_products = intval($_POST['select_resort']);
    }

    $local_js_scripts_list = global_v::print_local_js_in_header($js_for_module);
    $params_for_product_list = catalog_m::get_list_params_by_group(2);

    $group_id_for_list = 0;
    if (!is_null($_cur_area_sub)){
        $group_id_for_list = $cat_data['group_id'];
    }


    $search_word = $get_price = $dop_special_condition_for_product_list = NULL;

    $search_get_index = 'search_product';
    if (isset($_GET[$search_get_index])){
        $search_word = mysql_real_escape_string($_GET[$search_get_index]);
        $dop_special_condition_for_product_list[] = 'AND|dop_field_2|LIKE "%'.$search_word.'%" |NULL';
        $dop_special_condition_for_product_list[] = 'OR|o.product_article| LIKE "%'.$search_word.'%" |NULL';
        $group_products_ids = catalog_m::count_product_by_all_child_group($group_id_for_list,true,$seller_id,$partner_id);
        $products_by_search = catalog_m::get_products_list($params_for_product_list,$group_products_ids,NULL,NULL,$dop_special_condition_for_product_list,$resort_products);
    }
	
	// мин/макс значение цен
	$prices_default = catalog_m::count_catalog_min_max_price();
	$prices_default = $prices_default[0];
	
	// мин/макс значение вознаграждения
	$offers_default = catalog_m::count_catalog_min_max_offers();
	$offers_default = $offers_default[0];

    $price_get_index = 'price';
    $price_offer_get_index = 'price_offer';

    if (isset($_GET[$price_get_index])){
        $get_price['min'] = intval($_GET[$price_get_index]['min']);
        $get_price['max'] = intval($_GET[$price_get_index]['max']);
        $max_for_sql = $get_price['max']+1;
        $dop_special_condition_for_product_list[] = 'AND|dop_field_4|>= '.$get_price['min'].'|NULL';
        $dop_special_condition_for_product_list[] = 'AND|dop_field_4|< '.$max_for_sql.'|NULL';
        $group_products_ids = catalog_m::count_product_by_all_child_group($group_id_for_list,true,$seller_id,$partner_id);
        $products_by_price = catalog_m::get_products_list($params_for_product_list,$group_products_ids,NULL,NULL,$dop_special_condition_for_product_list,$resort_products);
    }elseif (isset($_GET[$price_offer_get_index])){
        $get_price_offert['min'] = intval($_GET[$price_offer_get_index]['min']);
        $get_price_offert['max'] = intval($_GET[$price_offer_get_index]['max']);
        $min_for_sql = $get_price_offert['min']*2;
        $max_for_sql = $get_price_offert['max']*2+1;
        $dop_special_condition_for_product_list[] = 'AND|dop_field_11|>= '.$min_for_sql.'|NULL';
        $dop_special_condition_for_product_list[] = 'AND|dop_field_11|< '.$max_for_sql.'|NULL';
        $group_products_ids = catalog_m::count_product_by_all_child_group($group_id_for_list,true,$seller_id,$partner_id);
        $products_by_price = catalog_m::get_products_list($params_for_product_list,$group_products_ids,NULL,NULL,$dop_special_condition_for_product_list,$resort_products);
    }
    $partners_products = NULL;
    if ($auth_class->cur_user_group==5 && $auth_class->cur_user_status_in_group==1){
        $partners_products = catalog_m::partner_products($auth_class->cur_user_id);
    }
    $category_array = catalog_m::get_products_groups();
    $category_resort = resort_array_groups_data($category_array,0);
//    $category_recursion = group_by_recursion(0,4,$category_resort);
//    ash_debug($category_recursion);


    $group_products_ids = catalog_m::count_product_by_all_child_group($group_id_for_list,true,$seller_id,$partner_id);

    $count_products_in_group = (isset($products_by_search))?count($products_by_search):count($group_products_ids);
    $count_products_in_group = (isset($products_by_price))?count($products_by_price):$count_products_in_group;
    $count_products_in_group = (isset($products_by_price))?count($products_by_price):$count_products_in_group;
    $page_nav  = page_navigation::get_page_by_num_for_front($count_products_in_group,$num_of_rows_per_page);

    if ($count_products_in_group>0){
        $products_list = catalog_m::get_products_list($params_for_product_list,$group_products_ids,$page_nav['nav_start_position'],$page_nav['nav_limit'],$dop_special_condition_for_product_list,$resort_products);
    }
	
	// топ продаж для слайдера категорий
    // ash-1 переписать
	$dop_special_condition_for_product_list[] = 'AND|dop_field_18|> 0|NULL';
	$top_products_list = catalog_m::get_top_products_list($params_for_product_list,$group_products_ids,NULL,NULL,$dop_special_condition_for_product_list,$resort_products);
//    ash_debug($top_products_list);
    
}

