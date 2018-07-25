<?php
header('Content-type: text/html; charset=utf-8');
session_start();
error_reporting('E_ALL');
require('core/config.php');
// get credentials from session

// chenge folder destination
$f = htmlentities($_GET['folder'], ENT_QUOTES, 'utf-8');
if (empty($f)) {
	$f = 'INBOX';
}

$ibox = imap_open($IMAP.$f, $_SESSION['email'], $_SESSION['pass']);
$count = imap_num_msg($ibox);

if ($ibox == false) {
	header('Location: index.php');
	exit;
}

$folders = imap_list($ibox, "{folders}", "*");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<title></title>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">  
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <meta name="description" content="Logowanie do panelu">
  <meta name="keywords" content="email client,e-mail,email,"> 	
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700|Roboto+Condensed:300,400,700&subset=latin-ext" rel="stylesheet">
<style type="text/css">
*{
	padding: 0px;
	margin: 0px;	
	font-size: 13px;      
	font-family: 'Roboto Condensed', sans-serif;    
    text-decoration: none;
    box-sizing: border-box;   
}
html{
	background: #f9f9f9;
}
.err{
	background: #fff;
	border: 1px solid #232f3e;
	color: #232f3e;
	padding: 10px;
	margin: 10px;
	overflow: hidden;
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
	transition: all 1s ease
}
.folders a:hover{
	background: linear-gradient(#232f3e,#2b3e50);
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
		margin: 5px;
		margin-left: 1%;
		margin-right: 1%;
		border-bottom: 1px solid #ddd;
		padding: 10px;
		background: #fff;
		box-shadow: 0px 1px 3px rgba(0,0,0,0.06);
		border-left: 1px solid #eee
	}

	.imsg:hover{
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
</head>
<body>
<?php
echo '<ul class="folders">';
foreach ($folders as $folder) {
    $folder = str_replace("{folders}", "", imap_utf7_decode($folder));

    if(strtolower($folder) == 'trash' || strtolower($folder) == 'kosz'){
    	//echo '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-trash-o"></i> ' . $folder . '</a></li>';
    	echo '<li><a href="inbox.php?folder=' . $folder . '">  <i class="fa fa-trash-o"></i> Kosz </a></li>';
	}else if(strtolower($folder) == 'send' || strtolower($folder) == 'sent'){
		//echo '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-send-o"></i> ' . $folder . '</a></li>';
		echo '<li><a href="inbox.php?folder=' . $folder . '">  <i class="fa fa-send-o"></i> Wysłane </a></li>';
	}else if(strtolower($folder) == 'odebrane' || strtolower($folder) == 'inbox'){
		//echo '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-envelope-o"></i> ' . $folder . '</a></li>'; 
		echo '<li><a href="inbox.php?folder=' . $folder . '">  <i class="fa fa-envelope-o"></i> Odebrane </a></li>';
	}else{
		echo '<li><a href="inbox.php?folder=' . $folder . '">  <i class="fa fa-trash-o"></i>'.$folder.'</a></li>';
	}
}
echo '<li><a href="sendemail.php">  <i class="fa fa-send"></i> Wyślij wiadomość </a></li>';
echo '<li><a href="logout.php">  <i class="fa fa-sign-out"></i> Wyloguj </a></li>';
echo "</ul>";



$del = (int)$_GET['msgid'];
if (!empty($del)) {
	$trash = 'Trash';
	if ($f == 'Trash') {
		$trash = 'INBOX';
	}
	//$r=imap_mail_copy($ibox, $del, $trash, CP_UID|CP_MOVE);	
	//$r=imap_mail_copy($ibox, $del, $trash, CP_UID|CP_MOVE);
	$r=imap_mail_move($ibox, $del, $trash, CP_UID);	
	if($r==false){die(imap_last_error());}
	// CP_UID FT_UID
	imap_expunge($ibox);
}

if ($count == 0) {
	echo $err = '<p class="err animated flipInX"> <i class="fa fa-bell-o"></i> Nie masz żadnych wiadomości </p>';
}else{
	echo $err = '<p class="err animated flipInX"> <i class="fa fa-bell-o"></i> '.$count.' wiadomości </p>';
}

$emails = imap_search($ibox,'ALL');
if ($emails) {
	// sort new first
	rsort($emails);
	// for every email
	foreach($emails as $nr) {
		// random avatar icon
		$src = 'http://www.gravatar.com/avatar/'.rand(999,974983).'?s=90&d=identicon&r=PG';
		//$src = 'http://www.gravatar.com/avatar/970584?s=90&d=identicon&r=PG';
		//$src = 'css/user1.png';

		// from email and nieprzeczytana
		$header = imap_headerinfo($ibox, $nr);
		//echo "<pre>";
		//print_r($header);

		$from = $header->from[0]->mailbox . "@" . $header->from[0]->host;
		$subject = quoted_printable_decode(imap_utf8($header->subject));
		$date = date('Y-m-d H:i:s',strtotime($header->date));

		$unseen = '<i class="fa fa-bell-slash-o" style="color: #f23"></i>';
		if($header->Unseen == 'U') {
       		$unseen = '<i class="fa fa-bell"></i>';	
    	}

    	/*
    	$uid = $nr;
    	// email uid
		$uid = imap_uid($ibox, $nr);
		echo '
			<div class="imsg animated fadeIn">
				<a href="mail.php?folder='.$f.'&msgid='.$uid.'" title="Przeczytaj wiadomość" target="_blank"> <img src="'.$src.'" class="avatar"> </a>
				<p class="isub"> <a href="mail.php?folder='.$f.'&msgid='.$uid.'" title="Temat wiadomości" target="_blank"> '.$subject.'</a> <a class="unseen">'.$unseen.'</a></p>
				<p class="isub"> <a class="from">'.$from.'</a> <a class="email" href="addkontakt.php?email='.$from.'">'.$from.' <i class="fa fa-user-plus"></i></a></p>
				<p class="itime" href=""> '.$date.'  <a class="unseen detail" title="Przenieś do kosza" style="margin-left: 5px; cursor: pointer; color: #666" href="?folder='.$f.'&msgid='.$uid.'"> <i class="fa fa-trash"></i> </a> </p>
			</div>
		';
		*/

    	$uid = $nr;
    	// email uid
		$uid = imap_uid($ibox, $nr);
    	// msg info
    	$overview = imap_fetch_overview($ibox,$nr);
		echo '
			<div class="imsg animated fadeIn">
				<a href="mail.php?folder='.$f.'&msgid='.$uid.'" title="Przeczytaj wiadomość"> <img src="'.$src.'" class="avatar"> </a>
				<p class="isub"> <a href="mail.php?folder='.$f.'&msgid='.$uid.'" title="Temat wiadomości"> '. quoted_printable_decode(imap_utf8($overview[0]->subject)).'</a> <a class="unseen">'.$unseen.'</a></p>
				<p class="isub"> <a class="from">'.imap_utf8($overview[0]->from).'</a> <a class="email" target="_blank" href="addkontakt.php?email='.$from.'" title="Dodaj do kontaktów">'.$from.' <i class="fa fa-user-plus"></i></a></p>
				<p class="itime" href=""> '.date('Y-m-d H:i:s',strtotime($overview[0]->date)).'  <a class="unseen detail" title="Przenieś do kosza" style="margin-left: 5px; cursor: pointer; color: #666" href="?folder='.$f.'&msgid='.$uid.'"> <i class="fa fa-trash"></i> </a> </p>
			</div>
		';
	
	}
}

imap_close($ibox);
?>

</body>
</html>

