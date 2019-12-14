<?php 
$dir = dirname(__FILE__);
include_once($dir.'/../util.php');
include_once($dir.'/../db.php');
include_once($dir.'/../token.php');

if($_SESSION['uid'] != 1) error('Not enough permissions');
$data = json_decode(file_get_contents('php://input'),TRUE,100,JSON_PARTIAL_OUTPUT_ON_ERROR);
$db = &$_SERVER['DB'];
if($_REQUEST['id']!=0)
{
  $stm = $db->prepare('UPDATE account SET email = ?, '.($data['secret']!='' ? 'secret = ?,' : '').' full_name = ? WHERE id = '.$_REQUEST['id']);
  $db->bind($stm,$data['secret']!='' ? Array($data['email'],$data['secret'],$data['full_name']) : Array($data['email'],$data['full_name']));
  $db->exec($stm,FALSE);
  $err = $db->errno();
  if($err==1062) error("Duplicate email");
  elseif($err) trigger_error($db->errno().': '.$db->errmsg(),E_USER_WARNING);
  else echo '{"saved":true}';
}
else
{
  $stm = $db->prepare('INSERT INTO account(email,secret,full_name) VALUES(?,?,?)');
  $db->bind($stm,Array($data['email'],$data['secret'],$data['full_name']));
  $db->exec($stm,FALSE);
  $err = $db->errno();
  if($err==1062) error("Duplicate email");
  elseif($err) trigger_error($db->errno().': '.$db->errmsg(),E_USER_WARNING);
  else
  {
    $data['id'] = $db->last_id();
    echo json_encode($data);
  }
}

?>