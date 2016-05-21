/*------------------------------------*\
    #SECTION-SCROLL-UP*
    Scripts for scroll-up button 
\*------------------------------------*/

document.addEventListener("DOMContentLoaded", function () { 
/*
 * Set listener to scroll page up when scroll-up button are clicked
 *
*/

    var scrollUp = document.getElementById('scrollup'); 

    scrollUp.onclick = function() { 
        window.scrollTo(0, 0);
    };

    document.body.onscroll = function () { 
        if (window.pageYOffset > 10) {
            scrollUp.style.display = 'block';
        } else {
            scrollUp.style.display = 'none';
        }
    }
});