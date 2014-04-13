<?php
/**
 * main_menu_v.php (admin)
 *
 * Прелставление главного меню админки
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

echo "<ul class='drv-main-menu'>\n";
?>
    <li>
        <a class="drv-menu-item" href="?logout">
            <div class="drv-menu-image"><img src="/assets/images/admin/icon-logout.png" /></div>
            <div class="drv-menu-text"><?=lang_text('{auth_logout}')?></div>
        </a>
    </li>
<?
foreach ($main_menu as $item_link=>$item_array){
    $lang_to_link = $friendly_url->lang_to_link;
    if (strpos($_SERVER['REQUEST_URI'],$item_link)!==false) {
        $active = "drv-menu-current";
    } else {
        if (($_SERVER['REQUEST_URI']==$path_index
            || $_SERVER['REQUEST_URI']==$path_index.$adm_folder.$lang_to_link."/")
            && $item_link=='dashboard'){
            $active="drv-menu-current";
        } else {
            $active="drv-menu-item";
        }
    }
    $li_class = (isset($item_array['sub_menu']))?' class="button"':NULL;

    ?>
    <li<?=$li_class?>>
        <a href="/<?=$adm_folder.$lang_to_link.'/'.$item_link?>/" class="<?=$active?>">
            <div class="drv-menu-image"><img src="/assets/images/admin/icon-<?=$item_link?>.png" /></div>
            <div class="drv-menu-text"><?=lang_text('{'.$item_link.'}')?></div>
        </a>
    </li>
    <?
    if ((isset($item_array['sub_menu']))){
        echo "<li class='drv-menu-dropdown'>";
        echo "<ul class='drv-sub-menu'>";
        foreach($item_array['sub_menu'] as $s_item_link=>$s_item_array){
            if (isset($s_item_array['s_item_name'])){
                $s_item_name = $s_item_array['s_item_name'];
            } else{
                $s_item_name = lang_text('{'.$s_item_link.'}');
            }
            if ($s_item_link=='order_input'){
            ?>
                <li>
                    <a href="#" onclick="return false;">
                        <form method="post" class="search_order_form" action="/<?=$adm_folder.$lang_to_link.'/'.$item_link?>/">
                            <?=$s_item_name?>:
                            <br>
                            <input style="float: left;width: 145px" type="text" class="search_order">
                            <input style="float: left" type="button" value="Go" class="search_order_go">
                            <br style="clear: both">
                        </form>
                    </a>
                </li>
            <?
            } else {
            ?>
                <li><a href="/<?=$adm_folder.$lang_to_link.'/'.$item_link.'/'.$s_item_link?>/"><?=$s_item_name?></a></li>
            <?
            }
        }
        echo "</ul>";
        echo "</li>";
    }
    ?>

<?
}
echo "    </ul>\n";

