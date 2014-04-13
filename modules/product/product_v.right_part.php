<?php
/**
 * product_v.php (front)
 *
 * Представление продукта из каталога
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

// ф-ция get_product_data(ID_ПАРАМЕТРА)
// список параметров можешь посмотреть так:
// ash_debug($product_data['params']);

// ash-0 mal-0 вынести весь статический текст в языковой файл
$catalog = 'catalog';
?>
<h2 class="product-title"><?=$product_name?> <span class="product-code">(<?=$product_article?>)</span></h2>

<div class="breadcrumbs">
    <a href="/"><?=lang_text('{main_menu}')?></a> /

    <?
    if (is_null($_cur_area_sub)){
        echo lang_text('{catalog_menu}');
    } else {
        echo " <a href='/$catalog'>".lang_text('{catalog_menu}')."</a> /";
        $breadcrumbs =  breadcrumbs_create($category_array,$cat_data['group_parent_group']);
        echo (!is_null($breadcrumbs))?implode(' ',$breadcrumbs):NULL;
        echo " <a href='/$catalog/{$cat_data['group_short_name']}'>{$cat_data['group_full_name']}</a> / ";
        echo "$product_name";
    }
    ?>
</div>

<div class="product-wrapper clearfix">
    <div class="product-top clearfix">
        <div class="product-auth">
            Разместил:
            <?
            if (!is_null($product_owner_data)){
                echo "<a href='/catalog/marketplace={$product_owner_data['user_login']}' title='Перейти на страницу продавца'>{$product_owner_data['user_fullname']}</a>";
            } else {
                echo "<span>".lang_text('{no_owner_found}')."</span>";
            }
            ?>
        </div>
        <div class="p-talk">
            <a href="javascript:void(0)" title="Количество отзывов товара" class="p-talk-img"></a> 45
        </div>
        <div class="p-like">
            <a data-article="<?=$_cur_area_sub?>" href="javascript:void(0)" title="Количество довольных покупателей" class="p-like-img"></a> <span><?=get_product_data(7)?></span>
        </div>
        <div class="p-look">
            <a href="javascript:void(0)" title="Количество просмотров товара" class="p-look-img"></a> <?=get_product_data(6)?>
        </div>
    </div>
    <div class="prduct-slider">
        <ul id="slider-name">
            <li class="panel1">
                <?
                if(!empty($auth_class->cur_user_login) && ($auth_class->cur_user_group==5 && $auth_class->cur_user_status_in_group==1)) {
                ?>
                <div class="offer"><p><?=get_product_data(11)/2?>%</p></div>
                <?
                }
                ?>
                <img src="<?=global_v::check_img(get_product_data(9),2)?>" alt="" width="600px" height="385px">
            </li>
        </ul>
    </div>
    <div class="product-left clearfix">
        <ul class="product-tab">
            <li><a href="javascript:void(0)" id="tab-1" class="tab-selected"><?=lang_text('{tab_desc}')?></a></li>
            <li><a href="javascript:void(0)" id="tab-2"><?=lang_text('{tab_carrier}')?></a></li>
            <li><a href="javascript:void(0)" id="tab-3"><?=lang_text('{tab_talk}')?></a></li>
        </ul>
        <br style="clear: both">
        <div class="tabs-block clearfix" id="tab-1-c">
            <p>
                <?
                $desc = get_product_data(3);
                echo (!empty($desc))?nl2br($desc):lang_text('{empty_desc}');
                ?>
            </p>
        </div>
        <div class="tabs-block clearfix" id="tab-2-c">
            <p>
                <?
                $delivery_arr = get_product_data(17);
                if (count($delivery_arr)==1){
                    echo lang_text('{delivery_text_one}')."<br>".current($delivery_arr);
                } else {
                    echo lang_text('{delivery_text_more}');
                    echo "<ul class='delivery_list'>";
                    foreach($delivery_arr as $delivery){
                        echo "<li>$delivery</li>";
                    }
                    echo "</ul>";
                }
                ?>
            </p>
        </div>
        <div class="tabs-block clearfix" id="tab-3-c">
            <?=comment_block();?>
        </div>
    </div>
    <div class="product-right clearfix">
    	<?
    	$action_price = get_product_data(4);
		$general_price = get_product_data(5);
    	if(isset($action_price) && ($action_price > 0)) {
        	echo "<div class='price-old'>{$general_price} ₴</div>";
        	echo "<div class='price-current'>{$action_price} ₴</div>";
        } else {
        	echo "<div class='price-current'>{$general_price} ₴</div>";
        }
        ?>
        <div class="product-buy add_to_cart" title="" data-product-article="<?= $_cur_area_sub ?>"><?=lang_text('{button_buy}')?></div>
        <?
        if(!empty($auth_class->cur_user_login) && ($auth_class->cur_user_group==5 && $auth_class->cur_user_status_in_group==1)) {
            if (isset($partners_products[get_product_data('product_id')])){
                $show = 'block';
            } else {
                $show = 'none';
                ?>
                <div class="product-buy add_to_partner" title="" data-product-article="<?= $_cur_area_sub ?>"><?=lang_text('{button_to_partner}')?></div>
                <?
            }
            ?>
            <div style="display: <?=$show?>" class="isset_block">
                <br><br>
                <div class=""><?=lang_text('{isset_in_partner_list}')?></div>
            </div>
            <?
        }
        ?>
        <!--div class="product-buy" title="Отложить товар"><?=lang_text('{button_buy_dozen}')?></div-->
        <?=str_to_list(get_product_data(12),'dignity');?>
        <?
        	$action_start = get_product_data(13);
			$action_end = get_product_data(14);
			
			if(!empty($action_start) && !empty($action_end)) {
				$action_start = date('d.m.y', strtotime($action_start));
				$action_end = date('d.m.y', strtotime($action_end));
				echo "<div class='product-date'>Акция действует:<span>{$action_start} - {$action_end}</span></div>";
			}
        ?>
    </div>
</div>
