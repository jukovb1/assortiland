<?php
/**
 * global_с.functions.php
 *
 * Ф-ции контроллера представления (общий)
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
 * file_exists_if_isset($path, $report = false)
 * @description Проверка файла на существование
 *
 * @var $path string строка
 * @var $report boolean изначальные данные для отчета
 * @return boolean
 * Возвращает сообщение об ошибке или подключает файл
 */

function file_exists_if_isset($path, $report = false) {
    if (file_exists($path)){
		require_once($path);
	} elseif($report) {
    	echo "<p>Файл {$path} не найден.</p>";
		return false;
    } else {
    	return false;
    }
}

/**
 * get_quote_slider_data()
 * @description Получаем слайды с цитатами
 *
 * @return array
 * Возвращает массив с цитатами
 */
function get_quote_slider_data() {
	$page_sliders = array();
	
	// получаем список слайдов
	$quote_slides = global_m::get_constants_data(10);
	if(!empty($quote_slides['site_quotes'])) {
		// получаем перечень слайдов
		$slides = explode(';', $quote_slides['site_quotes']);
	
		foreach ($slides as $slide) {
			$slide_content = explode('|', $slide);
			if(strlen($slide_content[0])>0) {
				$page_sliders[trim($slide_content[0])]=$slide_content[1];
			}
		}
	}
	return $page_sliders;
}