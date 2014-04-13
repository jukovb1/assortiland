<?php
/**
 * time_control.class.php
 *
 * Класс контроля скорости загрузки страницы
 * с учётом промежуточных участков.
 *
 * Использование:
 * добавить в нужных местах строки
 * control_time::add_to_log("ВАШЕ_ПРИМЕЧАНИЕ",__FILE__,__LINE__);
 * После отрисовки html добавить
 * control_time::add_to_log("Конец отрисовки html",__FILE__,__LINE__,true);
 * В результате, в конце страницы появится таблица с учётом времени исполнения
 * различных участков кода
 *
 * Данный файл НЕ является частью системы управления контентом
 *
 * @author Ashterix <ashterix69@gmail.com>
 * @version 0.0.1
 */
if (!defined('IN_APP')) {
    die("not in app");
}
class control_time
{
    /**
     * $profiler_data
     *
     * @var array
     * результирующий массив
     */
    static private $profiler_data;


    /**
     * add_to_log($name,$file,$line,$print=false)
     * @type static public
     * @description Получение списка всех языков для сайта
     *
     * @param $name string (примечание)
     * @param $file string (файл где вызвана)
     * @param $line string (строка где вызвана)
     * @param $print boolean (показ таблицы)
     *
     * @return NULL Строит таблицу результатов
     */
    static public function add_to_log($name,$file,$line,$print=false){
        list($usec, $sec) = explode(" ",microtime());
        $cur_time= (float)$sec + (float)$usec;

        if (!isset(self::$profiler_data["time_start"])){
            self::$profiler_data["time_start"]=$cur_time;
        }
        if (!isset(self::$profiler_data["time_prev"])){
            self::$profiler_data["time_prev"]=$cur_time;
        }
        self::$profiler_data["time_log"][]=array(
            "name"=>$name,
            "file"=>$file,
            "line"=>$line,
            "time"=>$cur_time,
            "time_from_prev"=>round(($cur_time-self::$profiler_data["time_prev"]),3),
            "time_from_start"=>round(($cur_time-self::$profiler_data["time_start"]),3)
        );
        self::$profiler_data["time_prev"]=$cur_time;
        self::$profiler_data["time_fin"]=round(($cur_time-self::$profiler_data["time_start"]),3);
        if ($print && $GLOBALS["is_local_start"]){
            self::show_log();
        }
    }


    /**
     * show_log()
     * @type static private
     * @description Получение списка всех языков для сайта
     *
     * @return NULL ничего не возвращает
     */
    static private function show_log(){
        ?>
        <style>
            .table_log{
                width: 1000px;
                margin: 30px auto;
                background: #fff;
            }
            .table_log th{
                height: 30px;
                background: #ccc;
                border: 1px solid #000;
                font-weight: bold;
                text-align: center;
            }
            .table_log td{
                background: #fff;
                border: 1px solid #000;
                font-weight: normal;
                padding-left: 20px;
            }
            .table_log tr:hover td{
                background: #d2d385;
                cursor: default;
            }
            td.time_td{
                width: 100px;
                text-align: center;
                padding: 0;
            }
        </style>
        <table class="table_log">
            <tr>
                <th colspan="4" style="vertical-align: middle">Control time log</th>
            </tr>

            <tr>
                <th>Point name</th>
                <th>Time from prev (ms)</th>
                <th>Time from start (ms)</th>
                <th>File/Line</th>
            </tr> <?
            foreach(self::$profiler_data['time_log'] as $log_val){
            ?>
            <tr>
                <td><?=$log_val['name']?></td>
                <td class="time_td"><?=$log_val['time_from_prev']*1000?></td>
                <td class="time_td"><?=$log_val['time_from_start']*1000?></td>
                <td><?=$log_val['file']?> <b>line:<?=$log_val['line']?></b></td>
            </tr>
            <?
            }
            ?>
            <tr>
                <th colspan="4" style="text-align: left;padding-left: 20px;vertical-align: middle">Page load time - <?=self::$profiler_data['time_fin']*1000?> ms</th>
            </tr>
        </table>
        <?

    }

}