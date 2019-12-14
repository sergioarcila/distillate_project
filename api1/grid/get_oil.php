<?php 
$dir = dirname(__FILE__);
include_once($dir.'/../util.php');
include_once($dir.'/../db.php');
include_once($dir.'/../token.php');
ini_set('zlib.output_compression', 1);

$res = $_SERVER['DB']->query('SELECT oil.datum < current_date AS history,oil.datum,COALESCE(turnarounds,0) AS turnarounds,runs,COALESCE(yield,0) AS yield,
  production,COALESCE(oil.imports,oil_user.imports,0) AS imports,COALESCE(exports,0) AS exports,COALESCE(extra_exports,0) AS extra_exports,
  COALESCE(shipments,0) AS shipments,COALESCE(padd_demand,0) AS padd_demand,COALESCE(oil.reported_us_demand,oil_user.reported_us_demand,0) AS reported_us_demand,
  COALESCE(padd_hdd,0) AS padd_hdd,COALESCE(us_hdd,0) AS us_hdd,COALESCE(us_hdd_norm,0) AS us_hdd_norm,stocks,atl_stocks,COALESCE(atl_stocks_over_padd,0) AS atl_stocks_over_padd
  FROM oil LEFT JOIN oil_user ON oil.datum = oil_user.datum AND user_id = '.(int)$_SESSION['uid'].'
  UNION
  SELECT oil_user.datum < current_date AS history,oil_user.datum,COALESCE(turnarounds,0) AS turnarounds,runs,COALESCE(yield,0) AS yield,production,
  COALESCE(oil.imports,oil_user.imports,0) AS imports,COALESCE(exports,0) AS exports,COALESCE(extra_exports,0) AS extra_exports,
  COALESCE(shipments,0) AS shipments,COALESCE(padd_demand,0) AS padd_demand,COALESCE(oil.reported_us_demand,oil_user.reported_us_demand,0) AS reported_us_demand,
  COALESCE(padd_hdd,0) AS padd_hdd,COALESCE(us_hdd,0) AS us_hdd,COALESCE(us_hdd_norm,0) AS us_hdd_norm,stocks,atl_stocks,COALESCE(atl_stocks_over_padd,0) AS atl_stocks_over_padd
  FROM oil RIGHT JOIN oil_user ON oil.datum = oil_user.datum AND user_id = '.(int)$_SESSION['uid']);
$info = Array('history'=>Array(), 'forecast'=>Array());
while($row = mysqli_fetch_assoc($res)) 
{
  if($row['history']) $info['history'][] = $row;
    else $info['forecast'][] = $row;
}
echo json_encode($info,JSON_NUMERIC_CHECK);

?>