$(document).ready(function() {

    // $("#txt_FecNac").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_cli").addClass("active");

    $("#txt_FecNac").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });
    $("#CbSexo").selectpicker();


    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        cli: function() {
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
                url: "PagClientes.php",
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
        busqClie: function(val) {


            var datos = {
                opc: "BusqDepart",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            }

            $.ajax({
                type: "POST",
                url: "PagClientes.php",
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
        editCli: function(cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEditCli",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#text_id").val(cod);
                    $("#txt_Cod").val(data['inde_cli']);
                    $("#txt_Desc").val(data['nom_cli']);
                    $("#CbSexo").selectpicker("val", data['sex_cli']);
                    $("#txt_FecNac").val(data['fec_cli']);
                    $("#txt_Dir").val(data['dir_cli']);
                    $("#txt_email").val(data['email_cli']);
                    $("#txt_Tel").val(data['tel_cli']);
                    $("#txt_obser").val(data['obs_cli']);


                    $("#txt_Cod").prop('disabled', false);
                    $("#txt_Desc").prop('disabled', false);
                    $("#CbSexo").prop('disabled', false);
                    $("#txt_FecNac").prop('disabled', false);
                    $("#txt_Dir").prop('disabled', false);
                    $("#txt_Tel").prop('disabled', false);
                    $("#txt_obser").prop('disabled', false);
                },

                error: function(error_messages) {
                    //alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').show();


        },
        VerCli: function(cod) {

            var datos = {
                ope: "BusqEditCli",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#text_id").val(cod);
                    $("#txt_Cod").val(data['inde_cli']);
                    $("#txt_Desc").val(data['nom_cli']);
                    $("#CbSexo").selectpicker("val", data['sex_cli']);
                    $("#txt_FecNac").val(data['fec_cli']);
                    $("#txt_Dir").val(data['dir_cli']);
                    $("#txt_email").val(data['email_cli']);
                    $("#txt_Tel").val(data['tel_cli']);
                    $("#txt_obser").val(data['obs_cli']);

                    $("#txt_Cod").prop('disabled', false);
                    $("#txt_Desc").prop('disabled', false);
                    $("#CbSexo").prop('disabled', false);
                    $("#txt_FecNac").prop('disabled', false);
                    $("#txt_Dir").prop('disabled', false);
                    $("#txt_Tel").prop('disabled', false);
                    $("#txt_obser").prop('disabled', false);

                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').hide();

        },
        deletCli: function(cod) {

            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "GuardarClientes.php",
                    data: datos,
                    success: function(data) {
                        if (data === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.cli();
                        }
                    },
                    error: function(error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        paginador: function(pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()
            }

            $.ajax({
                type: "POST",
                url: "PagClientes.php",
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

            };

            $.ajax({
                type: "POST",
                url: "PagClientes.php",
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
                url: "PagClientes.php",
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

    $.cli();

    $("#btn_nuevo1").on("click", function() {
        $('#acc').val("1");

        $("#txt_Cod").val("");
        $("#txt_Desc").val("");
        $("#CbSexo").selectpicker("val", " ");
        $("#txt_FecNac").val("");
        $("#txt_Dir").val("");
        $("#txt_email").val("");
        $("#txt_Tel").val("");
        $("#txt_obser").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#CbSexo").prop('disabled', false);
        $("#txt_FecNac").prop('disabled', false);
        $("#txt_Dir").prop('disabled', false);
        $("#txt_Tel").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);

        $("#responsive").modal();
        $('#mopc').show();


    });


    $("#txt_Cod").on("change", function() {

        var datos = {
            ope: "verfClie",
            cod: $("#txt_Cod").val()
        }

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            success: function(data) {
                if (data === "1") {
                    alert("Esta Identificacion ya ha sido Registrada");
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
        $("#CbSexo").selectpicker("val", " ");
        $("#txt_FecNac").val("");
        $("#txt_Dir").val("");
        $("#txt_email").val("");
        $("#txt_Tel").val("");
        $("#txt_obser").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#CbSexo").prop('disabled', false);
        $("#txt_FecNac").prop('disabled', false);
        $("#txt_Dir").prop('disabled', false);
        $("#txt_Tel").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);


    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function() {


        if ($('#txt_Cod').val() == "") {
            alert("Ingrese la Identificacion");
            $('#txt_Cod').focus();
            return;
        }

        if ($('#txt_Desc').val() === "") {
            alert("Ingrese el Nombre del Cliente");
            $('#txt_Desc').focus();
            return;
        }


        var datos = {
            iden: $("#txt_Cod").val(),
            nom: $("#txt_Desc").val(),
            sex: $("#CbSexo").val(),
            fec: $("#txt_FecNac").val(),
            dir: $("#txt_Dir").val(),
            ema: $("#txt_email").val(),
            tel: $("#txt_Tel").val(),
            obs: $("#txt_obser").val(),
            id: $("#text_id").val(),
            acc: $("#acc").val()
        };

        $.ajax({
            type: "POST",
            url: "GuardarClientes.php",
            data: datos,
            success: function(data) {
                if (data === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.cli();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_Cod").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', true);
                    $("#CbSexo").prop('disabled', true);
                    $("#txt_FecNac").prop('disabled', true);
                    $("#txt_Dir").prop('disabled', true);
                    $("#txt_Tel").prop('disabled', true);
                    $("#txt_obser").prop('disabled', true);

                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });



});

