<?php
/**
 * global_v.class.php
 *
 * Основной класс представления (общий)
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
class global_v
{
    /**
     * print_global_js_in_header($section)
     * @type static public
     * @description Получение списка автоматического подключения файлов js для сайта
     *
     * @param $division string (только для админки указать "admin")
     * @return string
     * Возвращает строку содержащую список тегов <script>
     */
    static public function print_global_js_in_header($division='site') {
        $path_global_js = ($division=='admin')?'/assets/js/admin/.global/':'/assets/js/.global/';
        if (!is_dir($_SERVER['DOCUMENT_ROOT'].$path_global_js)) {
            return NULL;
        } else {
            $files = scandir($_SERVER['DOCUMENT_ROOT'].$path_global_js);
            $return_js_string = "\n    <!-- Global scripts -->\n";
            if (empty($files)) {$return_js_string = "    <!-- No global scripts -->\n";}
            foreach ($files as $file) {
                $file_info = pathinfo($file);

                if($file_info['extension'] == 'js'){
                    $return_js_string .= "    <script type='text/javascript' src='$path_global_js{$file}'></script>\r\n";
                }
            }
            return $return_js_string;
        }
    }


    /**
     * print_local_js_in_header()
     * @type static public
     * @description Получение списка подключения локальных файлов js для сайта
     *
     * @param $js_names_arr array (массив имён JS модулей)
     * @return string
     * Возвращает строку содержащую список тегов <script> для текущего раздела
     */
    static public function print_local_js_in_header($js_names_arr) {
        $path_js = '/assets/js/';
        if (!is_array($js_names_arr)) {
            return NULL;
        }else {
            $return_js_string = "\n    <!-- Local scripts -->\n";
            if (empty($js_names_arr)) {$return_js_string .= "    <!-- No local scripts -->\n";}
            foreach ($js_names_arr as $js_folder_key=>$js_folder_val) {
                $js_folder_name = $js_folder_val;
                $selectively_connection = false;
                if (is_array($js_folder_val)) {
                    $js_folder_name = $js_folder_key;
                    $selectively_connection = true;
                    $js_folder_val = array_flip($js_folder_val);
                }
                $return_js_array[$js_folder_name] = "";
                if (is_dir($_SERVER['DOCUMENT_ROOT'].$path_js.$js_folder_name.'/')) {
                    $files = scandir($_SERVER['DOCUMENT_ROOT'].$path_js.$js_folder_name.'/');
                    foreach ($files as $npp=> $file) {
                        $file_info = pathinfo($file);
                        if (isset($file_info['extension']) && $file_info['extension'] == 'js'){
                            if ($selectively_connection) {
                                $parse_file_name = self::parse_js_filename($file_info['filename']);
                                if (is_array($parse_file_name)){
                                    $file_index = $parse_file_name['script_name'];
                                    if (isset($js_folder_val[$file_index])){
                                        unset($js_folder_val[$file_index]);
                                        $return_js_array[$js_folder_name] .= "    <script type='text/javascript' src='{$path_js}$js_folder_name/{$file}'></script>\r\n";
                                    }
                                } else {
                                    $return_js_array[$js_folder_name] .= "    <!-- $parse_file_name -->\r\n";

                                }
                            } else {
                                $return_js_array[$js_folder_name] .= "    <script type='text/javascript' src='{$path_js}$js_folder_name/{$file}'></script>\r\n";
                            }
                        }

                    }

                    if ($selectively_connection && !empty($js_folder_val)) {
                        foreach($js_folder_val as $key=>$va) {
                            $return_js_array[$js_folder_name] .= "    <!-- Folder JS module \"$js_folder_name\" contains no js files with index '$key' -->\r\n";
                        }
                    }

                    if (empty($return_js_array[$js_folder_name])) {
                        $return_js_string .= "    <!-- Folder JS module \"$js_folder_name\" contains no js files -->\r\n";
                    } else {
                        $return_js_string .= $return_js_array[$js_folder_name];
                    }
                } else {
                    $return_js_string .= "    <!-- JS module '$js_folder_name' is not found -->\r\n";
                }
            }
            return $return_js_string;
        }
    }

    /**
     * print_lang_text_from_files($section)
     * @type static public
     * @description Получение разноязычных текстов
     * Поиск проходит в папке соответствующего раздела, затем
     * в папке глобал, если ничего не находит, исчет значение для
     * языка по-умолчанию по той-же логике
     *
     * @param $section string  (название модуля)
     * @param $division string (только для админки указать "admin")
     * @return string
     * Возвращает текст для нужного языка
     */
    static public function print_lang_text_from_files($section,$division='site') {
        global $langs_data,$friendly_url;
        $current_lang = $friendly_url->url_lang['abbr'];
        $default_lang = $langs_data['default_lang']['lang_abbr'];

        $final_text_arr = $cur_lang_section_text_arr = $cur_lang_def_text_arr = $def_lang_section_text_arr = $def_lang_def_text_arr = array();

        $path_langs = ($division=='admin')?'/assets/langs/admin/':'/assets/langs/';
        $global_folder = '.global';

        // получаем массив текстов для модуля и дополняем его глобальными текстами (для выбранного языка)
        if (is_dir($_SERVER['DOCUMENT_ROOT'].$path_langs.$current_lang."/")) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'].$path_langs.$current_lang."/$section.json")){
                $cur_lang_section_text_object = file_get_contents($_SERVER['DOCUMENT_ROOT'].$path_langs.$current_lang."/$section.json");
                $cur_lang_section_text_object = preg_replace('#//.*#','',$cur_lang_section_text_object);
                $cur_lang_section_text_arr = json_decode($cur_lang_section_text_object);
            }
            if (file_exists($_SERVER['DOCUMENT_ROOT'].$path_langs.$current_lang."/.global.json")){
                $cur_lang_def_text_object = file_get_contents($_SERVER['DOCUMENT_ROOT'].$path_langs.$current_lang."/.global.json");
                $cur_lang_def_text_object = preg_replace('#//.*#','',$cur_lang_def_text_object);
                $cur_lang_def_text_arr = json_decode($cur_lang_def_text_object);
            }
        }
        // если выбран язык, отличный от языка по-умолчанию
        if ($default_lang != $current_lang){
            // получаем массив текстов для модуля и дополняем его глобальными текстами (для языка по-умолчанию)
            if (is_dir($_SERVER['DOCUMENT_ROOT'].$path_langs.$default_lang."/")) {
                if (file_exists($_SERVER['DOCUMENT_ROOT'].$path_langs.$default_lang."/$section.json")){
                    $def_lang_section_text_object = file_get_contents($_SERVER['DOCUMENT_ROOT'].$path_langs.$default_lang."/$section.json");
                    $def_lang_section_text_object = preg_replace('#//.*#','',$def_lang_section_text_object);
                    $def_lang_section_text_arr = json_decode($def_lang_section_text_object);
                }
                if (file_exists($_SERVER['DOCUMENT_ROOT'].$path_langs.$default_lang."/.global.json")){
                    $def_lang_def_text_object = file_get_contents($_SERVER['DOCUMENT_ROOT'].$path_langs.$default_lang."/.global.json");
                    $def_lang_def_text_object = preg_replace('#//.*#','',$def_lang_def_text_object);
                    $def_lang_def_text_arr = json_decode($def_lang_def_text_object);
                }
            }
        }
        // сводим все четыре массива
        foreach ($cur_lang_section_text_arr as $key_name=>$value) {
            $final_text_arr[$key_name] = $value;
        }
        foreach ($cur_lang_def_text_arr as $key_name2=>$value2) {
            if (!isset($final_text_arr[$key_name2])){
                $final_text_arr[$key_name2] = $value2;
            }
        }
        foreach ($def_lang_section_text_arr as $key_name3=>$value3) {
            if (!isset($final_text_arr[$key_name3])){
                $final_text_arr[$key_name3] = $value3;
            }
        }
        foreach ($def_lang_def_text_arr as $key_name4=>$value4) {
            if (!isset($final_text_arr[$key_name4])){
                $final_text_arr[$key_name4] = $value4;
            }
        }
        return $final_text_arr;
    }

    /**
     * check_img($path,$size=1)
     * @type static public
     * @description Проверка существования картинки, если нет, то выводим заглушку
     *
     * @param $path string  (путь до картинки)
     * @param $size number размер
     * @return string
     * Возвращает откорректированный путь
     */
    static public function check_img($path,$size=1) {
        $not_isset = false;
        if (strpos($path,'http://')!==false){
            $full_path =$path;
            $headers = get_headers($full_path);
            if (strpos($headers[0],'404')!==false){
                $not_isset = true;
            }
        } else {
            $full_path =$_SERVER['DOCUMENT_ROOT'].'/'.$path;
            if (!file_exists($full_path) || is_null($path) || empty($path)){
                $not_isset = true;
            }
        }

        if ($not_isset){
            $path_correct = "/assets/images/other/no_img.size_$size.png";
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$path_correct)){
                $path_correct = "/assets/images/other/no_img.size_1.png";
            }
        } else {
            $path_correct = $path;
        }
        return $path_correct;
    }


    /**
     * parse_js_filename($section)
     * @type static private
     * @description Парсер полного имени JS файла
     *
     * @param $filename string (имя файла)
     * @return array
     * Возвращает одномерный ассоциативный массив
     *
     */
    static private function parse_js_filename($filename) {
        $filename_pieces = explode('.',$filename);
        $return_arr = array();
        $num_pieces = count($filename_pieces);
        if ($num_pieces == 7) {
            $return_arr['npp']              = $filename_pieces[0];
            $return_arr['script_parent']    = $filename_pieces[1];
            $return_arr['script_name']      = $filename_pieces[2];
            $return_arr['version']['major'] = $filename_pieces[3]; // http://semver.org/
            $return_arr['version']['minor'] = $filename_pieces[4];
            $return_arr['version']['patch'] = $filename_pieces[5];
            $return_arr['compression']      = $filename_pieces[6];
        } elseif ($num_pieces == 6) {
            if (end($filename_pieces)!='min'){
                $return_arr['npp']              = $filename_pieces[0];
                $return_arr['script_parent']    = $filename_pieces[1];
                $return_arr['script_name']      = $filename_pieces[2];
                $return_arr['version']['major'] = $filename_pieces[3]; // http://semver.org/
                $return_arr['version']['minor'] = $filename_pieces[4];
                $return_arr['version']['patch'] = $filename_pieces[5];
                $return_arr['compression']      = '';
            } else {
                $return_arr['npp']              = '';
                $return_arr['script_parent']    = $filename_pieces[0];
                $return_arr['script_name']      = $filename_pieces[1];
                $return_arr['version']['major'] = $filename_pieces[2]; // http://semver.org/
                $return_arr['version']['minor'] = $filename_pieces[3];
                $return_arr['version']['patch'] = $filename_pieces[4];
                $return_arr['compression']      = $filename_pieces[5];
            }
        } elseif ($num_pieces == 5) {
            $return_arr['npp']              = '';
            $return_arr['script_parent']    = $filename_pieces[0];
            $return_arr['script_name']      = $filename_pieces[1];
            $return_arr['version']['major'] = $filename_pieces[2]; // http://semver.org/
            $return_arr['version']['minor'] = $filename_pieces[3];
            $return_arr['version']['patch'] = $filename_pieces[4];
            $return_arr['compression']      = '';
        } elseif ($num_pieces == 1) {
            $return_arr['npp']              = '';
            $return_arr['script_parent']    = '';
            $return_arr['script_name']      = $filename_pieces[0];
            $return_arr['version']['major'] = ''; // http://semver.org/
            $return_arr['version']['minor'] = '';
            $return_arr['version']['patch'] = '';
            $return_arr['compression']      = '';
        }

        if (count($return_arr)<1){
            $return = "File name '$filename.js' is not specified on a template";
        } else {
            $return = $return_arr;
        }
        return $return;
    }


    /**
     * send_msg_to_email($mail_to,$subject,$msg,$return_name='server'
     * @type static public
     * @description Отправка почтовых сообщений
     *
     * @param $mail_to string (адрес получателя)
     * @param $subject string (тема)
     * @param $msg string (текст сообщения)
     * @param $return_name string (имя отправителя,по-умолчанию SERVER)
     * @return array
     * Возвращает одномерный ассоциативный массив
     *
     */
    static public function send_msg_to_email($mail_to,$subject,$msg,$return_name='server'){
    	global $global_constants;
		
        $time = date("d.m.Y H:i:s");
        $return_mail = "$return_name@".$_SERVER['SERVER_NAME'];
        $headers  = "MIME-Version: 1.0\r\n";
        //$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $headers .= "From: $return_name <$return_mail>\n";
        $headers .= "X-Sender: <$return_mail>\n";
        $headers .= "X-Mailer: Robot\n";
        $headers .= "Return-Path: <$return_mail>\n";
        $headers .= "Content-Type: text/html; charset=utf-8\n";
		
		$sitename = get_constant($global_constants,'site_name');
		$link = "<a title='{$sitename}' href='http://{$_SERVER['SERVER_NAME']}'>{$sitename}</a>";
		$footer = lang_text("{email_msg_system_info_about}::{:SUPPORT_LINK:}={$link}");

        $html_msg = "
        <style type='text/css'>
            .msg_logo{width:300px; min-height:75px; display: inline-block;}
            .msg_logo img{border: none}
            .msg_table{width:100%; border:1px dashed #3b8ede;border-radius: 5px}
            .msg_table td{padding: 10px}
            .msg_line{border-top: 3px double #3b8ede;width: 100%;}
            .msg_title{color: #3b8ede;font-style: italic;font-weight: bold;text-align: right;}
            .msg_td_no_padding_vertical{text-align:center;padding-left: 10px;padding-right: 10px;}
            .msg_system_info,.msg_system_info_about{font-size:80%;color:grey;}
			.msg_system_info_about a,.msg_system_info_about a:active{color:#ff6418;}
			.msg_system_info_about a:hover{color:#e06425;}
            .msg_button{background: url('http://{$_SERVER['SERVER_NAME']}/assets/images/other/bg-price-but.png') repeat-x;display:inline-block;padding:5px;padding-left:20px;padding-right:20px;text-decoration:none;color: #fff;text-align: center;border: 1px solid #af6e13;font-size: 12px;}
        </style>
        <table class='msg_table'>
            <tr>
                <td><a target='_blank' class='msg_logo' href='http://{$_SERVER['SERVER_NAME']}/' title=''><img src='http://{$_SERVER['SERVER_NAME']}/assets/images/other/logo.png'/></a></td>
                <td style='text-align:right;'><small class='msg_system_info'>$time</small><br><h2 class='msg_title'>$subject</h2></td>
            </tr>
            <tr>
                <td colspan='2' class='msg_td_no_padding_vertical'><div class='msg_line'></div></td>
            </tr>
            <tr>
                <td colspan='2'>$msg</td>
            </tr>
            <tr>
                <td colspan='2' class='msg_td_no_padding_vertical'><div class='msg_line'></div></td>
            </tr>
            <tr>
                <td colspan='2' class='msg_td_no_padding_vertical'><small class='msg_system_info'>".lang_text("{email_msg_no_request}")."</small><br/><small class='msg_system_info_about'>{$footer}</small></td>
            </tr>
        </table>";

        mail($mail_to, $subject, $html_msg, $headers);
    }

    static public function create_button_for_email_msg($url,$anchor){
        return "<a class='msg_button' target='_blank' href='$url'>$anchor</a>";
    }
    static public function user_name_link_by_group_rules($user_id){
        global $friendly_url;
        $user_res = global_m::get_user_data_by_id($user_id);
        if (!$user_res['result']){
            return false;
        } else {
            $group_res = global_m::get_users_group_by_id($user_res['result_data']['user_default_group']);
            if (!$group_res['result']){
                $color = $pref = $suf = $title = "";
            } else {
                $gr_data = $group_res['result_data'];
                $color = "style='color: {$gr_data['us_group_color']};' ";
                $pref = $gr_data['us_group_prefix'];
                $suf = $gr_data['us_group_sufix'];
                $title = $gr_data['us_group_title'][$friendly_url->url_lang['id']];
            }
            $user_link = "<a title='{$title}' {$color} href='{$friendly_url->lang_to_link}/{$user_res['result_data']['user_login']}'>{$pref}{$user_res['result_data']['user_fullname']}{$suf}</a>";
            return $user_link;
        }
    }

    static public function date_to_format($date,$format="d.m.Y H:i"){
        if (gettype($date)=='string'){
            $date = strtotime($date);
        }
        return date($format,$date);
    }
}
