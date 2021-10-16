<?php  

require_once("C:/xampp/htdocs/MyNetflix/config/configFile.php");

if(isset($_POST["videoId"]) && isset($_POST["username"]) && isset($_POST["progress"])) {

	$query = $conn->prepare("UPDATE videoProgress SET progress=:progress, dateCreated=NOW() WHERE username=:username AND videoId=:videoId");
	$query->bindValue(":videoId", $_POST["videoId"]);
	$query->bindValue(":username", $_POST["username"]);
	$query->bindValue(":progress",$_POST["progress"]);

	$query->execute();

} else {
	echo "No video ID or username to show";
}
?>