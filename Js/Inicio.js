$(document).ready(function () {
    var datos = "";
    $("#txt_username").focus();
    $.extend({
        
        Alert: function (div, msg, type) {
            Metronic.alert({
                container: div, //  [ "" ] alerts parent container(by default placed after the page breadcrumbs)
                place: "append", //  [ append, prepent] append or prepent in container 
                type: type, //  [success, danger, warning, info] alert's type
                message: msg, //  Mensaje Del Alert
                close: true, //  [true, false] make alert closable
                reset: true, //  [true, false] close all previouse alerts first
                focus: true, //  [true, false] auto scroll to the alert after shown
                closeInSeconds: 5, //  [0, 1, 5, 10] auto close after defined seconds
                icon: ""            //  ["", "warning", "check", "user"] put icon before the message
            });
        },
        Login: function () {
            var user = $("#txt_username").val();
            var key = $("#txt_key").val();
            if (user === "" || user === " ") {
                $.Alert("#msg", "Usuario Y Contraseña Incorrecta... Verifique Por favor", "danger");
                return;
            }
            if (key === "" || key === " ") {
                $.Alert("#msg", "Usuario Y Contraseña Incorrecta... Verifique Por favor", "danger");
                return;
            }
            datos = "";
            datos = "&USER=" + user + "&KEY=" + key;
            $.ajax({
                type: 'POST',
                url: 'Login.php',
                data: datos,
                async: false,
                success: function (data) {
           
                    if (data == 0) {
                        $.Alert("#msg", "Bienvenido...", "success");
                        window.location.href = 'Administracion.php';
                    } else {
                        $.Alert("#msg", "Usuario Y Contraseña Incorrecta... Verifique Por Favor", "danger");
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }
    });

   

    $("#btn_login").on("click", function () {
        $.Login();
    });
    
   

    $("#body1").on("keypress", function (event) {
        if (event.which == 13) {
            $.Login();
        }
    });
    
});