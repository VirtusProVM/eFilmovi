<?php 
require_once("files/header.php");

$provider = new PreviewProvider($conn, $userLoggedIn);
echo $provider->createTVShowPreviewVideo();


$category = new Category($conn, $userLoggedIn);
echo $category->showTVShowsCategory();
?>