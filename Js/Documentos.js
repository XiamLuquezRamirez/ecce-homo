$(document).ready(function () {

    $("#home").removeClass("start active open");
    $("#menu_doc").addClass("start active open");
    var Op_Formu=$("#op_formu").val();
    if(Op_Formu=="Save"){ $("#menu_doc_save").addClass("active"); }
    if(Op_Formu=="Upad"){ $("#menu_doc_update").addClass("active"); }
    if(Op_Formu=="Cons"){ $("#menu_doc_consul").addClass("active"); }
    if(Op_Formu=="Dele"){ $("#menu_doc_delete").addClass("active"); }

    $("#txt_fecha_incial").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });
    $("#txt_fecha_final").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });

    var Op_Cargar_Doc=""; var Datos_Final=""; Op_Cargar_Doc="NO";
    var File_Name, File_Size; var Op_Validar=0;

    $.extend({
        Run_Doc: function(){
            Datos_Final="";
            var Text_Fase=$("#cbx_fase option:selected").text();
            var Text_Dpto=$("#cbx_dpto option:selected").text();
            var Text_Muni=$("#cbx_muni option:selected").text();
            if(Text_Fase=="SELECC.."){ Text_Fase=" "; }
            if(Text_Dpto=="SELECC.."){ Text_Dpto=" "; }
            if(Text_Muni=="SELECC.."){ Text_Muni=" "; }
            Datos_Final+=""
                + "&Fecha_Ini=" + $("#txt_fecha_incial").val()
                + "&Fecha_Fin=" + $("#txt_fecha_final").val()
                + "&Cod_Tipo=" + $("#cbx_tipo").val()
                + "&Text_Tipo=" + $("#cbx_tipo option:selected").text()
                + "&Cod_Depen=" + $("#cbx_dependencia").val()
                + "&Text_Depen=" + $("#cbx_dependencia option:selected").text()
                + "&Cod_Fase=" + $("#cbx_fase").val()
                + "&Text_Fase=" + Text_Fase
                + "&Cod_Dpto=" + $("#cbx_dpto").val()
                + "&Text_Dpto=" + Text_Dpto
                + "&Cod_Muni=" + $("#cbx_muni").val()
                + "&Text_Muni=" + Text_Muni
                + "&Src_Doc=" + $("#txt_src_archivo").val()
                + "&File_Name=" + File_Name
                + "&File_Size=" + File_Size
            ;
        },
        Cargar_Doc: function(){
            var formData = new FormData($("#form")[0]);
            $.ajax({
                async: false,
                type: 'POST',
                url: "../Cargar_Documento",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    if (data['Op'].trim() == "Local") {
                        Op_Cargar_Doc="SI";
                        $('#txt_src_archivo').val(data['Ruta'].trim()+data['Dir'].trim());
                    } else {
                        Op_Cargar_Doc="SI";
                        $('#txt_src_archivo').val(data['Ruta'].trim()+data['Dir'].trim());
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        Cancelar_Save: function(){
            if (confirm("¿Esta Seguro De Cancelar La Operación?")) {
                window.location.href = "../Formu_Save_Doc";
            }
        },
        Format_Bytes: function(bytes, decimals) {
            if(bytes == 0) return '0 Byte';
            var k = 1024;
            var dm = decimals + 1 || 3;
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            var i = Math.floor(Math.log(bytes) / Math.log(k));
            return (bytes / Math.pow(k, i)).toPrecision(dm) + ' ' + sizes[i];
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
        },
        Validar: function(){
            var id="";
            id="#txt_fecha_incial";
            if($(id).val()=="" || $(id).val()==" "){
                Op_Validar=1; $(id).css('background-color', '#EA5338');
            }else{
                $(id).removeAttr('style');
            }
            id="#txt_fecha_final";
            if($(id).val()=="" || $(id).val()==" "){
                Op_Validar=1; $(id).css('background-color', '#EA5338');
            }else{
                $(id).removeAttr('style');
            }
            id="#div_tipo";
            if($("#cbx_tipo").val()=="" || $("#cbx_tipo").val()==" "){
                Op_Validar=1; $(id).css('background-color', '#EA5338');
            }else{
                $(id).removeAttr('style');
            }
            id="#div_depen";
            if($("#cbx_dependencia").val()=="" || $("#cbx_dependencia").val()==" "){
                Op_Validar=1; $(id).css('background-color', '#EA5338');
            }else{
                $(id).removeAttr('style');
            }
            id="#txt_archivo";
            if($(id).val()=="" || $(id).val()==" "){
                Op_Validar=1; $(id).css('background-color', '#EA5338');
            }else{
                $(id).removeAttr('style');
            }
        },
        Ver_Doc: function(Id_Doc){
            var Datos=""; Datos+="&Id_Doc="+Id_Doc+"&Opcion=Ver_Doc";
            $.ajax({
                async: false,
                type: "POST",
                url: "../Funciones_Doc",
                data: Datos,
                dataType: 'json',
                success: function (data) {
                    if (data['Salida'].trim() == 1) {
//                        window.open("../Reportes/wilmer.jpg", 'Tepichikana');
                        window.open(data['Ruta'], 'Tepichikana');
                    }
                    if (data['Salida'].trim() == 2) {
                        alert("Su Sesión Ha Terminado. Inicie Sesión Nuevamente..");
                        window.location.href = "../Logout";
                    }
                    if (data['Salida'].trim() == 3) {
                        alert("Ha Ocurrido un Error...");
                    }
                },
                beforeSend: function () {
                    $('#cargando').modal('show');
                },
                complete: function () {
                    $('#cargando').modal('hide');
                },
                error: function (error) {
                    alert("HA OCURRIDO UN ERROR");
                }
            });
        }
    });

    //====BUSQUEDA DE REGISTRO====\\
    $("#btn_busq").on("click", function() {
        var Aux="";
        if($("#txt_busq").val()==""){
            Aux="Inactivo";
        }else{
            Aux="Activo";
        }
        var Datos=""; Datos+="&Opcion=Busq_Doc&Aux="+Aux+"&Txt="+$("#txt_busq").val();
        $.ajax({
            type: "POST",
            url: "../Funciones_Doc",
            data: Datos,
            dataType: 'json',
            success: function(data){
                $('#tb_conte').show(100).html(data['Salida']);
            },
            error: function(error_messages){
                alert('HA OCURRIDO UN ERROR');
            } 
        });
    });

    //===INPUT FILE===\\
    $("#txt_archivo").change(function(e){
        var file = this.files[0],
        Modifi= file.lastModifiedDate,
        fileType= file.type,
        fileName = file.name,
        fileSize = file.size;
        var Mb=$.Format_Bytes(fileSize,2);
        $("#fileSize").html(Mb);
        File_Name=fileName; File_Size=Mb;
        var Aux=Mb.split(" ");
        if(Aux[0]>=1 && Aux[1].trim()=="GB"){
            $("#fileSize").html($.Format_Bytes(0,2));
            $.Alert("#msg_save", "El Archivo Peso Mas De 1 GigaBytes, No Se Puede Cargar El Archivo...", "warning");
            $(this).val(""); return;
        }
    });
    
    //===VALIDAR FECHAS===\\
    $('#txt_fecha_final').on('changeDate', function(ev){
        var Dat=""; 
        Dat="&Opcion=Validar_Fecha" +
                "&Fecha_Ini="+$("#txt_fecha_incial").val() +
                "&Fecha_Fin="+$("#txt_fecha_final").val();
        $.ajax({
            type: "POST",
            url: "../Funciones_Doc",
            data: Dat,
            dataType: 'json',
            success: function(data){
                if(data['Salida'].trim()==1){
                    if(data['Fecha'].trim()=="Invalido"){ 
                        $.Alert("#msg_save", "La Fecha Final No Puede Ser Menor A La Inicial..", "warning");
                        $("#txt_fecha_incial").val("");
                        $("#txt_fecha_final").val("");
                    }else{
                        $.Alert("#msg_save", "Fecha Correcta...", "success");
                    }  
                }
                if(data['Salida'].trim()==2){
                    alert("Su Sesión Ha Terminado. Inicie Sesión Nuevamente..");
                    window.location.href="../Logout";
                }
                if(data['Salida'].trim()==3){
                    alert("Ha Ocurrido un Error...");
                }
            },
            error: function(error){
                alert("Ha Ocurrido un Error..."+error);
            }               
        });
    });
    
    //====BTN GUARDAR====\\
    $("#btn_guardar").on("click", function () {
        Op_Cargar_Doc="NO";
        $.Validar();
        if(Op_Validar==1){
            $.Alert("#msg_save", "Por Favor Llenar Campos Obligatorios...", "warning");
            Op_Validar=0; return;
        }
        $.Cargar_Doc();
        if(Op_Cargar_Doc=="NO"){
            return;
        }
        var Datos=""; $.Run_Doc(); Datos+=Datos_Final+"&Opcion=Guardar";
        $.ajax({
            async: false,
            type: "POST",
            url: "../Gestionar_Doc",
            data: Datos,
            dataType: 'json',
            success: function (data) {
                if (data['Salida'].trim() == 1) {
                    $("#btn_guardar").prop('disabled', true);
                    alert('DATOS GUARDADOS DE MANERA EXITOSA...');
                    window.location.href = "../Formu_Save_Doc";
                }
                if (data['Salida'].trim() == 2) {
                    $("#btn_guardar").css('display', 'none');
                    alert("Su Sesión Ha Terminado. Inicie Sesión Nuevamente..");
                    window.location.href = "../Logout";
                }
                if (data['Salida'].trim() == 3) {
                    $("#btn_guardar").prop('disabled', true);
                    alert("Ha Ocurrido un Error...");
                }
            },
            beforeSend: function () {
                $('#cargando').modal('show');
            },
            complete: function () {
                $('#cargando').modal('hide');
            },
            error: function (error) {
                $("#btn_guardar").prop('disabled', true);
                $("#txt_error").val(JSON.stringify(error));
                alert("HA OCURRIDO UN ERROR");
            }
        });
    });
    
    //====BTN VOLVER====\\
    $("#btn_volver").on("click", function () {
        if (confirm("¿Esta Seguro De Volver?")) {
            window.location.href = "../Menu_Documentos.jsp";
        }
    });
    
    //====RESTINGIR BOTON BORRAR PARA IR ATRAS====\\
    if (typeof window.event == 'undefined') {
        document.onkeypress = function (e) {
            var test_var = e.target.nodeName.toUpperCase();
            if (e.target.type)
                var test_type = e.target.type.toUpperCase();
            if ((test_var == 'INPUT' && test_type == 'TEXT') || test_var == 'TEXTAREA') {
                return e.keyCode;
            } else if (e.keyCode == 8) {
                e.preventDefault();
            }
        }
    } else {
        document.onkeydown = function () {
            var test_var = event.srcElement.tagName.toUpperCase();
            if (event.srcElement.type)
                var test_type = event.srcElement.type.toUpperCase();
            if ((test_var == 'INPUT' && test_type == 'TEXT') || test_var == 'TEXTAREA') {
                return event.keyCode;
            } else if (event.keyCode == 8) {
                event.returnValue = false;
            }
        }
    }
    
});