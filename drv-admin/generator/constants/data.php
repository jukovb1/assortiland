<?


// группы
$constants_groups = array(
    1 => array(
        'const_group_alias' => 'system',
        'const_group_name' => array(
            1=>'Системные параметры',
            2=>'System',
        )
    ),
    2 => array(
        'const_group_alias' => 'global',
        'const_group_name' => array(
            1=>'Глобальные параметры',
            2=>'Global',
        )
    ),
   	3 => array(
        'const_group_alias' => 'page_main',
        'const_group_name' => array(
            1=>'Главная страница',
            2=>'Main page',
        )
    ),
    4 => array(
        'const_group_alias' => 'page_catalog',
        'const_group_name' => array(
            1=>'Cтраница Каталога',
            2=>'Catalog page',
        )
    ),
    5 => array(
        'const_group_alias' => 'global_commerce',
        'const_group_name' => array(
            1=>'Глобальные коммерческие параметры',
            2=>'Global commerce',
        )
    ),
    6 => array(
        'const_group_alias' => 'global_delivery',
        'const_group_name' => array(
            1=>'Доставка',
            2=>'Delivery',
        )
    ),
    7 => array(
        'const_group_alias' => 'global_main_menu',
        'const_group_name' => array(
            1=>'Главное меню',
            2=>'Main menu',
        )
    ),
    8 => array(
        'const_group_alias' => 'global_slides',
        'const_group_name' => array(
            1=>'Слайды',
            2=>'Slides',
        )
    ),
    9 => array(
        'const_group_alias' => 'global_sliders',
        'const_group_name' => array(
            1=>'Слайдеры',
            2=>'Sliders',
        )
    ),
    10 => array(
        'const_group_alias' => 'global_quote_sliders',
        'const_group_name' => array(
            1=>'Цитаты',
            2=>'Quotes',
        )
    ),
	11 => array(
        'const_group_alias' => 'global_reg_page_agreement',
        'const_group_name' => array(
            1=>'Регистрационные соглашения',
            2=>'Registration agreements',
        )
    ),
    12 => array(
        'const_group_alias' => 'global_regions',
        'const_group_name' => array(
            1=>'Список областей',
            2=>'List of regions',
        )
    ),
);



