<?php

include __DIR__.'/../config.php';

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS `".$dataBaseName."` CHARACTER SET utf8 COLLATE utf8_general_ci;";
$conn->query($sql);
$conn->close();

define("SERVER", $servername);
define("BASE", $dataBaseName);
define("USER", $username);
define("PASS", $password);

class Database {

    public function Database() {
        $this->_conn = SPDO::getInstance();
    }

    public function select($pQry = "") {
        $pdo = SPDO::getInstance();
        try {
            $result = $pdo->query($pQry);
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
        $row = array ();
        if (!empty ($result)) {
            $row = $result->fetchAll(PDO::FETCH_ASSOC);
        }
        return $row;
    }

    public function insert($pQry = "") {
        $pdo = SPDO::getInstance();
        try {
            $result = $pdo->execute($pQry);
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }

        return $pdo->lastInsertId();
    }

    public function delete($pQry = "") {
        $pdo = SPDO::getInstance();
        try {
            $result = $pdo->execute($pQry);
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }

        return $result;
    }
}

class SPDO {

    private $PDOInstance = null;
    private static $instance = null;
    private $exception;

    private function __construct() {
        try {
            $this->PDOInstance = new PDO("mysql:host=".SERVER.";dbname=".BASE, USER, PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
        } catch (PDOException $e) {
            echo "Error connecting to MySQL!: ".$e->getMessage();
            exit();
        }
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new SPDO();
        }
        return self::$instance;
    }

    public function query($query) {
        return $this->PDOInstance->query($query);
    }

    public function prepare($query) {
        return $this->PDOInstance->prepare($query);
    }

    public function execute($query) {
        return $this->PDOInstance->exec($query);
    }

    public function lastInsertId() {
        return $this->PDOInstance->lastInsertId();
    }

    public function quote($query) {
        return $this->PDOInstance->quote($query);
    }

    public function getException() {
        return $this->exception;
    }
}

?>