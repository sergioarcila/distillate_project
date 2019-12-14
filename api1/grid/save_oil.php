<?php 
$dir = dirname(__FILE__);
include_once($dir.'/../util.php');
include_once($dir.'/../db.php');
include_once($dir.'/../token.php');

$stm_history = $_SERVER['DB']->prepare('INSERT INTO oil_user(user_id,datum,turnarounds,exports,extra_exports,padd_demand,padd_hdd,us_hdd,us_hdd_norm)
  VALUES(?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE turnarounds = VALUES(turnarounds), exports = VALUES(exports), extra_exports = VALUES(extra_exports), 
  padd_demand = VALUES(padd_demand), padd_hdd = VALUES(padd_hdd), us_hdd = VALUES(us_hdd), us_hdd_norm = VALUES(us_hdd_norm)');
$stm_forecast = $_SERVER['DB']->prepare('INSERT INTO oil_user(user_id,datum,turnarounds,yield,imports,exports,extra_exports,shipments,padd_demand,reported_us_demand,us_hdd,us_hdd_norm,atl_stocks_over_padd)
  VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE turnarounds = VALUES(turnarounds), yield = VALUES(yield), imports = VALUES(imports), exports = VALUES(exports),
  extra_exports = VALUES(extra_exports), shipments = VALUES(shipments), padd_demand = VALUES(padd_demand), reported_us_demand = VALUES(reported_us_demand),
  us_hdd = VALUES(us_hdd), us_hdd_norm = VALUES(us_hdd_norm), atl_stocks_over_padd = VALUES(atl_stocks_over_padd)');
$data = json_decode(file_get_contents('php://input'),TRUE,100,JSON_PARTIAL_OUTPUT_ON_ERROR);
if(is_array($data['history'])) foreach($data['history'] as &$row)
{
  $_SERVER['DB']->bind($stm_history,Array($_SESSION['uid'],substr($row['datum'],0,10),$row['turnarounds'],$row['exports'],$row['extra_exports'],$row['padd_demand'],
    $row['padd_hdd'],$row['us_hdd'],$row['us_hdd_norm']));
  $_SERVER['DB']->exec($stm_history);
}

if(is_array($data['forecast'])) foreach($data['forecast'] as &$row)
{
  $_SERVER['DB']->bind($stm_forecast,Array($_SESSION['uid'],substr($row['datum'],0,10),$row['turnarounds'],$row['yield'],$row['imports'],$row['exports'],
    $row['extra_exports'],$row['shipments'],$row['padd_demand'],$row['reported_us_demand'],$row['us_hdd'],$row['us_hdd_norm'],$row['atl_stocks_over_padd']));
  $_SERVER['DB']->exec($stm_forecast);
}

echo '{"saved":true}';

?>