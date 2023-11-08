$(document).ready(function () {
    var mapa="";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_ceme").addClass("active");


    ///////////////////////CARGAR MUNICIPIOS: 
    $.extend({
        ceme: function () {
            var datos = {
                opc: "CargDepartamento",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            }

             $.ajax({
                type: "POST",
                url: "PagCementerio.php",
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
        busqCemen: function (val) {


            var datos = {
                opc: "BusqDepart",
                bus: val,
                pag:"1",
                op:"1",
                nreg: $("#nreg").val()

            }

            $.ajax({
                type: "POST",
                url: "PagCementerio.php",
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
        editCeme: function (cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEditCeme",
                cod: cod
            };

              $.ajax({
                type: "POST",
                url: "all.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                  $("#text_id").val(cod);
                    $("#txt_Cod").val(data['cod_cem']);
                    $("#txt_Desc").val(data['nom_cem']);
                    $("#txt_obser").val(data['obser_cem']);

                    $("#acc").val("2");

                    $("#txt_Cod").prop('disabled', false);
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
         VerCeme: function (cod) {

              var datos = {
                ope: "BusqEditFuner",
                cod: cod
            }

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#text_id").val(cod);
                    $("#txt_Cod").val(data['cod_cem']);
                    $("#txt_Desc").val(data['nom_cem']);
                    $("#txt_obser").val(data['obser_cem']);

                    $("#acc").val("2");

                    $("#txt_Cod").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', false);
                    $("#txt_obser").prop('disabled', false);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
          $("#responsive").modal();
          $('#mopc').hide(); 

        },
        deletCeme: function (cod) {

            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "GuardarCementerios.php",
                    data: datos,
                    success: function (data) {
                        if (data === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.ceme();
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
                    url: "PagCementerio.php",
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
                    url: "PagCementerio.php",
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

            };

            $.ajax({
                type: "POST",
               url: "PagCementerio.php",
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

        }

    });
    //======FUNCIONES========\\

    $.ceme();

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
            ope: "verfCeme",
            cod: $("#txt_Cod").val()
        }

        $.ajax({
            type: "POST",
            url: "All.php",
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

    $("#btn_nuevo2").on("click", function () {
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
            alert("Ingrese el Código de la Funeraria");
            $('#txt_Cod').focus();
            return;
        }

        if ($('#txt_Desc').val() === "") {
            alert("Ingrese el Nombre de la Funeraria");
            $('#txt_Desc').focus();
            return;
        }

        var datos = {
            cod: $("#txt_Cod").val(),
            des: $("#txt_Desc").val(),
            obs: $("#txt_obser").val(),
            id: $("#text_id").val(),
            acc: $("#acc").val()
        }

        $.ajax({
            type: "POST",
            url: "GuardarCementerios.php",
            data: datos,
            success: function (data) {
                if (data === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.ceme();
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
