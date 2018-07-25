<?php
//========================================================================
// IMAP SETTINGS
$IMAPhost = 'www.fxstar.eu';
// IMAP port 143, 995 or POP3 port 110, 995
$IMAPport = '143';
$IMAPssl = 'tls';

//=======================================================================
// IMAP CONNECTION URL don't change line belove
$IMAP = '{'.$IMAPhost.':'.$IMAPport.'/imap/'.$IMAPssl.'/novalidate-cert}';

//================================================ DATABASE MYSQL change database name in newsletter.sql file in sql folder if you need another name
// mysql hostname url
$host = 'localhost';
// mysql database name
$dbname = 'newsletter';
// mysql username
$user = 'root';
// mysql password for user
$pass = 'toor';


//================================================ SMTP
// SMTP settings hostname for phpmailer
$SMTPdomain = 'fxstar.eu';
//SMTP port 25 or 587 or 465
$SMTPPort = 587;
// SMTP tls or ssl type
$SMTPSecure = "tls"; // or ssl
// SMTP authentication
$SMTPAuth = true;
// Set send from email Name (text np.: CompanyName)
$SetFrom = 'Hello';


//================================================ DKIM you don't need set this
// DKIM settings host (if empty don't add DKIM only add from mail server if exist)
$DKIMdomain = 'fxstar.eu';
// path to file with private key generate on -> http://dkimcore.org/tools/
$DKIMprivkey = 'dkim.txt';
// DNS selector
$DKIMselector = 'all';
// Passprase for private key or empty
$DKIMpassword = '';