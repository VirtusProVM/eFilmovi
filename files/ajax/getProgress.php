<?php  

require_once("C:/xampp/htdocs/MyNetflix/config/configFile.php");

if(isset($_POST["videoId"]) && isset($_POST["username"])) {

	$query = $conn->prepare("SELECT progress FROM videoProgress WHERE username=:username AND videoId=:videoId");
	$query->bindValue(":username", $_POST["username"]);
	$query->bindValue(":videoId", $_POST["videoId"]);
	$query->execute();
	echo $query->fetchColumn();

} else {
	echo "Video ID or username are not correct";
}

?>