<?php 
$dir = dirname(__FILE__);
include_once($dir.'/../util.php');
include_once($dir.'/../db.php');
include_once($dir.'/../token.php');
ini_set('zlib.output_compression', 1);

// select datum,left(yearweek(datum,6),4),substr(yearweek(datum,6),5) from oil
$info = Array();
$res = $_SERVER['DB']->query('SELECT datum,row,col,price,COALESCE(stocks,0) AS stocks,COALESCE(atl_stocks,0) AS atl_stocks FROM dates LEFT OUTER JOIN oil USING(datum)');
while($row = mysqli_fetch_assoc($res)) $info[] = $row;

echo json_encode($info,JSON_NUMERIC_CHECK);

?>