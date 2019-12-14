<?php 

$dir = dirname(__FILE__);
include_once($dir.'/util.php');
include_once($dir.'/db.php');
session_start();

$db = &$_SERVER['DB'];
$res = $db->query('SELECT id FROM account WHERE email = "'.$db->escape($_REQUEST['username']).'" AND secret = "'.$db->escape($_REQUEST['password']).'"');
if(!$db->count($res))
{
	// ask authorization again
  header('HTTP/1.0 401 Unauthorized', true, 401);
  echo 'Wrong username or password';
	die;
}
else $_SESSION['uid'] = $db->get_res($res);

if($_SESSION['uid'] == 1) header('X-ADMIN: 1');
echo '{"login":true}';

?>