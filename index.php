<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<!DOCTYPE html>
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Funeraria la Esperanza | Bienvenido</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
        <link href="Plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/simple-line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->
        
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="Css/Admin/login.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
        <link href="Plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL STYLES -->
        <!-- END PAGE LEVEL SCRIPTS -->
        
        <!-- BEGIN THEME STYLES -->
        <link href="Css/Global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="Css/Global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="Css/Admin/Layout/css/layout.css" rel="stylesheet" type="text/css"/>
        <link id="style_color" href="Css/Admin/Layout/css/themes/light2.css" rel="stylesheet" type="text/css"/>
        <link href="Css/Admin/Layout/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->
        
        <link rel="shortcut icon" href="Img/favicon.ico"/>
        
        <script src="Js/jquery-2.1.4.min.js" type="text/javascript"></script>
        <script src="Js/Inicio.js" type="text/javascript"></script>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="login" id="body1">
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <div class="menu-toggler sidebar-toggler">
        </div>
        <!-- END SIDEBAR TOGGLER BUTTON -->
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a>
                <img src="Css/Admin/Layout/img/logo-big.png" alt="" height="200" width="300"/>
            </a>
        </div>
        
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form">
                <h3 class="form-title">INICIAR SESIÓN</h3>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Usuario</label>
                    <input id="txt_username" class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Ingrese su usuario" name="username"/>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Contraseña</label>
                    <input id="txt_key" class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Ingrese su contraseña" name="password"/>
                </div>
                <div id="msg"></div>
                <div class="form-actions">
                    <button type="button" id="btn_login" class="btn btn-success uppercase">Entrar</button>
                </div>
              
            </form>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            
            <!-- END FORGOT PASSWORD FORM -->
            <!-- BEGIN REGISTRATION FORM -->
             
            <!-- END REGISTRATION FORM -->
        </div>
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
        <!-- BEGIN CORE PLUGINS -->
        
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="Plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
        <script src="Plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
        <!-- END PAGEVEL PLUGINS -->
        
        <!-- BEGIN PALEVEL SCRIPTS -->
        <script src="Plugins/metronic.js" type="text/javascript"></script>
        <script src="Css/Admin/Layout/scripts/layout.js" type="text/javascript"></script>
        <script src="Css/Admin/Layout/scripts/quick-sidebar.js" type="text/javascript"></script>
        <script src="Css/Admin/Layout/scripts/demo.js" type="text/javascript"></script>
        <script src="Css/Admin/Pages/ui-extended-modals.js" type="text/javascript"></script>
        <!--<script s"../Css/Admin/Pages/form-validation.js" type="text/javascript"></script>-->
        <script src="Css/Admin/Pages/ui-alert-dialog-api.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        
        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                QuickSidebar.init(); // init quick sidebar
                Demo.init(); // init demo features
                UIExtendedModals.init();
//                FormValidation.init();
                UIAlertDialogApi.init();
            });
        </script>
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>
