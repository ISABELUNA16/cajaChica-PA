
<?php
    session_start();
	//include_once "Modulos/php_conexion.php";
	include_once "Modulos/funciones.php";
    $_SESSION['path'] = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>

<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>.: Inicio de sesion :.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #21355f;
            background-image: url(img/fondo.png);
            background-repeat: repeat;


            
        }
        
        .form-signin {
            max-width: 300px;
            padding: 19px 29px 29px;
            margin: 0 auto 20px;
            background-color: #fff;
            border: 1px solid #e5e5e5;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
                border-radius: 5px;
            -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
        }

        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }

        .form-signin input[type="text"],
        .form-signin input[type="password"] {
            font-size: 16px;
            height: auto;
            margin-bottom: 15px;
            padding: 7px 9px;
        }
        input{
            text-align:center;
        }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
<link rel="icon" type="image/png" sizes="32x32" href="ico/favicon.png">
  </head>

  <body>
    <div class="container">
	  <form name="form1" method="post" action="" class="form-signin">
      	<center><img src="img/logo-web-01-320x80.png"></center><br>
      	<?php
	  	if(!empty($_POST['usu']) and !empty($_POST['con'])){
			$usu=limpiar($_POST['usu']);
			$con=limpiar($_POST['con']);

            $serverName = "192.168.1.100"; //serverName\instanceName
            $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
            $conn = sqlsrv_connect( $serverName, $connectionInfo);

            if( $conn === false ) {
                echo mensajes(sqlsrv_errors().'<br>','rojo');
            }

            $sql = "SELECT * FROM vst_usuario WHERE usuario='$usu' and contrasena='$con'";
            $stmt = sqlsrv_query( $conn, $sql );

            if( $stmt === false){
                //die( print_r( sqlsrv_errors(), true) );
                echo mensajes(sqlsrv_errors().'<br>','rojo');
            }else{
                //echo $sql;

                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                    if($row['estado']==1){
                        $nombre=$row['nombres'];
                        $nombre=explode(" ", $nombre);
                        $nombre=$nombre[0];
                        $_SESSION['cod_user']=$row['id'];
                        $_SESSION['user_name']=$nombre;
                        $_SESSION['ape_paterno']=$row['paterno'];
                        $_SESSION['ape_materno']=$row['materno'];
                        $_SESSION['cod_perfil']=$row['iperfil'];
                        $_SESSION['nom_perfil']=$row['dperfil'];
                        echo mensajes('Bienvenido<br>'.$row['nombres'].' '.$row['paterno'].'<br> Ingresando, por favor espere...','verde').'<br>';
                        echo '<center><img src="img/ajax-loader.gif"></center><br>';
                        echo '<meta http-equiv="refresh" content="3;url=principal.php">';
                    }else{
                        echo mensajes('Usted no se encuentra Activo en la base de datos<br>Consulte con su Administrador de Sistema','rojo');
                        echo '<center><a href="index.php" class="btn"><strong>Intentar de Nuevo</strong></a></center>';
                    }
                }

                sqlsrv_free_stmt( $stmt);
            }

            sqlsrv_close($conn);
		}else{
			echo '	<input type="text" name="usu" class="input-block-level" placeholder="Usuario" autocomplete="off style="text-align:center;" required>
					<input type="password" name="con" class="input-block-level" placeholder="Contraseña" autocomplete="off" required>
					<div align="right"><button class="btn btn-large btn-primary" type="submit"><strong>Ingresar</strong></button></div>';
		}
	  ?>
      </form>
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
  </body>
</html>
