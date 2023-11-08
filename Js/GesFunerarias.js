$(document).ready(function() {
    var mapa = "";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_fune").addClass("active");


    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        fune: function() {
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
                url: "PagFunera.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_TipDoc').show(100).html(data['cad']);
                    $('#bot_TipDoc').show(100).html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqFunera: function(val) {


            var datos = {
                opc: "BusqDepart",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            }

            $.ajax({
                type: "POST",
                url: "PagFunera.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_TipDoc').show(100).html(data['cad']);
                    $('#bot_TipDoc').show(100).html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        editFune: function(cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);

            var datos = {
                ope: "BusqEditFuner",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {

                    $("#text_id").val(cod);
                    $("#txt_Cod").val(data['cod_fune']);
                    $("#txt_Desc").val(data['nom_fune']);
                    $("#txt_nit").val(data['nit']);
                    $("#txt_dir").val(data['dir']);
                    $("#txt_tel").val(data['tel']);
                    $("#txt_obser").val(data['obser_fune']);

                    $("#acc").val("2");

                    $("#txt_Cod").prop('disabled', false);
                    $("#txt_Desc").prop('disabled', false);
                    $("#txt_obser").prop('disabled', false);
                },

                error: function(error_messages) {
                    //alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').show();


        },
        VerFune: function(cod) {

            var datos = {
                ope: "BusqEditFuner",
                cod: cod
            }

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#text_id").val(cod);
                    $("#txt_Cod").val(data['cod_fune']);
                    $("#txt_Desc").val(data['nom_fune']);
                    $("#txt_nit").val(data['nit']);
                    $("#txt_dir").val(data['dir']);
                    $("#txt_tel").val(data['tel']);
                    $("#txt_obser").val(data['obser_fune']);

                    $("#acc").val("2");

                    $("#txt_Cod").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', false);
                    $("#txt_obser").prop('disabled', false);

                },
                error: function(error_messages) {
                    //  alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').hide();

        },
        deletFune: function(cod) {

            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "GuardarFuneraria.php",
                    data: datos,
                    success: function(data) {
                        if (data === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.fune();
                        } else {
                            alert("Esta Funeraria esta relacionada a un Contrato. No se puede Eliminar. ");
                        }
                    },
                    error: function(error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        paginador: function(pag, servel) {
            regus = "n";
            if ($('#reusu').prop('checked')) {
                regus = "s";
            }
            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "PagFunera.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                  
                    $('#tab_TipDoc').show(100).html(data['cad']);
                    $('#bot_TipDoc').show(100).html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        combopag: function(pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()

            }

            $.ajax({
                type: "POST",
                url: "PagFunera.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_TipDoc').show(100).html(data['cad']);
                    $('#bot_TipDoc').show(100).html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        combopag2: function(nre) {

            var datos = {
                nreg: nre,
                bus: $("#busq_centro").val(),
                pag: $("#selectpag").val()

            };

            $.ajax({
                type: "POST",
                url: "PagFunera.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_TipDoc').html(data['cad']);
                    $('#bot_TipDoc').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        }

    });
    //======FUNCIONES========\\

    $.fune();

    $("#btn_nuevo1").on("click", function() {
        $('#acc').val("1");

        $("#txt_Cod").val("");
        $("#txt_Desc").val("");
        $("#txt_nit").val("");
        $("#txt_dir").val("");
        $("#txt_tel").val("");
        $("#txt_obser").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_nit").prop('disabled', false);
        $("#txt_dir").prop('disabled', false);
        $("#txt_tel").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);
        $("#responsive").modal();
        $('#mopc').show();


    });


    $("#txt_Cod").on("change", function() {

        var datos = {
            ope: "verfFune",
            cod: $("#txt_Cod").val()
        }

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            success: function(data) {
                if (data == 1) {
                    alert("Este Codigo ya ha sido Registrado");
                    $('#txt_Cod').focus();
                    $("#txt_Cod").val("");
                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#btn_nuevo2").on("click", function() {
        $('#acc').val("1");

        $("#txt_Cod").val("");
        $("#txt_Desc").val("");
        $("#txt_nit").val("");
        $("#txt_dir").val("");
        $("#txt_tel").val("");
        $("#txt_obser").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_nit").prop('disabled', false);
        $("#txt_dir").prop('disabled', false);
        $("#txt_tel").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);


    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function() {


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
            nit: $("#txt_nit").val(),
            dir: $("#txt_dir").val(),
            tel: $("#txt_tel").val(),
            obs: $("#txt_obser").val(),
            id: $("#text_id").val(),
            acc: $("#acc").val()
        }

        $.ajax({
            type: "POST",
            url: "GuardarFuneraria.php",
            data: datos,
            success: function(data) {
                if (data === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.fune();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_Cod").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', true);
                    $("#txt_nit").prop('disabled', true);
                    $("#txt_dir").prop('disabled', true);
                    $("#txt_tel").prop('disabled', true);
                    $("#txt_obser").prop('disabled', true);

                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });



});
///////////////////////
