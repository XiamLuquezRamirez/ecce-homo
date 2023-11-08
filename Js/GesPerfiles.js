$(document).ready(function () {
    var mapa="";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_user").addClass("start active open");
    $("#menu_ges_perf").addClass("active");   
   

    ///////////////////////CARGAR MUNICIPIOS: 
    $.extend({
       perfiles: function () {
            var datos = {
                 opc: "CargContratos",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "PagPerfiles.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_TipDoc').html(data['cad']);
                    $('#bot_TipDoc').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                    
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqResp: function (val) {
            

               var datos = {
                    opc: "BusqDepe",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()
                
            };

            $.ajax({
                type: "POST",
                url: "PagPerfiles.php",
                data: datos,
                 dataType: 'JSON',
                success: function (data) {
                    $('#tab_TipDoc').html(data['cad']);
                    $('#bot_TipDoc').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editPerf: function (cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEdperfil",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                   $("#txt_Nomb").val(data['nomperfil']);
                    $("#idperfil").val(cod);
                
                    if (data['ggesserv'] == "s") {
                        $('#ggesserv').iCheck('check');
                    } else {
                        $('#ggesserv').iCheck('uncheck');
                    }
                    
                    $("#cbx_1").find(':checkbox').each(function () {
                     $(this).iCheck('uncheck');
                    });
                    
                    
                    if (data['gesser1'] == "s") {
                        $('#gesser1').iCheck('check');
                    } else {
                        $('#gesser1').iCheck('uncheck');
                    }
                    
                    if (data['gesser2'] == "s") {
                        $('#gesser2').iCheck('check');
                    } else {
                        $('#gesser2').iCheck('uncheck');
                    }
                    if (data['gesser3'] == "s") {
                        $('#gesser3').iCheck('check');
                    } else {
                        $('#gesser3').iCheck('uncheck');
                    }
                    if (data['gesser4'] == "s") {
                        $('#gesser4').iCheck('check');
                    } else {
                        $('#gesser4').iCheck('uncheck');
                    }
                    if (data['gesser5'] == "s") {
                        $('#gesser5').iCheck('check');
                    } else {
                        $('#gesser5').iCheck('uncheck');
                    }
                    
                    /////////
                    if (data['gesConsRetra'] == "s") {
                        $('#gesConsRetra').iCheck('check');
                    } else {
                        $('#gesConsRetra').iCheck('uncheck');
                    }
                    
                    /////////
                    if (data['gopgen'] == "s") {
                        $('#gopgen').iCheck('check');
                    } else {
                        $('#gopgen').iCheck('uncheck');
                    }
                    
                    $("#cbx_2").find(':checkbox').each(function () {
                     $(this).iCheck('uncheck');
                    });
                    
                      if (data['gopgen1'] == "s") {
                        $('#gopgen1').iCheck('check');
                    } else {
                        $('#gopgen1').iCheck('uncheck');
                    }
                      if (data['gopgen2'] == "s") {
                        $('#gopgen2').iCheck('check');
                    } else {
                        $('#gopgen2').iCheck('uncheck');
                    }
                    
                    
                    if (data['gpargen'] == "s") {
                        $('#gpargen').iCheck('check');
                    } else {
                        $('#gpargen').iCheck('uncheck');
                    }
                    
                    $("#cbx_3").find(':checkbox').each(function () {
                     $(this).iCheck('uncheck');
                    });
                                        
                    if (data['gpargen1'] == "s") {
                        $('#gpargen1').iCheck('check');
                    } else {
                        $('#gpargen1').iCheck('uncheck');
                    }
                    
                      if (data['gpargen2'] == "s") {
                        $('#gpargen2').iCheck('check');
                    } else {
                        $('#gpargen2').iCheck('uncheck');
                    }
                    
                      if (data['gpargen3'] == "s") {
                        $('#gpargen3').iCheck('check');
                    } else {
                        $('#gpargen3').iCheck('uncheck');
                    }
                    
                    if (data['gpargen4'] == "s") {
                        $('#gpargen4').iCheck('check');
                    } else {
                        $('#gpargen4').iCheck('uncheck');
                    }
                    
                    
                    if (data['gpargen5'] == "s") {
                        $('#gpargen5').iCheck('check');
                    } else {
                        $('#gpargen5').iCheck('uncheck');
                    }
                    
                      if (data['gpargen6'] == "s") {
                        $('#gpargen6').iCheck('check');
                    } else {
                        $('#gpargen6').iCheck('uncheck');
                    }
                    
                    if (data['gpargen7'] == "s") {
                        $('#gpargen7').iCheck('check');
                    } else {
                        $('#gpargen7').iCheck('uncheck');
                    }
                    
                    if (data['ggestUsu'] == "s") {
                        $('#ggestUsu').iCheck('check');
                    } else {
                        $('#ggestUsu').iCheck('uncheck');
                    }
                    
                    $("#cbx_4").find(':checkbox').each(function () {
                     $(this).iCheck('uncheck');
                    });                    
                    
                    if (data['ggestUsu1'] == "s") {
                        $('#gestUsu1').iCheck('check');
                    } else {
                        $('#gestUsu1').iCheck('uncheck');
                    }                    
                    
                      if (data['ggestUsu2'] == "s") {
                        $('#gestUsu2').iCheck('check');
                    } else {
                        $('#gestUsu2').iCheck('uncheck');
                    }
                    
                    if (data['gesAudi'] == "s") {
                        $('#gesAudi').iCheck('check');
                    } else {
                        $('#gesAudi').iCheck('uncheck');
                    }
                    
                      if (data['gesFact'] == "s") {
                        $('#gesFact').iCheck('check');
                    } else {
                        $('#gesFact').iCheck('uncheck');
                    }
                    
                    if (data['gesCons'] == "s") {
                        $('#gesCons').iCheck('check');
                    } else {
                        $('#gesCons').iCheck('uncheck');
                    }
                                        
                    if (data['gesReci'] == "s") {
                        $('#gesReci').iCheck('check');
                    } else {
                        $('#gesReci').iCheck('uncheck');
                    }
                    
                
                    $("#acc").val("2");


                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').show();
          
            
        },
        verPerf: function (cod) {
           
              var datos = {
                ope: "BusqEdperfil",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_Nomb").val(data['nomperfil']);
                    $("#idperfil").val(cod);
                
                    if (data['ggesserv'] == "s") {
                        $('#ggesserv').iCheck('check');
                    } else {
                        $('#ggesserv').iCheck('uncheck');
                    }
                    
                    $("#cbx_1").find(':checkbox').each(function () {
                     $(this).iCheck('uncheck');
                    });
                    
                    
                    if (data['gesser1'] == "s") {
                        $('#gesser1').iCheck('check');
                    } else {
                        $('#gesser1').iCheck('uncheck');
                    }
                    
                    if (data['gesser2'] == "s") {
                        $('#gesser2').iCheck('check');
                    } else {
                        $('#gesser2').iCheck('uncheck');
                    }
                    if (data['gesser3'] == "s") {
                        $('#gesser3').iCheck('check');
                    } else {
                        $('#gesser3').iCheck('uncheck');
                    }
                    if (data['gesser4'] == "s") {
                        $('#gesser4').iCheck('check');
                    } else {
                        $('#gesser4').iCheck('uncheck');
                    }
                    if (data['gesser5'] == "s") {
                        $('#gesser5').iCheck('check');
                    } else {
                        $('#gesser5').iCheck('uncheck');
                    }
                    
                    /////////
                    if (data['gesConsRetra'] == "s") {
                        $('#gesConsRetra').iCheck('check');
                    } else {
                        $('#gesConsRetra').iCheck('uncheck');
                    }
                    
                    /////////
                    if (data['gopgen'] == "s") {
                        $('#gopgen').iCheck('check');
                    } else {
                        $('#gopgen').iCheck('uncheck');
                    }
                    
                    $("#cbx_2").find(':checkbox').each(function () {
                     $(this).iCheck('uncheck');
                    });
                    
                      if (data['gopgen1'] == "s") {
                        $('#gopgen1').iCheck('check');
                    } else {
                        $('#gopgen1').iCheck('uncheck');
                    }
                      if (data['gopgen2'] == "s") {
                        $('#gopgen2').iCheck('check');
                    } else {
                        $('#gopgen2').iCheck('uncheck');
                    }
                    
                    
                    if (data['gpargen'] == "s") {
                        $('#gpargen').iCheck('check');
                    } else {
                        $('#gpargen').iCheck('uncheck');
                    }
                    
                    $("#cbx_3").find(':checkbox').each(function () {
                     $(this).iCheck('uncheck');
                    });
                                        
                    if (data['gpargen1'] == "s") {
                        $('#gpargen1').iCheck('check');
                    } else {
                        $('#gpargen1').iCheck('uncheck');
                    }
                    
                      if (data['gpargen2'] == "s") {
                        $('#gpargen2').iCheck('check');
                    } else {
                        $('#gpargen2').iCheck('uncheck');
                    }
                    
                      if (data['gpargen3'] == "s") {
                        $('#gpargen3').iCheck('check');
                    } else {
                        $('#gpargen3').iCheck('uncheck');
                    }
                    
                    if (data['gpargen4'] == "s") {
                        $('#gpargen4').iCheck('check');
                    } else {
                        $('#gpargen4').iCheck('uncheck');
                    }
                    
                    
                    if (data['gpargen5'] == "s") {
                        $('#gpargen5').iCheck('check');
                    } else {
                        $('#gpargen5').iCheck('uncheck');
                    }
                    
                      if (data['gpargen6'] == "s") {
                        $('#gpargen6').iCheck('check');
                    } else {
                        $('#gpargen6').iCheck('uncheck');
                    }
                    
                    if (data['gpargen7'] == "s") {
                        $('#gpargen7').iCheck('check');
                    } else {
                        $('#gpargen7').iCheck('uncheck');
                    }
                    
                    if (data['ggestUsu'] == "s") {
                        $('#ggestUsu').iCheck('check');
                    } else {
                        $('#ggestUsu').iCheck('uncheck');
                    }
                    
                    $("#cbx_4").find(':checkbox').each(function () {
                     $(this).iCheck('uncheck');
                    });                    
                    
                    if (data['ggestUsu1'] == "s") {
                        $('#gestUsu1').iCheck('check');
                    } else {
                        $('#gestUsu1').iCheck('uncheck');
                    }                    
                    
                      if (data['ggestUsu2'] == "s") {
                        $('#gestUsu2').iCheck('check');
                    } else {
                        $('#gestUsu2').iCheck('uncheck');
                    }
                    
                    if (data['gesAudi'] == "s") {
                        $('#gesAudi').iCheck('check');
                    } else {
                        $('#gesAudi').iCheck('uncheck');
                    }
                    
                    if (data['gesFact'] == "s") {
                        $('#gesFact').iCheck('check');
                    } else {
                        $('#gesFact').iCheck('uncheck');
                    }
                    
                    if (data['gesCons'] == "s") {
                        $('#gesCons').iCheck('check');
                    } else {
                        $('#gesCons').iCheck('uncheck');
                    }
                                        
                    if (data['gesReci'] == "s") {
                        $('#gesReci').iCheck('check');
                    } else {
                        $('#gesReci').iCheck('uncheck');
                    }
                    
                
                    $("#acc").val("2");


                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
          $("#responsive").modal();
          $('#mopc').hide(); 
            
        },
        deletPerf: function (cod) {
           $("#acc").val("3");
            
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: $("#acc").val(),
                    cod: cod
                }

                $.ajax({
                    type: "POST",
                    url: "GuardarProy.php",
                    data: datos,
                    success: function (data) {
                        if (trimAll(data) == "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.proy();
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
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()
                };

                $.ajax({
                    type: "POST",
                    url: "PagPerfiles.php",
                    data: datos,
                     dataType: 'JSON',
                success: function (data) {
                    $('#tab_TipDoc').html(data['cad']);
                    $('#bot_TipDoc').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            
        },
        combopag: function (pag,servel) {
          
           var datos = {
                     pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()
            };

                $.ajax({
                    type: "POST",
                    url: "PagPerfiles.php",
                    data: datos,
                   dataType: 'JSON',
                success: function (data) {
                    $('#tab_TipDoc').html(data['cad']);
                    $('#bot_TipDoc').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            
        },
         combopag2: function (nre) {

            var datos = {
                nreg: nre,
                bus: $("#busq_centro").val(),
                pag: $("#selectpag").val()
                

            }

            $.ajax({
                type: "POST",
                url: "PagContancias.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_TipDoc').html(data['cad']);
                    $('#bot_TipDoc').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

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
           cargaResp: function () {
           
              
            var datos = {
            Opcion: "cargaResp"
        }

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                
                  $('#CbRespon').show(100).html(data);  
                
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
      
            
        },
        cargaCola: function () {
           
              
            var datos = {
            Opcion: "cargaCola"
        }

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                
                  $('#CbCola').show(100).html(data);  
                
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
      
            
        },
        cargaMun: function () {
           
              
            var datos = {
            Opcion: "cargaMun"
        }

        $.ajax({
            type: "POST",
            url: "../All.php",
            data: datos,
            success: function (data) {
                
                  $('#CbMun').show(100).html(data);  
                
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
      
            
        }
        
        
    });
    //======FUNCIONES========\\
  
  
    $("#ggesserv").on('ifChecked ifUnchecked', function (event) {

        if (event.type == 'ifChecked') {
            $("#cbx_1").find(':checkbox').each(function () {
                $(this).iCheck('check');
            });
        } else {
            $("#cbx_1").find(':checkbox').each(function () {
                $(this).iCheck('uncheck');
            });
        }

    });

    $("#gopgen").on('ifChecked ifUnchecked', function (event) {

        if (event.type == 'ifChecked') {
            $("#cbx_2").find(':checkbox').each(function () {
                $(this).iCheck('check');
            });
        } else {
            $("#cbx_2").find(':checkbox').each(function () {
                $(this).iCheck('uncheck');
            });
        }
    });
    
    $("#gpargen").on('ifChecked ifUnchecked', function (event) {

        if (event.type == 'ifChecked') {
            $("#cbx_3").find(':checkbox').each(function () {
                $(this).iCheck('check');
            });
        } else {
            $("#cbx_3").find(':checkbox').each(function () {
                $(this).iCheck('uncheck');
            });
        }
    });

    $("#ggestUsu").on('ifChecked ifUnchecked', function (event) {

        if (event.type == 'ifChecked') {
            $("#cbx_4").find(':checkbox').each(function () {
                $(this).iCheck('check');
            });
        } else {
            $("#cbx_4").find(':checkbox').each(function () {
                $(this).iCheck('uncheck');
            });
        }
    });

    $("#btn_nuevo1").on("click", function () {
        $('#acc').val("1");

        $("#txt_Nomb").val("");

        $("#cbx_1").find(':checkbox').each(function () {
            $(this).iCheck('uncheck');
        });
        $("#cbx_2").find(':checkbox').each(function () {
            $(this).iCheck('uncheck');
        });
        $("#cbx_3").find(':checkbox').each(function () {
            $(this).iCheck('uncheck');
        });
        $("#cbx_4").find(':checkbox').each(function () {
            $(this).iCheck('uncheck');
        });
        $('#ggesserv').iCheck('uncheck');
        $('#gopgen').iCheck('uncheck');
        $('#gpargen').iCheck('uncheck');
        $('#ggestUsu').iCheck('uncheck');
     
     
        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);



        $("#responsive").modal();
        $('#mopc').show();
    });
    
    $("#btn_nuevo2").on("click", function(){
      $('#acc').val("1");
        
        $("#txt_Nomb").val("");

        $("#cbx_1").find(':checkbox').each(function () {
            $(this).iCheck('uncheck');
        });
        $("#cbx_2").find(':checkbox').each(function () {
            $(this).iCheck('uncheck');
        });
        $("#cbx_3").find(':checkbox').each(function () {
            $(this).iCheck('uncheck');
        });
        $("#cbx_4").find(':checkbox').each(function () {
            $(this).iCheck('uncheck');
        });
        $('#ggesserv').iCheck('uncheck');
        $('#gopgen').iCheck('uncheck');
        $('#gpargen').iCheck('uncheck');
        $('#ggestUsu').iCheck('uncheck');
     
     
        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);
       
        
    });
   

    //BOTON GUARDAR-
     $("#btn_guardar").on("click", function () {


        if ($('#txt_Nomb').val() == "") {
            alert("Ingrese el Nombre");
            $('#txt_Nomb').focus();
            return;
        }


        ggesserv = "n";
        if ($('#ggesserv').prop('checked')) {
            ggesserv = "s";
        }

        gesser1 = "n";
        if ($('#gesser1').prop('checked')) {
            gesser1 = "s";
        }
        gesser2 = "n";
        if ($('#gesser2').prop('checked')) {
            gesser2 = "s";
        }
        gesser3 = "n";
        if ($('#gesser3').prop('checked')) {
            gesser3 = "s";
        }
        gesser4 = "n";
        if ($('#gesser4').prop('checked')) {
            gesser4 = "s";
        }
        gesser5 = "n";
        if ($('#gesser5').prop('checked')) {
            gesser5 = "s";
        }        
        gesser6 = "n";
        if ($('#gesser6').prop('checked')) {
            gesser6 = "s";
        }        
        gesser7 = "n";
        if ($('#gesser7').prop('checked')) {
            gesser7 = "s";
        }        
        gesser8 = "n";
        if ($('#gesser8').prop('checked')) {
            gesser8 = "s";
        }        
        gesser9 = "n";
        if ($('#gesser9').prop('checked')) {
            gesser9 = "s";
        }        
        gesConsRetra = "n";
        if ($('#gesConsRetra').prop('checked')) {
            gesConsRetra = "s";
        }        
        gesConsPago = "n";
        if ($('#gesConsPago').prop('checked')) {
            gesConsPago = "s";
        }        
        gopgen = "n";
        if ($('#gopgen').prop('checked')) {
            gopgen = "s";
        }
        gopgen1 = "n";
        if ($('#gopgen1').prop('checked')) {
            gopgen1 = "s";
        }
        gopgen2 = "n";
        if ($('#gopgen2').prop('checked')) {
            gopgen2 = "s";
        }        
        gpargen = "n";
        if ($('#gpargen').prop('checked')) {
            gpargen = "s";
        }
        gpargen1 = "n";
        if ($('#gpargen1').prop('checked')) {
            gpargen1 = "s";
        }
        gpargen2 = "n";
        if ($('#gpargen2').prop('checked')) {
            gpargen2 = "s";
        }
        gpargen3 = "n";
        if ($('#gpargen3').prop('checked')) {
            gpargen3 = "s";
        }
        gpargen4 = "n";
        if ($('#gpargen4').prop('checked')) {
            gpargen4 = "s";
        }
        gpargen5 = "n";
        if ($('#gpargen5').prop('checked')) {
            gpargen5 = "s";
        }
        gpargen6 = "n";
        if ($('#gpargen6').prop('checked')) {
            gpargen6 = "s";
        }
        gpargen7 = "n";
        if ($('#gpargen7').prop('checked')) {
            gpargen7 = "s";
        }    
        ggestUsu = "n";
        if ($('#ggestUsu').prop('checked')) {
            ggestUsu = "s";
        }
        gestUsu1 = "n";
        if ($('#gestUsu1').prop('checked')) {
            gestUsu1 = "s";
        }
        gestUsu2 = "n";
        if ($('#gestUsu2').prop('checked')) {
            gestUsu2 = "s";
        } 
        
        gesAudi = "n";
        if ($('#gesAudi').prop('checked')) {
            gesAudi = "s";
        }     
        gesFact = "n";
        if ($('#gesFact').prop('checked')) {
            gesFact = "s";
        }     
        gesCons = "n";
        if ($('#gesCons').prop('checked')) {
            gesCons = "s";
        }     
        gesReci = "n";
        if ($('#gesReci').prop('checked')) {
            gesReci = "s";
        }     
      
        var datos = {
            txt_Nomb: $("#txt_Nomb").val(),
            ggesserv: ggesserv,
            gesser1: gesser1,
            gesser2: gesser2,
            gesser3: gesser3,
            gesser4: gesser4,
            gesser5: gesser5,
            gesser6: gesser6,
            gesser7: gesser7,
            gesser8: gesser8,
            gesser9: gesser9,
            gesConsRetra: gesConsRetra,
            gesConsPago: gesConsPago,
            gopgen: gopgen,
            gopgen1: gopgen1,
            gopgen2: gopgen2,            
            gpargen: gpargen,
            gpargen1: gpargen1,
            gpargen2: gpargen2,
            gpargen3: gpargen3,
            gpargen4: gpargen4,
            gpargen5: gpargen5,
            gpargen6: gpargen6,
            gpargen7: gpargen7,
            ggestUsu: ggestUsu,
            gestUsu1: gestUsu1,
            gestUsu2: gestUsu2,
            gesAudi: gesAudi,
            gesFact: gesFact,
            gesCons: gesCons,
            gesReci: gesReci,
            acc: $("#acc").val(),
            id: $("#idperfil").val()
        };

        $.ajax({
            type: "POST",
            url: "GuardarPerfil.php",
            data: datos,
            success: function (data) {
                if (trimAll(data) == "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.perfiles();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);
                    $("#txt_Nomb").prop('disabled', true);

                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });
 

    
    });
    ///////////////////////
