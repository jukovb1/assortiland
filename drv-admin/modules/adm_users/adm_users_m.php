<?php
/**
 * adm_users_m.php (admin)
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
$user_fields_data[0] = array(
    'user_default_group'		 => 'u', // группа
    'user_fullname'				 => 'u', // Ф.И.О
    'user_login'				 => 'u', // Логин
    //'user_gender'				 => 'u', // пол
    'user_pass' 				 => 'u', // Пароль
    'user_email'				 => 'u', // E-mail
    'user_phone'				 => 'u', // Телефон
    'user_homepage'				 => 'u', // Адрес сайта
);
// продавцы
$user_fields_data[4] = array(
    'user_default_group'		 => 'u', // группа
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
        'user_bank_name'			 => 'f', // Получатель
        'user_bank_code'			 => 'f', // Код получателя
        'user_bank_fullname'		 => 'f', // Наименование банка
        'user_bank_mfo'				 => 'f', // МФО банка
        'user_bank_rated_number'	 => 'f', // Номер расчетного счета
        'user_bank_card_number'		 => 'f', // Номер карточного счета
        'user_private_code'			 => 'f', // Идентификационный код
        'user_taxes'				 => 'f', // Система налогооблажения
        'user_bank_contact_fullname'=> 'f', // Ф.И.О контактного лица
        'user_bank_contact_phone'	 => 'f', // Телефон контактного лица
        'user_address' 				 => 'f', // Адрес
    ),
);
// партнёры
$user_fields_data[5] = array(
    'user_default_group'		 => 'u', // группа
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
        'user_private_code'			 => 'f', // Идентификационный код
        'user_bank_name'			 => 'f', // Получатель
        'user_bank_code'			 => 'f', // Код получателя
        'user_bank_fullname'		 => 'f', // Наименование банка
        'user_bank_mfo'				 => 'f', // МФО банка
        'user_bank_rated_number'	 => 'f', // Номер расчетного счета
        'user_bank_card_number'		 => 'f', // Номер карточного счета
        'user_taxes'				 => 'f', // Система налогооблажения
    ),

);

$user_fields_data['options'] = array(
    'user_taxes' => global_m::get_taxes_systems(),
    'user_gender' => array(
        1 => lang_text("{gender_male}"),
        0 => lang_text("{gender_female}")
    ),
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
        'err'       => lang_text('{IE_2x104}::{:MIN:}=3'),
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
        'type'		=> 3,
        'required'	=> true,
    ),
    'user_private_code' => array(
        'type'		=> 2,
        'required'	=> true,
        'min'       => 10,
        'max'       => 10,
        'err'       => lang_text('{IE_2x106}::{:LENGTH:}=10'),
    ),
    'user_bank_name' => array(
        'type'		=> 3,
        'required'	=> true,
    ),
    'user_bank_code' => array(
        'type'		=> 2,
        'required'	=> true,
        'min'       => 4,
        'max'       => 15,
        'err'       => lang_text('{IE_2x107}::{:MIN:}=4::{:MAX:}=15'),
    ),
    'user_bank_fullname' => array(
        'type'		=> 3,
        'required'	=> true,
    ),
    'user_bank_mfo' => array(
        'type'		=> 2,
        'required'	=> true,
        'min'       => 6,
        'max'       => 6,
        'err'       => lang_text('{IE_2x106}::{:LENGTH:}=6'),
    ),
    'user_bank_rated_number' => array(
        'type'		=> 2,
        'required'	=> true,
        'min'       => 20,
        'max'       => 20,
        'err'       => lang_text('{IE_2x106}::{:LENGTH:}=20'),
    ),
    'user_bank_card_number' => array(
        'type'		=> 2,
        'required'	=> true,
        'min'       => 16,
        'max'       => 16,
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
);

