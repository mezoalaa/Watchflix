<?php
require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["email"])){
    $query=$con->prepare("UPDATE videoprogress SET finished=1, progress=0
                          WHERE email=:email AND videoId=:videoId");
    $query->bindValue(":email", $_POST["email"]);
    $query->bindValue(":videoId", $_POST["videoId"]);


    $query->execute();


}
else{
    echo "no videoID or or email passed in file";
}


?>