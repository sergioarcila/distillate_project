<?php

$path = __DIR__.'/../';
$n = basename(__DIR__);

$nbre_dossier = 1;
$nbre_dossier = count(glob($path."/*",GLOB_ONLYDIR));
//===================================================
//===================================================

$use_proxy = "false";

// database configuration
$servername = "localhost";
$username = "root";
$password = "nTzpt.25KH";
$dataBaseName = "nymex";
$DB_tableName1 = "price_table_options";