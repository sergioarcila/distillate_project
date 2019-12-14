<?php 
$dir = dirname(__FILE__);
include_once($dir.'/../util.php');
include_once($dir.'/../db.php');
include_once($dir.'/../token.php');
ini_set('zlib.output_compression', 1);

$res = $_SERVER['DB']->query('SELECT gas.datum < current_date AS history,gas.datum,COALESCE(turnarounds,0) AS turnarounds,runs,COALESCE(yield,0) AS yield,
  ethanol_input,COALESCE(ethanol_blend,0) AS ethanol_blend,COALESCE(gas.imports,gas_user.imports,0) AS imports,COALESCE(exports,0) AS exports,COALESCE(extra_exports,0) AS extra_exports,
  COALESCE(pipe_barge,0) AS pipe_barge,COALESCE(pipe,0) AS pipe,COALESCE(barge,0) AS barge,COALESCE(shipments,0) AS shipments,COALESCE(padd_demand,0) AS padd_demand,
  COALESCE(gas.reported_us_demand,gas_user.reported_us_demand,0) AS reported_us_demand,stocks,atl_stocks,COALESCE(atl_stocks_over_padd,0) AS atl_stocks_over_padd,
  COALESCE(padd_demand_model,0) AS padd_demand_model,yield_fin_stock,yield_blend_stock,yield_import,yield_export,yield_blend,yield_ethanol,yield_receipts,yield_output,yield_crude_input
  FROM gas LEFT JOIN gas_user ON gas.datum = gas_user.datum AND user_id = '.(int)$_SESSION['uid'].'
  UNION
  SELECT gas_user.datum < current_date AS history,gas_user.datum,COALESCE(turnarounds,0) AS turnarounds,runs,COALESCE(yield,0) AS yield,
  ethanol_input,COALESCE(ethanol_blend,0) AS ethanol_blend,COALESCE(gas.imports,gas_user.imports,0) AS imports,COALESCE(exports,0) AS exports,COALESCE(extra_exports,0) AS extra_exports,
  COALESCE(pipe_barge,0) AS pipe_barge,COALESCE(pipe,0) AS pipe,COALESCE(barge,0) AS barge,COALESCE(shipments,0) AS shipments,COALESCE(padd_demand,0) AS padd_demand,
  COALESCE(gas.reported_us_demand,gas_user.reported_us_demand,0) AS reported_us_demand,stocks,atl_stocks,COALESCE(atl_stocks_over_padd,0) AS atl_stocks_over_padd,
  padd_demand_model,COALESCE(yield_fin_stock,0) AS yield_fin_stock,COALESCE(yield_blend_stock,0) AS yield_blend_stock,COALESCE(yield_import,0) AS yield_import,
  COALESCE(yield_export,0) AS yield_export,COALESCE(yield_blend,0) AS yield_blend,COALESCE(yield_ethanol,0) AS yield_ethanol,COALESCE(yield_receipts,0) AS yield_receipts,
  COALESCE(yield_output,0) AS yield_output,COALESCE(yield_crude_input,0) AS yield_crude_input
  FROM gas RIGHT JOIN gas_user ON gas.datum = gas_user.datum AND user_id = '.(int)$_SESSION['uid']);
$info = Array('history'=>Array(), 'forecast'=>Array());
while($row = mysqli_fetch_assoc($res)) 
{
  if($row['history']) $info['history'][] = $row;
    else $info['forecast'][] = $row;
}
echo json_encode($info,JSON_NUMERIC_CHECK);

?>