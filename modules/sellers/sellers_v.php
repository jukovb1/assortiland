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

?>
<div class="center sellers-center">
	<div class="top-cat">
	    <h1 class="sub_title"><?=lang_text('{module_name}')?></h1>
	</div>
	<div class="breadcrumbs">
	    <a href="/"><?=lang_text('{main_menu}')?></a> /
	    <a href="/sellers"><?=lang_text('{module_name}')?></a>
	</div>
	<div class="sellers-wrapper">
		<div class="center">
			<div class='table' style='width: 100%'>
	            <div class='sellers-top table_row'>
	                <div class='table_cell' style='width: 40%'><?=lang_text('{sellers_fio}')?></div>
	                <div class='table_cell' style='width: 20%'><?=lang_text('{sellers_login}')?></div>
	                <div class='table_cell' style='width: 5%'><?=lang_text('{sellers_gender}')?></div>
	                <div class='table_cell' style='width: 26%'><?=lang_text('{sellers_email}')?></div>
	                <div class='table_cell' style='width: 9%'><?=lang_text('{sellers_count_products}')?></div>
	            </div>
<?
            if(!empty($sellers_list)) {
                foreach ($sellers_list as $seller_id => $seller_value) {
?>
                    <div class='sellers-in table_row' data-seller-article='<?=$seller_value['user_login']?>'>
                        <div class="table_cell" style='width: 40%'>
                            <a href="/catalog/marketplace=<?=$seller_value['user_login']?>" title="<?=$seller_value['user_fullname']?>"><span><?=$seller_value['user_fullname']?></span></a>
                        </div>
                        <div class="table_cell" style='width: 20%'>
                            <span><?=$seller_value['user_login']?></span>
                        </div>
                        <div class="table_cell" style='width: 5%'>
                            <span><?=$seller_value['user_gender']==1?lang_text('{sellers_gender_m}'):lang_text('{sellers_gender_f}')?></span>
                        </div>
                        <div class='table_cell' style='width: 26%'>
                            <span><?=$seller_value['user_email']?></span>
                        </div>
                        <div class='table_cell' style='width: 9%'>
                        	<span><?=$seller_value['products_count']?></span>
                        </div>
                    </div>
<?
                }
            }
?>
	        </div>
		</div>
	</div>
	<div class="sellers-pag cat-pag clearfix">
	    <?=$page_nav['nav_menu'];?>
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
	</div>
</div>