<?php

require_once("includes/header.php");


if(!isset($userLoggedIn)){
    header("location:/login.php");
}

$preview = new PreviewProvider($con , $userLoggedIn);
echo $preview->createPreviewVideo(null);

$containers = new CategoryContainers($con , $userLoggedIn);
echo $containers->showAllCategory();


?>


