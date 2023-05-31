<?php
class VideoProvider{
    public static function getUpNext($con,$currentVideo){
        $query=$con->prepare("SELECT * FROM videos
                             WHERE entityId=:entityId and id !=:videoId
                             AND (
                                (season =:season and episode > :episode)OR season > :season
                             )
                             ORDER BY season,episode ASC LIMIT 1");
        $query->bindValue(":entityId" ,$currentVideo->getEntityId());
        $query->bindValue(":season" ,$currentVideo->getSeasonNumber());
        $query->bindValue(":episode" ,$currentVideo->getEpisodeNum());
        $query->bindValue(":videoId" ,$currentVideo->getId());

        $query->execute();

        if($query->rowCount()==0){
            $query=$con->prepare("SELECT * FROM videos
                                 where season <=1 and episode <=1
                                 and id != :videoId
                                 order by views desc limit 1");
            $query->bindValue(":videoId", $currentVideo->getId());
            $query->execute();


        }
        $row=$query->fetch(PDO::FETCH_ASSOC);
        return new Video($con,$row);


    }

    public static function getEntityVideoForUser($con,$entityId,$email){
        $query= $con->prepare("SELECT videoId FROM videoprogress inner JOIN videos
                               on videoprogress.videoId=videos.id
                               WHERE videos.entityId=:entityId
                               and videoprogress.email=:email
                               ORDER BY videoprogress.dateModified DESC 
                               LIMIT 1");

        $query->bindValue(":entityId",$entityId);
        $query->bindValue(":email",$email);
        $query->execute();

        if($query->rowCount()==0){
            $query=$con->prepare("SELECT id FROM videos 
                                 WHERE entityId=:entityId 
                                 ORDER BY season,episode ASC LIMIT 1");
            $query->bindValue(":entityId",$entityId);
            $query->execute();
        }
        return $query->fetchColumn();

    }


    public static function getEntityVideoForRec($con,$categoryId,$email){
        $query= $con->prepare("SELECT finished FROM `videoprogress` INNER JOIN categories
                              ON videoprogress.videoId=videoprogress.videoId 
                              ORDER by videoprogress.dateModified");


        $query->bindValue(":categoryId",$categoryId);
        $query->bindValue(":email",$email);
         $query->execute();










    }








    
}

?>