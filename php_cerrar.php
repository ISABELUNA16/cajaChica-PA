<?php
	session_start();
    
    //unset($_SESSION['path']);
    /*
    $_SESSION['path']=null;
    $_SESSION['cod_user']=limpiar($_SESSION['cod_user']);
    $_SESSION['user_name']=limpiar($_SESSION['user_name']);
    $_SESSION['ape_paterno']=limpiar($_SESSION['ape_paterno']);
    $_SESSION['ape_materno']=limpiar($_SESSION['ape_materno']);
    $_SESSION['cod_perfil']=limpiar($_SESSION['cod_perfil']);
    $_SESSION['nom_peril']=limpiar($_SESSION['nom_peril']);
    
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
    $_SESSION['UsuarioLectura']=$row['usuariol'];*/
    
    session_destroy();
    
	header('Location:index.php');
?>