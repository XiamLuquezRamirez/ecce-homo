$(document).ready(function () {
    
    $("#btn_requi").on("click", function(){
        window.location.href='GesRequisicion.php'; 
    });
    
    $("#btn_Arriendo").on("click", function(){
        window.location.href='GesContratoArriendo.php'; 
    });
    
    $("#btn_Venta").on("click", function(){
        window.location.href='GesContratoVenta.php'; 
    });
    
    $("#btn_Previ").on("click", function(){
        window.location.href='GesContratoPrevi.php'; 
    });
    
    $("#btn_Consig").on("click", function(){
        window.location.href='GesCostanciasConsig.php'; 
    });
    
    $("#btn_Recibos").on("click", function(){
        window.location.href='GesRecibos.php'; 
    });
    
    
    
    
});