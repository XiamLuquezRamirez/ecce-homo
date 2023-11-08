$(document).ready(function () {
    var mapa="";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_muni").addClass("active");   
   

    ///////////////////////CARGAR MUNICIPIOS: 
    $.extend({
        muni: function () {
            var datos = {
                opc: "CargMunicipios",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n"
            }

            $.ajax({
                type: "POST",
                url: "PagMuni.php",
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
        busqMun: function (val) {
            

            var datos = {
                opc: "BusqMun",
                bus: val,
                pag:"1",
                op:"1"               
            }

            $.ajax({
                type: "POST",
                url: "PagMuni.php",
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
        editMun: function (cod) {
            $('#acc').val("2");
              $("#btn_nuevo2").prop('disabled', true);
                    $("#btn_guardar").prop('disabled', false);
               var datos = {
                Opcion: "BusqEditMun",
                cod: cod                
            }

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                    dataType: 'JSON',
                   success: function (data) {
                       $("#txt_Cod").val(data['id']);
                       $("#txt_Desc").val(data['opcion']);
                        $("#CbDepa").select2("val", data['relacion']);
                       $("#txt_obser").val(data['observ_mun']);                                    },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
          $("#responsive").modal();
          $('#mopc').show(); 
          
            
        },
         verMun: function (cod) {
           
               var datos = {
                Opcion: "BusqEditMun",
                cod: cod                
            }

            $.ajax({
                type: "POST",
                url: "../All",
                data: datos,
                 dataType: 'JSON',
                   success: function (data) {
                       $("#txt_Cod").val(data['id']);
                       $("#txt_Desc").val(data['opcion']);
                        $("#CbDepa").select2("val", data['relacion']);
                       $("#txt_obser").val(data['observ_mun']); 
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
          $("#responsive").modal();
          $('#mopc').hide(); 
            
        },
         cargaDep: function () {
           
              
            var datos = {
            Opcion: "cargDepar"
        }

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                
                  $('#CbDepa').show(100).html(data);  
                
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
      
            
        },
        deletMun: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                }

                $.ajax({
                    type: "POST",
                    url: "GuardarMun.php",
                    data: datos,
                    success: function (data) {
                        if (data == "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.muni();
                        }
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        paginador: function (pag,servel) {
          regus = "n";
            if ($('#reusu').prop('checked')) {
                regus = "s";
            }
           var datos = {
                    pag: pag,
                    bus: $("#busq_centro").val(),
                    rus: regus
                }

                $.ajax({
                    type: "POST",
                    url: "PagMuni.php",
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
                    url: "PagMuni.php",
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
        
   $("#CbDepa").select2("val","");
      $('#acc').val("1");
            $("#txt_Cod").val("");
                    $("#txt_Desc").val("");
                    $("#txt_obser").val("");
                    $("#btn_nuevo2").prop('disabled', true);
                    $("#btn_guardar").prop('disabled', false);
                    
                    $("#txt_Cod").prop('disabled', false);
                    $("#txt_Desc").prop('disabled', false);
                    $("#txt_obser").prop('disabled', false);
        $.cargaDep();            
        
        $("#responsive").modal();
        $('#mopc').show(); 
        
        
       
        
    });
    
    
      $("#txt_Cod").on("change", function(){
         
               var datos = {
            Opcion: "verfMun",
            cod: $("#txt_Cod").val()
        }

        $.ajax({
            type: "POST",
            url: "../All.php",
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
   $("#CbDepa").select2("val","");
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
   
      $.cargaDep();
   
    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function(){
      
        
        if ($('#txt_Cod').val() == "") {
            alert("Ingrese el Código del Municipio");
            $('#txt_Cod').focus();
            return;
        }

        if ($('#txt_Desc').val() == "") {
            alert("Ingrese el Nombre del Municipio");
            $('#txt_Desc').focus();
            return;
        }
        if ($('#cbx_depart').val() == "") {
            alert("Seleccione el Departamento");
            $('#cbx_depart').focus();
            return;
        }
        
        var datos = {
            opc: "verMun",
            cod: $("#txt_Cod").val(),
            des: $("#txt_Desc").val(),
            dep: $("#CbDepa").val(),
            obs: $("#txt_obser").val(),
            acc: $("#acc").val()
        }

        $.ajax({
            type: "POST",
            url: "GuardarMun.php",
            data: datos,
            success: function (data) {
                if (trimAll(data) == "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.muni();
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
