<?php
/**
 * catalog_v.php (front)
 *
 * Представление каталога
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

$catalog = 'catalog';
$product = 'product';
?>
<script type="text/javascript">
    var price = {};
    price['min'] = <?= isset($prices_default['min'])?$prices_default['min']:0 ?>;
    price['max'] = <?= isset($prices_default['max'])?$prices_default['max']:0 ?>;

    var price_offer = {};
    price_offer['min'] = <?= isset($offers_default['min'])?$offers_default['min']:0 ?>;
    price_offer['max'] = <?= isset($offers_default['max'])?$offers_default['max']:0 ?>;
</script>
<div class="catwrapper">
    <div class="leftwrapper">
        <div class="wrapper-drop cat-categories">
            <h2 class="sub_title"><?=lang_text('{category}')?></h2><div class="hb-but"></div>
        </div>
        <?
        $cat_hide = 'catmenu_hide';
        if ($_cur_area == $catalog){
            $cat_hide = '';
        }
        ?>
        <ul id='catmenu' class="catmenu <?=$cat_hide?>">
            <li>
                <a href="/<?=$catalog?>/<?=$link_marketplace?>">
                    <?=lang_text('{all_products}');?>
                    <?
                    $group_products_ids = catalog_m::count_product_by_all_child_group(0,true,$seller_id,$partner_id);
                    $count_product = count($group_products_ids);
                    ?>
                    <span class="cat-qty">(<?=$count_product?>)</span>
                </a>
            </li>
            <?
            foreach($category_array[0] as $parent_id=>$parent_data){
                ?>
                <li>
                    <a href="/<?=$catalog?>/<?=$parent_data['group_short_name'];?>/<?=$link_marketplace?>">
                        <?=$parent_data['group_full_name'];?>
                        <?
                        $group_products_ids = catalog_m::count_product_by_all_child_group($parent_data['group_id'],true,$seller_id,$partner_id);
                        $count_product = count($group_products_ids);
                        ?>
                        <span class="cat-qty">(<?=$count_product?>)</span>
                    </a>
                    <?
                    if(isset($category_array[$parent_id])){
                        ?>
                        <div class="catmenu-wrapper">
                            <ul class="subcatmenu">
                                <?
                                foreach($category_array[$parent_id] as $item_id=>$item_data){
                                    ?>
                                    <li>
                                        <a href="/<?=$catalog?>/<?=$item_data['group_short_name'];?>/<?=$link_marketplace?>">
                                            <?=$item_data['group_full_name'];?>
                                            <?
                                            $group_products_ids = catalog_m::count_product_by_all_child_group($item_data['group_id'],true,$seller_id,$partner_id);
                                            $count_product = count($group_products_ids);
                                            ?>
                                            <span class="cat-qty">(<?=$count_product?>)</span>
                                        </a>
                                    </li>
                                <?
                                }
                                ?>
                            </ul>
                            <!--                            <div class="sub-product" id="sub-product">-->
                            <!--                                <div class="subcatmenu-slider-left-arrow"></div>-->
                            <!--                                <div class="jcarousel">-->
                            <!--                                    --><?//
                            //                                    if(!empty($top_products_list)) {
                            //                                        ?>
                            <!--                                        <ul>-->
                            <!--                                            --><?//
                            //                                            foreach ($top_products_list as $product_id => $product_data) {
                            //                                                ?>
                            <!--                                                <li>-->
                            <!--                                                    <a title="--><?//=$product_data['dop_field_2']?><!--" href="--><?//= "/{$product}/{$product_data['product_article']}"?><!--" class="sub-link">-->
                            <!--                                                        <img src="--><?//=global_v::check_img(strlen($product_data['dop_field_9'])>0?$product_data['dop_field_9']:'/catalog')?><!--">-->
                            <!--                                                    </a>-->
                            <!--                                                </li>-->
                            <!--                                            --><?//
                            //                                            }
                            //                                            ?>
                            <!--                                        </ul>-->
                            <!--                                    --><?//	} ?>
                            <!--                                </div>-->
                            <!--                                <div class="subcatmenu-slider-right-arrow"></div>-->
                            <!--                            </div>-->
                        </div>
                    <?
                    }
                    ?>

                </li>

            <?
            }
            ?>
        </ul>
        <?
        $class_search = "search-form";
        if (isset($search_word)){
            $class_search = "search-form-visible";
        }
        ?>
        <div class="wrapper-drop cat-search">
            <h2 class="sub_title"><?=lang_text('{search}')?></h2><div class="hb-but"></div>
        </div>
        <?
        $search_form_action = ($_cur_area != $catalog)?"/$catalog":'';
        ?>
        <form class="<?=$class_search?>" id="search-form" action="<?=$search_form_action?>" method="get">
            <fieldset>
                <div class="row">
                    <input type="text" name="<?=$search_get_index?>" value="<?=$search_word?>" placeholder="<?=lang_text('{search_text}')?>" id="search_input">
                    <button class="searchsubmit" onclick="if($('#search_input').val().length<=0){return false;}"> </button>
                </div>
            </fieldset>
        </form>
        <div class="price-scroller">
            <div class="wrapper-drop cat-price">
                <h2 class="sub_title"><?=lang_text('{cost}')?></h2><div class="hb-but"></div>
            </div>
            <?
            $class_price = "price-form";
            if (isset($get_price)){
                $class_price = "price-form-visible";
            }
            ?>
            <form class="<?=$class_price?>" id="price-form" action="<?=$search_form_action?>" method="get">
                <label for="lower_bound"><?=lang_text('{cost_from}')?></label>
                <input name="price[min]" id="lower_bound" class="lower_bound" value="<?=(isset($get_price['min']))?$get_price['min']:""?>" title="<?=lang_text('{cost_text_min}')?>" onfocus="select(this)" />
                <label for="upper_bound"><?=lang_text('{cost_to}')?></label>
                <input name="price[max]" id="upper_bound" class="upper_bound" value="<?=(isset($get_price['max']))?$get_price['max']:""?>" title="<?=lang_text('{cost_text_max}')?>" onfocus="select(this)" />
                <button class="sh-button cat-but"><?=lang_text('{button_ok}')?></button>
                <button type="button" id="price_reset" class="sh-button cat-but"><?=lang_text('{button_cancel}')?></button>
                <div class="price-range"></div>
            </form>
        </div>
        <?	if(!empty($auth_class->cur_user_login) && ($auth_class->cur_user_group==5 && $auth_class->cur_user_status_in_group==1)) { ?>
            <div class="offer-scroller">
                <div class="wrapper-drop cat-offer">
                    <h2 class="sub_title"><?=lang_text('{offer}')?></h2><div class="hb-but"></div>
                </div>
                <?
                $class_price = "offer-form";
                if (isset($get_price_offert)){
                    $class_price = "offer-form-visible";
                }
                ?>
                <form class="<?=$class_price?>" id="offer-form" action="<?=$search_form_action?>" method="get">
                    <label for="lower_bound"><?=lang_text('{cost_from}')?></label>
                    <input name="price_offer[min]" id="lower_bound_offer" class="lower_bound_offer" value="<?=(isset($get_price_offert['min']))?$get_price_offert['min']:""?>" title="<?=lang_text('{cost_text_min}')?>" onfocus="select(this)" />
                    <label for="upper_bound"><?=lang_text('{cost_to}')?></label>
                    <input name="price_offer[max]" id="upper_bound_offer" class="upper_bound_offer" value="<?=(isset($get_price_offert['max']))?$get_price_offert['max']:""?>" title="<?=lang_text('{cost_text_max}')?>" onfocus="select(this)" />
                    <button class="sh-button cat-but"><?=lang_text('{button_ok}')?></button>
                    <button type="button" id="offer_reset" class="sh-button cat-but"><?=lang_text('{button_cancel}')?></button>
                    <div class="price-range-offer"></div>
                </form>
            </div>
        <? 	} ?>
        <!--    <div class="popular">-->
        <!--        <div class="wrapper-drop cat-popular">-->
        <!--            <h2 class="sub_title">--><?//=lang_text('{cloud_top}')?><!--</h2><div class="hb-but"></div>-->
        <!--        </div>-->
        <!--        <ul class="popmenu">-->
        <!--            <li><a href="javascript:void(0)">Промышленные товары</a></li>-->
        <!--            <li><a href="javascript:void(0)">Услуги</a></li>-->
        <!--            <li><a href="javascript:void(0)">Оптовые товары</a></li>-->
        <!--            <li><a href="javascript:void(0)">Товары со скидками</a></li>-->
        <!--            <li><a href="javascript:void(0)">Все товары</a></li>-->
        <!--            <li><a href="javascript:void(0)">Услуги</a></li>-->
        <!--            <li><a href="javascript:void(0)">Детские товары</a></li>-->
        <!--            <li><a href="javascript:void(0)">Куртки</a></li>-->
        <!--            <li><a href="javascript:void(0)">Носки</a></li>-->
        <!--            <li><a href="javascript:void(0)">Акссесуары</a></li>-->
        <!--            <li><a href="javascript:void(0)">ipad</a></li>-->
        <!--            <li><a href="javascript:void(0)">Комплектующие компьютеры</a></li>-->
        <!--        </ul>-->
        <!--    </div>-->
    </div>
    <div class="rightwrapper">
        <? require_once($_SERVER['DOCUMENT_ROOT']."/modules/$_cur_area/{$_cur_area}_v.right_part.php"); ?>
    </div>
</div>
<br style="clear: both">