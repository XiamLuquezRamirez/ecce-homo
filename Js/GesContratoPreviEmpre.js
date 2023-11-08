$(document).ready(function() {
    var Order = "b.nom_proyect ASC";
    // $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_serv").addClass("start active open");
    $("#menu_serv_prevEmpr").addClass("active");

    var Dat_Anexos = "";


    $("#txt_fecha_RecPag,#txt_FecNacBenef,#txt_FecAfil,#txt_fecha_pagoAnio,#txt_fecha_Cre, #txt_fecha_pago,#txt_fecha_PagoDet,#txt_fecha_Pago,#txt_fecha_PagoHas").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });

    $("#txt_FecCont,#txt_FecNac").datepicker({
        format: 'dd/mm/yyyy',
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


    $("#CbParentescoBenef,#CbEstadoBenefi,#CbEstado,#cbx_Pagen,#CbFormPagoAnio,#cbx_Fpago,#cbx_mesPag,#Cbanios,#CbFormPagoC,#CbPlanExeC,#CbTipVincC,#CbPlanExe,#CbTipVinc,#CbTipClien,#CbSexo,#CbDirRecaudo,#CbParenGruBas,#CbSexoGrupBas,#CbEstGrupBas,#CbParenGruSec,#CbSexoGrupSec,#CbEstaGrupSec,#CbFormPago").selectpicker();


    var contAnios = 0;
    var contGruSec = 0;
    var vtotalg = 0;
    var Dat_GrupBas = "";
    var Dat_GrupSec = "";


    $.extend({
        Previ: function() {
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
                url: "PagPrevisionEmpre.php",
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
        },
        editDatAfil: function(cod) {


            $('#accAfi').val("2");

            $("#btn_nuevo2Afil").prop('disabled', true);
            $("#btn_guardarAfil").prop('disabled', false);
            var datos = {
                ope: "BusqEditAfil",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#idAfilia").val(cod);
                    $("#txt_IdentiAfi").val(data['Cedula_cliente']);
                    $("#txt_NombreAfi").val(data['Nombres_cliente']);
                    $("#txt_ApelliAfi").val(data['Apellidos_cliente']);
                    $("#txt_NContratoAfi").val(data['contrato_cliente']);
                    $('#CbTipPlan').val(data["idPlan_cliente"]).change();
                    $("#CbEstado").selectpicker("val", data['Estado_cliente']);
                    $("#txt_DirAfi").val(data['direccion_cliente']);
                    $("#txt_BarrAfi").val(data['barrio_cliente']);
                    $("#txt_TelAfi").val(data['telefono_cliente']);
                    $("#txt_CelAfi").val(data['celular_cliente']);
                    $("#txt_emailAfi").val(data['correo_cliente']);
                    $("#txt_FecAfil").val(data['Fecha_ingreso_cliente']);
                    $("#txt_ValCuotAfil").val("$ " + number_format2(data['Cuota_cliente'], 2, ',', '.'));
                    $("#CbTipClien").selectpicker("val", data['tipo_cliente']);
                    $("#txt_FecNac").val(data['fecha_nacimiento']);
                    $("#CbSexo").selectpicker("val", data['sexo']);
                    $("#CbTipVinc").selectpicker("val", data['tipo_vinculacion']);
                     $("#txt_Empre").val(data['empresa_anterior']);
                     $("#txt_FecCont").val(data['fecha_creacion']);
                     $("#txt_Asesor").val(data['asesor']);
                    
                },

                error: function(error_messages) {
                    //alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsiveAfiliado").modal();
            $("#btn_AddAnexo").prop('disabled', false);
            $('#mopc').show();
            $('#DivEstado').show();


        },
        editDatBenef: function(cod) {


            $('#accBenef').val("2");

            $("#btn_nuevo2Benef").prop('disabled', true);
            $("#btn_guardarBenefi").prop('disabled', false);
            var datos = {
                ope: "BusqEditBenefi",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#text_idBenef").val(cod);
                    $("#txt_NombreBenef").val(data['nombre_beneficiario']);
                    $("#txt_ApelliBenef").val(data['apellido_beneficiario']);
                    $("#txt_Edad").val(data['nacimiento_beneficiario']);
                    $("#CbTbenefi").val(data['tipo_benefi']);
                    $("#txt_ciuResi").val(data['ciudad_beneficiario']);
                    $("#CbParentescoBenef").selectpicker("val", data['parentesco_beneficiario']);
                    $("#CbEstadoBenefi").selectpicker("val", data['estado_beneficiario']);

                },

                error: function(error_messages) {
                    //alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsiveBeneficioarios").modal();
            $('#DivEstadoBenef').show();


        },
        editAfi: function(codempre) {

            $("#idmepre").val(codempre);
            $("#busqAfi").val("1");
            $("#busq_centro").val("");

            var datos = {
                opc: "PagAfiliadosPrevi",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val(),
                ord: Order,
                codemp: $("#idmepre").val()
            };

            $.ajax({
                type: "POST",
                url: "PagAfiliadosPrevi.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_TipDoc').html(data['cad']);
                    $('#bot_TipDoc').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                    $('#LabNomEmpre').html("<b>Nombre Empresa:</b> " + data['NombEmpr'] + " &nbsp;&nbsp;&nbsp; <b>Numero de Afiliados:</b> " + data['contador'] + " &nbsp;&nbsp;&nbsp;<b>Valor Total:</b> $ " + data['Cuota']);


                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $('#DivNombEmpr').show();
            $('#btn_atras').show();
            $('#btn_nuevoAfil').show();
            $('#btn_PrintAfil').show();
            $('#atitulo2').show(100).html("<a href='#tab_01' data-toggle='tab' id='atitulo2'>Listado de Afiliados</a>");

        },
        Beneficiarios: function(codAfil) {

            $("#idAfilia").val(codAfil);
            $("#busqAfi").val("2");
            $("#busq_centro").val("");

            var datos = {
                opc: "PagBeneficiariosPrevi",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val(),
                ord: Order,
                codAfil: $("#idAfilia").val()
            };

            $.ajax({
                type: "POST",
                url: "PagBeneficiariosPrevi.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_TipDoc').html(data['cad']);
                    $('#bot_TipDoc').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                    $('#P_Ncontrato').html(data['contra']);
                    $('#P_cedula').html(data['ced']);
                    $('#P_nombre').html(data['nom']);
                    $('#P_fafil').html(data['fec']);
                    $('#P_telef').html(data['tel']);
                    $('#P_dir').html(data['dir']);
                    $('#P_Empre').html(data['nempr']);
                    $('#P_Estado').html(data['est']);
                    $('#P_NAfil').html(data['contador']);

                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $('#DivNombEmpr').hide();
            $('#DatAfil').show();
            $('#btn_nuevobenef').show();
            $('#btn_nuevoAfil').hide();
            $('#btn_PrintAfil').hide();
            $('#btn_PrintBenef').show();
            $('#btn_atras').hide();
            $('#btn_atras1').show();

            $('#atitulo2').show(100).html("<a href='#tab_01' data-toggle='tab' id='atitulo2'>Listado de Beneficiarios</a>");

        },
        busqContrato: function(val) {

            var datos = {
                opc: "BusqDepe",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val(),
                ord: Order,
                codemp: $("#idmepre").val(),
                codAfil: $("#idAfilia").val()

            };
            var url = "";
            if ($("#busqAfi").val() === "1") {
                url = "PagAfiliadosPrevi.php";
            } else if ($("#busqAfi").val() === "2") {
                url = "PagBeneficiariosPrevi.php";
            } else {
                url = "PagPrevisionEmpre.php";
            }

            $.ajax({
                type: "POST",
                url: url,
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
        },
        busqCli: function(val) {


            var datos = {
                ope: "VentClientes",
                bus: val
            }


            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#tab_Clientes").show(100).html(data['tabla_terceros']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        anios: function() {

            var datos = {
                ope: "tab_anios",
                cod: $("#id_prevision").val()
            };


            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#tb_Anios").show(100).html(data['tabla_anios']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        aniosDeta: function() {

            var datos = {
                ope: "tab_aniosDetaEmpresa",
                anio: $("#txt_anioSel").val(),
                empr: $("#idmepre").val()
            };
            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#tb_DetaxAnio").show(100).html(data['tabla_aniosDet']);
                    $("#val_ingreso").html('$ ' + number_format2(data['valor'], 2, ',', '.'));
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }

            });



        },
        DeleteAfil: function(id) {

            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {
                var datos = {
                    ope: "del_afiliado",
                    cod: id
                };

                $.ajax({
                    type: "POST",
                    url: "All.php",
                    data: datos,
                    success: function(data) {
                        if (trimAll(data) === "bien") {
                            alert("Operacion Realizada Exitosamente");
                        $.editAfi($("#idmepre").val());
                        }
                    },
                    error: function(error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        PrintPrev: function(val) {
            window.open("PDF_ContPrevi.php?id=" + val + "", '_blank');
        },
        busqActi: function(val) {


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
                success: function(data) {
                    $("#tab_Actividades").show(100).html(data['tabla_actividades']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        SelCli: function(val) {
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
        SelNece: function(val) {
            var par = val.split("//");

            $("#txt_id_Nec").val(par[0]);
            $("#txt_nomNec").val(par[1]);
            $("#txt_Cant").val("1");
            $("#txt_Val").val(par[2]);
            $('#necesidad').modal('toggle');
        },

        AddGrupBas: function() {

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
        UpdGrupBas: function() {

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
        UpdGrupSec: function() {

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
        limpiarGrupBas: function() {

            $("#txt_IdGruBas").val("");
            $('#txt_NomGruBas').val("");
            $("#CbParenGruBas").selectpicker("val", " ");
            $("#CbSexoGrupBas").selectpicker("val", " ");
            $("#CbEstGrupBas").selectpicker("val", " ");
            $('#txt_EdadGrupBas').val("");
            $('#txt_CiudResGrupBas').val("VALLEDUPAR");

        },
        reordenarGrupBas: function() {
            var num = 1;
            $('#tb_GrupBas tbody tr').each(function() {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_GrupBas tbody input').each(function() {
                $(this).attr('id', "GrupBas" + num);
                num++;
            });

        },
        QuitarGrupBas: function(id_fila, valor) {
            $('#' + id_fila).remove();
            $.reordenarGrupBas();
            contGruBas = $('#contGruBas').val();
            contGruBas = contGruBas - 1;
            $("#contGruBas").val(contGruBas);

        },
        EditGrupBas: function(id_fila) {

            $("#FilaEdit").val(id_fila);

            $('#' + id_fila).find(':input').each(function() {
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
        EditGrupSec: function(id_fila) {

            $("#FilaEdit").val(id_fila);

            $('#' + id_fila).find(':input').each(function() {
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
        AddGrupSec: function() {

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
        limpiarGrupSec: function() {

            $("#txt_IdGruSec").val("");
            $('#txt_NomGruSec').val("");
            $("#CbParenGruSec").selectpicker("val", " ");
            $("#CbSexoGrupSec").selectpicker("val", " ");
            $("#CbEstaGrupSec").selectpicker("val", " ");
            $('#txt_EdadGrupSec').val("");
            $('#txt_CiudResGrupSec').val("VALLEDUPAR");

        },
        reordenarGrupSec: function() {
            var num = 1;
            $('#tb_GrupSec tbody tr').each(function() {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_GrupSec tbody input').each(function() {
                $(this).attr('id', "GrupSec" + num);
                num++;
            });

        },
        QuitarGrupSec: function(id_fila, valor) {
            $('#' + id_fila).remove();
            $.reordenarGrupSec();
            contGruSec = $('#contGruSec').val();
            contGruSec = contGruSec - 1;
            $("#contGruSec").val(contGruSec);

        },
        habiCobr: function() {
            if ($('#cbx_Pagen').val() === "COBRADORES") {
                $("#txt_NCobrador").prop('disabled', false);
            } else {
                $("#txt_NCobrador").prop('disabled', true);

            }

        },
        AddAnio: function() {
            $("#anios").modal();

        },
        AddDetPago: function() {

            $("#acc_detpago").val("1");
            $("#DetallPago").modal();

            $("#btn_nuevoDet").prop('disabled', true);
            $("#btn_guardarDet").prop('disabled', false);


            $("#txt_fecha_Pago").prop('disabled', false);
            $("#cbx_mesPag").prop('disabled', false);
            $("#txt_fecha_PagoHas").prop('disabled', false);
            //$("#txt_nRecibo").prop('disabled', false);
            $("#txt_obserDetPag").prop('disabled', false);


            $("#txt_fecha_Pago").val('');
            $("#txt_fecha_PagoHas").val('');
            $("#txt_nRecibo").val('');
            $("#txt_obserDetPag").val('');
            $("#cbx_mesPag").selectpicker("val", ' ');


            $("#txt_ValCuota").val("$ " + number_format2($("#txt_ValReal").val(), 2, ',', '.'));
            // $("#txt_ValReal").val($("#txt_ValReal").val());


        },
        AddPago: function(id) {
            $("#idmepre").val(id);

            var datos = {
                ope: "BusqPreviEmpr",
                cod: id
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#P_InfNit").html(data['Nit_empresa']);
                    $("#P_InfNomEmpr").html(data['Nombre_empresa']);
                    $("#txt_titular").val(data['Nit_empresa'] + " - " + data['Nombre_empresa'] + " - " + data['Direccion_empresa'] + " - " + data['Telefono_empresa']);
                    $("#P_InfCliAnt").html(data['conta']);
                    $("#txt_Nafil").val(data['conta']);
                    $("#P_InfVtotal").html("$ " + number_format2(data['tot'], 2, ',', '.'));
                    $("#txt_ValReal").val(data['tot']);

                    $("#txt_ValCuota").val("$ " + number_format2(data['tot'], 2, ',', '.'));
                    $("#tb_Anios").show(100).html(data['tabla_anios']);
                }

            });



            $('#divDeta').hide();
            $('#tab_03_pp').show();
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").removeClass("active in");
            $("#tab_02_pp").removeClass("active in");
            $("#tab_03").addClass("active in");
            $("#tab_03_pp").addClass("active in");





        },
        editPrev: function(cod) {
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
                success: function(data) {

                    $("#txt_id").val(cod);

                    $("#txt_Cod").val(data['ncontrato']);
                    $("#txt_fecha_Cre").val(data['fecha_cre']);
                    $("#txt_Ciuda").val(data['ciudad']);
                    $('#CbPlanExe').val(data["plan"]).change();
                    $("#CbTipVinc").val(data['tipo_vinc']);
                    $("#txt_Empre").val(data['nompad_req']);
                    $("#txt_NomMadr").val(data['empresa']);
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
        CalCuota: function() {

            var meses = $("#cbx_mesPag").val();
            // var valor = parseFloat(pvalmes[1].replace(".", "").replace(".", "").replace(",", "."));

            var valmes = parseFloat($("#txt_ValReal").val());
            var vtotal = 0;
            for (var i = 0; i <= meses.length - 1; i++) {
                vtotal += valmes;
            }
            $("#txt_ValCuota").val("$ " + number_format2(vtotal, 2, ',', '.'));

        },

        VerPrev: function(cod) {

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
                success: function(data) {

                    $("#txt_id").val(cod);

                    $("#txt_Cod").val(data['ncontrato']);
                    $("#txt_fecha_Cre").val(data['fecha_cre']);
                    $("#txt_Ciuda").val(data['ciudad']);
                    $('#CbPlanExe').val(data["plan"]).change();
                    $("#CbTipVinc").val(data['tipo_vinc']);
                    $("#txt_Empre").val(data['nompad_req']);
                    $("#txt_NomMadr").val(data['empresa']);
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
        AbrirClien: function() {

            var datos = {
                ope: "VentClientes",
                bus: ""
            };


            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#tab_Clientes").show(100).html(data['tab_cli']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#clientes").modal();


        },
        EditDetPagos: function(cod) {

            $("#id_deta_pago").val(cod);

            $("#acc_detpago").val("2");

            var datos = {
                ope: "VerDetallePagoEmpre",
                cod: cod,
                ida: $("#txt_anioSel").val()
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#txt_fecha_PagoDet").val(data['fpag']);

                    $("#txt_ValCuota").val("$ " + number_format2(data['val'], 2, ',', '.'));
                    $("#txt_ValReal").val(data['val']);

                    var mes = data["mes"].split(",");
                    $("#cbx_mesPag").val(mes).change();
                    $("#txt_fecha_PagoHas").val(data['fven']);
                    if (data['pagoen'] === null) {
                        $("#cbx_Pagen").selectpicker("val", " ");
                    } else {
                        $("#cbx_Pagen").selectpicker("val", data['pagoen']);
                    }

                    $("#txt_obserDetPag").val(data['observ']);
                    $("#txt_nRecibo").val(data['recibo']);
                    $("#txt_NCobrador").val(data['ncobrador']);
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
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#DetallPago").modal();



        },
        MostrarRecibo: function(cod) {

            var datos = {
                ope: "VerDetalleRecibo",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
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
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#VentRecibo").modal();
            $("#btn_guardarReci").prop('disabled', true);
            $('#btn_ImprRec').show();
            $('#btn_Anular').show();

        },
        AbrirNece: function() {

            var datos = {
                ope: "VentNece",
                bus: ""
            }


            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#tab_Nece").show(100).html(data['tab_cli']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#necesidad").modal();


        },
        MostrarBenef: function() {

            var datos = {
                ope: "mostbenefi",
                cod: $("#id_prevision").val()
            };


            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#tab_benbas").html(data['CadGrupBas']);
                    $("#tab_bensec").html(data['CadGrupSec']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#beneficiarios").modal();


        },
        VerDetPagos: function(anio) {

            $("#txt_anioSel").val(anio);
            $('#divDeta').show();

            $.aniosDeta();

        },

        deletPrev: function(cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "GuardarPrevi.php",
                    data: datos,
                    success: function(data) {
                        if (trimAll(data) === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.Previ();
                        }
                    },
                    error: function(error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        EliminarBenef: function(cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    accBenef: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "GuardarPreviEmprBeneficiarios.php",
                    data: datos,
                    success: function(data) {
                        if (trimAll(data) === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.Beneficiarios($("#idAfilia").val());
                        }
                    },
                    error: function(error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        DelDetPagos: function(cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    ope: "deleteDetPagoEmpre",
                    cod: cod,
                    idp: $("#id_prevision").val()
                };

                $.ajax({
                    type: "POST",
                    url: "All.php",
                    data: datos,
                    success: function(data) {
                        if (trimAll(data) === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.aniosDeta();
                        } else if (trimAll(data) === "no") {
                            alert("Este Pago esta relacionado con un Recibo de pago, Verifique...");
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
                nreg: $("#nreg").val(),
                ord: Order,
                codemp: $("#idmepre").val(),
                codAfil: $("#idAfilia").val()

            };
            var url = "";
            if ($("#busqAfi").val() === "1") {
                url = "PagAfiliadosPrevi.php";
            } else if ($("#busqAfi").val() === "2") {
                url = "PagBeneficiariosPrevi.php";
            } else {
                url = "PagPrevisionEmpre.php";
            }

            $.ajax({
                type: "POST",
                url: url,
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

        },
        combopag: function(pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val(),
                ord: Order,
                codemp: $("#idmepre").val(),
                codAfil: $("#idAfilia").val()

            };
            var url = "";
            if ($("#busqAfi").val() === "1") {
                url = "PagAfiliadosPrevi.php";
            } else if ($("#busqAfi").val() === "2") {
                url = "PagBeneficiariosPrevi.php";
            } else {
                url = "PagPrevisionEmpre.php";
            }

            $.ajax({
                type: "POST",
                url: url,
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

        },
        Dta_Anexos: function() {
            Dat_Anexos = "";
            $("#tb_Anexo").find(':input').each(function() {
                Dat_Anexos += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Anexos += "&Long_Anexos=" + $("#contAnexo").val();
        },
        combopag2: function(nre) {

            var datos = {
                nreg: nre,
                bus: $("#busq_centro").val(),
                pag: $("#selectpag").val(),
                ord: Order,
                codemp: $("#idmepre").val(),
                codAfil: $("#idAfilia").val()

            };
            var url = "";
            if ($("#busqAfi").val() === "1") {
                url = "PagAfiliadosPrevi.php";
            } else if ($("#busqAfi").val() === "2") {
                url = "PagBeneficiariosPrevi.php";
            } else {
                url = "PagPrevisionEmpre.php";
            }

            $.ajax({
                type: "POST",
                url: url,
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

        },

        conse: function() {

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
                    success: function(data) {
                        $("#txt_Cod").val(data['StrAct']);
                        $("#cons").val(data['cons']);

                    },
                    error: function(error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });

                //  $('#mopc').hide();

            }

        },
        conseRec: function() {

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
                success: function(data) {
                    $("#txt_ConRec").val(data['StrAct']);
                    $("#consRec").val(data['cons']);

                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            //  $('#mopc').hide();



        },
        NumLetr: function(num) {
            $("#txt_vtotalFact").val(num);
            var datos = {
                num: num
            };


            $.ajax({
                type: "POST",
                url: "numero_letra.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#txt_ValLetra").val(data['letra']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        UploadDoc: function() {
   
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

            var ruta = "upload_AnexoEmpre.php";

            $.ajax({
                async: false,
                url: ruta,
                type: "POST",
                data: archivos,
                contentType: false,
                processData: false,
                success: function(datos)
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
        
        consulanexos: function() {
            
                var datos = {
                ope: "BusqAnexosAfiliados",
                cod: $("#idAfilia").val()
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#tb_Anexo").html(data['Tab_Anexos']);
                }

            });
            
        },
        AddArchivos: function() {
                  
                var datos = {
                txt_DesAnex: $("#txt_DesAnex").val(),
                Src_File: $("#Src_File").val(),
                idAfilia: $("#idAfilia").val(),
                ope: "AddAnexo"

            };
                  
    

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            success: function(data) {
                if (trimAll(data) === "bien") {
                    alert("Datos Guardados Exitosamente");
                      $.consulanexos();           
                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


        },
   
        QuitarAnexo: function(id_fila) {
           if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {
                var datos = {
                    ope: "del_anexo_bene",
                    cod: id_fila
                };

                $.ajax({
                    type: "POST",
                    url: "All.php",
                    data: datos,
                    success: function(data) {
                        if (trimAll(data) === "bien") {
                            alert("Operacion Realizada Exitosamente");
                             $.consulanexos();                              
                        }
                    },
                    error: function(error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        Dta_GrupBas: function() {
            Dat_GrupBas = "";
            $("#tb_GrupBas").find(':input').each(function() {
                Dat_GrupBas += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_GrupBas += "&Long_GrupBas=" + $("#contGruBas").val();

        },
        conseCos: function() {


            var datos = {
                ope: "ConConsecutivo",
                tco: "CONSTANCIAS"
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#txt_CodConst").val(data['StrAct']);
                    $("#consConst").val(data['cons']);

                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
         PrintContrato: function(val) {
            window.open("PDF_ContPreviEmpresarial.php?id=" + val + "", '_blank');
        },
        EnvioNotif: function(IdAfi) {
            $("#txt_IdentiAfiNot").val(IdAfi);
            var datos = {
                ope: "CargaDatAfilNot",
                idaf: IdAfi
               };

              $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                   
                    $("#txt_IdAfiNot").val(data['Cedula_cliente']);
                    $("#txt_NombreAfiNot").val(data['Nombres_cliente']);
                    $("#txt_ApelliAfiNot").val(data['Apellidos_cliente']);
                    $("#txt_NContratoAfiNot").val(data['contrato_cliente']);
                    $("#txt_emailAfiNot").val(data['correo_cliente']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            
             
             $("#responsiveNotificacion").modal();
        },
        Dta_GrupSec: function() {
            Dat_GrupSec = "";
            $("#tb_GrupSec").find(':input').each(function() {
                Dat_GrupSec += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_GrupSec += "&Long_GrupSec=" + $("#contGruSec").val();
        },
        CargaPlanes: function() {
            var datos = {
                ope: "CargaTodDatosPlanes"
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#CbTipPlan").html(data['planes']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });


        },
        

    });

    //======FUNCIONES========\\
    $.Previ();
    $.CargaPlanes();


    $("#txt_iden").on("change", function() {

        var datos = {
            ope: "busDatCli",
            cod: $("#txt_iden").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            dataType: 'JSON',
            success: function(data) {
                $('#txt_id_cli').val(data['id_cli']);
                $('#txt_NomCli').val(data['nom_cli']);
                $("#CbSexo").selectpicker("val", data['sex_cli']);
                $("#txt_FecNac").val(data['fec_cli']);
                $("#txt_DirCli").val(data['dir_cli']);
                $("#txt_TelCli").val(data['tel_cli']);
                $("#txt_nuevo").val(data['cliex']);
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });


    $("#btn_volver").on("click", function() {
        window.location.href = "AdminServicios.php";
    });


    $("#btn_cancelar").on("click", function() {
        window.location.href = 'GesContratoPrevi.php';
    });

    $("#btn_nuevoAnio").on("click", function() {
        $("#btn_nuevoAnio").prop('disabled', true);
        $("#btn_guardarAnio").prop('disabled', false);

        $("#txt_anio").prop('disabled', false);
        $("#txt_anio").val('');
    });

    $("#btn_ImprRec").on("click", function() {
        window.open("PDF_ReciboPagoEmpre.php?id=" + $('#txt_idRecib').val() + "", '_blank');
    });

    $("#btn_atras").on("click", function() {
        $('#btn_atras').hide();
        $('#DivNombEmpr').hide();
        $('#btn_nuevoAfil').hide();
        $('#btn_PrintAfil').hide();

        $.Previ();
        $("#busqAfi").val("0");
        $('#atitulo2').show(100).html("<a href='#tab_01' data-toggle='tab' id='atitulo2'>Listado Empresas</a>");
    });

    $("#btn_atras1").on("click", function() {
        $('#DivNombEmpr').show();
        $('#DatAfil').hide();
        $('#btn_atras1').hide();
        $('#btn_atras').show();
        $('#btn_nuevobenef').hide();
        $('#btn_PrintBenef').hide();
        $('#btn_nuevoAfil').show();
        $('#btn_PrintAfil').show();

        $.editAfi($("#idmepre").val());
        $("#busqAfi").val("1");
        $('#atitulo2').show(100).html("<a href='#tab_01' data-toggle='tab' id='atitulo2'>Listado Afiliados</a>");
    });

    $("#btn_Anular").on("click", function() {
        if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

            var datos = {
                ope: "AnularReciboEmpr",
                cod: $("#txt_idRecib").val(),
                iddet: $("#id_deta_pago").val()
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                success: function(data) {
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
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }
    });

    $("#btn_Recibo").on("click", function() {

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
                success: function(data) {
                    if (trimAll(data) === "bien") {
                        $("#btn_guardarReci").prop('disabled', false);
                    }
                },
                error: function(error_messages) {
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
//            $("#txt_fecha_RecPag").val($("#txt_fecha_PagoDet").val());


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

    $("#btn_Constancia").on("click", function() {

        $("#modalConstancia").modal();
        $('#filaDetaCons1').remove();

        var datos = {
            ope: "cargaCostanciaEmpre",
            cod: $("#id_deta_pago").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            dataType: 'JSON',
            success: function(data) {
                if (data["existe"] === "s") {
                    $("#txt_idCost").val(data['id_constan']);
                    $("#txt_CodConst").val(data['cons_constan']);
                    $("#txt_fecha_CreCos").val(data['fec_cre']);
                    $("#txt_fecha_Cons").val(data['fec_cons']);
                    $("#txt_CiudaCons").val(data['ciudad']);
                    $("#CbConsigConst").selectpicker("val", data["fpago"]);
                    //  $("#txt_vtotalFact").val(data['valor']);

                    $("#tb_ConConst").html(data['CadNec']);
                    $("#contDetCost").val(data['cont']);

                    $("#txt_idenconst").val(data['iden']);
                    $("#txt_NomCliConst").val(data['nom']);
                    $("#txt_TelCliConst").val(data['dir']);
                    $("#txt_TelCliFact").val(data['tel']);


                    $("#btn_guardarCost").prop('disabled', true);
                    $('#btn_impriCost').show();
                    //    $('#btn_Anular').show();
                } else {

                    $.conseCos();
                    $('#txt_CiudaCons').val("VALLEDUPAR");
                    var titu = $("#txt_titular").val().split(" - ");
                    $('#txt_idenconst').val(titu[0]);
                    $('#txt_NomCliConst').val(titu[1]);
                    $('#txt_DirConst').val(titu[2]);
                    $('#txt_TelCliConst').val(titu[3]);

                    var pvalmes = $("#txt_ValCuota").val().split(" ");
                    var num = parseFloat(pvalmes[1].replace(".", "").replace(".", "").replace(",", "."));
                    var concep = "PAGO P.A.E.E DEL MES DE " + $("#cbx_mesPag").val() + " DEL " + $("#txt_anioSel").val();
                    var contDet = 0;

                    contDet++;

                    var fila = '<tr class="selected" id="filaDetaCons' + contDet + '" >';

                    fila += "<td>" + contDet + "</td>";
                    fila += "<td>" + concep + "</td>";
                    fila += "<td>" + $("#txt_ValCuota").val() + "</td>";

                    fila += "<td style='display:none;'><input type='hidden' id='DetallCons" + contDet + "' name='DetallCons' value='' />"
                            + "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";


                    $('#tb_ConConst').append(fila);
                    $("#gtotalcost").html($("#txt_ValCuota").val());
                    $('#txt_vtotalConst').val(num);


                }

            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });

    $("#btn_nuevoAfil").on("click", function() {
        $('#accAfi').val("1");

        $("#txt_IdentiAfi").val("");
        $("#txt_NombreAfi").val("");
        $("#txt_ApelliAfi").val("");
        $("#txt_NContratoAfi").val("");
        $("#CbTipPlan").select2("val", " ");
        $("#txt_DirAfi").val("");
        $("#txt_BarrAfi").val("");
        $("#txt_TelAfi").val("");
        $("#txt_CelAfi").val("");
        $("#txt_emailAfi").val("");
        $("#txt_FecAfil").val("");
        $("#txt_ValCuotAfil").val("$ 0,00");

        $("#btn_nuevo2Afil").prop('disabled', true);
        $("#btn_guardarAfil").prop('disabled', false);

        $("#txt_IdentiAfi").prop('disabled', false);
        $("#txt_NombreAfi").prop('disabled', false);
        $("#txt_ApelliAfi").prop('disabled', false);
        $("#txt_NContratoAfi").prop('disabled', false);
        $("#CbTipPlan").prop('disabled', false);
        $("#txt_DirAfi").prop('disabled', false);
        $("#txt_BarrAfi").prop('disabled', false);
        $("#txt_TelAfi").prop('disabled', false);
        $("#txt_CelAfi").prop('disabled', false);
        $("#txt_emailAfi").prop('disabled', false);
        $("#txt_FecAfil").prop('disabled', false);
        $("#txt_ValCuotAfil").prop('disabled', false);

        $("#responsiveAfiliado").modal();
        $('#mopc').show();
        $('#DivEstado').hide();
        //   $.CargaPlanes();

    });

    $("#btn_AddAnexo").on("click", function() {
        
        $.consulanexos();
        $("#txt_DesAnex").val("");
        $("#archivos").val("");          

        $("#responsiveAnexos").modal();
        
    });

 
    
    
    $("#Anx_Doc").on("click", function() {
         if ($('#archivos').val() === "") {
            alert("Seleccione el Archivo a subir");
         
            return;
        }
       $.UploadDoc();
       $.AddArchivos();
        
    });

    $("#btn_nuevobenef").on("click", function() {
        $('#accBenef').val("1");

        $("#txt_NombreBenef").val("");
        $("#txt_ApelliBenef").val("");
        $("#txt_FecNacBenef").val("");
        $("#CbParentescoBenef").selectpicker("val", '');


        $("#btn_nuevo2Benef").prop('disabled', true);
        $("#btn_guardarBenefi").prop('disabled', false);

        $("#responsiveBeneficioarios").modal();
//        $('#DivEstadoBenef').hide();


    });

    $("#btn_nuevo2Benef").on("click", function() {
        $('#accBenef').val("1");

        $("#txt_NombreBenef").val("");
        $("#txt_ApelliBenef").val("");
        $("#txt_FecNacBenef").val("");
        $("#CbParentescoBenef").selectpicker("val", '');


        $("#btn_nuevo2Benef").prop('disabled', true);
        $("#btn_guardarBenefi").prop('disabled', false);

        //  $("#responsiveBeneficioarios").modal();
        $('#DivEstadoBenef').hide();


    });

    $("#btn_nuevo2Afil").on("click", function() {
        $('#accAfi').val("1");

        $("#txt_IdentiAfi").val("");
        $("#txt_NombreAfi").val("");
        $("#txt_ApelliAfi").val("");
        $("#txt_NContratoAfi").val("");
        $("#CbTipPlan").select2("val", " ");
        $("#txt_DirAfi").val("");
        $("#txt_BarrAfi").val("");
        $("#txt_TelAfi").val("");
        $("#txt_CelAfi").val("");
        $("#txt_emailAfi").val("");
        $("#txt_FecAfil").val("");
        $("#txt_ValCuotAfil").val("$ 0,00");

        $("#btn_nuevo2Afil").prop('disabled', true);
        $("#btn_guardarAfil").prop('disabled', false);
         $("#btn_AddAnexo").prop('disabled', true);

        $("#txt_IdentiAfi").prop('disabled', false);
        $("#txt_NombreAfi").prop('disabled', false);
        $("#txt_ApelliAfi").prop('disabled', false);
        $("#txt_NContratoAfi").prop('disabled', false);
        $("#CbTipPlan").prop('disabled', false);
        $("#txt_DirAfi").prop('disabled', false);
        $("#txt_BarrAfi").prop('disabled', false);
        $("#txt_TelAfi").prop('disabled', false);
        $("#txt_CelAfi").prop('disabled', false);
        $("#txt_emailAfi").prop('disabled', false);
        $("#txt_FecAfil").prop('disabled', false);
        $("#txt_ValCuotAfil").prop('disabled', false);

        $.CargaPlanes();
        $('#mopc').show();
        $('#DivEstado').hide();

    });

    $("#btn_nuevoDet").on("click", function() {

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
    $("#btn_guardarAnio").on("click", function() {

        var anio = $('#txt_anio').val();
        var flag = 0;

        $("#tb_Anios").find(':input').each(function() {
            if ($(this).val() === anio) {
                flag = 1;
            }
        });


        if (anio === "") {
            alert("Ingrese el Año a Ingresar");
            $('#txt_anio').focus();
            return;

        }

        if (flag === 1) {
            alert("El año " + anio + " ya se encuentra registrado, Verifique...");
            return;

        }

        contAnios = $("#contAnios").val();

        contAnios++;

        var fila = '<tr class="selected">'
                + "<td class=\"highlight\">"
                + anio + " "
                + "</td>"
                + "<td class=\"highlight\"><input type='hidden' id='idanios" + contAnios + "' name='GrupSec' value='" + anio + "' />"
                + "<a  onclick=\"$.VerDetPagos('" + anio + "')\"  class=\"btn default btn-xs blue\">"
                + "<i class=\"fa fa-search\"></i> Ver</a>"
                + "</td>"
                + "</tr>";

        $('#tb_Anios').append(fila);
        $('#txt_anio').val("");
        $("#contAnios").val(contAnios);
    });



    $("#btn_impriCost").on("click", function() {
        window.open("PDF_ConstanciaEmpre.php?id=" + $('#txt_idCost').val() + "", '_blank');
    });

    $("#txt_ConRec").on("change", function() {

        var datos = {
            ope: "verfConseReciPrev",
            cod: $("#txt_ConRec").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            dataType: 'JSON',
            success: function(data) {
                if (data === 1) {
                    alert("Este Consecutivo ya ha sido Registrado");
                    $('#txt_ConRec').focus();
                    $("#txt_ConRec").val("");
                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#txt_NContratoAfi").on("change", function() {

        var datos = {
            ope: "verfNcontratoAfi",
            cod: $("#txt_NContratoAfi").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            dataType: 'JSON',
            success: function(data) {
                if (data === 1) {
                    alert("Este Número de Contrato ya ha sido Registrado");
                    $('#txt_NContratoAfi').focus();
                    $("#txt_NContratoAfi").val("");
                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#txt_IdentiAfi").on("change", function() {

        var datos = {
            ope: "verfIdentAfil",
            cod: $("#txt_IdentiAfi").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            dataType: 'JSON',
            success: function(data) {
                if (data === 1) {
                    alert("Este Número de Identificación ya ha sido Registrado");
                    $('#txt_IdentiAfi').focus();
                    $("#txt_IdentiAfi").val("");
                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    //BOTON GUARDAR DETALLE PAGO-
    $("#btn_guardarDet").on("click", function() {


        if ($('#cbx_mesPag').val() === "") {
            alert("Seleccione el Mes a Pagar");
            $('#cbx_mesPag').focus();
            return;

        }
        if ($('#txt_fecha_PagoDet').val() === "") {
            alert("Ingrese La Fecha de Pago");
            $('#txt_fecha_PagoDet').focus();
            return;

        }
        if ($('#txt_fecha_PagoHas').val() === "") {
            alert("Ingrese La Fecha de Vencimiento");
            $('#txt_fecha_PagoHas').focus();
            return;

        }

        if ($('#cbx_Pagen').val() === " ") {
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
            ope: 'InserDetaAnioEmpresa',
            anio: $("#txt_anioSel").val(),
            fpag: $("#txt_fecha_PagoDet").val(),
            valp: valmes,
            mesp: $("#cbx_mesPag").val(),
            fven: $("#txt_fecha_PagoHas").val(),
            recp: $("#txt_nRecibo").val(),
            obs: $("#txt_obserDetPag").val(),
            nafi: $("#txt_Nafil").val(),
            pag: $("#cbx_Pagen").val(),
            empr: $("#idmepre").val(),
            acc: $("#acc_detpago").val(),
            id: $("#id_deta_pago").val(),
            ncob: $("#txt_NCobrador").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            success: function(data) {
                pardat = data.split("-");
                if (pardat[0] === "bien") {
                    $("#id_deta_pago").val(pardat[1]);
                    alert("Datos Guardados Exitosamente");
                    $.aniosDeta();
                    $("#btn_nuevoDet").prop('disabled', false);
                    $("#btn_Recibo").prop('disabled', false);
                    $("#btn_Constancia").prop('disabled', false);
                    $("#btn_guardarDet").prop('disabled', true);

                    $("#txt_anioSel").prop('disabled', true);
                    $("#txt_fecha_Pago").prop('disabled', true);
                    $("#cbx_mesPag").prop('disabled', true);
                    $("#txt_fecha_PagoHas").prop('disabled', true);
                    $("#txt_nRecibo").prop('disabled', true);
                    $("#txt_obserDetPag").prop('disabled', true);

                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });

    //BOTON GUARDAR RECIBO-
    $("#btn_guardarReci").on("click", function() {


        if ($('#txt_ConRec').val() === "") {
            alert("Ingrese el Número del Recibo");
            $('#txt_ConRec').focus();
            return;
        }

        if ($('#txt_NomRec').val() === "") {
            alert("Ingrese el Nombre de la Empresa");
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
            ope: 'InserRecibPagoEmpresa',
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
            deta: $("#id_deta_pago").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            success: function(data) {
                var padata = data.split("/");
                if (trimAll(padata[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $('#txt_idRecib').val(padata[1]);
                    $('#txt_nRecibo').val(padata[2]);
                    $("#btn_guardarReci").prop('disabled', true);
                    $('#btn_ImprRec').show();
                    $('#btn_Anular').show();
                    $.aniosDeta();
                    window.open("PDF_ReciboPagoEmpre.php?id=" + $('#txt_idRecib').val() + "", '_blank');
                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });

    //BOTON GUARDAR CONSTANCIA-
    $("#btn_guardarCost").on("click", function() {

        if ($('#txt_CodConst').val() === "") {
            alert("Ingrese El Consecutivo");
            $('#txt_CodConst').focus();
            return;
        }
        if ($('#CbConsigConst').val() === " ") {
            alert("Seleccione Forma de Consignacion");
            $('#CbConsigConst').focus();
            return;
        }

        if ($('#txt_NomCliConst').val() === "") {
            alert("Nombre del Cliente");
            $('#txt_NomCliConst').focus();
            return;
        }

        var concep = "PAGO P.A.E.E DEL MES DE " + $("#cbx_mesPag").val() + " DEL " + $("#txt_anioSel").val();


        var datos = "consec=" + $("#txt_CodConst").val() + "&fcreac=" + $("#txt_fecha_CreCos").val()
                + "&txt_fecha_Cons=" + $("#txt_fecha_Cons").val() + "&txt_Ciuda=" + $("#txt_CiudaCons").val() + "&txt_iden=" + $("#txt_idenconst").val()
                + "&txt_NomCli=" + $("#txt_NomCliConst").val() + "&CbConsigConst=" + $("#CbConsigConst").val()
                + "&txt_DirConst=" + $("#txt_DirConst").val() + "&txt_TelCliConst=" + $("#txt_TelCliConst").val()
                + "&txt_vtotalConst=" + $("#txt_vtotalConst").val() + "&deta=" + $("#id_deta_pago").val()
                + "&conse=" + $("#consConst").val() + "&concep=" + concep;


        var Alldata = datos;

        $.ajax({
            type: "POST",
            url: "GuardarConstaEmpre.php",
            data: Alldata,
            success: function(data) {

                var padata = data.split("/");
                if (trimAll(padata[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");

                    $("#txt_idCost").val(padata[1]);
                    // $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardarCost").prop('disabled', true);
                    $('#btn_impriCost').show();
                }
            },
            beforeSend: function() {
                $('#cargando').modal('show');
            },
            complete: function() {
                $('#cargando').modal('hide');
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
    
    
   $("#btn_PrintAfil").on("click", function() {
       
        window.open("PrintAfiliados.php?id_Empre=" + $('#idmepre').val() + "", '_blank');

    });
    
   $("#btn_PrintBenef").on("click", function() {
       
        window.open("PrintBeneficiarios.php?idAfilia=" + $('#idAfilia').val() + "", '_blank');

    });
   $("#btn_enviar").on("click", function() {
       
        
        if ($('#txt_emailAfiNot').val() === "") {
            alert("Ingrese el Email");
            $('#txt_emailAfiNot').focus();
            return;
        }
       

        var datos = "txt_IdentiAfiNot=" + $("#txt_IdentiAfiNot").val() + "&txt_NombreAfiNot=" + $("#txt_NombreAfiNot").val()
                + "&txt_ApelliAfiNot=" + $("#txt_ApelliAfiNot").val() + "&txt_NContratoAfiNot=" + $("#txt_NContratoAfiNot").val()
                + "&txt_emailAfiNot=" + $("#txt_emailAfiNot").val() + "&txt_mensaje=" + $("#txt_mensaje").val()+ "&txt_IdentiAfiNot=" + $("#txt_IdentiAfiNot").val();
        

        $.ajax({
            type: "POST",
            url: "EnvNotAfiliado.php",
            data: datos,
            success: function(data) {
                if (trimAll(data) === "bien") {
                    alert("Operación Realizada Exitosamente");              
                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    //BOTON GUARDAR-
    $("#btn_guardarAfil").on("click", function() {


        if ($('#txt_IdentiAfi').val() === "") {
            alert("Ingrese la Identificación del Afiliado");
            $('#txt_IdentiAfi').focus();
            return;
        }

        if ($('#txt_NombreAfi').val() === "") {
            alert("Ingrese El Nombre del Afiliado");
            $('#txt_NombreAfi').focus();
            return;
        }

        if ($('#txt_ApelliAfi').val() === "") {
            alert("Ingrese el Apellido del Afiliado");
            $('#txt_ApelliAfi').focus();
            return;
        }

        if ($('#txt_NContratoAfi').val() === "") {
            alert("Ingrese el Numero del Contrato");
            $('#txt_NContratoAfi').focus();
            return;
        }
        
        
        if ($('#CbTipPlan').val() === null) {
            alert("Seleccione el Tipo de Plan");
            $('#CbTipPlan').focus();
            return;
        }
        if ($('#txt_FecAfil').val() === "") {
            alert("Seleccione la Fecha de Afiliación");
            $('#txt_FecAfil').focus();
            return;
        }


        var pvalCuot = $("#txt_ValCuotAfil").val().split(" ");
        var valcuota = pvalCuot[1].replace(".", "").replace(".", "").replace(",", ".");

        var datos = "txt_IdentiAfi=" + $("#txt_IdentiAfi").val() + "&txt_NombreAfi=" + $("#txt_NombreAfi").val()
                + "&txt_ApelliAfi=" + $("#txt_ApelliAfi").val() + "&txt_NContratoAfi=" + $("#txt_NContratoAfi").val()
                + "&CbTipPlan=" + $("#CbTipPlan").val() + "&txt_DirAfi=" + $("#txt_DirAfi").val()
                + "&txt_BarrAfi=" + $("#txt_BarrAfi").val() + "&txt_TelAfi=" + $("#txt_TelAfi").val()
                + "&txt_CelAfi=" + $("#txt_CelAfi").val() + "&txt_emailAfi=" + $("#txt_emailAfi").val()
                + "&txt_FecAfil=" + $("#txt_FecAfil").val() + "&txt_TelCli=" + $("#txt_Tel").val()+ "&txt_Asesor=" + $("#txt_Asesor").val()
                + "&CbTipClien=" + $("#CbTipClien").val() + "&CbSexo=" + $("#CbSexo").val() + "&txt_FecNac=" + $("#txt_FecNac").val()
                + "&CbTipVinc=" + $("#CbTipVinc").val() + "&txt_Empre=" + $("#txt_Empre").val() + "&txt_FecCont=" + $("#txt_FecCont").val() 
                + "&accAfi=" + $("#accAfi").val() + "&text_idAfi=" + $("#idAfilia").val() + "&CbEstado=" + $("#CbEstado").val()
                + "&idmepre=" + $("#idmepre").val() + "&valcuota=" + valcuota;
        var Alldata = datos;

        $.ajax({
            type: "POST",
            url: "GuardarPreviEmpresarial.php",
            data: Alldata,
            success: function(data) {
                padat=data.split("-");
                if (trimAll(padat[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $("#idAfilia").val(padat[1]);
                    $.editAfi($("#idmepre").val());
                    
                    $("#btn_AddAnexo").prop('disabled', false);
                    $("#btn_nuevo2Afil").prop('disabled', false);
                    $("#btn_guardarAfil").prop('disabled', true);
                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
    //BOTON GUARDAR-
    $("#btn_guardarBenefi").on("click", function() {



        if ($('#txt_NombreBenef').val() === "") {
            alert("Ingrese El Nombre del Beneficiario");
            $('#txt_NombreBenef').focus();
            return;
        }

        if ($('#txt_ApelliBenef').val() === "") {
            alert("Ingrese el Apellido del Beneficiario");
            $('#txt_ApelliBenef').focus();
            return;
        }


        if ($('#CbParentescoBenef').val() === "") {
            alert("Seleccione el Parentesco");
            $('#CbParentescoBenef').focus();
            return;
        }

        if ($('#txt_FecNacBenef').val() === "") {
            alert("Seleccione Una Fecha de Nacimiento");
            $('#txt_FecNacBenef').focus();
            return;
        }
       

        var datos = "txt_NombreBenef=" + $("#txt_NombreBenef").val() + "&txt_ApelliBenef=" + $("#txt_ApelliBenef").val()
                + "&CbParentescoBenef=" + $("#CbParentescoBenef").val() + "&txt_FecNacBenef=" + $("#txt_Edad").val()
                + "&CbEstadoBenefi=" + $("#CbEstadoBenefi").val() + "&accBenef=" + $("#accBenef").val() + "&text_idAfi=" + $("#idAfilia").val()
                + "&text_idBenef=" + $("#text_idBenef").val() + "&idmepre=" + $("#idmepre").val() + "&txt_ciuResi=" + $("#txt_ciuResi").val()+ "&CbTbenefi=" + $("#CbTbenefi").val();
        var Alldata = datos;

        $.ajax({
            type: "POST",
            url: "GuardarPreviEmprBeneficiarios.php",
            data: Alldata,
            success: function(data) {
                if (trimAll(data) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.Beneficiarios($("#idAfilia").val());
                    $("#btn_nuevo2Benef").prop('disabled', false);
                    $("#btn_guardarBenefi").prop('disabled', true);
                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
});
///////////////////////
