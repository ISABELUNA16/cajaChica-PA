<?php
header('Content-type: text/html; charset=utf-8');
session_start();
error_reporting('E_ALL');
//require('core/pdo.php');
require('core/config.php');
//$db = Conn();

if (isset($_POST['send'])) {  
  if (!empty($_POST['email']) && !empty($_POST['pass'])) {
    $email = htmlentities($_POST['email'],ENT_QUOTES,'utf-8');
    $pass = htmlentities($_POST['pass'], ENT_QUOTES, 'utf-8');   
    $ibox = imap_open($IMAP, $email, $pass);
    if ($ibox === false) {      
      echo '<p class="toperror">Nie można się połączyć! Popraw dane logowania.</p>';
    }else{
      $_SESSION['login'] = 1;
      $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];  
      $_SESSION['email'] = $email;   
      $_SESSION['pass'] = $pass;    
      echo "Jesteś zalogowany(a)";
      header('Location: inbox.php');   
      die();
    }        
  }else{
    echo '<p class="toperror">Podaj adres email i hasło!</p>';
  }
}

/*
if (isset($_POST['send1'])) {  
  if (!empty($_POST['email']) || !empty($_POST['pass'])) {
    $email = htmlentities($_POST['email'],ENT_QUOTES,'utf-8');
    $pass = md5($_POST['pass']);      
    try {
      $s = $db->query("SELECT * FROM user WHERE email = '$email' AND pass = '$pass'");
      $rows = $s->fetchAll();   
      if ($s->rowCount() == 1) {
          $_SESSION['login'] = 1;
          $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];  
          $_SESSION['email'] = $email;
          header('Location: inbox.php');
          die();
      }else{
        echo'<p class="toperror">Błędny login lub hasło!</p>';
      }
    } catch (Exception $e) {      
      $code = $e->getCode();
      $msg = $e->getMessage();
    }
  }else{
    echo '<p class="toperror">Podaj adres email i hasło!</p>';
  }
}
*/

?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.5/socket.io.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>    
    <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
  <?php //require('menulogin.php'); ?>
      <form class="animated swing" id="login" method="POST" action="">
      <label><i class="fa fa-envelope"></i> Logowanie <small></small> </label>
      <input type="text" id="mnick" autocomplete="off" placeholder="Podaj login" name="email">
      <input type="password" id="mnick" autocomplete="off" placeholder="Podaj hasło" name="pass" >
      <input type="submit" name="send" class="animated bounce" value="Wejście" id="sendbtn">
    </form>
 <p class="footer">
  <a href="email.fxstar.eu"> www.fxstar.eu </a>
 </p>
</body>
<?php $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT); 
$_SESSION['color'] = $color;
if ($color == '#fff' || $color == '#ffffff') {
  $color = '#ff6600';  
}
?>
</html>
