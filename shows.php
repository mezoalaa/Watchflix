<?php

require_once("includes/header.php");


$preview = new PreviewProvider($con , $userLoggedIn);
echo $preview->createTvShowsVideo();

$containers = new CategoryContainers($con , $userLoggedIn);
echo $containers->showTVShowsCategory();


?>


