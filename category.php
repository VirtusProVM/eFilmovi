<?php 
require_once("files/header.php");

if(!isset($_GET["id"])) {
	ErrorMessage::show("No ID passed to page");
}

$provider = new PreviewProvider($conn, $userLoggedIn);
echo $provider->createCategoryPreviewVideo($_GET["id"]);


$category = new Category($conn, $userLoggedIn);
echo $category->showCategory($_GET["id"]);
?>