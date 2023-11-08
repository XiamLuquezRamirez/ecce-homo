$(document).ready(function () {
    
    $("#btn_DatEmpre").on("click", function(){
        window.location.href='Gestionar_Config_Empresa.php'; 
    });
    
    $("#btn_Age_Cli").on("click", function(){
        window.location.href='GesClientes.php'; 
    });
    
    $("#btn_Funera").on("click", function(){
        window.location.href='GesFunerarias.php'; 
    });
    
    $("#btn_Necesi").on("click", function(){
        window.location.href='GesServicios.php'; 
    });
    
    $("#btn_Cementerio").on("click", function(){
        window.location.href='GesCementerios.php'; 
    });
    
    $("#btn_Iglesias").on("click", function(){
        window.location.href='GesIglesias.php'; 
    });
    
    $("#btn_Consec").on("click", function(){
        window.location.href='GestionConse.php'; 
    });
    
    
});