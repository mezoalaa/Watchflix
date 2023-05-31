<?php
require_once("includes/config.php");
require_once("includes/classes/PreviewProvider.php");
require_once("includes/classes/Entity.php");
require_once("includes/classes/CategoryContainers.php");
require_once("includes/classes/EntityProvider.php");
require_once("includes/classes/ErrorMessage.php");
require_once("includes/classes/SeasonProvider.php");
require_once("includes/classes/Season.php");
require_once("includes/classes/Video.php");
require_once("includes/classes/VideoProvider.php");
require_once("includes/classes/User.php");







if(!isset($_SESSION["userLoggedIn"])){
    // header("location:re");
    
}

$user=array('userLoggedIn' =>'');

$userLoggedIn = $_SESSION["userLoggedIn"];

?>

<!DOCTYPE html>
<html> 
    <head>
        <title> Welcome to Watchflix </title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css">

        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>



        <script src="https://kit.fontawesome.com/2007184339.js" crossorigin="anonymous"></script>
        <script src="assets/js/script.js"></script>
    </head>
    <body>
        <div class="wrapper">

<?php
if(!isset($hideNav)){
    include_once("includes/navBar.php");
}
?>