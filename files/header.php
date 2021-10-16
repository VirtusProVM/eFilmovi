<?php  


require_once("config/configFile.php");
require_once("files/klase/PreviewProvider.php");
require_once("files/klase/Category.php");
require_once("files/klase/Entity.php");
require_once("files/klase/EntityProvider.php");
require_once("files/klase/ErrorMessage.php");
require_once("files/klase/SeasonProvider.php");
require_once("files/klase/Season.php");
require_once("files/klase/Video.php");
require_once("files/klase/VideoProvider.php");
require_once("files/klase/User.php");

if(!isset($_SESSION['userLoggedIn'])) {
	header("Location: register.php");
}

$userLoggedIn = $_SESSION['userLoggedIn'];


?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Vrleflix Movie Database</title>
	<link rel="stylesheet" type="text/css" href="files/style/vrleflix.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="files/js/script.js"></script>

</head>
<body>

	<div class="wrapper">

<?php  

if(!isset($hideNav)) {
	include_once("files/topbar.php");
}

?>
	