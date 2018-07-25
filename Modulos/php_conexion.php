<?php
    /*
	$conexion = mysql_connect("192.168.1.100","sa","");
	mysql_select_db("BD_TESORERIA",$conexion);
	date_default_timezone_set("America/Bogota");
    mysql_query("SET NAMES utf8");
	mysql_query("SET CHARACTER_SET utf");
	$s='Bs';
	
	$paa=mysql_query("SELECT * FROM empresa WHERE id=1");					
	if($dato=mysql_fetch_array($paa)){
		$maxima_nota=$dato['maxima'];
		$minima_nota=$dato['minima'];
	}
	
	
	function limpiar($tags){
		

		return $tags;
	}
    */
    /*
    $serverName = "192.168.1.100"; //serverName\instanceName
    $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    
    if( $conn ) {
         echo "Conexión establecida.<br />";
    }else{
         echo "Conexión no se pudo establecer.<br />";
         die( print_r( sqlsrv_errors(), true));
    }
    */
	function limpiar($tags){
		

		return $tags;
	}
?>