<?php
/**
 * profile_m.php (admin)
 *
 * Файл модели продукции админки
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

//  1 - !system
//  2 - number
//  3 - string
//  4 - boolean
//  5 - select (single)
//  6 - select (multy)
//  7 - textarea
//  8 - file

// массив для различного типа пользователей
$user_fields_data['for_cart'] = array(
    'user_fullname'				 => 'u', // Ф.И.О
    'user_email'				 => 'u', // E-mail
    'user_phone'				 => 'u', // Телефон
    'full_data' => array(
        'user_address'              => 'f',
    ),
);
$user_fields_data['registration'] = array(
    'user_login'				 => 'u', // Логин
    'user_email'				 => 'u', // E-mail
    //'user_gender'				 => 'u', // пол
    'user_pass' 				 => 'u', // Пароль
    'captcha'				 	 => 'u', // Текст с изображения
);
$user_fields_data[1] = array(
    'user_fullname'				 => 'u', // Ф.И.О
    'user_login'				 => 'u', // Логин
    //'user_gender'				 => 'u', // пол
    'user_pass' 				 => 'u', // Пароль
    'user_email'				 => 'u', // E-mail
    'user_phone'				 => 'u', // Телефон
    //'user_homepage'				 => 'u', // Адрес сайта
    'full_data' => array(
        //'user_address'              => 'f',
        'user_delivery_region'		 => 'f', // Регионы доставки Украины
    ),
);
// продавцы
$user_fields_data[4] = array(
    'user_fullname'				 => 'u', // Наименование продавца
    'user_login'				 => 'u', // Логин
    //'user_gender'				 => 'u', // пол
    'user_pass' 				 => 'u', // Пароль
    'user_email'				 => 'u', // E-mail
    'user_phone'				 => 'u', // Телефон
    'user_homepage'				 => 'u', // Адрес сайта
    'full_data' => array(
        'user_company_desc'			 => 'f', // Краткое описание компании
        'user_company_dop_info'		 => 'f', // Дополнительная информация
        'user_address' 				 => 'f', // Адрес
        'user_bank_contact_fullname'=> 'f', // Ф.И.О контактного лица
        'user_bank_contact_phone'	 => 'f', // Телефон контактного лица
        'is_separator_1'			 => '{edit_payment_info}', // разделитель
        'user_bank_name'			 => 'f', // Получатель
        'user_bank_code'			 => 'f', // Код получателя
        'user_bank_fullname'		 => 'f', // Наименование банка
        'user_bank_mfo'				 => 'f', // МФО банка
        'user_bank_rated_number'	 => 'f', // Номер расчетного счета
        //'user_bank_card_number'		 => 'f', // Номер карточного счета
        //'user_private_code'			 => 'f', // Идентификационный код
        'user_taxes'				 => 'f', // Система налогооблажения
        'user_delivery_region'		 => 'f', // Регионы доставки Украины
    ),
);
// партнёры
$user_fields_data[5] = array(
    'user_fullname'				 => 'u', // Ф.И.О
    'user_login'				 => 'u', // Логин
    //'user_gender'				 => 'u', // пол
    'user_pass' 				 => 'u', // Пароль
    'user_email'				 => 'u', // E-mail
    'user_phone'				 => 'u', // Телефон
    'user_homepage'				 => 'u', // Адрес сайта
    'full_data' => array(
        'user_company_desc'			 => 'f', // Краткое описание деятельности
        'user_address' 				 => 'f', // Почтовый адрес
        'is_separator_1'			 => '{edit_payment_info}', // разделитель
        //'user_private_code'			 => 'f', // Идентификационный код
        'user_bank_name'			 => 'f', // Получатель
        'user_bank_code'			 => 'f', // Код получателя
        'user_bank_fullname'		 => 'f', // Наименование банка
        'user_bank_mfo'				 => 'f', // МФО банка
        'user_bank_rated_number'	 => 'f', // Номер расчетного счета
        //'user_bank_card_number'		 => 'f', // Номер карточного счета
        'user_taxes'				 => 'f', // Система налогооблажения
        'user_delivery_region'		 => 'f', // Регионы доставки Украины
    ),

);

// массив для различного типа пользователей
$user_fields_data['view'][1] = array(
    'user_fullname'				 => 'u', // Ф.И.О
    'user_login'				 => 'u', // Логин
    //'user_gender'				 => 'u', // пол
    //'user_homepage'				 => 'u', // Адрес сайта
    /*'full_data' => array(
        'user_address'              => 'f',
    ),*/
);
// продавцы
$user_fields_data['view'][4] = array(
    'user_fullname'				 => 'u', // Ф.И.О
    'user_login'				 => 'u', // Логин
    //'user_gender'				 => 'u', // пол
    'user_homepage'				 => 'u', // Адрес сайта
    'full_data' => array(
        'user_company_desc'			 => 'f', // Краткое описание компании
        'user_company_dop_info'		 => 'f', // Дополнительная информация
    ),
);
// партнёры
$user_fields_data['view'][5] = array(
    'user_fullname'				 => 'u', // Ф.И.О
    'user_login'				 => 'u', // Логин
    //'user_gender'				 => 'u', // пол
    'user_homepage'				 => 'u', // Адрес сайта
    'full_data' => array(
        'user_company_desc'			 => 'f', // Краткое описание деятельности
    ),
);

