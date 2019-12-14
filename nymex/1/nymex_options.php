<?php
error_reporting(E_ALL ^ E_DEPRECATED);
//error_reporting(0);
//ini_set('display_errors', 0);

ini_set('max_execution_time', 0);
ini_set("memory_limit","1024M");
//set_time_limit(400);

include 'lib/Database.class.php';
$db    = new Database();

include 'config.php';
include 'lib/simple_html_dom.php';
include 'lib/cURL.php';
include 'lib/http_connection.php';
include 'function_aux.php';
include 'lib/createTableSQL.php';

$html1 = new simple_html_dom();
$html2 = new simple_html_dom();
$html3 = new simple_html_dom();
$html4 = new simple_html_dom();
$html5 = new simple_html_dom();

$qry = "CREATE TABLE IF NOT EXISTS `".$DB_tableName2."` ( id INT NOT NULL AUTO_INCREMENT, `TradeDate` date NOT NULL, `Contractdate` date NOT NULL, `PriceCode` int NOT NULL, `OptionTypeCode` varchar(20)	NOT NULL, `StrikePrice` float NOT NULL, `SettlementPrice` float NOT NULL, `HighPrice` float NOT NULL, `LowPrice` float NOT NULL, `Volume` float NOT NULL, `Previous` float NOT NULL, PRIMARY KEY (id) ) ENGINE = MYISAM DEFAULT CHARSET=utf8 ;";
$db->select($qry);

$url_ftp = 'ftp://ftp.cmegroup.com/settle/nymex_option.csv';
$name_file = 'nymex_option.csv';
$dir_file = 'csv';
save_File_From_ftp($url_ftp, $name_file, $dir_file);

$result_AUS = array();
$result_AUS = readCSV($dir_file.'/'.$name_file);
//echo '<pre>'; print_r($result_AUS);

