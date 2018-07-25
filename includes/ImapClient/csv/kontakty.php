<?php
error_reporting(0);
// pobierz kontakty
$file = fopen("contacts.csv","r");
while(! feof($file))
{
 $all[] = fgetcsv($file);
}
fclose($file);
echo "<pre>";
print_r($all);


$email = htmlentities($_POST['email'], ENT_QUOTES, 'utf-8');
$name = htmlentities($_POST['name'], ENT_QUOTES, 'utf-8');
$country = htmlentities($_POST['country'], ENT_QUOTES, 'utf-8');
$city = htmlentities($_POST['city'], ENT_QUOTES, 'utf-8');
$address = htmlentities($_POST['address'], ENT_QUOTES, 'utf-8');


if (!empty($email)) {	
	$a = serialize($all);

	if (strrpos($a, $email) == false) {	
	$kontakt = array($email,$name,$country,$city,$address);
	$fp = fopen('contacts.csv', 'a+');
	fputcsv($fp, $kontakt);
	//file_put_contents('contacts.csv', $kontakt, FILE_APPEND);
	}else{
		echo "Email już istnieje";
	}
}

?>


<form class="animated swing" id="login" method="POST" action="">
  <label><i class="fa fa-envelope"></i> Dodaj kontakt <small></small> </label>
  <input type="text" id="mnick" autocomplete="off" placeholder="Podaj login" name="email">
  <input type="password" id="mnick" autocomplete="off" placeholder="Podaj imie i nazwisko" name="name" >
  <input type="text" id="mnick" autocomplete="off" placeholder="Podaj kraj" name="country">
  <input type="password" id="mnick" autocomplete="off" placeholder="Podaj miasto" name="city" >  
  <input type="text" id="mnick" autocomplete="off" placeholder="Podaj adres" name="address">  
  <input type="submit" name="send" class="animated bounce" value="Wejście" id="sendbtn">
</form>
