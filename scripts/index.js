/*------------------------------------*\
    #SECTION-TOUR-REQUEST*
    Scripts for index.php
\*------------------------------------*/
/* 
 * Functions:
 *
 * loadTours () - Function to load the list of tours
 *
 * * makeTour () - Function to make the tour (return a reference to 
 * * the maked tour)
 *
 * * showTours (showNext, tourType, country) - Function to show the 
 * * list of tours 
 *
 * * setFilter (obj) - Function to handle clicks on "filter" labels
 *
 * * showCountries () - Function to fill the list of countries
 *
 * * selectCountry (country) - Function to filter list of tours and show
 * * only tours in seleced country
 *
 * * stopScroll (flag) - Functiont to forbid scrolling of the list of tours
 *
 * Listeners:
 * 1 - fill list of tours by "showTours()"
*/


function loadTours () {
/*
 * Function to load the list of tours
*/
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var tours   = document.querySelector('main>div'),
                filters = document.querySelectorAll('[data-type="filter"]'),
                menuChbx = document.getElementById('menu-chbx'),
                countriesChbx = document.getElementById('countries-chbx');

            var resultArray   = JSON.parse(xhttp.responseText),
                countriesFirstLoad = false;
                showStep = 15; // quantity of tours displayed in one step

            function makeTour (tourObj) {
            /*
             * Function to make the tour (return a reference to the maked tour)
            */
                var tourBox = document.createElement("a");
                
                tourBox.innerHTML = 
                "<article class='presentation'>" +
                "<div class='presentation__img'>" +
                "<img src='http://travelingua.com.ua/tour-img/" + tourObj.id + ".jpg' alt='" + 
                tourObj.id + ".jpg' width='300' height='190'>" +
                "</div><div class='presentation__header'>" +
                "<h1>" + tourObj.tagline + "</h1></div>" +
                "<div class='presentation__service-info'>" +
                "<div><b class='" + tourObj.tourType + "'>" + 
                tourObj.dateOfLeaving + "</b>" + 
                "<div class='tour-id'>ID " + tourObj.id + 
                "</div></div></div></article>";
                
                tourBox.href = "tour.php?id=" + tourObj.id;
                tourBox.setAttribute("data-type", tourObj.tourType);
                tourBox.setAttribute("data-country", tourObj.engName);
                
                return tourBox;
            }
            
            function showTours (showNext, tourType, country) {
            /*
             * Function to show the list of tours
            */
                var i = counter = 0;
                
                while (resultArray[i]) {
                    if (resultArray[i].tourType === tourType||
                    resultArray[i].engName === country||
                    (country === "all"&&tourType === "all")) {
                        if (!resultArray[i].ref&&counter < showNext) {
                            resultArray[i].ref = makeTour (resultArray[i]);
                            counter++;
                        }
                        
                        if (resultArray[i].ref) {
                            resultArray[i].ref.style.display = "";
                            // sort the list of tours by creation date/time
                            tours.appendChild(resultArray[i].ref); 
                        }
                    } else if (resultArray[i].ref) {
                        resultArray[i].ref.style.display = "none";
                    }

                    i++;
                }
            }
            
            
            function setFilter (obj) {
            /*
             * Function to handle clicks on "filter" labels
            */
                var showNext = showStep,
                    i = 0;
                    
                    
                document.getElementById(obj.className + 
                '-tour-chbx').checked = true;
                // countries filter switch off if types filter switch onn
                document.getElementById('all-country-chbx').checked = true;
                
                while (i < resultArray.length&&showNext>0) {
                    if (obj.className !== "all") { 
                            if (resultArray[i].ref&&
                            resultArray[i].tourType === obj.className) {
                            showNext--;
                        }
                    } else (showNext = 0)
                    i++;
                }
                showTours (showNext, obj.className, "all");
            }

            
            function selectCountry (country) {
            /*
             * Function to filter list of tours and show only tours to the 
             * seleced country
            */
                var showNext = showStep,
                    i = 0;
                
                var icon;
                
                
                countriesChbx.checked = false;
                countriesChbx.onchange();
                // types filter switch off if countries filter switch onn
                document.getElementById('all-tour-chbx').checked = true;
                document.getElementById(country + '-country-chbx').checked = true;
                if (country !== "all") {
                    while (i < resultArray.length&&showNext>0) {
                        if (country !== "all") { 
                                if (resultArray[i].ref&&
                                resultArray[i].engName === country) {
                                showNext--;
                            }
                        } else (showNext = 0)
                        i++;
                    }
                    showTours (showNext, "all", country);
                    
                    icon = document.createElement("img");
                    icon.src = "img/countries/" + country + ".png";
                    icon.className = "country-icon";
                    icon.alter = country;
                    document.querySelector("header").appendChild(icon);
                } else {
                    showTours (0, "all", "all");
                    icon = document.querySelector(".country-icon");
                    if (icon) {icon.remove()};
                }
            }

            function showCountries (position) { 
            /*
             * Function to fill the list of countries
            */
                var xhttp, countriesList, resultArr;
              
                
                if (position) {
                    menuChbx.checked = false;
                    menuChbx.onchange();
                }
                
                // first loading of the countries list                
                if (!countriesFirstLoad) {
                    countriesFirstLoad = true;
                    countriesList = document.getElementById("countries-list");
                    xhttp = new XMLHttpRequest();
                    
                    xhttp.onreadystatechange = function() {
                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                            resultArr = JSON.parse(xhttp.responseText);
                            
                            for (var i=0; i<resultArr.length; i++) {
                                countryBox = document.createElement("li"),
                                countriesList.appendChild(countryBox);
                                
                                countryBox.innerHTML = 
                                '<input type="radio" name="countries" ' +
                                'id="' + resultArr[i][0] + 
                                '-country-chbx" class="hidden">'+ 
                                '<img src="img/countries/' + resultArr[i][0] +
                                '.png" alt="' + resultArr[i][1] +'">' +
                                '<span>' + resultArr[i][1] + '</span>';
                                
                                countryBox.onclick = (function (country) {
                                    return function () {
                                        selectCountry(country);
                                    }
                                })(resultArr[i][0]);
                            }
                        }
                    };
                    xhttp.open("GET", "tools/handler--countries.php", true);
                    xhttp.send();
                }
            }


            function stopScroll (flag) {
            /*
             * Functiont to forbid scrolling of the list of tours
            */
                var tourBox = document.documentElement;
                
                
                if (flag) {
                    tourBox.style.overflow = "hidden";
                } else {
                    tourBox.style.overflow = "";
                }
            }
           
            
            // first set of tours
            showTours (showStep, "all", "all");
            
            for (var i=0; i<filters.length; i++) {
                filters[i].onclick = function () {setFilter(this);};
            }

            window.addEventListener ("scroll", function() {
                var docHeight = document.documentElement.scrollHeight,
                    winHeight = document.documentElement.clientHeight,
                    // documentElement.scrollTop incorrect 
                    // in Safari/Chrome/Operabody
                    scrolled = window.pageYOffset ||     
                    document.documentElement.scrollTop,  
                    showedType = 
                        document.querySelector('input[name="types"]:checked').
                        parentNode.className,
                    showedCountry = 
                        document.querySelector('input[name="countries"]' +
                        ':checked').id;
                    // extract country name from id    
                    showedCountry = showedCountry.substring(0, 
                                    showedCountry.indexOf('-country-chbx'));
                        

                if  (docHeight - winHeight - scrolled === 0) {
                    // next set of tours
                    showTours (showStep, showedType, showedCountry);
                }
            });
            
            
            // listeners:
            // disable/enable ability of scrolling the list of tours 
            // if menu open/closed
            menuChbx.onchange = function() {stopScroll(menuChbx.checked);}
            // disable/enable ability of scrolling the list of tours 
            // if the list of countries open/closed
            // and load the list of countries
            countriesChbx.onchange = function() {
                showCountries(countriesChbx.checked);
                stopScroll(countriesChbx.checked);
            }
            //
            document.getElementById('all-countries').onclick = 
                function() {selectCountry("all");}
        }
    };
    xhttp.open("GET", "tools/handler--tours.php", true);
    xhttp.send();
}


document.addEventListener("DOMContentLoaded", function () { 
    // 1
    loadTours();
});