<?php
    $q = $_GET['q'];
    
    $serverName = "192.168.1.100";
    $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>""); 
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if( $conn === false ) {
        //echo mensajes('Hubo un error de conexión.','rojo');
    }else{
        $sql="SELECT * FROM vst_proveedor WHERE ruc = '".$q."'";
        //echo $sql;
        $stmt = sqlsrv_query($conn, $sql);
        $cont=1;
        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            echo $row['razon'];
        }
    }
    
    sqlsrv_close($conn);
?>