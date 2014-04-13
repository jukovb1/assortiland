<?php
/**
 * pages_c.functions.php (front)
 *
 * Ф-ции контроллера страниц
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
 * get_page_slider_data()
 * @description Получаем слайды для страницы
 *
 * @return array
 * Возвращает массив со слайдами
 */
function get_page_slider_data($page) {
    global $friendly_url;
	
	$page_sliders = $slides_by_alias = array();
	
	// получаем список слайдов
	$constants_slides = global_m::get_constants_data(8);
	if(!empty($constants_slides['site_slides'])) {
		// получаем перечень слайдов
		$slides = explode(';', $constants_slides['site_slides']);
	
		foreach ($slides as $slide) {
			$slide_content = explode('|', $slide);
			if(strlen($slide_content[0])>0) {
				$slides_by_alias[$slide_content[0]]=$slide_content;
			}
		}
	}

	// получаем список слайдеров
	$constants_sliders = global_m::get_constants_data(9);
	if(!empty($constants_sliders['site_sliders'])) {
		// получаем перечень слайдеров
		$sliders = explode(',', $constants_sliders['site_sliders']);
		
		
		foreach ($sliders as $slider) {
			$slider_content = explode('|', $slider);
			
			if($slider_content[0] == $page) {
			
				if(!empty($slider_content[1]) && strlen($slider_content[1])>0) {
					$slides_alias = explode(';', $slider_content[1]);
					
					// пробегаемся по всем слайдам и берем их из массива по alias
					// данные по слайду берем из $slides_alias
                    foreach ($slides_alias as $slide_alias) {
						$page_sliders[$slide_alias] = $slides_by_alias[$slide_alias];
					}
				}
			}
		}
	}

	return $page_sliders;
}
