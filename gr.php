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
        <title>Contrato de Previsi&oacute;n | Funeraria La Esperanza </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
        <script src="Js/GesContratoPrevi.js" type="text/javascript"></script>
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
                                <a href="../AdminServicios.php">Gesti&oacute;n de Servicios</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <i class="fa fa-cube"></i>
                                <a href="GesContratoPrevi.php">Contrato de Previsi&oacute;n  </a>
                            </li>
                        </ul>
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
                                                <div id="sample_1_filter" class="dataTables_filter">
                                                    <label>
                                                        Busqueda:
                                                        <input class="form-control input-small input-inline" onkeypress="$.busqCli(this.value);" onchange="$.busqCli(this.value);" id="busq_terce" type="search" placeholder="" aria-controls="sample_1">
                                                    </label>
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
                                                <div class='col-md-4'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Mes a Pagar</label>
                                                        <select id="cbx_mesPag" class='form-control'>
                                                            <option value=" ">SEL...</option>
                                                            <option value="ENERO">ENERO</option>
                                                            <option value="FEBRERO">FEBRERO</option>
                                                            <option value="MARZO">MARZO</option>
                                                            <option value="ABRIL">ABRIL</option>
                                                            <option value="MAYO">MAYO</option>
                                                            <option value="JUNIO">JUNIO</option>
                                                            <option value="JULIO">JULIO</option>
                                                            <option value="AGOSTO">AGOSTO</option>
                                                            <option value="SEPTIEMBRE">SEPTIEMBRE</option>
                                                            <option value="OCTUBRE">OCTUBRE</option>
                                                            <option value="NOVIEMBRE">NOVIEMBRE</option>
                                                            <option value="DICIEMBRE">DICIEMBRE</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='col-md-3'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Pago Hasta:</label>

                                                       <input type='text' id='txt_fecha_PagoHas' value="" class='form-control' readonly/>
                                                    </div>
                                                </div>
                                                <div class='col-md-4'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Pago en:</label>
                                                        <select id="cbx_Pagen" class='form-control'>
                                                            <option value=" ">SEL...</option>
                                                            <option value="OFICINA">OFICINA</option>
                                                            <option value="COBRADORES">COBRADORES</option>
                                                           
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='col-md-4'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Recibo No.:</label>
                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' disabled id='txt_nRecibo' class='form-control'/>
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
                                                <button type="button" class="btn blue" disabled id="btn_Recibo"><i class="fa fa-plus"></i> Recibo</button> 

                                            </div>

                                        </div>
                                        </from>
                                </div>	
                            </div>
                        </div>

                    </div>
                      <!-- responsive -->
                    <div id="VentRecibo" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Recibo de Pago</h4> 
                      </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>
                                    <form action='#' id="formnot" class='horizontal-form'>
                                        <div class='form-body'>
                                            <div class='row'>
                                                <div class='col-md-4'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Recibo No:</label>

                                                        <input type='hidden' id='txt_idRecib' value="" class='form-control' />
                                                        <input type='hidden' id='consRec' value="" class='form-control' readonly/>
                                                       <input type='text' id='txt_ConRec' value="" class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='col-md-4'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Fecha:</label>
                                                         <input type='text' id='txt_fecha_RecPag' value="<?php echo date('Y-m-d'); ?>" class='form-control' readonly/>
                                                        
                                                    </div>
                                                </div>
                                                
                                                <div class='col-md-4'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Valor:</label>

                                                       <input type='text' id='txt_ValRecib' value="" class='form-control' readonly/>
                                                    </div>
                                                </div>
                                                <div class='col-md-12'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Recibimos de:</label>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class='form-group'>
                                                        <label class='control-label'>Identificaci&oacute;n:</label>
                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  value=""  disabled="" id='txt_indenRec' class='form-control'/>

                                                    </div>
                                                </div>
                                                <div class='col-md-8' >
                                                    <div class='form-group'>
                                                        <label class='control-label'>Nombre:</label>
                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' disabled="" value=""  id='txt_NomRec' class='form-control'/>

                                                    </div>
                                                </div>
                                                <div class='col-md-12' >
                                                    <div class='form-group'>
                                                        <label class='control-label'>La Suma De:</label>
                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' disabled="" value=""  id='txt_ValLetra' class='form-control'/>

                                                    </div>
                                                </div>
                                                <div class='col-md-12' >
                                                    <div class='form-group'>
                                                        <label class='control-label'>Por Concepto:</label>
                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  value="P.A.E.E"  id='txt_ConcepRec' class='form-control'/>

                                                    </div>
                                                </div>
                                                <div class='col-md-3' >
                                                    <div class='form-group'>
                                                        <label class='control-label'>Cuota:</label>
                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' disabled value=""  id='txt_CuoMes' class='form-control'/>

                                                    </div>
                                                </div>
                                                <div class='col-md-3' >
                                                    <div class='form-group'>
                                                        <label class='control-label'>Forma de Pago:</label>
                                                         <select id="cbx_Fpago" class='form-control'>
                                                            <option value=" ">SEL...</option>
                                                            <option value="EFECTIVO">EFECTIVO</option>
                                                            <option value="CHEQUE">CHEQUE</option>
                                                      
                                                        </select>

                                                    </div>
                                                </div>
                                                   <div class='col-md-3' >
                                                    <div class='form-group'>
                                                        <label class='control-label'>No:</label>
                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  value=""  id='txt_Ncheque' class='form-control'/>

                                                    </div>
                                                </div>
                                                   <div class='col-md-3' >
                                                    <div class='form-group'>
                                                        <label class='control-label'>Banco:</label>
                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  value=""  id='txt_BancoRec' class='form-control'/>

                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <center><h4 class='form-section'></h4></center>  
                                            <div class="form-actions right" id="mopc" >
                                                <button type="button" class="btn green" id="btn_guardarReci"><i class="fa fa-save"></i> Guardar</button>
                                                <button type="button" class="btn blue-soft"  style="display: none;" id="btn_ImprRec"><i class="fa fa-print"></i> Imprimir</button> 
                                                <button type="button" class="btn red-soft"  style="display: none;" id="btn_Anular"><i class="fa fa-times"></i> Anular</button> 
                                               
                                            </div>

                                        </div>
                                        </from>
                                </div>	
                            </div>
                        </div>

                    </div>
                     <!-- responsive -->
                    <div id="anios" class="modal fade" tabindex="-1" data-width="600">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Insertar A&ntilde;o</h4> 
                        </div>
                       
                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>
                                    <form action='#' id="formnot" class='horizontal-form'>
                                        <div class='form-body'>
                                            <div class='row'>
                                                <div class='col-md-3'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Año:</label>
                                                        <input type='text' onkeyup='this.value = this.value.toUpperCase()' maxlength="4" id='txt_anio' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='col-md-4'>
                                                    <div class='form-group'>
                                                        <label class="control-label">Valor Anual/Previsi&oacute;n:</label>
                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' onclick="this.select();" value="$ 0,00" onblur="textm(this.value, this.id)" id='txt_ValAnAnio' class='form-control'/>
                                                    </div>
                                                </div>
                                                <div class='col-md-4'>
                                                    <div class='form-group'>
                                                        <label class="control-label">Val. Cuota Mes:</label>
                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' onclick="this.select();" value="$ 0,00" onblur="textm(this.value, this.id)" id='txt_ValMeAnio' class='form-control'/>
                                                    </div>
                                                </div>
                                                <div class='col-md-4'>
                                                    <div class='form-group'>
                                                        <label class="control-label">Forma de Pago:</label>
                                                        <select class='form-control' id="CbFormPagoAnio" name="options2">
                                                            <option value=" ">Select...</option>
                                                            <option value="SEMANAL">SEMANAL</option>
                                                            <option value="QUINCENAL">QUINCENAL</option>                                                                    
                                                            <option value="MENSUAL">MENSUAL</option>                                                                    
                                                            <option value="ANUAL">ANUAL</option>                                                                    
                                                        </select>
                                                   </div>
                                                </div>
                                                <div class='col-md-4'>
                                                    <div class='form-group'>
                                                        <label class='control-label'>Apartir de:</label>

                                                        <input type='text' id='txt_fecha_pagoAnio' readonly value="<?php echo date('Y-m-d'); ?>" class='form-control' readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <center><h4 class='form-section'></h4></center>  
                                            <div class="form-actions right" >
                                                <button type="button" class="btn green" id="btn_guardarAnio"><i class="fa fa-save"></i> Guardar</button>
                                                <button type="button" class="btn purple" disabled id="btn_nuevoAnio"><i class="fa fa-file-o"></i> Nuevo</button> 

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
                    <!-- responsive beneficiarios-->
                    <div id="beneficiarios" class="modal fade" tabindex="-1" data-width="760">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title" id='titformi'>Beneficiarios</h4> 
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class='portlet-body form'>

                                    <div class='form-body'>

                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Grupo Familiar Basico.</label>

                                                </div>
                                            </div>
                                            <div class='col-md-12'>

                                                <div class="table-scrollable">
                                                    <div  style="height: 200px;overflow: scroll;">
                                                        <table class='table table-striped table-hover table-bordered' id="tab_benbas">
                                                            
                                                        </table>
                                                    </div> 

                                                </div>    
                                            </div>
                                            <div class='col-md-12'>
                                                <div class='form-group'>
                                                    <label class='control-label'>Grupo Familiar Secundario.</label>

                                                </div>
                                            </div>
                                            <div class='col-md-12'>
                                                <div class="table-scrollable">
                                                    <div  style="height: 200px;overflow: scroll;">
                                                         <table class='table table-striped table-hover table-bordered' id="tab_bensec">
                                                            
                                                        </table>
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
                            <a href="#tab_01" data-toggle="tab"> Listado de Contrato de Previsi&oacute;nes</a>
                        </li>
                        <li id="tab_02_pp">
                            <a href="#tab_02" data-toggle="tab" onclick="$.conse();" id="atitulo">Crear Previsi&oacute;n</a>
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
                                                                        <input class="form-control input-small input-inline"  onchange="$.busqContrato(this.value);" id="busq_centro" type="search" placeholder="" aria-controls="sample_1">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <div class='form-group'>
                                                                    <div style="float: right;">
                                                                        <button type="button" style="display: none;" class="btn purple" id="btn_nuevo1"><i class="fa fa-file-o"></i> Nuevo</button> 

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class='col-md-12'>
                                                                <div class="table-scrollable">

                                                                    <div id="tab_TipDoc" style="height: 250px;overflow: scroll; width: 1300px;">

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
                                        <i class="fa fa-angle-right"></i>Informaci&oacute;n de la Previsi&oacute;n
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
                                            <li>
                                                <a href="#tab_2" data-toggle="tab">Grupo Familiar Basico</a>
                                            </li>
                                            <li>
                                                <a href="#tab_3" data-toggle="tab"> Grupo Familiar Secundario </a>
                                            </li>
                                            <li>
                                                <a href="#tab_4" data-toggle="tab"> Forma de Pago</a>
                                            </li>

                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="tab_1">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Datos De la Previsi&oacute;n
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
                                                                        <label class='control-label'>Contrato No:</label>
                                                                        <input type='text' onkeyup='this.value = this.value.toUpperCase()' id='txt_Cod' class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fecha Creaci&oacute;n:</label>
                                                                        <input type='text' id='txt_fecha_Cre' value="<?php echo date('Y-m-d'); ?>" class='form-control' readonly/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Ciudad:</label>

                                                                        <input type='text' id='txt_Ciuda' onkeyup='this.value = this.value.toUpperCase()' value="VALLEDUPAR" class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Plan de Prevenci&oacute;n exequial:</label>
                                                                        <select class='form-control' id="CbPlanExe" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="DIOCESANO">DIOCESANO</option>
                                                                            <option value="FAMILIA INTEGRAL">FAMILIA INTEGRAL</option>
                                                                            <option value="DORADO">DORADO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Tipo de Vinculaci&oacute;n:</label>
                                                                        <select class='form-control' id="CbTipVinc" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="INICIAL">INICIAL</option>
                                                                            <option value="RENOVACION">RENOVACI&Oacute;N</option>
                                                                            <option value="TRASLADO">TRASLADO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Empresa Anterior:</label>
                                                                        <input type='text' id='txt_Empre' onkeyup='this.value = this.value.toUpperCase()' value="" class='form-control' />
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
                                                            <i class='fa fa-angle-right'></i>Datos del Titular
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
                                                                                   <input type="hidden" id="txt_nuevo" value="SI" class="form-control"  />
                                                                                <span class="input-group-btn">
                                                                                    <button type="button" id="btn_para" onclick="$.AbrirClien()" class="btn green-meadow">
                                                                                        <i class="fa fa-search fa-fw"/></i>
                                                                                    </button>
                                                                                </span>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-5' >
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Nombre:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  value=""  id='txt_NomCli' class='form-control'/>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Tipo de Cliente:</label>
                                                                        <select class='form-control' id="CbTipClien" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="DEPENDIENTE">DEPENDIENTE</option>
                                                                            <option value="INDEPENDIENTE">INDEPENDIENTE</option>
                                                                            <option value="COOPERADO">COOPERADO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Sexo:</label>
                                                                        <select class='form-control' id="CbSexo" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="MASCULINO">MASCULINO</option>
                                                                            <option value="FEMENINO">FEMENINO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Fec. Nacimiento:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_FecNac' readonly class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-6'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Direcci&oacute;n:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_Dir' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Tel&eacute;fono:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_Tel' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Direcci&oacute;n de Recaudo para Independiente:</label>
                                                                        <select class='form-control' id="CbDirRecaudo" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="RESIDENCIA">RESIDENCIA </option>
                                                                            <option value="OTRA">OTRA</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-5'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Cual:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_OtrDir' class='form-control'/>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </p>
                                                <p>                                       
                                                    <!--fallecido--> 
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Datos Empleador/Agremiaci&oacute;n (Independiente con Afiliaci&oacute;n Coletiva o Cooperado)
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
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <input type="text" id="txt_IdEmpl" class="form-control"  />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-9' >
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Nombre o Razon Social del Empleador:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()'  value=""  id='txt_NomEmpl' class='form-control'/>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Direcci&oacute;n:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_DirEmpl' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Ciudad:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_CiuEmpl' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Departamento:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_DepEmpl' class='form-control'/>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Tel&eacute;fono:</label>
                                                                        <input type='text'  onkeyup='this.value = this.value.toUpperCase()' id='txt_TelEmpl' class='form-control'/>
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
                                                                            <option value="PADRASTRO">PADRASTRO</option>
                                                                            <option value="MADRASTRA">MADRASTRA</option>
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
                                                                            <option value="PADRE">TIO(A)</option>
                                                                            <option value="PADRE">SOBRINO(A)</option>
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
                                    <div class="form-actions right">
                                        <button type="button" class="btn green" id="btn_guardar"><i class="fa fa-check"></i> Guardar</button>
                                        <button type="button" class="btn red" id="btn_cancelar"><i class="fa fa-times"></i> Cancelar</button> 
                                        <button type="button" class="btn blue" id="btn_volver"><i class="fa fa-mail-reply"></i> Volver</button>
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
<!--                                            <li>
                                                <a href="#tab_2" data-toggle="tab">Grupo Familiar Basico</a>
                                            </li>
                                            <li>
                                                <a href="#tab_3" data-toggle="tab"> Grupo Familiar Secundario </a>
                                            </li>
                                            <li>
                                                <a href="#tab_4" data-toggle="tab"> Forma de Pago</a>
                                            </li>-->

                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="tab_1">
                                                <p>
                                                <div class='portlet box blue'>
                                                    <div class='portlet-title'>
                                                        <div class='caption'>
                                                            <i class='fa fa-angle-right'></i>Datos Del Contrato Previsi&oacute;n
                                                        </div>
                                                        <div class='tools'>
                                                            <a href='javascript:;' class='collapse'></a>
                                                        </div>
                                                    </div>
                                                    <div class='portlet-body form'>

                                                        <div class='form-body'>

                                                            <div class='row'>
                                                                <div class='col-md-4'>
                                                                    <div class='form-group'><input type="hidden" id="id_prevision" value="" />
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
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Plan de Prevenci&oacute;n exequial:</label>
                                                                        <select class='form-control' disabled id="CbPlanExeC" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="DIOCESANO">DIOCESANO</option>
                                                                            <option value="FAMILIA INTEGRAL">FAMILIA INTEGRAL</option>
                                                                            <option value="DORADO">DORADO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Tipo de Vinculaci&oacute;n:</label>
                                                                        <select class='form-control' disabled id="CbTipVincC" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="INICIAL">INICIAL</option>
                                                                            <option value="RENOVACION">RENOVACI&Oacute;N</option>
                                                                            <option value="TRASLADO">TRASLADO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                 <div class='col-md-2'>
                                                                    <div class='form-group'>
                                                                        <label class="control-label">Forma de Pago:</label>
                                                                        <select class='form-control' disabled id="CbFormPagoC" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="SEMANAL">SEMANAL</option>
                                                                            <option value="QUINCENAL">QUINCENAL</option>                                                                    
                                                                            <option value="MENSUAL">MENSUAL</option>                                                                    
                                                                            <option value="ANUAL">ANUAL</option>                                                                    
                                                                        </select>

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
                                                                        <input type='text' id='txt_asesorC' disabled onkeyup='this.value = this.value.toUpperCase()' value="" class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Ultimo Cobrador:</label>
                                                                        <input type='text' id='txt_cobraC' disabled onkeyup='this.value = this.value.toUpperCase()' value="" class='form-control' />
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-6' style="text-align: right;" >
                                                                    <div class='form-group'>
                                                                       <a onclick="$.MostrarBenef()" class="btn green">
                                                                            Mostrar Beneficiarios <i class="fa fa-plus"></i>
                                                                        </a>        
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

                                                                
                                                                <div class='col-md-3' >
                                                                    <div class='form-group'>
                                                                        <label class='control-label'><b>Años del Contrato:</b></label>
                                                                                   <table class='table table-striped table-hover table-bordered' id='tb_Anios'>
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i>Año
                                                                                    </td>
                                                                                                                                                                    
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i> Acci&oacute;n
                                                                                    </td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody >


                                                                            </tbody>


                                                                        </table>
                                                                        <a onclick="$.AddAnio()" class="btn green">
                                                                            Insertar Año del Contrato <i class="fa fa-plus"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-9' id='divDeta' style="display: none;" ><input type="hidden" id="saldo" value="" /><input type="hidden" id="mes" value="" /><input type="hidden" id="txt_anioSel" value="" />
                                                                    <div class='form-group'>
                                                                        <label class='control-label'><b>Detalles del Contrato: &nbsp;</b></label><label id='an_cont'></label><br/>
                                                                        
                                                                        <label class='control-label'><b>Valor del Contrato:</b></label>
                                                                        <label class='control-label' id="val_contrato" ></label>
                                                                        <label class='control-label'><b>Valor de la Cuota Mensual:</b></label>
                                                                        <label class='control-label' disabled id="val_Mens_contrato"></label>
                                                                                   <table class='table table-striped table-hover table-bordered' id="tb_DetaxAnio">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i>Cuota
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i>Mes Pagado
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i>Fecha 
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i>Recibo 
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i>Valor 
                                                                                    </td>
                                                                                    <td>
                                                                                        <i class='fa fa-angle-right'></i>Pago Hasta 
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