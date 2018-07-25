<?php
header('Content-type: text/html; charset=utf-8');
session_start();
error_reporting('E_ALL');
require('core/config.php');

// chenge folder destination
$f = htmlentities($_GET['folder'], ENT_QUOTES, 'utf-8');
if (empty($f)) {
	$f = 'INBOX';
}

$tmpfolder = md5($_SESSION['email']);
mkdir('media/'.$tmpfolder);
$tmpdir = 'media/'.$tmpfolder;
$_SESSION['tmpdir'] = $tmpdir;
chmod($tmpdir, 755);

// get credentials from session
$ibox = imap_open($IMAP.$f, $_SESSION['email'], $_SESSION['pass']);
$folders = imap_list($ibox, "{folders}", "*");

echo '<ul class="folders">';
foreach ($folders as $folder) {
    $folder = str_replace("{folders}", "", imap_utf7_decode($folder));

    if(strtolower($folder) == 'trash' || strtolower($folder) == 'kosz'){
    	//echo '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-trash-o"></i> ' . $folder . '</a></li>';
    	echo '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-trash-o"></i> Kosz </a></li>';
	}else if(strtolower($folder) == 'send' || strtolower($folder) == 'sent'){
		//echo '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-send-o"></i> ' . $folder . '</a></li>';
		echo '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-send-o"></i> Wysłane </a></li>';
	}else if(strtolower($folder) == 'odebrane' || strtolower($folder) == 'inbox'){
		//echo '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-envelope-o"></i> ' . $folder . '</a></li>'; 
		echo '<li><a href="inbox.php?folder=' . $folder . '&func=view">  <i class="fa fa-envelope-o"></i> Odebrane </a></li>';
	}
}
echo '<li><a href="sendemail.php">  <i class="fa fa-send"></i> Wyślij wiadomość </a></li>';
echo '<li><a href="logout.php">  <i class="fa fa-sign-out"></i> Wyloguj </a></li>';
echo "</ul>";


//$nr = imap_uid($ibox, 3);
$uid = (int)$_GET['msgid'];
//$nr = imap_uid($ibox, $nr);
$nr = imap_msgno($ibox,$uid);

// $status = imap_setflag_full($imap, $uid, "\Seen \Flagged", ST_UID);
$status = imap_setflag_full($ibox, $nr, "\Seen \Flagged", ST_UID);
//imap_delete($imap, $uid, FT_UID);
//imap_expunge($imap);
		
		// header details IP, traceroute
		$info = imap_fetchheader($ibox, $nr);
		// from mime type
		//$info2 = imap_fetchmime($ibox, $uid, FT_UID);
		//$elements = imap_mime_header_decode($info2);

		// random avatar icon
		$src = 'http://www.gravatar.com/avatar/'.rand(999,974983).'?s=90&d=identicon&r=PG';

		// from email and nieprzeczytana
		$header = imap_headerinfo($ibox, $nr);
		$from = $header->from[0]->mailbox . "@" . $header->from[0]->host;
		$unseen = '<i class="fa fa-bell-slash-o" style="color: #f23"></i>';
		if($header->Unseen == 'U') {
       		$unseen = '<i class="fa fa-bell"></i>';	
    	}

		$message = imap_fetchbody($ibox,$nr);

		// emoticony w wiadomości
		$se = imap_fetchstructure($ibox, $nr, 1);
		//echo "<pre>";
		//print_r($se);


		if(true){
			require('core/class.EmailMessage.php');
			// the number in constructor is the message number
			$emailMessage = new EmailMessage($ibox, $nr);
			// set to true to get the message parts (or don't set to false, the default is true)
			$emailMessage->getAttachments = true;
			$emailMessage->fetch();
			preg_match_all('/src="cid:(.*)"/Uims', $emailMessage->bodyHTML, $matches);
			if(count($matches)) {				
				$search = array();
				$replace = array();
				//echo $DOMAIN = $_SERVER['HTTP_HOST'];	
				//echo $_SERVER["DOCUMENT_ROOT"];
				// dfolder from url
				$DOMAIN = $_SERVER["HTTP_HOST"].pathinfo($_SERVER["REQUEST_URI"], PATHINFO_DIRNAME);
				foreach($matches[1] as $match) {
					$uniqueFilename = explode('@',$match)[0];
					$ext = pathinfo($uniqueFilename, PATHINFO_EXTENSION);
					//if($ext == 'jpg' || $ext == 'png' || $ext == 'gif' || $ext == 'jpeg' || $ext == 'bmp'){
					if($ext != 'php' && $ext != 'cgi'){
					file_put_contents($tmpdir."/".$uid."-$uniqueFilename", $emailMessage->attachments[$match]['data']);
					$search[] = "src=\"cid:$match\"";
					$replace[] = "src=\"http://$DOMAIN/".$tmpdir."/".$uid."-$uniqueFilename\"";
					}				
				}					
				$part = explode('<br />', $emailMessage->bodyHTML);
				$emailMessage->bodyHTML = implode('', $part);
				$emailMessage->bodyHTML = str_replace($search, $replace, $emailMessage->bodyHTML);
			}
		}

		//get message body		
        if($message == ''){        	
        	//$message = quoted_printable_decode(imap_fetchbody($ibox,$nr,1.2));
        	$message = html_entity_decode($emailMessage->bodyHTML);        	
        }  
		if($message == '')
        {
           $message = quoted_printable_decode(imap_fetchbody($ibox,$nr,1.1));
        }		
        if($message == '')
        {
        	print_r(imap_fetchbody($ibox,$nr,1));

            //$message = quoted_printable_decode(imap_fetchbody($ibox,$nr,1));

        }
        file_put_contents($tmpdir."/".$uid.'.html', $message);

    	$overview = imap_fetch_overview($ibox,$nr);
		echo '
			<div class="imsg animated fadeIn">
				<a href="mail.php?folder='.$f.'&msgid='.$nr.'" title="Przeczytaj wiadomość"> <img src="'.$src.'" class="avatar"> </a>
				<p class="isub"> 
					<a href="mail.php?msgid='.$nr.'" title="Temat wiadomości"> '.quoted_printable_decode(imap_utf8($overview[0]->subject)).'</a> 
					<a class="unseen">'.$unseen.'</a>					
				</p>
				<p class="isub"> <a class="from">'.imap_utf8($overview[0]->from).'</a> <a class="email">'.$from.'</a></p>
				<p class="itime" href=""> '.date('Y-m-d H:i:s',strtotime($overview[0]->date)).' <a class="unseen detail" title="Szczegóły wiadomości" style="margin-left: 5px; cursor: pointer; color: #666"> <i class="fa fa-info-circle"></i> </a></p>
			</div>
		';


