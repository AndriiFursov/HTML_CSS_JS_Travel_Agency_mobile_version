<?php

include "tools/connect.php";

$tour_id = $_GET["id"];





// take data about tour                                                         
$sql = "SELECT tours.price, tours.date_of_leaving, tours.duration, " .
       "tours.tour_accomodation, tours.tour_room, tours.tour_visa, " .
       "tours.tour_operator, tours.from_place, " . 
       "cities.name_rus, cities.region, countries.rus_name, " . 
       "currency.symbol, tour_types.id, tour_types.name, " .
       "hotels.h_name, hotels.h_class " .                                      
       "FROM tours, cities, countries, currency, tour_types, hotels " .                 
       "WHERE tours.id = '" . $tour_id . "' " .                                     
       "AND cities.name_eng = tours.city " .                                  
       "AND cities.country = countries.eng_name " .                           
       "AND currency.code = tours.currency " .                                
       "AND hotels.h_code = tours.hotel_id " .                                
       "AND tour_types.id = tours.tour_type";
       
                                                                                
$result = $conn->query($sql);                                                   
$t_row = $result->fetch_assoc();                                                  
                                                                                
                                                                                
// set auxiliary variables                                                      
if ($t_row["region"] !== "") {                                                    
    $region = " (" . $t_row["region"] . ")";                                      
}                                                                               
                                                                                
$country_full = $t_row["rus_name"] . $region;

$tour_type = $t_row["name"];
                                                                                
                                                                                
// put together promo text (text placed at the top of the page)                 
$promo_text = $country_full . ", " . $t_row["name_rus"] . 
            "! <span class='attention--strong'>" .
            $t_row["price"] . " " . $t_row["symbol"] . 
            "</span> " . " for " . $t_row["duration"] . " days!";  





// take data about hotel
$sql = "SELECT hotels.* " . 
       "FROM hotels, tours " .
       "WHERE tours.id = '" . $tour_id . "' " .
       "AND hotels.h_code = tours.hotel_id";
                                                                                
$result = $conn->query($sql);                                                   
$h_row = $result->fetch_assoc();                                                  


class HotelProperty {
    // name of hotel property
    var $property_name;
    // name of css class
    var $class_name;
    // name of category (list of specific hotel properties)
    var $category_name;
    
    function HotelProperty($pr, $cl, $ca) {
        $this->property_name = $pr;
        $this->class_name = $cl;
        $this->category_name = $ca;
    }
};

$hotel_info = array(
    $distances     = new HotelProperty("h_distances", 
                     "icon-distance", "Distances:"),
    $in_rooms      = new HotelProperty("h_in_rooms", 
                     "icon-in-room", "In the room:"),
    $available     = new HotelProperty("h_numbers", 
                     "icon-available", "Avalibale:"),
    $food          = new HotelProperty("h_food", 
                     "icon-food", "Accomodation:"),
    $territory     = new HotelProperty("h_territory", 
                     "icon-territory", "Territiry:"),
    $pools         = new HotelProperty("h_pools", 
                     "icon-pool", "Pools:"),
    $for_children  = new HotelProperty("h_for_children", 
                     "icon-children", "For children:"),
    $services      = new HotelProperty("h_services", 
                     "icon-services", "Services:"),
    $beauty        = new HotelProperty("h_health", 
                     "icon-beauty", "Beauty and Health:"),
    $party         = new HotelProperty("h_fun", 
                     "icon-party", "Entertainment:"),
    $sport         = new HotelProperty("h_sport", 
                     "icon-sport", "Sport:")
);
?>
<!DOCTYPE html>
<html class="" lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" lang="ru" content="СОК traveling">
    <meta name="description" content="Vacation at <?php echo $t_row["rus_name"]?>! Hot tour to <?php echo $t_row["rus_name"]?>!>
    <meta name="keywords" content="Vacation at <?php echo $t_row["rus_name"]?>! Hot tour to <?php echo $t_row["rus_name"]?>!">
    <title>COK-trevel - <?php echo $t_row["rus_name"]?>! Hot tours!</title>
    <link rel="canonical" href="http://travelingua.com.ua/tours/<?php echo $tour_id?>.php">
    <link rel="icon" type="image/vnd.microsoft.icon" href="img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/tour__grid.css">
    <link rel="stylesheet" type="text/css" href="css/tour__carousel.css">
    <link rel="stylesheet" type="text/css" href="css/tour-mob.css">
    <script src="scripts/tour__carousel.js"></script>
    <script src="scripts/tour__scroll-up.js"></script>
    <script src="scripts/tour__tour-request.js"></script>
    
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>





