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
        <title>.: Movimientos :.</title>
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
        
        <link rel="stylesheet" href="../../css/calendario/jquery-ui.css">
        <link rel="stylesheet" href="../../css/calendario/style.css">
        <script src="../../js/calendario/jquery-1.12.4.js"></script>
        <script src="../../js/calendario/jquery-ui.js"></script>
        <!--
        <script src='../../js/jquery/jquery.min.2.1.3.js'></script>
        <script src='../../js/jquery/jquery.min.1.7.1.js'></script>
        <script src='../../js/jquery/jquery-ui.min.1.9.1.js'></script>
        -->
        <script>
            $( function() {
                $( "#datepicker" ).datepicker();
            } );
        </script>
    </head>
    <?php
        if(isset($_POST["codfin"])){
            $_POST['buscar']=$_POST['buscar'];
            //$_POST["codfin"] = $_POST["codfin"];
            //echo $_POST["codfin"];
            if($_POST["codfin"]==0){
                //document.appendChild('<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">×</button><strong>Hubo un problema con la conexión.</strong></div>');
                //echo mensajes('Hubo un problema con la conexión.','rojo');
            }
            
            if($_POST["codfin"]==1){
                //document.appendChild('<div class="alert alert-error" align="center"><button type="button" class="close" data-dismiss="alert">×</button><strong>Hubo un error al Finalizar el movimiento.</strong></div>');
                echo mensajes('Hubo un error al Finalizar el movimiento.','rojo');
            }
            
            if($_POST["codfin"]==2){
                //document.body.innerHTML = '<div class="alert alert-success" align="center"><button type="button" class="close" data-dismiss="alert">×</button><strong>El movimiento ha sido Finalizado con Exito.</strong></div>'+document.body.innerHTML;
                echo mensajes('El movimiento ha sido Finalizado con Exito.','verde');
            }
        }
        
        if(isset($_POST["mensaje"])){
            if($_POST["mensaje"]!=""){
                $id=limpiar($_POST['id']);
                $user=$_SESSION['cod_user'];
                $mensaje=$_POST['mensaje'];

                $miFecha= gmmktime(12,0,0,1,15,2089);
                setlocale(LC_TIME, 'es_PE.UTF-8');
                date_default_timezone_set ('America/Lima');
                //echo 'Ahora fecha actual es: '.strftime("%A, %d de %B de %Y %H:%M").'<br/>';
                $anio = strftime("%Y");
                $mes = substr("0".strftime("%m"), -2);
                $dia = substr("0".strftime("%d"), -2);
                
                $fec = $anio."-".$mes."-".$dia;
                
                $hora = substr("0".strftime("%H"), -2);
                $minuto = substr("0".strftime("%M"), -2);
                
                $hor = $hora.":".$minuto;
                
                $serverName = "192.168.1.100";
                $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
                $conn = sqlsrv_connect( $serverName, $connectionInfo);
                
                $stmt = sqlsrv_query($conn,"INSERT INTO tb_historial (id_movimiento, id_personal, historial_fvisto, historial_hvisto, historial_fecha, historial_hora, historial_mensaje, historial_estado) VALUES (".$id.", ".$user.", '', '', '".$fec."', '".$hor."', '".$mensaje."', 1)");
                
                if( $stmt == false ) {
                    echo mensajes('Hubo un error al intentar enviar el mensaje.','rojo');
                }else{
                    echo mensajes('El mensaje ha sido Enviado con Exito','verde');
                }
                /*
                require "../includes/PHPMailer/class.phpmailer.php";
                
                $mail = new phpmailer();
                
                $mail->PluginDir = "../includes/PHPMailer/";
                $mail->Mailer = "smtp";
                
                $mail->Host = ""; //cloud6.hostgator.com";
                
                $mail->SMTPAuth = false;
                
                $mail->Username = ""; //soporte@professionalair.edu.pe"; 
                $mail->Password = ""; //"mipassword";
                
                $mail->From = "programador@sistemas.com";
                $mail->FromName = "Juan Sarmiento";
                
                $mail->Timeout=30;
                
                $mail->AddAddress("jsarmiento87@live.com");
                
                $mail->Subject = "Prueba de phpmailer";
                $mail->Body = "<b>Mensaje de prueba mandado con phpmailer en formato html</b>";
                
                $mail->AltBody = "Mensaje de prueba mandado con phpmailer en formato solo texto";
                
                $exito = $mail->Send();
                
                $intentos=1;
                
                while ((!$exito) && ($intentos < 5)) {
                    sleep(5);
                    //echo $mail->ErrorInfo;
                    $exito = $mail->Send();
                    $intentos=$intentos+1;
                }
                
                if(!$exito){
                    echo "Problemas enviando correo electrónico a ".$valor;
                    echo "<br/>".$mail->ErrorInfo;	
                }else{
                    echo "Mensaje enviado correctamente";
                }
                */
            }
        }
        if(isset($_POST["transaccion"])){
            if($_POST["transaccion"]!="" && $_POST["movimiento"]!="" && $_POST["monto"]!="" && $_POST["glosa"]!=""){
                $serverName = "192.168.1.100"; //serverName\instanceName
                $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
                $conn = sqlsrv_connect( $serverName, $connectionInfo);
                
                $proveedor = 0;
                
                //echo strlen($_POST["ruc"]);
                
                if(count($_POST["ruc"])!=0 && strlen($_POST["ruc"])==11){
                    $sqlConsultar = "SELECT * FROM vst_proveedor WHERE ruc = '".$_POST["ruc"]."'";
                    $stmtConsultar = sqlsrv_query($conn, $sqlConsultar);

                    while( $rowConsultar = sqlsrv_fetch_array( $stmtConsultar, SQLSRV_FETCH_ASSOC) ) {
                        $proveedor = $rowConsultar["id"];
                    }
                    
                    //echo $proveedor."<br>";
                    
                    if($proveedor==0){
                        //echo "INSERT INTO tb_proveedor (proveedor_ruc, proveedor_razon, proveedor_direccion, proveedor_telefono, proveedor_estado) VALUES ('".$_POST["ruc"]."', '".$_POST["razon"]."', '', '', 1)";
                        
                        $stmt = sqlsrv_query($conn, "INSERT INTO tb_proveedor (proveedor_ruc, proveedor_razon, proveedor_direccion, proveedor_telefono, proveedor_estado) VALUES ('".$_POST["ruc"]."', '".$_POST["razon"]."', '', '', 1)");
                        
                        if( $stmt == false ) {
                            echo mensajes('Hubo un error al registrar al proveedor.','rojo');
                        }else{
                            $sqlVConsultar = "SELECT * FROM vst_proveedor WHERE ruc = '".$_POST["ruc"]."'";
                            $stmtVConsultar = sqlsrv_query($conn, $sqlVConsultar);
                            
                            while( $rowVConsultar = sqlsrv_fetch_array( $stmtVConsultar, SQLSRV_FETCH_ASSOC) ) {
                                $proveedor = $rowVConsultar["id"];
                            }
                            
                            sqlsrv_free_stmt( $stmtVConsultar);
                        }
                    }
                    
                    sqlsrv_free_stmt( $stmtConsultar);
                }
                
                //echo "INSERT INTO tb_movimiento (id_personal, id_transaccion, id_tipomovimiento, movimiento_fecha, movimiento_hora, id_comprobante, num_comprobante, id_proveedor, movimiento_monto, movimiento_glosa, movimiento_estado) VALUES (".$_SESSION['cod_user'].", ".$_POST["transaccion"].", ".$_POST["movimiento"].", '".$_POST["fecact"]."', '".$_POST["horact"]."', ".$_POST["comprobante"].", '".$_POST["numero"]."', ".$proveedor.", '".$_POST["monto"]."', '".$_POST["glosa"]."', 1)";
                
                $stmt = sqlsrv_query($conn, "INSERT INTO tb_movimiento (id_personal, id_transaccion, id_tipomovimiento, movimiento_fecha, movimiento_hora, id_comprobante, num_comprobante, id_proveedor, movimiento_monto, movimiento_glosa, movimiento_estado) VALUES (".$_SESSION['cod_user'].", ".$_POST["transaccion"].", ".$_POST["movimiento"].", '".$_POST["fecact"]."', '".$_POST["horact"]."', ".$_POST["comprobante"].", '".$_POST["numero"]."', ".$proveedor.", '".$_POST["monto"]."', '".$_POST["glosa"]."', 1)");
                
                if( $stmt == false ) {
                    echo mensajes('Hubo un error al registrar los datos.','rojo');
                }else{
                    echo mensajes('Los datos Han sido Registrado con Exito','verde');
                }
                
            }
        }
    ?>
    <script language=javascript type=text/javascript>
        $(document).ready(function() {
            $("[id*=datepicker]").each(
                function(index, value) {
                    $(this).change(cantidad_cambiada)
                }
            );
        });
        
        function cantidad_cambiada(){
            var fecha = new Date(this.value);
            var xanio, xmes, xdia;
            
            var xanio = fecha.getFullYear();
            var xmes = fecha.getMonth() + 1;
            var xdia = "0" + fecha.getDate();
            
            xdia = xdia.substr(-2);
            xmes = "0" + xmes;
            xmes = xmes.substr(-2);
            
            var xfec = xanio + "-" + xmes + "-" + xdia;
            
            document.form1.buscar.value = xfec;
            document.form1.submit();
        }
        
        function finalizar(cod){
            document.form1.codfin.value = cod;
            
            //if(x==true){
                $.ajax({
                    url: 'finalizar.php',
                    type: 'POST',
                    dataType: 'html',
                    data: { condicion: "finalizar", ident: cod},
                    
                    success:function(resultado){
                        document.form1.codfin.value = resultado;
                        document.form1.submit();
                    }
                });
            //}
        }
        
        function buscarproveedor(str) {
            if (str=="") {
                document.form2.razon.value = "";
                return;
            } 
            if (window.XMLHttpRequest) {
                xmlhttp=new XMLHttpRequest(); //code for IE7+, Firefox, Chrome, Opera, Safari
            } else {
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); //code for IE6, IE5
            }
            xmlhttp.onreadystatechange=function() {
                if (this.readyState==4 && this.status==200) {
                    document.form2.razon.value = this.responseText //document.getElementById("razon").innerHTML=this.responseText;
                }
            }
            //alert(str.length);
            //if(str.length==11){
                xmlhttp.open("GET","proveedor.php?q="+str, true);
                xmlhttp.send();
            //}
        }
    </script>
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
                                    <div class="span8">
                                        <h2 class="text-info">
                                            <img src="../../img/comprobante.png" width="80" height="80">
                                            Movimientos
                                        </h2>
                                    </div>
                                    <div class="span4">
                                        <form name="form1" method="post" action="">
                                            <div>
                                                <input type="hidden" name="buscar" autocomplete="off" value="<?php echo $_POST['buscar']; ?>">
                                                <input type="hidden" name="codfin" autocomplete="off" value="">
                                                <input type="text" id="datepicker" placeholder="Seleccione una fecha" >
                                            </div>
                                        </form>
                                        <a href="#nuevo" role="button" class="btn" data-toggle="modal">
                                            <strong><i class="icon-plus"></i> Movimiento</strong>
                                        </a>
                                        <div id="nuevo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <form name="form2" method="post" action="">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h3 id="myModalLabel">Nuevo Movimiento</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row-fluid">
                                                        <?php
                                                            $serverName = "192.168.1.100";
                                                            $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
                                                            $conn = sqlsrv_connect( $serverName, $connectionInfo);

                                                            if( $conn === false ) {
                                                                echo mensajes('Hubo un error de conexión.','rojo');
                                                            }
                                                        ?>
                                                        <div class="span6">
                                                            <strong>Transaccion</strong><br>
                                                            <select name="transaccion" tabindex="100" required>
                                                                <option value=0 selected>Seleccione</option>
                                                                <?php
                                                                    $sql = "SELECT * FROM vst_transaccion WHERE estado = 1 ORDER BY transaccion ASC";
                                                                    $stmt = sqlsrv_query($conn, $sql);
                                                                    $cont=1;
                                                                    
                                                                    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                                ?>
                                                                        <option value=<?php echo $row['id']; ?> ><?php echo $row['transaccion']; ?></option>
                                                                <?php
                                                                        $cont=$cont+1;
                                                                    }

                                                                    sqlsrv_free_stmt( $stmt);
                                                                ?>
                                                            </select><br>
                                                            <input type="hidden" name="fecact" value="<?php
                                                                //Inicio Actualizar fecha y hora del visto
                                                                $miFecha= gmmktime(12,0,0,1,15,2089);
                                                                setlocale(LC_TIME, 'es_PE.UTF-8');
                                                                date_default_timezone_set ('America/Lima');
                                                                //echo 'Ahora fecha actual es: '.strftime("%A, %d de %B de %Y %H:%M").'<br/>';
                                                                $anio = strftime("%Y");
                                                                $mes = substr("0".strftime("%m"), -2);
                                                                $dia = substr("0".strftime("%d"), -2);

                                                                $fec = $anio."-".$mes."-".$dia;
                                                                
                                                                echo $fec;
                                                            ?>">
                                                            <strong>Comprobante</strong><br>
                                                            <select name="comprobante" tabindex="102">
                                                                <option value=0 selected>Seleccione</option>
                                                                <?php
                                                                    $sql = "SELECT * FROM vst_comprobante WHERE estado = 1 ORDER BY comprobante ASC";
                                                                    $stmt = sqlsrv_query($conn, $sql);
                                                                    $cont=1;
                                                                    
                                                                    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                                ?>
                                                                        <option value=<?php echo $row['id']; ?> ><?php echo $row['comprobante']; ?></option>
                                                                <?php
                                                                        $cont=$cont+1;
                                                                    }
                                                                    
                                                                    sqlsrv_free_stmt( $stmt);
                                                                ?>
                                                            </select><br>
                                                            <strong>RUC</strong><br>
                                                            <input type="text" name="ruc" autocomplete="off" value="" onchange="buscarproveedor(this.value)" tabindex="104" ><br>
                                                            <strong>Monto</strong><br>
                                                            <input type="text" name="monto" autocomplete="off" required value=""  tabindex="106"><br>
                                                        </div>
                                                        <div class="span6">
                                                            <strong>Tipo de Movimiento</strong><br>
                                                            <select name="movimiento" tabindex="101" required>
                                                                <option value=0 selected>Seleccione</option>
                                                                <?php
                                                                    $sql = "SELECT * FROM vst_tipomovimiento WHERE estado = 1 ORDER BY tipomovimiento ASC";
                                                                    $stmt = sqlsrv_query($conn, $sql);
                                                                    $cont=1;
                                                                    
                                                                    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                                ?>
                                                                        <option value=<?php echo $row['id']; ?> ><?php echo $row['tipomovimiento']; ?></option>
                                                                <?php
                                                                        $cont=$cont+1;
                                                                    }
                                                                    
                                                                    sqlsrv_free_stmt( $stmt);
                                                                ?>
                                                            </select>
                                                            <input type="hidden" name="horact" value="<?php
                                                                //Inicio Actualizar fecha y hora del visto
                                                                $miFecha= gmmktime(12,0,0,1,15,2089);
                                                                setlocale(LC_TIME, 'es_PE.UTF-8');
                                                                date_default_timezone_set ('America/Lima');
                                                                
                                                                $hora = substr("0".strftime("%H"), -2);
                                                                $minuto = substr("0".strftime("%M"), -2);
                                                                
                                                                $hor = $hora.":".$minuto;
                                                                
                                                                echo $hor;
                                                            ?>"><br>
                                                            <strong>Número</strong><br>
                                                            <input type="text" name="numero" autocomplete="off" value="" tabindex="103"><br>
                                                            <strong>Razón Social</strong><br>
                                                            <input type="text" name="razon" autocomplete="off" value="" tabindex="105"><br>
                                                        </div>
                                                        <?php
                                                            //sqlsrv_close($conn);
                                                        ?>
                                                        <textarea rows="5" name="glosa" style="width: 97%;" placeholder="Glosa" tabindex="107"></textarea><br>
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
                            <td><strong class="text-info">Transacción</strong></td>
                            <td><strong class="text-info">Tipo</strong></td>
                            <td><strong class="text-info">Monto</strong></td>
                            <td><strong class="text-info">Concepto</strong></td>
                            <td><strong class="text-info">Mensaje</strong></td>
                            <td><center><strong class="text-info">Estado</strong></center></td>
                            <td><center><strong class="text-info">Detalle</strong></center></td>
                            <td><center><strong class="text-info">Finalizar</strong></center></td>
                            <td><center><strong class="text-info">Mensaje</strong></center></td>
                        </tr>
                        <?php
                            $serverName = "192.168.1.100"; //serverName\instanceName
                            $connectionInfo = array( "Database"=>"BD_TESORERIA", "UID"=>"sa", "PWD"=>"");
                            $conn = sqlsrv_connect( $serverName, $connectionInfo);
                            
                            if( $conn === false ) {
                                echo mensajes('Hubo un error de conexión.','rojo');
                            }else{
                                if(!empty($_POST['buscar'])){
                                    $buscar=limpiar($_POST['buscar']);
                                    $sql="SELECT * FROM vst_movimiento WHERE fecha LIKE '%$buscar%' ORDER BY fecha ASC";
                                }else{
                                    $miFecha= gmmktime(12,0,0,1,15,2089);
                                    setlocale(LC_TIME, 'es_PE.UTF-8');
                                    date_default_timezone_set ('America/Lima');
                                    //echo 'Ahora fecha actual es: '.strftime("%A, %d de %B de %Y %H:%M").'<br/>';
                                    $anio = strftime("%Y");
                                    $mes = substr("0".strftime("%m"), -2);
                                    $dia = substr("0".strftime("%d"), -2);
                                    
                                    $fec = $anio."-".$mes."-".$dia;
                                    
                                    //$sql="SELECT * FROM vst_movimiento ORDER BY fecha ASC";
                                    $sql="SELECT * FROM vst_movimiento WHERE fecha = '$fec' ORDER BY fecha ASC";
                                }
                                
                                $stmt = sqlsrv_query($conn, $sql);
                                $cont=0;
                                
                                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                    if($cont%2==0){
                                        echo '<tr style="background-color: #ffffff;">';
                                    }else{
                                        echo '<tr style="background-color: darkgrey;">';
                                    }
                                    
                                    $cont+=1;
                            ?>
                                <td><?php echo $cont; ?></td>
                                <td><?php echo $row['dtransaccion']; ?></td>
                                <td><?php echo $row['dtipomovimiento']; ?></td>
                                <td><?php echo $row['monto']; ?></td>
                                <td><?php echo $row['glosa']; ?></td>
                                <td>
                                <!-- Ver Mensajes -->
                                <?php
                                    //if($row['mensaje']==0){
                                ?>
                                        <?php //echo $row['mensaje']; ?>
                                <?php
                                    //}else{
                                ?>
                                        <center>
                                            <a href="#ms<?php echo $row['id']; ?>" title="Ver detalle" role="button" class="btn btn-mini" data-toggle="modal">
                                                <?php echo $row['mensaje']; ?>
                                            </a>
                                        </center>
                                        <div id="ms<?php echo $row['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <form name="form3" method="post" action="">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h3 id="myModalLabel">
                                                        <?php echo "Historial de Mensajes"; ?>
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div>
                                                        <?php
                                                            //Inicio Actualizar fecha y hora del visto
                                                            $miFecha= gmmktime(12,0,0,1,15,2089);
                                                            setlocale(LC_TIME, 'es_PE.UTF-8');
                                                            date_default_timezone_set ('America/Lima');
                                                            //echo 'Ahora fecha actual es: '.strftime("%A, %d de %B de %Y %H:%M").'<br/>';
                                                            $anio = strftime("%Y");
                                                            $mes = substr("0".strftime("%m"), -2);
                                                            $dia = substr("0".strftime("%d"), -2);
                                                            
                                                            $fec = $anio."-".$mes."-".$dia;
                                                            
                                                            $hora = substr("0".strftime("%H"), -2);
                                                            $minuto = substr("0".strftime("%M"), -2);
                                                            
                                                            $hor = $hora.":".$minuto;
                                                            
                                                            $sqlvisto = "UPDATE tb_historial SET historial_fvisto = '".$fec."', historial_hvisto = '".$hor."', historial_estado = 0 WHERE id_movimiento = ".$row['id']." AND id_personal != ".$_SESSION['cod_user'];
                                                            
                                                            //echo $sqlvisto;
                                                            
                                                            $stmtvisto = sqlsrv_query($conn, $sqlvisto);
                                                            
                                                            if( $stmtvisto === false ) {
                                                                echo mensajes('Hubo un error al actualizar el visto.','rojo');
                                                            }else{
                                                                //echo mensajes('El vito ha sido Actualizado con Exito','verde');
                                                            }
                                                            //Fin Actualizar fecha y hora del visto
                                                            $sqlmov = "SELECT * FROM vst_historial WHERE imovimiento = ".$row['id']." ORDER BY id DESC";
                                                            //echo $sqlmov;
                                                            
                                                            $stmtmov = sqlsrv_query($conn, $sqlmov);
                                                            $cont=1;
                                                            //date_format($row['fecha'], 'd/m/Y')
                                                            while( $rowmov = sqlsrv_fetch_array( $stmtmov, SQLSRV_FETCH_ASSOC) ) {
                                                        ?>
                                                                    <h4 id="myModalLabel"><?php echo date_format($rowmov['fecha'], 'd/m/Y').' '.$rowmov['hora'].' - '.$rowmov['personal'].' dice:'; ?></h4>
                                                                    <?php echo $rowmov['mensaje']; ?>
                                                                    <?php
                                                                        if($rowmov['hora_visto']!=""){
                                                                    ?>
                                                                            <br>
                                                                            <small><em><?php echo '<b>Visto</b> '.date_format($rowmov['fecha_visto'], 'd/m/Y').' a las '.$rowmov['hora_visto']; ?></em></small>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                    <legend></legend>
                                                        <?php
                                                                $cont=$cont+1;
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
                                                </div>
                                            </form>
                                        </div>
                                <?php
                                    //}
                                ?>
                                </td>
                                <td>
                                    <center>
                                        <?php 
                                            if($row['estado']==1){
                                                echo '<span class="label label-warning">Por confirmar</span>';
                                            }else{
                                                echo '<span class="label label-important">Cerrado</span>';
                                            }
                                        ?>
                                    </center>
                                </td>
                                <td>
                                    <!-- Ver Detalle -->
                                    <center>
                                        <a href="#a<?php echo $row['id']; ?>" title="Ver detalle" role="button" class="btn btn-mini" data-toggle="modal">
                                            <i class="icon-eye-open"></i>
                                        </a>
                                    </center>
                                    <div id="a<?php echo $row['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <form name="form6" method="post" action="">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h3 id="myModalLabel">
                                                    <?php echo "Fecha: ".date_format($row['fecha'], 'd/m/Y')." a las ".$row['hora']; ?>
                                                </h3>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                        <strong>Transacción</strong><br>
                                                        <?php echo $row['dtransaccion']; ?><br>
                                                        <strong>Monto</strong><br>
                                                        <?php echo $row['monto']; ?><br>
                                                    </div>
                                                    <div class="span6">
                                                        <strong>Tipo</strong><br>
                                                        <?php echo $row['dtipomovimiento']; ?><br>
                                                        <?php
                                                            if($row['icomprobante']!=""){
                                                        ?>
                                                                <strong>Comprobante</strong><br>
                                                                <?php echo $row['dcomprobante']." N° ".$row['numero']; ?>
                                                        <?php
                                                            }
                                                        ?>
                                                        <br>
                                                    </div>
                                                </div>
                                                <br>
                                                <strong>Glosa</strong><br>
                                                <?php echo $row['glosa']; ?>
                                                <br>
                                                <br>
                                                <div>
                                                    <?php
                                                        if($row['ruc']!=""){
                                                            ?>
                                                            <h4 id="myModalLabel"><u>Datos del proveedor</u></h4>
                                                            <strong>RUC</strong><br>
                                                            <?php echo $row['ruc']; ?><br>
                                                            <strong>Razón Social</strong><br>
                                                            <?php echo $row['razon']; ?><br>
                                                            <strong>Dirección</strong><br>
                                                            <?php echo $row['direccion']; ?><br>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <br>
                                                <div>
                                                    <h4 id="myModalLabel"><u>Registrado por:</u></h4>
                                                    <?php echo $row['personal']; ?>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <!-- Finalizar -->
                                    <?php 
                                        if($row['estado']==1){
                                    ?>
                                            <center>
                                                <a href="#f<?php echo $row['id']; ?>" title="Finalizar Movimiento" role="button" class="btn btn-mini" data-toggle="modal">
                                                    <i class="icon-ok"></i>
                                                </a>
                                            </center>
                                            <div id="f<?php echo $row['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <form name="form4" method="post" action="">
                                                    <input type="hidden" name="idfinal" value="<?php echo $row['id']; ?>">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h3 id="myModalLabel">Mensaje</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row-fluid">
                                                            <strong>¿Está seguro que desea finalizar el movimiento?</strong><br>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
                                                        <button type="submit" class="btn btn-primary" onclick="finalizar(<?php echo $row['id']; ?>);"><i class="icon-ok"></i> <strong>Finalizar</strong></button>
                                                        <!--                                                    
                                                        <input type="button" class="btn btn-primary" onclick="capturarcodigo()" value="Finalizar">
                                                        -->
                                                    </div>
                                                </form>
                                            </div>
                                    <?php
                                        }
                                    ?>
                                </td>
                                <td>
                                    <!-- Mensaje -->
                                    <?php 
                                        if($row['estado']==1){
                                    ?>
                                            <center>
                                                <a href="#m<?php echo $row['id']; ?>" title="Ver detalle" role="button" class="btn btn-mini" data-toggle="modal">
                                                    <i class="icon-edit"></i>
                                                </a>
                                            </center>
                                            <div id="m<?php echo $row['id']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <form name="form3" method="post" action="">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h3 id="myModalLabel">Actualizar Comprobante</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div>
                                                            <div>
                                                                <strong>Mensaje</strong><br>
                                                                <textarea rows="10" name="mensaje" style="width: 97%;"></textarea><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
                                                        <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> <strong>Enviar</strong></button>
                                                    </div>
                                                </form>
                                            </div>
                                    <?php
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php
                                }
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
        <!-- <script src="../../js/jquery.js"></script> -->
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