$structure = imap_fetchstructure($ibox,$nr,0);
//echo "<pre>";
//print_r($structure);

$attachments = array();
if(isset($structure->parts) && count($structure->parts) > 0) {
	for($i = 0; $i < count($structure->parts); $i++) {

		$attachments[$i] = array(
			'is_attachment' => false,
			'filename' => '',
			'name' => '',
			'attachment' => ''
		);
		if($structure->parts[$i]->ifdparameters) {
			foreach($structure->parts[$i]->dparameters as $object) {
				if(strtolower($object->attribute) == 'filename') {
					$attachments[$i]['is_attachment'] = true;
					$attachments[$i]['filename'] = $object->value;
				}
			}
		}
		
		if($structure->parts[$i]->ifparameters) {
			foreach($structure->parts[$i]->parameters as $object) {
				if(strtolower($object->attribute) == 'name') {
					$attachments[$i]['is_attachment'] = true;
					$attachments[$i]['name'] = $object->value;
				}
			}
		}
		
		if($attachments[$i]['is_attachment']) {
			$attachments[$i]['attachment'] = imap_fetchbody($ibox, $nr, $i+1);
			if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
				$attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
			}
			elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
				$attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
			}
		}
	}
}

/* iterate through each attachment and save it */
foreach($attachments as $attachment)
{

    if($attachment['is_attachment'] == 1 && !empty($attachment['name']))
    {
        $filename = $attachment['name'];
        if(empty($filename)) $filename = $attachment['filename'];

        if(empty($filename)) $filename = time().".dat";

        /* prefix the email number to the filename in case two emails
         * have the attachment with the same file name.
         */
        //$fp = fopen("media/".$nr . "-" . $filename, "w+");
        $fp = fopen($tmpdir."/".$filename, "w+");
        fwrite($fp, $attachment['attachment']);
        fclose($fp);
    }

}

echo '<div class="bottom">';
foreach ($attachments as $v) {	
	if (!empty($v['filename']) && pathinfo(basename($attachment['name']),PATHINFO_EXTENSION) != 'dat') {
		echo '<a class="file" target="_blank" href="'.$tmpdir."/".$v['filename'].'">'.$v['filename'].'</a>';	
	}	
}
echo '</div>';

echo '<div class="bottom1"> 
	<p class="title"> Szczegóły wiadomości  <a class="unseen btnclose" title="Szczegóły wiadomości" style="float: right; margin-right: 5px; cursor: pointer; color: #f22"> <i class="fa fa-close"></i> </a> </p>
';
echo nl2br($info);
echo '</div>';
		
//echo '<div class="body">'.imap_utf8($message).'</div>';
echo '<div class="body"><iframe src="'.$tmpdir."/".$uid.'.html" sandbox="allow-same-origin allow-popups allow-forms"></iframe></div>';

imap_expunge($ibox);
imap_close($ibox,CL_EXPUNGE);
?>


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
