<?php 
	session_start();
	include_once "../funciones.php";
    
	if($_SESSION['nom_perfil']==''){
		header('Location:../../index.php');
	}else{
        $_SESSION['cod_user']=limpiar($_SESSION['cod_user']);
        $_SESSION['user_name']=limpiar($_SESSION['user_name']);
        $_SESSION['ape_paterno']=limpiar($_SESSION['ape_paterno']);
        $_SESSION['ape_materno']=limpiar($_SESSION['ape_materno']);
        $_SESSION['cod_perfil']=limpiar($_SESSION['cod_perfil']);
        $_SESSION['nom_perfil']=limpiar($_SESSION['nom_perfil']);
        
        $_SESSION['MovimientoLectura']=$_SESSION['MovimientoLectura'];
        $_SESSION['TransaccionesLectura']=$_SESSION['TransaccionesLectura'];
        $_SESSION['ComprobantesLectura']=$_SESSION['ComprobantesLectura'];
        $_SESSION['ProveedoresLectura']=$_SESSION['ProveedoresLectura'];
        $_SESSION['PerfilLectura']=$_SESSION['PerfilLectura'];
        $_SESSION['PermisoLectura']=$_SESSION['PermisoLectura'];
        $_SESSION['UsuarioLectura']=$_SESSION['UsuarioLectura'];
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>.: Perfiles :.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="../../css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
                background-color: #2f5a78;
                background-repeat: repeat;
                color: black;
            }
        </style>
        <link href="../../css/bootstrap-responsive.css" rel="stylesheet">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../../ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="../../ico/favicon.png">
    </head>
    <?php
        if(isset($_POST["id"])){
            $id=limpiar($_POST['id']);
            $perfil=limpiar($_POST['perfil']);
            
            if($id==0){
                $serverName = "192.168.1.100"; //serverName\instanceName
                $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
                $conn = sqlsrv_connect( $serverName, $connectionInfo);
                
                $sql = "sp_perfil ?, ?, ?, ?";
                $stmt = sqlsrv_query($conn, $sql, array(1, $id, $perfil, 1));
                
                if( $stmt == false ) {
                    echo mensajes('Hubo un error al registrar los datos.','rojo');
                }else{
                    echo mensajes('Los datos del perfil "'.$perfil.'" Ha sido Registrado con Exito','verde');
                }
            }else{
                $estado=limpiar($_POST['estado']);
                
                $serverName = "192.168.1.100";
                $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
                $conn = sqlsrv_connect( $serverName, $connectionInfo);
                
                $sql = "sp_perfil ?, ?, ?, ?";
                $stmt = sqlsrv_query($conn, $sql, array(2, $id, $perfil, $estado));
                
                if( $stmt == false ) {
                    echo mensajes('Hubo un error al actualizar los datos.','rojo');
                }else{
                    echo mensajes('Los datos del perfil "'.$perfil.'" Ha sido Actualizado con Exito','verde');
                }    
            }
        }
    ?>
    <body>
    <?php include_once "../m_principal.php"; ?>
    <div align="center">
        <table width="60%">
            <tr>
                <td style="background-color: #ff8600;">
                    <table class="table table-bordered">
                        <tr class="info" style="background-color: #ff8600;">
                            <td>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <h2 class="text-info">
                                            <img src="../../img/perfil.png" width="80" height="80">
                                            Perfiles
                                        </h2>
                                    </div>
                                    <div class="span6">
                                        <form name="form1" method="post" action="">
                                            <div class="input-append">
                                                <input type="text" name="buscar" class="input-xlarge" autocomplete="off" autofocus placeholder="Buscar Perfiles">
                                                <button type="submit" class="btn"><strong><i class="icon-search"></i> Buscar</strong></button>
                                            </div>
                                        </form>
                                        <a href="#nuevo" role="button" class="btn" data-toggle="modal">
                                        <strong><i class="icon-plus"></i> Nuevo Perfil</strong>
                                        </a>

                                        <div id="nuevo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <form name="form2" method="post" action="">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h3 id="myModalLabel">Nuevo Perfil</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row-fluid">
                                                        <div class="span6">
                                                            <input type="hidden" name="id" value="">
                                                            <strong>Perfil</strong><br>
                                                            <input type="text" name="perfil" autocomplete="off" required value=""  tabindex="100"><br>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="modal-footer">
                                                <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
                                                <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> <strong>Guardar</strong></button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <table width="60%">
            <tr>
                <td>
            	   <table class="table table-bordered table">
                        <tr class="info" style="background-color: #ea421c;">
                            <td><strong class="text-info">N</strong></td>
                            <td><strong class="text-info">Perfil</strong></td>
                            <td><center><strong class="text-info">Estado</strong></center></td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                            $serverName = "192.168.1.100"; //serverName\instanceName
                            $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
                            $conn = sqlsrv_connect( $serverName, $connectionInfo);

                            if( $conn === false ) {
                                echo mensajes('Hubo un error al registrar los datos.','rojo');
                            }

                            if(!empty($_POST['buscar'])){
                                $buscar=limpiar($_POST['buscar']);
                                $sql="SELECT * FROM vst_perfil WHERE perfil LIKE '%$buscar%' ORDER BY perfil ASC";
                            }else{
                                $sql="SELECT * FROM vst_perfil ORDER BY perfil ASC";
                            }

                            $stmt = sqlsrv_query($conn, $sql);
                            
                            $cont = 0;
                            
                            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                if($cont%2==0){
                                    echo '<tr style="background-color: #ffffff;">';
                                }else{
                                    echo '<tr style="background-color: darkgrey;">';
                                }
                                
                                $cont+=1;
                        ?>
                            <td><?php echo $cont; ?></td>
                            <td><?php echo $row['perfil']; ?></td>
                            <td>
                                <center>
                                    <?php 
                                    if($row['estado']==1){
                                    echo '<span class="label label-success">Activo</span>';
                                    }else{
                                    echo '<span class="label label-important">No Activo</span>';
                                    }
                                    ?>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <a href="#a<?php echo $row['id']; ?>" title="Editar Perfil" role="button" class="btn btn-mini" data-toggle="modal">
                                        <i class="icon-edit"></i>
                                    </a>
                                </center>
                                <div id="a<?php echo $row['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <form name="form3" method="post" action="">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h3 id="myModalLabel">Actualizar Perfil</h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <strong>Perfil</strong><br>
                                                    <input type="text" name="perfil" autocomplete="off" required value="<?php echo $row['perfil']; ?>" tabindex="100"><br>
                                                </div>
                                                <div class="span6">
                                                    <strong>Estado</strong><br>
                                                    <select name="estado" tabindex="108">
                                                        <option value=1 <?php if($row['estado']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['estado']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
                                            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> <strong>Actualizar</strong></button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php
                            }
                            
                            sqlsrv_free_stmt( $stmt);
                            sqlsrv_close($conn);
                        ?>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- Le javascript ../../js/jquery.js
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../js/jquery.js"></script>
    <script src="../../js/bootstrap-transition.js"></script>
    <script src="../../js/bootstrap-alert.js"></script>
    <script src="../../js/bootstrap-modal.js"></script>
    <script src="../../js/bootstrap-dropdown.js"></script>
    <script src="../../js/bootstrap-scrollspy.js"></script>
    <script src="../../js/bootstrap-tab.js"></script>
    <script src="../../js/bootstrap-tooltip.js"></script>
    <script src="../../js/bootstrap-popover.js"></script>
    <script src="../../js/bootstrap-button.js"></script>
    <script src="../../js/bootstrap-collapse.js"></script>
    <script src="../../js/bootstrap-carousel.js"></script>
    <script src="../../js/bootstrap-typeahead.js"></script>
  </body>
</html>