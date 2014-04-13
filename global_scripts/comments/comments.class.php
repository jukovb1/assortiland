<?php
/**
 * comments.class.php
 *
 * Класс выведения и добавления комментариев
 *
 * Данный файл НЕ является частью системы управления контентом
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */


class comments extends global_m
{

    private $class_name = NULL;         // имя класса
    private $module_name = NULL;        // название раздела
    private $target_id = 0;             // id страницы
    private $comments_array = array();  // массив комментариев
    private $count_comments = 0;        // кол-во комментариев данной страницы
    private $count_comments_for_double_form = 5;        // кол-во комментариев для второй формы
    private $user_data = array();       // массив данных комментирующего (для уменьшения запросов к БД)

    private $sort_desc = true;       // сортировка от новых к старым
    private $count_by_page = 10;       // кол-во на странице

    public function __construct($module,$target,$ajax=false){
        // присваиваем значения
        $this->class_name = get_class();
        $this->module_name = $module;
        $this->target_id = $target;

        if (!$ajax){
            // получаем список комментариев
            $this->get_comments_for_page();
        }
    }


    public function print_comments_block($html_tab=-1){
        $block = tab($html_tab)."<div class='comments_block'>";
        if ($this->count_comments >= $this->count_comments_for_double_form){
            $block .= tab($html_tab).$this->html_comments_form($html_tab);
        }
        $block .= tab($html_tab).$this->html_comments_list($html_tab);
        $block .= tab($html_tab).$this->html_comments_form($html_tab);
        $block .= tab($html_tab)."</div>";
        return $block;
    }

    public function print_comments_block_ajax($html_tab=-1){
        $block = '';
        if ($this->count_comments == $this->count_comments_for_double_form){
            $block .= tab($html_tab).$this->html_comments_form($html_tab);
        }
        $block .= tab($html_tab).$this->html_comments_list($html_tab);
        return $block;
    }

    private function html_comments_form($html_tab=-1){
        global $auth_class;
        $comments_form = tab($html_tab+1)."<div class='comments_form'>";
        if ($auth_class->cur_user_group>0){
            $comments_form .= tab($html_tab+2)."<textarea required class='comment_text' placeholder='".lang_text("{comment_placeholder}")."'></textarea>";
            $comments_form .= tab($html_tab+2)."<div class='show_required_text'>".lang_text("{required_text}")."</div>";
            $comments_form .= tab($html_tab+2)."<div class='show_dop_text'>".lang_text("{comments_timeout}::{:TIMEOUT:}=<span class='comment_timeout'>30</span>::{:REMAINING_TIME:}=<span class='comment_remaining_time'>30</span>")."</div>";
            $comments_form .= tab($html_tab+2)."<button class='send_comment' >".lang_text("{send_comment}")."</button>";
        } else {
            $comments_form .= tab($html_tab+2).lang_text("{comment_no_auth}");
        }
        $comments_form .= tab($html_tab+1)."</div>".tab(0);
        return $comments_form;
    }

    private function html_comments_list($html_tab=-1){
        global $auth_class;
        $comments_list = tab($html_tab+1)."<div class='comments_list' data-module='{$this->module_name}' data-target_id='{$this->target_id}'>";
        if ($this->count_comments>0) {
            $i=0;
            foreach ($this->comments_array as $data) {
                $i++;
                $class_comment = "comment";
                $del_button = "";
                if ($auth_class->cur_user_id == $data['com_user_id']){
                    $class_comment = "my_comment";
                    $del_button = tab($html_tab+5)."<button data-comment_del_status='".lang_text("{comment_del_status}")."'  data-comment_recovery='".lang_text("{comment_recovery}")."' title='".lang_text("{comment_del}")."' data-comment_id='{$data['com_id']}' class='comment_del'>&#10008;</button>";
                }
                $last = ($i == $this->count_comments && $class_comment == "my_comment")?"id='last_comment'":"";
                if ($this->sort_desc){
                    $last = ($i == 1 && $class_comment == "my_comment")?"id='last_comment'":"";
                }
                $comments_list .= tab($html_tab+2)."<div $last class='$class_comment'>";
                $comments_list .= tab($html_tab+3)."<div class='comment_header'>";
                $comments_list .= tab($html_tab+4)."<div class='comment_author'>";
                $comments_list .= tab($html_tab+5).$data['com_user_link'];
                $comments_list .= tab($html_tab+5)."<span class='comment_date'>(".global_v::date_to_format($data['com_date']).")</span>";
                $comments_list .= $del_button;
                $comments_list .= tab($html_tab+4)."</div>";
                $comments_list .= tab($html_tab+3)."</div>";
                $comments_list .= tab($html_tab+3)."<div class='comment_text'>";
                $comments_list .= tab($html_tab+4).nl2br($data['com_text']);
                $comments_list .= tab($html_tab+3)."</div>";
                $comments_list .= tab($html_tab+2)."</div>";
            }
        } else {
            $comments_list .= tab($html_tab+2)."<div class='no_comments'>".lang_text('{no_comments_for_this_target}')."</div>";
        }
        $comments_list .= tab($html_tab+1)."</div>".tab(0);
        return $comments_list;
    }

