<?php
class SeasonProvider{
    private $con,$email;

    public function __construct($con,$email) {
        $this->con = $con;
        $this->email = $email;
        
    }
    public function create($entity){
        $seasons=$entity->getseason();

        if(sizeof($seasons)==0){
            return;

        }
        $seasonHtml="";
        foreach($seasons as $season){
            $seasonNumber= $season->getSeasonNumber() ;

            $videoHtml="";
            foreach($season->getVideos() as $video){
                $videoHtml.=$this->createVideoSquare($video);
            }

            $seasonHtml .= "<div class='season'>
                                 <h3>Season $seasonNumber</h3>
                                 <div class='videos'>
                                     $videoHtml
                                 </div>
                              </div>";
        }
        return $seasonHtml;
 
    }
    private function createVideoSquare($video){
        $id=$video->getId();
        $thumbnail=$video->getThumbnail();
        $name=$video->getTitle();
        $description=$video->getDescription();
        $episodeNumber=$video->getEpisodeNum();
        $hasSeen=$video->hasSeen($this->email)?"<i class='fa-regular fa-circle-check seen'></i>":"";


       return "<a href='watch.php?id=$id'>
                  <div class='episodeContainer'>
                        <div class='contents'>
                              
                            <img src='$thumbnail'>

                            <div class='videoInfo'>

                                <h4>$episodeNumber. $name</h4>
                                <span>$description</span>
 
                            </div>

                            $hasSeen

                        </div>
                   </div>
                </a>";
    }


}

?>