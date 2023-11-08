$(document).ready(function () {
    var mapa="";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_estdoc").addClass("active");
    
   

    ///////////////////////CARGAR MUNICIPIOS: 
    $.extend({
        EstDoc: function () {
            var datos = {
                opc: "CargEstaDoc",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n"
            }

            $.ajax({
                type: "POST",
                url: "../PagEstaDoc",
                data: datos,
                success: function (data) {
                    pdat = data.split("//");

                    $('#tab_EstDoc').show(100).html(pdat[0]);
                    $('#bot_EstDoc').show(100).html(pdat[1]);
                    
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqEstDoc: function (val) {
            

            var datos = {
                opc: "BusqDepe",
                bus: val,
                pag:"1",
                op:"1"
                
            }

            $.ajax({
                type: "POST",
                url: "../PagEstaDoc",
                data: datos,
                success: function (data) {
                          pdat = data.split("//");

                   $('#tab_EstDoc').show(100).html(pdat[0]);
                    $('#bot_EstDoc').show(100).html(pdat[1]);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editEstDoc: function (cod) {
            $('#acc').val("2");
              $("#btn_nuevo2").prop('disabled', true);
                    $("#btn_guardar").prop('disabled', false);
               var datos = {
                ope: "BusqEditEstDoc",
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
                    $('#divest').show(100).html(pdat[2]);
                    $('#txt_obser').val(pdat[3]);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
          $("#responsive").modal();
          $('#mopc').show(); 
          
            
        },
         verEstDoc: function (cod) {
           
               var datos = {
                ope: "BusqEditEstDoc",
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
                    $('#divest').show(100).html(pdat[2]);
                    $('#txt_obser').val(pdat[3]);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
          $("#responsive").modal();
          $('#mopc').hide(); 
            
        },
        deletEstDoc: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    ope: "delecEstDoc",
                    cod: cod
                }

                $.ajax({
                    type: "POST",
                    url: "../All",
                    data: datos,
                    success: function (data) {
                        if (data == 1) {
                            alert("Operacion Realizada Exitosamente");
                            $.EstDoc();
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
                    url: "../PagEstaDoc",
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
                    url: "../PagEstaDoc",
                    data: datos,
                    success: function (data) {
                             pdat = data.split("//");

                      $('#tab_EstDoc').show(100).html(pdat[0]);
                    $('#bot_EstDoc').show(100).html(pdat[1]);
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
            ope: "verfEstDoc",
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
            alert("Ingrese el Código del Estado del documento");
            $('#txt_Cod').focus();
            return;
        }

        if ($('#txt_Desc').val() == "") {
            alert("Ingrese el Nombre del Estado del documento");
            $('#txt_Desc').focus();
            return;
        }

        var datos = {
            opc: "verMun",
            cod: $("#txt_Cod").val(),
            des: $("#txt_Desc").val(),
            obs: $("#txt_obser").val(),
            est: $('input:radio[name=est]:checked').val(),
            acc: $("#acc").val()
        }

        $.ajax({
            type: "POST",
            url: "../GuardarEstDoc",
            data: datos,
            success: function (data) {
                if (trimAll(data) == "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.EstDoc();
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
