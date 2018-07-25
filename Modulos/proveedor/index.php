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
        <title>.: Proveedores :.</title>
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
            $ruc=limpiar($_POST['ruc']);
            $razon=limpiar($_POST['razon']);
            $direccion=limpiar($_POST['direccion']);
            $telefono=limpiar($_POST['telefono']);
            
            if($id==0){
                $serverName = "192.168.1.100";
                $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
                $conn = sqlsrv_connect( $serverName, $connectionInfo);
                
                if( $conn === false ) {
                    echo mensajes('Hubo un error de conexión.','rojo');
                }else{
                    $sql = "SELECT count(id) as total FROM vst_proveedor WHERE ruc = '".$ruc."'";
                    $stmt = sqlsrv_query($conn, $sql);

                    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                        if($row['total']==0){
                            $sql2 = "INSERT INTO tb_proveedor (proveedor_ruc, proveedor_razon, proveedor_direccion, proveedor_telefono, proveedor_estado) VALUES ('".$ruc."', '".$razon."', '".$direccion."', '".$telefono."', 1)";

                            $stmt2 = sqlsrv_query($conn, $sql2);

                            if($stmt2 == false){
                                echo mensajes('Hubo un error al regsitrar los datos.','rojo');
                            }else{
                                echo mensajes('Los datos del proveedor "'.$razon.'" Ha sido Registrado con Exito','verde');
                            }
                        }else{
                            echo mensajes('Ya se encuentra un proveedor registrado con el mismo número de RUC.','verde');
                        }
                    }
                }
            
            }else{
                $estado=limpiar($_POST['estado']);
                
                $serverName = "192.168.1.100";
                $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
                $conn = sqlsrv_connect( $serverName, $connectionInfo);
                
                if( $conn === false ) {
                    echo mensajes(sqlsrv_errors());
                }else{
                    $sql2 = "UPDATE tb_proveedor SET proveedor_ruc = '".$ruc."', proveedor_razon = '".$razon."', proveedor_direccion = '".$direccion."', proveedor_telefono = '".$telefono."', proveedor_estado = ".$estado." WHERE id_proveedor = ".$id;

                    $stmt2 = sqlsrv_query($conn, $sql2);

                    if( $stmt2 == false ) {
                        echo mensajes('Hubo un error al regsitrar los datos.','rojo');
                    }else{
                        echo mensajes('Los datos del proveedor "'.$razon.'" Ha sido Actualizado con Exito','verde');
                    }
                }
            }
        }
    ?>
    <body>
    <?php include_once "../m_principal.php"; ?>
    <div align="center">
        <table width="90%">
            <tr>
                <td style="background-color: #ff8600;">
                    <table class="table table-bordered">
                        <tr class="info" style="background-color: #ff8600;">
                            <td>
                            <div class="row-fluid">
                                <div class="span6">
                                    <h2 class="text-info">
                                    <img src="../../img/perfil.png" width="80" height="80">
                                    Proveedores
                                    </h2>
                                </div>
                                <div class="span6">
                                    <form name="form1" method="post" action="">
                                        <div class="input-append">
                                            <input type="text" name="buscar" class="input-xlarge" autocomplete="off" autofocus placeholder="Buscar Proveedor">
                                            <button type="submit" class="btn"><strong><i class="icon-search"></i> Buscar</strong></button>
                                        </div>
                                    </form>
                                    <a href="#nuevo" role="button" class="btn" data-toggle="modal">
                                    <strong><i class="icon-plus"></i> Nuevo Proveedor</strong>
                                    </a>
                                    
                                    <div id="nuevo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <form name="form2" method="post" action="">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h3 id="myModalLabel">Nuevo Proveedor</h3>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <input type="hidden" name="id" value="">
                                                        <strong>RUC</strong><br>
                                                        <input type="text" name="ruc" autocomplete="off" required value=""  tabindex="100"><br>
                                                        <strong>Dirección</strong><br>
                                                        <input type="text" name="direccion" autocomplete="off" required value="" tabindex="102"><br>
                                                    </div>
                                                    <div class="span6">
                                                        <strong>Razón Social</strong><br>
                                                        <input type="text" name="razon" autocomplete="off" required value="" tabindex="101"><br>
                                                        <strong>Teléfono</strong><br>
                                                        <input type="text" name="telefono" autocomplete="off" required value="" tabindex="103"><br>
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
        
        <table width="90%">
            <tr>
                <td>
            	   <table class="table table-bordered table">
                        <tr class="info" style="background-color: #ea421c;">
                            <td><strong class="text-info">N</strong></td>
                            <td><strong class="text-info">RUC</strong></td>
                            <td><strong class="text-info">Razón Social</strong></td>
                            <td><strong class="text-info">Dirección</strong></td>
                            <td><strong class="text-info">Teléfono</strong></td>
                            <td><center><strong class="text-info">Estado</strong></center></td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                            $serverName = "192.168.1.100"; //serverName\instanceName
                            $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
                            $conn = sqlsrv_connect( $serverName, $connectionInfo);

                            if( $conn === false ) {
                                echo mensajes('Hubo un error de conexión.','rojo');
                            }
                            
                            if(!empty($_POST['buscar'])){
                                $buscar=limpiar($_POST['buscar']);
                                $sql="SELECT * FROM vst_proveedor WHERE razon LIKE '%$buscar%' ORDER BY razon ASC";					
                            }else{
                                $sql="SELECT * FROM vst_proveedor ORDER BY razon ASC";				
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
                            <td><?php echo $row['ruc']; ?></td>
                            <td><?php echo $row['razon']; ?></td>
                            <td><?php echo $row['direccion']; ?></td>
                            <td><?php echo $row['telefono']; ?></td>
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
                                    <a href="#a<?php echo $row['id']; ?>" title="Editar proveedor" role="button" class="btn btn-mini" data-toggle="modal">
                                        <i class="icon-edit"></i>
                                    </a>
                                </center>
                                <div id="a<?php echo $row['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <form name="form3" method="post" action="">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h3 id="myModalLabel">Actualizar proveedor</h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <strong>RUC</strong><br>
                                                    <input type="text" name="ruc" autocomplete="off" required value="<?php echo $row['ruc']; ?>"  tabindex="100"><br>
                                                    <strong>Dirección</strong><br>
                                                    <input type="text" name="direccion" autocomplete="off" required value="<?php echo $row['direccion']; ?>" tabindex="102"><br>
                                                    <strong>Estado</strong><br>
                                                    <select name="estado" tabindex="105">
                                                        <option value=1 <?php if($row['estado']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['estado']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                </div>
                                                <div class="span6">
                                                    <strong>Razón Social</strong><br>
                                                    <input type="text" name="razon" autocomplete="off" required value="<?php echo $row['razon']; ?>" tabindex="101"><br>
                                                    <strong>Teléfono</strong><br>
                                                    <input type="text" name="telefono" autocomplete="off" required value="<?php echo $row['telefono']; ?>" tabindex="103"><br>
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