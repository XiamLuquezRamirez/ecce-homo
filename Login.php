<?php

session_start();

include("Conectar.php");

if (($_POST['USER'] == "") || !isset($_POST['USER'])) {

    echo "<script>location.href='login.php';</script>";
}

$link = conectar();

mysqli_query($link, "BEGIN");

$success = 1;

$menuopc = "";

$con = "SELECT * FROM usuarios u INNER JOIN perfiles p ON u.`niv_codigo`=p.`nomperfil` where cue_alias='" . $_POST['USER'] . "'

       AND cue_pass=SHA1('" . $_POST['KEY'] . "')";

$qc = mysqli_query($link, $con);

$num = mysqli_num_rows($qc);

//echo $num;

if ($num > 0) {

    $fila = mysqli_fetch_array($qc);

    $_SESSION['ses_compa'] = "Funeraria la Esperanza";
    $_SESSION['ses_nombre'] = $fila['cue_nombres'];
    $_SESSION['ses_user'] = $_POST['USER'];
    $_SESSION['ses_nivel'] = $fila['niv_codigo'];

    $_SESSION['ggesserv'] = $fila['ggesserv'];
    $_SESSION['gesser1'] = $fila['gesser1'];
    $_SESSION['gesser2'] = $fila['gesser2'];
    $_SESSION['gesser3'] = $fila['gesser3'];
    $_SESSION['gesser4'] = $fila['gesser4'];
    $_SESSION['gesser5'] = $fila['gesser5'];
    $_SESSION['gesser6'] = $fila['gesser6'];
    $_SESSION['gesser7'] = $fila['gesser7'];
    $_SESSION['gesser8'] = $fila['gesser8'];
    $_SESSION['gesser9'] = $fila['gesser9'];

    $_SESSION['gesConsRetra'] = $fila['gesConsRetra'];

    $_SESSION['gopgen'] = $fila['gopgen'];
    $_SESSION['gopgen1'] = $fila['gopgen1'];
    $_SESSION['gopgen2'] = $fila['gopgen2'];

    $_SESSION['gpargen'] = $fila['gpargen'];
    $_SESSION['gpargen1'] = $fila['gpargen1'];
    $_SESSION['gpargen2'] = $fila['gpargen2'];
    $_SESSION['gpargen3'] = $fila['gpargen3'];
    $_SESSION['gpargen4'] = $fila['gpargen4'];
    $_SESSION['gpargen5'] = $fila['gpargen5'];
    $_SESSION['gpargen6'] = $fila['gpargen6'];
    $_SESSION['gpargen7'] = $fila['gpargen7'];

    $_SESSION['ggestUsu'] = $fila['ggestUsu'];
    $_SESSION['gestUsu1'] = $fila['gestUsu1'];
    $_SESSION['gestUsu2'] = $fila['gestUsu2'];

    $_SESSION['gesAudi'] = $fila['gesAudi'];
    $_SESSION['gesConsPago'] = $fila['gesConsPago'];
    $_SESSION['gesFact'] = $fila['gesFact'];
    

    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,

            log_hora, log_accion, log_tipo, log_interfaz) VALUES

            ('" . $_POST['USER'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),

                NOW(),'Entrada satisfactoria al sistema' ,'ENTRADA', 'login.php')";



    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    if ($success == 0) {

        mysqli_query($link, "ROLLBACK");

        $_SESSION['ses_cpb'] = "no";

        echo "1";
    } else {

        mysqli_query($link, "COMMIT");

        $Footer = "<div class='page-footer'>
                         <div class='page-footer-inner'>
                             2017 &copy; Funeraria la Esperanza
                         </div>
                         <div class='scroll-to-top'>
                             <i class='icon-arrow-up'></i>
                         </div>
                     </div>";

        $User_Login = "
                     <li class='dropdown dropdown-user'>
                         <a class='dropdown-toggle'>
                             <img class='img-circle' src='Img/User.png' alt=''/>
                             <span class='username'>
                                " . acentos($_SESSION['ses_nombre']) . "
                            </span>
                             <i class='fa fa-angle-left'></i>
                         </a>
                     </li>

                     <li class='dropdown dropdown-user'>
                         <a href='cerrar.php' class='dropdown-toggle'>
                             <span class='username'>
                                Cerrar Sesi&oacute;n
                            </span>
                             <i class='icon-logout'></i>
                        </a>
                     </li>";


        $Menu_Left = "<div class='page-sidebar-wrapper'>
                        <div class='page-sidebar navbar-collapse collapse'>
                            <!-- BEGIN MENU LATERAL -->
                            <ul class='page-sidebar-menu' data-keep-expanded='false' data-auto-scroll='true' data-slide-speed='200'>
                                <li class='sidebar-toggler-wrapper'>
                                     <!--BEGIN SIDEBAR TOGGLER BUTTON-->
                                    <div class='sidebar-toggler'>
                                    </div>
                                     <!--END SIDEBAR TOGGLER BUTTON-->
                                </li>

                                <form class='sidebar-search '></form>

                                <li class='start active open' id='home'>
                                    <a href='Administracion.php'>
                                        <i class='icon-home'></i>
                                        <span class='title'>Inicio</span>
                                        <span class='arrow '></span>
                                    </a>
                                </li>";


        if ($_SESSION['ggesserv'] == "s") {
            $Menu_Left .= "           <li id='menu_serv' >
                                    <a href='#'>
                                        <i class='fa fa-briefcase'></i>
                                        <span class='title'>Gesti&oacute;n de Servicios</span>
                                        <span class='arrow'></span>
                                    </a>
                                      <ul class='sub-menu'> ";
            if ($_SESSION['gesser1'] == "s") {
                $Menu_Left .= "   <li id='menu_serv_req'>
                                            <a href='GesRequisicion.php'>
                                                <i class='fa fa-save'></i>
                                                 Requisici&oacute;n Interna
                                            </a>
                                        </li> ";
            }
            if ($_SESSION['gesser2'] == "s") {
                $Menu_Left .= "       <li id='menu_serv_arri'>
                                            <a href='GesContratoArriendo.php'>
                                                <i class='fa fa-save'></i>
                                                 Contrato de Arriendo
                                            </a>
                                        </li>";
            }
            if ($_SESSION['gesser3'] == "s") {
                $Menu_Left .= "        <li id='menu_serv_vent'>
                                            <a href='GesContratoVenta.php'>
                                                <i class='fa fa-save'></i>
                                                Contrato de Venta
                                            </a>
                                        </li>";
            }
            if ($_SESSION['gesser4'] == "s") {
                $Menu_Left .= "        <li id='menu_serv_prev'>
                                            <a href='GesContratoPrevi.php'>
                                                <i class='fa fa-save'></i>
                                                Contrato de Previsi&oacute;n
                                            </a>
                                        </li>";
            }
            if ($_SESSION['gesser4'] == "s") {
                $Menu_Left .= "        <li id='menu_serv_prevEmpr'>
                                            <a href='GesContratoPreviEmpre.php'>
                                                <i class='fa fa-save'></i>
                                                Contrato de Previsi&oacute;n Empresarial
                                            </a>
                                        </li>";
            }
            if ($_SESSION['gesser5'] == "s") {
                $Menu_Left .= "        <li id='menu_serv_Consta'>
                                            <a href='GesCostanciasConsig.php'>
                                                <i class='fa fa-save'></i>
                                                Constancia de Consignaci&oacute;n
                                            </a>
                                        </li>";
            }
            if ($_SESSION['gesser6'] == "s") {
                $Menu_Left .= "        <li id='menu_serv_notif'>
                                            <a href='GesNotifiaciones.php'>
                                                <i class='fa fa-save'></i>
                                                Notificaci&oacute;n a Clientes
                                            </a>
                                        </li>";
            }
            if ($_SESSION['gesser7'] == "s") {
                $Menu_Left .= "        <li id='menu_serv_inhum'>
                                            <a href='GesOrdenInhumacion.php'>
                                                <i class='fa fa-save'></i>
                                                Orden de Inhumación
                                            </a>
                                        </li>";
            }
            if ($_SESSION['gesser8'] == "s") {
                $Menu_Left .= "        <li id='menu_serv_exhuma'>
                                            <a href='GesOrdenExhum.php'>
                                                <i class='fa fa-save'></i>
                                                Orden de Exhumación
                                            </a>
                                        </li>";
            }
            if ($_SESSION['gesser9'] == "s") {
                $Menu_Left .= "        <li id='menu_serv_cespred'>
                                            <a href='GesCesionContrato.php'>
                                                <i class='fa fa-save'></i>
                                                Cesión de Contrato
                                            </a>
                                        </li>";
            }
//                              if($_SESSION['gesproy3']=="s"){
//                                  $Menu_Left.="<li id='menu_serv_recibos'>
//                                            <a href='GesRecibos.php'>
//                                                <i class='fa fa-save'></i>
//                                                Gesti&oacute;n de Recibos
//                                            </a>
//                                        </li>";
//                              }

            $Menu_Left .= "      </ul>
                                </li>";
        }



        $Menu_Left .= "           <li id='menu_cons' >
                                    <a href='#'>
                                        <i class='fa fa-file-text-o'></i>
                                        <span class='title'>Consultas</span>
                                        <span class='arrow'></span>
                                    </a>
                                      <ul class='sub-menu'> ";
        if ($_SESSION['gesConsRetra'] == "s") {
            $Menu_Left .= "   <li id='menu_cons_retra'>
                                            <a href='GesConsultasRetra.php'>
                                                <i class='fa fa-file-text'></i>
                                                 Consultas de Cartera
                                            </a>
                                        </li> ";
        }
        if ($_SESSION['gesConsRetra'] == "s") {
            $Menu_Left .= "   <li id='menu_cons_carteEmpre'>
                                            <a href='GesConsultasEmpre.php'>
                                                <i class='fa fa-file-text'></i>
                                                 Consulta de Cartera Empresarial
                                            </a>
                                        </li> ";
        }
        if ($_SESSION['gesConsPago'] == "s") {
            $Menu_Left .= "   <li id='menu_cons_pago'>
                                            <a href='GesConsultaPagos.php'>
                                                <i class='fa fa-file-text'></i>
                                                 Consulta de Pagos
                                            </a>
                                        </li> ";
        }
        if ($_SESSION['gesConsPago'] == "s") {
            $Menu_Left .= "   <li id='menu_cons_estado'>
                                            <a href='GesConsultaEstadoPagos.php'>
                                                <i class='fa fa-file-text'></i>
                                                 Consultar Estado Afiliado
                                            </a>
                                        </li> ";
        }

        $Menu_Left .= "      </ul>
                                </li>";

        if ($_SESSION['gopgen'] == "s") {
            $Menu_Left .= "           <li id='menu_opcige' >
                                    <a href='#'>
                                        <i class='fa fa-briefcase'></i>
                                        <span class='title'>Otros Servicios</span>
                                        <span class='arrow'></span>
                                    </a>
                                      <ul class='sub-menu'> ";
            if ($_SESSION['gopgen1'] == "s") {
                $Menu_Left .= "   <li id='menu_op_noti'>
                                            <a href='GesNoticias.php'>
                                                <i class='fa fa-save'></i>
                                                 Gesti&oacute;n de Noticias
                                            </a>
                                        </li> ";
            }

            if ($_SESSION['gopgen2'] == "s") {
                $Menu_Left .= "       <li id='menu_op_gal'>
                                            <a href='GesGalerias.php'>
                                                <i class='fa fa-save'></i>
                                                 Gesti&oacute;n de Galerias
                                            </a>
                                        </li>";
            }


            $Menu_Left .= "      </ul>
                                </li>";
        }


        if ($_SESSION['gpargen'] == "s") {

            $Menu_Left .= "<li id='menu_op' >
                                    <a href='#'>
                                        <i class='fa fa-gears'></i>
                                        <span class='title'>Parametros Generales</span>
                                        <span class='arrow '></span>
                                    </a>
                                    <ul class='sub-menu'> ";

            if ($_SESSION['gpargen1'] == "s") {
                $Menu_Left .= " <li id='menu_op_conf_emp'>
                                            <a href='Config_Empresa.php'>
                                                <i class='fa fa-building-o'></i>
                                                 Datos De La Empresa
                                            </a>
                                        </li> ";
            }
            if ($_SESSION['gpargen1'] == "s") {
                $Menu_Left .= " <li id='menu_op_empresa'>
                                            <a href='GestioEmpresas.php'>
                                                <i class='fa fa-building-o'></i>
                                                Gesti&oacute;n de Empresas
                                            </a>
                                        </li> ";
            }

            if ($_SESSION['gpargen2'] == "s") {
                $Menu_Left .= " <li id='menu_op_cli'>
                                            <a href='GesClientes.php'>
                                                <i class='fa fa-users'></i>
                                                 Gesti&oacute;n de Clientes
                                            </a>
                                        </li> ";
            }

            if ($_SESSION['gpargen3'] == "s") {
                $Menu_Left .= "     <li id='menu_op_fune'>
                                            <a href='GesFunerarias.php'>
                                                <i class='fa fa-institution'></i>
                                                 Gesti&oacute;n Funerarias
                                            </a>
                                        </li> ";
            }

            if ($_SESSION['gpargen4'] == "s") {
                $Menu_Left .= "<li id='menu_op_serv'>
                                            <a href='GesServicios.php'>
                                                <i class='fa fa-bookmark'></i>
                                                 Gesti&oacute;n de Precios.
                                            </a>
                                        </li> ";
            }


            if ($_SESSION['gpargen5'] == "s") {
                $Menu_Left .= "<li id='menu_op_ceme'>
                                            <a href='GesCementerios.php'>
                                                <i class='fa fa-plus-square-o'></i>
                                                 Gesti&oacute;n de Cementerios
                                            </a>
                                        </li> ";
            }
            if ($_SESSION['gpargen6'] == "s") {
                $Menu_Left .= "<li id='menu_op_igle'>
                                            <a href='GesIglesias.php'>
                                                <i class='fa  fa-bank'></i>
                                                 Gesti&oacute;n de Iglesias
                                            </a>
                                        </li> ";
            }
            if ($_SESSION['gpargen7'] == "s") {
                $Menu_Left .= "<li id='menu_op_conse'>
                                            <a href='GestionConse.php'>
                                                <i class='fa fa-sort-numeric-asc'></i>
                                                 Gesti&oacute;n de Consecutivos
                                            </a>
                                        </li> ";
            }

            $Menu_Left .= "      </ul>
                                </li>";
        }



        if ($_SESSION['ggestUsu'] == "s") {
            $Menu_Left .= "<li id='menu_user'>
                                    <a href='#'>
                                        <i class='icon-users'></i>
                                        <span class='title'>Gesti&oacute;n de Usuarios</span>
                                        <span class='arrow '></span>
                                    </a>
                                    <ul class='sub-menu'> ";
            if ($_SESSION['gestUsu1'] == "s") {
                $Menu_Left .= "  <li id='menu_ges_usu'>
                                            <a href='GestionUsuario.php'>
                                                <i class='icon-user'></i>
                                                 Gestionar Usuario
                                            </a>
                                        </li>";
            }
            if ($_SESSION['gestUsu2'] == "s") {
                $Menu_Left .= "      <li id='menu_ges_perf'>
                                            <a href='GestionPerfiles.php'>
                                                <i class='icon-key'></i>
                                                 Gestionar Perfil
                                            </a>
                                        </li>";
            }



            $Menu_Left .= "      </ul>
                                </li>";
        }
        if ($_SESSION['gesAudi'] == "s") {
            $Menu_Left .= "  <li id='menu_logs'>
                                    <a href='Administracion/logs.php'>
                                        <i class='icon-users'></i>
                                        <span class='title'>Auditoria</span>
                                        <span class='arrow '></span>
                                    </a>
                                </li>";
        }



        $Menu_Left .= "

                            </ul>
                            <!-- END MENU LATERAL -->
                        </div>
                    </div>";


        $_SESSION['Footer'] = $Footer;
        $_SESSION['User_Login'] = $User_Login;
        $_SESSION['Menu_Left'] = $Menu_Left;
    }
} else {

    $_SESSION['ses_user'] = NULL;

    //echo $con;

    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
I
            log_hora, log_accion, log_tipo, log_interfaz) VALUES

            ('" . $_POST['USER'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),

                NOW(),'Entrada fallida al sistema' ,'ENTRADA', 'login.php')";

    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }

    if ($success == 0) {

        mysqli_query($link, "ROLLBACK");
    } else {

        mysqli_query($link, "COMMIT");
    }

    $_SESSION['ses_cpb'] = "no";

    echo "1";
}

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>