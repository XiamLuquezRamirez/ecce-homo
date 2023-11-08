$(document).ready(function() {
    var mapa = "";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});
    $("#home").removeClass("start active open");
    $("#menu_cons").addClass("start active open");
    $("#menu_cons_carteEmpre").addClass("active");
    $("#Cbconsu,#CbconsuTip").selectpicker();
    $("#txt_anio").datepicker({
        autoclose: true,
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        yearRange: '2010:2020'
    });
    $("#txt_mes").datepicker({
        autoclose: true,
        format: "MM",
        changeMonth: true,
        viewMode: "months",
        minViewMode: "months"
    });
    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        consu: function() {

            if ($('#CbconsuTip').val() === " ") {
                alert("Seleccione el Tipo de Consulta");
                $('#CbconsuTip').focus();
                return;
            }
            var datos = {
                pag: "1",
                op: "1",
                cons: $("#CbconsuTip").val(),
                nreg: $("#nreg").val(),
                empre: $("#CbEmpre").val(),
                anio: $("#txt_anio").val(),
                mes: $("#txt_mes").val()
            };
            var url = "";
            url = "PagConsultasEmpre.php";
            $.ajax({
                type: "POST",
                url: url,
                data: datos,
                dataType: 'JSON',
                success: function(data) {

                    $('#tab_TipDoc').show(100).html(data['cad']);

                    $("#divInf").show();
                    $('#val_cartera').html("$ " + number_format2(data['totalCart'], 2, ',', '.'));
                    $('#n_Afiliados').html(data['totalAfi']);
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

            };
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
        },
        TipCons: function(tip) {

            if (tip === "empre") {
                $("#div_mes").hide();
                $("#div_anio").show();
                $("#div_empr").show();
            } else if(tip==="mes"){
                $("#div_mes").show();
                $("#div_anio").show();
                $("#div_empr").hide();
            }else{
                $("#div_mes").hide();
                $("#div_anio").hide();
                $("#div_empr").hide();    
            }
            
        },
        CargaEpre: function() {
            var datos = {
                ope: "CargaEmpresas"
            };
            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#CbEmpre").html(data['empre']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }

    });
    //======FUNCIONES========\\

    $.CargaEpre();
    $("#btn_impriReport").on("click", function() {
        window.open("PDF_ConsultasEmpre.php?tcon=" + $('#CbconsuTip').val() + "&empr=" + $('#CbEmpre').val()
                + "&anio=" + $('#txt_anio').val() + "&mes=" + $('#txt_mes').val() + "", '_blank');
    });
});
///////////////////////