// Константы
// const_type:
// -1 - разделитель
// 1 - цифровое
// 11 - checkbox
// 21 - строка общая для всех языков
// 22 - текстовое поле обще для всех языков
// 23 - текстовое поле обще для всех языков с редактором
// 31 - строка для языка (индекс из таблицы языковых текстов)
// 32 - текстовое поле для языка (индекс из таблицы языковых текстов)
// 33 - текстовое поле для языка (индекс из таблицы языковых текстов) + редактор
$constants = array(
    1=> array(
        'const_alias' => 'site_name',
        'const_name' => array(
            1=>'Название сайта',
            2=>'Site name',
        ),
        'const_group'   => 2,
        'const_type'    => 31,
        'value'         => array(
            1=>'Ассорти',
            2=>'AssortiLand',
        ),
    ),
    2=> array(
        'const_alias' => 'path_index',
        'const_name' => array(
            1=>'Рабочая папка сайта',
            2=>'Working directory site',
        ),
        'const_group' => 1,
        'const_type' => 21,
        'value'         => '/',
    ),
    
    3=> array(
        'const_alias' => 'site_description',
        'const_name' => array(
            1=>'Описание сайта',
            2=>'Site description',
        ),
        'const_group' => 2,
        'const_type' => 32,
        'value'         => array(
            1=>'Русское описание',
            2=>'English desc',
        ),
    ),
    4=> array(
        'const_alias' => 'site_keywords',
        'const_name' => array(
            1=>'Ключевые слова',
            2=>'Site keywords',
        ),
        'const_group' => 2,
        'const_type' => 32,
        'value'         => array(
            1=>'Русские слова',
            2=>'English keys',
        ),
    ),

    
    
    
    
    
	/* Главная страница */

	5 => array(
        'const_alias' => 'main_page_offers_title',
        'const_name' => array(
            1=>'Заголовок блока предложений',
            2=>'Name of the title for &quot;Our offers&quot;',
        ),
        'const_group' => 3,
        'const_type' => 31,
        'value'         => array(
            1=>'Наши предложения',
            2=>'Your title',
        ),
    ),
	6 => array(
        'const_alias' => 'separator',
        'const_name' => array(
        ),
        'const_group' => 3,
        'const_type' => -1,
        'value'         => array(
            1=>'Блок &quot;Партнерам&quot;',
            2=>'Block &quot;Partners&quot;',
        ),
    ),
	7 => array(
        'const_alias' => 'main_page_offers_partners_title',
        'const_name' => array(
            1=>'Заголовок блока',
            2=>'Name of the title',
        ),
        'const_group' => 3,
        'const_type' => 31,
        'value'         => array(
            1=>'Партнерам',
            2=>'Partners',
        ),
    ),
	8 => array(
        'const_alias' => 'main_page_offers_partners_desc',
        'const_name' => array(
            1=>'Контент блока',
            2=>'Content',
        ),
        'const_group' => 3,
        'const_type' => 33,
        'value'         => array(
            1=>'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.',
            2=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.',
        ),
    ),
	9 => array(
        'const_alias' => 'main_page_offers_partners_button_title',
        'const_name' => array(
            1=>'Надпись на кнопке',
            2=>'Name of the button title for &quot;Partners&quot;',
        ),
        'const_group' => 3,
        'const_type' => 31,
        'value'         => array(
            1=>'Стать партнёром',
            2=>'Your title',
        ),
    ),

	10 => array(
        'const_alias' => 'separator',
        'const_name' => array(
        ),
        'const_group' => 3,
        'const_type' => -1,
        'value'         => array(
            1=>'Блок &quot;Продавцам&quot;',
            2=>'Block &quot;Sellers&quot;',
        ),
    ),
	11 => array(
        'const_alias' => 'main_page_offers_sellers_title',
        'const_name' => array(
            1=>'Заголовок блока',
            2=>'Name of the title',
        ),
        'const_group' => 3,
        'const_type' => 31,
        'value'         => array(
            1=>'Продавцам',
            2=>'Sellers',
        ),
    ),
	12 => array(
        'const_alias' => 'main_page_offers_sellers_desc',
        'const_name' => array(
            1=>'Контент блока',
            2=>'Content',
        ),
        'const_group' => 3,
        'const_type' => 33,
        'value'         => array(
            1=>'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.',
            2=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.',
        ),
    ),
	13 => array(
        'const_alias' => 'main_page_offers_sellers_button_title',
        'const_name' => array(
            1=>'Надпись на кнопке',
            2=>'Name of the button title for &quot;Partners&quot;',
        ),
        'const_group' => 3,
        'const_type' => 31,
        'value'         => array(
            1=>'Стать продавцом',
            2=>'Your title',
        ),
    ),

	14 => array(
        'const_alias' => 'separator',
        'const_name' => array(
        ),
        'const_group' => 3,
        'const_type' => -1,
        'value'         => array(
            1=>'Блок &quot;Помощь роста&quot;',
            2=>'Block about &quot;Help of groove&quot;',
        ),
    ),
	15 => array(
        'const_alias' => 'main_page_offers_helpful_title',
        'const_name' => array(
            1=>'Заголовок',
            2=>'Title',
        ),
        'const_group' => 3,
        'const_type' => 31,
        'value'         => array(
            1=>'Как мы можем помочь вашему бизнесу расти?',
            2=>'Your title',
        ),
    ),

	16 => array(
        'const_alias' => 'main_page_offers_helpful_text',
        'const_name' => array(
            1=>'Контент',
            2=>'Content',
        ),
        'const_group' => 3,
        'const_type' => 33,
        'value'         => array(
            1=>'<p>Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat.</p>',
            2=>'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat.',
        ),
    ),
	17 => array(
        'const_alias' => 'separator',
        'const_name' => array(
        ),
        'const_group' => 3,
        'const_type' => -1,
        'value'         => array(
            1=>'Блок &quot;Акционных предложений&quot;',
            2=>'Block of &quot;Action sales&quot;',
        ),
    ),
	18 => array(
        'const_alias' => 'main_page_offers_sales_title',
        'const_name' => array(
            1=>'Заголовок',
            2=>'Name of the title for &quot;Action sales&quot;',
        ),
        'const_group' => 3,
        'const_type' => 31,
        'value'         => array(
            1=>'Акционные предложения',
            2=>'Action sales',
        ),
    ),
	19 => array(
        'const_alias' => 'main_page_offers_sales_desc',
        'const_name' => array(
            1=>'Краткий текст',
            2=>'Short text',
        ),
        'const_group' => 3,
        'const_type' => 32,
        'value'         => array(
            1=>'В данном блоке отображены последние из поступивших акционных предложений. Нажмите на кнопку ниже, чтобы просмотреть больше.',
            2=>'В данном блоке отображены последние из поступивших акционных предложений. Нажмите на кнопку ниже, чтобы просмотреть больше.',
        ),
    ),


	/* Страница Каталога */
	20 => array(
        'const_alias' => 'catalog_seo_keywords',
        'const_name' => array(
            1=>'SEO ключевые слова',
            2=>'SEO keywords',
        ),
        'const_group' => 4,
        'const_type' => 31,
        'value'         => array(
            1=>'каталог, каталог товаров, каталог продуктов',
            2=>'catalog, catalog of products, catalog of services',
        ),
    ),
    21 => array(
        'const_alias' => 'catalog_seo_title',
        'const_name' => array(
            1=>'SEO заголовок',
            2=>'SEO title',
        ),
        'const_group' => 4,
        'const_type' => 31,
        'value'         => array(
            1=>'Интернет-проект АссортиЛенд',
            2=>'Project Assortiland',
        ),
    ),
    22 => array(
        'const_alias' => 'catalog_seo_desc',
        'const_name' => array(
            1=>'SEO описание',
            2=>'SEO description',
        ),
        'const_group' => 4,
        'const_type' => 32,
        'value'         => array(
            1=>'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.',
            2=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.',
        ),
    ),
    
	/* Глобальные коммерческие данные */
	23 => array(
        'const_alias' => 'site_commerce_min',
        'const_name' => array(
            1=>'Процент < 1000',
            2=>'Percent < 1000',
        ),
        'const_group' => 5,
        'const_type' => 1,
        'value'         => 10,

    ),
    24 => array(
        'const_alias' => 'site_commerce_middle',
        'const_name' => array(
            1=>'Процент >= 1000 и < 5000',
            2=>'Percent >= 1000 & < 5000',
        ),
        'const_group' => 5,
        'const_type' => 1,
        'value'         => 12,
    ),
    25 => array(
        'const_alias' => 'site_commerce_high',
        'const_name' => array(
            1=>'Процент > 5000',
            2=>'Percent > 5000',
        ),
        'const_group' => 5,
        'const_type' => 1,
        'value'         => 15,

    ),
    
	/* Доставка */
	26 => array(
        'const_alias' => 'delivery_services',
        'const_name' => array(
            1=>'Способы доставки',
            2=>'Delivery services',
        ),
        'const_group' => 6,
        'const_type' => 22,
        'value'      => '',
    ),
    
	/* Главное меню */
	27 => array(
        'const_alias' => 'site_main_menu',
        'const_name' => array(
            1=>'Главное меню',
            2=>'Main menu',
        ),
        'const_group' => 7,
        'const_type' => 32,
        'value'         => array(
            1=>'Главная|http://httpdocs.assortiland, Профиль|http://httpdocs.assortiland/profile',
            2=>'Main|http://httpdocs.assortiland, Profile|http://httpdocs.assortiland/profile',
        ),
    ),
    
	/* Слайды */
	28 => array(
        'const_alias' => 'site_slides',
        'const_name' => array(
            1=>'Слайды',
            2=>'Slides',
        ),
        'const_group' => 8,
        'const_type' => 32,
        'value'         => array(
            1=>'slide1|Название|Под название|Описание|Кнопка|http://httpdocs.assortiland|http://httpdocs.assortiland; slide2|Название|Под название|Описание|Кнопка|http://httpdocs.assortiland|http://httpdocs.assortiland',
            2=>'slide1|Name|Subname|Description|Button|http://httpdocs.assortiland|http://httpdocs.assortiland; slide2|Name|Subname|Description|Button|http://httpdocs.assortiland|http://httpdocs.assortiland',
        ),
    ),
    
	/* Слайдеры */
	29 => array(
        'const_alias' => 'site_sliders',
        'const_name' => array(
            1=>'Слайдеры',
            2=>'Sliders',
        ),
        'const_group' => 9,
        'const_type' => 32,
        'value'         => array(
            1=>'',
            2=>'',
        ),
    ),


	/* Контактные данные */
	30=> array(
        'const_alias' => 'separator',
        'const_name' => array(
        ),
        'const_group' => 2,
        'const_type' => -1,
        'value'         => array(
            1=>'Информация в футере',
            2=>'Info in footer',
        ),
    ),
	31 => array(
        'const_alias' => 'footer_info_title',
        'const_name' => array(
            1=>'Заголовок',
            2=>'Title',
        ),
        'const_group' => 2,
        'const_type' => 31,
        'value'         => array(
            1=>'Информация',
            2=>'Information',
        ),
    ),
	32 => array(
        'const_alias' => 'footer_info_content',
        'const_name' => array(
            1=>'Контент',
            2=>'Content',
        ),
        'const_group' => 2,
        'const_type' => 33,
        'value'         => array(
            1=>'Телефон:123-45-78<br>e-mail:support@assortiland.com',
            2=>'Telephone:123-45-78<br>e-mail:support@assortiland.com',
        ),
    ),
    33 => array(
        'const_alias' => 'separator',
        'const_name' => array(
        ),
        'const_group' => 2,
        'const_type' => -1,
        'value'         => array(
            1=>'Уведомления администратора',
            2=>'Notify the administrator',
        ),
    ),
	34 => array(
        'const_alias' => 'email_support',
        'const_name' => array(
            1=>'E-mail для уведомлений',
            2=>'E-mail notification',
        ),
        'const_group' => 2,
        'const_type' => 21,
        'value'         => "support@assorty.com",
    ),
    35 => array(
        'const_alias' => 'email_support_reg',
        'const_name' => array(
            1=>'Регистрация нового пользователя',
            2=>'New user registration',
        ),
        'const_group' => 2,
        'const_type' => 11,
        'value'         => 1,
    ),
    36 => array(
        'const_alias' => 'email_support_join',
        'const_name' => array(
            1=>'Заявки на вступление в спец. группу',
            2=>'Requests to join special group',
        ),
        'const_group' => 2,
        'const_type' => 11,
        'value'      => 1,
    ),

    37 => array(
        'const_alias' => 'email_support_order_error',
        'const_name' => array(
            1=>'Ошибки оформления заказа',
            2=>'Ordering Errors',
        ),
        'const_group' => 2,
        'const_type' => 11,
        'value'         => 1,
    ),
    38 => array(
        'const_alias' => 'site_commerce_bank_requisites',
        'const_name' => array(
            1=>'Реквизиты банка',
            2=>'Percent < 1000',
        ),
        'const_group' => 5,
        'const_type' => 32,
        'value'         => array(
            1=>"Наименование: БАНК КРЕДИТНЫЙ \r\nПолучатель:11111 \r\nМФО:11111",
            2=>"Наименование: БАНК КРЕДИТНЫЙ \r\nПолучатель:11111 \r\nМФО:11111",
        ),
    ),
    
    /* Цитаты */
	39 => array(
        'const_alias' => 'site_quotes',
        'const_name' => array(
            1=>'Цитаты',
            2=>'Quotes',
        ),
        'const_group' => 10,
        'const_type' => 32,
        'value'         => array(
            1=>'Lorem Ipsum 1|Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн.; Lorem Ipsum 2|Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн.',
            2=>'Lorem Ipsum 3|Lorem Ipsum is simply dummy text of the printing and typesetting industry.; Lorem Ipsum 4|Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
        ),
    ),
    
	// Список областей
	40 => array(
        'const_alias' => 'site_regions',
        'const_name' => array(
            1=>'Список регионов Украины',
            2=>'List of Ukraine regions',
        ),
        'const_group' => 12,
        'const_type' => 32,
        'value'         => array(
            1=>'Винницкая область, Волынская область, Днепропетровская область, Донецкая область, Житомирская область, Закарпатская область, Запорожская область, Ивано-Франковская область, Киевская область, Кировоградская область, Крым, Луганская область, Львовская область, Николаевская область, Одесская область, Полтавская область, Ровенская область, Сумская область, Тернопольская область, Харьковская область, Херсонская область, Хмельницкая область, Черкасская область, Черниговская область, Черновицкая область',
            2=>'Винницкая область, Волынская область, Днепропетровская область, Донецкая область, Житомирская область, Закарпатская область, Запорожская область, Ивано-Франковская область, Киевская область, Кировоградская область, Крым, Луганская область, Львовская область, Николаевская область, Одесская область, Полтавская область, Ровенская область, Сумская область, Тернопольская область, Харьковская область, Херсонская область, Хмельницкая область, Черкасская область, Черниговская область, Черновицкая область',
        ),
    ),

    // Регистрационные соглашения
    41 => array(
        'const_alias' => 'reg_page_assignments_public_offer',
        'const_name' => array(
            1=>'Условия публичной оферты',
            2=>'The conditions of the public offer',
        ),
        'const_group' => 11,
        'const_type' => 33,
        'value'         => array(
            1=>'<p>Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat.</p>',
            2=>'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat.',
        ),
    ),
);
