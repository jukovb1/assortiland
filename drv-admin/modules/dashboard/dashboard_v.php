<?php
/**
 * dashbord_v.php (admin)
 *
 * Представление главной страницы админки
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
<div class="drv-short-descr">
    <h3><?= lang_text("{dashboard_info_general}") ?></h3>
    <div class="drv-short-info">
        <h4 class="drv-info-header"><?= lang_text("{dashboard_info_content}") ?></h4>
        <div class="drv-fast-info"><a href="javascript:void(0)" title="<?= lang_text("{dashboard_info_pages}") ?>"><?=$count_pages?></a><span><?= lang_text("{dashboard_pages}") ?></span></div>
        <div class="drv-fast-info"><a href="javascript:void(0)" title="<?= lang_text("{dashboard_info_categories}") ?>"><?=$count_products_groups?></a><span><?= lang_text("{dashboard_categories}") ?></span></div>
    </div>
    <div class="drv-fast-common">
        <h4 class="drv-info-header"><?= lang_text("{dashboard_info_site}") ?></h4>
        <div class="drv-fast-info"><a href="javascript:void(0)" title="<?= lang_text("{dashboard_info_users}") ?>"><?=$count_users?></a><span class="drv-info-users"><?= lang_text("{dashboard_users}") ?></span></div>
        <div class="drv-fast-info"><a href="javascript:void(0)" title="<?= lang_text("{dashboard_info_partners}") ?>"><?=$count_partners?></a><span class="drv-info-partners"><?= lang_text("{dashboard_partners}") ?></span></div>
        <div class="drv-fast-info"><a href="javascript:void(0)" title="<?= lang_text("{dashboard_info_sellers}") ?>"><?=$count_sellers?></a><span class="drv-info-sellers"><?= lang_text("{dashboard_sellers}") ?></span></div>
        <div class="drv-fast-info"><a href="javascript:void(0)" title="<?= lang_text("{dashboard_info_products}") ?>"><?=$count_products?></a><span class="drv-info-products"><?= lang_text("{dashboard_products}") ?></span></div>
    </div>
</div>
