<?php

function save_File_From_ftp($url_ftp, $name_file, $dir_file){

    if(!file_exists($dir_file)){
        mkdir($dir_file);
    }
    //create a new file where its contents will be dumped
    $fp = fopen (dirname(__FILE__) . '/'.$dir_file.'/'.$name_file, 'w+');

    //Here is the file we are downloading, replace spaces with %20
    $ch = curl_init(str_replace(" ","%20",$url_ftp));

    curl_setopt($ch, CURLOPT_TIMEOUT, 50);
    //disable ssl cert verification to allow copying files from HTTPS NB: you can always fix your php 'curl.cainfo' setting so yo dont have to disable this
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // write curl response to file
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    // get curl response
    $exec = curl_exec($ch);

    curl_close($ch);
    fclose($fp);
    if($exec == true){
        $returnData[0] = true;
    }else{
        $returnData[0] =false;
    }
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
        $res[$i] = fgetcsv($file,0,",");
        $i++;
    }
    fclose($file);
    return $res;
}

function addScheme($scheme ,$url){
    return parse_url($url, PHP_URL_SCHEME) === null ?
        $scheme . $url : $url;
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

function check_element_in_TABLE1($element_name, $element_value, $DB_tableName1, $db){
    $element_exist = 'false';
    $qry = "SELECT COUNT(*) as nb FROM  `".$DB_tableName1."` WHERE `".$element_name."` =  '".mysql_escape_string($element_value)."'";
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

?>