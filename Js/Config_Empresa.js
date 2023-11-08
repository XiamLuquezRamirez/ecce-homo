$(document).ready(function () {
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});
    
    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_conf_emp").addClass("active");
    
    var Datos=""; var Opcion=""; var TK_ID=""; 
    Opcion="1";
    $.extend({
        Cargar_Datos_Empre: function(TK_ID1){
            Datos=""; Datos+="&ope=Cargar_DatosEmpresa&TK_ID="+TK_ID1;
            $.ajax({
                async: false,
                type: "POST",
                url: "All.php",
                data: Datos,
                dataType: 'JSON',
                success: function(data){ 
                    $("#txt_nit").val(data['TK_NIT']);
                    $("#txt_tipo_nit").selectpicker("val", data['TK_TIPO_NIT']);
                    $("#txt_razon_social").val(data['TK_RAZON_SOCIAL']);
                    $("#txt_muni").val(data['TK_MUNI']);
                    $("#txt_direccion").val(data['TK_DIRECCION']);
                    $("#txt_telefono").val(data['TK_TELEFONO']);
                    $("#txt_fax").val(data['TK_FAX']);
                    $("#txt_email").val(data['TK_EMAIL']);
                    TK_ID=data['TK_ID'];
                     $("#acc").val("2");
                } 
            });
        },
        Cargar_Tabla_Empre: function(){
           Datos=""; Datos+="&ope=CargarTabEmpresa";
            $.ajax({
                async: false,
                type: "POST",
                url: "All.php",
                data: Datos,
                success: function(data){ 
                        $('#contenido').html(data);
                } 
            });
        },
        Enviar_Datos: function(){
            Datos=""
                + "&TK_ID=" + TK_ID
                + "&TK_NIT=" + $("#txt_nit").val()
                + "&TK_TIPO_NIT=" + $("#txt_tipo_nit").val()
                + "&TK_RAZON_SOCIAL=" + $("#txt_razon_social").val()
                + "&TK_MUNI=" + $("#txt_muni").val()
                + "&TK_DIRECCION=" + $("#txt_direccion").val()
                + "&TK_TELEFONO=" + $("#txt_telefono").val()
                + "&TK_FAX=" + $("#txt_fax").val()
                + "&TK_EMAIL=" + $("#txt_email").val()
                + "&acc=" + $("#acc").val()
        ;
        }
    });
    
    $.Cargar_Tabla_Empre();

    //====BOTON VOLVER====\\
    $('#btn_volver').live('click', function () {
        window.location.href = 'AdminParametros.jsp';
    });
    //====BOTON VOLVER====\\
   
    //====BOTON GUARDAR====\\
    $('#btn_guardar').live('click', function () {
        if ($('#TK_NIT').val() == " ") {
            alert("Ingrese Una Identificación o NIT");
            $('#TK_NIT').focus();
            return;
        }
        if ($('#TK_TIPO_NIT').val() == " ") {
            alert("Ingrese Un Tipo De Codigo ");
            $('#TK_TIPO_NIT').focus();
            return;
        } 
        if ($('#TK_RAZON_SOCIAL').val() == " ") {
            alert("Ingrese Una Razon Social ");
            $('#TK_RAZON_SOCIAL').focus();
            return;
        } 
        $.Enviar_Datos();Datos+="&Opcion="+Opcion;
        $.ajax({
            type: "POST",
            url: "Gestionar_Config_Empresa.php",
            data: Datos,
            success: function(data){
                if(data==1){
                    alert("Datos Guardado Exitosamente...");
                    $.Cargar_Tabla_Empre();
                  //  window.location.href='Config_Empresa.php'; 
                }
            },
            beforeSend:function(){ $('#cargando').modal('show'); },
            complete: function() { $('#cargando').modal('hide'); },
            error: function(error_messages){
                alert('HA OCURRIDO UN ERROR');
            } 
        });
    });

    
});