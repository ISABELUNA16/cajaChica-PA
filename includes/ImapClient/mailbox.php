<!DOCTYPE html>
<html>
<head>
	<title>Twoje wiadomości</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">  
	<meta name="viewport" content="width=device-width, initial-scale=1">  
	<meta name="description" content="Logowanie do panelu administracyjnego.">
	<meta name="keywords" content="e-mail,email,mail,newsletter,serwery pocztowe,konta e-mail,wysyłka email,wiadomości email,newsletter script">  

    <!-- Socket.IO <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.5/socket.io.js"></script> -->
    <!-- JQUERY <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,latin-ext" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

	<style type="text/css">
	*{
		font-family: 'Open Sans';
		font-size: 13px;
		padding: 0px;
		margin: 0px;
		box-sizing: border-box;
		list-style: none;
	}
	body{
		background: #f9f9f9;
	}
	li{
		padding: 5px;
		float: left;
		display: inline;
		border-bottom: 1px solid #eee;
	}
	.top{
		position: fixed;
		top: 0px;
		left: 0px;
		width: 100%;
		height: 50px;
		background: #fff;
		border-bottom: 1px solid #eee;
		z-index: 500;
		font-size: 25px; color: #66c666
	}
	.left{
		position: fixed;
		top: 0px;
		left: 0px;
		width: 30%;
		min-height: 100%;
		border-right: 1px solid #eee;
		padding: 0px;
		overflow: hidden;
		padding-top: 50px;
	}
	.right{
		position: absolute;
		top: 0px;
		left: 30%;		
		width: 70%;
		min-height: 100%;
		padding: 0px;
		padding-top: 50px;
		box-shadow: 0px 0px 3px rgba(0,0,0,0.06);
		background: #f9f9f9;
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

	.imsg{
		min-width: 100%;
		float: left;
		border-bottom: 1px solid #ddd;
		padding: 10px;
		margin: 5px;
		background: #fff;
		box-shadow: 0px 1px 3px rgba(0,0,0,0.06);
		border-left: 1px solid #eee
	}
	.imsg:hover{
		border-left: 3px solid #66c666;
		cursor: pointer;
		background: #D5E8CF
	}
	.imsg .avatar{
		position: relative;
		float: left;
		max-width: 10%;
		min-width: 10%;
				border: 1px solid #eee;
		border-radius: 100px;
		padding: 2px;
	}
	.imsg .isub{
		float: left;
		height: auto;
		min-width: 90%;
		text-decoration: none;		
		color: #444;
		font-weight: 700;
		font-size: 12px;
		box-sizing: border-box;		
		overflow: hidden;
		padding-left: 5px;
	}
	.imsg .itime small{
		float: left;
		height: auto;
		text-decoration: none;		
		color: #666;
		font-weight: 300;
		font-size: 11px !important;
		box-sizing: border-box;		
		overflow: hidden;
		padding-left: 5px;
	}


	.right .email{
		margin: 10px auto;
		padding: 10px;
		background: #fff;
		max-width: 700px;
		overflow: hidden;
	}
	.right .imsg{
		min-width: 100%;
		float: left;
		padding: 10px;
		margin: 0px;
		background: #fff;
		box-shadow: 0px 1px 3px rgba(0,0,0,0.05);
		border: 0px;
		margin-bottom: 20px;
	}
	.right .imsg:hover{
		
	}
	.right .imsg .avatar{
		position: relative;
		float: left;
		min-width: 5%;
		max-width: 64px !important;
		border: 1px solid #eee;
		border-radius: 100px;
		padding: 4px;
	}
	.right .imsg .isub{
		float: left;
		height: auto;
		min-width: 90%;
		text-decoration: none;		
		color: #444;
		font-weight: 700;
		font-size: 13px;
		box-sizing: border-box;		
		overflow: hidden;
		padding-left: 5px;
	}
	.right .imsg .itime small{
		float: left;
		height: auto;
		text-decoration: none;		
		color: #666;
		font-weight: 300;
		font-size: 13px !important;
		box-sizing: border-box;		
		overflow: hidden;
		padding-left: 5px;
	}
	.right .imsg .ibox{
		box-sizing: border-box;
		min-width: 90%;
		float: right;
		padding-top: 20px;		
	}
	.right .imsg .ibox .ibtn{
		float: right;
		margin-left: 5px;
		color: #66c666;
		border: 1px solid #66c666;
		padding: 5px;
		border-radius: 5px;
		width: 28px;
		height: 28px;
		text-align: center;
		font-size: 11px;
	}
	.right .imsg .ibox .ibtn:hover{
		color: #fff;
		background: #66c666
	}
	</style>
</head>
<body>
<div class="top">
	Newsletter
</div>
	<li class="left">
	<div class="imsgtime">		
		<a class="itime"> <i class="fa fa-clock-o" aria-hidden="true"></i> <small><?php echo date('Y-m-d H:i:s', time()); ?></small></a>
	</div>

	<div class="imsg">
		<img src="https://fxstar.eu/media/11_fxstaruser.png" class="avatar">
		<a class="isub" href="">Temat wiadomości</a>
		<a class="itime" href=""> <small> 2016-08-29 </small></a>
	</div>
		<?php
		for($i = 0; $i < 5;$i++){
		$src = 'http://www.gravatar.com/avatar/'.rand(999,974983).'?s=90&d=identicon&r=PG';
		$t = date('Y-m-d H:i:s', time()-$i*rand(999,98745));
		echo '
			<a href=""> <div class="imsg">
				<img src="'.$src.'" class="avatar">
				<a class="isub" href="">Temat wiadomości</a>
				<a class="itime" href=""> <small> '.$t.' </small></a>
			</div></a>
		';
		}
		?>
	<div class="imsgtime">		
		<a class="itime"> <i class="fa fa-clock-o" aria-hidden="true"></i> <small>2016-08-25</small></a>
	</div>
		<?php
		for($i = 0; $i < 5;$i++){
		$src = 'http://www.gravatar.com/avatar/'.rand(999,974983).'?s=90&d=identicon&r=PG';
		echo '
			<a href=""> <div class="imsg">
				<img src="'.$src.'" class="avatar">
				<a class="isub" href="">Temat wiadomości</a>
				<a class="itime" href=""> <small> 2016-08-29 </small></a>
			</div></a>
		';
		}
		?>
	</li>
	<li class="right">

	<div class="imsg">
		<img src="https://fxstar.eu/media/11_fxstaruser.png" class="avatar">
		<a class="isub" href="">Temat wiadomości</a>
		<a class="itime" href=""> <small> 2016-08-29 </small></a>
		<p class="ibox">
			<a class="ibtn" href=""><i class="fa fa-trash"></i></a>			
			<a class="ibtn" href=""><i class="fa fa-heart-o"></i></a>		
			<a class="ibtn" href=""><i class="fa fa-user"></i></a>
			<a class="ibtn" href=""><i class="fa fa-reply"></i></a>	
		</p>
	</div>	
	<div class="email"> 
	<h1>Skąd się to wzięło?</h1>
		eciwieństwie do zwykłego: „tekst, tekst, tekst”, sprawiającego, że wygląda to „zbyt czytelnie” po polsku. Wielu webmasterów i designerów używa Lorem Ipsum jako domyślnego modelu tekstu i wpisanie w internetowej wyszukiwarce ‘lorem ipsum’ spowoduje znalezienie bardzo wielu stron, które wciąż są w budowie. Wiele wersji tekstu ewoluowało i zmieniało się przez lata, czasem przez przypadek, czasem specjalnie (humorystyczne wstawki itd).	

	
		eciwieństwie do zwykłego: „tekst, tekst, tekst”, sprawiającego, że wygląda to „zbyt czytelnie” po polsku. Wielu webmasterów i designerów używa Lorem Ipsum jako domyślnego modelu tekstu i wpisanie w internetowej wyszukiwarce ‘lorem ipsum’ spowoduje znalezienie bardzo wielu stron, które wciąż są w budowie. Wiele wersji tekstu ewoluowało i zmieniało się przez lata, czasem przez przypadek, czasem specjalnie (humorystyczne wstawki itd).

		Skąd się to wzięło?

		W przeciwieństwie do rozpowszechnionych opinii, Lorem Ipsum nie jest tylko przypadkowym tekstem. Ma ono korzenie w klasycznej łacińskiej literaturze z 45 roku przed Chrystusem, czyli ponad 2000 lat temu! Richard McClintock, wykładowca łaciny na uniwersytecie Hampden-Sydney w Virginii, przyjrzał się uważniej jednemu z najbardziej niejasnych słów w Lorem Ipsum – consectetur – i po wielu poszukiwaniach eciwieństwie do zwykłego: „tekst, tekst, tekst”, sprawiającego, że wygląda to „zbyt czytelnie” po polsku. Wielu webmasterów i designerów używa Lorem Ipsum jako domyślnego modelu tekstu i wpisanie w internetowej wyszukiwarce ‘lorem ipsum’ spowoduje znalezienie bardzo wielu stron, które wciąż są w budowie. Wiele wersji tekstu ewoluowało i zmieniało się przez lata, czasem przez przypadek, czasem specjalnie (humorystyczne wstawki itd).
	<img src="http://www.hamann-motorsport.com/fileadmin/user_upload/assets/fotos/showroom/lamborghini-aventador/lamborghini_aventador_01.jpg" width="100%" height="400px">
	<h1>Skąd się to wzięło?</h1>

W przeciwieństwie do rozpowszechnionych opinii, Lorem Ipsum nie jest tylko przypadkowym tekstem. Ma ono korzenie w klasycznej łacińskiej literaturze z 45 roku przed Chrystusem, czyli ponad 2000 lat temu! Richard McClintock, wykładowca łaciny na uniwersytecie Hampden-Sydney w Virginii, przyjrzał się uważniej jednemu z najbardziej niejasnych słów w Lorem Ipsum – consectetur – i po wielu poszukiwaniach odnalazł niezaprzeczalne źródło: Lorem Ipsum pochodzi z fragmentów (1.10.32 i 1.10.33) „de Finibus Bonorum et Malorum”, czyli „O granicy dobra i zła”, napisanej właśnie w 45 p.n.e. przez Cycerona. Jest to bardzo popularna w czasach renesansu rozprawa na temat etyki. Pierwszy wiersz Lorem Ipsum, „Lorem ipsum dolor sit amet...” pochodzi właśnie z sekcji 1.10.32.

Standardowy blok Lorem Ipsum, używany od XV wieku, jest odtworzony niżej dla zainteresowanych. Fragmenty 1.10.32 i 1.10.33 z „de Finibus Bonorum et Malorum” Cycerona, są odtworzone w dokładnej, oryginalnej formie, wraz z angielskimi tłumaczeniami H. Rackhama z 1914 roku.
Skąd to wziąć?

Jest dostępnych wiele różnych wersji Lorem Ipsum, ale większość zmieniła się pod wpływem dodanego humoru czy przypadkowych słów, które nawet w najmniejszym stopniu nie przypominają istniejących. Jeśli masz zamiar użyć fragmentu Lorem Ipsum, lepiej mieć pewność, że nie ma niczego „dziwnego” w środku tekstu. Wszystkie Internetowe generatory Lorem Ipsum mają tendencje do kopiowania już istniejących bloków, co czyni nasz pierwszym prawdziwym generatorem w Internecie. Używamy zawierającego ponad 200 łacińskich słów słownika, w kontekście wielu znanych sentencji, by wygenerować tekst wyglądający odpowiednio. To wszystko czyni „nasz” Lorem Ipsum wolnym od powtórzeń, humorystycznych wstawek czy niecharakterystycznych słów.eciwieństwie do zwykłego: „tekst, tekst, tekst”, sprawiającego, że wygląda to „zbyt czytelnie” po polsku. Wielu webmasterów i designerów używa Lorem Ipsum jako domyślnego modelu tekstu i wpisanie w internetowej wyszukiwarce ‘lorem ipsum’ spowoduje znalezienie bardzo wielu stron, które wciąż są w budowie. Wiele wersji tekstu ewoluowało i zmieniało się przez lata, czasem przez przypadek, czasem specjalnie (humorystyczne wstawki itd).

Skąd się to wzięło?

W przeciwieństwie do rozpowszechnionych opinii, Lorem Ipsum nie jest tylko przypadkowym tekstem. Ma ono korzenie w klasycznej łacińskiej literaturze z 45 roku przed Chrystusem, czyli ponad 2000 lat temu! Richard McClintock, wykładowca łaciny na uniwersytecie Hampden-Sydney w Virginii, przyjrzał się uważniej jednemu z najbardziej niejasnych słów w Lorem Ipsum – consectetur – i po wielu poszukiwaniach odnalazł niezaprzeczalne źródło: Lorem Ipsum pochodzi z fragmentów (1.10.32 i 1.10.33) „de Finibus Bonorum et Malorum”, czyli „O granicy dobra i zła”, napisanej właśnie w 45 p.n.e. przez Cycerona. Jest to bardzo popularna w czasach renesansu rozprawa na temat etyki. Pierwszy wiersz Lorem Ipsum, „Lorem ipsum dolor sit amet...” pochodzi właśnie z sekcji 1.10.32.

Standardowy blok Lorem Ipsum, używany od XV wieku, jest odtworzony niżej dla zainteresowanych. Fragmenty 1.10.32 i 1.10.33 z „de Finibus Bonorum et Malorum” Cycerona, są odtworzone w dokładnej, oryginalnej formie, wraz z angielskimi tłumaczeniami H. Rackhama z 1914 roku.
Skąd to wziąć?

Jest dostępnych wiele różnych wersji Lorem Ipsum, ale większość zmieniła się pod wpływem dodanego humoru czy przypadkowych słów, które nawet w najmniejszym stopniu nie przypominają istniejących. Jeśli masz zamiar użyć fragmentu Lorem Ipsum, lepiej mieć pewność, że nie ma niczego „dziwnego” w środku tekstu. Wszystkie Internetowe generatory Lorem Ipsum mają tendencje do kopiowania już istniejących bloków, co czyni nasz pierwszym prawdziwym generatorem w Internecie. Używamy zawierającego ponad 200 łacińskich słów słownika, w kontekście wielu znanych sentencji, by wygenerować tekst wyglądający odpowiednio. To wszystko czyni „nasz” Lorem Ipsum wolnym od powtórzeń, humorystycznych wstawek czy niecharakterystycznych słów.eciwieństwie do zwykłego: „tekst, tekst, tekst”, sprawiającego, że wygląda to „zbyt czytelnie” po polsku. Wielu webmasterów i designerów używa Lorem Ipsum jako domyślnego modelu tekstu i wpisanie w internetowej wyszukiwarce ‘lorem ipsum’ spowoduje znalezienie bardzo wielu stron, które wciąż są w budowie. Wiele wersji tekstu ewoluowało i zmieniało się przez lata, czasem przez przypadek, czasem specjalnie (humorystyczne wstawki itd).

Skąd się to wzięło?

W przeciwieństwie do rozpowszechnionych opinii, Lorem Ipsum nie jest tylko przypadkowym tekstem. Ma ono korzenie w klasycznej łacińskiej literaturze z 45 roku przed Chrystusem, czyli ponad 2000 lat temu! Richard McClintock, wykładowca łaciny na uniwersytecie Hampden-Sydney w Virginii, przyjrzał się uważniej jednemu z najbardziej niejasnych słów w Lorem Ipsum – consectetur – i po wielu poszukiwaniach odnalazł niezaprzeczalne źródło: Lorem Ipsum pochodzi z fragmentów (1.10.32 i 1.10.33) „de Finibus Bonorum et Malorum”, czyli „O granicy dobra i zła”, napisanej właśnie w 45 p.n.e. przez Cycerona. Jest to bardzo popularna w czasach renesansu rozprawa na temat etyki. Pierwszy wiersz Lorem Ipsum, „Lorem ipsum dolor sit amet...” pochodzi właśnie z sekcji 1.10.32.

Standardowy blok Lorem Ipsum, używany od XV wieku, jest odtworzony niżej dla zainteresowanych. Fragmenty 1.10.32 i 1.10.33 z „de Finibus Bonorum et Malorum” Cycerona, są odtworzone w dokładnej, oryginalnej formie, wraz z angielskimi tłumaczeniami H. Rackhama z 1914 roku.
Skąd to wziąć?

Jest dostępnych wiele różnych wersji Lorem Ipsum, ale większość zmieniła się pod wpływem dodanego humoru czy przypadkowych słów, które nawet w najmniejszym stopniu nie przypominają istniejących. Jeśli masz zamiar użyć fragmentu Lorem Ipsum, lepiej mieć pewność, że nie ma niczego „dziwnego” w środku tekstu. Wszystkie Internetowe generatory Lorem Ipsum mają tendencje do kopiowania już istniejących bloków, co czyni nasz pierwszym prawdziwym generatorem w Internecie. Używamy zawierającego ponad 200 łacińskich słów słownika, w kontekście wielu znanych sentencji, by wygenerować tekst wyglądający odpowiednio. To wszystko czyni „nasz” Lorem Ipsum wolnym od powtórzeń, humorystycznych wstawek czy niecharakterystycznych słów.eciwieństwie do zwykłego: „tekst, tekst, tekst”, sprawiającego, że wygląda to „zbyt czytelnie” po polsku. Wielu webmasterów i designerów używa Lorem Ipsum jako domyślnego modelu tekstu i wpisanie w internetowej wyszukiwarce ‘lorem ipsum’ spowoduje znalezienie bardzo wielu stron, które wciąż są w budowie. Wiele wersji tekstu ewoluowało i zmieniało się przez lata, czasem przez przypadek, czasem specjalnie (humorystyczne wstawki itd).

Skąd się to wzięło?

W przeciwieństwie do rozpowszechnionych opinii, Lorem Ipsum nie jest tylko przypadkowym tekstem. Ma ono korzenie w klasycznej łacińskiej literaturze z 45 roku przed Chrystusem, czyli ponad 2000 lat temu! Richard McClintock, wykładowca łaciny na uniwersytecie Hampden-Sydney w Virginii, przyjrzał się uważniej jednemu z najbardziej niejasnych słów w Lorem Ipsum – consectetur – i po wielu poszukiwaniach odnalazł niezaprzeczalne źródło: Lorem Ipsum pochodzi z fragmentów (1.10.32 i 1.10.33) „de Finibus Bonorum et Malorum”, czyli „O granicy dobra i zła”, napisanej właśnie w 45 p.n.e. przez Cycerona. Jest to bardzo popularna w czasach renesansu rozprawa na temat etyki. Pierwszy wiersz Lorem Ipsum, „Lorem ipsum dolor sit amet...” pochodzi właśnie z sekcji 1.10.32.

Standardowy blok Lorem Ipsum, używany od XV wieku, jest odtworzony niżej dla zainteresowanych. Fragmenty 1.10.32 i 1.10.33 z „de Finibus Bonorum et Malorum” Cycerona, są odtworzone w dokładnej, oryginalnej formie, wraz z angielskimi tłumaczeniami H. Rackhama z 1914 roku.
Skąd to wziąć?

Jest dostępnych wiele różnych wersji Lorem Ipsum, ale większość zmieniła się pod wpływem dodanego humoru czy przypadkowych słów, które nawet w najmniejszym stopniu nie przypominają istniejących. Jeśli masz zamiar użyć fragmentu Lorem Ipsum, lepiej mieć pewność, że nie ma niczego „dziwnego” w środku tekstu. Wszystkie Internetowe generatory Lorem Ipsum mają tendencje do kopiowania już istniejących bloków, co czyni nasz pierwszym prawdziwym generatorem w Internecie. Używamy zawierającego ponad 200 łacińskich słów słownika, w kontekście wielu znanych sentencji, by wygenerować tekst wyglądający odpowiednio. To wszystko czyni „nasz” Lorem Ipsum wolnym od powtórzeń, humorystycznych wstawek czy niecharakterystycznych słów.odnalazł niezaprzeczalne źródło: Lorem Ipsum pochodzi z fragmentów (1.10.32 i 1.10.33) „de Finibus Bonorum et Malorum”, czyli „O granicy dobra i zła”, napisanej właśnie w 45 p.n.e. przez Cycerona. Jest to bardzo popularna w czasach renesansu rozprawa na temat etyki. Pierwszy wiersz Lorem Ipsum, „Lorem ipsum dolor sit amet...” pochodzi właśnie z sekcji 1.10.32.

Standardowy blok Lorem Ipsum, używany od XV wieku, jest odtworzony niżej dla zainteresowanych. Fragmenty 1.10.32 i 1.10.33 z „de Finibus Bonorum et Malorum” Cycerona, są odtworzone w dokładnej, oryginalnej formie, wraz z angielskimi tłumaczeniami H. Rackhama z 1914 roku.
Skąd to wziąć?

Jest dostępnych wiele różnych wersji Lorem Ipsum, ale większość zmieniła się pod wpływem dodanego humoru czy przypadkowych słów, które nawet w najmniejszym stopniu nie przypominają istniejących. Jeśli masz zamiar użyć fragmentu Lorem Ipsum, lepiej mieć pewność, że nie ma niczego „dziwnego” w środku tekstu. Wszystkie Internetowe generatory Lorem Ipsum mają tendencje do kopiowania już istniejących bloków, co czyni nasz pierwszym prawdziwym generatorem w Internecie. Używamy zawierającego ponad 200 łacińskich słów słownika, w kontekście wielu znanych sentencji, by wygenerować tekst wyglądający odpowiednio. To wszystko czyni „nasz” Lorem Ipsum wolnym od powtórzeń, humorystycznych wstawek czy niecharakterystycznych słów.
</div>
	</li>

</body>
</html>