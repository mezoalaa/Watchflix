<?php

require_once("includes/header.php");

if(!isset($_GET["id"])){
    ErrorMessage::show("No id passed in this page");
}


$preview = new PreviewProvider($con , $userLoggedIn);
echo $preview->createCategoryVideo($_GET["id"]);

$containers = new CategoryContainers($con , $userLoggedIn);
echo $containers->showCategory($_GET["id"]);


?>
