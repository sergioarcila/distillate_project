<?php
header('Content-Type: application/json');

$DBHost='173.255.233.251';
$DBName='nymex';
$DBUser= 'root';
$DBPassword='nTzpt.25KH';
require("PDO.class.php");
$db = new Db($DBHost, $DBName, $DBUser, $DBPassword);

$qry = "SELECT DISTINCT(TradeDate) AS TradeDate FROM price_table_future ORDER BY TradeDate DESC";
$tab = $db->query($qry);

for($i=0;$i<count($tab);$i++){
	$qry = "SELECT * FROM price_table_future  WHERE TradeDate = '".$tab[$i]['TradeDate']."' ORDER BY ContractDate ASC";
	$tab1 = $db->query($qry);
	
	
	$qry = "SELECT * FROM price_first_future  WHERE TradeDate = '".$tab1[0]['TradeDate']."' AND  PriceCode = '".$tab1[0]['PriceCode']."'  AND  ContractDate = '".$tab1[0]['ContractDate']."'";
	$tab1 = $db->query($qry);
 
	if(count($tab1)==0){
		$qry = "INSERT INTO `price_first_future`(`id`, `TradeDate`, `ContractDate`, `PriceCode` ) VALUES (NULL,'".$tab1[0]['TradeDate']."','".$tab1[0]['ContractDate']."','".$tab1[0]['PriceCode']."')";
		$db->query($qry);
	} 
}

/*
if(isset($_GET['type']) and !empty($_GET['type'])){
$type = trim($_GET['type']);
if($type == 'future'){
		
if(isset($_GET['trade_date']) and !empty($_GET['trade_date'])){
			
$tradeDate = trim($_GET['trade_date']);
 
if(isset($_GET['price_code']) and !empty($_GET['price_code'])){
				
$PriceCode = trim($_GET['price_code']);
 
$county_scraped = "";
$qry = "SELECT * FROM `price_table_future` WHERE TradeDate = '".$tradeDate."' AND 	PriceCode = '".$PriceCode."' ORDER BY Contractdate asc;";
$tab = $db->query($qry);
	

echo json_encode($tab[0]);
}
}
}
	 

}
*/
 


?>