<?
if (!defined('IN_APP')) {
    die("not in app");
}

class auth extends global_m {
    public $cur_user_id = NULL;
    public $cur_user_name = '';
    public $cur_user_login = '';
    public $cur_user_email = '';
    public $cur_user_status = 0;
    public $cur_user_group  = 0;
    public $cur_user_status_in_group  = 0;
    public $auth_form_path;
    public $result_msg = '';
    public $show_form;

    private $post_auth = '';
    private $auth_area = '';
    private $user_ip = '';
    private $user_groups = NULL;
    private $to_time = 86400; // время жизни сессии (секунды)


    function __construct($area='front'){
        $this->auth_area = $area;
        $this->auth_form_path = str_replace("\\","/",dirname(__FILE__))."/form/auth.form.php";
        // определяем ip посльзователя
        $this->user_ip = ip2long($_SERVER['REMOTE_ADDR']);
        // удаляем старые ключи из таблицы сессий
        $this->del_old_keys();
        // по-умолчанию показывать форму входа
        $this->show_form = true;
        // есть ли в массиве POST инфо о том, что это была форма авторизации
        $this->post_auth = (isset($_POST['auth']))?$_POST['auth']:NULL;

        // процедура выхода
        if(isset($_GET['logout'])){
            $this->logout();
        } else {
            //проверка существования сессии
            if($area=='admin'){
                $this->user_groups = "1,2";
            }
            if (isset($_COOKIE["user_session_key"])){
                $this->auto_login($_COOKIE["user_session_key"],$this->user_ip);
            } else {
                if($area=='admin'){
                    $this->check_auth_in_admin_panel();
                } else {
                    $this->check_auth_in_front();
                }
            }

        }
    }
    private function check_auth_in_admin_panel(){
        if (!is_null($this->post_auth)){
            $prep_array = $this->prep_auth_form_data($_POST);
            if ($prep_array['result']){
                $this->cur_user_login = $prep_array['result_data']['login'];
                $this->login($this->cur_user_login,$prep_array['result_data']['pass']);
            }
        }
    }

    private function check_auth_in_front(){

        if (!is_null($this->post_auth)){

            $prep_array = $this->prep_auth_form_data($_POST);
            if ($prep_array['result']){
                $this->cur_user_login = $prep_array['result_data']['login'];
                $this->login($this->cur_user_login,$prep_array['result_data']['pass']);
            }
        }
    }

    private function del_old_keys() {
        $current_date = date('Y-m-d H:i:s');
        global $class_db;
        $class_db->delete_from_table("users_sessions","ses_time < '$current_date'");
    }

    private function logout($reload=true) {
        setcookie("user_session_key", 0,time(),'/');

        $this->cur_user_id = 0;
        $this->cur_user_name = '';
        $this->cur_user_login = '';
        $this->cur_user_status = 0;
        $this->cur_user_group = 0;
        $this->cur_user_email = '';
        $this->cur_user_status_in_group = 0;
        $this->show_form = true;
        if ($reload===true){
            $url = $_SERVER['REQUEST_URI'];
            $url = str_replace("?logout","",$url);
            $url = str_replace("&logout","",$url);
            $url = str_replace("/logout","",$url);
            header("Location: $url");
        }
    }

    private function check_access_for_user($auto=false,$key=NULL) {
        $users_for_access_group = self::get_user_list();
        $cur_user_id_data = $this->get_user($this->cur_user_id,$this->user_groups);
        $this->cur_user_name = $cur_user_id_data['user_fullname'];
        $this->cur_user_login = $cur_user_id_data['user_login'];
        $this->cur_user_status = $cur_user_id_data['user_status'];
        $this->cur_user_group = $cur_user_id_data['user_default_group'];
        $this->cur_user_email = $cur_user_id_data['user_email'];
        $this->cur_user_status_in_group = $cur_user_id_data['user_status_in_group'];
        $this->show_form = false;

        if ($auto && is_array($cur_user_id_data)){
            $this->set_login_auto($this->cur_user_id,$key);

        } elseif (is_array($cur_user_id_data)){
            $this->set_login($this->cur_user_id);
        } else {
            $this->result_msg = lang_text('{auth_access_denied_for_you}');
            $this->logout(false);
        }
    }
    private function auto_login($key,$ip) {
        global $class_db;

        $sql = "
            SELECT us.*
            FROM users_sessions as ses, users as us
            WHERE ses.ses_key = '$key'
            AND ses.ses_user_id = us.user_id
            LIMIT 1
        ";
        $sql_res = $class_db->select_from_table($sql);

        if (!$sql_res) {
            $this->logout(false);
            $this->show_form = true;
        } else {
            $this->cur_user_id = $sql_res[0]['user_id'];
            $this->check_access_for_user(true,$key);
        }
    }

