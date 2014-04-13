<?php
/**
 * friendly_url.class.php
 *
 * Класс определения ЧПУ и языка
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
class friendly_url extends global_m
{
    public $url_lang        = array();
    public $url_command     = array();
    public $url_user_login  = NULL;
    public $url_user_data   = array();
    public $url_page        = NULL;
    public $url_sub_page    = NULL;
    public $url_other       = array();
    public $lang_to_link    = NULL;

    private $lang_data      = array();
    private $request_url    = "";
    private $array_gets     = "";
    private $commands       = array (
    							'add',				// Добавление
    							'edit',				// Редактирование
                                'search', 	    	//поиск
                                'search_product', 	//поиск
                                'registration', 	//регистрация
                                'recovery_password',//восстановление пароля
                                'logout',       	//выход
                                'activate',     	//команда на активацию учётной записи
                                'join',     		//команда-заявка на переход в нужную группу
                                'confirm',     		//команда-подтверждение
                                'marketplace',     	//торговая площадка
                                'marketplace_p',    //партнёрская площадка
                                'recover_pass',     //команда на сброс пароля для учетной записи
                            );

    function __construct(){
        $this->lang_abbr_to_link();

        if (isset($_GET['do'])) {
            // Получаем URL для проверки
            $this->request_url = preg_replace("/\?.*/i",'', $_SERVER['REQUEST_URI']);

            // получаем строку запроса, обрезаем лишние слеши и рубим её на массив
            $this->array_gets = explode('/', trim($_GET['do'],"\/"));

            $this->check_lang();

            $this->check_command();

            $this->check_url_user_login();

            $this->check_url_page();
        }
    }

    private function check_url_page() {
        // определяем раздел по url
        if (count($this->array_gets)>0){
            $this->url_page = $this->array_gets[0];
        }


        foreach ($this->array_gets as $key => $get_data) {
            if ($key == 0) {
                $this->url_page = $get_data;
            } elseif ($key == 1) {
                $this->url_sub_page = $get_data;
            } else {
                $this->url_other[] = $get_data;
            }
        }
    }

    private function check_url_user_login() {
        // проверяем наличие логина пользователя в url
        $gets_first = $this->array_gets;
        foreach ($this->array_gets as $get_key=>$get_data) {
            $isset_login = $this->get_user_data_by_login($get_data);
            if ($isset_login['result']){

                $this->url_user_login = $get_data;
                $this->url_user_data = $isset_login['result_data'];
                unset($this->array_gets[$get_key]);
            }
        }
        if (count($this->array_gets)>0){
            $this->array_gets = $this->array_rename($this->array_gets,$gets_first);
        }
    }

    private function check_command() {
        // проверяем наличие команды в url
        $commands = array_flip($this->commands);
        $gets_first = $this->array_gets;
        foreach ($this->array_gets as $get_key=>$get_data) {
            $from_get = explode('=',$get_data);
            if (isset($commands[$from_get[0]])){
                $this->url_command[$from_get[0]] = (isset($from_get[1]))?$from_get[1]:$from_get[0];
                $_GET[$from_get[0]] = (isset($from_get[1]))?$from_get[1]:$from_get[0];
                unset($this->array_gets[$get_key]);
            }
        }
        if (count($this->array_gets)>0){
            $this->array_gets = $this->array_rename($this->array_gets,$gets_first);
        }
    }

    private function check_lang() {
        // проверяем наличие языковой аббревиатуры в первой позиции url
        foreach ($this->lang_data['by_abbr'] as $lang_data) {
            if ($this->array_gets[0] == $lang_data['lang_abbr']) {
                $this->url_lang['id'] = $lang_data['lang_id'];
                $this->url_lang['abbr'] = $lang_data['lang_abbr'];
                $gets_first = $this->array_gets;
                unset($this->array_gets[0]);
                if (count($this->array_gets)>0){
                    $this->array_gets = $this->array_rename($this->array_gets,$gets_first);
                }
                break;
            }
        }
    }

    private function lang_abbr_to_link() {
        $this->lang_data = global_m::get_langs_data();

        $this->url_lang['id'] = $this->lang_data['default_lang']['lang_id'];
        $this->url_lang['abbr'] = $this->lang_data['default_lang']['lang_abbr'];

        // определяем нужно ли добавлять язык в ссылку
        if (count($this->lang_data['by_abbr']) > 1){
            $this->lang_to_link = "/{$this->url_lang['abbr']}";
        }
    }

    private function array_rename($arr_1, $arr_2){
        $arr_k = array_keys($arr_2);
        array_splice($arr_k,count($arr_1));
        $return = (array_combine($arr_k, $arr_1));
        return $return;
    }

}
