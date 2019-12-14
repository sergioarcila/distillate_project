<?php 
$dir = dirname(__FILE__);
include_once($dir.'/../util.php');
include_once($dir.'/../db.php');
include_once($dir.'/../token.php');

$stm_history = $_SERVER['DB']->prepare('INSERT INTO oil_user(user_id,datum,turnarounds,exports,extra_exports,pipe_barge,pipe,barge,padd_demand)
  VALUES(?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE turnarounds = VALUES(turnarounds), exports = VALUES(exports), extra_exports = VALUES(extra_exports), 
  pipe_barge = VALUES(pipe_barge), pipe = VALUES(pipe), barge = VALUES(barge), padd_demand = VALUES(padd_demand)');
$stm_forecast = $_SERVER['DB']->prepare('INSERT INTO oil_user(user_id,datum,turnarounds,yield,ethanol_blend,imports,exports,extra_exports,pipe_barge,pipe,barge,
  shipments,padd_demand,padd_demand_model,reported_us_demand,atl_stocks_over_padd)
  VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE turnarounds = VALUES(turnarounds), yield = VALUES(yield), ethanol_blend = VALUES(ethanol_blend),
  imports = VALUES(imports), exports = VALUES(exports), extra_exports = VALUES(extra_exports), pipe_barge = VALUES(pipe_barge), pipe = VALUES(pipe), barge = VALUES(barge),
  shipments = VALUES(shipments), padd_demand = VALUES(padd_demand), padd_demand_model = VALUES(padd_demand_model), reported_us_demand = VALUES(reported_us_demand),
  atl_stocks_over_padd = VALUES(atl_stocks_over_padd)');
$data = json_decode(file_get_contents('php://input'),TRUE,100,JSON_PARTIAL_OUTPUT_ON_ERROR);
if(is_array($data['history'])) foreach($data['history'] as &$row)
{
  $_SERVER['DB']->bind($stm_history,Array($_SESSION['uid'],substr($row['datum'],0,10),$row['turnarounds'],$row['exports'],$row['extra_exports'],$row['pipe_barge'],
    $row['pipe'],$row['barge'],$row['padd_demand']));
  $_SERVER['DB']->exec($stm_history);
}
if(is_array($data['forecast'])) foreach($data['forecast'] as &$row)
{
  $_SERVER['DB']->bind($stm_forecast,Array($_SESSION['uid'],substr($row['datum'],0,10),$row['turnarounds'],$row['yield'],$row['ethanol_blend'],
    $row['imports'],$row['exports'],$row['extra_exports'],$row['pipe_barge'],$row['pipe'],$row['barge'],$row['shipments'],$row['padd_demand'],
    $row['padd_demand_model'],$row['reported_us_demand'],$row['atl_stocks_over_padd']));
  $_SERVER['DB']->exec($stm_forecast);
}

echo '{"saved":true}';

?>