    private function login($login,$pass) {
        global $class_db;
        $sql = "SELECT *
            FROM users
            WHERE user_login = '$login'
            AND user_pass='$pass'
            LIMIT 1";
        $sql_res = $class_db->select_from_table($sql);

        if (!$sql_res) {
            $this->show_form;
            $this->result_msg = lang_text('{auth_error}');

        } else {
            $this->cur_user_id = $sql_res[0]['user_id'];
            $this->check_access_for_user();
            if ($this->show_form == false){
                $new_url = $_SERVER['REQUEST_URI'];
                if (isset($_GET['ref'])){
                    $decode_referer = str_replace("[Q]","?",$_GET['ref']);
                    $decode_referer = str_replace("[A]","&",$decode_referer);
                    $new_url = $decode_referer;
                }
                $add_msg_user = (isset($_COOKIE['msg_for_user']))?$_COOKIE['msg_for_user']."<br>":NULL;
                setcookie('msg_for_user',$add_msg_user.lang_text('{auth_hello_user}::{:USER_NAME:}='.$this->cur_user_name),time()+60,'/');
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: $new_url");
            }
        }
    }

    private function get_user($id,$group=NULL) {
        $result = false;
        global $class_db;
        if (is_null($group)){
            $where = '';
        } else {
            $where = "AND user_default_group IN ($group)";
        }
        $sql_res = $class_db->select_from_table("
            SELECT *
            FROM users
            WHERE user_id = $id
            AND user_status >= 0
            $where
            LIMIT 1
        ");
        if ($sql_res){
            $result = $sql_res[0];
        }
        return $result;
    }

    private function set_login($user_id) {
        global $class_db;
        $user_session_key = md5(time().mt_rand());
        $array_to_db = array(
            'ses_user_id'=>$user_id,
            'ses_key'=>$user_session_key,
            'ses_user_ip'=>$this->user_ip,
            'ses_time'=>date('Y-m-d H:i:s',time()+$this->to_time)
        );
        $class_db->insert_array_to_table("users_sessions",$array_to_db);
        setcookie("user_session_key", $user_session_key,time()+$this->to_time,'/');

    }

    private function set_login_auto($user_id,$user_session_key) {
        global $class_db;
        $array_to_db = array(
            'ses_user_id'=>$user_id,
            'ses_key'=>$user_session_key,
            'ses_user_ip'=>$this->user_ip,
            'ses_time'=>date('Y-m-d H:i:s',time()+$this->to_time)
        );
        $class_db->insert_array_to_table("users_sessions",$array_to_db,'','',0,"ses_user_id=$user_id AND ses_key='$user_session_key' AND ses_user_ip='{$this->user_ip}'");
        setcookie("user_session_key", $user_session_key,time()+$this->to_time,'/');
    }
    private function prep_auth_form_data($posted_ar) {
        $result['result'] = true;
        $result['result_msg'] = '';
        if (!isset($posted_ar['login']) || empty($posted_ar['login'])) {
            $result['result'] = false;
            $result['result_msg'] = "Заполните логин и пароль  \r\n";
        }
        if (!isset($posted_ar['pass']) || empty($posted_ar['pass'])) {
            $result['result'] = false;
            $result['result_msg'] = "Заполните логин и пароль \r\n";
        }
        $f_login = trim($posted_ar['login']);
        $f_login = mysql_real_escape_string($f_login);
        $f_login = htmlspecialchars($f_login);
        $result['result_data']['login'] = $f_login;

        $f_pass = md5($posted_ar['pass']);
        $f_pass = trim($f_pass);
        $f_pass = mysql_real_escape_string($f_pass);
        $f_pass = htmlspecialchars($f_pass);
        $result['result_data']['pass'] = $f_pass;
        return $result;
    }
}
