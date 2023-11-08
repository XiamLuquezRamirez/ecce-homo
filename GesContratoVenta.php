<?php
session_start();

putenv('TZ=America/Bogota');
date_default_timezone_set('America/Bogota');

if ($_SESSION['ses_user'] == NULL) {

    echo "<script>location.href='index.php'</script>";

    exit();
}
//
if (isset($_GET['Logout'])) {

    header("Location:cerrar.php?opc=1");
    session_destroy();
}

include("Conectar.php");

$link = conectar();
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Contrato de Venta | Funeraria La Esperanza </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>

        <meta content="" name="description"/>
        <meta content="" name="author"/>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
        <link href="Plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/simple-line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="Plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/jquery-tags-input/jquery.tagsinput.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/typeahead/typeahead.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/jquery-multi-select/css/multi-select.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL STYLES -->

        <!-- BEGIN THEME STYLES -->
        <link href="Css/Global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="Css/Global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="Css/Admin/Layout/css/layout.css" rel="stylesheet" type="text/css"/>
        <!--<link id="style_color" href="Css/Admin/Layout/css/themes/darkblue.css" rel="stylesheet" type="text/css"/>-->
        <link id="style_color" href="Css/Admin/Layout/css/themes/light2.css" rel="stylesheet" type="text/css"/>
        <link href="Css/Admin/Layout/css/custom.css" rel="stylesheet" type="text/css"/>

        <link rel="shortcut icon" href="Img/favicon.ico"/>

        <script src="Js/jquery-2.1.4.min.js" type="text/javascript"></script>
        <script src="Js/GesContratoVenta.js" type="text/javascript"></script>
        <script src="Js/funciones_generales.js" type="text/javascript"></script>
    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class="page-header-fixed page-quick-sidebar-over-content" >

        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner">

                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a>
                        <img src="Css/Admin/Layout/img/logo.png" alt="logo" class="logo-default"/>
                    </a>
                    <div class="menu-toggler sidebar-toggler hide">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div>
                </div>
                <!-- END LOGO -->

                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->

                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <?php echo $_SESSION['User_Login']; ?>

                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->

            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->

        <div class="clearfix">
        </div>

        <!-- BEGIN CONTAINER -->
        <div class="page-container">

            <!-- MENU LEFT -->
            <?php echo $_SESSION['Menu_Left']; ?>

            <!-- MENU LEFT -->

            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <div class="page-content">


                    <!-- BEGIN PAGE HEADER-->
                    <!--                    <h3 class="page-title">
                                            BUSQUEDA ACTIVA
                                        </h3>-->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="AdminServicios.php">Gesti&oacute;n de Servicios</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <i class="fa fa-cube"></i>
                                <a href="GesContratoVenta.php">Contrato de Venta  </a>
                            </li>
                        </ul>
                    </div>

                    <!-- VENTANA OCUPADO -->
                    <div id="ventOcupa" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Detalle de la Ocupaci&oacute;n</h4>


                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <ul class="nav nav-tabs">
                                    <li class="active" id="tab_01_ppOcu">
                                        <a href="#tab_01Ocu" data-toggle="tab">Datos de Ocupaci&oacute;n</a>
                                    </li>
                                    <!--                                                                        <li id="tab_02_ppOcu">
                                                                                                                <a href="#tab_02Ocu" data-toggle="tab" >Agregar Datos de Ocupaci&oacute;n</a>
                                                                                                            </li>-->
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="tab_01Ocu">
                                        <div class="portlet-body form">

                                            <div class="form-body">

                                                <div class="tab-content">
                                                    <div class="tab-pane fade active in" id="tab_011Ocu">
                                                        <div class="table-scrollable">

                                                            <div id="tab_Ocup" style="height: 250px;overflow: scroll;">

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade " id="tab_02Ocu">

                                        <div class='portlet-body form'>
                                            <form  method="post" enctype="multipart/form-data" >
                                                <div class='form-body'>

                                                    <input type="hidden" id="id_ocup" value="" />
                                                    <input type="hidden" id="accOcu" value="1" />


                                                    <div class='row'>
                                                        <div class='col-md-8' >
                                                            <div class='form-group'>
                                                                <label class='control-label'>Nombre:</label>
                                                                <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  value=""  id='txt_NomOcu' class='form-control'/>

                                                            </div>
                                                        </div>

                                                        <div class='col-md-4'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Fecha de Inhumaci&oacute;n:</label>
                                                                <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_FechInhumOcu' class='form-control'/>
                                                            </div>
                                                        </div>
                                                        <div class='col-md-12'>
                                                            <div class='form-group'>
                                                                <label class='control-label'>Observaci&oacute;n:</label>
                                                                <textarea id="txt_obserOcu" rows="2" onkeyup='this.value = this.value.toUpperCase()' class='form-control' style="width: 100%"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <center><h4 class='form-section'></h4></center>
                                                    <div class="form-actions right" >
                                                        <button type="button" class="btn green" id="btn_guardarOcup"><i class="fa fa-save"></i> Guardar</button>
                                                        <button type="button" disabled class="btn purple" id="btn_nuevoOcu"><i class="fa fa-file-o"></i> Nuevo</button>

                                                    </div>

                                                </div>
                                                </from>
                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- responsive terceros-->
                    <div id="clientes" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Selecci&oacute;n Clientes </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>

                                    <div class='form-body'>

                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div class="row">
                                                    <div class='col-md-6'>
                                                        <div id="sample_1_filter" class="dataTables_filter">
                                                            <label>
                                                                Busqueda:
                                                                <input class="form-control input-small input-inline" onkeypress="$.busqCli(this.value);" onchange="$.busqCli(this.value);" id="busq_terce" type="search" placeholder="" aria-controls="sample_1">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div id="bot_TipDoc" style="float:right;">
                                                            <button type="button" class="btn blue" id="btn_PrintNotif"><i class="fa fa-print"></i> Imprimir Lista</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="table-scrollable">
                                                    <div id="tab_Clientes" style="height: 250px;overflow: scroll;">

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <center><h4 class='form-section'></h4></center>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- responsive -->
                    <div id="DetallPago" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Detalle Del Pago.</h4>
                        </div>
                        <input type="hidden" id="id_deta_pago" value="" />
                        <input type="hidden" id="acc_detpago" value="1" />
                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>
                                    <form action='#' id="formnot" class='horizontal-form'>
                                        <div class='form-body'>
                                            <div class='row'>
                                                <div class='col-md-3'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Fecha de Pago:</label>

                                                        <input type='text' id='txt_fecha_Pago' value="<?php echo date('Y-m-d'); ?>" class='form-control' readonly/>
                                                    </div>
                                                </div>
                                                <div class='col-md-4'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Valor de La Cuota</label>
                                                        <input type='text' disabled  onkeyup='this.value = this.value.toUpperCase()' onclick="this.select();" value="$ 0,00" onblur="textm(this.value, this.id)" id='txt_ValCuota' class='form-control'/>

                                                    </div>
                                                </div>

                                                <div class='col-md-3'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Pago Hasta:</label>

                                                        <input type='text' id='txt_fecha_PagoHas' value="" class='form-control' readonly/>
                                                    </div>
                                                </div>

                                                <div class='col-md-12'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Observaci&oacute;n:</label>
                                                        <textarea id="txt_obserDetPag" rows="2" onkeyup='this.value = this.value.toUpperCase()' class='form-control' style="width: 100%"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <center><h4 class='form-section'></h4></center>
                                            <div class="form-actions right" id="mopc" >
                                                <button type="button" class="btn green" id="btn_guardarDet"><i class="fa fa-save"></i> Guardar</button>
                                                <button type="button" class="btn purple" disabled id="btn_nuevoDet"><i class="fa fa-file-o"></i> Nuevo</button>
                                                <button type="button" class="btn blue" disabled id="btn_CostaciaDetPag"><i class="fa fa-plus"></i> Constancia de Consignaci&oacute;n</button>

                                            </div>

                                        </div>
                                        </from>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- responsive necesidades-->
                    <div id="necesidad" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Selecci&oacute;n La Necesidad </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>

                                    <div class='form-body'>

                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div id="sample_1_filter" class="dataTables_filter">
                                                    <label>
                                                        Busqueda:
                                                        <input class="form-control input-small input-inline" onkeypress="$.busqNec(this.value);" onchange="$.busqNece(this.value);" id="busq_nece" type="search" placeholder="" aria-controls="sample_1">
                                                    </label>
                                                </div>
                                                <div class="table-scrollable">
                                                    <div id="tab_Nece" style="height: 250px;overflow: scroll;">

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <center><h4 class='form-section'></h4></center>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- BEGIN PAGE CONTENT-->
                    <ul class="nav nav-tabs">
                        <li class="active" id="tab_01_pp">
                            <a href="#tab_01" data-toggle="tab"> Listado de Contrato de Venta</a>
                        </li>
                        <li id="tab_02_pp">
                            <a href="#tab_02" data-toggle="tab" onclick="$.conse();" id="atitulo">Crear Contrato</a>
                        </li>
                        <li id="tab_03_pp" style="display: none;">
                            <a href="#tab_03" data-toggle="tab" >Añadir Pago</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="tab_01">

                            <div class="portlet-body form">

                                <div class="form-body">

                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="tab_011">
                                            <p>
                                            <div class='portlet box blue'>

                                                <div class='portlet-body form'>

                                                    <div class='form-body'>

                                                        <div class='row'>

                                                            <div class='col-md-6'>
                                                                <div class='form-group'>
                                                                    <label>
                                                                        Busqueda:
                                                                        <input class="form-control input-small input-inline" onkeypress="$.busqContrato(this.value);"  onchange="$.busqContrato(this.value);" id="busq_centro" type="search" placeholder="" aria-controls="sample_1">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <div class='form-group'>
                                                                    <div style="float: right;">
                                                                        <button type="button"  class="btn purple" id="btn_impriReport"><i class="fa fa-print"></i> Imprimir</button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-12'>
                                                                <div class="table-scrollable">

                                                                    <div id="tab_TipDoc" style="height: 250px;width: 1300px;overflow: scroll;">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-12'  >
                                                                <div class='row'>
                                                                    <div class='col-md-2'>
                                                                        <label>No. de Resgistros:
                                                                            <select id="nreg" onchange="$.combopag2(this.value)" class='form-control'>
                                                                                <option value="5">5</option>
                                                                                <option value="10">10</option>
                                                                                <option value="20">20</option>
                                                                                <option value="50">50</option>
                                                                                <option value="100">100</option>
                                                                                <option value="*">Sin Limite</option>
                                                                            </select>
                                                                        </label>

                                                                    </div>
                                                                    <div class='col-md-2'>


                                                                        <div id="cobpag">

                                                                        </div>

                                                                    </div>
                                                                    <div class='col-md-5'>




                                                                    </div>

                                                                    <div class='col-md-4'>
                                                                        <div id="bot_TipDoc" style="float:right;">
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <center><h4 class='form-section'></h4></center>

                                                    </div>

                                                </div>
                                            </div>
                                            </p>
                                        </div>

                                    </div>
                                </div>


                                <!-- END FORM-->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_02">
                            <p>
                            <div class="portlet box purple-intense">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-angle-right"></i>Informacion de la Venta
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <ul class="nav nav-tabs">
                                            <li class="active" id="tab_infPP">
                                                <a href="#tab_inf" data-toggle="tab"> Inf. General </a>
                                            </li>
                                            <li id="tab_constPP" style="display: none;">
                                                <a href="#tab_const"  data-toggle="tab"> Constancia de Consignaci&oacute;n </a>
                                            </li>
                                            <li id="tab_factPP" data-toggle="tab" style="display: none;">
                                                <a href="#tab_fact" data-toggle="tab"> Factura de Venta</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="tab_inf">

                                                <p>
                                                    <!--contratante-->
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Contratante
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>
                                                            <div class='row'>
                                                                <div class="col-md-3">
                                                                    <label class="control-label">C.C &oacute; NIT: <span class="required">* </span></label>
                                                                    <div class="form-inline">
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <input type="text" id="txt_iden" class="form-control"  />
                                                                                <input type="hidden" id="txt_id_cli" class="form-control"  />
                                                                                <input type="hidden" id="txt_nuevo" value="" class="form-control"  />
                                                                                <span class="input-group-btn">
                                                                                    <button type="button" id="btn_para" onclick="$.AbrirClien()" class="btn green-meadow">
                                                                                        <i class="fa fa-search fa-fw"/></i>
                                                                                    </button>
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-6' >
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Nombre:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  value=""  id='txt_NomCli' class='form-control'/>

                                                                    </div>
                                                                </div>

                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>sexo:</label>
                                                                        <select class='form-control' id="CbSexo" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="MASCULINO">MASCULINO</option>
                                                                            <option value="FEMENINO">FEMENINO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'  style="display:  none;">
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fec. Nacimiento:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_FecNac'  class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Direcci&oacute;n:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_DirCli' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>

                                                                    <div class='form-group'>

                                                                        <label class='control-label'>Barrio:</label>

                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_Dirbarrio' class='form-control'/>

                                                                    </div>

                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Tel&eacute;fono:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_TelCli' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-4'>

                                                                    <div class='form-group'>

                                                                        <label class='control-label'>E-Mail:</label>

                                                                        <input type='text'   onchange="validarEmail(this.value);" id='txtemail' class='form-control'/>

                                                                    </div>

                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Datos del Contrato
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>

                                                            <div class='row'>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'><input type="hidden" id="cons" value="" /><input type="hidden" id="acc" value="1" /><input type="hidden" id="txt_id" value="1" /><input type="hidden" id="txt_fec" value="<?php echo date('Y-m-d'); ?>" />
                                                                        <label class='control-label'>Pedido - Contrato:</label>

                                                                        <input type='text' onkeyup='this.value = this.value.toUpperCase()' id='txt_Cod' class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fecha Solicitud:</label>

                                                                        <input type='text' id='txt_fecha_Cre' value="<?php echo date('Y-m-d'); ?>" class='form-control' readonly/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Ciudad:</label>

                                                                        <input type='text' id='txt_Ciuda' onkeyup='this.value = this.value.toUpperCase()' value="VALLEDUPAR" class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Forma de Pago:</label>
                                                                        <select class='form-control' id="CbFpago"  name="options2">
                                                                            <option value=" ">SEL...</option>
                                                                            <option value="CUOTAS">CUOTAS</option>
                                                                            <option value="CONTADO">CONTADO</option>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-1'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Cuotas:</label>

                                                                        <input type='text' id='txt_Cuota' disabled onkeyup='this.value = this.value.toUpperCase()' value="" class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'><b>Venta de Lote:</b></label>  <input type="hidden"  id="txt_IdLote" >

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-1'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Jardin:</label>
                                                                        <input type="text" class="form-control input-xsmall" id="txt_jardin" >
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-1'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Zona:</label>
                                                                        <input type="text" class="form-control input-xsmall" id="txt_zona" >
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-1'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Lote:</label>
                                                                        <input type="text" class="form-control input-xsmall" id="txt_lote" >
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Tipo de Lote:</label>
                                                                        <select class='form-control' id="CbTipLote" name="options2">
                                                                            <option value=" ">SEL...</option>
                                                                            <option value="SENCILLO">SENCILLO</option>
                                                                            <option value="DOBLE">DOBLE</option>
                                                                            <option value="MAUSOLEO">MAUSOLEO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Precio:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' onclick="this.select();" value="$ 0,00" onblur="textm(this.value, this.id)" id='txt_Prec' class='form-control'/>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2' style="display:none;">
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Val. Cuota Inicial:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' onclick="this.select();" value="$ 0,00" onblur="textm(this.value, this.id)" id='txt_CuIni' class='form-control'/>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2' style="display:none;">
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Val. Cuota Mes:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  onclick="this.select();" value="$ 0,00" onblur="textm(this.value, this.id)" id='txt_CuMes' class='form-control'/>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-5'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Construcci&oacute;n:</label>
                                                                        <textarea id="txt_CostruLot" rows="1" onkeyup='this.value = this.value.toUpperCase()' class='form-control' style="width: 100%"></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-9'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Observaci&oacute;n:</label>
                                                                        <textarea id="txt_obser" rows="2" onkeyup='this.value = this.value.toUpperCase()' class='form-control' style="width: 100%"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-1' style="text-align: right">
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>&nbsp;</label>
                                                                        <div id="btn_addlote"><a onclick="$.AddLote()"  class="btn green">
                                                                                Agregar <i class="fa fa-plus"></i>
                                                                            </a></div>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'><input type="hidden" id="contLote" value="0" />
                                                                    <div class='form-group'>
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_lote">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> #
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Ubicaci&oacute;n
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Tipo de Lote
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Precio
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Construcci&oacute;n
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Observaci&oacute;n
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Ocupado
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Acci&oacute;n
                                                                                    </td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody >


                                                                            </tbody>


                                                                        </table>



                                                                    </div>
                                                                </div>

                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'><b>Venta de Osario:</b></label>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-1'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Jardin:</label>
                                                                        <input type="text" class="form-control input-xsmall" id="txt_jardinOsa" >
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-1'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">N&uacute;mero:</label>
                                                                        <input type="text" class="form-control input-xsmall" id="txt_nosa" >
                                                                    </div>
                                                                </div>

                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Osario:</label>
                                                                        <select class='form-control' id="CbTipOsa" name="options2">
                                                                            <option value="----">SEL...</option>
                                                                            <option value="TIERRA">TIERRA</option>
                                                                            <option value="PARED">PARED</option>
                                                                            <option value="MONUMENTO">MONUMENTO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Precio:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' onclick="this.select();" value="$ 0,00" onblur="textm(this.value, this.id)" id='txt_PreOsa' class='form-control'/>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2' style="display:none;">
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Val. Cuota Inicial:</label>
                                                                        <input type='text' value="0"  id='txt_prec2' class='form-control'/>
                                                                        <input type='text' value="0"  id='txt_PrecAnt' class='form-control'/>
                                                                        <input type='text' value="0"  id='txt_PrecAntOsa' class='form-control'/>
                                                                        <input type='text' id='txt_IdOsa' class='form-control'/>

                                                                    </div>
                                                                </div>

                                                                <div class='col-md-5'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Construcci&oacute;n:</label>
                                                                        <textarea id="txt_CostruOsa" rows="1" onkeyup='this.value = this.value.toUpperCase()' class='form-control' style="width: 100%"></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-9'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Observaci&oacute;n:</label>
                                                                        <textarea id="txt_obserOsa" rows="2" onkeyup='this.value = this.value.toUpperCase()' class='form-control' style="width: 100%"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-1' style="text-align: right">
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>&nbsp;</label>
                                                                        <div id="btn_addOsario"><a onclick="$.AddOsario()" class="btn green">
                                                                                Agregar <i class="fa fa-plus"></i>
                                                                            </a></div>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'><input type="hidden" id="contOsa" value="0" />
                                                                    <div class='form-group'>
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_osar">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> #
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Ubicaci&oacute;n
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Tipo de Osario
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Precio
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Construcci&oacute;n
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Observaci&oacute;n
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Ocupado
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Acci&oacute;n
                                                                                    </td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody >


                                                                            </tbody>


                                                                        </table>



                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Precio Total:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' onclick="this.select();" value="$ 0,00" onblur="textm(this.value, this.id)" id='txt_PrecTot' class='form-control'/>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2' >
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Val. Cuota Inicial:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' onclick="this.select();" value="$ 0,00" onblur="textm(this.value, this.id)" id='txt_CuIniTot' class='form-control'/>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2' >
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Val. Cuota Mes:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  onclick="this.select();" value="$ 0,00" onblur="textm(this.value, this.id)" id='txt_CuMesTot' class='form-control'/>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>

                                                <p>
                                                    <!-- personas ordenar inhumacion -->
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Personas Para Ordenar Inhumaciones
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>
                                                        <input type="hidden" id="contPers" class="form-control"  />
                                                        <div class='form-body'>
                                                            <div class='row'>
                                                                <div class="col-md-2">
                                                                    <label class="control-label">Identificaci&oacute;n: <span class="required">* </span></label>
                                                                    <div class="form-inline">
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <input type="text" id="txt_idenPers" class="form-control"  />
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-6' >
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Nombre:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  value=""  id='txt_NomPers' class='form-control'/>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Tel&eacute;fono:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_TelPers' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-1' style="text-align: right">
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>&nbsp;</label>
                                                                        <a onclick="$.AddPersona()" class="btn green">
                                                                            Agregar <i class="fa fa-plus"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_Perso">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> #
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Identificaci&oacute;n
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Nombre
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Tel&eacute;fono
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Acci&oacute;n
                                                                                    </td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody >


                                                                            </tbody>


                                                                        </table>



                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>

                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Observaciones.
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>
                                                            <div class='row'>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Observaci&oacute;n</label>
                                                                        <textarea id="txt_obsercion" rows="3" class='form-control' style="width: 100%"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>



                                            </div>
                                            <div class="tab-pane fade" id="tab_const">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Datos de la Constancia
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>

                                                            <div class='row'>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'><input type="hidden" id="consConst" value="" /><input type="hidden" id="txt_idCost" value="" />
                                                                        <label class='control-label'>Consecutivo:</label>

                                                                        <input type='text' onkeyup='this.value = this.value.toUpperCase()' id='txt_CodConst' class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fecha Creacion:</label>

                                                                        <input type='text' id='txt_fecha_CreCos' value="<?php echo date('Y-m-d'); ?>" class='form-control' readonly/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fecha de Consignaci&oacute;n:</label>
                                                                        <input type='text' id='txt_fecha_Cons' value="<?php echo date('Y-m-d'); ?>" class='form-control' readonly/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Ciudad:</label>

                                                                        <input type='text' id='txt_CiudaCons' onkeyup='this.value = this.value.toUpperCase()' value="" class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label' style="font-weight:bold;">Datos del Cliente:</label>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="control-label">C.C &oacute; NIT: <span class="required">* </span></label>
                                                                    <div class="form-inline">
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <input type="text" id="txt_idenconst" class="form-control"  />

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-9' >
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Nombre:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  value=""  id='txt_NomCliConst' class='form-control'/>

                                                                    </div>
                                                                </div>

                                                                <div class='col-md-6'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Direcci&oacute;n:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_DirConst' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Tel&eacute;fono:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_TelCliConst' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Consignaci&oacute;n:</label>
                                                                        <select class='form-control' id="CbConsig" name="options2">
                                                                            <option value=" ">Sel...</option>
                                                                            <option value="DAVIVIENDA">DAVIVIENDA</option>
                                                                            <option value="BANCOLOMBIA">BANCOLOMBIA</option>
                                                                            <option value="TARJETA">TARJETA</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12' >
                                                                    <div class='form-group'>
                                                                        <label class='control-label' style="font-weight:bold;">Datos de los Conceptos:</label>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <input type="hidden" id="contConst" value="" />
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_Constancia">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> #
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Concepto
                                                                                    </td>

                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Valor
                                                                                    </td>

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody >
                                                                            </tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th colspan='2' style='text-align: right;'>Total a Pagar:</th>
                                                                                    <th colspan='1'><label id='gtotalCostancia' style='font-weight: bold;'></label></th>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>



                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <div class="form-actions right"  >
                                                                            <button type="button" class="btn green" id="btn_guardarCost"><i class="fa fa-save"></i> Guardar Constancia</button>
                                                                            <button type="button" class="btn blue-dark" style="display: none;" id="btn_impriCost"><i class="fa fa-file-pdf-o"></i> Imprimir</button>

                                                                        </div>
                                                                    </div>
                                                                </div>




                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>

                                            </div>

                                            <div class="tab-pane fade" id="tab_fact">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Datos de la Factura
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>

                                                            <div class='row'>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'><input type="hidden" id="consFact" value="" /><input type="hidden" id="txt_idCost" value="" /><input type="hidden" id="txt_idFact" value="" /><input type="hidden" id="txt_valetra" value="" />
                                                                        <label class='control-label'>Consecutivo:</label>

                                                                        <input type='text' onkeyup='this.value = this.value.toUpperCase()' id='txt_CodFact' class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fecha Creaci&oacute;n:</label>

                                                                        <input type='text' id='txt_fecha_CreFact' value="<?php echo date('Y-m-d'); ?>" class='form-control' readonly/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Ciudad:</label>

                                                                        <input type='text' id='txt_CiudaFact' onkeyup='this.value = this.value.toUpperCase()' value="" class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label' style="font-weight:bold;">Datos del Cliente:</label>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="control-label">C.C &oacute; NIT: <span class="required">* </span></label>
                                                                    <div class="form-inline">
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <input type="text" id="txt_idenFact" class="form-control"  />

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-9' >
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Nombre:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  value=""  id='txt_NomCliFact' class='form-control'/>

                                                                    </div>
                                                                </div>

                                                                <div class='col-md-6'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Direcci&oacute;n:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_DirFact' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Tel&eacute;fono:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_TelCliFact' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'><input type="hidden" id="txt_vtotalFactF" value="0" class="form-control"  />
                                                                        <label class='control-label'>Forma de Pago:</label>
                                                                        <select class='form-control' id="CbFpagoFact" name="options2">
                                                                            <option value=" ">Sel...</option>
                                                                            <option value="15 DIAS">15 DIAS</option>
                                                                            <option value="30 DIAS">30 DIAS</option>
                                                                            <option value="CONTADO">CONTADO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12' >
                                                                    <div class='form-group'>
                                                                        <label class='control-label' style="font-weight:bold;">Datos de los Detalles:</label>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <input type="hidden" id="contFactura" value="" />
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_Factura">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> #
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Concepto
                                                                                    </td>

                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Valor
                                                                                    </td>

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody >
                                                                            </tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th colspan='2' style='text-align: right;'>Total a Pagar:</th>
                                                                                    <th colspan='1'><label id='gtotalFactura' style='font-weight: bold;'></label></th>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>



                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Valor en Letra:</label>
                                                                        <label id='gtotalDetLetra' style='font-weight: bold;'></label>
                                                                    </div>
                                                                </div>

                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <div class="form-actions right"  >
                                                                            <button type="button" class="btn green" id="btn_guardarFact"><i class="fa fa-save"></i> Guardar Constancia</button>
                                                                            <button type="button" class="btn blue-dark" style="display: none;" id="btn_impriFact"><i class="fa fa-file-pdf-o"></i> Imprimir</button>

                                                                        </div>
                                                                    </div>
                                                                </div>




                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>

                                            </div>


                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                        <button type="button" class="btn green" id="btn_guardar"><i class="fa fa-check"></i> Guardar</button>
                                        <button type="button" class="btn red" id="btn_cancelar"><i class="fa fa-times"></i> Cancelar</button>
                                        <button type="button" class="btn blue" id="btn_volver"><i class="fa fa-mail-reply"></i> Volver</button>
                                        <button type="button" class="btn blue-dark" style="display: none;" id="btn_impri"><i class="fa fa-file-pdf-o"></i> Imprimir</button>
                                        <button type="button" class="btn  red-soft"   style="display: none;" id="btn_constancia"><i class="fa fa-plus"></i> Constancia</button>
                                        <button type="button" class="btn red-soft" style="display: none;" id="btn_factura"><i class="fa fa-plus"></i> Factura</button>
                                        <button type="button" class="btn red-soft"  style="display: none;" id="btn_Pago"><i class="fa fa-plus"></i> Añadir Pago</button>
                                    </div>
                                    <!-- END FORM-->
                                </div>
                            </div>

                            <div id="cargando" class="modal fade" tabindex="-1" data-width="150">
                                <div class="modal-footer">
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </p>
                        </div>
                        <div class="tab-pane fade" id="tab_03">
                            <p>
                            <div class="portlet box purple-intense">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-angle-right"></i>Informaci&oacute;n del Contrato Previsi&oacute;n
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1" data-toggle="tab"> Inf. General </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="tab_1">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Datos Del Contrato de Venta
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>

                                                            <div class='row'>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group'><input type="hidden" id="id_venta" value="" />
                                                                        <label class='control-label'>Contrato No:</label>
                                                                        <input type='text' onkeyup='this.value = this.value.toUpperCase()' disabled id='txt_CodC' class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fecha Creaci&oacute;n:</label>
                                                                        <input type='text' id='txt_fecha_CreC' value="" disabled class='form-control' readonly/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Ciudad:</label>

                                                                        <input type='text' id='txt_CiudaC' onkeyup='this.value = this.value.toUpperCase()' disabled value="" class='form-control' />
                                                                    </div>
                                                                </div>

                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Forma de Pago:</label>
                                                                        <select class='form-control' disabled id="CbFormPagoC" name="options2">
                                                                            <option value=" ">SEL...</option>
                                                                            <option value="CUOTAS">CUOTAS</option>
                                                                            <option value="CONTADO">CONTADO</option>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>No. Cuotas:</label>
                                                                        <input type='text' id='txt_NCuot' onkeyup='this.value = this.value.toUpperCase()' disabled value="" class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-5'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Titular:</label>
                                                                        <input type="text" disabled id="txt_titular" class="form-control"  />

                                                                    </div>
                                                                </div>

                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Asesor:</label>
                                                                        <input type='text' id='txt_asesorC' disabled onkeyup='this.value = this.value.toUpperCase()' value="<?php echo $_SESSION['ses_nombre']; ?>" class='form-control' />
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>

                                                <p>
                                                    <!--contratante-->
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Datos del Pago
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>
                                                        <div class='form-body'>
                                                            <div class='row'>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'><b>Valor del Contrato:</b></label>
                                                                        <label class='control-label' id="val_contrato" ></label>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'><b>Valor de la Cuota Mensual:</b></label>
                                                                        <label class='control-label' disabled id="val_Mens_contrato"></label>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'><b>Saldo Pendiente:</b></label>
                                                                        <label class='control-label' disabled id="val_Saldo"></label>
                                                                    </div>
                                                                </div>

                                                                <div class='col-md-12' id='divDeta'  ><input type="hidden" id="saldo" value="" /><input type="hidden" id="mes" value="" />
                                                                    <div class='form-group'>
                                                                        <label class='control-label'><b>Detalles del Contrato: &nbsp;</b></label>
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_Deta">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i>Cuota
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i>Fecha
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i>Valor
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i>Saldo
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Acci&oacute;n
                                                                                    </td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody >


                                                                            </tbody>


                                                                        </table>
                                                                        <a onclick="$.AddDetPago()" class="btn green">
                                                                            Agregar Pago <i class="fa fa-plus"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>

                                            </div>
                                            <div class="tab-pane fade" id="tab_2">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i> Grupo Familiar B&aacute;sico
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>
                                                        <input type="hidden" id="contGruBas" value="0" class="form-control"  />
                                                        <div class='form-body'>

                                                            <div class='row'>
                                                                <div class="col-md-3">
                                                                    <label class="control-label">Identificaci&oacute;n: <span class="required">* </span></label>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" id="txt_IdGruBas" class="form-control"  />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-9' >
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Apellidos y Nombres Completos:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  value=""  id='txt_NomGruBas' class='form-control'/>

                                                                    </div>
                                                                </div>


                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Parentesco:</label>
                                                                        <select class='form-control' id="CbParenGruBas" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="ESPOSO(A)">ESPOSO(A) </option>
                                                                            <option value="HIJO(A)">HIJO(A)</option>
                                                                            <option value="HERMANO(A)">HERMANO(A)</option>
                                                                            <option value="PADRE">PADRE</option>
                                                                            <option value="MADRE">MADRE</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Sexo:</label>
                                                                        <select class='form-control' id="CbSexoGrupBas" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="MASCULINO">MASCULINO</option>
                                                                            <option value="FEMENINO">FEMENINO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Estado de Salud:</label>
                                                                        <select class='form-control' id="CbEstGrupBas" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="BUENA">BUENA</option>
                                                                            <option value="MALA">MALA</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-1'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Edad:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_EdadGrupBas' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Ciudad de Residencia:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' value="VALLEDUPAR" id='txt_CiudResGrupBas' class='form-control'/>
                                                                    </div>
                                                                </div>



                                                                <div class='col-md-12' style="text-align: right">
                                                                    <div class='form-group'>
                                                                        <a onclick="$.AddGrupBas()" class="btn green">
                                                                            Agregar <i class="fa fa-plus"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_GrupBas">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> #
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Identificaci&oacute;n
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Apellido y Nombres
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Parentesco
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Estado Salud
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Sexo
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Edad
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Ciudad
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Acci&oacute;n
                                                                                    </td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody >


                                                                            </tbody>


                                                                        </table>



                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>
                                                <p>

                                                </p>
                                            </div>
                                            <div class="tab-pane fade" id="tab_3">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Grupo Familiar Secundario y/o Adicionales
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>
                                                        <input type="hidden" id="contGruSec" value="0" class="form-control"  />
                                                        <div class='form-body'>
                                                            <div class='row'>
                                                                <div class="col-md-3">
                                                                    <label class="control-label">Identificaci&oacute;n: <span class="required">* </span></label>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" id="txt_IdGruSec" class="form-control"  />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-9' >
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Apellidos y Nombres Completos:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  value=""  id='txt_NomGruSec' class='form-control'/>

                                                                    </div>
                                                                </div>


                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Parentesco:</label>
                                                                        <select class='form-control' id="CbParenGruSec" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="ESPOSO(A)">ABUELO(A) </option>
                                                                            <option value="HIJO(A)">NIETO(A)</option>
                                                                            <option value="HERMANO(A)">PRIMO(A)</option>
                                                                            <option value="PADRE">CUÑADO(A)</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Sexo:</label>
                                                                        <select class='form-control' id="CbSexoGrupSec" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="MASCULINO">MASCULINO</option>
                                                                            <option value="FEMENINO">FEMENINO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Estado de Salud:</label>
                                                                        <select class='form-control' id="CbEstaGrupSec" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="BUENA">BUENA</option>
                                                                            <option value="MALA">MALA</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-1'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Edad:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_EdadGrupSec' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Ciudad de Residencia:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' value="VALLEDUPAR" id='txt_CiudResGrupSec' class='form-control'/>
                                                                    </div>
                                                                </div>



                                                                <div class='col-md-12' style="text-align: right">
                                                                    <div class='form-group'>
                                                                        <a onclick="$.AddGrupSec()" class="btn green">
                                                                            Agregar <i class="fa fa-plus"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class='form-group'>
                                                                        <table class='table table-striped table-hover table-bordered' id="tb_GrupSec">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> #
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Identificaci&oacute;n
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Apellido y Nombres
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Parentesco
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Estado Salud
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Sexo
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Edad
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Ciudad
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Acci&oacute;n
                                                                                    </td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody >


                                                                            </tbody>


                                                                        </table>



                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>
                                            </div>
                                            <div class="tab-pane fade" id="tab_4">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Forma de Pago
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                            <input type="hidden" id="cont" value="0" />
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>

                                                            <div class='row'>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Valor Anual/Previsi&oacute;n:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' onclick="this.select();" value="$ 0,00" onblur="textm(this.value, this.id)" id='txt_ValAn' class='form-control'/>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Val. Cuota Mes:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' onclick="this.select();" value="$ 0,00" onblur="textm(this.value, this.id)" id='txt_ValMe' class='form-control'/>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Forma de Pago:</label>
                                                                        <select class='form-control' id="CbFormPago" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="SEMANAL">SEMANAL</option>
                                                                            <option value="QUINCENAL">QUINCENAL</option>
                                                                            <option value="MENSUAL">MENSUAL</option>
                                                                            <option value="ANUAL">ANUAL</option>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Apartir de:</label>

                                                                        <input type='text' id='txt_fecha_pago' readonly value="<?php echo date('Y-m-d'); ?>" class='form-control' readonly/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Asesor:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' value="<?php echo $_SESSION['ses_nombre']; ?>" id='txt_Asesor' class='form-control'/>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- END FORM-->
                                </div>
                            </div>

                            <!--                            <div id="cargando" class="modal fade" tabindex="-1" data-width="150">
                                                            <div class="modal-footer">
                                                                <div class="progress progress-striped active">
                                                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                                  -->

                            </p>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT-->

                </div>
                <!-- BEGIN CONTENT -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->

        <!-- BEGIN FOOTER -->
        <?php echo $_SESSION['Footer']; ?>

        <!-- END FOOTER -->

        <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        <!-- BEGIN CORE PLUGINS -->
        <script src="Plugins/jquery.min.js" type="text/javascript"></script>
        <script src="Plugins/jquery-migrate.min.js" type="text/javascript"></script>
        <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
        <script src="Plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="Plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="Plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="Plugins/jquery.cokie.min.js" type="text/javascript"></script>
        <script src="Plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="Plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
        <script src="Plugins/fuelux/js/spinner.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        <script src="Plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="Plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="Plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
        <script src="Plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
        <script src="Plugins/typeahead/typeahead.bundle.js" type="text/javascript"></script>
        <script src="Plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
        <script src="Plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="Plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="Plugins/select2/select2.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="Plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="Plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="Plugins/metronic.js" type="text/javascript"></script>
        <script src="Css/Admin/Layout/scripts/layout.js" type="text/javascript"></script>
        <script src="Css/Admin/Layout/scripts/quick-sidebar.js" type="text/javascript"></script>
        <script src="Css/Admin/Layout/scripts/demo.js" type="text/javascript"></script>
        <script src="Css/Admin/Pages/components-form-tools.js" type="text/javascript"></script>
        <script src="Css/Admin/Pages/ui-extended-modals.js" type="text/javascript"></script>
        <script src="Css/Admin/Pages/form-validation.js" type="text/javascript"></script>
        <script src="Css/Admin/Pages/components-pickers.js" type="text/javascript"></script>
        <script src="Css/Admin/Pages/ui-alert-dialog-api.js" type="text/javascript"></script>
        <script src="Css/Admin/Pages/components-dropdowns.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->

        <script>
                                                                            jQuery(document).ready(function () {
                                                                                Metronic.init(); // init metronic core components
                                                                                Layout.init(); // init current layout
                                                                                QuickSidebar.init(); // init quick sidebar
                                                                                Demo.init(); // init demo features
                                                                                ComponentsFormTools.init();
                                                                                UIExtendedModals.init();
                                                                                FormValidation.init();
                                                                                ComponentsPickers.init();
                                                                                UIAlertDialogApi.init();
                                                                                ComponentsDropdowns.init();
                                                                            });
        </script>
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>