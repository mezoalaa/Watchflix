<?php
require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["email"]) && isset($_POST["progress"])){
    $query=$con->prepare("UPDATE videoprogress SET progress=:progress,
                          dateModified=NOW() WHERE email=:email AND videoId=:videoId");
    $query->bindValue(":email", $_POST["email"]);
    $query->bindValue(":videoId", $_POST["videoId"]);
    $query->bindValue(":progress", $_POST["progress"]);


    $query->execute();


}
else{
    echo "no videoID or or email passed in file";
}


?>