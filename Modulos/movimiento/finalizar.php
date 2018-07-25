<?php 
	include_once "../funciones.php";
    
    // verificas que si llegue el parámetro que le estas enviando
    if(isset($_REQUEST["condicion"])){
        // si llega la condicion, y es igual a la condicion que necesitas para entrar ejecuta la función y devuelve el resultado
        if($_REQUEST["condicion"] == "finalizar" ){
            //echo funcionPHP($_REQUEST["ident"]);
            //echo "UPDATE tb_movimiento SET movimiento_estado = 0 WHERE id_movimiento = ".$_REQUEST["ident"];
            //exit();
            
            $serverName = "192.168.1.100";
            $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
            $conn = sqlsrv_connect( $serverName, $connectionInfo);
            
            if( $conn === false ) {
                echo 0;
            }else{
                $sql2 = "UPDATE tb_movimiento SET movimiento_estado = 0 WHERE id_movimiento = ".$_REQUEST["ident"];
                
                $stmt2 = sqlsrv_query($conn, $sql2);
                
                if( $stmt2 === false ) {
                    echo 1;
                }else{
                    echo 2;
                }
            }
            
            // salimos de la pagina php y devolvemos la respuesta
            exit();
        }else{
            echo "otra funcion o respuesta";
            // salimos de la pagina php y devolvemos la respuesta
            exit();
        }
    }
    /*
    function funcionPHP(ident){
        
        $serverName = "192.168.1.100";
        $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        
        if( $conn === false ) {
            return mensajes('Hubo un problema con la conexión.','rojo');
        }else{
            $sql2 = "UPDATE tb_movimiento SET movimiento_estado = 0 WHERE id_permiso = ".ident;

            $stmt2 = sqlsrv_query($conn, $sql2);

            if( $stmt2 === false ) {
                return mensajes('Hubo un error al Finalizar el movimiento.','rojo');
            }else{
                return mensajes('El movimiento ha sido Finalizado con Exito','verde');
            }
        }
    }*/
?>