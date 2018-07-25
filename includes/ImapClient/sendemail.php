<?php
session_start();
error_reporting(0);

set_time_limit(0); // Make sure php doesnt end script after 30 seconds
ini_set('upload_max_filesize', '100M');

require('core/pdo.php');
require('core/config.php');	
$db = Conn();
header('Content-type: text/html; charset=utf-8');
//file_put_contents($file, $txt, FILE_APPEND | LOCK_EX);

// login first
$IMAPuser = $_SESSION['email']; 
$IMAPpass = $_SESSION['pass'];
$ibox = imap_open($IMAP, $IMAPuser, $IMAPpass);
if ($ibox == false) {
	header('Location: index.php');
	exit;
}

$folders = imap_list($ibox, "{folders}", "*");
$m = '<ul class="folders">';
foreach ($folders as $folder) {
    $folder = str_replace("{folders}", "", imap_utf7_decode($folder));

    if(strtolower($folder) == 'trash' || strtolower($folder) == 'kosz'){
    	//echo '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-trash-o"></i> ' . $folder . '</a></li>';
    	$m .= '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-trash-o"></i> Kosz </a></li>';
	}else if(strtolower($folder) == 'send' || strtolower($folder) == 'sent'){
		//echo '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-send-o"></i> ' . $folder . '</a></li>';
		$m .= '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-send-o"></i> Wysłane </a></li>';
	}else if(strtolower($folder) == 'odebrane' || strtolower($folder) == 'inbox'){
		//echo '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-envelope-o"></i> ' . $folder . '</a></li>'; 
		$m .= '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-envelope-o"></i> Odebrane </a></li>';
	}
}
$m .= '<li><a href="sendemail.php">  <i class="fa fa-send"></i> Wyślij wiadomość </a></li>';
$m .= '<li><a href="logout.php">  <i class="fa fa-sign-out"></i> Wyloguj </a></li>';
$m .= "</ul>";

function getDomain($host){
	//$host = str_replace('@', '.', $host);
	$e = explode('.', $host);
	$c = count($e);
	return $h = $e[$c-2].'.'.$e[$c-1];
}

