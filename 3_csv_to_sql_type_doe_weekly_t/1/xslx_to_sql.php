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

echo '<div class="jumbotron text-center">';
echo '<h2>PID = '.getmypid ().'</h2><br>';
echo '</div>';

$qry = "CREATE TABLE IF NOT EXISTS `".$DB_tableName1."` ( id INT NOT NULL AUTO_INCREMENT, `Date` date NOT NULL, `Flow_Code` int NOT NULL, `Product_Code` int NOT NULL, `Location_Code` int NOT NULL, `Volume` int NOT NULL, PRIMARY KEY (id) ) ENGINE = MYISAM DEFAULT CHARSET=utf8 ;";
$db->select($qry);

//$qry = "ALTER TABLE `".$DB_tableName1."` DROP `id`";
//$db->select($qry);
//
//$qry = "ALTER TABLE `".$DB_tableName1."` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`) ;";
//$db->select($qry);

$result_AUS = array();
$result_AUS = readCSV("../csv/doe_weekly_t.csv");

$count_line2 = 1;
$count_line2 = count($result_AUS);

echo '<br><span style="color: green">==================================</span><br>';
echo 'readCSV = '.($i+1).'<br>';
echo '$count_line2 = '.$count_line2.'<br>';

for($j=1; $j<$count_line2; $j++){

    echo $j.',';

    $Date = "";
    $Flow_Code = "";
    $Product_Code = "";
    $Location_Code = "";
    $Volume = "";

    if(!empty($result_AUS[$j][0]) and !empty($result_AUS[$j][1])){

        $Date0 = "";
        $Date0 = trim(convert_month_from_French_to_English($result_AUS[$j][0]));
        $Date0 = trim(preg_replace("/\//","-",$Date0));
        $Date = date('Y-m-d', strtotime($Date0));

        if(!empty($result_AUS[$j][1])){
            $Flow_Code = trim(preg_replace("/,/",".",trim($result_AUS[$j][1])));
        }
        if(!empty($result_AUS[$j][2])){
            $Product_Code = trim(preg_replace("/,/",".",trim($result_AUS[$j][2])));
        }
        if(!empty($result_AUS[$j][3])){
            $Location_Code = trim(preg_replace("/,/",".",trim($result_AUS[$j][3])));
        }
        if(!empty($result_AUS[$j][4])){
            $Volume = trim(preg_replace("/,/",".",trim($result_AUS[$j][4])));
        }

        $qry = "INSERT INTO `doe_db`.`doe_weekly_t` (`id`, `Date`, `Flow_Code`, `Product_Code`, `Location_Code`, `Volume`) VALUES (NULL, '".$Date."', ".$Flow_Code.", ".$Product_Code.", ".$Location_Code.", ".$Volume.");";
        $db->select($qry);

    }
}


echo '<span style="color: green"><strong><br>*****************************************************************<br>
*****************************************************************<br>
success
<br>*****************************************************************
<br>*****************************************************************<br></strong></span></div></div></body></html>';

?>


