<?php
/**
 * global_v.functions.php
 *
 * Основные функции представления (общий)
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
/**
 * lang_text($text_index)
 * @description Получение текста для языка из массива по индексу
 *
 * @param $text_index string (индекс, для замены языковым текстом)
 * @return string
 * Возвращает строку содержащую текст на соответствующем языке
 * ИЛИ текстовый индекс, если для него нет соответствия
 */
function lang_text($text_index) {
    global $lang_text,$no_language_keys;
    $text_index_with_replace_array = explode("::",$text_index);
    $text_index = $text_index_with_replace_array[0];
    if (isset($lang_text[$text_index])){
        $lang_text_return[$text_index] = $lang_text[$text_index];
        if(count($text_index_with_replace_array)>1){
            foreach($text_index_with_replace_array as $k => $replace_arr){
                if($k>0){
                    $replace_arr = trim($replace_arr);
                    $t_rep = explode('=',$replace_arr);
                    $rep[0] = $t_rep[0];
                    unset($t_rep[0]);
                    $rep[1] = implode('=',$t_rep);
                    $lang_text_return[$text_index] = str_replace($rep[0],$rep[1],$lang_text_return[$text_index]);
                }
            }
        } else {
            $lang_text_return[$text_index] = $lang_text[$text_index];
        }
        return $lang_text_return[$text_index];
    } else {
        // определяем место вызова
        // файл, строка, имя переменной
        $called = debug_backtrace();
        $file = $called[0]['file'];
        $line = $called[0]['line'];

        $no_language_keys[$text_index] = "$file line:$line";

        return $text_index;
    }
}

/**
 * get_constant($constants_arr,$index,$hide_index)
 * @description Проверка и получение константы из списка
 *
 * @var $constants_arr array (массив)
 * @var $index string (индекс)
 * @var $hide_index (показывать индекс)
 * @return string
 * Возвращает строку содержащую текст константы
 * ИЛИ текстовый индекс, если не существует такой константы
 */
function get_constant($constants_arr,$index,$hide_index=NULL) {

    if (isset($constants_arr[$index])){
        return $constants_arr[$index];
    } else {
        if (is_null($hide_index)){
            return "{:$index:}";
        } else {
            return NULL;
        }
    }

}
/**
 * print_lang_flag($show_lang_tabs_for_mod,$data)
 * @description Отрисовка флага страны для нужного языка
 *
 * @var $constants_arr boolean
 * @var $data array (массив)
 * @return string
 * Возвращает строку картинку
 */
function print_lang_flag($show_lang_tabs_for_mod,$data) {
    $flag = NULL;
    if ($show_lang_tabs_for_mod){
        $flag = "<img src='/assets/images/admin/flags/blank.png' class='flag flag-{$data['lang_abbr']}' alt='[{$data['lang_abbr']}]' />";
    }
    return $flag;
}

/**
 * str_to_list($string,$class_for_ul=NULL,$delimiter=',')
 * @description Парсер строки по разделителю и представление в виде списка
 *
 * @var $string string строка
 * @var $class_for_ul string класс для тега ul
 * @var $delimiter string разделитель, по-умолчанию запятая
 * @return string
 * Возвращает строку картинку
 */

function str_to_list($string,$class_for_ul=NULL,$delimiter=',') {
    if (empty($string)){
        $result = NULL;
    } else {
        if (!is_null($class_for_ul)){
            $class_for_ul = " class='$class_for_ul'";
        }
        $dignities = explode($delimiter,$string);
        $result = "<ul{$class_for_ul}>\r\n";
        foreach($dignities as $dignity) {
            $result .= "<li>{$dignity}</li>\r\n";
        }
        $result .= "</ul>\r\n";
    }
    return $result;
}

function print_big_slider($array){
    $return = '';
    if(!empty($array)) {
        $slide_count = 1;
        $return .=  "<div class='slider'>";
        $return .=  "<div class='center'>";
        $return .=  "<div class='slider-wrapper'>";
        if (count($array)>1){
            $return .=  "<div class='slider-left-arrow'>Left</div>";
            $return .=  "<div class='slider-right-arrow'>Right</div>";
        }
        $return .=  "<div class='slider-right-back'>";
        $return .=  "<ul id='slider'>";
        foreach ($array as $slide) {
            $slide_count++;
            $return .=  "<li class='panel{$slide_count}'>";
            $return .=  "<div class='l-side'>";
            $return .=  "<div class='sub-title'>{$slide[1]}</div>";
            $return .=  "<div class='quotes'>{$slide[2]}</div>";
            $return .=  "<div class='s-descr'>{$slide[3]}</div>";
            $return .=  "<a class='slide-button' href='{$slide[5]}'>{$slide[4]}</a>";
            $return .=  "</div>";
            $return .=  "<img src='{$slide[6]}' alt='' width='500px' height='355px'>";
            $return .=  "</li>";
        }
        $return .= "</ul>";
        $return .= "</div>";
        $return .= "</div>";
        $return .= "</div>";
        $return .= "</div>";
    }
    return $return;
}

/**
 * get_regions_list($url)
 * @type static public
 * @description Получение данных регионов
 * @var $regions - перечень регионов
 *
 * @return array
 * Возвращает массив данных с нужными полями
 */
function get_regions_list($regions, $cur_user_delivery_region='',$cart_key=0) {
	$regions_list = '';
	if($cart_key<0) {
		$select_name="name='delivery_region' ";
	} else {$select_name="name='delivery_region[{$cart_key}]' ";}

	if(isset($regions) && !empty($regions)) {
		$regions_list = "<select {$select_name}class='regions-list'>";
		foreach ($regions as $region_name) {
			$region = trim($region_name);
			$selected = '';
			if($cur_user_delivery_region==$region_name)
				$selected = 'selected ';
			$regions_list .= "<option {$selected}name='{$region}'>{$region}</option>";
		}
		$regions_list .= "</select>";
		//$regions_list .= "<input type='hidden' name='delivery_region'>";
	}
	
	return $regions_list;
}

function tab($count){
    $normal=4;
    $out = "\n";
    for($i=1;$i<=$count*$normal;$i++)
    {
        $out .= " ";
    }
    return $out;
}