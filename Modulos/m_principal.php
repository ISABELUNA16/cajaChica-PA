<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="#">Professional Air</a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li><a href=<?php echo $_SESSION['path']."/principal.php" ?>>Principal</a></li>
                    <?php
                        if($_SESSION['Movimiento']==true){
                    ?>
                            <li><a href=<?php echo $_SESSION['path']."/Modulos/movimiento/index.php" ?>>Movimiento</a></li>
                    <?php
                        }
                    ?>
                    <li class="dropdown">
                    
                    <?php
                        if($_SESSION['Mantenimiento']==true){
                        ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mantenimiento <span class="caret"></span></a>
                        <?php
                        }
                    ?>
                        <ul class="dropdown-menu">
                            <?php
                                if($_SESSION['Transacciones']==true){
                            ?>
                                <li><a href=<?php echo $_SESSION['path']."/Modulos/transaccion/index.php" ?>>Transacciones</a></li>
                            <?php
                                }
                            ?>
                            <?php
                                if($_SESSION['Comprobantes']==true){
                            ?>
                                    <li role="separator" class="divider"></li>
                                    <li><a href=<?php echo $_SESSION['path']."/Modulos/comprobante/index.php" ?>>Comprobantes</a></li>
                            <?php
                                }
                            ?>
                            <?php
                                if($_SESSION['Proveedores']==true){
                            ?>
                                    <li role="separator" class="divider"></li>
                                    <li><a href=<?php echo $_SESSION['path']."/Modulos/proveedor/index.php" ?>>Proveedores</a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <?php
                            if($_SESSION['Seguridad']==true){
                            ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Seguridad <span class="caret"></span></a>
                            <?php
                            }
                        ?>
                      <ul class="dropdown-menu">
                        <?php
                            if($_SESSION['Perfil']==true){
                        ?>
                                <li><a href=<?php echo $_SESSION['path']."/Modulos/perfil/index.php" ?>>Perfiles</a></li>
                        <?php
                            }
                        ?>
                        <?php
                            if($_SESSION['Permiso']==true){
                        ?>

                                <li role="separator" class="divider"></li>
                                <li><a href=<?php echo $_SESSION['path']."/Modulos/permiso/index.php" ?>>Permiso</a></li>
                        <?php
                            }
                        ?>
                        <?php
                            if($_SESSION['Usuario']==true){
                        ?>
                                <li role="separator" class="divider"></li>
                                <li><a href=<?php echo $_SESSION['path']."/Modulos/usuario/index.php" ?>>Usuarios</a></li>
                        <?php
                            }
                        ?>
                      </ul>
                    </li>
                </ul>
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span style="color:#FFF">Bienvenido <?php echo $_SESSION['user_name']; ?></span> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Mis Datos</a></li>
                            <li class="divider"></li>
                            <li><a href=<?php echo $_SESSION['path']."/php_cerrar.php" ?>><i class="icon-off"></i> Salir</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div><!-- /container -->