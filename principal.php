<?php
	session_start();
	//include_once "Modulos/php_conexion.php";
	//include_once "Modulos/class_buscar.php";

	include_once "Modulos/funciones.php";	
    if($_SESSION['nom_perfil']==''){
	
    	header('Location:index.php');
	
    }else{
        
        $_SESSION['path']=$_SESSION['path'];
        $_SESSION['cod_user']=limpiar($_SESSION['cod_user']);
        $_SESSION['user_name']=limpiar($_SESSION['user_name']);
        $_SESSION['ape_paterno']=limpiar($_SESSION['ape_paterno']);
        $_SESSION['ape_materno']=limpiar($_SESSION['ape_materno']);
        $_SESSION['cod_perfil']=limpiar($_SESSION['cod_perfil']);
        $_SESSION['nom_perfil']=limpiar($_SESSION['nom_perfil']);

            $serverName = "192.168.1.100"; //serverName\instanceName
            $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
            $conn = sqlsrv_connect( $serverName, $connectionInfo);

        if( $conn === false ) {
            echo mensajes('Hubo un error de conexión.','rojo');
        }

        $sql = "SELECT * FROM vst_permiso WHERE iperfil=".$_SESSION["cod_perfil"];
        $stmt = sqlsrv_query($conn, $sql);

        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
           
            $_SESSION['Movimiento']=$row['movimiento'];
            $_SESSION['MovimientoLectura']=$row['movimientol'];
            $_SESSION['Mantenimiento']=$row['mantenimiento'];
            $_SESSION['Transacciones']=$row['transacciones'];
            $_SESSION['TransaccionesLectura']=$row['transaccionesl'];
            $_SESSION['Comprobantes']=$row['comprobantes'];
            $_SESSION['ComprobantesLectura']=$row['comprobantesl'];
            $_SESSION['Proveedores']=$row['proveedores'];
            $_SESSION['ProveedoresLectura']=$row['proveedoresl'];
            $_SESSION['Seguridad']=$row['seguridad'];
            $_SESSION['Perfil']=$row['perfil'];
            $_SESSION['PerfilLectura']=$row['perfill'];
            $_SESSION['Permiso']=$row['permiso'];
            $_SESSION['PermisoLectura']=$row['permisol'];
            $_SESSION['Usuario']=$row['usuario'];
            $_SESSION['UsuarioLectura']=$row['usuariol'];
        }
        sqlsrv_free_stmt( $stmt);
        sqlsrv_close($conn);
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>.: Principal :.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
            
            body {
                padding-top: 60px;
                padding-bottom: 40px;
                background-color: #2f5a78;
                background-repeat: repeat;
            }
            
            </style>
        <link href="css/bootstrap-responsive.css" rel="stylesheet">


        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="ico/favicon.png">
    </head>
    <?php include_once "Modulos/m_principal.php"; ?>
    <div align="center">
        <!-- <h2><?php echo "Nivel: ".$_SESSION['nom_peril']; ?></h2> -->
        <h2><?php echo $_SESSION['nom_perfil']; ?></h2>
        <table width="60%">
            <tr>          

                <td>
                    <table class="table table-bordered">
                        <tr class="info" style="background-color: #ff8600;">
                             <td colspan="2"><h2 align="center"><img src="img/alertas.png" width="80" height="80">Alertas</h2></td>
                            </tr>
                        <tr>
                         <td>
                            <div align="center">
                            <h4>
                         <i class="icon-ok"></i>
                            <?php

                                $serverName = "192.168.1.100"; //serverName\instanceName
                                $connectionInfo = array("Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");

                                $conn = sqlsrv_connect( $serverName, $connectionInfo);

                                if( $conn === false ) {
                                    echo mensajes('Hubo un error de conexión.','rojo');
                                }

                         $fecha= "03/11/2016";
                         $sql = "select count(*) as movimiento from vst_movimiento where ipersonal = ".$_SESSION["cod_user"]." and fecha = '$fecha' and estado = 1";
                         $stmt = sqlsrv_query($conn, $sql);

                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                       
                            if($row['movimiento']==0){
                                 echo "No se ha encontrado movimientos en su caja.";
                                }else{
                               
                                if($row['movimiento']==1){
                                    echo "Tiene ".$row['movimiento']." movimiento nuevo por revisar.";
                                }else{
                                    echo "Tiene ".$row['movimiento']." movimientos nuevos por revisar.";
                                }
                            }
                        }

                        sqlsrv_free_stmt( $stmt);
                        sqlsrv_close($conn);
                        ?>
                        </h4>
                        </div>
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

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
