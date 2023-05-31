<?php
class Video{
    private $con,$sqlData, $entity;
    public function __construct($con,$input)
    {
        $this->con=$con;

        if(is_array($input)){

            $this->sqlData=$input;
        }
        else{
            $query= $this->con->prepare("SELECT * FROM videos WHERE id=:id");
            $query->bindValue(":id",$input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
        $this->entity=new Entity($con,$this->sqlData["entityId"]);
    }

    public function getId(){
        return $this->sqlData["id"];
    }
    public function getTitle(){
        return $this->sqlData["title"];
    }
    public function getDescription(){
        return $this->sqlData["description"];
    }
    public function getFilePath(){
        return $this->sqlData["filePath"];
    }
    public function getThumbnail(){
        return $this->entity->getThumbnail();
    }
    public function getEpisodeNum(){
        return $this->sqlData["episode"];
    }
    public function getSeasonNumber(){
        return $this->sqlData["season"];
    }
    public function getEntityId(){
        return $this->sqlData["entityId"];
    }
    // count the views and show it database
    public function incrementViews(){
        $query=$this->con->prepare("UPDATE videos set views=views+1 where id=:id");
        $query->bindValue(":id",$this->getId());
        $query->execute();
    }

    public function getSeasonAndEpisode(){
        if($this->isMovie()){
            return;
        }

        $season=$this->getSeasonNumber();
        $episode=$this->getEpisodeNum();

        return "Season $season, Episode $episode";
    }

    public function isMovie(){

       return $this->sqlData["isMovie"]==1;
    }

    public function isInProgress($email){
        $query=$this->con->prepare("SELECT * FROM videoprogress 
                                    WHERE videoId=:videoId AND email=:email");

        $query->bindValue(":videoId",$this->getId());
        $query->bindValue(":email",$email);
        $query->execute();

        return $query->rowCount()!=0;

    }
    
    public function hasSeen($email){
        $query=$this->con->prepare("SELECT * FROM videoprogress 
                                  WHERE videoId=:videoId AND email=:email
                                  AND finished=1");

        $query->bindValue(":videoId",$this->getId());
        $query->bindValue(":email",$email);
        $query->execute();

        return $query->rowCount()!=0;
    }


    




}






?>