$user_fields_data['options'] = array(
    'user_taxes' => global_m::get_taxes_systems(),
    'user_gender' => array(
        1 => lang_text("{gender_male}"),
        0 => lang_text("{gender_female}")
    ),
    'user_delivery_region' => global_m::get_delivery_regions(),
);


$user_fields_data['validation'] = array(
    'user_gender' => array(
        'type'		=> 5,
    ),
    'user_default_group' => array(
        'type'		=> 5,
    ),
    'user_fullname' => array(
        'type'		=> 3,
        'required'	=> true,
    ),
    'user_login' => array(
        'type'		=> 3,
        'required'	=> true,
        'min'		=> 3,
        'err'       => lang_text('{IE_2x112}::{:MIN:}=3'),
    ),
    'captcha' => array(
        'type'		=> 3,
        'required'	=> true,
        'err'       => lang_text('{IE_3x107}'),
    ),
    'user_pass' => array(
        'type'		=> 3,
        'min'		=> 6,
        'err'       => lang_text('{IE_2x104}::{:MIN:}=6'),
    ),
    'user_email' => array(
        'type'		=> 3,
        'required'	=> true,
        'html5'     => 'email'
    ),
    'user_avatar' => array(
        'type'		=> 8,
        'accept'    => "image/jpeg,image/jpg,image/png,image/gif",
    ),
    'user_phone' => array(
        'type'		=> 3,
        'required'	=> true,
    ),
    'user_company_desc' => array(
        'type'		=> 7,
        'editor'    => true,
    ),
    'user_company_dop_info' => array(
        'type'		=> 7,
        'editor'    => true,
    ),
    'user_address' => array(
        'type'		=> 7,
        'required'	=> false,
    ),
    'user_private_code' => array(
        'type'		=> 2,
        'required'	=> true,
        'min'       => 10,
        'err'       => lang_text('{IE_2x106}::{:LENGTH:}=10'),
    ),
    'user_bank_name' => array(
        'type'		=> 3,
        'required'	=> true,
    ),
    'user_bank_code' => array(
        'type'		=> 2,
        'required'	=> true,
        'min'       => 8,
        'err'       => lang_text('{IE_2x102}::{:MIN:}=8'),
    ),
    'user_bank_fullname' => array(
        'type'		=> 3,
        'required'	=> true,
    ),
    'user_bank_mfo' => array(
        'type'		=> 2,
        'required'	=> true,
        'min'       => 6,
        'err'       => lang_text('{IE_2x106}::{:LENGTH:}=6'),
    ),
    'user_bank_rated_number' => array(
        'type'		=> 2,
        'required'	=> true,
        'min'       => 5,
        'max'       => 14,
        'err'       => lang_text('{IE_2x107}::{:MIN:}=5::{:MAX:}=14'),
    ),
    'user_bank_card_number' => array(
        'type'		=> 2,
        'required'	=> true,
        'min'       => 16,
        'err'       => lang_text('{IE_2x106}::{:LENGTH:}=16'),
    ),
    'user_taxes' => array(
        'type'		=> 5,
        'required'	=> true,
    ),
    'user_bank_contact_fullname' => array(
        'type'		=> 3,
        'required'	=> true,
    ),
    'user_bank_contact_phone' => array(
        'type'		=> 3,
        'required'	=> true,
    ),
    'user_homepage' => array(
        'type'		=> 3,
    ),
    'user_delivery_region' => array(
        'type'		=> 5,
    ),
);


