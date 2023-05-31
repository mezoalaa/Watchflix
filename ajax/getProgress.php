<?php
require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["email"])){
    $query=$con->prepare("SELECT progress FROM videoprogress 
                          WHERE email=:email AND videoId=:videoId");
    $query->bindValue(":email", $_POST["email"]);
    $query->bindValue(":videoId", $_POST["videoId"]);


    $query->execute();
    // return 1 value 
    echo $query->fetchColumn();


}
else{
    echo "no videoID or or email passed in file";
}


?>