<body>
    <script>
    /* Google Analytics*/
    </script>
    
    <header>
        <div class="logo">
            <a href="http://tolomuco.xyz/examples/tr-ag/mobile/" title="home">
                <img src="img/logo_cok.png" width="48px" height="48px"
                alt="COK traveling logoо">
            </a>
        </div>
        <a href="http://tolomuco.xyz/examples/tr-ag/mobile/contacts.html"
        class="phones" title="contacts">
            <div><div class="mobo-mts"></div>(050)613-31-92</div>
            <div><div class="mobo-kyivstar"></div>(098)761-98-55</div>
            <div><div class="mobo-life"></div>(073)475-64-56</div>
            <div>Kiev, Pavlovskaya str. 29, office 6</div>                
        </a>
        <a href="http://tolomuco.xyz/examples/tr-ag/mobile/" title="home"
        class="hamburger"></a>
    </header>
    
    
    
    
    
    <section>
<?php
// carousel
// get array of photos
$elements = explode("|", $h_row["h_photos"]);
$array_size = count($elements);

// make carousel structure
if ($array_size > 1) {
    echo '<div class="carousel__wrapper">                                           
            <ul id="carousel__frame" class="carousel__frame">
    ';
            
    for ($i = 0; $i < $array_size; $i++) {
        echo '
                <li>                                                              
                    <img src="http://travelingua.com.ua/tour-img/' . $elements[$i] . '"                        
                    height="250px" alt="tour image">                              
                </li>
        ';
    }
    
    echo '
            </ul>
        
            <div id="left-scroll" class="carousel__left">
                <img alt="Scroll left" src="img/carousel-left.png"
                title="Scroll left" height="40px">
            </div>
            <div id="right-scroll" class="carousel__right">
                <img alt="Scroll right" src="img/carousel-right.png"
                title="Scroll right" height="40px">
            </div>  
        
            <div id="carousel__controls" class="carousel__controls"> 
                <input id="pointer1" type="radio" name="current-frame"
                checked>  
                <label for="pointer1">
                </label>
    ';
        
    for ($i = 2; $i < $array_size + 1; $i++) {
        echo '
                <input id="pointer' . $i . 
                '" type="radio" name="current-frame">
                <label for="pointer' . $i . '">                                            
                </label>
        ';
    } 

    echo '
            </div>

        </div>
    ';
} else {
    if ($array_size > 0) {
        echo '
        <div class="carousel__wrapper">                                           
            <ul id="carousel__frame" class="carousel__frame">
                <li>                                                              
                    <img src="tour-img/' . $elements[0] . '"                        
                    height="250px" alt="tour image">                              
                </li>                                                             
            </ul>                                                                 
        </div>
        ';
    }
}
?>
    </section>
    
    
    
    
    
    <main>
        <h1>
            <?php echo $promo_text?>
        </h1>
        
        <div class="tour-order">
            <label for="tour-request">
                Book this tour
            </label>
        </div>
        
        
        <!-- tour info block -->        
        <section class="tour-details">   
            <div class="row">        
                <div class="col-12">
                    <div class="icon-fly"></div>
                    <div class="brief-info">
                        Departure from <?php echo $t_row["from_place"]; 
                        ?> <b><?php echo $t_row["date_of_leaving"]; ?></b>
                        for <?php echo $t_row["duration"]; ?>
                        days/<?php echo $t_row["duration"]-1; ?> nights
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="icon-hotel"></div>
                    <div class="brief-info">
                        <b>Hotel:</b> <?php echo $t_row["h_name"]; ?>
                        <?php echo $t_row["h_class"]; ?>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="icon-accomodation"></div>
                    <div class="brief-info">
                        <b>Accomodation:</b> <?php echo $t_row["tour_accomodation"]; ?>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="icon-room"></div>
                    <div class="brief-info">
                        <b>Room:</b> <?php echo $t_row["tour_room"]; ?>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="icon-type"></div>
                    <div class="brief-info">
                        <b>Tour type:</b>
                        <span class="<?php echo $t_row["id"]; ?>">
                            <?php echo $tour_type ?>
                        </span>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="icon-price"></div>
                    <div class="brief-info">
                        <b>Price:</b>
                        <?php echo $t_row["price"]; ?> <?php echo $t_row["symbol"]; ?>
                    </div>
                </div>
            <div class="note">
                <b>The price includes:</b> The international transfer, transfer to hotel, accommodation at the hotel with a specified power, medical insurance. 
            </div>
            
            <div class="visa">
                <b><?php echo $t_row["tour_visa"]; ?></b>
            </div>
        </section>

        
        <!-- hotel info block -->        
        <input id="hotel-details" class="switch" type="checkbox">
        
        <div class="th-switch">
            <label class="hd-open" for="hotel-details">
                Hotel details <span>&#9660;</span>
            </label>
            <label class="hd-close" for="hotel-details">
                Hide <span>&#9650;</span>
            </label>
        </div>

        <section class="row hotel-details">
<?php 
// hotel's site
if ($h_row["h_site"] !== '') {
    echo '
            <div>
                <div class="icon-site"></div>
                <h2 class="brief-info">Сайт отеля:</h2>
                <a href="' . 
                $h_row["h_site"] . '" 
                target="_blank">' . 
                $h_row["h_site"] . 
                '</a>
            </div>
    ';
}

