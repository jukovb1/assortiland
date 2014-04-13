<?php
/**
 * ash_debug.functions.php
 *
 * Набор функций для дебагера
 *
 * Данный файл НЕ является частью системы управления контентом
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
if (!defined('IN_APP')) {
    die("not in app");
}

$show_debug = true;

if (!$GLOBALS["is_local_start"]) {
    $show_debug = false;
    if (isset($_GET['show_debug']) && $_GET['show_debug']=='bbz3ghkhbj'){
        $show_debug = true;
    }
}


// ф-ции дебагера
function wrap($color, $text, $type, $title = false) {
    if ($title){
        return "<span title='$type' style='font-weight: bold;color:".$color.";font-size:14px;font-we'>".$text."</span>";
    } else {
        return "<span title='$type' style='color:".$color."'>".$text."</span>";
    }
}

function filter_tilda_keys(&$a) {
    static $level = 0;
    $tab = "<small style='color: #555;font-size: 6px'>.</small>    ";
    $return = '';
    if (empty($a)){
        return $return;
    }
    foreach($a as $k=>$v) {
        if(substr($k, 0, 1) != "~" && $k!=='GLOBALS') {
            if(is_array($v)) {
                $return.= str_repeat($tab, $level)."[".wrap("OrangeRed", $k,'array (count('.count($v).'))')."] => array";
                if(!empty($v)) {
                    $return.=  "\n";
                    $return.= str_repeat($tab, $level)."(\n";
                    $level++;
                    $return.= filter_tilda_keys($v);
                } else {
                    $return.= "( )\n";
                }
            } elseif(is_string($v)) {
                if ($level==0) {
                    $return.= str_repeat($tab, $level)."(\n";
                    $level=1;
                }
                $return.= str_repeat($tab, $level)."[".wrap("blue", $k,'string')."] = ".((strlen($v) < 255) ? $v : substr($v, 0, 255)."...")."\n";
            } elseif (is_numeric($v)) {
                if ($level==0) {
                    $return.= str_repeat($tab, $level)."(\n";
                    $level=1;
                }
                $return.= str_repeat($tab, $level)."[".wrap("#00ff00", $k,'number')."] = ".$v."\n";
            }elseif (is_bool($v)) {
                if ($level==0) {
                    $return.= str_repeat($tab, $level)."(\n";
                    $level=1;
                }
                $return.= str_repeat($tab, $level)."[".wrap("yellow", $k,'boolean')."] = ".$v."\n";
            } else {
                $return.= str_repeat($tab, $level)."[".wrap("red", $k,'other')."] = ".$v."\n";
            }
        }
    }
    $level--;
    $show_bracket = ($level<0)?false:true;
    $level=($level<0)?0:$level;
    $return.= ($show_bracket)?str_repeat($tab, $level).")\n":"";
    return nl2br($return);
}

function ash_debug($var,$description=NULL) {
    global $show_debug;
    if ($show_debug) {
        // определяем место вызова
        // файл, строка, имя переменной
        $called = debug_backtrace();
        $file = $called[0]['file'];
        $line = $called[0]['line'];

        $v_file = file($file);
        $v_line = $v_file[$line - 1];
        preg_match( "#\\$(\w+)#", $v_line, $match );
        $var_name = "$".$match[1];


        $coord=($file && $line)?" <small style='font-size: 11px'>{{$file} - <b>line:$line</b>}</small>":NULL;
        if(is_numeric($var)) {
            $title = " - number ";
            $data = $var;
        } elseif(empty($var)) {
            $title = " - empty ";
        } elseif (is_array($var)){
            $title = " - is array (count(".count($var).")) ";
            $data = filter_tilda_keys($var);
        } else{
            $title = " - is string (strlen(".strlen($var)."))";
            $data = ((strlen($var) < 255) ? $var : substr($var, 0, 255)."...");
        }
        echo "<pre style='font-size:12px;font-weight: normal;border: 1px solid #000;width: 1000px;margin:10px auto'>";
        echo "<div style='background: LightSteelBlue;border-bottom: 3px double #000;padding:10px;'>";
        echo wrap("green", $var_name,$var_name." - ".$description , true).$title.$coord;
        echo "</div>";
        echo (isset($data))?"<div style='background: #000;padding:10px;color:LightSkyBlue;max-height: 200px;overflow: auto;'>":NULL;
        echo (isset($data))?$data:NULL;
        echo (isset($data))?"</div>":NULL;
        echo "</pre>";
    }
}