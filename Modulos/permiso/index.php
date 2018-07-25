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
        <title>.: Usuarios :.</title>
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
            $tipo=limpiar($_POST['tipo']);
            $movimiento=limpiar($_POST['movimiento']);
            $movimientol=limpiar($_POST['movimientol']);
            $mantenimiento=limpiar($_POST['mantenimiento']);
            $transacciones=limpiar($_POST['transacciones']);
            $transaccionesl=limpiar($_POST['transaccionesl']);
            $comprobantes=limpiar($_POST['comprobantes']);
            $comprobantesl=limpiar($_POST['comprobantesl']);
            $proveedores=limpiar($_POST['proveedores']);
            $proveedoresl=limpiar($_POST['proveedoresl']);
            $seguridad=limpiar($_POST['seguridad']);
            $perfil=limpiar($_POST['perfil']);
            $perfill=limpiar($_POST['transaccionesl']);
            $permiso=limpiar($_POST['comprobantes']);
            $permisol=limpiar($_POST['comprobantesl']);
            $usuario=limpiar($_POST['usuario']);
            $usuariol=limpiar($_POST['usuariol']);
            
            if($id==0){
                $serverName = "192.168.1.100";
                $connectionInfo = array("Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
                $conn = sqlsrv_connect($serverName, $connectionInfo);
                
                if($conn === false) {
                    echo mensajes('Hubo un problema con la conexión.','rojo');
                }else{
                    $sql = "SELECT count(id) as total FROM vst_permiso WHERE iperfil = ".$tipo;
                    $stmt = sqlsrv_query($conn, $sql);
                    
                    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                        //echo $row['total'];
                        if($row['total']==0){
                            $sql2 = "INSERT INTO tb_permiso (id_perfil, permiso_movimiento, permiso_movimiento_lectura, permiso_mantenimiento, permiso_transacciones,
                            permiso_transacciones_lectura, permiso_comprobantes, permiso_comprobantes_lectura, permiso_proveedores,
                            permiso_proveedores_lectura, permiso_seguridad, permiso_perfil, permiso_perfil_lectura, permiso_permiso,
                            permiso_permiso_lectura, permiso_usuario, permiso_usuario_lectura)
                            VALUES (".$tipo.", ".$movimiento.", ".$movimientol.", ".$mantenimiento.", ".$transacciones.", ".$transaccionesl.", ".$comprobantes.", ".$comprobantesl.", ".$proveedores.", ".$proveedoresl.", ".$seguridad.", ".$perfil.", ".$perfill.", ".$permiso.", ".$permisol.", ".$usuario.", ".$usuariol.")";
                            
                            $stmt2 = sqlsrv_query($conn, $sql2);
                            
                            if( $stmt2 == false ) {
                                echo mensajes('Hubo un error al regsitrar los datos.','rojo');
                            }else{
                                echo mensajes('Los permisos han sido Registrado con Exito','verde');
                            }
                        }else{
                            echo mensajes('El perfil ya tiene permisos aignados.','rojo');
                        }
                    }
                }
            }else{
                $serverName = "192.168.1.100";
                $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
                $conn = sqlsrv_connect( $serverName, $connectionInfo);
                
                if( $conn === false ) {
                    echo mensajes('Hubo un problema con la conexión.','rojo');
                }else{
                    $sql2 = "UPDATE tb_permiso SET permiso_movimiento = ".$movimiento.", permiso_movimiento_lectura = ".$movimientol.", permiso_mantenimiento = ".$mantenimiento.", permiso_transacciones = ".$transacciones.", permiso_transacciones_Lectura = ".$transaccionesl.", permiso_comprobantes = ".$comprobantes.", permiso_comprobantes_Lectura = ".$comprobantesl.", permiso_proveedores = ".$proveedores.", permiso_proveedores_Lectura = ".$proveedoresl.", permiso_seguridad = ".$seguridad.", permiso_perfil = ".$perfil.", permiso_perfil_lectura = ".$perfill.", permiso_permiso = ".$permiso.", permiso_permiso_lectura = ".$permisol.", permiso_usuario = ".$usuario.", permiso_usuario_lectura = ".$usuariol." WHERE id_permiso = ".$id;
                    
                    $stmt2 = sqlsrv_query($conn, $sql2);
                    
                    if( $stmt2 === false ) {
                        echo mensajes('Hubo un error al actualizar los datos.','rojo');
                    }else{
                        echo mensajes('Los permisos han sido Actualizado con Exito','verde');
                    }
                }
            }
        }
            
            //sqlsrv_free_stmt( $stmt);
            //sqlsrv_close($conn);
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
                                    <img src="../../img/permiso.png" width="80" height="80">
                                    Permisos
                                    </h2>
                                </div>
                                <div class="span6">
                                    <form name="form1" method="post" action="">
                                        <div class="input-append">
                                            <input type="text" name="buscar" class="input-xlarge" autocomplete="off" autofocus placeholder="Buscar Permiso">
                                            <button type="submit" class="btn"><strong><i class="icon-search"></i> Buscar</strong></button>
                                        </div>
                                    </form>
                                    <a href="#nuevo" role="button" class="btn" data-toggle="modal">
                                    <strong><i class="icon-plus"></i> Nuevo Permiso</strong>
                                    </a>
                                    
                                    <div id="nuevo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <form name="form2" method="post" action="">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h3 id="myModalLabel">Nuevo Permiso</h3>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <input type="hidden" name="id" value="">
                                                        <strong>Tipo de Usuario</strong><br>
                                                        <select name="tipo" tabindex="100">
                                                            <?php
                                                                $serverName = "192.168.1.100";
                                                                $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
                                                                $conn = sqlsrv_connect( $serverName, $connectionInfo);
                                                                
                                                                if( $conn === false ) {
                                                                    echo mensajes('Hubo un error de conexión.','rojo');
                                                                }
                                                                
                                                                $sql = "SELECT * FROM vst_perfil WHERE estado = 1 ORDER BY perfil ASC";
                                                                $stmt = sqlsrv_query($conn, $sql);
                                                                $cont=1;
                                                                
                                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                            ?>
                                                                    <option value=<?php echo $row['id']; ?> <?php if($cont==1){ echo 'selected'; }else{ echo ''; } ?>><?php echo $row['perfil']; ?></option>
                                                            <?php
                                                                    $cont=$cont+1;
                                                                }
                                                                
                                                                sqlsrv_free_stmt( $stmt);
                                                                sqlsrv_close($conn);
                                                            ?>
                                                        </select>
                                                        <strong>Movimiento</strong><br>
                                                        <select name="movimiento" tabindex="101">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <strong>Mantenimiento</strong><br>
                                                        <select name="mantenimiento" tabindex="103">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <strong>Transacciones</strong><br>
                                                        <select name="transacciones" tabindex="104">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <strong>Comprobantes</strong><br>
                                                        <select name="comprobantes" tabindex="106">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <strong>Proveedores</strong><br>
                                                        <select name="proveedores" tabindex="108">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <strong>Seguridad</strong><br>
                                                        <select name="seguridad" tabindex="110">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <strong>Perfil</strong><br>
                                                        <select name="perfil" tabindex="111">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <strong>Permiso</strong><br>
                                                        <select name="permiso" tabindex="113">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <strong>Usuario</strong><br>
                                                        <select name="usuario" tabindex="115">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                    </div>
                                                    <div class="span6">
                                                        <br><br><br>
                                                        <strong>Lectura</strong><br>
                                                        <select name="movimientol" tabindex="102">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <br><br><br><br>
                                                        <strong>Lectura</strong><br>
                                                        <select name="transaccionesl" tabindex="105">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <strong>Lectura</strong><br>
                                                        <select name="comprobantesl" tabindex="107">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <strong>Lectura</strong><br>
                                                        <select name="proveedoresl" tabindex="109">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <br><br><br><br>
                                                        <strong>Lectura</strong><br>
                                                        <select name="perfill" tabindex="112">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <strong>Lectura</strong><br>
                                                        <select name="permisol" tabindex="114">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
                                                        <strong>Lectura</strong><br>
                                                        <select name="usuariol" tabindex="116">
                                                            <option value=1 selected>Activo</option>
                                                            <option value=0 >Inactivo</option>
                                                        </select>
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
                            <td><strong class="text-info">Perfil</strong></td>
                            <td><strong class="text-info">Movimiento</strong></td>
                            <td><strong class="text-info">Mantenimiento</strong></td>
                            <td><strong class="text-info">Transacciones</strong></td>
                            <td><strong class="text-info">Comprobantes</strong></td>
                            <td><strong class="text-info">Proveedores</strong></td>
                            <td><strong class="text-info">Seguridad</strong></td>
                            <td><strong class="text-info">Perfil</strong></td>
                            <td><strong class="text-info">Permiso</strong></td>
                            <td><strong class="text-info">Usuario</strong></td>
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
                                $sql="SELECT * FROM vst_permiso WHERE dperfil LIKE '%$buscar%' ORDER BY dperfil ASC";					
                            }else{
                                $sql="SELECT * FROM vst_permiso ORDER BY dperfil ASC";				
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
                            <td><?php echo $row['dperfil']; ?></td>
                            <td>
                                <?php 
                                    if($row['movimiento']==1){
                                        echo '<span class="label label-success">Activo</span>';
                                    }else{
                                        echo '<span class="label label-important">No Activo</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if($row['mantenimiento']==1){
                                        echo '<span class="label label-success">Activo</span>';
                                    }else{
                                        echo '<span class="label label-important">No Activo</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if($row['transacciones']==1){
                                        echo '<span class="label label-success">Activo</span>';
                                    }else{
                                        echo '<span class="label label-important">No Activo</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if($row['comprobantes']==1){
                                        echo '<span class="label label-success">Activo</span>';
                                    }else{
                                        echo '<span class="label label-important">No Activo</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if($row['proveedores']==1){
                                        echo '<span class="label label-success">Activo</span>';
                                    }else{
                                        echo '<span class="label label-important">No Activo</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if($row['seguridad']==1){
                                        echo '<span class="label label-success">Activo</span>';
                                    }else{
                                        echo '<span class="label label-important">No Activo</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if($row['perfil']==1){
                                        echo '<span class="label label-success">Activo</span>';
                                    }else{
                                        echo '<span class="label label-important">No Activo</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if($row['permiso']==1){
                                        echo '<span class="label label-success">Activo</span>';
                                    }else{
                                        echo '<span class="label label-important">No Activo</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if($row['usuario']==1){
                                        echo '<span class="label label-success">Activo</span>';
                                    }else{
                                        echo '<span class="label label-important">No Activo</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <center>
                                    <a href="#a<?php echo $row['id']; ?>" title="Editar Usuario" role="button" class="btn btn-mini" data-toggle="modal">
                                        <i class="icon-edit"></i>
                                    </a>
                                </center>
                                <div id="a<?php echo $row['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <form name="form3" method="post" action="">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h3 id="myModalLabel">Actualizar Permiso</h3>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <strong>Tipo de Usuario</strong><br>
                                                    <input type="text" name="tipo" autocomplete="off" required value="<?php echo $row['dperfil']; ?>" tabindex="101"><br>
                                                    <strong>Movimiento</strong><br>
                                                    <select name="movimiento" tabindex="108">
                                                        <option value=1 <?php if($row['movimiento']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['movimiento']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <strong>Mantenimiento</strong><br>
                                                    <select name="mantenimiento" tabindex="108">
                                                        <option value=1 <?php if($row['mantenimiento']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['mantenimiento']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <strong>Transacciones</strong><br>
                                                    <select name="transacciones" tabindex="108">
                                                        <option value=1 <?php if($row['transacciones']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['transacciones']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <strong>Comprobantes</strong><br>
                                                    <select name="comprobantes" tabindex="108">
                                                        <option value=1 <?php if($row['comprobantes']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['comprobantes']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <strong>Proveedores</strong><br>
                                                    <select name="proveedores" tabindex="108">
                                                        <option value=1 <?php if($row['proveedores']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['proveedores']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <strong>Seguridad</strong><br>
                                                    <select name="seguridad" tabindex="108">
                                                        <option value=1 <?php if($row['seguridad']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['seguridad']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <strong>Perfil</strong><br>
                                                    <select name="perfil" tabindex="108">
                                                        <option value=1 <?php if($row['perfil']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['perfil']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <strong>Permiso</strong><br>
                                                    <select name="permiso" tabindex="108">
                                                        <option value=1 <?php if($row['permiso']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['permiso']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <strong>Usuario</strong><br>
                                                    <select name="usuario" tabindex="108">
                                                        <option value=1 <?php if($row['usuario']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['usuario']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                </div>
                                                <div class="span6">
                                                    <br><br><br>
                                                    <strong>Lectura</strong><br>
                                                    <select name="movimientol" tabindex="108">
                                                        <option value=1 <?php if($row['movimientol']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['movimientol']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <br><br><br><br>
                                                    <strong>Lectura</strong><br>
                                                    <select name="transaccionesl" tabindex="108">
                                                        <option value=1 <?php if($row['transaccionesl']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['transaccionesl']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <strong>Lectura</strong><br>
                                                    <select name="comprobantesl" tabindex="108">
                                                        <option value=1 <?php if($row['comprobantesl']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['comprobantesl']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <strong>Lectura</strong><br>
                                                    <select name="proveedoresl" tabindex="108">
                                                        <option value=1 <?php if($row['proveedoresl']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['proveedoresl']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <br><br><br><br>
                                                    <strong>Lectura</strong><br>
                                                    <select name="perfill" tabindex="108">
                                                        <option value=1 <?php if($row['perfill']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['perfill']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <strong>Lectura</strong><br>
                                                    <select name="permisol" tabindex="108">
                                                        <option value=1 <?php if($row['permisol']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['permisol']==0){ echo 'selected'; } ?>>Inactivo</option>
                                                    </select>
                                                    <strong>Lectura</strong><br>
                                                    <select name="usuariol" tabindex="108">
                                                        <option value=1 <?php if($row['usuariol']==1){ echo 'selected'; } ?>>Activo</option>
                                                        <option value=0 <?php if($row['usuariol']==0){ echo 'selected'; } ?>>Inactivo</option>
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