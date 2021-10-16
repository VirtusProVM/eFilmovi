<?php 
	require_once("C:/xampp/htdocs/MyNetflix/config/configFile.php");

	if(isset($_POST["videoId"]) && isset($_POST["username"])) {

		$query = $conn->prepare("SELECT * FROM videoProgress WHERE username=:username AND videoId=:videoId");
		$query->bindValue(":username", $_POST["username"]);
		$query->bindValue(":videoId", $_POST["videoId"]);

		$query->execute();

		if($query->rowCount() == 0) {
			$query = $conn->prepare("INSERT INTO videoProgress(username, videoId) VALUES (:username, :videoId)");
			$query->bindValue(":username", $_POST["username"]);
			$query->bindValue(":videoId", $_POST["videoId"]);

			$query->execute();
		}
	} else {
		echo "No video ID or username pass in file";
	}
 ?>