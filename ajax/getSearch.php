<?php
require_once("../includes/config.php");
require_once("../includes/classes/searchResults.php");
require_once("../includes/classes/EntityProvider.php");
require_once("../includes/classes/Entity.php");
require_once("../includes/classes/PreviewProvider.php");




if(isset($_POST["term"]) && isset($_POST["email"])){
    $sr=new searchResults($con,$_POST["email"]);
    echo $sr->getResults($_POST["term"]);
}
else{
    echo "No term  or or email passed in file";
}


?>