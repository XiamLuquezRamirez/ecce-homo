$(document).ready(function() {
    var mapa = "";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_cons").addClass("start active open");
    $("#menu_cons_retra").addClass("active");

    $("#Cbconsu,#CbconsuTip").selectpicker();
    $("#txt_fecha_ini,#txt_fecha_fin").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });


    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        consu: function() {
            var datos = {
                opc: "CargDepartamento",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                con: $("#Cbconsu").val(),
                nreg: $("#nreg").val(),
                fini: $("#txt_fecha_ini").val(),
                ffin: $("#txt_fecha_fin").val()
            };

            var url = "";
            if ($("#CbconsuTip").val() === "PREVI") {
                url = "PagConsultasRetra.php";
            } else {
                url = "PagConsultasRetraOsaLote.php";
            }

            $.ajax({
                type: "POST",
                url: url,
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_TipDoc').show(100).html(data['cad']);
                    $('#bot_TipDoc').show(100).html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                    $('#val_atrasado').html("$ " + number_format2(data['totalpen'], 2, ',', '.'));
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        busqFunera: function(val) {


            var datos = {
                opc: "CargDepartamento",
                bus: val,
                pag: "1",
                op: "1",
                con: $("#Cbconsu").val(),
                tcon: $("#CbconsuTip").val(),
                nreg: $("#nreg").val(),
                fini: $("#txt_fecha_ini").val(),
                ffin: $("#txt_fecha_fin").val()

            };
            var url = "";
            if ($("#CbconsuTip").val() === "PREVI") {
                url = "PagConsultasRetra.php";
            } else {
                url = "PagConsultasRetraOsaLote.php";
            }


            $.ajax({
                type: "POST",
                url: url,
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_TipDoc').show(100).html(data['cad']);
                    //   $('#bot_TipDoc').show(100).html(data['cad2']);
                    //     $('#cobpag').html(data['cbp']);
                    $('#val_atrasado').html("$ " + number_format2(data['totalpen'], 2, ',', '.'));
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },

        paginador: function(pag, servel) {
            regus = "n";
            if ($('#reusu').prop('checked')) {
                regus = "s";
            }
            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val(),
                con: $("#Cbconsu").val(),
                tcon: $("#CbconsuTip").val()
            }

            $.ajax({
                type: "POST",
                url: "PagConsultasRetra.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_TipDoc').show(100).html(data['cad']);
                    //  $('#bot_TipDoc').show(100).html(data['cad2']);
                    //    $('#cobpag').html(data['cbp']);
                    $('#val_atrasado').html("$ " + number_format2(data['totalpen'], 2, ',', '.'));
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
                nreg: $("#nreg").val(),
                con: $("#Cbconsu").val(),
                tcon: $("#CbconsuTip").val()

            }

            $.ajax({
                type: "POST",
                url: "PagConsultasRetra.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_TipDoc').show(100).html(data['cad']);
                    $('#bot_TipDoc').show(100).html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                    $('#val_atrasado').html("$ " + number_format2(data['totalpen'], 2, ',', '.'));
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
                pag: $("#selectpag").val(),
                con: $("#Cbconsu").val(),
                tcon: $("#CbconsuTip").val()

            };

            $.ajax({
                type: "POST",
                url: "PagConsultasRetra.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_TipDoc').html(data['cad']);
                    $('#bot_TipDoc').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                    $('#val_atrasado').html("$ " + number_format2(data['totalpen'], 2, ',', '.'));
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        }

    });
    //======FUNCIONES========\\

    // $.consu();

    $("#btn_impriReport").on("click", function() {
        window.open("PDF_Consultas.php?tcon=" + $('#Cbconsu').val() + "", '_blank');
    });

});
///////////////////////