// hotel description
if ($h_row["h_build"] !== '') {
    $elements = explode("|", $h_row["h_build"]);
    $array_size = count($elements);
}

if (($h_row["h_description"] !== '')||($h_row["h_build"] !== '')) {
    echo '
            <div class="hotel-description">
                <h2>Hotel description:</h2>
                <br>
    ';

    echo $h_row["h_description"];
    
    if (($h_row["h_description"] !== '')&&($h_row["h_build"] !== '')) {
        echo '
                <br><br>
        ';
    }
    
    if ($h_row["h_build"] !== '') {
        for ($i = 0; $i < $array_size; $i++) {
            echo $elements[$i] . '<br>';
        }
    }
    
    echo '
            </div>
    ';
}

// other hotel properties
$hi_size = count($hotel_info);
for ($i = 0; $i < $hi_size; $i++) {
    if ($h_row[$hotel_info[$i]->property_name] !== '') {
        $elements = explode("|", 
        $h_row[$hotel_info[$i]->property_name]);
        $array_size = count($elements);
    }
    
    if ($h_row[$hotel_info[$i]->property_name] !== '') {
        echo '
                <div class="col-12">
                    <div class="' . $hotel_info[$i]->class_name .
                    '"></div>
                    <h2 class="brief-info">' .
                    $hotel_info[$i]->category_name . '</h2>
                    <ul>
        ';
        
        for ($j = 0; $j < $array_size; $j++) { 
            echo '
                        <li>' . $elements[$j] . '</li>
            ';
        }
        
        echo '
                    </ul>
                </div>
        ';
    }
}
?>
        </section>
    </main>
    
    
    
    
    
    <section class="general-info">
        <div>
            <ul>
                <li>Relevance of this proposal check with our managers! </li>
                
                <li class="attention--strong">The price is for 1 person with a 2-bed rooms (for only 1 person in 2-bed room price will be higher, check with our managers) </li>
                
                <li>Payment in local currency at the exchange rate</li>
                
                <li>We can count the cost of the hotel on any date of departure and at any number of days</li>
            </ul>

            <div class="attention--strong">
                THERE ISN'T FINAL LIST OF PROPOSALS ON OUR SITE! CHECK NEW 
                PROPOSALS WITH OUR MANAGERS!
            </div>
        </div>
        
        <div class="about-us">
            <a href="http://tolomuco.xyz/examples/tr-ag/mobile/contacts.html">
                About us
            </a>
        </div>
    </section>





    <footer>
        <div class="copyright">
            Copyright © 2014 - <?php echo date("Y");?> 
            <a href="http://tolomuco.xyz/examples/tr-ag/">COK travel</a> 
            All Rights Reserved
        </div>
        
        <div class="developer">
            Developed - Tolomuco.xyz
        </div>
    </footer>
    
    
    
    
    
    <section>
        <input id="tour-request" class="switch" type="checkbox">
        <form id="request-form" class="request-form" 
        onsubmit="return false" 
        action="http://travelingua.com.ua/tour.php?id=<?php echo $tour_id ?>">
            <label class="req-close" for="tour-request">×</label>
            
            <div class="request-greeting">
                Send request for callback
            </div>
            
            
            <label class="col-12" for="rq-name" 
            title="Required">
                Name<span class="attention--strong">*</span>
            </label>
            <input id="rq-name"  class="col-12" type="text" required
            pattern="^[А-Яа-яЁёA-Za-z\s]+$" maxlength="64"
            name="client-name">
            
            <label class="col-12" for="rq-phone" 
            title="Required">
                Phone<span class="attention--strong">*</span>
            </label>
            <input id="rq-phone" class="col-12" type="tel" required
            pattern="^[0-9\s\(\)\+\-]+$" maxlength="20"
            name="client-phone">
            
            <label class="col-12" for="rq-mail">E-mail</label>
            <input id="rq-mail" class="col-12" type="email"
            maxlength="64"
            name="client-email">
            
            <label class="col-12">tour ID</label>
            <input class="col-12" type="text" value="<?php echo $tour_id?>" readonly
            name="tour-id">
            
            <label class="col-12" for="rq-text">Short comment</label>
            <textarea id="rq-text" class="col-12" maxlength="1000"
            name="client-comment"></textarea>
            
            <div class="col-12">
                <label class="rq-button" for="tour-request">
                    Cancel
                </label>
                <button class="rq-button" type="submit">Send</button>
            </div>
        </form>
        
        <input id="tour-answer" class="switch" type="checkbox">
        <div class="tour-answer">
            <p></p>
            <label class="rq-button" for="tour-answer">Close</label>
        </div>
    </section>
    
    
    
    
    
    <div id="scrollup">
        <img src="img/scroll-up.png" title="Scroll up" alt="Scroll up" 
        width="40px">
    </div>
</body>
</html>