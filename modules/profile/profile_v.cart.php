<?php
/**
 * profile_v.cart.php
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

<div class='prof-cart-wrap'>
    <?
    //    ash_debug($_POST);
    //    ash_debug($cart_products);

    $isset_cart = 'none';
    $empty_cart = 'block';
    if($cart_has_products) {
        $isset_cart = 'table';
        $empty_cart = 'none';
    }
    ?>
    <form action="" method="post">
        <div class='prod-in-cart cart-wrapper' style='display:<?=$empty_cart?>;'><?=lang_text("{IE_2x108}")?></div>
        <div class='cart-wrapper' style='display:<?=$isset_cart?>;width: 100%'>
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
                    $total_cost = $total_cost+$cart_value['product_total'];
                    ?>
                    <div class='prod-in-cart table_row' data-product-article='<?=$cart_value['product_article']?>'>
                        <div class='table_cell first'>
                            <input type="hidden" name="cart_data[<?=$cart_key?>][cart_id]" value="<?=$cart_key?>"/>

                            <div class="table">
                                <div class="table_row">
                                    <div class="table_cell">
                                        <img height="88" class='prod-img' src='<?=global_v::check_img($cart_value['product_img'])?>'>
                                    </div>
                                    <div class="table_cell" style="border: none;text-align: left">
                                        <span class='prod-fullprice'><?=$cart_value['product_title']?> <small>(<?=$cart_value['product_article']?>)</small></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="table_cell">
                            <span class='prod-fullprice'><span class="price_one"><?=$cart_value['product_price']?></span> &#8372;</span>
                        </div>
                        <div class="table_cell">
                            <div class='prod-fullqty'>
                                <input type='text' name="cart_data[<?=$cart_key?>][cart_count]" class='numbertype' value='<?=$cart_value['product_count']?>'>
                                <span class='plus'></span>
                                <span class='minus'></span>
                            </div>
                        </div>
                        <div class='table_cell'>
                            <span class='prod-fulltotal'><span class="price_all"><?=$cart_value['product_total']?></span> &#8372;</span>
                            <div class='prod-delete'>
                                <a data-cart_id='<?=$cart_key?>' class='prod-delete-button' href='#' title='<?=lang_text("{delete_from_cart}")?>'>
                                    <img src='/assets/images/profile/del-but.png' />
                                </a>
                            </div>
                        </div>

                    </div>
                <?

                }
                ?>
            </div>

            <div class='prod-under-cart' style='display:table;margin-top: 10px;width: 100%'>
                <div style="float: right;width: auto" class='prod-fullprice total_cost'>
                    <?=lang_text('{cart_total_cost}')?>: <span class="price_total"><?=$total_cost?></span> &#8372;
                </div>
                <button style="float: left" name='order' class='button order'><?=lang_text('{cart_prod_confirm}')?></button>
            </div>
            <?
            } else {
                echo "</div>";
            }
            ?>
        </div>
    </form>
</div>
