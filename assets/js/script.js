$(document).scroll(function(){
    var isScrolled= $(this).scrollTop()> $(".topBar").height()
    $(".topBar").toggleClass("scrolled",isScrolled)
});

function volumeToggle(button){
    var muted = $(".previewVideo").prop("muted");
    $(".previewVideo").prop("muted",!muted);


    $(button).find("i").toggleClass("fa-sharp fa-solid fa-volume-xmark");
    $(button).find("i").toggleClass("fa-solid fa-volume-high");


}

function previewEnded(){
    $(".previewVideo").toggle();
    $(".previewImage").toggle();

}
// play on button go back of the video
function goBack(){
    window.history.back();

}

function startHideTimer(){
    var timeout=null;

    $(document).on("mousemove", function(){
        clearTimeout(timeout);
        $(".watchNav").fadeIn();
        timeout=setTimeout(function(){
            $(".watchNav").fadeOut();

        },400);
    })
}

//for keeping the progress for the video 
function initVideo(videoId,email){
    startHideTimer();
    // console.log(videoId);
    // console.log(email);
    setStartTime(videoId,email);
    updateProgressTimer(videoId,email);
}
function updateProgressTimer(videoId,email){
    addDuration(videoId,email);

    var timer;

    $("video").on("playing" , function(event){
        window.clearInterval(timer);
        timer=window.setInterval(function(){

            updateProgress(videoId,email,event.target.currentTime)
        },1000 );
    })
    .on("ended",function(){
        setFinished(videoId,email);
        window.clearInterval(timer);
    })
}

function addDuration(videoId,email){
    $.post("ajax/addDuration.php",{ videoId:videoId, email:email}, function(data){
        if(data !==null && data !==""){
            alert(data);
        }


    })
}

function updateProgress(videoId,email,progress){
    $.post("ajax/updateDuration.php",{ videoId: videoId, email: email,progress: progress}, function(data){
        if(data !==null && data !==""){
            alert(data);
        }


    })
}

function setFinished(videoId,email){
    $.post("ajax/setFinished.php",{ videoId: videoId, email: email}, function(data){
        if(data !==null && data !==""){
            alert(data);
        }


    })
}

function setStartTime(videoId,email){
    $.post("ajax/getProgress.php",{ videoId: videoId, email: email}, function(data){
       // is not number isnan
        if(isNaN(data)){
            alert(data);
            return;

        }
        
        // start the video from when i stoped 
        $("video").on("canplay",function(){
            this.currentTime = data;
            $("video").off("canplay");
        })


    })
}

function restartVideo(){
    $("video")[0].currentTime=0;
    $("video")[0].play();
    $(".upNext").fadeOut();
}

function watchVideo(videoId){
    window.location.href="watch.php?id="+videoId;
}

function showUpNext(){
    $(".upNext").fadeIn();
}

