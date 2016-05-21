/*------------------------------------*\
    #SECTION-CAROUSEL*
    Scripts for carousel 
    in tours full-info files
\*------------------------------------*/
/* 
 * Functions:
 *
 * selectFrame () - Function to show image in carousel
 *
 * changeFrame (direction) - Function to change image in carousel
 *
 * alignControls () - Function to align controls in carousel
 *
 * Listeners:
 * L-1 - Carusel controls are checked, scroll buttons are clicked and
 *       first image is loaded 
 *
 * L-2 - Window is resized
 *
*/

selectFrame = function () {
/*
 * Function to show image in carousel 
*/
    
    var pointerList = document.getElementsByName("current-frame"),
        framesList = document.querySelectorAll(".carousel__frame li");
    var i, frameNumber;
        
    
    for (i = 0; i < pointerList.length; i++) {
        if (pointerList[i].checked === true) {
            frameNumber = i;
        }
    }
    
    for (i = 0; i < framesList.length; i++) {
        framesList[i].style.display = "none";
    }
    
    framesList[frameNumber].style.display = "block";
}

function changeFrame (direction) {
/*
 * Function to change image in carousel 
*/
    
    var pointerList = document.getElementsByName("current-frame");
    var i, frameNumber;
        
    
    for (i = 0; i < pointerList.length; i++) {
        if (pointerList[i].checked === true) {
            frameNumber = i;
        }
    }
    
    if (direction === "left") {
        frameNumber - 1 < 0 ? frameNumber = pointerList.length - 1 : frameNumber--;
    } else {
        frameNumber + 1 >= pointerList.length ? frameNumber = 0 : frameNumber++;
    }
    
    pointerList[frameNumber].checked = "true";
    selectFrame();
    alignControls();
}

function alignControls () {
/*
 * Function to align controls in carousel 
*/

    var leftScroll  = document.getElementById("left-scroll"), 
        rightScroll = document.getElementById("right-scroll");
    var imgHeight   = document.querySelector(".carousel__wrapper").offsetHeight;
    
    leftScroll.style.bottom  = (imgHeight/2-30) + "px";
    rightScroll.style.bottom = (imgHeight/2-30) + "px";
}

/* -- Listeners -- */
document.addEventListener("DOMContentLoaded", function () { /* [L-1] */
/*
 * Set listeners to call "alignControls" function when first image is loaded
 * and to call "selectFrame" function when carusel controls are checked
 * or scroll buttons are clicked 
 *
 * 1 - protection against inappropriate behavior of IE 
 *
*/
   
    var pointerList = document.getElementsByName("current-frame"),
        leftScroll  = document.getElementById("left-scroll"), 
        rightScroll = document.getElementById("right-scroll"),
        firstImage  = document.querySelector(".carousel__frame li:first-child img");
/*        userBrowser = window.navigator.userAgent*/
    var i, brIE;
    

    for(i = 0; i < pointerList.length; i++) {
        pointerList[i].onchange = selectFrame;
    }
    
    if (!window.navigator.userAgent.match("/MSIE *\d+\.\w+/i")) { /* [1] */
        leftScroll.style.display = rightScroll.style.display = "none";
    }
    
    leftScroll.onclick  = function () {changeFrame('left')};
    rightScroll.onclick = function () {changeFrame('right')};
    firstImage.onload   = function () {
        alignControls();
        leftScroll.style.display = rightScroll.style.display = "block";
    };
});

window.addEventListener("resize", alignControls);  /* [L-2] */
