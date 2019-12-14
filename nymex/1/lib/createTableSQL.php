<?php

function creatTable($NameFieldTable1, $DB_tableName1, $db){
    $str_qry = "";
    for($f=0; $f<count($NameFieldTable1); $f++){
        $str_qry = $str_qry.' `'.$NameFieldTable1[$f].'` text NOT NULL,';
    }
    $qry = "CREATE TABLE IF NOT EXISTS `".$DB_tableName1."` (
	id INT NOT NULL AUTO_INCREMENT,".$str_qry
        ."PRIMARY KEY (id) ) ENGINE = MYISAM DEFAULT CHARSET=utf8 ;";
    $db->select($qry);
}

function insertTable($NameFieldTable1, $ValueFieldTable1, $DB_tableName1, $db){
    $str_qry = "";
    for($f=0; $f<count($NameFieldTable1); $f++){
        $str_qry = $str_qry.' `'.$NameFieldTable1[$f].'`,';
    }
    $str_qry = trim(preg_replace('/,$/','',trim($str_qry)));

    $str_qry_value = "";
    for($f=0; $f<count($ValueFieldTable1); $f++){
        $str_qry_value = $str_qry_value.' \''.mysql_escape_string($ValueFieldTable1[$f]).'\', ';
    }
    $str_qry_value = trim(preg_replace('/,$/',');',trim($str_qry_value)));
    $str_qry_value = "INSERT INTO `".$DB_tableName1."`(`id`, ".$str_qry.") VALUES (NULL,".$str_qry_value;
    $db->insert($str_qry_value);

}

?>