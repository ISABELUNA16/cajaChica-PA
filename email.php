<?php
$para = 'jsarmiento87@live.com';

// Pear Mail Library
require_once "Mail.php";

$from = '<nicoletesen@gmail.com>'; //change this to your email address
$to = '<jsarmiento87@live.com>'; // change to address
$subject = 'Amor!'; // subject of mail
$body = "Hola mi amor, dejame decirte que te amo demasiado"; //content of mail

$headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
);

$smtp = Mail::factory('smtp', array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => '465',
        'auth' => true,
        'username' => 'susana.arevalo.1962@gmail.com', //your gmail account
        'password' => 'SUS4N4-4R3V4L0' // your password
    ));

// Send the mail
$mail = $smtp->send($to, $headers, $body);
?>