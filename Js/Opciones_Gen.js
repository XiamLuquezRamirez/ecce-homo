$(document).ready(function () {
    
    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    
    $("#btn_user").on("click", function(){
        window.location.href='Administracion/gestion_usuarios.jsp'; 
    });
    
    $("#btn_config_empresa").on("click", function(){
        window.location.href='Administracion/Config_Empresa.jsp'; 
    });
    
    $("#btn_volver").on("click", function(){
        window.location.href='Administracion.jsp'; 
    });
    
    $("#btn_dependencias").on("click", function(){
        window.location.href='Administracion/GestionDependencias.jsp'; 
    });
    
    $("#btn_tipoDocumento").on("click", function(){
        window.location.href='Administracion/GestionTipDoc.jsp'; 
    });
    
    $("#btn_EstadoDoc").on("click", function(){
        window.location.href='Administracion/EstadoDoc.jsp'; 
    });
    
    $("#btn_depar").on("click", function(){
        window.location.href='Administracion/GestionDepart.jsp'; 
    });
    
    $("#btn_muni").on("click", function(){
        window.location.href='Administracion/GestionMun.jsp'; 
    });
    
});