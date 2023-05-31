<?php
class searchResults{
    private $con , $email;

    public function __construct($con,$email)
    {
        $this->con=$con;
        $this->email=$email;

        
    }

    public function getResults($inputText){
        $entities=EntityProvider::getSearchEntities($this->con,$inputText);
        $html= "<div class='previewCategories noScroll'>";

        $html.=$this->getResultsHtml($entities);

        return $html . "</div>";
    }

    private function getResultsHtml($entities){
        if(sizeof($entities)==0){
            return;
        }

        $entitiesHtml = "";
        $previewProvider=new previewProvider($this->con, $this-> email);
       // loop for every item in the array
        foreach($entities as $entity){
            $entitiesHtml .=  $previewProvider->createEntityProviderSquare($entity);
        }


        return "<div class category>


                   <div class='entities'>
                       $entitiesHtml
                   </div>

                </div>";
    }
}
?>