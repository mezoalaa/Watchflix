<?php
class PreviewProvider{

    private $con,$email;

    public function __construct($con,$email) {
        $this->con = $con;
        $this->email = $email;
        
    }

    public function createCategoryVideo($categoryId){
        $entitiesArray = EntityProvider::getEntities($this->con,$categoryId,1);

        if(sizeof($entitiesArray)==0){
            ErrorMessage::show("No TV Shows to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }

    public function createTvShowsVideo(){
        $entitiesArray = EntityProvider::getTvShowsEntities($this->con,null,1);

        if(sizeof($entitiesArray)==0){
            ErrorMessage::show("No TV Shows to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }


    public function createMoviesPreviewVideo(){
        $entitiesArray = EntityProvider::getMoviesEntities($this->con,null,1);

        if(sizeof($entitiesArray)==0){
            ErrorMessage::show("No Movies to display");
        }

        return $this->createPreviewVideo($entitiesArray[0]);
    }

    public function createPreviewVideo($entity){
        
        if($entity == null){
            $entity = $this->getRandomEntity();
        }

        $id = $entity->getId();
        $name= $entity->getName();
        $preview = $entity->getPreview();
        $thumbnail=$entity->getThumbnail();

        // todo :add subtitle

        $videoId=VideoProvider::getEntityVideoForUser($this->con, $id, $this->email);
         // todo :add subtitle
        $video=new Video($this->con,$videoId);
        $inProgress=$video->isInProgress($this->email);
        $playButtoText=$inProgress?"Continue watching":"play";
        $seasonEpisode= $video->getSeasonAndEpisode();


        $subHeading= $video->isMovie()?"":"<h4>$seasonEpisode</h4>";


        return "<div class='previewContainer'>

                  <img src='$thumbnail' class='previewImage' hidden>

                  <video autoplay muted class ='previewVideo' onended='previewEnded()'>
                    <source src='$preview' type='video/mp4'>
                  </video>

                  <div class='previewOverlay'>
                     
                    <div class='mainDetails'>

                       <h3>$name</h3>
                        $subHeading

                       <div class='buttons'>
                          <button onclick='watchVideo($videoId)'><i class='fa-sharp fa-solid fa-circle-play'></i> $playButtoText</button>
                          <button onclick='volumeToggle(this)'><i class='fa-sharp fa-solid fa-volume-xmark'></i></button>

                       </div>


                    </div>

                   </div>



                </div>";
       




    }

    public function createEntityProviderSquare($entity){
        $id= $entity->getId();
        $thumbnail= $entity->getThumbnail();
        $name= $entity->getName();

        return "<a href='entity.php?id=$id'>
                  
                    <div class='previewContainer small'>
                        <img src='$thumbnail' title='$name'>

                    </div>
                     
 
                </a>";

                



    }



    private function getRandomEntity(){

        $entity = EntityProvider::getEntities($this->con,null,1);
        return $entity[0];

       

    }




}

?>