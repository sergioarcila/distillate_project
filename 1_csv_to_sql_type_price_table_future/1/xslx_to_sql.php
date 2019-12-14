<?php

echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<link rel="stylesheet" href="resources/bootstrap/css/bootstrap.min.css">';
echo '<script src="resources/bootstrap/js/jquery.min.js"></script>';
echo '<script src="resources/bootstrap/js/bootstrap.min.js"></script>';
echo '</head><body><div class="container"><div class="row">';

error_reporting(E_ALL ^ E_DEPRECATED);
//error_reporting(0);
//ini_set('display_errors', 0);

ini_set("memory_limit","1024M");
//set_time_limit(400);

include 'lib/Database.class.php';
$db    = new Database();

include 'config.php';
include 'function_reset.php';
include 'lib/createTableSQL.php';

$qry = "CREATE TABLE IF NOT EXISTS `".$DB_tableName1."` ( id INT NOT NULL AUTO_INCREMENT, `TradeDate` date NOT NULL, `Contractdate` date NOT NULL, `PriceCode` int NOT NULL, `SettlementPrice` float NOT NULL, `HighPrice` float NOT NULL, `LowPrice` float NOT NULL, `Volume` float NOT NULL, `OpenInterest` float NOT NULL, PRIMARY KEY (id) ) ENGINE = MYISAM DEFAULT CHARSET=utf8 ;";
$db->select($qry);

//$qry = "ALTER TABLE `".$DB_tableName1."` DROP `id`";
//$db->select($qry);
//
//$qry = "ALTER TABLE `".$DB_tableName1."` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`) ;";
//$db->select($qry);

$folder_files = "csv";

$tab = array();
$file1 = __DIR__."/../".$folder_files;

$dir = new DirectoryIterator($file1);
$count_file = 0;
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDir() && !$fileinfo->isDot()) {
        $count_file++;
    }
}

$count_line = $count_file;

//start end script
$start_line = 0;
$end_line = $count_line;

//===================================================
//===================================================

echo '<div class="jumbotron text-center">';
echo '<h2>PID = '.getmypid ().'</h2><br>';
echo '$count_line = '.$count_line.'<br>';
echo '$start_line = '.$start_line.'<br>';
echo '$end_line = '.$end_line.'<br>';
echo '</div>';

for($i=$start_line; $i<$end_line; $i++){

    $result_AUS = array();
    $result_AUS = readCSV("../".$folder_files."/".($i+1).".csv");

    $count_line2 = 1;
    $count_line2 = count($result_AUS);

    echo '<br><span style="color: green">==================================</span><br>';
    echo 'readCSV = '.($i+1).'<br>';
    echo '$count_line2 = '.$count_line2.'<br>';

    for($j=1; $j<$count_line2; $j++){

        echo $j.',';

        $TradeDate = "";
        $ContractDate = "";
        $PriceCode = "";
        $OptionTypeCode = "";
        $StrikePrice = "";
        $SettlementPrice = "";
        $HighPrice = "";
        $LowPrice = "";
        $Volume = "";
        $Previous = "";

        $TradeDate0 = "";
        $Contractdate0 = "";

        if(!empty($result_AUS[$j][0]) and !empty($result_AUS[$j][1])){

            $TradeDate = "";
            $Contractdate = "";
            $PriceCode = "";
            $SettlementPrice = "";
            $HighPrice = "";
            $LowPrice = "";
            $Volume = "";
            $OpenInterest = "";

            $TradeDate0 = trim(convert_month_from_French_to_English($result_AUS[$j][0]));
            $TradeDate0 = trim(preg_replace("/\//","-",$TradeDate0));
            $TradeDate = date('Y-m-d', strtotime($TradeDate0));

            $Contractdate0 = trim(convert_month_from_French_to_English($result_AUS[$j][1]));
            $Contractdate0 = trim(preg_replace("/\//","-",$Contractdate0));
            $Contractdate = date('Y-m-d', strtotime($Contractdate0));

            if(!empty($result_AUS[$j][2])){
                $PriceCode = trim($result_AUS[$j][2]);
            }
            if(!empty($result_AUS[$j][3])){
                $SettlementPrice = trim($result_AUS[$j][3]);
            }
            if(!empty($result_AUS[$j][4])){
                $HighPrice = trim($result_AUS[$j][4]);
            }
            if(!empty($result_AUS[$j][5])){
                $LowPrice = trim($result_AUS[$j][5]);
            }
            if(!empty($result_AUS[$j][6])){
                $Volume = trim($result_AUS[$j][6]);
            }
            if(!empty($result_AUS[$j][7])){
                $OpenInterest = trim($result_AUS[$j][7]);
            }

            $qry = "INSERT INTO `".$DB_tableName1."` (`id`, `TradeDate`, `Contractdate`, `PriceCode`, `SettlementPrice`, `HighPrice`, `LowPrice`, `Volume`, `OpenInterest`) VALUES (NULL, '".$TradeDate."', '".$Contractdate."', '".$PriceCode."', '".$SettlementPrice."', '".$HighPrice."', '".$LowPrice."', '".$Volume."', '".$OpenInterest."');";
            $db->select($qry);

        }
    }
}


echo '<span style="color: green"><strong><br>*****************************************************************<br>
*****************************************************************<br>
success
<br>*****************************************************************
<br>*****************************************************************<br></strong></span></div></div></body></html>';

?>
