<?php
/**
 * profile_v.functions.php (front)
 *
 * Функции представления модуля пользователей
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
 * print_fields_set_by_user_group($fields_set,$fields_validation,$cont_data,$options,$group=NULL,$print_separator=NULL)
 * @description отрисовка списка полей для редактирования пользователя
 *
 * @param $fields_set array - набор полей
 * @param $fields_validation array - образец для проверки
 * @param $cont_data array - значения
 * @param $options array - опции для селектов
 * @param $group number - группа пользователей
 * @param $print_separator boolean - отрисовка разделителей
 * @return string
 * Возвращает строку с полями
 */
function print_fields_set_by_user_group($fields_set,$fields_validation,$cont_data,$options,$group=NULL,$print_separator=true){
    global $reg_form, $friendly_url;
    if (is_null($group)){
        $group = $cont_data['user_default_group'];
    }
    $result = "";
    foreach($fields_set as $field_name=>$na){		
        $cont_data[$field_name] = (isset($cont_data[$field_name]))?$cont_data[$field_name]:'';

        if (isset($fields_validation[$field_name]) && ($field_name!='user_login' || isset($reg_form))){
            $field_name_for_lang = "{edit_{$field_name}}";
            if ($group==4 && ($field_name=='user_address' || $field_name=='user_fullname' || $field_name=='user_company_desc')) {
                $field_name_for_lang = "{edit_{$field_name}_$group}";
            }
            $css_class = 'linesreg';
            $title = $dop_info = $title_inp = $star = $required_text = $required = '';
            if (($field_name=='user_pass' && isset($reg_form)) || (isset($fields_validation[$field_name]['required']) && $fields_validation[$field_name]['required'])){
                $title = " title='".lang_text("{required_text}")."'";
                $required_text = "<div class='show_required_text'>".lang_text("{required_text}")."</div>";
                $required = "required";
                $star = "<span style='color:#e65400'>*</span>";
            }
            if (isset($fields_validation[$field_name]['err'])){
                $title_inp = " title='".$fields_validation[$field_name]['err']."'";
                $dop_info = "(".$fields_validation[$field_name]['err'].")";
                $required_text .= "<div class='show_dop_text'>".$fields_validation[$field_name]['err']."</div>";
            }
            $label = "<label $title class='drv-lines-label' for='$field_name'> $star ".lang_text($field_name_for_lang)." <small>{$dop_info}</small></label>\r\n";

            $min = (isset($fields_validation[$field_name]['min']))?$fields_validation[$field_name]['min']:NULL;
            $max = (isset($fields_validation[$field_name]['max']))?$fields_validation[$field_name]['max']:NULL;
            $size = "{$min},{$max}";
            if ($min==$max){
                $size = "{$min}";
            }


            if ($fields_validation[$field_name]['type']==2){
                $pattern = (!is_null($min)||!is_null($max))?"pattern='[0-9]{{$size}}'":NULL;

                $result .= $label;
                $result .= "<input $title_inp id='$field_name' $required class='$css_class' name='$field_name' value='{$cont_data[$field_name]}' type='number' $pattern>\r\n $required_text ";

            } elseif ($fields_validation[$field_name]['type']==3){
                $pattern = (!is_null($min)||!is_null($max))?"pattern='[\s\d\w,.]{{$size}}'":NULL;
                if ($field_name!='user_pass' && $field_name!='captcha'){
                    $input_type = 'text';
                    if (isset($fields_validation[$field_name]['html5'])){
                        $input_type = $fields_validation[$field_name]['html5'];
                    }
                    $result .= $label;
                    $result .= "<input $title_inp id='$field_name' $required class='$css_class' name='$field_name' value='{$cont_data[$field_name]}' type='$input_type' $pattern>\r\n $required_text ";
                } elseif ($field_name!='captcha') {
                    // для пароля
                    if(isset($friendly_url->url_command['edit'])) {
                    	$field_name_for_lang = "{edit_new_pass}";
                    	$field_name = "new_pass";
					}
										
                    $result .= "<table class='table_edit_user'>
                <tr>
                <td>
                    <label $title class='drv-lines-label' for='$field_name'> $star ".lang_text("{$field_name_for_lang}")."</label>\r\n
                    <input $required $title_inp id='$field_name' autocomplete='off' class='linesreg-pass' name='$field_name' value='' type='password' $pattern>\r\n$required_text
                </td>
                <td style='padding-left: 15px'>
                    <label $title class='drv-lines-label' for='{$field_name}_confirm'> $star ".lang_text("{edit_{$field_name}_confirm}")."</label>\r\n
                    <input $required $title_inp id='{$field_name}_confirm' autocomplete='off' class='linesreg-pass' name='{$field_name}_confirm' value='' type='password' $pattern>\r\n$required_text
                </td>
                </tr>
            </table><br>";
                }


            } elseif ($fields_validation[$field_name]['type']==5){
                $css_class = 'wid100';
                if (isset($options[$field_name])){
                    $result .= $label;
                    $result .= "<select id='$field_name' class='$css_class' name='$field_name'>";
                    foreach ($options[$field_name] as $opt_id=>$option) {
                        $selected = "";
                        if ($opt_id==$cont_data[$field_name]){
                            $selected = "selected='selected'";
                        }
                        $result .= "<option $selected value='$opt_id'>{$option}</option>";
                    }
                    $result .= "</select>\r\n $required_text<br><br>";
                } elseif($field_name=='user_default_group') {

                } else {
                    $result .= err_field("Нет опций для построения списка \"$field_name\".");
                }

            } elseif ($fields_validation[$field_name]['type']==7){
            	$css_class = 'linesreg-textarea';
                $editor = '';
                if (isset($fields_validation[$field_name]['editor'])){
                    $editor = 'redactor';
                }
                $result .= $label;
                $result .= "<textarea id='$field_name' $required class='$css_class $editor' name='$field_name'>{$cont_data[$field_name]}</textarea>\r\n $required_text";

            } else {
                $result .= err_field("Не написан обработчик для типа \"{$fields_validation[$field_name]['type']}\" у поля $field_name");

            }

        } elseif (strpos($field_name,'separator')){
            $result .= ($print_separator)? "<br><div class='option_separator'></div><div class='option_separator_text'>".lang_text($na)."</div><br><br>":NULL;
        } elseif ($field_name=='full_data'){
            $result .= ($print_separator)?"<br><div class='option_separator'></div><div class='option_separator_text'>".lang_text("{edit_user_dop_data}")."</div><br><br>":NULL;
            $result .= print_fields_set_by_user_group($na,$fields_validation,isset($cont_data['full_data'])?$cont_data['full_data']:array(),$options,$group);

        } else {
            if ($field_name!=='user_login' && !isset($reg_form)){
                $result .= err_field("Нет поля \"$field_name\" в наборе данных \"\$fields_validation\"");
            }
        }


    }
    return $result;
}