if (isset($_POST['add'])) {	
$email = $_POST['email'];
$msg = $_POST['msg'];
$subject = $_POST['subject'];

if (filter_var($email, FILTER_VALIDATE_EMAIL) != false) {

$fn = basename($_FILES['file']['name']);
$ftmp = $_FILES['file']['tmp_name'];
$ext = pathinfo(basename($fn),PATHINFO_EXTENSION);
if ($ext == 'php' || $ext == 'cgi') {
	$error = "Ten typ plików jest zabroniony. Spakuj do zip i wyślij.";
}else{
	if(!empty($fn))move_uploaded_file($ftmp,'tmp/'.$fn);
}

$ip = $_SERVER['REMOTE_ADDR'];
	if (empty($_POST['email']) || empty($_POST['msg']) || empty($_POST['subject'])) {
	echo "Wypełnij wszystkie pola formularza!";	
	}else{
		error_reporting(0);
		// get config			
		require 'mailer/PHPMailerAutoload.php';
		require('mailer/class.phpmailer.php');
		//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

		// send mail
		$sub = $subject;
		$msg             = eregi_replace("[\]",'', $msg);
		$mail             = new PHPMailer();
		// send like html
		$mail->IsHTML(true);
		$mail->IsSMTP(); 	
		
		// Add dkim keys
		if (!empty($DKIMdomain)) {
			$mail->DKIM_domain = $DKIMdomain; 		// domain dns
			$mail->DKIM_private = 'core/'.$DKIMprivkey;		// private key path to file
			$mail->DKIM_selector = $DKIMselector;  	//this effects what you put in your DNS record
			$mail->DKIM_passphrase = $DKIMpassword;	// nothing if empty
			$mail->DKIM_identity = $mail->From;
		}
		
		//$mail->SMTPDebug  = 1;                   // 1 = errors and messages, 2 = messages only
		//hostname
		$mail->Host       = $SMTPdomain; 		// SMTP server hostname
		$mail ->CharSet   = "utf-8";		// charset utf-8
		$Mail->Encoding    = '8bit';		// encoding 
		$mail->SMTPSecure = $SMTPSecure;    // true or false
		$mail->Port       = $SMTPPort;          // set the SMTP port for the GMAIL server
		$mail->SMTPAuth   = $SMTPAuth;      // enable SMTP authentication
		$mail->Username   = $IMAPuser; 		// SMTP account username
		$mail->Password   = $IMAPpass;      // SMTP account password
    	//$mail->Timeout       =   60; 		// set the timeout (seconds)
    	//$mail->SMTPKeepAlive = true; 		// don't close the connection between messages

		$mail->SetFrom($IMAPuser, $SetFrom);
		$mail->AddReplyTo($IMAPuser, $SetFrom);

		$mail->Subject    = $sub;
		$mail->AltBody    = $sub;
		$mail->MsgHTML(html_entity_decode($msg));

		// email to and name
		$mail->AddAddress($email, 'Witaj');

		if (file_exists('tmp/'.$fn) && !empty($fn)) {
			$mail->AddAttachment('tmp/'.$fn);      // attachment	
		}
		

		// log file
		//$dir = (__DIR__);
		$dir = $_SERVER['DOCUMENT_ROOT'];
		$file = 'logs/SendMailLog-'.date('Y-m-d-H', time()).'.txt';

		if(!$mail->Send()) {			
			$time = date('Y-m-d H:i:s', time());
		  	$err = $time." ###Mailer Error confirmation : " . $mail->ErrorInfo . " ###MAIL" . $email."<br>\r\n";
		  	file_put_contents($file, $err, FILE_APPEND);		  	
		  	echo '<p class="toperror">Nie wysłano wiadomości na podany adres email.</p>';
		} else {		
		//print_r($mail->getSentMIMEMessage());
		$ibox = imap_open($IMAP, $_SESSION['email'], $_SESSION['pass']);
		$dmy=date("Y-m-d H:i:s");
		$boundary = "------=".md5(uniqid(rand())); 

		if(file_exists('tmp/'.$fn)){
		/*			
		$attachment = chunk_split(base64_encode(file_get_contents('tmp/'.$fn)));   
		$add =      "Content-Transfer-Encoding: base64\r\n"
			        . "Content-Disposition: attachment; filename=\"$fn\"\r\n"
			        . "\r\n" . $attachment . "\r\n"
			        . "\r\n\r\n\r\n"   
			        . "--$boundary--\r\n\r\n";
		*/
		}
    	
    		//$sub= "=?UTF-8?B?".base64_encode($sub)."?=";
		$boundary1 = "###".md5(microtime())."###";
		$boundary2 = "###".md5(microtime().rand(9,999))."###"; 
		imap_append($ibox, $IMAP."Send"
			, "From: Hello <".$IMAPuser.">\r\n"
			. "To: ".$email."\r\n"
			. "Date: $dmy\r\n" 
			. "Subject: ".quoted_printable_encode($sub)."\r\n"
		        . "MIME-Version: 1.0\r\n"
		        . "Content-Type: multipart/mixed; boundary=\"$boundary1\"\r\n"
		        . "\r\n\r\n"
		        . "--$boundary1\r\n"
		        . "Content-Type: multipart/alternative; boundary=\"$boundary2\"\r\n"
		        . "\r\n\r\n"
		        // ADD Plain text data
		        . "--$boundary2\r\n"
		        . "Content-Type: text/plain; charset=\"utf-8\"\r\n"
		        . "Content-Transfer-Encoding: quoted-printable\r\n"
		        . "\r\n\r\n" 
		    	. $msg."\r\n"
		        . "\r\n\r\n"
		        // ADD Html content
		        . "--$boundary2\r\n"
		        . "Content-Type: text/html; charset=\"utf-8\"\r\n"
		        . "Content-Transfer-Encoding: quoted-printable \r\n"
		        . "\r\n\r\n" 
		    	. html_entity_decode($msg)."\r\n"
		        . "\r\n\r\n"
		        . "--$boundary2\r\n"
		        . "\r\n\r\n"
		        // ADD attachment(s)
		        . "--$boundary1\r\n"
		        . "Content-Type: image/gif; name=\"$fn\"\r\n"
		        . "Content-Transfer-Encoding: base64\r\n"
		        . "Content-Disposition: attachment; filename=\"$fn\"\r\n"
		        . "\r\n\r\n"
		        . $attachment 
		        . "\r\n\r\n"   
		        . "--$boundary1--\r\n\r\n" 
		);
			// and you can get whole raw message with getSentMIMEMessage() method but doesn't work above is better
			//$ibox = imap_open($IMAP, $_SESSION['email'], $_SESSION['pass']);			
			//imap_append($ibox,$IMAP,$mail->getSentMIMEMessage(), "\Seen");
			//imap_append($ibox, 'Send',$mail->getSentMIMEMessage(), "\\Draft");

			$time = date('Y-m-d H:i:s', time());
			$log = $time." ###CONFIRMATION Message sent! ".$email." Temat: ".$sub.' Wiadomość: '.$msg."<br>\r\n";		
			file_put_contents($file, $log, FILE_APPEND);
			echo '<p class="toperror">Wiadomosć została wysłana.</p>';	 
		}

	}
}else{
	echo '<p class="toperror">Popraw adres e-mail.</p>';
}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Wyślij wiadomość email</title>
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">	
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700|Roboto+Condensed:300,400,700&subset=latin-ext" rel="stylesheet">
<style type="text/css">
*{
	padding: 0px;
	margin: 0px;	
	font-size: 13px;      
	font-family: 'Roboto', sans-serif;    
    text-decoration: none;
    box-sizing: border-box;   
}
html{
	background: #f9f9f9;
}
iframe{
	border: 0px;
	min-width: 100%;
	min-height: 900px;
}
.body{
	width: 98%;
	margin-left: 1%;
	margin-right: 1%;
	background: #fff;
}
.err{
	background: #fff;
	border: 1px solid #232f3e;
	color: #232f3e;
	padding: 10px;
	margin: 10px;
	overflow: hidden;
}
.file{
	position: relative;
	float: right;
	padding: 5px;
	font-size: 12px;
	background: #fff;
	color: #777;
	border: 1px solid #777;
	margin: 5px;
	border-radius: 4px;
}
.file:hover{
color: #23313f;
border-color: #23313f
}
.bottom{
	margin: 0 auto;
	width: 98%;
	background: #f6f6f6;
	height: auto;
	overflow: hidden;
	margin-bottom: 10px;
	box-shadow: 0px 1px 3px rgba(0,0,0,0.1);
	box-sizing: border-box;
	border: 1px solid #f9f9f9 inset;
}
.bottom1{
	display: none;
	margin: 0 auto;
	width: 98%;
	background: #fff;
	height: auto;
	overflow: hidden;
	margin-bottom: 10px;
	box-shadow: 0px 1px 3px rgba(0,0,0,0.1);
	box-sizing: border-box;
	border: 1px solid #f9f9f9 inset;
	padding: 10px;
}
.title{
	width: 100%;
	padding: 5px;
	margin-bottom: 10px;
	font-weight: 700;
	border-bottom: 1px solid #eee;
}
.folders{
	float: left;
	min-width: 100%;			
	padding: 10px;
	color: #fff;
	background: #232f3e;
	list-style: none;
	display: inline;
	margin-bottom: 10px;
}
.folders li{
	float: left;
	display: inline;
	padding: 5px;
	margin: 5px;
}
.folders a{
	color: #fff;
	//background: linear-gradient(#2b3e50, #232f3e,#232f3e);
	text-decoration: none;		
	text-transform: lowercase;
	padding: 10px;
	border-top: 1px solid #fff;
}
.folders a:hover{
	background: #2b3e50;
	border-top: 0px;
	border-bottom: 1px solid #fff
}

	.imsgtime{
		min-width: 100%;
		float: left;
		border-bottom: 1px solid #ddd;
		padding: 10px;
		margin: 5px;
		background: #fff;
		box-shadow: 0px 1px 3px rgba(0,0,0,0.06);
		border-left: 2px solid #66c666;
		background: linear-gradient(#fff,#eee);
	}
	.imsgtime .itime{
		font-weight: 400;
		font-size: 13px;
		color: #66c666;
	}

	.msgid{
		position: relative;
		float: left;
		width: 100%;
		height: auto;
		overflow: hidden;
		border: 1px solid #000;
	}
	.imsg{
		width: 98%;
		float: left;
		margin-left: 1%;
		margin-right: 1%;
		border-bottom: 1px solid #ddd;
		padding: 10px;
		background: #fff;
		box-shadow: 0px 1px 3px rgba(0,0,0,0.1);
		border-left: 1px solid #eee
	}
	.imsg:hover-{
		border-left: 3px solid #232f3e;
		cursor: pointer;
		background: #D5E8CF
	}
	.imsg .avatar{
		position: relative;
		float: left;
		min-width: 5%;
		max-width: 5%;
		border: 1px solid #eee;
		border-radius: 100px;
		padding: 2px;
	}
	.imsg .isub{
		float: left;
		height: auto;
		min-width: 95%;
		text-decoration: none;		
		color: #444;
		font-weight: 700;
		font-size: 15px;
		box-sizing: border-box;		
		overflow: hidden;
		padding-left: 10px;
		height: auto;
		overflow: hidden;
		margin-bottom: 5px;
	}
	.imsg .isub a{
		color: #232f3e;
		font-size: 15px;
	}
	.imsg .isub .unseen{
		color: #66cc66;
		font-size: 13px;
		float: right;
	}	
	.imsg .isub .from{
		color: #232f3e;
		font-size: 13px;
	}
	.imsg .isub .email{
		color: #444;
		font-size: 13px;
	}
	.imsg .itime{
		float: left;
		height: auto;
		text-decoration: none;		
		color: #666;
		font-weight: 300;
		font-size: 13px !important;
		box-sizing: border-box;		
		overflow: hidden;
		padding-left: 10px;
	}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">		
		$('.detail').click(function() {				
				$('.bottom1').css({'display': 'inherit'}); 				
		});

		$('.btnclose').click(function() {				
				$('.bottom1').css({'display': 'none'}); 				
		});		
</script>    
</head>
<body>
<?php echo $m; ?>
<form class="animated shake" id="login" method="POST" action="" style="min-width: 90%;" enctype="multipart/form-data">
<label>Nowa wiadomość</label>
<p class="error"><?php echo $error; ?></p>
	<input type="text" name="email" placeholder="Wyślij do adres e-mail">
	<input type="text" name="subject" placeholder="Tytuł wiadomości">
	<textarea name="msg" placeholder="Tresć wiadomości (text lub html)" style="min-height: 250px; max-height: 400px; padding: 5px;"></textarea>
	<input type="file" name="file">
	<input type="submit" name="add" value="Wyślij wiadomość" id="sendbtn">	
</form>
</body>
</html>