for($a=1; $a<count($result_AUS); $a++){

    $PRODUCT_SYMBOL = "";
    $CONTRACT_MONTH = "";
    $CONTRACT_YEAR = "";
    $CONTRACT_DAY = "01";
    $PUT_CALL = "";
    $STRIKE = "";
    $CONTRACT = "";
    $PRODUCT_DESCRIPTION = "";
    $OPEN = "";
    $HIGH = "";
    $HIGH_AB_INDICATOR = "";
    $LOW = "";
    $LOW_AB_INDICATOR = "";
    $LAST = "";
    $LAST_AB_INDICATOR = "";
    $SETTLE = "";
    $PT_CHG = "";
    $EST_VOL = "";
    $PRIOR_SETTLE = "";
    $PRIOR_VOL = "";
    $PRIOR_INT = "";
    $TRADEDATE = "";

    if(!empty($result_AUS[$a][0])){
        $PRODUCT_SYMBOL = trim($result_AUS[$a][0]);
    }
    if(!empty($result_AUS[$a][1])){
        $CONTRACT_MONTH = trim($result_AUS[$a][1]);
    }
    if(!empty($result_AUS[$a][2])){
        $CONTRACT_YEAR = trim($result_AUS[$a][2]);
    }
    if(!empty($result_AUS[$a][3])){
        $CONTRACT_DAY = trim($result_AUS[$a][3]);
    }
    if(!empty($result_AUS[$a][4])){
        $PUT_CALL = trim($result_AUS[$a][4]);
    }
    if(!empty($result_AUS[$a][5])){
        $STRIKE = trim($result_AUS[$a][5]);
    }
    if(!empty($result_AUS[$a][6])){
        $CONTRACT = trim($result_AUS[$a][6]);
    }
    if(!empty($result_AUS[$a][7])){
        $PRODUCT_DESCRIPTION = trim($result_AUS[$a][7]);
    }
    if(!empty($result_AUS[$a][8])){
        $OPEN = trim($result_AUS[$a][8]);
    }
    if(!empty($result_AUS[$a][9])){
        $HIGH = trim($result_AUS[$a][9]);
    }
    if(!empty($result_AUS[$a][10])){
        $HIGH_AB_INDICATOR = trim($result_AUS[$a][10]);
    }
    if(!empty($result_AUS[$a][11])){
        $LOW = trim($result_AUS[$a][11]);
    }
    if(!empty($result_AUS[$a][12])){
        $LOW_AB_INDICATOR = trim($result_AUS[$a][12]);
    }
    if(!empty($result_AUS[$a][13])){
        $LAST = trim($result_AUS[$a][13]);
    }
    if(!empty($result_AUS[$a][14])){
        $LAST_AB_INDICATOR = trim($result_AUS[$a][14]);
    }
    if(!empty($result_AUS[$a][15])){
        $SETTLE = trim($result_AUS[$a][15]);
    }
    if(!empty($result_AUS[$a][16])){
        $PT_CHG = trim($result_AUS[$a][16]);
    }
    if(!empty($result_AUS[$a][17])){
        $EST_VOL = trim($result_AUS[$a][17]);
    }
    if(!empty($result_AUS[$a][18])){
        $PRIOR_SETTLE = trim($result_AUS[$a][18]);
    }
    if(!empty($result_AUS[$a][19])){
        $PRIOR_VOL = trim($result_AUS[$a][19]);
    }
    if(!empty($result_AUS[$a][20])){
        $PRIOR_INT = trim($result_AUS[$a][20]);
    }
    if(!empty($result_AUS[$a][21])){
        $TRADEDATE = trim($result_AUS[$a][21]);
    }

    $TradeDate = "";
    $Contractdate = "";
    $PriceCode = 0;
    $OptionTypeCode = "";
    $StrikePrice = 0;
    $SettlementPrice = 0;
    $HighPrice = 0;
    $LowPrice = 0;
    $Volume = 0;
    $Previous = 0;

    $TradeDate = date('Y-m-d', strtotime($TRADEDATE));
    $Contractdate = date('Y-m-d', strtotime($CONTRACT_YEAR.'/'.$CONTRACT_MONTH.'/'.$CONTRACT_DAY));

    if($PRODUCT_SYMBOL == "OH"){
        $PriceCode = 3;
    }
    if($PRODUCT_SYMBOL == "OB"){
        $PriceCode = 4;
    }
    if($PRODUCT_SYMBOL == "LO"){
        $PriceCode = 1;
    }
    if($PUT_CALL == "C"){
        $OptionTypeCode = 1;
    }
    if($PUT_CALL == "P"){
        $OptionTypeCode = 2;
    }
    $StrikePrice = (float) $STRIKE;
    $SettlementPrice = (float) $SETTLE;
    $HighPrice = (float) $HIGH;
    $LowPrice = $LOW;
    $Volume = $EST_VOL;
    $Previous = $PRIOR_SETTLE;

    if($PRODUCT_SYMBOL == "OH" || $PRODUCT_SYMBOL == "OB" ||  $PRODUCT_SYMBOL == "LO"){

        echo ($a+1).' / '.count($result_AUS).' >> $PRODUCT_SYMBOL ='.$PRODUCT_SYMBOL.'<br>';

        $NameFieldTable1 = array('TradeDate', 'Contractdate', 'PriceCode', 'OptionTypeCode', 'StrikePrice', 'SettlementPrice', 'HighPrice', 'LowPrice', 'Volume', 'Previous');
        $ValueFieldTable1 = array($TradeDate,$Contractdate,$PriceCode,$OptionTypeCode,$StrikePrice,$SettlementPrice,$HighPrice,$LowPrice,$Volume,$Previous);
        $element_exist = check_all_row_in_TABLE1($NameFieldTable1, $ValueFieldTable1, $DB_tableName2, $db);
        if($element_exist == "false"){
            insertTable($NameFieldTable1, $ValueFieldTable1, $DB_tableName2, $db);
        }
    }
}

echo '<span style="color: green"><strong><br>*****************************************************************<br>
*****************************************************************<br>
success
<br>*****************************************************************
<br>*****************************************************************<br></strong></span></div></div></body></html>';

?>