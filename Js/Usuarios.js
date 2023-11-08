$(document).ready(function () {
    
    $("#home").removeClass("start active open");
    $("#menu_user").addClass("start active open");
    
    var Op_Save=""; Op_Save="New"; var Id_User="";
    var rutaimagen; 
    rutaimagen="Img/sin_firma.png"; 
    
    //====CARGAR EPS====\\
    $.extend({
        Cargar_User: function () {
            var datos = {
                Opcion: "Cargar_User",
                Auxi: "Inactivo"
            }
            $.ajax({
                type: "POST",
                url: "../Funciones_User",
                data: datos,
                success: function (data) {
                    $('#Conte_Lista').show(100).html("");
                    $('#Conte_Lista').show(100).html(data);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Edit_User: function (Id) {
            $("#btn_nuevo").css("display", "none");
            $("#btn_guardar").css("display","initial");
            $("#btn_cancelar").css("display","initial");
            var datos = {
                Opcion: "Edit_User",
                Id: Id
            }
            $.ajax({
                type: "POST",
                url: "../Funciones_User",
                data: datos,
                dataType: 'json',
                success: function (data) {
                    $("#div_contra").css("display" , "initial");
                    Op_Save="Edit_Datos";
                    
                    $("#tab_01_pp").removeClass("active");
                    $("#tab_01").removeClass("active in");
                    
                    $("#tab_02_pp").addClass("active");
                    $("#tab_02").addClass("active in");
                    
                    Id_User=data['ID'];
                    $("#txt_ced").val(data['CEDULA']);
                    $("#txt_nombre").val(data['NOMBRE']);
                    $("#cbx_sexo").selectpicker("val", data['SEXO']);
                    $("#txt_telefono").val(data['TELEFONO']);
                    $("#txt_email").val(data['EMAIL']);
                    $("#txt_user").val(data['USUARIO']);
                    $("#cbx_perfil").selectpicker("val", data['PERFIL']);
                    $("#cbx_estado").selectpicker("val", data['ESTADO']);
                    
                    $.Habilitar();
                    $("#txt_key").prop('disabled', true);
                    $("#txt_key2").prop('disabled', true);
                },
                beforeSend:function(){ $('#cargando').modal('show'); },
                complete: function() { $('#cargando').modal('hide'); },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Elimi_User: function (Id) {
            if(confirm("¿Esta Seguro De Desea Eliminar Este Registro?")){
                var datos = {
                    Op_Save: "Eliminar",
                    Id: Id
                }
                $.ajax({
                    type: "POST",
                    url: "../Gestionar_User",
                    data: datos,
                    success: function (data) {
                        if (trimAll(data) == "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.Cargar_User();
                        }else{
                            alert('HA OCURRIDO UN ERROR');
                        }
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        Hab_Contra: function () {
            if ($('#chk_contra').attr('checked')) {
                Op_Save="Edit_Key";
                $("#txt_key").prop('disabled', false);
                $("#txt_key2").prop('disabled', false);
            } else {
                $("#txt_key").prop('disabled', true);
                $("#txt_key2").prop('disabled', true);
            }
        },
        Validar_Contra: function(){
            var key, key2;
            key=$("#txt_key").val();
            key2=$("#txt_key2").val();
            if(key==key2){
                $.Alert("#msg_user", "Contraseñas Validas", "success");
                $("#btn_guardar").css("display", "initial");
            }else{
                $.Alert("#msg_user", "Las Contraseñas NO SON IGUALES", "danger");
                $("#btn_guardar").css("display","none");
            }
        },
        Limpiar: function(){
            $("#txt_ced").val("");
            $("#txt_nombre").val("");
            $("#cbx_sexo").selectpicker("val", " ");
            $("#txt_telefono").val("");
            $("#txt_email").val("");
            $("#txt_user").val("");
            $("#txt_key").val("");
            $("#txt_key2").val("");
            $("#cbx_perfil").selectpicker("val", " ");
        },
        Habilitar: function(){
            $("#txt_ced").prop('disabled', false);
            $("#txt_nombre").prop('disabled', false);
            $("#txt_telefono").prop('disabled', false);
            $("#txt_email").prop('disabled', false);
            $("#txt_user").prop('disabled', false);
            $("#txt_key").prop('disabled', false);
            $("#txt_key2").prop('disabled', false);
            
            $("#cbx_sexo").prop('disabled', false);
            $("#cbx_sexo").selectpicker('refresh');
            $("#cbx_estado").prop('disabled', false);
            $("#cbx_estado").selectpicker('refresh');
            $("#cbx_perfil").prop('disabled', false);
            $("#cbx_perfil").selectpicker('refresh');
        },
        Desahabilitar: function(){
            $("#txt_ced").prop('disabled', true);
            $("#txt_nombre").prop('disabled', true);
            $("#txt_telefono").prop('disabled', true);
            $("#txt_email").prop('disabled', true);
            $("#txt_user").prop('disabled', true);
            $("#txt_key").prop('disabled', true);
            $("#txt_key2").prop('disabled', true);
            
            $("#cbx_sexo").prop('disabled', true);
            $("#cbx_sexo").selectpicker('refresh');
            $("#cbx_estado").prop('disabled', true);
            $("#cbx_estado").selectpicker('refresh');
            $("#cbx_perfil").prop('disabled', true);
            $("#cbx_perfil").selectpicker('refresh');
        },
        Alert: function(div, mssg, type){
            Metronic.alert({
                container: div,     //  [ "" ] alerts parent container(by default placed after the page breadcrumbs)
                place: "append",    //  [ append, prepent] append or prepent in container 
                type: type,         //  [success, danger, warning, info] alert's type
                message: mssg,      //  Mensaje Del Alert
                close: true,        //  [true, false] make alert closable
                reset: true,        //  [true, false] close all previouse alerts first
                focus: true,        //  [true, false] auto scroll to the alert after shown
                closeInSeconds: 10,  //  [0, 1, 5, 10] auto close after defined seconds
                icon: ""            //  ["", "warning", "check", "user"] put icon before the message
            });
        }
    });
    //====CARGAR EPS====\\
    
    $.Cargar_User();
    
     //====BUSQUEDA DE REGISTRO====\\
    $("#btn_busqueda_doc").on("click", function() {
        var Aux="";
        if($("#txt_busq_user").val()==""){
            Aux="Inactivo";
        }else{
            Aux="Activo";
        }
        var Datos=""; Datos+="&Opcion=Cargar_User&Auxi="+Aux+"&Txt="+$("#txt_busq_user").val();
        $.ajax({
            async: false,
            type: "POST",
            url: "../Funciones_User",
            data: Datos,
            success: function(data){
                $('#Conte_Lista').show(100).html(data);
            },
            error: function(error_messages){
                alert('HA OCURRIDO UN ERROR');
            } 
        });
    });
    
    //====BOTON VOLVER====\\
    $('#btn_volver').live('click', function () {
        window.location.href = '../Opciones_Generales.jsp';
    });
    //====BOTON VOLVER====\\
    
    //====VERIFICAR SI EXISTE LA CEDULA USUARIO====\\
    $('#txt_ced').change(function(){
        if($("#txt_ced").val()==" " || $("#txt_ced").val()==""){
            $.Alert("#msg_user", "Numero De Identificación Erroneo", "danger");
            $("#txt_ced").val(""); $('#txt_ced').focus(); $("#btn_guardar").css("display","none");
            return;
        }
        var datos = {
            Opcion: "Existe_Ced",
            Ced: $("#txt_ced").val()
        }
        $.ajax({
            type: "POST",
            url: "../Funciones_User",
            data: datos,
            dataType: 'json',
            success: function (data) {
                if(data['Salida'] == "Existe"){
                    $.Alert("#msg_user", "Ya existe un Usuario Registrado con esta Identificación", "danger");
                    $("#txt_ced").val(""); $('#txt_ced').focus(); $("#btn_guardar").css("display","none");
                }
                if(data['Salida'] == "No_Existe"){
                    $.Alert("#msg_user", "Numero De Identificación Valida", "success");
                    $("#btn_guardar").css("display", "initial");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
    //====VERIFICAR SI EXISTE LA CEDULA USUARIO====\\
    
    //====VERIFICAR SI EXISTE USUARIO====\\
    $('#txt_user').change(function(){
        if($("#txt_user").val()==" " || $("#txt_user").val()==""){
            $.Alert("#msg_user", "Nombre De Usuario Erroneo", "danger");
            $("#txt_user").val(""); $('#txt_user').focus(); $("#btn_guardar").css("display","none");
            return;
        }
        var datos = {
            Opcion: "Existe_User",
            Usu: $("#txt_user").val()
        }
        $.ajax({
            type: "POST",
            url: "../Funciones_User",
            data: datos,
            dataType: 'json',
            success: function (data) {
                if(data['Salida'] == "Existe"){
                    $.Alert("#msg_user", "Ya Existe Este Usuario..Por Favor Eliga Otro Usuario", "danger");
                    $("#txt_user").val(""); $('#txt_user').focus(); $("#btn_guardar").css("display","none");
                }
                if(data['Salida'] == "No_Existe"){
                    $("#btn_guardar").css("display", "initial");
                    $.Alert("#msg_user", "Nombre De Usuario Valido", "success");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
    //====VERIFICAR SI EXISTE USUARIO====\\
    
    //====VERIFICAR SI LAS CONTRASEÑAS SON IGUALES ====\\
    $('#txt_key2').change(function(){
        $.Validar_Contra();
    });
    //====VERIFICAR SI LAS CONTRASEÑAS SON IGUALES ====\\
    
    //====BOTON NUEVO====\\
    $('#btn_nuevo').live('click', function () {
        $("#btn_nuevo").css("display", "none");
        $("#btn_guardar").css("display","initial");
        $("#btn_cancelar").css("display","initial");
        $.Habilitar();
        $.Limpiar();
        $("#txt_ced").focus();
    });
    //====BOTON NUEVO====\\
    
    //====BOTON NUEVO====\\
    $('#btn_cancelar').live('click', function () {
        $("#div_contra").css("display" , "none");
        Id_User="";
        $.Desahabilitar();
        $.Limpiar();
    });
    //====BOTON NUEVO====\\
    
    //====BOTON GUARDAR====\\
    $('#btn_guardar').live('click', function () {
        if($("#txt_user").val()==" " || $("#txt_user").val()==""){
            $.Alert("#msg_user", "Nombre De Usuario Erroneo", "danger");
            $("#txt_user").val(""); $('#txt_user').focus();
            return;
        }
        var datos = {
            Op_Save: Op_Save,
            Ced: $("#txt_ced").val(),
            Nom: $("#txt_nombre").val(),
            Sexo: $("#cbx_sexo").val(),
            Tele: $("#txt_telefono").val(),
            Email: $("#txt_email").val(),
            User: $("#txt_user").val(),
            Key: $("#txt_key").val(),
            Estado: $("#cbx_estado").val(),
            Perfil: $("#cbx_perfil").val(),
            Id: Id_User,
            firma: rutaimagen
        }
        $.ajax({
            type: "POST",
            url: "../Gestionar_User",
            data: datos,
            success: function (data) {
                if (trimAll(data) == "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.Cargar_User();
                    $.Desahabilitar();
                    $.Limpiar();
                    $("#btn_nuevo").css("display", "initial");
                    $("#btn_guardar").css("display","none");
                    $("#btn_cancelar").css("display","none");
                }else{
                    alert('HA OCURRIDO UN ERROR');
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
    //====BOTON GUARDAR====\\
 
    $('#cargar_firma').live('click',function(){
       var formData = new FormData($("#form")[0]); 
       $.ajax({
           type: 'POST',
           url: "../Cargar_Firma",
           data: formData,
           cache: false,
           contentType: false,
           processData: false,
           success: function(data){  
                $('#firma1').attr("src","../"+data.trim());
                $('#firma2').attr("src","../"+data.trim());
                rutaimagen=data.trim();
                $('#modal').modal('hide'); 
           },
           error: function(error_messages){
                alert('HA OCURRIDO UN ERROR');
           }
       });   
    }); 
    
});