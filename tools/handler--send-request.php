<?php
/*------------------------------------*\
    #SECTION-SEND-CLIENT-REQUEST
    handling and sending the clien
    request to the admin e-mail
\*------------------------------------*/

$client_name    = $_POST["client-name"];
$client_phone   = $_POST["client-phone"];
$client_email   = $_POST["client-email"];
$tour_id        = $_POST["tour-id"];
$client_comment = $_POST["client-comment"];


if ($client_name&&$client_name!=""&&$client_phone&&client_phone!="") {
    $mail_body = "name - " . $client_name . "\n" .
    "phone - " . $client_phone . "\n" .
    "e-mail - " . $client_email . "\n" .
    "tour ID - " . $tour_id . "\n" .
    "link - http://tolomuco.xyz/examples/tr-ag/#!/tour/" . $tour_id . "\n" .
    "comment - " . $client_comment . "\n";
    
    if (mail("example@example.com", "client common tour request " .
    date("Y/m/d-H:i"), $mail_body)) {
        echo '{"result":"success"}';
    } else {
        echo '{"result":"error", "reason":"Request can not be sended.' .
             ' Try to repeat your request later, or call us ' .
             ' (MTS:(050)613-31-92; Kievstar:(098)761-98-55; ' .
             'Life:(073)475-64-56)!"}';
    }
} else {
    echo '{"result":"error", "reason":"Check your name and phone!"}';
}
?>
            
