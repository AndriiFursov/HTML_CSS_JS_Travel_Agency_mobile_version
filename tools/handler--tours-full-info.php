<?php
/*------------------------------------*\
    #SECTION-MANAGER-TOURS
    take full information about
    the selected tour    
\*------------------------------------*/

include "connect.php";


// geting tour ID 
$tour_id = $_GET["tour_id"];


$sql = "SELECT " .
       "tours.id, tours.view, tours.price, tours.hotel, tours.date_of_leaving, " .
       "tours.duration, tours.tour_room, tours.tour_accomodation, tours.currency, " . 
       "tours.tour_operator, tours.tour_visa, tours.tagline, tours.promo_text, " .
       "tour_types.name, currency.symbol, countries.rus_name, cities.name_rus " .
       "FROM " .
       "tours, countries, cities, currency, tour_types " .
       "WHERE " .
       "cities.name_eng = tours.city AND countries.eng_name = cities.country " .
       "AND tour_types.id = tours.tour_type AND currency.code = tours.currency " .
       "AND tours.id = " . $tour_id;
       
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $outp = "[";
    $outp .= '"' . $row["id"] . '",';
    $outp .= '"' . $row["view"] . '",';
    $outp .= '"' . $row["rus_name"] . '",';
    $outp .= '"' . $row["name_rus"] . '",';
    $outp .= '"' . $row["price"] . ' ' . $row["symbol"] . '",';
    $outp .= '"' . $row["currency"] . '",';
    $outp .= '"' . $row["hotel"] . '",';
    $outp .= '"' . $row["date_of_leaving"] . '",';
    $outp .= '"' . $row["duration"] . '",';
    $outp .= '"' . $row["tour_room"] . '",';
    $outp .= '"' . $row["tour_accomodation"] . '",';
    $outp .= '"' . $row["tour_operator"] . '",';
    $outp .= '"' . $row["tour_visa"] . '",';
    $outp .= '"' . $row["name"] . '",';
    $outp .= '"' . $row["tagline"] . '",';
    $outp .= '"' . $row["promo_text"] . '"';
    $outp .="]";
} else {
    $outp = "['error']";
}


echo $outp;


$conn->close();
?>