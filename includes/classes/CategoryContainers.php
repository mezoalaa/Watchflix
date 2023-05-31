<?php
class CategoryContainers{

    private $con,$email;

    public function __construct($con,$email) {
        $this->con = $con;
        $this->email = $email;
        
    }

    public function showAllCategory(){
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html= "<div class='previewCategory'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $html .=$this->getCategoryHtml($row,null,true,true);
        }

        return $html . "</div>";
    }

    public function showTVShowsCategory(){
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html= "<div class='previewCategory'>
                   <h1>TV Shows</h1>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $html .=$this->getCategoryHtml($row,null,true,false);
        }

        return $html . "</div>";
    }


    
    public function showMoviesCategory(){
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html= "<div class='previewCategory'>
                   <h1>Movies</h1>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $html .=$this->getCategoryHtml($row,null,false,true);
        }

        return $html . "</div>";
    }



    // show categoryid like (4,"sdfsdfsdafsd") or (4)
    public function showCategory($categoryId,$title=null){
        $query = $this->con->prepare("SELECT * FROM categories WHERE id=:id");
        $query->bindValue(":id", $categoryId);
        $query->execute();

        $html= "<div class='previewCategories noScroll'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $html .=$this->getCategoryHtml($row,$title,true,true);
        }

        return $html . "</div>";

    }

    private function getCategoryHtml($sqlData,$title,$tvShows,$movies ){

        $categoryId= $sqlData["id"];
        //put the name of title on title if passed in , if not use sqldata or title
        $title = $title==null ? $sqlData["name"] : $title;

        if($tvShows && $movies){
            $entities = EntityProvider::getEntities($this->con,$categoryId,20);
        }
        else if($tvShows){
            //Get tv shows entities 
            $entities = EntityProvider::getTVShowsEntities($this->con,$categoryId,20);
        }
        else {
            //Get movie entities 

            $entities = EntityProvider::getMoviesEntities($this->con,$categoryId,20);

        }

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
                   <a href='category.php?id=$categoryId'>
                      <h3>$title</h3>
                   </a>

                   <div class='entities'>
                       $entitiesHtml
                   </div>

                </div>";


 
    }

    // private function getCategoryrecent($sqlData,$title,$tvShows,$movies,"categories" ){}

   
    

}

?>