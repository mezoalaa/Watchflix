<?php
require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["email"])){
    $query=$con->prepare("SELECT * FROM videoprogress 
                          WHERE email=:email AND videoId=:videoId");
    $query->bindValue(":email", $_POST["email"]);
    $query->bindValue(":videoId", $_POST["videoId"]);

    $query->execute();

    if($query->rowCount() == 0){
        
        $query=$con->prepare("INSERT INTO videoprogress (email , videoId)
                             Value(:email, :videoId)");

        $query->bindValue(":email", $_POST["email"]);
        $query->bindValue(":videoId", $_POST["videoId"]);

        $query->execute();

    }


}
else{
    echo "no videoID or or email passed in file";
}


?>