/**
 * print_profile_data_by_user_group($fields_set,$cont_data,$options)
 * @description отрисовка списка полей для редактирования пользователя
 *
 * @param $fields_set array - набор полей
 * @param $fields_validation array - набор полей для валидации
 * @param $cont_data array - значения
 * @param $options array - набор опций
 * @return string
 * Возвращает строку с полями
 */
function print_profile_data_by_user_group($fields_set,$fields_validation,$cont_data,$options){
	$result = '';
	
	foreach($fields_set as $field_name=>$na){
		$field_name_for_lang = "{edit_{$field_name}}";		
		if(isset($fields_validation[$field_name]) && isset($cont_data[$field_name])
			&& ($fields_validation[$field_name]['type'] == 5 || $fields_validation[$field_name]['type'] == 6)) {
			$cont_data[$field_name] = (isset($options[$field_name][$cont_data[$field_name]]))?$options[$field_name][$cont_data[$field_name]]:'';
		}
		if(isset($cont_data[$field_name]) && !empty($cont_data[$field_name]) && $field_name !== 'full_data' && $field_name !== 'user_pass') {
			$lang_text = lang_text($field_name_for_lang);
			// убираем текст-подсказку в телефонах при просмотре профиля
			if($field_name == 'user_phone') {
				$lang_text = preg_replace("/<small>(.*?)<\/small>/", "", $lang_text);
			}
			
			$result .= "<div class='info-line'>".$lang_text."</div>
						<div class='info-answer'>".$cont_data[$field_name]."</div>";
			
		} elseif($field_name == 'full_data') {
            $result .= "<div class='option_separator'></div><div class='option_separator_text'>".lang_text("{edit_user_dop_data}")."</div><br><br>";
            $result .= print_profile_data_by_user_group($na, $fields_validation, (isset($cont_data['full_data'])?$cont_data['full_data']:array()), $options);
		}
	}
	
	return $result;
}

function err_field($str){
    return "<div style='margin:5px 0;padding:10px;color: red;background: #dddddd'>$str</div>";
}
