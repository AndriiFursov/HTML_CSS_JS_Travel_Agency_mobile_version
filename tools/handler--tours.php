<?php
/*------------------------------------*\
    #SECTION-LIST-OF-TOURS-SHORT-INFO
    select information about tours 
    from DB and send it for script 
    which show infocards with
    this information
\*------------------------------------*/
include "connect.php";


$sql = "SELECT id, city, price, currency, date_of_leaving, " .
       "duration, tour_type FROM `tours` WHERE `view` = 1 " .
       "ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $i = 0;
    $resultArray = '[';
    while($row = $result->fetch_assoc()) {
        if ($i>0) {$resultArray = $resultArray . ', ';}
        // take data about tour destination
        $sql_tour = "SELECT cities.name_rus, countries.eng_name, cities.region, " .
                    "countries.rus_name, currency.symbol " .
                    "FROM cities, countries, currency " .
                    "WHERE cities.name_eng = '" . $row["city"] . "' " .
                           "AND cities.country = countries.eng_name " .
                           "AND currency.code = '" . $row["currency"] . "'";


        $result_tour = $conn->query($sql_tour); 
        $row_tour = $result_tour->fetch_assoc();
        
        
        // set auxiliary variables
        if ($row_tour["region"] !== "") {
            $region = " (" . $row_tour["region"] . ")";
        }
        
        $country_full = $row_tour["rus_name"] . $region;
        $region = "";
        
        // put together tagline (text at the header of tour presentation)
        $tagline = $country_full . ", " . $row_tour["name_rus"] . "! " . 
                   "<span class=\"attention--strong\">" . $row["price"] . " " . 
                   $row_tour["symbol"] . "</span>" . " for " . 
                   $row["duration"] . " days!";
        $tagline = json_encode(mb_strtolower($tagline, 'UTF-8'));
        
        
        // make JSON array of objects
        $resultArray = $resultArray . '{' .
            '"id":"' . $row["id"] . '", ' .
            '"tourType":"' . $row["tour_type"] . '", ' .
            '"engName":"' . $row_tour["eng_name"] . '", ' .
            '"tagline":' . $tagline . ', ' .
            '"dateOfLeaving":"' . $row["date_of_leaving"] . '"' .
        '}';
        
        $i++;
    }
    
} else {
    $resultArray[0] = 'error';
}

$resultArray = $resultArray . ']';

    
echo $resultArray;
?>