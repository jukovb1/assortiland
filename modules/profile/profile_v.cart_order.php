<?php
/**
 * profile_v.cart_order.php
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
<h2><?=lang_text('{order_title}')?></h2>


<div class='prof-cart-wrap' id="order_cart">
    <form action="" method="post">
        <h3><?=lang_text('{order_subtitle_info}')?></h3>
        <br>
        <br>
        <?=print_fields_set_by_user_group($fields_set,$fields_validation,$friendly_url->url_user_data,$fields_options,0,false); ?>
        <h3><?=lang_text('{order_subtitle_cart}')?></h3>
        <br>
        <br>
        <div class='cart-wrapper' style='width: 100%'>
            <div class='table' style='width: 100%'>
                <div class='prod-top-cart table_row'>
                    <div class='table_cell'><?=lang_text('{cart_prod_name}')?></div>
                    <div class='table_cell'><?=lang_text('{cart_prod_price}')?></div>
                    <div class='table_cell'><?=lang_text('{cart_prod_qty}')?></div>
                    <div class='table_cell'><?=lang_text('{cart_prod_total}')?></div>
                </div>
                <?

                if($cart_has_products) {
                $total_cost = 0;
                foreach ($cart_products as $cart_key => $cart_value) {
                    if (isset($cart_value['product_delivery'])
                        && is_array($cart_value['product_delivery'])
                        && count($cart_value['product_delivery'])>0){

                        $total_cost = $total_cost+$cart_value['product_total'];
                        ?>
                        <div class='prod-in-cart table_row' data-product-article='<?=$cart_value['product_article']?>'>
                            <div class='table_cell first no_border'>
                                <input type="hidden" name="cart_data[<?=$cart_key?>][cart_id]" value="<?=$cart_key?>"/>
                                <span class='prod-fullprice'><?=$cart_value['product_title']?> <small>(<?=$cart_value['product_article']?>)</small></span>
                                <br><br>
								<?
                                echo "<div class='prod-in-cart-delivery-wrapper'>";
									echo "".lang_text("{order_regions}").": ";
									echo get_regions_list($user_delivery_regions, $cur_user_delivery_region, $cart_key);
									echo "<br>";
	                                echo "".lang_text("{order_delivery}").": ";
	                                echo "<select data-key='$cart_key' name='delivery[$cart_key]'>";
	                                foreach ($cart_value['product_delivery'] as $delivery_id => $delivery_data) {
	                                    $data_l = (!empty($cart_value['product_delivery_long'][$delivery_id]))?$cart_value['product_delivery_long'][$delivery_id]:lang_text("{order_delivery_dop_info_title}");
	                                    echo "<option data-delivery_id='$delivery_id' value='$delivery_data' data-delivery_label='{$data_l}'>$delivery_data</option>";
	                                }
	                                echo "</select>";
								echo "</div>";
                                ?>
                                <br style="clear: both">
                            </div>
                            <div class="table_cell no_border">
                                <span class='prod-fullprice'><span class="price_one"><?=$cart_value['product_price']?></span> &#8372;</span>
                            </div>
                            <div class="table_cell no_border">
                                <div class='prod-fullqty'>
                                    <input type='text' name="cart_data[<?=$cart_key?>][cart_count]" class='numbertype' value='<?=$cart_value['product_count']?>'>
                                    <span class='plus'></span>
                                    <span class='minus'></span>
                                </div>
                            </div>
                            <div class='table_cell no_border'>
                                <span class='prod-fulltotal'><span class="price_all"><?=$cart_value['product_total']?></span> &#8372;</span>
                                <div class='prod-delete'>
                                    <a data-cart_id='<?=$cart_key?>' class='prod-delete-button' href='#' title='<?=lang_text("{delete_from_cart}")?>'>
                                    <img src='/assets/images/profile/del-but.png' />
                                    </a>
                                </div>
                            </div>

                        </div>
                        <div class='prod-in-cart table_row' data-product-article='<?=$cart_value['product_article']?>'>
                            <div class='table_cell first colspan_cell'>
                                <label id="label_delivery_info_<?=$cart_key?>" class="drv-lines-label" for="delivery_dop_info_<?=$cart_key?>">
                                    <?=lang_text("{order_delivery_dop_info_title}");?>
                                </label>
                                <textarea required="required" id="delivery_dop_info_<?=$cart_key?>" style="position: relative" name="delivery_info[<?=$cart_key?>]" class="linesreg-textarea"></textarea>
                                <div class="show_required_text" style="display: none;"><?=lang_text('{required_text}')?></div>
                            </div>
                            <div class='table_cell'></div>
                            <div class='table_cell'></div>
                            <div class='table_cell'></div>

                        </div>
					<?
						if(isset($cart_value['product_owner_data']['result_data'])) {
							$owner_fio = $cart_value['product_owner_data']['result_data']['user_fullname'];
							$owner_address = '';
							if(isset($cart_value['product_owner_data']['result_data']['full_data'])
								&& strlen($cart_value['product_owner_data']['result_data']['full_data']['user_address'])>0) {
								$owner_address = " | ".$cart_value['product_owner_data']['result_data']['full_data']['user_address'];
							}
							echo "<div class='prod-in-cart table_row' data-product-article='{$cart_value['product_article']}'>";
							echo "<div class='prod-in-cart-owner-wrapper'>";
							echo "".lang_text("{order_owner_data}").": ";
							echo "<strong>{$owner_fio}{$owner_address}</strong>";
							echo "</div>";
							echo "</div>";
							echo "<div class='table_cell'></div>";
                            echo "<div class='table_cell'></div>";
                            echo "<div class='table_cell'></div>";
						}
					?>
                    <?
                    } else {
                        ?>
                        <div class='prod-in-cart table_row' data-product-article='<?=$cart_value['product_article']?>'>

                            <div class="table_cell first colspan_cell">
                                <?=lang_text("{order_delivery_error}::{:PRODUCT_NAME:}=<span class='prod-fullprice'>{$cart_value['product_title']} <small>({$cart_value['product_article']})</small></span> ");?>
                            </div>
                            <div class="table_cell"></div>
                            <div class="table_cell"></div>
                            <div class="table_cell"></div>
                        </div>
                    <?
                    }
                }
                ?>
            </div>

            <div class='prod-under-cart' style='display:table;margin-top: 10px;width: 100%'>
                <div style="float: right;width: auto" class='prod-fullprice total_cost'>
                    <?=lang_text('{cart_total_cost}')?>: <span class="price_total"><?=$total_cost?></span> &#8372;
                </div>
                <button style="float: left;" name='order_finish' class='button order'><?=lang_text('{cart_prod_send}')?></button>
                <button style="float: left; margin-left:5px;" data-href="<?=$_SERVER['REQUEST_URI']?>" type="button" class='button order button_link'><?=lang_text('{cart_back}')?></button>
            </div>
            <?
            } else {
                echo "</div>";
            }
            ?>
        </div>
    </form>
</div>
