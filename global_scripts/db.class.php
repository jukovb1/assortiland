<?php
/**
 * db.class.php
 *
 * Класс подключения к БД
 *
 * Данный файл НЕ является частью системы управления контентом
 *
 * @author Ashterix <ashterix69@gmail.com>
 * Подробное описание будет для последующих версий
 * @version 0.0.1
 */
if (!defined('IN_APP')) {
    die("not in app");
}
class Database
{
    public $link;
    public $dbname;

	// Initializes the database link.
    function __construct($hostname, $username, $password, $dbname, $link=false, $set_cp1251=false){
        $this->dbname = $dbname;
		if($link===false){
			$this->link = mysql_connect($hostname, $username, $password);
		}else{
			$this->link = $link;
		}
		if (!$this->link) {
			my_error_log(0,mysql_error(),__FILE__,__LINE__);
			die();
		}
		if(strlen($dbname)>0) {
			mysql_select_db($dbname, $this->link);
		}
		if($set_cp1251){
			$this->unisql_query("SET NAMES cp1251");
		} else {
            $this->unisql_query("SET NAMES utf8");
        }
	}

	private function mysql_array_to($covertArray,$covertTo)	{
		$keys="";
		$values="";
		$table="";
		$html_table="";
		$keys_values="";
		$first=1;
		reset($covertArray);
		while (list($key, $value) = each($covertArray)) {
			if ($first==0) {
                $keys.=", ";
				$values.=", ";
				$keys_values.=", ";
			}

			//addslashes
			//mysql_escape_string
			$keys.="`".$key."`";
			if (is_array($value)){
                $value=$value["function"];
				$values.=$value;
				$keys_values.="`".$key."`=$value";
			}else{
                $values.="'".mysql_real_escape_string($value,$this->link)."'";
				$keys_values.="`".$key."`='".mysql_real_escape_string($value,$this->link)."'";
			}
			$table.=$key.": ".$value."\n";

			$first=0;
		}

		if ($covertTo=="values") {
            return $values;
		}elseif ($covertTo=="keys") {
            return $keys;
		}elseif ($covertTo=="table") {
            return $table;
		}elseif ($covertTo=="keys_values") {
            return $keys_values;
		}elseif ($covertTo=="html_table") {
            return $html_table;
		}
	}


	public function insert_array_to_table($add_to_table,$add_array,$update_where_name="",$update_where_value="",$limit=0,$update_where_complit="",$delayed=false, $test_on_error=true){
		$add_limit="";
		if ($limit>0) {
            $add_limit="LIMIT $limit";
		}
        $where = "";
        $upd = false;
		if (strlen($update_where_name)>0) {
            $upd = true;
            $where = "WHERE `$update_where_name` = '".mysql_real_escape_string($update_where_value)."'";
            $query="UPDATE `".$add_to_table."`
                    SET ".$this->mysql_array_to($add_array,"keys_values")."
                    $where
                    $add_limit";
		}elseif (strlen($update_where_complit)>0) {
            $upd = true;
            $where = "WHERE $update_where_complit";
            $query="UPDATE `".$add_to_table."`
                    SET ".$this->mysql_array_to($add_array,"keys_values")."
                    $where
                    $add_limit";
		}else{
			$add_delayed=($delayed)? "DELAYED":"";

			$query="INSERT $add_delayed
                    INTO ".$add_to_table."(".$this->mysql_array_to($add_array,"keys").")
                    VALUES (".$this->mysql_array_to($add_array,"values").")
                      ";
		}

		if ($this->unisql_query($query, $test_on_error)){
            $insert_id=mysql_insert_id($this->link);
			if ($insert_id) {
                return $insert_id;
			}else{
				if (mysql_affected_rows($this->link)>0) {
                    return true;
				}elseif ($upd) {
                    $sql = "SELECT * FROM $add_to_table $where";
                    if($this->select_from_table($sql)){
                        return true;
                    } else {
                        return false;
                    }
                }else {
                    return false;
				}
			}

		}else {
            return false;
		}
	}

	public function delete_from_table($table,$condition,$test_on_error=true){
		$query="DELETE
                    FROM    $table
                    WHERE   $condition
            ";

		if ($result=$this->unisql_query($query,$test_on_error)) {
			return true;
		} else {
            return false;
		}
	}


	public function select_from_table($query,$test_on_error=true)	{
		$return_value=array();

		if ($result=$this->unisql_query($query,$test_on_error)){
			while ($row = mysql_fetch_assoc($result)){
                $return_value[]=$row;
			}

		}else {
			return false;
		}

		mysql_free_result ($result);
		return $return_value;
	}

	public function unisql_query($query, $test_on_error=true){
		$result=mysql_query($query,$this->link);
		if (!$result) {
			my_error_log(0,mysql_error ()."\nЗапрос:\n".$query,__FILE__,__LINE__);
			$result=false;
		}

		return $result;
	}

    public function unisql_fetch_assoc($result){
		if ($row=mysql_fetch_assoc($result)){
            return $row;
		}else{
            return false;
		}
	}


    public function unisql_num_rows($result)	{
		if ($num_rows=mysql_num_rows($result)) {
            return $num_rows;
		}else{
            return false;
		}
	}

    public function unisql_fetch_array($result){
		if ($array=mysql_fetch_array($result)){
            return $array;
		}else{
            return false;
		}
	}

    public function  unisql_real_escape_string($str){
		return  mysql_real_escape_string($str,$this->link);
	}

    public function unisql_last_query_info($add_ext_info=false){
		$return = array();

		if($add_ext_info){
			$strInfo = mysql_info($this->link);
			if($strInfo){
				preg_match("/Records: ([0-9]*)/", $strInfo, $records);
				preg_match("/Duplicates: ([0-9]*)/", $strInfo, $dupes);
				preg_match("/Warnings: ([0-9]*)/", $strInfo, $warnings);
				preg_match("/Deleted: ([0-9]*)/", $strInfo, $deleted);
				preg_match("/Skipped: ([0-9]*)/", $strInfo, $skipped);
				preg_match("/Rows matched: ([0-9]*)/", $strInfo, $rows_matched);
				preg_match("/Changed: ([0-9]*)/", $strInfo, $changed);

				$return['records'] = isset($records[1])?(int)$records[1]:false;
				$return['duplicates'] = isset($dupes[1])?(int)$dupes[1]:false;
				$return['warnings'] = isset($warnings[1])?(int)$warnings[1]:false;
				$return['deleted'] = isset($deleted[1])?(int)$deleted[1]:false;
				$return['skipped'] = isset($skipped[1])?(int)$skipped[1]:false;
				$return['rows_matched'] = isset($rows_matched[1])?(int)$rows_matched[1]:false;
				$return['changed'] = isset($changed[1])?(int)$changed[1]:false;
			}
		}

		$found_rows=$this->select_from_table("SELECT FOUND_ROWS() as found_rows");
		$return['found_rows'] = $found_rows[0]["found_rows"];

		return $return;
	}


};