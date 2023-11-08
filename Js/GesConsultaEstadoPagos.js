$(document).ready(function () {
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_cons").addClass("start active open");
    $("#menu_cons_estado").addClass("active");

    $("#CbconsuTip").selectpicker();

    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        AbrirClien: function () {

            var datos = {
                ope: "VentClientesEstadoPagos",
                tipcli: $("#CbconsuTip").val(),
                bus: ""
            };


            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tab_Clientes").show(100).html(data['tab_cli']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#clientes").modal();


        },
        busqCli: function (bus) {

            var datos = {
                ope: "VentClientesEstadoPagos",
                tipcli: $("#CbconsuTip").val(),
                bus: bus
            };


            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tab_Clientes").show(100).html(data['tab_cli']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        consuAnex: function () {
            $("#ModAnex").modal();
        },
        SelCli: function (val) {
            var par = val.split("//");
            $("#txt_iden").val(par[0]);
            $("#txt_NomCli").val(par[1]);

            var datos = {
                ope: "BusInfConsulPago",
                tipcli: $("#CbconsuTip").val(),
                ident: par[0]

            };
            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_Contrato").val(data['contrato']);
                    $("#txt_plan").val(data['plan']);
                    $("#txt_fecha").val(data['fech_vcenc']);
                    $("#txt_dias").val(data['diav']);
                    $("#tb_benefi").show(100).html(data['CadGrupBas']);
                    if ($("#CbconsuTip").val() === "EMPRESARIAL") {
                        $("#txt_empresa").val(data['nom']);
                    } else {
                        $("#txt_empresa").val("NO APLICA");
                    }
                   
                    if (data['contAnex'] > 1) {
                        $("#btn_anexocli").show();
                        $("#tb_anexos").show(100).html(data['AnexosBenf']);
                    } else {
                        $("#btn_anexocli").hide();
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });


            $('#clientes').modal('toggle');

        }

    });


});
///////////////////////
