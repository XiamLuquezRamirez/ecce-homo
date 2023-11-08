<?php
session_start();

putenv('TZ=America/Bogota');

if ($_SESSION['ses_user'] == NULL) {

    echo "<script>location.href='index.php'</script>";

    exit();

}
//
if (isset($_GET['Logout'])) {

    header("Location:cerrar.php?opc=1"); session_destroy();

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
        <title>Funeraria la Esperanza | Config. Empresa</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
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
        <link href="Plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL STYLES -->
        
        <!-- BEGIN THEME STYLES -->
        <link href="Css/Global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="Css/Global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="Css/Admin/Layout/css/layout.css" rel="stylesheet" type="text/css"/>
        <link id="style_color" href="Css/Admin/Layout/css/themes/light2.css" rel="stylesheet" type="text/css"/>
        <link href="Css/Admin/Layout/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->
        
        <link rel="shortcut icon" href="Img/favicon.ico"/>
        
        <script src="Js/jquery-2.1.4.min.js" type="text/javascript"></script>
        <script src="Js/Config_Empresa.js" type="text/javascript"></script>
    </head>
    <!-- END HEAD -->
    
    <!-- BEGIN BODY -->
    <body class="page-header-fixed page-quick-sidebar-over-content">
        
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
                         <?php echo $_SESSION['User_Login'];?> 
                    
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
              <?php echo $_SESSION['Menu_Left'];?> 
           
            <!-- MENU LEFT -->

            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="Administracion.php">Administración</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <i class="fa fa-gears"></i>
                                <a href="Opciones_Generales.php">Parametros Generales</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <i class="fa fa-building-o"></i>
                                <a href="Config_Empresa.php">Datos De La Empresa</a>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->

                    <!-- BEGIN PAGE CONTENT--> 
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Datos De La Empresa
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body"> 
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <p class="control-label"> Campos Obligatorios <span class="required">* </span> </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="hidden" id="acc" value="1" />
                                            <label class="control-label">Identificación o Nit <span class="required">* </span></label>
                                            <input type="text" id="txt_nit" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Tipo De Identificación o Nit <span class="required">* </span></label>
                                            <select id="txt_tipo_nit" class="bs-select form-control">
                                                <option value=" ">Selecc..</option>
                                                <option value="NIT">NIT</option>
                                                <option value="C.C.">C.C.</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Razon Social <span class="required">* </span></label>
                                            <input type="text" id="txt_razon_social" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Municipio </label>
                                            <input type="text" id="txt_muni" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Dirección </label>
                                            <input type="text" id="txt_direccion" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Telefono </label>
                                            <input type="text" id="txt_telefono" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Fax </label>
                                            <input type="text" id="txt_fax" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">E-Mail </label>
                                            <input type="text" id="txt_email" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <table class="table table-striped table-hover table-bordered" id="td_terce">
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            <label class="control-label">
                                                                Identificación o Nit 
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="control-label">
                                                                Tipo De Identificación o Nit 
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="control-label">
                                                                Razon Social 
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="control-label">
                                                                Municipio
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="control-label">
                                                                Dirección
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="control-label">
                                                                Telefono
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="control-label">
                                                                Fax
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="control-label">
                                                                E-Mail
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="control-label">
                                                                Acción
                                                            </label>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody id="contenido">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions right">
                                <button type="button" class="btn green" id="btn_guardar"><i class="fa fa-save"></i> Guardar</button>
                                <button type="button" class="btn blue" id="btn_volver"><i class="fa fa-mail-reply"></i> Volver</button>
                            </div>
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
                    <!-- END PAGE CONTENT-->

                </div>
                <!-- BEGIN CONTENT -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        
        <!-- BEGIN FOOTER -->
        <?php echo $_SESSION['Footer'];?> 
   
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
        <script src="Plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js" type="text/javascript"></script>
        <script src="Plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
        <script src="Plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        
        <script src="Plugins/select2/select2.min.js" type="text/javascript"></script>
        <script src="Plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="Plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
        <script src="Plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js" type="text/javascript"></script>
        <script src="Plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js" type="text/javascript"></script>
        <script src="Plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="Plugins/metronic.js" type="text/javascript"></script>
        <script src="Css/Admin/Layout/scripts/layout.js" type="text/javascript"></script>
        <script src="Css/Admin/Layout/scripts/quick-sidebar.js" type="text/javascript"></script>
        <script src="Css/Admin/Layout/scripts/demo.js" type="text/javascript"></script>
        <script src="Css/Admin/Pages/components-form-tools.js" type="text/javascript"></script>
        <script src="Css/Admin/Pages/ui-extended-modals.js" type="text/javascript"></script>
        <!--<script src="Css/Admin/Pages/form-validation.js" type="text/javascript"></script>-->
        <script src="Css/Admin/Pages/components-pickers.js" type="text/javascript"></script>
        <script src="Css/Admin/Pages/ui-alert-dialog-api.js" type="text/javascript"></script>
        <script src="Css/Admin/Pages/components-dropdowns.js" type="text/javascript"></script>
        <script src="Css/Admin/Pages/table-editable.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        
        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                QuickSidebar.init(); // init quick sidebar
                Demo.init(); // init demo features
                ComponentsFormTools.init();
                UIExtendedModals.init();
//                FormValidation.init();
                ComponentsPickers.init();
                UIAlertDialogApi.init();
                ComponentsDropdowns.init();
                TableEditable.init();
            });
        </script>
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>
