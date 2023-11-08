$(document).ready(function () {
    // $("#fecha").inputmask("d/m/y", {autoUnmask: true});
    var Order = "";
    $("#home").removeClass("start active open");
    $("#menu_serv").addClass("start active open");
    $("#menu_serv_prev").addClass("active");

    var Dat_Anexos = "";


    $("#txt_fecha_pagoAnio,#txt_fecha_Cre, #txt_fecha_pago,#txt_fecha_PagoDet,#txt_FecNac,#txt_fecha_Pago,#txt_fecha_PagoHas").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });


    $("#txt_fecha_vel, #txt_fecha_Exc").datetimepicker({
        isRTL: Metronic.isRTL(),
        format: "yyyy-mm-dd - HH:ii P",
        showMeridian: true,
        autoclose: true,
        pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left"),
        todayBtn: true,
        language: 'es'
    });


    $("#cbx_Pagen,#CbFormPagoAnio,#cbx_Fpago,#cbx_mesPag,#Cbanios,#CbFormPagoC,#CbPlanExeC,#CbTipVincC,#CbPlanExe,#CbTipVinc,#CbTipClien,#CbSexo,#CbDirRecaudo,#CbParenGruBas,#CbSexoGrupBas,#CbEstGrupBas,#CbParenGruSec,#CbSexoGrupSec,#CbEstaGrupSec,#CbFormPago").selectpicker();


    var contGruBas = 0;
    var contGruSec = 0;
    var vtotalg = 0;
    var Dat_GrupBas = "";
    var Dat_GrupSec = "";


    $.extend({
        Previ: function () {
            //$('#cargando').modal('show');
            var datos = {
                opc: "CargContratos",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val(),
                ord: Order
            };

            $.ajax({
                type: "POST",
                url: "PagPrevision.php",
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
        busqContrato: function (val) {


            var datos = {
                opc: "BusqDepe",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val(),
                ord: Order

            };

            $.ajax({
                type: "POST",
                url: "PagPrevision.php",
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
        busqCli: function (val) {


            var datos = {
                ope: "VentClientes",
                bus: val
            }


            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tab_Clientes").show(100).html(data['tabla_terceros']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        anios: function () {

            var datos = {
                ope: "tab_anios",
                cod: $("#id_prevision").val()
            };


            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tb_Anios").show(100).html(data['tabla_anios']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        aniosDeta: function () {

            var datos = {
                ope: "tab_aniosDeta",
                cod: $("#txt_anioSel").val(),
                pre: $("#id_prevision").val()
            };
            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tb_DetaxAnio").show(100).html(data['tabla_aniosDet']);
                    $("#saldo").val(data['saldo']);
                    $("#mes").val(data['cuota']);
                    $("#val_contrato").html('$ ' + number_format2(data['valor'], 2, ',', '.'));
                    $("#val_Mens_contrato").html('$ ' + number_format2(data['cuota'], 2, ',', '.'));
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }

            });

        },
        DelAnio: function (id) {

            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {
                var datos = {
                    ope: "del_anios",
                    cod: id
                };

                $.ajax({
                    type: "POST",
                    url: "All.php",
                    data: datos,
                    success: function (data) {
                        if (trimAll(data) === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.anios();
                        }
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        validarAnios: function (val) {


            var datos = {
                ope: "val_anio",
                cod: val,
                contr: $('#id_prevision').val()
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                success: function (data) {

                    if (trimAll(data) === "1") {
                        alert("Este Año ya a sido Creado. Verifique...");
                        $('#txt_anio').focus();
                        $("#txt_anio").val("");
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        PrintPrev: function (val) {
            window.open("PDF_ContPrevi.php?id=" + val + "", '_blank');
        },
        busqActi: function (val) {


            var datos = {
                ope: "VentActividades",
                tac: "ETAPA PREPARATIVA",
                bus: val
            }


            $.ajax({
                type: "POST",
                url: "../All",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tab_Actividades").show(100).html(data['tabla_actividades']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        SelCli: function (val) {
            var par = val.split("//");

            $("#txt_id_cli").val(par[0]);
            $("#txt_iden").val(par[1]);
            $("#txt_NomCli").val(par[2]);
            $("#CbSexo").selectpicker("val", par[3]);
            $("#txt_FecNac").val(par[4]);
            $("#txt_Dir").val(par[5]);
            $("#txt_Tel").val(par[6]);
            $("#txt_Dirbarrio").val(par[7]);
            $("#txtemail").val(par[8]);
            $("#txt_nuevo").val("NO");

            $('#clientes').modal('toggle');

        },
        SelNece: function (val) {
            var par = val.split("//");

            $("#txt_id_Nec").val(par[0]);
            $("#txt_nomNec").val(par[1]);
            $("#txt_Cant").val("1");
            $("#txt_Val").val(par[2]);
            $('#necesidad').modal('toggle');
        },

        AddGrupBas: function () {

            var txt_IdGruBas = $("#txt_IdGruBas").val();
            var txt_NomGruBas = $('#txt_NomGruBas').val();
            var CbParenGruBas = $('#CbParenGruBas').val();
            var CbSexoGrupBas = $('#CbSexoGrupBas').val();
            var CbEstGrupBas = $('#CbEstGrupBas').val();
            var txt_EdadGrupBas = $('#txt_EdadGrupBas').val();
            var txt_CiudResGrupBas = $('#txt_CiudResGrupBas').val();

            contGruBas = $("#contGruBas").val();

            contGruBas++;

            var fila = '<tr class="selected" id="filaGruBas' + contGruBas + '" >';

            fila += "<td>" + contGruBas + "</td>";
            fila += "<td>" + txt_IdGruBas + "</td>";
            fila += "<td>" + txt_NomGruBas + "</td>";
            fila += "<td>" + CbParenGruBas + "</td>";
            fila += "<td>" + CbEstGrupBas + "</td>";
            fila += "<td>" + CbSexoGrupBas + "</td>";
            fila += "<td>" + txt_EdadGrupBas + "</td>";
            fila += "<td>" + txt_CiudResGrupBas + "</td>";

            fila += "<td><input type='hidden' id='GrupBas" + contGruBas + "' name='GrupBas' value='" + txt_IdGruBas + "//" + txt_NomGruBas + "//" + CbParenGruBas + "//" + CbEstGrupBas + "//" + CbSexoGrupBas + "//" + txt_EdadGrupBas + "//" + txt_CiudResGrupBas + "' />\n\
  <a onclick=\"$.QuitarGrupBas('filaGruBas" + contGruBas + "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>\n\
  <a onclick=\"$.EditGrupBas('filaGruBas" + contGruBas + "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-edit\"></i> Editar</a>\n\
</td></tr>";


            $('#tb_GrupBas').append(fila);
            $.reordenarGrupBas();
            $.limpiarGrupBas();
            $("#contGruBas").val(contGruBas);
        },
        UpdGrupBas: function () {

            var txt_IdGruBas = $("#txt_IdGruBas").val();
            var txt_NomGruBas = $('#txt_NomGruBas').val();
            var CbParenGruBas = $('#CbParenGruBas').val();
            var CbSexoGrupBas = $('#CbSexoGrupBas').val();
            var CbEstGrupBas = $('#CbEstGrupBas').val();
            var txt_EdadGrupBas = $('#txt_EdadGrupBas').val();
            var txt_CiudResGrupBas = $('#txt_CiudResGrupBas').val();
            id_fila = $("#FilaEdit").val();
            ConsEdit = id_fila.slice(10);

            var fila = '';

            fila += "<td>" + ConsEdit + "</td>";
            fila += "<td>" + txt_IdGruBas + "</td>";
            fila += "<td>" + txt_NomGruBas + "</td>";
            fila += "<td>" + CbParenGruBas + "</td>";
            fila += "<td>" + CbEstGrupBas + "</td>";
            fila += "<td>" + CbSexoGrupBas + "</td>";
            fila += "<td>" + txt_EdadGrupBas + "</td>";
            fila += "<td>" + txt_CiudResGrupBas + "</td>";

            fila += "<td><input type='hidden' id='GrupBas" + ConsEdit + "' name='GrupBas' value='" + txt_IdGruBas + "//" + txt_NomGruBas + "//" + CbParenGruBas + "//" + CbEstGrupBas + "//" + CbSexoGrupBas + "//" + txt_EdadGrupBas + "//" + txt_CiudResGrupBas + "' />\n\
            <a onclick=\"$.QuitarGrupBas('filaGruBas" + ConsEdit + "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>\n\
            <a onclick=\"$.EditGrupBas('filaGruBas" + ConsEdit + "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-edit\"></i> Editar</a>\n\
            </td>";

            $('#' + id_fila).html(fila);

            $("#Btn_AddBas").html('<a onclick="$.AddGrupBas()"  class="btn green">Agregar <i class="fa fa-plus"></i></a>');
            $.limpiarGrupBas();
        },
        UpdGrupSec: function () {

            var txt_IdGruBas = $("#txt_IdGruSec").val();
            var txt_NomGruBas = $('#txt_NomGruSec').val();
            var CbParenGruBas = $('#CbParenGruSec').val();
            var CbSexoGrupBas = $('#CbSexoGrupSec').val();
            var CbEstGrupBas = $('#CbEstaGrupSec').val();
            var txt_EdadGrupBas = $('#txt_EdadGrupSec').val();
            var txt_CiudResGrupBas = $('#txt_CiudResGrupSec').val();
            id_fila = $("#FilaEdit").val();
            ConsEdit = id_fila.slice(10);

            var fila = '';

            fila += "<td>" + ConsEdit + "</td>";
            fila += "<td>" + txt_IdGruBas + "</td>";
            fila += "<td>" + txt_NomGruBas + "</td>";
            fila += "<td>" + CbParenGruBas + "</td>";
            fila += "<td>" + CbEstGrupBas + "</td>";
            fila += "<td>" + CbSexoGrupBas + "</td>";
            fila += "<td>" + txt_EdadGrupBas + "</td>";
            fila += "<td>" + txt_CiudResGrupBas + "</td>";

            fila += "<td><input type='hidden' id='GrupSec" + ConsEdit + "' name='GrupSec' value='" + txt_IdGruBas + "//" + txt_NomGruBas + "//" + CbParenGruBas + "//" + CbEstGrupBas + "//" + CbSexoGrupBas + "//" + txt_EdadGrupBas + "//" + txt_CiudResGrupBas + "' />\n\
            <a onclick=\"$.QuitarGrupSec('filaGruSec" + ConsEdit + "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>\n\
            <a onclick=\"$.EditGrupSec('filaGruSec" + ConsEdit + "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-edit\"></i> Editar</a>\n\
            </td>";

            $('#' + id_fila).html(fila);

            $("#Btn_AddSec").html('<a onclick="$.AddGrupSec()"  class="btn green">Agregar <i class="fa fa-plus"></i></a>');
            $.limpiarGrupSec();
        },
        limpiarGrupBas: function () {

            $("#txt_IdGruBas").val("");
            $('#txt_NomGruBas').val("");
            $("#CbParenGruBas").selectpicker("val", " ");
            $("#CbSexoGrupBas").selectpicker("val", " ");
            $("#CbEstGrupBas").selectpicker("val", " ");
            $('#txt_EdadGrupBas').val("");
            $('#txt_CiudResGrupBas').val("VALLEDUPAR");

        },
        reordenarGrupBas: function () {
            var num = 1;
            $('#tb_GrupBas tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_GrupBas tbody input').each(function () {
                $(this).attr('id', "GrupBas" + num);
                num++;
            });

        },
        QuitarGrupBas: function (id_fila, valor) {
            $('#' + id_fila).remove();
            $.reordenarGrupBas();
            contGruBas = $('#contGruBas').val();
            contGruBas = contGruBas - 1;
            $("#contGruBas").val(contGruBas);

        },
        EditGrupBas: function (id_fila) {

            $("#FilaEdit").val(id_fila);

            $('#' + id_fila).find(':input').each(function () {
                Dat_GrupBas = $(this).val();
            });
            ParDat = Dat_GrupBas.split("//");

            $("#txt_IdGruBas").val(ParDat[0]);
            $('#txt_NomGruBas').val(ParDat[1]);
            $("#CbParenGruBas").selectpicker("val", ParDat[2]);
            $("#CbSexoGrupBas").selectpicker("val", ParDat[4]);
            $("#CbEstGrupBas").selectpicker("val", ParDat[3]);
            $('#txt_EdadGrupBas').val(ParDat[5]);
            $('#txt_CiudResGrupBas').val(ParDat[6]);

            $("#Btn_AddBas").html('<a onclick="$.UpdGrupBas()" id="Btn_AddBas" class="btn blue">Actualizar <i class="fa fa-refresh"></i></a>');

        },
        EditGrupSec: function (id_fila) {

            $("#FilaEdit").val(id_fila);

            $('#' + id_fila).find(':input').each(function () {
                Dat_GrupBas = $(this).val();
            });
            ParDat = Dat_GrupBas.split("//");

            $("#txt_IdGruSec").val(ParDat[0]);
            $('#txt_NomGruSec').val(ParDat[1]);
            $("#CbParenGruSec").selectpicker("val", ParDat[2]);
            $("#CbSexoGrupSec").selectpicker("val", ParDat[4]);
            $("#CbEstaGrupSec").selectpicker("val", ParDat[3]);
            $('#txt_EdadGrupSec').val(ParDat[5]);
            $('#txt_CiudResGrupSec').val(ParDat[6]);

            $("#Btn_AddSec").html('<a onclick="$.UpdGrupSec()" id="Btn_AddBas" class="btn blue">Actualizar <i class="fa fa-refresh"></i></a>');

        },
        AddGrupSec: function () {

            var txt_IdGruSec = $("#txt_IdGruSec").val();
            var txt_NomGruSec = $('#txt_NomGruSec').val();
            var CbParenGruSec = $('#CbParenGruSec').val();
            var CbSexoGrupSec = $('#CbSexoGrupSec').val();
            var CbEstaGrupSec = $('#CbEstaGrupSec').val();
            var txt_EdadGrupSec = $('#txt_EdadGrupSec').val();
            var txt_CiudResGrupSec = $('#txt_CiudResGrupSec').val();

            contGruSec = $("#contGruSec").val();

            contGruSec++;

            var fila = '<tr class="selected" id="filaGruSec' + contGruSec + '" >';

            fila += "<td>" + contGruSec + "</td>";
            fila += "<td>" + txt_IdGruSec + "</td>";
            fila += "<td>" + txt_NomGruSec + "</td>";
            fila += "<td>" + CbParenGruSec + "</td>";
            fila += "<td>" + CbEstaGrupSec + "</td>";
            fila += "<td>" + CbSexoGrupSec + "</td>";
            fila += "<td>" + txt_EdadGrupSec + "</td>";
            fila += "<td>" + txt_CiudResGrupSec + "</td>";

            fila += "<td><input type='hidden' id='GrupSec" + contGruSec + "' name='GrupSec' value='" + txt_IdGruSec + "//" + txt_NomGruSec + "//" + CbParenGruSec + "//" + CbEstaGrupSec + "//" + CbSexoGrupSec + "//" + txt_EdadGrupSec + "//" + txt_CiudResGrupSec + "' />\n\
            <a onclick=\"$.QuitarGrupSec('filaGruSec" + contGruSec + "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>\n\
            \n\<a onclick=\"$.EditGrupSec('filaGruSec" + contGruSec + "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-edit\"></i> Editar</a>\n\
            </td></tr>";

            $('#tb_GrupSec').append(fila);
            $.reordenarGrupSec();
            $.limpiarGrupSec();
            $("#contGruSec").val(contGruSec);
        },
        limpiarGrupSec: function () {

            $("#txt_IdGruSec").val("");
            $('#txt_NomGruSec').val("");
            $("#CbParenGruSec").selectpicker("val", " ");
            $("#CbSexoGrupSec").selectpicker("val", " ");
            $("#CbEstaGrupSec").selectpicker("val", " ");
            $('#txt_EdadGrupSec').val("");
            $('#txt_CiudResGrupSec').val("VALLEDUPAR");

        },
        reordenarGrupSec: function () {
            var num = 1;
            $('#tb_GrupSec tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_GrupSec tbody input').each(function () {
                $(this).attr('id', "GrupSec" + num);
                num++;
            });

        },
        QuitarGrupSec: function (id_fila, valor) {
            $('#' + id_fila).remove();
            $.reordenarGrupSec();
            contGruSec = $('#contGruSec').val();
            contGruSec = contGruSec - 1;
            $("#contGruSec").val(contGruSec);

        },
        habiCobr: function () {
            if ($('#cbx_Pagen').val() === "COBRADORES") {
                $("#txt_NCobrador").prop('disabled', false);
            } else {
                $("#txt_NCobrador").prop('disabled', true);
            }
        },
        AddAnio: function () {
            $("#anios").modal();
        },
        AddDetPago: function () {

            $("#acc_detpago").val("1");
            $("#DetallPago").modal();

            $("#btn_nuevoDet").prop('disabled', true);
            $("#btn_guardarDet").prop('disabled', false);
            $("#txt_fecha_Pago").prop('disabled', false);
            $("#cbx_mesPag").prop('disabled', false);
            $("#txt_fecha_PagoHas").prop('disabled', false);
            $("#txt_obserDetPag").prop('disabled', false);

            $("#txt_fecha_Pago").val('');
            $("#txt_fecha_PagoHas").val('');
            $("#txt_nRecibo").val('');
            $("#txt_obserDetPag").val('');
            $("#cbx_mesPag").selectpicker("val", ' ');

            $("#txt_ValCuota").val("$ " + number_format2($("#mes").val(), 2, ',', '.'));
            $("#txt_ValReal").val($("#mes").val());

        },
        AddPago: function (id) {

            $('#id_prevision').val(id);

            var datos = {
                ope: "BusqPrevi",
                cod: id
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_CodC").val(data['ncontrato']);
                    $("#txt_fecha_CreC").val(data['fecha_cre']);
                    $("#txt_CiudaC").val(data['ciudad']);
                    $('#CbPlanExeC').val(data["plan"]).change();
                    $("#CbTipVincC").val(data['tipo_vinc']);
                    $("#txt_titular").val(data['nomb_titu']);
                    $("#val_contrato").html('$ ' + data['val_anual']);
                    $("#txt_ValAnAnio").val('$ ' + data['val_anual']);
                    $("#val_Mens_contrato").html('$ ' + data['val_mes']);
                    $("#txt_ValMeAnio").val('$ ' + data['val_mes']);
                    $("#val_Pend_contrato").html('$ ' + number_format2(data['saldo'], 2, ',', '.'));
                    $("#CbFormPagoC").selectpicker("val", data["form_pago"]);
                    $("#txt_fecha_pago").val(data['fech_ini']);
                    $("#txt_asesorC").val(data['asesor']);
                    $("#txt_cobraC").val(data['cobrador']);
                    $("#saldo").val(data['saldo']);
                    $("#mes").val(data['mes']);

                }

            });

            $.anios();

            $('#divDeta').hide();
            $('#tab_03_pp').show();
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").removeClass("active in");
            $("#tab_02_pp").removeClass("active in");
            $("#tab_03").addClass("active in");
            $("#tab_03_pp").addClass("active in");





        },
        editPrev: function (cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);


            var datos = {
                ope: "BusqEditPrev",
                cod: cod
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_id").val(cod);

                    $("#txt_Cod").val(data['ncontrato']);
                    $("#txt_fecha_Cre").val(data['fecha_cre']);
                    $("#txt_Ciuda").val(data['ciudad']);
                    $('#CbPlanExe').val(data["plan"]).change();
                    $("#CbTipVinc").selectpicker("val", data['tipo_vinc']);
                    $("#txt_Empre").val(data['empresa']);
                    $("#txt_iden").val(data['id_titu']);
                    $("#txt_NomCli").val(data['nomb_titu']);
                    $("#CbTipClien").selectpicker("val", data["tipo_cli"]);
                    $("#CbSexo").selectpicker("val", data["sex_cli"]);
                    $("#txt_FecNac").val(data['fec_cli']);
                    $("#txt_Dir").val(data['dir_cli']);
                    $("#txt_Tel").val(data['tel_cli']);
                    $("#CbDirRecaudo").selectpicker("val", data["dir_recau"]);
                    $("#txt_OtrDir").val(data['otr_dir']);
                    $("#txt_IdEmpl").val(data['id_emple']);
                    $("#txt_NomEmpl").val(data['nom_emple']);
                    $("#txt_DirEmpl").val(data['dir_emple']);
                    $("#txt_CiuEmpl").val(data['ciud_emple']);
                    $("#txt_DepEmpl").val(data['depar_emple']);
                    $("#txt_TelEmpl").val(data['tel_emple']);
                    $("#txt_ValAn").val('$ ' + data['val_anual']);
                    $("#txt_ValMe").val('$ ' + data['val_mes']);
                    $("#CbFormPago").selectpicker("val", data["form_pago"]);
                    $("#txt_fecha_pago").val(data['fech_ini']);
                    $("#txt_Asesor").val(data['asesor']);
                    $("#txt_Dirbarrio").val(data['barrio']);
//                    $("#txt_Asesor").val(data['cobrador']);
                    $("#txt_obser").val(data['observ']);


                    $("#tb_GrupBas").html(data['CadGrupBas']);
                    $("#contGruBas").val(data['contGrupBas']);

                    $("#tb_GrupSec").html(data['CadGrupSec']);
                    $("#contGruSec").val(data['contGrupSec']);

                    $("#tb_Anexo").html(data['Tab_Anexos']);
                    $("#contAnexo").val(data['contAnexos']);



                }
//                error: function (error_messages) {
//                    alert('HA OCURRIDO UN ERROR');
//                }
            });


            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Previsi&oacute;n</a>");


        },
        CalCuota: function () {

            var meses = $("#cbx_mesPag").val();

            var valmes = parseFloat($("#txt_ValReal").val());
            var vtotal = 0;
            for (var i = 0; i <= meses.length - 1; i++) {
                vtotal += valmes;
            }
            $("#txt_ValCuota").val("$ " + number_format2(vtotal, 2, ',', '.'));

        },

        VerPrev: function (cod) {

            $("#btn_guardar").prop('disabled', true);
            var datos = {
                ope: "BusqEditPrev",
                cod: cod
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_id").val(cod);

                    $("#txt_Cod").val(data['ncontrato']);
                    $("#txt_fecha_Cre").val(data['fecha_cre']);
                    $("#txt_Ciuda").val(data['ciudad']);
                    $('#CbPlanExe').val(data["plan"]).change();
                    $("#CbTipVinc").selectpicker("val", data['tipo_vinc']);
                    $("#txt_Empre").val(data['empresa']);
                    $("#txt_iden").val(data['id_titu']);
                    $("#txt_NomCli").val(data['nomb_titu']);
                    $("#CbTipClien").selectpicker("val", data["tipo_cli"]);
                    $("#CbSexo").selectpicker("val", data["sex_cli"]);
                    $("#txt_FecNac").val(data['fec_cli']);
                    $("#txt_Dir").val(data['dir_cli']);
                    $("#txt_Tel").val(data['tel_cli']);
                    $("#CbDirRecaudo").selectpicker("val", data["dir_recau"]);
                    $("#txt_OtrDir").val(data['otr_dir']);
                    $("#txt_IdEmpl").val(data['id_emple']);
                    $("#txt_NomEmpl").val(data['nom_emple']);
                    $("#txt_DirEmpl").val(data['dir_emple']);
                    $("#txt_CiuEmpl").val(data['ciud_emple']);
                    $("#txt_DepEmpl").val(data['depar_emple']);
                    $("#txt_TelEmpl").val(data['tel_emple']);
                    $("#txt_ValAn").val('$ ' + data['val_anual']);
                    $("#txt_ValMe").val('$ ' + data['val_mes']);
                    $("#CbFormPago").selectpicker("val", data["form_pago"]);
                    $("#txt_fecha_pago").val(data['fech_ini']);
                    $("#txt_Asesor").val(data['asesor']);
                    $("#txt_obser").val(data['observ']);
                    $("#txt_Dirbarrio").val(data['barrio']);


                    $("#tb_GrupBas").html(data['CadGrupBas']);
                    $("#contGruBas").val(data['contGrupBas']);

                    $("#tb_GrupSec").html(data['CadGrupSec']);
                    $("#contGruSec").val(data['contGrupSec']);

                    $("#tb_Anexo").html(data['Tab_Anexos']);
                    $("#contAnexo").val(data['contAnexos']);


                }
//                error: function (error_messages) {
//                    alert('HA OCURRIDO UN ERROR');
//                }
            });


            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Ver Previsio&oacute;n</a>");


        },
        AbrirClien: function () {

            var datos = {
                ope: "VentClientes",
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
        EditDetPagos: function (cod) {

            $("#id_deta_pago").val(cod);

            $("#acc_detpago").val("2");

            var datos = {
                ope: "VerDetallePago",
                cod: cod,
                ida: $("#txt_anioSel").val(),
                idp: $("#id_prevision").val()
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_fecha_PagoDet").val(data['fpago']);
                    $("#txt_ValCuota").val("$ " + number_format2(data['valor'], 2, ',', '.'));
                    $("#txt_ValReal").val(data['valor']);

                    var mes = data["mes"].split(",");
                    $("#cbx_mesPag").val(mes).change();
                    //   $("#cbx_mesPag").selectpicker("val", data['mes']);
                    $("#txt_fecha_PagoHas").val(data['fvenc']);
                    $("#cbx_Pagen").selectpicker("val", data['pagoen']);
                    $("#txt_obserDetPag").val(data['observ']);
                    $("#saldo").val(data['saldo']);
                    $("#txt_nRecibo").val(data['recibo']);
                    $("#txt_NCobrador").val(data['cobrador']);
                    if (data['pagoen'] === "COBRADORES") {
                        $("#txt_NCobrador").prop('disabled', false);
                    }

                    if (data['recibo'] === "") {
                        $("#btn_nuevoDet").prop('disabled', true);
                        $("#btn_Recibo").prop('disabled', true);
                        $("#btn_guardarDet").prop('disabled', false);

                        $("#txt_fecha_Pago").prop('disabled', false);
                        $("#cbx_mesPag").prop('disabled', false);
                        $("#txt_fecha_PagoHas").prop('disabled', false);
                        $("#txt_obserDetPag").prop('disabled', false);
                        $("#cbx_Pagen").prop('disabled', false);



                    } else {
                        $("#btn_nuevoDet").prop('disabled', false);
                        $("#btn_Recibo").prop('disabled', false);
                        $("#btn_guardarDet").prop('disabled', true);
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#DetallPago").modal();



        },
        MostrarRecibo: function (cod) {

            var datos = {
                ope: "VerDetalleRecibo",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    par = cod.split("/");

                    $("#id_deta_pago").val(par[1]);
                    $("#txt_ConRec").val(par[0]);
                    $("#txt_idRecib").val(data['id']);
                    $("#txt_fecha_RecPag").val(data['fecha']);
                    $("#txt_ValRecib").val('$ ' + number_format2(data['valor'], 2, ',', '.'));
                    $("#txt_indenRec").val(data['iden']);
                    $("#txt_NomRec").val(data['nombre']);
                    $("#txt_ValLetra").val(data['valletra']);
                    $("#txt_ConcepRec").val(data['concepto']);
                    $("#txt_CuoMes").val(data['cuotames']);
                    $("#cbx_Fpago").selectpicker("val", data['fpago']);
                    $("#txt_Ncheque").val(data['ncheque']);
                    $("#txt_BancoRec").val(data['nbanco']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#VentRecibo").modal();
            $("#btn_guardarReci").prop('disabled', true);
            $('#btn_ImprRec').show();
            $('#btn_Anular').show();

        },
        AbrirNece: function () {

            var datos = {
                ope: "VentNece",
                bus: ""
            }


            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tab_Nece").show(100).html(data['tab_cli']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#necesidad").modal();


        },
        MostrarBenef: function () {

            var datos = {
                ope: "mostbenefi",
                cod: $("#id_prevision").val()
            };


            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tab_benbas").html(data['CadGrupBas']);
                    $("#tab_bensec").html(data['CadGrupSec']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#beneficiarios").modal();


        },
        VerDetPagos: function (anio) {
            var pani = anio.split("//");
            $("#txt_anioSel").val(pani[0]);
            $('#an_cont').html(" " + $("#txt_CodC").val() + " Año " + pani[1]);
            $('#divDeta').show();

            $.aniosDeta();

        },

        deletPrev: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "GuardarPrevi.php",
                    data: datos,
                    success: function (data) {
                        if (trimAll(data) === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.Previ();
                        } else {
                            alert("No se puede Eliminar la El Contrato  porque tiene Pagos Relacionados");
                        }
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        DelDetPagos: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var parde = cod.split("/");
                var datos = {
                    ope: "deleteDetPago",
                    cod: parde[0],
                    val: parde[1],
                    idp: $("#id_prevision").val()
                };

                $.ajax({
                    type: "POST",
                    url: "All.php",
                    data: datos,
                    success: function (data) {
                        if (trimAll(data) === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.aniosDeta();
                        } else if (trimAll(data) === "ult") {
                            alert("Solo Puede ser Eliminado el Ultimo Registro, Verifique");
                        } else if (trimAll(data) === "rec") {
                            alert("No se Puede Eliminar el Registro porque esta asociado a un Recibo, Verifique");
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
                nreg: $("#nreg").val(),
                ord: Order
            }

            $.ajax({
                type: "POST",
                url: "PagPrevision.php",
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
                nreg: $("#nreg").val(),
                ord: Order

            }

            $.ajax({
                type: "POST",
                url: "PagPrevision.php",
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
        Dta_Anexos: function () {
            Dat_Anexos = "";
            $("#tb_Anexo").find(':input').each(function () {
                Dat_Anexos += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Anexos += "&Long_Anexos=" + $("#contAnexo").val();
        },
        combopag2: function (nre) {

            var datos = {
                nreg: nre,
                bus: $("#busq_centro").val(),
                pag: $("#selectpag").val(),
                ord: Order

            }

            $.ajax({
                type: "POST",
                url: "PagPrevision.php",
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

        conse: function () {

            var text = $("#atitulo").text();

            if (text === "Crear Previsión") {

                var datos = {
                    ope: "ConConsecutivo",
                    tco: "PREVISION"
                };


                $.ajax({
                    type: "POST",
                    url: "All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        $("#txt_Cod").val(data['StrAct']);
                        $("#cons").val(data['cons']);

                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });

                //  $('#mopc').hide();

            }

        },
        conseRec: function () {

            var datos = {
                ope: "ConConsecutivo",
                tco: "RECIBOPAE"
            };


            $.ajax({
                async: false,
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_ConRec").val(data['StrAct']);
                    $("#consRec").val(data['cons']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            //  $('#mopc').hide();



        },
        NumLetr: function (num) {
            $("#txt_vtotalFact").val(num);
            var datos = {
                num: num
            };


            $.ajax({
                type: "POST",
                url: "numero_letra.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_ValLetra").val(data['letra']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        UploadDoc: function () {
            var archivos = document.getElementById("archivos");//Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            //Creamos una instancia del Objeto FormDara.
            var archivos = new FormData();
            /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
             Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como
             indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
            for (i = 0; i < archivo.length; i++) {
                archivos.append('archivo' + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
            }


            var ruta = "upload_Anexo.php";

            $.ajax({
                async: false,
                url: ruta,
                type: "POST",
                data: archivos,
                contentType: false,
                processData: false,
                success: function (datos)
                {
                    var par_res = datos.split("//");
                    if (par_res[0] === "Bien") {
                        $('#Src_File').val(par_res[1].trim());
                    } else if (par_res[0] === "Mal") {
                        $.Alert("#msgArch", "El archivo no se Puede Agregar debido al siguiente Error:".par_res[1], "warning");
                    }

                }
            });
        },
        AddArchivos: function () {

            var txt_DesAnex = $("#txt_DesAnex").val();
            var Src_File = $("#Src_File").val();
            var Name_File = $("#Src_File").val();


            var contAnexo = $("#contAnexo").val();
            contAnexo++;
            var fila = '<tr class="selected" id="filaAnexo' + contAnexo + '" >';

            fila += "<td>" + contAnexo + "</td>";
            fila += "<td>" + txt_DesAnex + "</td>";
            fila += "<td>" + Name_File + "</td>";
            fila += "<td><a href='Anexos/" + Src_File + "' target='_blank' class=\"btn default btn-xs blue\">"
                    + "<i class=\"fa fa-search\"></i> Ver</a>";
            fila += "<input type='hidden' id='idAnexo" + contAnexo + "' name='idAnexo' value='" + txt_DesAnex + "///" + Name_File + "///" + Src_File + "' /><a onclick=\"$.QuitarAnexo('filaAnexo" + contAnexo + "')\" class=\"btn default btn-xs red\">"
                    + "<i class=\"fa fa-trash-o\"></i> Quitar</a></td></tr>";

            $('#tb_Anexo').append(fila);
            $.reordenarAnexo();
            $("#contAnexo").val(contAnexo);

            $("#txt_DesAnex").val("");
            //   $("#Src_File").val("");
            $("#Name_File").val("");
            $("#archivos").val("");
            $("#fileSize").html("");

        },
        reordenarAnexo: function () {
            var num = 1;
            $('#tb_Anexo tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_Anexo tbody input').each(function () {
                $(this).attr('id', "idAnexo" + num);
                num++;
            });

        },
        QuitarAnexo: function (id_fila) {
            $('#' + id_fila).remove();
            $.reordenarAnexo();
            contProd = $('#contAnexo').val();
            contProd = contProd - 1;
            $("#contAnexo").val(contProd);
        },
        Dta_GrupBas: function () {
            Dat_GrupBas = "";
            $("#tb_GrupBas").find(':input').each(function () {
                Dat_GrupBas += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_GrupBas += "&Long_GrupBas=" + $("#contGruBas").val();

        },
        Dta_GrupSec: function () {
            Dat_GrupSec = "";
            $("#tb_GrupSec").find(':input').each(function () {
                Dat_GrupSec += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_GrupSec += "&Long_GrupSec=" + $("#contGruSec").val();
        }

    });

    //======FUNCIONES========\\
    $.Previ();


    $("#txt_iden").on("change", function () {

        var datos = {
            ope: "busDatCli",
            cod: $("#txt_iden").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {
                $('#txt_id_cli').val(data['id_cli']);
                $('#txt_NomCli').val(data['nom_cli']);
                $("#CbSexo").selectpicker("val", data['sex_cli']);
                $("#txt_FecNac").val(data['fec_cli']);
                $("#txt_DirCli").val(data['dir_cli']);
                $("#txt_TelCli").val(data['tel_cli']);
                $("#txt_nuevo").val(data['cliex']);
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });


    $("#btn_volver").on("click", function () {
        window.location.href = "AdminServicios.php";
    });


    $("#btn_cancelar").on("click", function () {
        window.location.href = 'GesContratoPrevi.php';
    });

    $("#btn_nuevoAnio").on("click", function () {
        $("#btn_nuevoAnio").prop('disabled', true);
        $("#btn_guardarAnio").prop('disabled', false);

        $("#txt_anio").prop('disabled', false);
        $("#txt_anio").val('');
    });

    $("#btn_ImprRec").on("click", function () {
        window.open("PDF_ReciboPago.php?id=" + $('#txt_idRecib').val() + "", '_blank');
    });

    $("#btn_Anular").on("click", function () {
        if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {


            var datos = {
                ope: "AnularRecibo",
                cod: $("#txt_idRecib").val(),
                iddet: $("#id_deta_pago").val()
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                success: function (data) {
                    if (trimAll(data) === "bien") {
                        alert("Operacion Realizada Exitosamente");
                        $("#btn_guardarReci").prop('disabled', false);
                        $("#btn_guardarDet").prop('disabled', false);
                        $("#btn_nuevoDet").prop('disabled', true);
                        $("#btn_Recibo").prop('disabled', true);
                        $('#btn_ImprRec').hide();
                        $('#btn_Anular').hide();
                        $("#txt_nRecibo").val("");

                        $("#txt_fecha_Pago").prop('disabled', false);
                        $("#cbx_mesPag").prop('disabled', false);
                        $("#txt_fecha_PagoHas").prop('disabled', false);
                        $("#txt_obserDetPag").prop('disabled', false);
                        $("#cbx_Pagen").prop('disabled', false);
                        $.aniosDeta();
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }
    });

    $("#btn_Recibo").on("click", function () {

        $("#VentRecibo").modal();

        if ($('#txt_nRecibo').val() === "") {

            var datos = {
                ope: "BusValRec",
                cod: $("#txt_idRecib").val(),
                iddet: $("#id_deta_pago").val()
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                success: function (data) {
                    if (trimAll(data) === "bien") {
                        $("#btn_guardarReci").prop('disabled', false);
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            if ($("#cbx_Pagen").val() === "OFICINA") {
                $.conseRec();
            } else {
                $("#txt_ConRec").val("");
            }


            $("#txt_CuoMes").val($("#cbx_mesPag").val());
            $("#txt_ValRecib").val($("#txt_ValCuota").val());


            var titu = $("#txt_titular").val().split(" - ");

            $("#txt_indenRec").val(titu[0]);
            $("#txt_NomRec").val(titu[1]);

            var pvalmes = $("#txt_ValCuota").val().split(" ");
            var num = parseFloat(pvalmes[1].replace(".", "").replace(".", "").replace(",", "."));
            $.NumLetr(num);

            $("#btn_guardarReci").prop('disabled', false);
            $("#txt_ConRec").prop('disabled', false);
            $('#btn_ImprRec').hide();
            $('#btn_Anular').hide();

        } else {
            $.MostrarRecibo($('#txt_nRecibo').val());
        }



    });

    $("#btn_nuevoDet").on("click", function () {

        $("#btn_nuevoDet").prop('disabled', true);
        $("#btn_guardarDet").prop('disabled', false);


        $("#txt_fecha_Pago").prop('disabled', false);
        $("#cbx_mesPag").prop('disabled', false);
        $("#txt_fecha_PagoHas").prop('disabled', false);
        $("#txt_nRecibo").prop('disabled', false);
        $("#txt_obserDetPag").prop('disabled', false);


        $("#txt_fecha_Pago").val('');
        $("#txt_fecha_PagoHas").val('');
        $("#txt_nRecibo").val('');
        $("#txt_obserDetPag").val('');
        $("#cbx_mesPag").selectpicker("val", ' ');
    });

    //BOTON GUARDAR AÑO-
    $("#btn_guardarAnio").on("click", function () {


        if ($('#txt_anio').val() == "") {
            alert("Ingrese el Año a Ingresar");
            $('#txt_anio').focus();
            return;

        }

        var pvalanio = $("#txt_ValAnAnio").val().split(" ");
        var valanio = pvalanio[1].replace(".", "").replace(".", "").replace(",", ".");

        var pvalmes = $("#txt_ValMeAnio").val().split(" ");
        var valmes = pvalmes[1].replace(".", "").replace(".", "").replace(",", ".");

        var datos = {
            ope: 'inseranio',
            anio: $("#txt_anio").val(),
            idpre: $("#id_prevision").val(),
            vani: valanio,
            vmes: valmes,
            fpag: $("#CbFormPagoAnio").val(),
            fech: $("#txt_fecha_pagoAnio").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            success: function (data) {
                if (data === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.anios();
                    $("#btn_nuevoAnio").prop('disabled', false);
                    $("#btn_guardarAnio").prop('disabled', true);

                    $("#txt_anio").prop('disabled', true);



                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });

    $("#Anx_Doc").on("click", function () {

        var des = $("#txt_DesAnex").val();
        var name = $("#Name_File").val();

        if (des === " " || des === "") {
            alert("Por Favor Ingrese una Descripción del Documento...");
            return;
        } else {
            $("#From_DescriDocu").removeClass("has-error");
        }


        $.UploadDoc();
        $.AddArchivos();

    });

    $("#txt_ConRec").on("change", function () {

        var datos = {
            ope: "verfConseReciPrev",
            cod: $("#txt_ConRec").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {
                if (data === 1) {
                    alert("Este Consecutivo ya ha sido Registrado");
                    $('#txt_ConRec').focus();
                    $("#txt_ConRec").val("");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#txt_Cod").on("change", function () {

        var datos = {
            ope: "verfConsePrev",
            cod: $("#txt_Cod").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {
                if (data === 1) {
                    alert("Este Número de Contrato ya ha sido Registrado");
                    $('#txt_Cod').focus();
                    $("#txt_Cod").val("");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    //BOTON GUARDAR DETALLE PAGO-
    $("#btn_guardarDet").on("click", function () {


        if ($('#cbx_mesPag').val() === "") {
            alert("Seleccione el Mes a Pagar");
            $('#cbx_mesPag').focus();
            return;

        }
        if ($('#txt_fecha_PagoHas').val() === "") {
            alert("Ingrese La Fecha de Vencimiento");
            $('#txt_fecha_PagoHas').focus();
            return;

        }

        if ($('#cbx_Pagen').val() === "") {
            alert("Seleccione donde fue realizado en Pago");
            $('#cbx_Pagen').focus();
            return;
        }


        if ($('#cbx_mesPag').val() === null) {
            alert("Seleccione el Mes a Pagar");
            $('#cbx_mesPag').focus();
            return;
        }

        var pvalmes = $("#txt_ValCuota").val().split(" ");
        var valmes = pvalmes[1].replace(".", "").replace(".", "").replace(",", ".");


        var datos = {
            ope: 'InserDetaAnio',
            anio: $("#txt_anioSel").val(),
            fpag: $("#txt_fecha_PagoDet").val(),
            valp: valmes,
            mesp: $("#cbx_mesPag").val(),
            fven: $("#txt_fecha_PagoHas").val(),
            recp: $("#txt_nRecibo").val(),
            obs: $("#txt_obserDetPag").val(),
            sal: $("#saldo").val(),
            pag: $("#cbx_Pagen").val(),
            prev: $("#id_prevision").val(),
            acc: $("#acc_detpago").val(),
            id: $("#id_deta_pago").val(),
            ncob: $("#txt_NCobrador").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            success: function (data) {
                pardat = data.split("-");
                if (pardat[0] === "bien") {
                    $("#id_deta_pago").val(pardat[1]);
                    alert("Datos Guardados Exitosamente");
                    $.aniosDeta();
                    $("#btn_nuevoDet").prop('disabled', false);
                    $("#btn_Recibo").prop('disabled', false);
                    $("#btn_guardarDet").prop('disabled', true);

                    $("#txt_anioSel").prop('disabled', true);
                    $("#txt_fecha_Pago").prop('disabled', true);
                    $("#cbx_mesPag").prop('disabled', true);
                    $("#txt_fecha_PagoHas").prop('disabled', true);
                    $("#txt_nRecibo").prop('disabled', true);
                    $("#txt_obserDetPag").prop('disabled', true);

                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });

    //BOTON GUARDAR RECIBO-
    $("#btn_guardarReci").on("click", function () {


        if ($('#txt_ConRec').val() === "") {
            alert("Ingrese el Número del Recibo");
            $('#txt_ConRec').focus();
            return;
        }

        if ($('#txt_NomRec').val() === "") {
            alert("Ingrese el Nombre");
            $('#txt_NomRec').focus();
            return;
        }

        if ($('#txt_CuoMes').val() === "") {
            alert("Ingrese Los Meses a Pagar");

            return;
        }

        if ($("#cbx_Pagen").val() === "OFICINA") {
            $.conseRec();
        }

        var pvalmes = $("#txt_ValRecib").val().split(" ");
        var valmes = pvalmes[1].replace(".", "").replace(".", "").replace(",", ".");

        var datos = {
            ope: 'InserRecibPago',
            crec: $("#consRec").val(),
            codr: $("#txt_ConRec").val(),
            valp: valmes,
            frec: $("#txt_fecha_RecPag").val(),
            inde: $("#txt_indenRec").val(),
            nomb: $("#txt_NomRec").val(),
            vall: $("#txt_ValLetra").val(),
            conc: $("#txt_ConcepRec").val(),
            cmes: $("#txt_CuoMes").val(),
            fpag: $("#cbx_Fpago").val(),
            nche: $("#txt_Ncheque").val(),
            nban: $("#txt_BancoRec").val(),
            anio: $("#txt_anioSel").val(),
            paen: $("#cbx_Pagen").val(),
            prev: $("#id_prevision").val(),
            deta: $("#id_deta_pago").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            success: function (data) {
                var padata = data.split("/");
                if (trimAll(padata[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $('#txt_idRecib').val(padata[1]);
                    $('#txt_nRecibo').val(padata[2]);
                    $("#btn_guardarReci").prop('disabled', true);
                    $('#btn_ImprRec').show();
                    $('#btn_Anular').show();
                    $.aniosDeta();
                    window.open("PDF_ReciboPago.php?id=" + $('#txt_idRecib').val() + "", '_blank');
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {


        if ($('#txt_Cod').val() == "") {
            alert("Ingrese el Codigo de la Requisicion");
            $('#txt_Cod').focus();
            return;
        }

        if ($('#CbPlanExe').val() == "") {
            alert("Ingrese El Plan");
            $('#CbPlanExe').focus();
            return;
        }

        if ($('#CbTipVinc').val() == "") {
            alert("Ingrese el Tipo de Vinculación");
            $('#CbTipVinc').focus();
            return;
        }

        if ($('#txt_iden').val() == "") {
            alert("Ingrese La Identificacion del Titular");
            $('#txt_iden').focus();
            return;
        }


        $.Dta_GrupBas();
        $.Dta_GrupSec();
        $.Dta_Anexos();

        var pvalAnual = $("#txt_ValAn").val().split(" ");
        var valAnual = pvalAnual[1].replace(".", "").replace(".", "").replace(",", ".");

        var pvalmes = $("#txt_ValMe").val().split(" ");
        var valmes = pvalmes[1].replace(".", "").replace(".", "").replace(",", ".");


        var datos = "codigo=" + $("#txt_Cod").val() + "&fcreac=" + $("#txt_fecha_Cre").val()
                + "&txt_Ciuda=" + $("#txt_Ciuda").val() + "&CbPlanExe=" + $("#CbPlanExe").val()
                + "&CbTipVinc=" + $("#CbTipVinc").val() + "&txt_Empre=" + $("#txt_Empre").val()
                + "&txt_iden=" + $("#txt_iden").val() + "&txt_NomCli=" + $("#txt_NomCli").val()
                + "&CbSexo=" + $("#CbSexo").val() + "&txt_FecNac=" + $("#txt_FecNac").val()
                + "&txt_DirCli=" + $("#txt_Dir").val() + "&txt_TelCli=" + $("#txt_Tel").val()
                + "&txt_Dirbarrio=" + $("#txt_Dirbarrio").val() + "&txtemail=" + $("#txtemail").val()
                + "&CbTipClien=" + $("#CbTipClien").val() + "&CbDirRecaudo=" + $("#CbDirRecaudo").val()
                + "&txt_OtrDir=" + $("#txt_OtrDir").val() + "&txt_IdEmpl=" + $("#txt_IdEmpl").val()
                + "&txt_NomEmpl=" + $("#txt_NomEmpl").val() + "&txt_DirEmpl=" + $("#txt_DirEmpl").val()
                + "&txt_CiuEmpl=" + $("#txt_CiuEmpl").val() + "&txt_DepEmpl=" + $("#txt_DepEmpl").val()
                + "&txt_TelEmpl=" + $("#txt_TelEmpl").val() + "&txt_ValAn=" + valAnual + "&txt_ValMe=" + valmes
                + "&CbFormPago=" + $("#CbFormPago").val() + "&txt_fecha_pago=" + $("#txt_fecha_pago").val()
                + "&txt_Asesor=" + $("#txt_Asesor").val() + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val()
                + "&conse=" + $("#cons").val() + "&txt_nuevo=" + $("#txt_nuevo").val() + "&txt_obser=" + $("#txt_obser").val();


        var Alldata = datos + Dat_GrupBas + Dat_GrupSec + Dat_Anexos;

        $.ajax({
            type: "POST",
            url: "GuardarPrevi.php",
            data: Alldata,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.Previ();

                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);


                }
            },
            beforeSend: function () {
                $('#cargando').modal('show');
            },
            complete: function () {
                $('#cargando').modal('hide');
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
});
///////////////////////
