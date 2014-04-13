<?php
/**
 * multiple_checkbox.class.php
 *
 * Класс генерирования древовидного поля множественного выбора
 * с возможностью поиска по дереву
 *
 * Использует принцип рекурсии
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
class multiple_checkbox
{

    private $tag_id = '';
    private $parent_tag_id = '';
    private $tag_level = '';
    private $tag_name = '';

    private $class_name;
    private $publish = false;

    public function __construct(){
        $this->publish = true;
        $this->class_name = get_class();
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
        if ($this->publish){
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
            $return_require_files = "\r\n\r\n<!-- CSS and JS files for class {$this->class_name} -->\r\n";
            if (!is_null($cur_css_path)){
                $return_require_files .= "<link rel='stylesheet' type='text/css' href='$cur_css_path'>\r\n";
            } else {
                $return_require_files .= "<!-- CSS file not found. Place the CSS file named \"{$this->class_name}.css\", in the folder \"$css_path\" -->\r\n";
            }
            if (!is_null($cur_js_path)){
                $return_require_files .= "<script type='text/javascript' src='$cur_js_path'></script>\r\n";
            } else {
                    $return_require_files .= "<!-- JS file not found. Place the JS file named \"{$this->class_name}.js\", in the folder \"$js_path\" -->\r\n";
            }
        }
        return $return_require_files;
    }

    private function tree_get_select_options_from_array_sort($branch,$parent_id,$selected_tags=array()){
        $select_res='';
        if(is_array($branch) && isset($branch[$parent_id])){
            foreach($branch[$parent_id] as $tag){
                $selected="";
                if(isset($selected_tags[$tag[$this->tag_id]])){
                    $selected="selected='selected'";
                }
                $select_res.="<option value='{$tag[$this->tag_id]}' class='sfco_{$tag[$this->parent_tag_id]}_{$tag[$this->tag_id]}' $selected>".str_repeat("",$tag[$this->tag_level])."{$tag[$this->tag_name]}</option>\n";
                $select_res .= $this->tree_get_select_options_from_array_sort($branch,$tag[$this->tag_id],$selected_tags);
            }
            return $select_res;

        } else {
            return null;
        }
    }


    private function tree_get_select_cbx_for_search_from_array_sort($branch,$parent_id,$selected_tags=array()){
        $select_res='';
        if(is_array($branch) && isset($branch[$parent_id])){
            foreach($branch[$parent_id] as $tag){
                $selected_class=$selected="";
                if(isset($selected_tags[$tag[$this->tag_id]])){
                    $selected="checked='checked'";
                    $selected_class = " scbx";
                }
                $cl=($tag[$this->tag_level]<=4)?$tag[$this->tag_level]:4;
                $select_res .= "<li class='m{$cl}{$selected_class}' data-i='{$tag[$this->tag_id]}' data-p='{$tag[$this->parent_tag_id]}' ><input $selected type='checkbox' value='{$tag[$this->tag_id]}'  class='cbfs scbfs{$tag[$this->parent_tag_id]}_{$tag[$this->tag_id]}' data-i='{$tag[$this->parent_tag_id]}_{$tag[$this->tag_id]}' > {$tag[$this->tag_name]}</li>\n";
                $select_res .= $this->tree_get_select_cbx_for_search_from_array_sort($branch,$tag[$this->tag_id],$selected_tags);
            }
            return $select_res;

        } else {
            return null;
        }

    }


    private function selected_params($branch,$parent_id,$selected_tags=array()){
        $select_res='';
        if(is_array($branch) && isset($branch[$parent_id]) && !empty($selected_tags)){
            foreach($branch[$parent_id] as $tag){
                if(isset($selected_tags[$tag[$this->tag_id]])){
                    $select_res.="<div class='sp sp_{$tag[$this->parent_tag_id]}_{$tag[$this->tag_id]}' data-i='{$tag[$this->parent_tag_id]}_{$tag[$this->tag_id]}'>{$tag[$this->tag_name]}<div title='Отменить выбор' class='ds'>X</div></div>\n";
                }
                $select_res.=$this->selected_params($branch,$tag[$this->tag_id],$selected_tags);
            }

            return $select_res;

        } else {
            return null;
        }
    }


    private function tree_get_select_checkbox_from_array_sort($tree,&$tree_result,$selected_tags=array()){

        foreach($tree as $data){
            $selected_class=$selected="";
            if(isset($selected_tags[$data['data'][$this->tag_id]])){
                $selected="checked";
                $selected_class = " scbx";
            }
            $cl=($data['data'][$this->tag_level]<=4)?$data['data'][$this->tag_level]:4;
            $plus_minus = (!empty($tree[$data['data'][$this->tag_id]]['child']))?"<div class='pf'><div data-st='1' class='pl pb{$data['data'][$this->parent_tag_id]}_{$data['data'][$this->tag_id]}' data-i='{$data['data'][$this->parent_tag_id]}_{$data['data'][$this->tag_id]}'></div></div>":"<div class='pf'><div class='ple' ></div></div>";
            $tree_result.="<div class='m{$cl}{$selected_class}'>$plus_minus<input class='cbfs cbfs{$data['data'][$this->parent_tag_id]}_{$data['data'][$this->tag_id]}' type='checkbox' $selected data-i='{$data['data'][$this->parent_tag_id]}_{$data['data'][$this->tag_id]}'>";
            $tree_result.="<div data-i='{$data['data'][$this->parent_tag_id]}_{$data['data'][$this->tag_id]}'  class='pa pb_{$data['data'][$this->parent_tag_id]}_{$data['data'][$this->tag_id]}'>";
            $tree_result.="{$data['data'][$this->tag_name]}</div></div>\r\n";
            if (!empty($tree[$data['data'][$this->tag_id]]['child'])){
                $tree_result.="<div class='cb child_box_{$data['data'][$this->parent_tag_id]}_{$data['data'][$this->tag_id]}'>";
                $this->tree_get_select_checkbox_from_array_sort($tree[$data['data'][$this->tag_id]]['child'],$tree_result,$selected_tags);
                $tree_result.="</div>\r\n";
            }
        }
        
    }

    public function set_indexes_for_branch_arr($tag_id,$parent_tag_id,$tag_level,$tag_name){
        $this->tag_id = $tag_id;
        $this->parent_tag_id = $parent_tag_id;
        $this->tag_level = $tag_level;
        $this->tag_name = $tag_name;
    }

    private function resort_array_by_tree($array,$parent_id){

        if(is_array($array) && isset($array[$parent_id])){
            $tree = array();
            foreach($array[$parent_id] as $cat){
                $tree[$cat['group_id']]['data'] = $cat;
                $tree[$cat['group_id']]['child'] = $this->resort_array_by_tree($array,$cat['group_id']);
            }
            return $tree;

        } else {
            return null;
        }

    }

    public function tree_print_final_table($table_id,$select_name,$branch,$selected=array(),$required=false){
        $required_attr = '';
        if ($required) {
            $required_attr = 'required="required"';
        }
        $second_array=$this->resort_array_by_tree($branch,0);
        $tree_result='';
        $this->tree_get_select_checkbox_from_array_sort($second_array,$tree_result,$selected);
        $selected_params = $this->selected_params($branch,0,$selected);
        $show_selected_block =($selected_params!==false)?"display:block;":NULL;
        /*контроль времени загрузки*/control_time::add_to_log("до построения $table_id",__FILE__,__LINE__);
        $return='';
        $return .= '<div class="for_multi_select" id="'.$table_id.'" style="display: table">';
        $return .= '    <div style="display: table-row">';
        $return .= '        <div class="select_multy_block">';
        $return .= '            <div class="h_cbx"></div>';
        $return .= '            <div style="display: none;" class="l_cbx">';
        $return .= '                <ul>';
        $return .=                      $this->tree_get_select_cbx_for_search_from_array_sort($branch,0,$selected);
        $return .= '                </ul>';
        $return .= '            </div>';
        $return .= '            <div class="t_li" style="">';
        $return .=                  $tree_result;
        $return .= '            </div>';
        $return .= '            <select '.$required_attr.' multiple class="sf_cbx" name="'.$select_name.'" style="">';
        $return .=                  $this->tree_get_select_options_from_array_sort($branch,0,$selected);
        $return .= '            </select>';
        $return .= '        </div>';
        $return .= '        <div style="display: table-cell">';
        $return .= '            <div class="ch_el" style="'.$show_selected_block.'">';
        $return .=                  $selected_params;
        $return .= '            </div>';
        $return .= '        </div>';
        $return .= '    </div>';
        $return .= '</div>';
        /*контроль времени загрузки*/control_time::add_to_log("после построения $table_id",__FILE__,__LINE__);
        return $return;
    }

}
