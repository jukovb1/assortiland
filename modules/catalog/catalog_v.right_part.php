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
// todo ash-0 в языковой файл ->
?>
<div class="top-cat">
    <h1 class="sub_title"><?=(!$seller_marketplace)?(!$partner_marketplace)?lang_text('{catalog}'):lang_text('{catalog_partner}'):lang_text('{catalog_seller}')?></h1>
    <?
    if (isset($resort_array) && count($resort_array)>0){
        ?>
        <div class="drop-down">
            <form action="" method="post" name="form_resort" id="form_resort">
                <?=lang_text('{sort}')?>
                <select class="cd-dropdown cd-select" name="select_resort" onchange="$(this).parent('form').submit()">
                    <?
                    foreach($resort_array as $action=>$resort_name){
                        $selected = NULL;
                        if (isset($_POST['select_resort']) && $_POST['select_resort'] == $action){
                            $selected = "selected='selected'";
                        }
                        echo "<option $selected value='$action'>$resort_name</option>";
                    }
                    ?>
                </select>
            </form>
        </div>
    <?
    }
    ?>
</div>
<div class="breadcrumbs">
    <a href="/"><?=lang_text('{main_menu}')?></a> /

    <?
    $catalog_txt = lang_text('{catalog_menu}');
    if (!is_null($seller_id)){
        $catalog_txt = lang_text('{catalog_menu_user}::{:USER_NAME:}='.$seller_name);
    }elseif (!is_null($partner_id)){
        $catalog_txt = lang_text('{catalog_menu_user}::{:USER_NAME:}='.$partner_name);
    }
    if (is_null($_cur_area_sub)){
        echo $catalog_txt;
    } else {
        echo " <a href='/$_cur_area/$link_marketplace'>$catalog_txt</a> /";
        $breadcrumbs =  breadcrumbs_create($category_array,$cat_data['group_parent_group']);
        echo (!is_null($breadcrumbs))?implode(' ',$breadcrumbs):NULL;
        echo " {$cat_data['group_full_name']}";
    }
    ?>
</div>
<div class="sub-cat">
    <?
    // todo mal-1 ash-1 Кир, нужно отверстать блоки дочерних категорий
    if (isset($cat_data) && isset($category_array[$cat_data['group_id']])){
        echo "<ul>";
        foreach($category_array[$cat_data['group_id']] as $data){
            echo "<li>";
            echo "<a href='/{$_cur_area}/{$data['group_short_name']}/$link_marketplace'>{$data['group_full_name']}</a> ";
            $group_products_ids = catalog_m::count_product_by_all_child_group($data['group_id'],true,$seller_id,$partner_id);
            $count_product = count($group_products_ids);
            echo "<span class=''>({$count_product})</span>";
            echo "</li>";

        }
        echo "<ul>";
    }
    ?>
</div>
<div class="breadcrumbs" style="text-align: right">
    <?
    if (isset($products_by_search)){
        echo lang_text("{page_nav_search_info}::{:SEARCH_WORD:}=<b>&laquo;$search_word&raquo;</b>::{:COUNT_SEARCHED:}=".count($products_by_search));
    } elseif (isset($products_by_price)){
        echo lang_text("{page_nav_price_info}::{:SEARCH_WORD:}=<b>&laquo;$search_word&raquo;</b>::{:COUNT_SEARCHED:}=".count($products_by_price));
    } else {
        echo $page_nav['nav_info'];
    }
    ?>
</div>

<ul class="tab-positions">
    <?
    if (isset($products_list)){
        foreach($products_list as $product_id=>$product_data){
            $link_for_del_from_partner_cat = '';
            if (isset($partners_products[$product_id])){
                $link_for_del_from_partner_cat = "<div data-product_article='{$product_data['product_article']}' title='".lang_text("{del_from_partner_cat}")."' class='del_from_partner_cat'>X</div>";
            }
            ?>
            <li class="product_<?=$product_data['product_article']?>">
                <div class="tab-pos">
                    <?
                    if(!empty($auth_class->cur_user_login) && ($auth_class->cur_user_group==5 && $auth_class->cur_user_status_in_group==1)) {
                        echo $link_for_del_from_partner_cat;
                        ?>
                        <div class="offer"><p><?=$product_data['dop_field_11']/2?>%</p></div>
                    <?
                    }
                    $add_mp_to_link = '';
                    if (isset($friendly_url->url_command['marketplace_p'])){
                        $add_mp_to_link = '/marketplace_p='.$friendly_url->url_command['marketplace_p'];
                    }
                    ?>
                    <a href="/product/<?=$product_data['product_article'].$add_mp_to_link?>">
                        <div class="tab-img">
                            <img src="<?=global_v::check_img($product_data['dop_field_9'])?>" />
                        </div>
                    </a>
                    <div class="icon-wrapper">
                        <h2><a href="/product/<?=$product_data['product_article'].$add_mp_to_link?>"><?=$product_data['dop_field_2']?> <small>(<?=$product_data['product_article']?>)</small></a></h2>
                        <div class="look">
                            <a href="javascript:void(0)" class="look-img"></a> <?=isset($product_data['dop_field_6'])?$product_data['dop_field_6']:0?>
                        </div>
                        <div class="like">
                            <a data-article="<?=$product_data['product_article']?>" href="javascript:void(0)" class="like-img"></a> <span><?=isset($product_data['dop_field_7'])?$product_data['dop_field_7']:0?></span>
                        </div>
                        <div class="talk">
                            <a href="javascript:void(0)" class="talk-img"></a> 0
                        </div>
                    </div>
                </div>
            </li>
        <?
        }
    } else {
        ?>
        <li><h2><?=lang_text('{no_products_in_group}')?></h2></li>
    <?
    }
    ?>
</ul>




<div class="cat-pag">
    <?=$page_nav['nav_menu'];?>
</div>
