$(document).ready(function () {
    var mapa="";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_dpto").addClass("active");
   

    ///////////////////////CARGAR MUNICIPIOS: 
    $.extend({
        depar: function () {
            var datos = {
                opc: "CargDepartamento",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n"
            }

            $.ajax({
                type: "POST",
                url: "PagDepart.php",
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
        busqDepen: function (val) {
            

            var datos = {
                opc: "BusqDepart",
                bus: val,
                pag:"1",
                op:"1"
                
            }

            $.ajax({
                type: "POST",
                url: "PagDepart.php",
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
        editDepart: function (cod) {
            $('#acc').val("2");
              $("#btn_nuevo2").prop('disabled', true);
                    $("#btn_guardar").prop('disabled', false);
               var datos = {
                Opcion: "BusqEditDepart",
                cod: cod                
            }

            $.ajax({
                type: "POST",
                url: "../All.php",
                data: datos,
                  dataType: 'JSON',
                success: function (data) {
                    $("#txt_Cod").val(data['cod_depart']);
                    $("#txt_Desc").val(data['nom_depart']);
                    $("#txt_obser").val(data['observ_depart']);
                    
                      $("#acc").val("2");
                      
                    $("#txt_Cod").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', false);
                    $("#txt_obser").prop('disabled', false);
                 
                },
                error: function (error_messages) {
                    //alert('HA OCURRIDO UN ERROR');
                }
            });
          $("#responsive").modal();
          $('#mopc').show(); 
          
            
        },
         verDepart: function (cod) {
           
               var datos = {
                Opcion: "BusqEditDepart",
                cod: cod                
            }

            $.ajax({
                type: "POST",
                url: "../All",
                data: datos,
                 dataType: 'JSON',
                success: function (data) {
                    $("#txt_Cod").val(data['cod_depart']);
                    $("#txt_Desc").val(data['nom_depart']);
                    $("#txt_obser").val(data['observ_depart']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
          $("#responsive").modal();
          $('#mopc').hide(); 
            
        },
        deletDepart: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    ope: "delecDepart",
                    cod: cod
                }

                $.ajax({
                    type: "POST",
                    url: "../All",
                    data: datos,
                    success: function (data) {
                        if (data == 1) {
                            alert("Operacion Realizada Exitosamente");
                            $.depar();
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
                    url: "PagDepart.php",
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
                    url: "PagDepart.php",
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
      
       $("#txt_Cod").val("");
                    $("#txt_Desc").val("");
                    $("#txt_obser").val("");
                    
                    $("#btn_nuevo2").prop('disabled', true);
                    $("#btn_guardar").prop('disabled', false);
                    
                    $("#txt_Cod").prop('disabled', false);
                    $("#txt_Desc").prop('disabled', false);
                    $("#txt_obser").prop('disabled', false);
        $("#responsive").modal();
        $('#mopc').show(); 
       
        
    });
    
    
      $("#txt_Cod").on("change", function(){
         
               var datos = {
            ope: "verfDepata",
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
            alert("Ingrese el Código del Departamento");
            $('#txt_Cod').focus();
            return;
        }

        if ($('#txt_Desc').val() == "") {
            alert("Ingrese el Nombre del Departamento");
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
            url: "GuardarDepart.php",
            data: datos,
            success: function (data) {
                if (trimAll(data) == "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.depar();
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
