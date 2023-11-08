$(document).ready(function () {
    
    var datos=""; var host, db, user, key;
    
    $.extend({
        Datos: function(){
            host=$("#name_host").val();
            db=$("#name_db").val();
            user=$("#name_user").val();
            key=$("#name_key").val();
        },
        Enviar: function(type, url1, datos, msg1){
            $.ajax({
                async: false,
                type: type,
                url: url1,
                data: datos,
                success: function(data){
                    if(data==1){
                        $("#resp").val(msg1);
                    }else{
                        $("#resp").val(data);
                    }  
                }              
            });
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
                closeInSeconds: 5,  //  [0, 1, 5, 10] auto close after defined seconds
                icon: ""            //  ["", "warning", "check", "user"] put icon before the message
            });
        },
        Enviar_Datos: function(){
            datos+="" 
                + "&HOST=" + host.trim() + "&DB=" + db.trim()
                + "&USER=" + user.trim() + "&KEY=" + key.trim();
        }
    });
    
    $("#btn_probar").on("click", function(){
        $.Datos(); datos="";
        $.Enviar_Datos();
        datos+="&Opcion=Probar";
        $.Enviar("POST", "Gestionar_Conexion", datos, "Conexión Exitosa a "+db);
        $.Alert("#msg", $("#resp").val(), "info");
    });
    
    $("#btn_guardar").on("click", function(){
        $.Datos(); datos="";
        $.Enviar_Datos();
        datos+="&Opcion=Guardar";
        $.Enviar("POST","Gestionar_Conexion", datos, "Conexión Guarda Exitosamente");
        $.Alert("#msg", $("#resp").val(), "success");
    });
    
    $("#btn_volver").on("click", function(){
        window.location.href='index.jsp';
    });
 
});