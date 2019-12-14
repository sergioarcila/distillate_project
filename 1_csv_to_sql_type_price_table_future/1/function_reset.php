<?php

function convert_month_from_French_to_English($date){

    if(preg_match('/janv/i',$date)){
        $date = trim(preg_replace('/janv/i','Jan',$date));

    }elseif(preg_match('/f.{1}vr/i',$date)){
        $date = trim(preg_replace('/f.{1}vr/i','Feb',$date));

    }elseif(preg_match('/mars?/i',$date)){
        $date = trim(preg_replace('/mars?/i','Mar',$date));

    }elseif(preg_match('/avril|avr/i',$date)){
        $date = trim(preg_replace('/avril|avr/i','Apr',$date));

    }elseif(preg_match('/mai/i',$date)){
        $date = trim(preg_replace('/mai/i','May',$date));

    }elseif(preg_match('/juin/i',$date)){
        $date = trim(preg_replace('/juin/i','Jun',$date));

    }elseif(preg_match('/juil/i',$date)){
        $date = trim(preg_replace('/juil/i','Jul',$date));

    }elseif(preg_match('/ao.{1}t/i',$date)){
        $date = trim(preg_replace('/ao.{1}t/i','Aug',$date));

    }elseif(preg_match('/sept/i',$date)){
        $date = trim(preg_replace('/sept/i','Sep',$date));

    }elseif(preg_match('/oct/i',$date)){
        $date = trim(preg_replace('/oct/i','Oct',$date));

    }elseif(preg_match('/nov/i',$date)){
        $date = trim(preg_replace('/nov/i','Nov',$date));
    }

    elseif(preg_match('/d.{1}c/i',$date)){
        $date = trim(preg_replace('/d.{1}c/i','Dec',$date));
    }

    return $date;

}

function readXLSX($pathXLSX){
    include 'lib/simplexlsx.class.php';
    $xlsx = new SimpleXLSX($pathXLSX);
    $res = array();
    $res = $xlsx->rows();
    return $res;
}

function readTXT($pathTXT){
    $lines = file($pathTXT);
    $i=0;
    $res=array();
    foreach($lines as $line_num => $line){
        $res[$i] = $line;
        $i++;
    }
    return $res;
}

function readCSV($pathCSV){
    $file = fopen($pathCSV,"r");
    $res = array();
    $i = 0;
    while(!feof($file)){
        $res[$i] = fgetcsv($file,0,";");
        $i++;
    }
    fclose($file);
    return $res;
}

function addScheme($scheme ,$url){
    return parse_url($url, PHP_URL_SCHEME) === null ?
        $scheme . $url : $url;
}

function check_element_in_TABLE1($element_name, $element_value, $DB_tableName1, $db){
    $element_exist = 'false';
    $qry = "SELECT ". $element_name ." FROM `" . $DB_tableName1 . "` WHERE `". $element_name ."` LIKE '". $element_value ."' ";
    $tab = $db->select($qry);
    if(count($tab)>0){
        $element_exist = 'true';
    }
    return $element_exist;
}

function check_all_row_in_TABLE1($NameFieldTable1, $ValueFieldTable1, $DB_tableName1, $db){

    $element_exist = 'false';

    $str_qry = "";
    for($f=0; $f<count($NameFieldTable1); $f++){
        $str_qry = $str_qry." and "."`".$NameFieldTable1[$f]."` LIKE '".mysql_escape_string($ValueFieldTable1[$f])."'" ;
    }
    $str_qry = trim(preg_replace('/^and/','',trim($str_qry)));

    $qry = "SELECT COUNT(*) as nb FROM  `".$DB_tableName1."` WHERE ".$str_qry;
    $count_table = $db->select($qry);
    $nbre_lignes = 0;
    if(!empty($count_table[0]['nb'])){
        $nbre_lignes = $count_table[0]['nb'];
        if($nbre_lignes>0){
            $element_exist = 'true';
        }
    }
    return $element_exist;
}

function get_count_line_table($DB_tableName1, $db){
    $qry1 = "SELECT COUNT(*) as nb FROM `".$DB_tableName1."`";
    $count_table1 = $db->select($qry1);
    $count_line1 = 0;
    if(!empty($count_table1[0]['nb'])){
        $count_line1 = (int) intval($count_table1[0]['nb']);
    }
    return $count_line1;
}

function get_all_table_counties($match, $dataBaseName,$db){
    $qry = "SHOW TABLES FROM `".$dataBaseName."` WHERE `Tables_in_".$dataBaseName."` LIKE '%".$match."_%'";
    $tab = array_column($db->select($qry), 'Tables_in_'.$dataBaseName);
    return $tab;
}

function DropTable($DB_tableName2, $db){
    $qry = "DROP TABLE IF EXISTS `".$DB_tableName2."`";
    $db->select($qry);
}

function creatTable_set_time_counties_scrape($DB_tableName2, $db){
    $NameFieldTable1 = array('county_scraped', 'county_name', 'county_url', 'amazon_date_YMD', 'amazon_timestamp', 'begin_county_script', 'end_county_script','total_updated_properties');
    creatTable($NameFieldTable1, $DB_tableName2, $db);
}

?>