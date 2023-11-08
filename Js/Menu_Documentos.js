$(document).ready(function () {
    $("#home").removeClass("start active open");
    $("#menu_doc").addClass("start active open");
    
    $("#btn_save_doc").on("click", function(){
        window.location.href='Formu_Save_Doc'; 
    });
    
    $("#btn_consul_doc").on("click", function(){
        window.location.href='Formu_Consultar_Doc'; 
    });
    
    $("#btn_del_doc").on("click", function(){
        window.location.href='Formu_Delete_Doc'; 
    });
    
    $("#btn_volver").on("click", function(){
        window.location.href='Administracion.jsp';
    });
    
});