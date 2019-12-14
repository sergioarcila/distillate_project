<?php
include_once(dirname(__FILE__)."/conf.php");

define('SQL_FOREIGN','23503');
define('SQL_UNIQUE','23505');
define('SQL_CHECK','23514');
define('SQL_OK','00000');

class dbMySQL
{
  function __construct()
  {
    $this->conn = NULL;
  }
  
  function connect()
  {
    $this->conn = @mysqli_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASS,DATABASE_NAME);
    if($this->conn === FALSE)
    {
      $js = Array('error'=>Array('type'=>'Error', 'text'=>mysqli_connect_error(), 'line'=>__LINE__, 'file'=>str_replace(ROOT,'',__FILE__), 'trace'=>Array()));
      echo json_encode($js,JSON_PARTIAL_OUTPUT_ON_ERROR);
      die;
    }
    mysqli_query($this->conn,'SET NAMES utf8');
  }
  
  function errno()
  {
    return mysqli_errno($this->conn);
  }
  
  function errmsg()
  {
    return mysqli_error($this->conn);
  }
  
  function prepare($query)
  {
    $stm = mysqli_stmt_init($this->conn);
    if(mysqli_stmt_prepare($stm,$query)) return $stm;
      else trigger_error(mysqli_error(),E_USER_WARNING);
  }
  
  function bind($stm,$arr)
  {

    $types = str_repeat('s',count($arr));
var_dump($types);exit;
    $params = Array();
    foreach($arr as $k=>&$v)
    {
      if(is_int($v) OR is_bool($v)) $types{$k} = 'i';
      elseif(is_float($v)) $types{$k} = 'd';
      elseif(is_numeric($v))
      {
        if(preg_match('/^[0-9]+$/',$v)) $types{$k} = 'i';
          else $types{$k} = 'd';
      }
      $params[] = $v;
    }
    array_unshift($params,$types);
    array_unshift($params,$stm);

    if(!call_user_func_array('mysqli_stmt_bind_param',$params)) trigger_error(mysqli_error($this->conn),E_USER_WARNING);
    //if(!mysqli_stmt_bind_param($stm,$types,...$arr)) trigger_error(mysqli_error($this->conn),E_USER_WARNING);
  }
  
  function exec($stm,$trigger=TRUE)
  {
    if(!mysqli_stmt_execute($stm)) 
      if($trigger) trigger_error(mysqli_errno($this->conn).': '.mysqli_error($this->conn),E_USER_WARNING);
  }
  
  function bind_res($stm,$arr)
  {
    $params = Array();
    foreach($arr as &$v) $params[] = $v;
    array_unshift($params,$stm);
    $result = call_user_func_array('mysqli_stmt_bind_result',$params);
    //$result = mysqli_stmt_bind_result($stm,...$arr);
    if($result === FALSE) trigger_error(mysqli_error($this->conn),E_USER_WARNING);
  }
  
  function fetch($stm)
  {
    $result = mysqli_stmt_fetch($stm);
    if($result === FALSE) trigger_error(mysqli_error($this->conn),E_USER_WARNING);
    return $result;
  }
  
  function result($stm)
  {
    $result = mysqli_stmt_get_result($stm);
    if(mysqli_errno($this->conn)) trigger_error(mysqli_error($this->conn),E_USER_WARNING);
    return $result;
  }
  
  function count($res)
  {
    return mysqli_num_rows($res);
  }
  
  function query($q,$trigger=TRUE)
  {
    $res = mysqli_query($this->conn,$q);
    if($res === FALSE) 
    {
      if($trigger) trigger_error(mysqli_errno($this->conn).': '.mysqli_error($this->conn),E_USER_WARNING);
        else return NULL;
    }
    else return $res;
  }
  
  function select($tbl,$clause,$field='',$where='')
  {
  	if ($clause==0) return ' ';
  	if($field=='') $field=$tbl;
  	$query = "SELECT $field FROM $tbl WHERE ";
  	if($where=='') $query.='ID='.$clause;
  		else $query.=$where;
  	$res = $this->query($query);
  	if(mysqli_num_rows($res))
  	{
  	  $z = mysqli_fetch_row($res)[0];
  	  mysqli_free_result($res);
  	  return $z;
  	}
  	else 
  	{
  	  mysqli_free_result($res);
  	  return ' ';
  	}
  }
  
  function escape($str)
  {
    return mysqli_real_escape_string($this->conn,$str);
  }
  
  function last_id()
  {
    return mysqli_insert_id($this->conn);
  }
  
  function get_res($res,$idx = 0)
  {
    return mysqli_fetch_row($res)[$idx];
  }
  
  function affected()
  {
    return mysqli_affected_rows($this->conn);
  }
  
  function mysqli_result($res,$row=0,$col=0)
  { 
    $numrows = mysqli_num_rows($res); 
    if ($numrows && $row <= ($numrows-1) && $row >=0)
    {
      mysqli_data_seek($res,$row);
      $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
      if (isset($resrow[$col])) return $resrow[$col];
    }
    return false;
  }
}

$_SERVER['DB'] = new dbMySQL;
$_SERVER['DB']->connect();

?>