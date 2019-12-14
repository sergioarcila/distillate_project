<?php 
$dir = dirname(__FILE__);
include_once($dir.'/../util.php');
include_once($dir.'/../db.php');
include_once($dir.'/../token.php');
ini_set('zlib.output_compression', 1);

if($_SESSION['uid'] != 1) error('Not enough permissions');
$res = $_SERVER['DB']->query('SELECT id,email,secret,full_name FROM account');
$info = Array();
while($row = mysqli_fetch_assoc($res)) $info[] = $row;
echo json_encode($info);

?>