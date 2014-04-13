<?php
/**
 * users_v.groups_list.php (admin)
 *
 * Представление страницы групп товаров
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

<div class="prof-right-wrap">
    <h2><?=lang_text('{left_menu_seller_products}')?></h2>
    <div class="edit-prof"><img src="/assets/images/profile/edit-but.png" /> <a href="<?=$add_url?>" /><?=lang_text('{seller_add_position}')?></a></div>
    <?
    if (count($products_list)==0){
        echo lang_text("{seller_no_products}");
    }else{
        foreach($products_list as $product_id=>$product_data){
            ?>
            <div class="your-product" data-product-article="<?=$product_data['product_article']?>">
                <div class="your-product-image">
                	<a target="_blank" href="<?=$product_url.$product_data['product_article']?>">
                    	<img src="<?=global_v::check_img($product_data['dop_field_9'])?>?w=299&h=182" />
                    </a>
                </div>
                <div class="your-product-main">
                    <ul class="your-product-button" data-product-article="<?=$product_data['product_article']?>">
                        <li><a href="<?=($edit_url.$product_data['product_article'])?>"><?=lang_text('{seller_edit_position}')?></a></li>
                        <li><a href="javascript:void(0)" class="seller_hide_position"><?=$product_data['product_status']==1?lang_text('{seller_hide_position}'):lang_text('{seller_show_position}')?></a></li>
                        <li><a href="javascript:void(0)" class="seller_del_position"><?=lang_text('{seller_del_position}')?></a></li>
                    </ul>
                    <h4><a target="_blank" href="<?=$product_url.$product_data['product_article']?>"><?=$product_data['dop_field_2']?></a></h4>
                    <p><?= isset($product_data['dop_field_3'])?mb_strcut($product_data['dop_field_3'], 0, 500):lang_text('{seller_empty_desc}')?></p>
                    <div class="your-product-code"><?=lang_text('{seller_product_article}')?>: <?=$product_data['product_article']?></div>
                </div>
            </div>
        <?
        }
    }
    ?>
    <div class="prod-pag">
        <?=$page_nav['nav_menu'];?>
    </div>
</div>