// перечень полей доступных для блока профиля
// 1 - все
// 4 - продавцы
// 5 - партнеры
// 0 - гости

// массив для всех пунктов меню
$left_menu_fields_data['menu'] = array(
    'cabinet'	=> array(
    	'title'	=> lang_text("{left_menu_cabinet}"),
    	'url'	=> '/profile',
    	'active'=> false,
	),
	'cart'	=> array(
    	'title'	=> lang_text("{left_menu_cart}"),
    	'url'	=> '/profile/cart',
    	'active'=> false,
	),
	'sellers_marketplace'	=> array(
    	'title'	=> lang_text("{left_menu_partners_marketplace}"),
    	'url'	=> '/catalog/marketplace_p={USER_LOGIN}',
    	'active'=> false,
	),
	/*'sellers_marketplace'	=> array(
    	'title'	=> lang_text("{left_menu_sellers_marketplace}"),
    	'url'	=> '/catalog/marketplace={USER_LOGIN}',
    	'active'=> false,
	),*/
	'seller_products'	=> array(
    	'title'	=> lang_text("{left_menu_seller_products}"),
    	'url'	=> '/profile/seller',
    	'active'=> false,
	),
	'join_seller'	=> array(
    	'title'	=> lang_text("{left_menu_join_seller}"),
    	'url'	=> '/profile/join=4',
    	'active'=> false,
	),
	'join_partner'	=> array(
    	'title'	=> lang_text("{left_menu_join_partner}"),
    	'url'	=> '/profile/join=5',
    	'active'=> false,
	),
	'stats'	=> array(
    	'title'	=> lang_text("{left_menu_stats}"),
    	'url'	=> '/profile/statistics',
    	'active'=> false,
	),
	'info'	=> array(
    	'title'	=> lang_text("{left_menu_info}"),
    	'url'	=> '/profile/info',
    	'active'=> false,
	),
	'auth'	=> array(
    	'title'	=> lang_text("{auth_title}"),
    	'url'	=> '/profile/auth',
    	'active'=> false,
	),
	'registration'	=> array(
    	'title'	=> lang_text("{reg_title}"),
    	'url'	=> '/profile/auth/registration',
    	'active'=> false,
	),
	'logout'	=> array(
    	'title'	=> lang_text("{logout}"),
    	'url'	=> '?logout',
    	'active'=> false,
	),
);
// гости
$left_menu_fields_data[0] = array(
	'auth','registration','cart',
);
// все
$left_menu_fields_data[1] = array(
	'cabinet','cart','logout',
);
$left_menu_fields_data[3] = array(
    'cabinet','join_seller','join_partner','cart','logout',
);


// продавцы
$left_menu_fields_data[4] = array(
	'cabinet', 'cart', 'seller_products', 'sellers_marketplace', 'stats', 'info','logout',
);
// партнеры
$left_menu_fields_data[5] = array(
	'cabinet', 'cart', 'join_seller', 'sellers_marketplace', 'stats', 'info','logout',
);
if ($auth_class->cur_user_status_in_group==0 && ($auth_class->cur_user_group==4 || $auth_class->cur_user_group==5)){
    $left_menu_fields_data[$auth_class->cur_user_group] = array(
        'cabinet','cart','logout',
    );
}
// ----- Блок Информации для профиля -----
// продавцы
$info_pages[4] = 'sellers-info-page';
// партнеры
$info_pages[5] = 'partners-info-page';


// список групп доступных для вступления пользователей
$cur_join_group[4] = true;
$cur_join_group[5] = true;