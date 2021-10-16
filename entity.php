<?php  
require_once("files/header.php");

if(!isset($_GET["id"])) {
	ErrorMessage::show("NO ID found!!!");
}

$entityID = $_GET["id"];
$entity = new Entity($conn, $entityID);

$provider = new PreviewProvider($conn, $userLoggedIn);
echo $provider->createPreviewVideo($entity);

$seassonProvider = new SeasonProvider($conn, $userLoggedIn);
echo $seassonProvider->create($entity);

$categoryProvider = new Category($conn, $userLoggedIn);
echo $categoryProvider->showCategory($entity->getCategoryID(), "You may also like");
?>