<?php
/*------------------------------------*\
    #SECTION-LIST-OF-COUNTRIES
    searching countries in DB and 
    sending back a list of them
\*------------------------------------*/
include "connect.php";


$resultArray = array ();
$i = 0;

$sql = "SELECT * FROM countries ORDER BY rus_name ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $resultArray[$i][0] = $row["eng_name"];
        $resultArray[$i][1] = $row["rus_name"];
        $i++;
    }
}

echo json_encode($resultArray);
?>