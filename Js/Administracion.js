$(document).ready(function () {
    
    $("#btn_Noti").on("click", function(){
        window.location.href='GesNoticias.php'; 
    });
    
    $("#btn_Gal").on("click", function(){
        window.location.href='GesGalerias.php'; 
    });
    
    $("#btn_Serv").on("click", function(){
        window.location.href='AdminServicios.php'; 
    });
    $("#btn_Para_Gen").on("click", function(){
        window.location.href='AdminParametros.php'; 
    });
    
    $("#btn_usu").on("click", function(){
        window.location.href='GestionUsuario.php'; 
    });
    
    $("#btn_Audi").on("click", function(){
        window.location.href='GestionAuditoria.php'; 
    });
    
});