<?php  
ob_start();
session_start();

date_default_timezone_set("Europe/Belgrade");

try {
	$conn = new PDO("mysql:dbname=vrleflix;host=localhost", "root", "");
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

} catch(PDOException $ex) {
	exit("Connection Failed: " . $ex->getMessage());
}

?>