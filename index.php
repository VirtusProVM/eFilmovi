<?php 
require_once("files/header.php");

$provider = new PreviewProvider($conn, $userLoggedIn);
echo $provider->createPreviewVideo(null);


$category = new Category($conn, $userLoggedIn);
echo $category->showAllCategories();
?>
