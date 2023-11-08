$(document).ready(function () {
    var mapa = "";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_user").addClass("start active open");
    $("#menu_ges_usu").addClass("active");



    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        usu: function () {
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
                url: "PagUsuarios.php",
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
        busqUsu: function (val) {


            var datos = {
                opc: "BusqDepe",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "PagUsuarios.php",
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
        editUsu: function (cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEditUsu",
                cod: cod
            }

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_usuid").val(data['cue_inden']);
                    $("#txt_usunom").val(data['cue_nombres']);
                    $("#cbx_sexo").selectpicker("val", data['cue_sexo']);
                    $("#cbx_estado").selectpicker("val", data['cue_estado']);
                    $("#txt_usudir").val(data['cue_dir']);
                    $("#txt_usuTel").val(data['cue_tele']);
                    $("#txt_usuemail").val(data['cue_correo']);
                    $("#txt_usuusu").val(data['cue_alias']);
                    $("#txt_usuusu").val(data['cue_alias']);
                    $("#cbx_perf").select2("val", data['niv_codigo']);

                    $("#acc").val("2");

                    $("#txt_usuid").prop('disabled', false);
                    $("#txt_usunom").prop('disabled', false);
                    $("#cbx_estado").prop('disabled', false);
                    $("#txt_usuTel").prop('disabled', false);
                    $("#txt_usudir").prop('disabled', false);
                    $("#txt_usuemail").prop('disabled', false);
                    $("#txt_usuusu").prop('disabled', false);
                    $("#txt_usucon1").prop('disabled', true);
                    $("#txt_usucon2").prop('disabled', true);
                    $("#cbx_perf").prop('disabled', false);


                    $("#dicont").css("display", "block");
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').show();


        },
        verUsu: function (cod) {

            var datos = {
                ope: "BusqEditUsu",
                cod: cod
            }

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_usuid").val(data['cue_inden']);
                    $("#txt_usunom").val(data['cue_nombres']);
                    $("#cbx_sexo").selectpicker("val", data['cue_sexo']);
                    $("#cbx_estado").selectpicker("val", data['cue_estado']);
                    $("#txt_usudir").val(data['cue_dir']);
                    $("#txt_usuTel").val(data['cue_tele']);
                    $("#txt_usuemail").val(data['cue_correo']);
                    $("#txt_usuusu").val(data['cue_alias']);
                    $("#txt_usuusu").val(data['cue_alias']);
                    $("#cbx_perf").select2("val", data['niv_codigo']);

                    $("#acc").val("2");

                    $("#txt_usuid").prop('disabled', false);
                    $("#txt_usunom").prop('disabled', false);
                    $("#cbx_estado").prop('disabled', false);
                    $("#txt_usuTel").prop('disabled', false);
                    $("#txt_usudir").prop('disabled', false);
                    $("#txt_usuemail").prop('disabled', false);
                    $("#txt_usuusu").prop('disabled', false);
                    $("#txt_usucon1").prop('disabled', true);
                    $("#txt_usucon2").prop('disabled', true);
                    $("#cbx_perf").prop('disabled', false);


                    $("#dicont").css("display", "block");
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').hide();

        },
        deletUsu: function (cod) {
            $("#acc").val("3");

            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: $("#acc").val(),
                    cod: cod
                }

                $.ajax({
                    type: "POST",
                    url: "GuardarUsu.php",
                    data: datos,
                    success: function (data) {
                        if (trimAll(data) == "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.usu();
                        }
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        paginador: function (pag, servel) {


            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "PagUsuarios.php",
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
        combopag: function (pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "PagUsuarios.php",
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
        cargaPerfil: function () {


            var datos = {
                ope: "cargaPerfil"
            }

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                success: function (data) {

                    $('#cbx_perf').show(100).html(data);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });


        },
        validarcontra: function (con, con1) {
            if (con == con1)
                return 'bien';
            else
                return 'mal';
        },
        validarcontra2: function () {
            con = $("#txt_usucon1").val();
            con1 = $("#txt_usucon2").val();
            if (con != con1) {
                alert("Las Contrase\u00f1a no Coinciden. Verifique");
                $("#txt_usucon2").val("");
                $("#txt_usucon2").focus();
            }
        },
        habcontra: function () {
            if ($('#cccont').attr('checked')) {
                $("#txt_usucon1").prop('disabled', false);
                $("#txt_usucon2").prop('disabled', false);
            } else {
                $("#txt_usucon1").prop('disabled', true);
                $("#txt_usucon2").prop('disabled', true);
            }
        }

    });
    //======FUNCIONES========\\

    $("#btn_nuevo1").on("click", function () {
        $('#acc').val("1");
        $("#txt_usuid").val("");
        $("#txt_usunom").val("");
        $("#cbx_sexo").selectpicker("val", " ");
        $("#cbx_estado").selectpicker("val", " ");
        $("#txt_usudir").val("");
        $("#txt_usuTel").val("");
        $("#txt_usuemail").val("");
        $("#txt_usuusu").val("");
        $("#txt_usucon1").val("");
        $("#txt_usucon2").val("");
        $("#cbx_perf").select2("val", "");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_usuid").prop('disabled', false);
        $("#txt_usunom").prop('disabled', false);
        $("#cbx_estado").prop('disabled', false);
        $("#txt_usuTel").prop('disabled', false);
        $("#txt_usudir").prop('disabled', false);
        $("#txt_usuemail").prop('disabled', false);
        $("#txt_usuusu").prop('disabled', false);
        $("#txt_usucon1").prop('disabled', false);
        $("#txt_usucon2").prop('disabled', false);
        $("#cbx_perf").prop('disabled', false);
        $("#dicont").css("display", "none");

        $("#responsive").modal();
        $('#mopc').show();
    });
    $.usu();
    $.cargaPerfil();


    $("#txt_usuid").on("change", function () {

        var datos = {
            ope: "verfUsu",
            cod: $("#txt_usuid").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            success: function (data) {
                if (data == 1) {
                    alert("Esta Identificación ya ha sido Registrada");
                    $('#txt_usuid').focus();
                    $("#txt_usuid").val("");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#txt_usuusu").on("change", function () {

        var datos = {
            ope: "verfNomUsu",
            cod: $("#txt_usuusu").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            success: function (data) {
                if (data == 1) {
                    alert("Este Nombre de Usuario ya Existe");
                    $('#txt_usuusu').focus();
                    $("#txt_usuusu").val("");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#btn_nuevo2").on("click", function () {
        $('#acc').val("1");

        $("#txt_usuid").val("");
        $("#txt_usunom").val("");
        $("#cbx_sexo").selectpicker("val", " ");
        $("#cbx_estado").selectpicker("val", " ");
        $("#txt_usudir").val("");
        $("#txt_usuTel").val("");
        $("#txt_usuemail").val("");
        $("#txt_usuusu").val("");
        $("#txt_usucon1").val("");
        $("#txt_usucon2").val("");
        $("#cbx_perf").select2("val", "");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_usuid").prop('disabled', false);
        $("#txt_usunom").prop('disabled', false);
        $("#cbx_estado").prop('disabled', false);
        $("#txt_usuTel").prop('disabled', false);
        $("#txt_usudir").prop('disabled', false);
        $("#txt_usuemail").prop('disabled', false);
        $("#txt_usuusu").prop('disabled', false);
        $("#txt_usucon1").prop('disabled', false);
        $("#txt_usucon2").prop('disabled', false);
        $("#cbx_perf").prop('disabled', false);
        $("#dicont").css("display", "none");


    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {


        var changPAss = "n";
        if ($('#cccont').prop('checked')) {
            changPAss = "s";
        }

        if ($('#txt_usuid').val() == "") {
            alert("Ingrese la Identificación");
            $('#txt_usuid').focus();
            return;
        }

        if ($('#txt_usunom').val() == "") {
            alert("Ingrese el Nombre");
            $('#txt_usunom').focus();
            return;
        }
        if ($('#txt_usuusu').val() == "") {
            alert("Ingrese el Nombre de Usuario");
            $('#txt_usuusu').focus();
            return;
        }

        if ($("#acc").val() == "1") {
            if ($('#txt_usucon1').val() == "") {
                alert("Ingrese Una Contraseña");
                $('#txt_usucon1').focus();
                return;
            }
        }

        if ($("#acc").val() == "2") {
            if (changPAss == "s") {
                if ($('#txt_usucon1').val() == "") {
                    alert("Ingrese Una Contraseña");
                    $('#txt_usucon1').focus();
                    return;
                }
            }
        }


        var datos = {
            txt_usuid: $("#txt_usuid").val(),
            txt_usunom: $("#txt_usunom").val(),
            cbx_estado: $("#cbx_estado").val(),
            cbx_sexo: $("#cbx_sexo").val(),
            txt_usuTel: $("#txt_usuTel").val(),
            txt_usudir: $("#txt_usudir").val(),
            txt_usuemail: $("#txt_usuemail").val(),
            txt_usuusu: $("#txt_usuusu").val(),
            txt_usucon1: $("#txt_usucon1").val(),
            cbx_perf: $("#cbx_perf").val(),
            changPAss: changPAss,
            acc: $("#acc").val()


        }

        $.ajax({
            type: "POST",
            url: "GuardarUsu.php",
            data: datos,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.usu();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_usuid").prop('disabled', true);
                    $("#txt_usunom").prop('disabled', true);
                    $("#cbx_estado").prop('disabled', true);
                    $("#txt_usuTel").prop('disabled', true);
                    $("#txt_usudir").prop('disabled', true);
                    $("#txt_usuemail").prop('disabled', true);
                    $("#txt_usuusu").prop('disabled', true);
                    $("#txt_usucon1").prop('disabled', true);
                    $("#txt_usucon2").prop('disabled', true);
                    $("#cbx_perf").prop('disabled', true);

                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });



});
///////////////////////