    private function get_comments_for_page(){
        global $class_db;
        $desc = ($this->sort_desc)?"DESC":"";
        $sql = "SELECT *
                FROM comments
                WHERE com_module = '{$this->module_name}'
                AND com_target_id = {$this->target_id}
                AND com_status > 0
                ORDER BY com_date $desc
        ";
        $comments = $class_db->select_from_table($sql);
        if ($comments){
            $i=0;
            foreach ($comments as $com_data) {
                $i++;
                $access = true;
                if (!isset($this->user_data[$com_data['com_user_id']])){
                    $tmp_user_data = global_v::user_name_link_by_group_rules($com_data['com_user_id']);
                    if ($tmp_user_data===false){
                        $access = false;
                    } else {
                        $this->user_data[$com_data['com_user_id']] = $tmp_user_data;
                    }
                }
                if ($access){
                    $this->comments_array[$i] = $com_data;
                    $this->comments_array[$i]['com_user_link'] = $this->user_data[$com_data['com_user_id']];
                }
            }
            $this->count_comments = count($comments);
        }
    }

    public function get_comment_by_id($id){
        global $class_db;
        $sql = "SELECT *
                FROM comments
                WHERE com_id = {$id}
                AND com_status > 0
        ";
        $comments = $class_db->select_from_table($sql);
        if ($comments){
            $return = $comments[0];
        } else {
            $return = false;
        }
        return $return;
    }

    public function add_comments_for_page($array){
        global $class_db;
        $return['result'] = true;
        $return['result_msg'] = "{IE_0x101}";
        $add_res = $class_db->insert_array_to_table('comments',$array);
        if (!$add_res){
            $return['result'] = false;
            $return['result_msg'] = "{IE_2x100}";
        } else {
            $this->get_comments_for_page();
        }
        return $return;
    }
    public function comment_change_status($status,$id){
        global $class_db;
        $return['result'] = true;
        $return['result_msg'] = ($status==1)?"{IE_recovery_ok}":"{IE_del_ok}";
        $add_res = $class_db->insert_array_to_table('comments',array("com_status"=>$status),'com_id',$id);
        if (!$add_res){
            $return['result'] = false;
            $return['result_msg'] = "{IE_error_db}";
        } else {
            $this->get_comments_for_page();
        }
        return $return;
    }

    public function require_js_and_css_files(){
        $root = $_SERVER['DOCUMENT_ROOT'];
        $point = '.';
        $slash='/';
        $css = "css";
        $js = "js";
        $return_require_files = '';
        $default_path = "/global_scripts/{$this->class_name}/";
        $css_path = "/assets/css/";
        $js_path = "/assets/js/{$this->class_name}/";
        // сначала css
        if (file_exists($root.$css_path.$this->class_name.$point.$css)){
            $cur_css_path = $css_path.$this->class_name.$point.$css;
        } elseif (file_exists($root.$default_path.$css.$slash.$this->class_name.$point.$css)){
            $cur_css_path = $default_path.$css.$slash.$this->class_name.$point.$css;
        } else {
            $cur_css_path = NULL;
        }
        if (file_exists($root.$js_path.$this->class_name.$point.$js)){
            $cur_js_path = $js_path.$this->class_name.$point.$js;
        } elseif (file_exists($root.$default_path.$js.$slash.$this->class_name.$point.$js)){
            $cur_js_path = $default_path.$js.$slash.$this->class_name.$point.$js;
        } else {
            $cur_js_path = NULL;
        }
        $return_require_files .= tab(0).tab(1)."<!-- CSS and JS files for class {$this->class_name} -->";
        if (!is_null($cur_css_path)){
            $return_require_files .= tab(1)."<link rel='stylesheet' type='text/css' href='$cur_css_path'>";
        } else {
            $return_require_files .= tab(1)."<!-- CSS file not found. Place the CSS file named \"{$this->class_name}.css\", in the folder \"$css_path\" -->";
        }
        if (!is_null($cur_js_path)){
            $return_require_files .= tab(1)."<script type='text/javascript' src='$cur_js_path'></script>";
        } else {
            $return_require_files .= tab(1)."<!-- JS file not found. Place the JS file named \"{$this->class_name}.js\", in the folder \"$js_path\" -->";
        }
        return $return_require_files.tab(0);
    }



}
