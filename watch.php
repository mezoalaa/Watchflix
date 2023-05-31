<?php
$hideNav=true;
require_once("includes/header.php");


if(!isset($_GET["id"])){
    ErrorMessage::show("No id passed into page");
}

$user=new User($con,$userLoggedIn);
if(!$user->getSubscribed()){
    ErrorMessage::show("You must be subscribed to continue watching .. don't go to egybest
                       <a href='Profile.php'>Click here to subscribe it's very cheap</a>");
}

$video=new Video($con,$_GET["id"]);
$video->incrementViews();

$upNextVideo = VideoProvider::getUpNext($con,$video);

?>

<div class="watchContainer">

   <div class="videoControls watchNav">

       <button onclick="goBack()"><i class="fa-solid fa-arrow-left"></i></button>
       <h1><?php echo $video->getTitle();?> </h1>



   </div>

   <div class="videoControls upNext" style="display: none;">

       <button onclick="restartVideo();"><i class="fa-solid fa-redo"></i></button>
       <div class="upNextContainer">
          <h2>Up next</h2>
          <h3><?php echo $upNextVideo->getTitle(); ?></h3>
          <h3><?php echo $upNextVideo->getSeasonAndEpisode(); ?></h3>

          <button class="playNext" onclick="watchVideo(<?php echo $upNextVideo->getId(); ?>)">
          <i class="fa-solid fa-play"></i> Play
          </button>

        </div>



   </div>








    <video controls autoplay onended="showUpNext()">
        <source src="<?php echo $video->getFilePath();?>" tybe="video/mp4">

    
    </video>


</div>
<!-- for keeping the progress for the video  -->

<script>

   initVideo("<?php echo $video->getId(); ?>","<?php echo $userLoggedIn; ?>");

</script>