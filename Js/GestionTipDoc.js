$(document).ready(function () {
    var mapa="";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_tipdoc").addClass("active");
    
   

    ///////////////////////CARGAR MUNICIPIOS: 
    $.extend({
        tipdoc: function () {
            var datos = {
                opc: "CargCent",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n"
            }

            $.ajax({
                type: "POST",
                url: "../PagTipDoc",
                data: datos,
                success: function (data) {
                    pdat = data.split("//");

                    $('#tab_TipDoc').show(100).html(pdat[0]);
                    $('#bot_TipDoc').show(100).html(pdat[1]);
                    
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqTipDoc: function (val) {
            

            var datos = {
                opc: "BusqTipDoc",
                bus: val,
                pag:"1",
                op:"1"
                
            }

            $.ajax({
                type: "POST",
                url: "../PagTipDoc",
                data: datos,
                success: function (data) {
                          pdat = data.split("//");

                   $('#tab_TipDoc').show(100).html(pdat[0]);
                    $('#bot_TipDoc').show(100).html(pdat[1]);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editTipDoc: function (cod) {
            $('#acc').val("2");
              $("#btn_nuevo2").prop('disabled', true);
                    $("#btn_guardar").prop('disabled', false);
               var datos = {
                ope: "BusqEditTipDoc",
                cod: cod                
            }

            $.ajax({
                type: "POST",
                url: "../All",
                data: datos,
                success: function (data) {
                          pdat = data.split("//");

                    $('#txt_Cod').val(pdat[0]);
                    $('#txt_Desc').val(pdat[1]);
                    $('#txt_obser').val(pdat[2]);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
          $("#responsive").modal();
          $('#mopc').show(); 
          
            
        },
         verTipDoc: function (cod) {
           
               var datos = {
                ope: "BusqEditTipDoc",
                cod: cod                
            }

            $.ajax({
                type: "POST",
                url: "../All",
                data: datos,
                success: function (data) {
                          pdat = data.split("//");

                    $('#txt_Cod').val(pdat[0]);
                    $('#txt_Desc').val(pdat[1]);
                    $('#txt_obser').val(pdat[2]);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
          $("#responsive").modal();
          $('#mopc').hide(); 
            
        },
        deletTipDoc: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    ope: "delecTipDoc",
                    cod: cod
                }

                $.ajax({
                    type: "POST",
                    url: "../All",
                    data: datos,
                    success: function (data) {
                        if (data == 1) {
                            alert("Operacion Realizada Exitosamente");
                            $.tipdoc();
                        }
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        paginador: function (pag,servel) {
         
           var datos = {
                    pag: pag,
                    bus: $("#busq_centro").val()
                }

                $.ajax({
                    type: "POST",
                    url: "../PagTipDoc",
                    data: datos,
                    success: function (data) {
                                pdat = data.split("//");

                $('#tab_TipDoc').show(100).html(pdat[0]);
                    $('#bot_TipDoc').show(100).html(pdat[1]);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            
        },
        combopag: function (pag,servel) {
          
           var datos = {
                    pag: pag,
                    bus: $("#busq_centro").val()
                    
                }

                $.ajax({
                    type: "POST",
                    url: "../PagTipDoc",
                    data: datos,
                    success: function (data) {
                             pdat = data.split("//");

                      $('#tab_TipDoc').show(100).html(pdat[0]);
                    $('#bot_TipDoc').show(100).html(pdat[1]);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            
        }
        
    });
    //======FUNCIONES========\\
  
    $("#btn_nuevo1").on("click", function(){
      $('#acc').val("1");
        $("#responsive").modal();
        $('#mopc').show(); 
       
        
    });
    
    
      $("#txt_Cod").on("change", function(){
         
               var datos = {
            ope: "verfTipDoc",
            cod: $("#txt_Cod").val()
        }

        $.ajax({
            type: "POST",
            url: "../All",
            data: datos,
            success: function (data) {
                if (data == 1) {
                    alert("Este Codigo ya ha sido Registrado");
                    $('#txt_Cod').focus();
                    $("#txt_Cod").val("");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
         
      });
  
    $("#btn_nuevo2").on("click", function(){
      $('#acc').val("1");
        
                    $("#txt_Cod").val("");
                    $("#txt_Desc").val("");
                    $("#txt_obser").val("");
                    $("#btn_nuevo2").prop('disabled', true);
                    $("#btn_guardar").prop('disabled', false);
                    
                    $("#txt_Cod").prop('disabled', false);
                    $("#txt_Desc").prop('disabled', false);
                    $("#txt_obser").prop('disabled', false);
       
        
    });
   
    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function(){
      
        
        if ($('#txt_Cod').val() == "") {
            alert("Ingrese el Código del Tipo de Documento");
            $('#txt_Cod').focus();
            return;
        }

        if ($('#txt_Desc').val() == "") {
            alert("Ingrese el Nombre del Tipo de Documento");
            $('#txt_Desc').focus();
            return;
        }

        var datos = {
            opc: "verMun",
            cod: $("#txt_Cod").val(),
            des: $("#txt_Desc").val(),
            obs: $("#txt_obser").val(),
            acc: $("#acc").val()
        }

        $.ajax({
            type: "POST",
            url: "../GuardarTipDoc",
            data: datos,
            success: function (data) {
                if (trimAll(data) == "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.tipdoc();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);
                    $("#txt_Cod").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', true);
                    $("#txt_obser").prop('disabled', true);

                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
       
        
    });
 

    
    });
    ///////////////////////
