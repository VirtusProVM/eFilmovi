<?php  
require_once("C:/xampp/htdocs/MyNetflix/config/configFile.php");
require_once("C:/xampp/htdocs/MyNetflix/files/klase/SearchResultsProvider.php");
require_once("C:/xampp/htdocs/MyNetflix/files/klase/EntityProvider.php");
require_once("C:/xampp/htdocs/MyNetflix/files/klase/Entity.php");
require_once("C:/xampp/htdocs/MyNetflix/files/klase/PreviewProvider.php");

if(isset($_POST["term"]) && isset($_POST["username"])) {
	$srp = new SearchResultsProvider($conn, $_POST["username"]);
	echo $srp->getResults($_POST["term"]);
} else {
	echo "Np term or username passed into file";
}
?>