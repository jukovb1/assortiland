<?php
/**
 * main_v.php (front)
 *
 * Представление главной страницы фронта
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
// todo ash-0 в языковой файл ->

echo print_big_slider($page_sliders);
?>
<div class="propositions">
    <div class="center">
        <div class="title">
            <?=get_constant($global_constants_main_page,'main_page_offers_title')?>
        </div>
        <div class="l-common">
            <div class="sub-title">
                <?=get_constant($global_constants_main_page,'main_page_offers_partners_title')?>
            </div>
            <p>
                <?=get_constant($global_constants_main_page,'main_page_offers_partners_desc')?>
            </p>
            <a href="javascript:void(0)" class="l-button"><?=get_constant($global_constants_main_page,'main_page_offers_partners_button_title')?></a>
        </div>
        <div class="r-common">
            <div class="sub-title">
                <?=get_constant($global_constants_main_page,'main_page_offers_sellers_title')?>
            </div>
            <p>
                <?=get_constant($global_constants_main_page,'main_page_offers_sellers_desc')?>
            </p>
            <a href="javascript:void(0)" class="r-button"><?=get_constant($global_constants_main_page,'main_page_offers_sellers_button_title')?></a>
        </div>
    </div>
</div>
<div class="helpful">
    <div class="center">
        <div class="title">
            <?=get_constant($global_constants_main_page,'main_page_offers_helpful_title')?>
            <div class="h-button"></div>
        </div>
        <div class="full-descr clearfix">
            <img src="/assets/images/other/diagram.png" style="float: left" alt="<?=lang_text('{alt_img_1}')?>" align="left">
            <?=get_constant($global_constants_main_page,'main_page_offers_helpful_text')?>
        </div>
    </div>
</div>
<div class="sales">
    <div class="center">
        <div class="title">
            <?=get_constant($global_constants_main_page,'main_page_offers_sales_title')?>
        </div>
        <div class="sales-descr">
            <?=get_constant($global_constants_main_page,'main_page_offers_sales_desc')?>
        </div>
        <div class="sales-all">
            <a href="/products" class="sales-button"><?=lang_text('{sales_show_all}')?></a>
        </div>
        <ul class="tab-buttons">
            <?
            foreach($products_for_actions as $sales_area=>$products_for_actions_for_area){
                ?>
                <li>
                    <a href="#" data-sales_area="<?=$sales_area?>" class="change_sales_area <?=$sales_area?>-button"><?=lang_text('{sales_show_'.$sales_area.'}')?></a>
                </li>
            <?
            }
            ?>

        </ul>
        <?
        foreach($products_for_actions as $sales_area=>$products_for_actions_for_area){
            $show=NULL;
            if ($sales_area=='act'){
                $show='style="display: block"';
            }
            ?>

            <div class="actions_block" <?=$show?> id="<?=$sales_area?>_products">
                <ul class="tab-positions">
                    <?
                    foreach($products_for_actions_for_area as $product_id=>$product_data){
                        ?>
                        <li>
                            <div class="tab-pos">
                                <a href="/product/<?=$product_data['product_article']?>">
                                    <div class="tab-img">
                                        <img src="<?=global_v::check_img($product_data['dop_field_9'])?>" />
                                    </div>
                                </a>
                                <div class="icon-wrapper">
                                    <h2><a href="/product/<?=$product_data['product_article']?>"><?=$product_data['dop_field_2']?> <small>(<?=$product_data['product_article']?>)</small></a></h2>
                                    <div class="look">
                                        <a href="javascript:void(0)" class="look-img"></a> <?=$product_data['dop_field_6']?>
                                    </div>
                                    <div class="like">
                                        <a href="javascript:void(0)" class="like-img"></a> <?=$product_data['dop_field_7']?>
                                    </div>
                                    <div class="talk">
                                        <a href="javascript:void(0)" class="talk-img"></a> 45
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?
                    }
                    ?>
                </ul>
            </div>
        <?
        }
        ?>


    </div>
</div>
<div class="partners">
    <div class="center">
        <div class="title"><?=lang_text('{partners_block_title}')?></div>
        <div class="partners-slider-wrapper">
            <div class="partners-slider-left-arrow">Left</div>
            <div class="partners-slider-right-arrow">Right</div>
            <div class="partners-slider">
                <ul>
                    <?
                    foreach($clients_arr as $client_data){
                        echo "<li>";
                        echo "<img width='180' title='{$client_data['cont_title']}' src='".global_v::check_img($client_data['cont_files'])."'>";
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>