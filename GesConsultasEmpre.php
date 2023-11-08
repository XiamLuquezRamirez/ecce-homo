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
        <title>Consulta de Cartera Empresarial | Funeraria La Esperanza </title>
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
        <script src="Js/GesConsultasEmpre.js" type="text/javascript"></script>
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
                                <a href="GesConsultasRetra.php.php">Consulta de Cartera</a>
                                <i class="fa fa-angle-right"></i>
                            </li>

                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="portlet box purple-intense">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-angle-right"></i>Gesti&oacute;n de Consultas
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="#" class="horizontal-form">
                                <div class="form-body">

                                    <div class="tab-content">
                                        <div class="tab-pane fade active in" id="tab_1">
                                            <p>
                                            <div class='portlet box blue'>

                                                <div class='portlet-body form'>
                                                    <form action='#' class='horizontal-form'>
                                                        <div class='form-body'>

                                                            <div class='row'>
                                                                <div class='col-md-3'>
                                                                    <div class='form-group'>
                                                                        <label class='control-label'> Consultar: </label>
                                                                        <select class='form-control' onchange="$.TipCons(this.value);"  id="CbconsuTip" name="options2">
                                                                            <option value=" ">Select...</option>
                                                                            <option value="empre">EMPRESA Y AÑO</option>
                                                                            <option value="mes">MES Y AÑO</option>
                                                                            <option value="atrasadas">EMPRESAS ATRASADAS</option>

                                                                        </select>

                                                                    </div>
                                                                </div>


                                                                <div class='col-md-5' id="div_empr"  style="display: none;">
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Empresa:</label>
                                                                        <select class="form-control select2me" data-placeholder="Seleccione..."  id="CbEmpre" name="options2">
                                                                            <option value=''>Select...</option>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2' id="div_anio"  style="display: none;">
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>Anio:</label>
                                                                        <input type='text' id='txt_anio' value="" class='form-control' readonly/>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-2' id="div_mes"  style="display: none;">
                                                                    <div class='form-group'>
                                                                        <label class='control-label'>  Mes:</label>
                                                                        <input type='text' id='txt_mes' value=""  class='form-control' readonly/>

                                                                    </div>
                                                                </div>

                                                                <div class='col-md-2'>
                                                                    <div class='form-group'>

                                                                        <label style="padding-top: 25px;">
                                                                            <button type="button" class="btn blue" onclick="$.consu();" id="btn_consultar"><i class="fa fa-search"></i> Consultar</button>
                                                                        </label>

                                                                    </div>
                                                                </div>
                                                                <div class='col-md-12'>
                                                                    <div class="table-scrollable">

                                                                        <div id="tab_TipDoc" style="height: 300px; width: 1200px;overflow: scroll;">

                                                                        </div>

                                                                    </div>
                                                                    <div style="text-align: right;display: none;" id="divInf">
                                                                        <label class='control-label'><b>N. de Afiliados:</b></label>
                                                                        <label class='control-label' id="n_Afiliados" >0</label>
                                                                        <label class='control-label'><b>Valor de Cartera:</b></label>
                                                                        <label class='control-label' id="val_cartera" >$ 0,00</label>
                                                                    </div>
                                                                    <div style="text-align: right;">
                                                                        <label>
                                                                            <button type="button" class="btn blue-dark" id="btn_impriReport"><i class="fa fa-file-pdf-o"></i> Imprimir</button>
                                                                        </label>
                                                                    </div>

                                                                </div>
                                                                <div class='col-md-12'  >

                                                                    <div id="bot_TipDoc" style="float:right;">

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

                                                                        <!--                                                                        <div class='col-md-4'>
                                                                                                                                                    <div id="bot_TipDoc" style="float:right;">
                                                                                                                                                    </div>

                                                                                                                                                </div> -->

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <center><h4 class='form-section'></h4></center>

                                                        </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </form>
                            <!-- END FORM-->
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
        <script src="Plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
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
                                                                                    jQuery(document).ready(function() {
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