<?php
/**
 * page_navigation.class.php
 *
 * Класс постраничной навигации (общий)
 *
 * Данный файл НЕ является частью системы управления контентом
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
class page_navigation
{
    static $profiler_data;

    static public function get_page_by_num_for_adm($count_items,$items=NULL,$num_rows=false){
        $amp='?';
        $return = array();
        if (is_null($items)){
            $items = lang_text('{page_nav_default_items}');
        }
        $num_rows = ($num_rows)?$num_rows:15;
        $num_pages = ceil($count_items/$num_rows);
        if(isset($_GET['p'])){
            $num_page=(!empty($_GET['p']))?intval($_GET['p']):1;
            if ($num_page>$num_pages){
                $num_page = $num_pages;
            }
        } else {
            $num_page = 1;
        }

        $return['nav_num_page'] = $num_page;

        if(isset($_GET['show_all_items'])){
            $all = true;
            $return['nav_start_position'] = NULL;
            $return['nav_limit'] = NULL;
        } else {
            $all = false;
            $return['nav_start_position'] = $num_rows*($num_page-1);
            $return['nav_limit'] = $num_rows;
        }
        $page_has = ($num_page == $num_pages)?$count_items - ($num_pages-1)*$num_rows:$num_rows;

        $first_shown = $return['nav_start_position']+1;
        $last_shown = $return['nav_start_position']+$page_has;
        $shown = "$first_shown-$last_shown";
        if ($first_shown == $last_shown){
            $shown = $first_shown;
        }
        $return['nav_info'] = (!$all && $num_rows<$count_items)?"<span><b>$shown</b> ".lang_text('{page_nav_from}')." <b>$count_items</b> $items</span>":NULL;

        $url = $_SERVER['REQUEST_URI'];
        $url_array = parse_url($url);
        if (isset($url_array['query'])){
            $pattern = '/p=(\d+)/';
            $pattern2 = '/show_all_items/';

            $url_query = $url_array['query'];
            $url_query_arr = explode('&',$url_query);
            $new_query = array();
            $new_query_str = '';
            foreach($url_query_arr as $pat){
                if (!preg_match($pattern,$pat) && !preg_match($pattern2,$pat)){
                    $new_query[]=$pat;
                    $amp = '&';
                }
            }
            if (count($new_query)>0){
                $new_query_str = '?'.implode('&',$new_query);
            }
            $url = $url_array['path'].$new_query_str;
        } else {
            $url = str_replace('?','',$url);
        }

        $pr = $num_page-1;
        $nx = $num_page+1;

        $divs = $return['nav_info'];
        $divs .= ($num_page>1)?"<a class='drv-pag-prev' href='{$url}{$amp}p={$pr}' title='".lang_text('{page_nav_prev}')."'></a>\r\n":NULL;
        $divs .= ($num_page<$num_pages)?"<a class='drv-pag-next' href='{$url}{$amp}p={$nx}' title='".lang_text('{page_nav_next}')."'></a>\r\n":NULL;
        $divs .= ($num_pages>1)?"<a class='drv-pag-all' href='{$url}{$amp}show_all_items' title='".lang_text('{page_nav_show_all_text}')."'>".lang_text('{page_nav_show_all}')."</a>\r\n":NULL;
        $divs2=($all)?"<a class='drv-pag-all' href='{$url}' title='".lang_text('{page_nav_show_by_page_text}')."'>".lang_text('{page_nav_show_by_page}')."</a><br style='clear: both'>\r\n":NULL;
        $return['nav_menu'] = (!$all)?$divs:$divs2;
        return $return;
    }

    static public function get_page_by_num_for_front($count_items,$num_rows=false){
        $amp='?';
        $return = array();
        $num_rows = ($num_rows)?$num_rows:15;
        $num_pages = ceil($count_items/$num_rows);
        if(isset($_GET['p'])){
            $num_page=(!empty($_GET['p']))?intval($_GET['p']):1;
            if ($num_page>$num_pages){
                $num_page = $num_pages;
            }
        } else {
            $num_page = 1;
        }

        $return['nav_num_page'] = $num_page;

        if(isset($_GET['show_all_items'])){
            $all = true;
            $return['nav_start_position'] = NULL;
            $return['nav_limit'] = NULL;
        } else {
            $all = false;
            $return['nav_start_position'] = $num_rows*($num_page-1);
            $return['nav_limit'] = $num_rows;
        }
        $page_has = ($num_page == $num_pages)?$count_items - ($num_pages-1)*$num_rows:$num_rows;

        $dop_text = (!$all && $num_rows<$count_items)?lang_text("{page_nav_info_dop_text}::{:NUM_IN_PAGE:}=$page_has::{:CUR_PAGE:}=$num_page::{:TOTAL_PAGES:}=$num_pages"):".";
        $return['nav_info'] = ($count_items>0)?lang_text("{page_nav_info_text}::{:COUNT_TOTAL:}=$count_items")."{$dop_text}":NULL;

        $url = $_SERVER['REQUEST_URI'];
        $url_array = parse_url($url);
        if (isset($url_array['query'])){
            $pattern = '/p=(\d+)/';
            $pattern2 = '/show_all_items/';

            $url_query = $url_array['query'];
            $url_query_arr = explode('&',$url_query);
            $new_query = array();
            $new_query_str = '';
            foreach($url_query_arr as $pat){
                if (!preg_match($pattern,$pat) && !preg_match($pattern2,$pat)){
                    $new_query[]=$pat;
                    $amp = '&';
                }
            }
            if (count($new_query)>0){
                $new_query_str = '?'.implode('&',$new_query);
            }
            $url = $url_array['path'].$new_query_str;
        } else {
            $url = str_replace('?','',$url);
        }

        $pr = $num_page-1;
        $nx = $num_page+1;

        $divs = "<ul>\r\n";
        $divs .= ($num_page>1)?"<li><a href='{$url}{$amp}p=1' title='".lang_text('{page_nav_first}')."'>&laquo;</a></li>\r\n":NULL;
        $divs .= ($num_page>1)?"<li><a href='{$url}{$amp}p={$pr}' title='".lang_text("{page_nav_prev}::{:PREV:}=$pr")."'>&#8249;</a></li>\r\n":NULL;
        $divs .= ($num_page-2>=1)?"<li><a href='{$url}{$amp}p=".($num_page-2)."'>".($num_page-2)."</a></li>\r\n":NULL;
        $divs .= ($num_page-1>=1)?"<li><a href='{$url}{$amp}p=".($num_page-1)."'>".($num_page-1)."</a></li>\r\n":NULL;
        $divs .= ($num_pages>1)?"<li><a class='cur_page' href='#' onclick='return false'>$num_page</a></li>\r\n":NULL;
        $divs .= ($num_page+1<=$num_pages)?"<li><a href='{$url}{$amp}p=".($num_page+1)."'>".($num_page+1)."</a></li>\r\n":NULL;
        $divs .= ($num_page+2<=$num_pages)?"<li><a href='{$url}{$amp}p=".($num_page+2)."'>".($num_page+2)."</a></li>\r\n":NULL;
        $divs .= ($num_page<$num_pages)?"<li><a href='{$url}{$amp}p={$nx}' title='".lang_text("{page_nav_next}::{:NEXT:}=$nx")."'>&#8250;</a></li>\r\n":NULL;
        $divs .= ($num_page<$num_pages)?"<li><a href='{$url}{$amp}p=$num_pages' title='".lang_text("{page_nav_last}::{:LAST:}=$num_pages")."'>&raquo;</a>\r\n":NULL;
        $divs .= "</ul>\r\n";
        $divs .= ($num_pages>1)?"<div><li><a href='{$url}{$amp}show_all_items' title='".lang_text('{page_nav_show_all_text}')."'>".lang_text('{page_nav_show_all}')."</a></li></div>\r\n":NULL;
        $divs2=($all)?"<div style='float: right'><li><a href='{$url}' title='".lang_text('{page_nav_show_by_page_text}')."'>".lang_text('{page_nav_show_by_page}')."</a></li></div><br style='clear: both'>\r\n":NULL;
        $return['nav_menu'] = (!$all)?$divs:$divs2;
        return $return;
    }



}