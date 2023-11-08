$(document).ready(function () {
    var Order = "b.nom_proyect ASC";
    // $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_serv").addClass("start active open");
    $("#menu_serv_inhum").addClass("active");

//   $("#CbProyect,#CbDepen,#CbResp,#CbElab,#CbContratista,#CbDepa,#CbRubPres,#CbMod,#CbTipCont").select2();


    $("#txt_fecha_nac,#txt_fecha_Cre, #txt_fecha_fall,#txt_fecha_CreFact,#txt_fecha_CreCos,#txt_fecha_Cons").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });


    $("#txt_fecha_Cere").datetimepicker({
        isRTL: Metronic.isRTL(),
        format: "yyyy-mm-dd - HH:ii P",
        showMeridian: true,
        autoclose: true,
        pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left"),
        todayBtn: true,
        language: 'es'
    });


    $("#CbFacNombCos,#CbFacNombFact,#CbPosic,#CbFpago,#CbConsigConst,#CbCeme").selectpicker();


    var contNec = 0;
    var vtotalg = 0;
    var Dat_Nece = "";
    var Dat_Detalles = "";
    var Dat_DetallesCons = "";


    $.extend({
        Requi: function () {
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
                url: "PagInhumaciones.php",
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
                url: "PagInhumaciones.php",
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
                ope: "VentClientesVentLote",
                bus: val
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
        CargUbi: function (cod) {
            $("#txt_id_cont").val(cod);
            var datos = {
                ope: "cargubiVenta",
                cod: cod
            };

            $('#TextUbi').hide();
            $('#CobUbi').show();

            var sel = "<option value=''>Select...</option>";
            $.ajax({
                async: false,
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#CbUbic").html(sel + data['ubi']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
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
            $("#txt_Dir").val(par[5] + " " + par[7]);
            $("#txt_Tel").val(par[6]);
            $("#txt_nuevo").val("NO");

            $('#clientes').modal('toggle');
            $.CargUbi(par[8]);

        },
        SelNece: function (val) {
            var par = val.split("//");

            $("#txt_id_Nec").val(par[0]);
            $("#txt_nomNec").val(par[1]);
            $("#txt_Cant").val("1");
            $("#txt_Val").val(par[2]);
            $('#necesidad').modal('toggle');
        },
        AddNecesidad: function () {

            var txt_id_Nec = $("#txt_id_Nec").val();
            var txt_nomNec = $('#txt_nomNec').val();
            var txt_Cant = $('#txt_Cant').val();
            var txt_Val = $('#txt_Val').val();
            var txt_obseNec = $('#txt_obseNec').val();

            vtotalg = $("#txt_vtotal").val();
            var pNec = txt_Val.split(" ");
            var vreal = pNec[1].replace(".", "").replace(".", "").replace(",", ".");
            var vtotal = parseFloat(vreal) * parseInt(txt_Cant);

            vtotalg = parseFloat(vtotalg) + parseFloat(vtotal);

            contNec = $("#contNec").val();

            contNec++;

            var fila = '<tr class="selected" id="filaNece' + contNec + '" >';

            fila += "<td>" + contNec + "</td>";
            fila += "<td>" + txt_nomNec + "</td>";
            fila += "<td>" + txt_obseNec + "</td>";
            fila += "<td>" + txt_Cant + "</td>";
            fila += "<td>" + txt_Val + "</td>";
            fila += "<td>$ " + number_format2(vtotal, 2, ',', '.') + "</td>";

            fila += "<td><input type='hidden' id='Neces" + contNec + "' name='Neces' value='" + txt_id_Nec + "//" + txt_Cant + "//" + vreal + "//" + txt_obseNec + "//" + txt_nomNec + "' /><a onclick=\"$.QuitarNeces('filaNece" + contNec + "'," + vtotal + ")\" class=\"btn default btn-xs red\">"
                    + "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";


            $('#tb_Nece').append(fila);
            $("#gtotal").html("$ " + number_format2(vtotalg, 2, ',', '.'));
            $('#txt_vtotal').val(vtotalg);
            $.reordenarNece();
            $.limpiarNece();
            $("#contNec").val(contNec);
        },
        AddDetalles: function () {

            var contDet = 0;
            var vtotalg = 0;
            $("#tb_Nece").find(':input').each(function () {
                Dat_Deta = $(this).val().split("//");

                var txt_id_Nec = Dat_Deta[0];
                var txt_nomNec = Dat_Deta[4];
                var txt_Cant = Dat_Deta[1];
                var txt_Val = Dat_Deta[2];

                var vtotal = parseFloat(txt_Val) * parseInt(txt_Cant);

                vtotalg = parseFloat(vtotalg) + parseFloat(vtotal);

                contDet++;

                var fila = '<tr class="selected" id="filaDeta' + contDet + '" >';

                fila += "<td>" + contDet + "</td>";
                fila += "<td>" + txt_nomNec + "</td>";
                fila += "<td>" + txt_Cant + "</td>";
                fila += "<td>" + number_format2(txt_Val, 2, ',', '.') + "</td>";
                fila += "<td>$ " + number_format2(vtotal, 2, ',', '.') + "</td>";

                fila += "<td style='display:none;'><input type='hidden' id='Detall" + contDet + "' name='Detall' value='" + txt_id_Nec + "//" + txt_Cant + "//" + txt_Val + "//" + txt_nomNec + "' /><a onclick=\"$.QuitarNeces('filaDeta" + contDet + ")\" class=\"btn default btn-xs red\">"
                        + "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";


                $('#tb_Deta').append(fila);
                $("#gtotalDet").html("$ " + number_format2(vtotalg, 2, ',', '.'));
                $('#txt_vtotalFact').val(vtotalg);
                $('#contDet').val(contDet);



            });
            $.NumLetr(vtotalg);
        },
        AddDetallesCost: function () {

            var contDet = 0;
            var vtotalg = 0;
            $("#tb_Nece").find(':input').each(function () {
                Dat_Deta = $(this).val().split("//");

                var txt_id_Nec = Dat_Deta[0];
                var txt_nomNec = Dat_Deta[4];
                var txt_Cant = Dat_Deta[1];
                var txt_Val = Dat_Deta[2];

                var vtotal = parseFloat(txt_Val) * parseInt(txt_Cant);

                vtotalg = parseFloat(vtotalg) + parseFloat(vtotal);

                contDet++;

                var fila = '<tr class="selected" id="filaDetaCons' + contDet + '" >';

                fila += "<td>" + contDet + "</td>";
                fila += "<td>" + txt_nomNec + "</td>";
                fila += "<td>" + txt_Cant + "</td>";
                fila += "<td>" + number_format2(txt_Val, 2, ',', '.') + "</td>";
                fila += "<td>$ " + number_format2(vtotal, 2, ',', '.') + "</td>";

                fila += "<td style='display:none;'><input type='hidden' id='DetallCons" + contDet + "' name='DetallCons' value='" + txt_id_Nec + "//" + txt_Cant + "//" + txt_Val + "//" + txt_nomNec + "' /><a onclick=\"$.QuitarNeces('filaDetaCons" + contDet + ")\" class=\"btn default btn-xs red\">"
                        + "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";


                $('#tb_ConConst').append(fila);
                $("#gtotalcost").html("$ " + number_format2(vtotalg, 2, ',', '.'));
                $('#txt_vtotalConst').val(vtotalg);
                $('#contDetCost').val(contDet);



            });

        },
        limpiarNece: function () {

            $("#txt_id_Nec").val("");
            $("#txt_nomNec").val("");
            $("#txt_Val").val("0,00");
            $("#txt_Cant").val("");
            $("#txt_obseNec").val("");


        },
        NumLetr: function (num) {

            var datos = {
                num: num
            };


            $.ajax({
                type: "POST",
                url: "numero_letra.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#gtotalDetLetra").html("SON: " + data['letra']);
                    $("#txt_valetra").val("SON: " + data['letra']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        reordenarNece: function () {
            var num = 1;
            $('#tb_Nece tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_Nece tbody input').each(function () {
                $(this).attr('id', "Neces" + num);
                num++;
            });

        },
        QuitarNeces: function (id_fila, valor) {
            $('#' + id_fila).remove();
            $.reordenarNece();
            contNec = $('#contNec').val();
            contNec = contNec - 1;
            $("#contNec").val(contNec);
            vtotalg = $('#txt_vtotal').val();

            vtotalg = vtotalg - valor;
            $("#gtotal").html("$ " + number_format2(vtotalg, 2, ',', '.'));
            $('#txt_vtotal').val(vtotalg);

        },
        editInhu: function (cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);


            var datos = {
                ope: "BusqEdiInhum",
                cod: cod
            }

            $.ajax({
                async: false,
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_id").val(cod);

                    $("#txt_Cod").val(data['conse']);
                    $("#txt_fecha_Cre").val(data['fec']);
                    $("#txt_Ciuda").val(data['ciu']);
                    $("#txt_NomFalle").val(data['fall']);
                    $("#txt_fecha_fall").val(data['ffall']);
                    $("#txt_fecha_nac").val(data['fnac']);
                    $("#txt_fecha_Cere").val(data['fcer']);
                    $('#CbFune').val(data["fun"]).change();
                    $("#txt_NomJefe").val(data['jef']);
                    $("#txt_iden").val(data['cedcli']);
                    $("#txt_NomCli").val(data['nomcli']);
                    $("#txt_Dir").val(data['dir']);
                    $("#txt_Tel").val(data['tel']);
                    $("#txt_id_cont").val(data['idv']);
                    $("#txt_obser").val(data['obs']);
                    $("#CbCeme").selectpicker("val", data["cem"]);


                    if (data['idv'] === "") {
                        $("#txt_Ubic").val(data['ubic']);
                        $('#TextUbi').show();
                        $('#CobUbi').hide();
                    } else {
                        $.CargUbi(data['idv']);
                        $("#CbUbic").select2("val", data['ido']);
                    }

                    $("#CbPosic").selectpicker("val", data["posi"]);
                }
            });


            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Inhumaci&oacute;n</a>");


        },
        VerInhu: function (cod) {
            $('#btn_impri').show();
            $("#btn_guardar").prop('disabled', true);
            var datos = {
                ope: "BusqEdiInhum",
                cod: cod
            }

            $.ajax({
                async: false,
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_id").val(cod);

                    $("#txt_Cod").val(data['conse']);
                    $("#txt_fecha_Cre").val(data['fec']);
                    $("#txt_Ciuda").val(data['ciu']);
                    $("#txt_NomFalle").val(data['fall']);
                    $("#txt_fecha_fall").val(data['ffall']);
                    $("#txt_fecha_nac").val(data['fnac']);
                    $("#txt_fecha_Cere").val(data['fcer']);
                    $('#CbFune').val(data["fun"]).change();
                    $("#txt_NomJefe").val(data['jef']);
                    $("#txt_iden").val(data['cedcli']);
                    $("#txt_NomCli").val(data['nomcli']);
                    $("#txt_Dir").val(data['dir']);
                    $("#txt_Tel").val(data['tel']);
                    $("#txt_id_cont").val(data['idv']);
                    $("#txt_obser").val(data['obs']);
                    $("#CbCeme").selectpicker("val", data["cem"]);
                    if (data['idv'] === "") {
                        $("#txt_Ubic").val(data['ubic']);
                        $('#TextUbi').show();
                        $('#CobUbi').hide();
                    } else {
                        $.CargUbi(data['idv']);
                        $("#CbUbic").select2("val", data['ido']);
                    }
                    $("#CbPosic").selectpicker("val", data["posi"]);

                }

            });


            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Ver  Inhumaci&oacute;n</a>");


        },
        AbrirClien: function () {

            var datos = {
                ope: "VentClientesVentLote",
                bus: ""
            };


            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tab_Clientes").html(data['tab_cli']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#clientes").modal();


        },
        AbrirNece: function () {

            var datos = {
                ope: "VentNece",
                bus: ""
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tab_Nece").html(data['tab_nece']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#necesidad").modal();


        },
        busqNec: function (val) {
            var datos = {
                ope: "VentNece",
                bus: val
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tab_Nece").html(data['tab_nece']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        deletInhu: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "GuardarInhumacion.php",
                    data: datos,
                    success: function (data) {
                        var padata = data.split("/");
                        if (trimAll(padata[0]) === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.Requi();
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
                url: "PagInhumaciones.php",
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
                url: "PagInhumaciones.php",
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
                pag: $("#selectpag").val(),
                ord: Order

            }

            $.ajax({
                type: "POST",
                url: "PagInhumaciones.php",
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
        CargaDatos: function () {

            var datos = {
                ope: "CargaTodDatos"
            }

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#CbFune").html(data['fune']);
//                    $("#CbIgle").html(data['igle']);
//                    $("#CbCem").html(data['ceme']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });



        },
        BusMun: function (val) {

            var datos = {
                ope: "cargaMun",
                cod: val
            }

            $.ajax({
                async: false,
                type: "POST",
                url: "../All",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#CbMun").show(100).html(data['mun']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#CbMun").prop('disabled', false);


        },
        conseFact: function () {


            var datos = {
                ope: "ConConsecutivo",
                tco: "FACTURA"
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_CodFact").val(data['StrAct']);
                    $("#consFact").val(data['cons']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        conse: function () {

            var text = $("#atitulo").text();

            if (text === "Crear Orden de Inhumación") {

                var datos = {
                    ope: "ConConsecutivo",
                    tco: "REQUISICION"
                };


                $.ajax({
                    async: false,
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
        conseCos: function () {


            var datos = {
                ope: "ConConsecutivo",
                tco: "CONSTANCIAS"
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_CodConst").val(data['StrAct']);
                    $("#consConst").val(data['cons']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        UpdFune: function () {

            var datos = {
                ope: "UpdateFune"
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#CbFune").html(data['fune']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        UpdCem: function () {

            var datos = {
                ope: "UpdateCeme"
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#CbCem").html(data['ceme']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        UpdIgle: function () {

            var datos = {
                ope: "UpdateIgle"
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#CbIgle").html(data['igle']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        InfUbi: function () {

            var cod = $("#CbUbic").val();
            var datos = {
                ope: "InfUbic",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    if (data['tlote'] === "DOBLE") {

                        $("#CbPosic").attr('disabled', false);
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        PrintInhu: function (val) {
            window.open("PDF_OrdenInhumacion.php?id=" + val + "", '_blank');
        },
        facnombCost: function (ori) {

            var datos = {
                ope: "BusinfFunera",
                idr: $("#txt_id").val(),
                cno: $("#CbFacNombCos").val(),
                ori: ori
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $('#txt_idenconst').val(data['nit']);
                    $('#txt_NomCliConst').val(data['nom_fune']);
                    $('#txt_DirConst').val(data['dir']);
                    $('#txt_TelCliConst').val(data['tel']);
                    $('#txt_NomFall').val(data['nomfall_req']);
                    $('#txt_FecNacFall').val(data['fecnfall_req']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        facnombFact: function (ori) {



            var datos = {
                ope: "BusinfFunera",
                idr: $("#txt_id").val(),
                cno: $("#CbFacNombFact").val(),
                ori: ori
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#txt_idenFact').val(data['nit']);
                    $('#txt_NomCliFact').val(data['nom_fune']);
                    $('#txt_DirFact').val(data['dir']);
                    $('#txt_TelCliFact').val(data['tel']);
                    $('#txt_NomFall').val(data['nomfall_req']);
                    $('#txt_FecNacFall').val(data['fecnfall_req']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        Dta_Nece: function () {
            Dat_Nece = "";
            $("#tb_Nece").find(':input').each(function () {
                Dat_Nece += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Nece += "&Long_Nece=" + $("#contNec").val();

        },
        Dta_Deta: function () {
            Dat_Detalles = "";
            $("#tb_Deta").find(':input').each(function () {
                Dat_Detalles += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Detalles += "&Long_Deta=" + $("#contDet").val();

        },
        Dta_DetaConst: function () {
            Dat_DetallesCons = "";
            $("#tb_ConConst").find(':input').each(function () {
                Dat_DetallesCons += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_DetallesCons += "&Long_DetaCons=" + $("#contDetCost").val();

        },
        NewFune: function () {
            window.open("GesFunerarias.php", '_blank');
        },
        NewCem: function () {
            window.open("GesCementerios.php", '_blank');
        },
        NewNece: function () {
            window.open("GesServicios.php", '_blank');
        },
        NewIgle: function () {
            window.open("GesIglesias.php", '_blank');
        },
        PrintAuto: function (val) {
            window.open("PDF_AutoEntrada_1.php?id=" + val + "", '_blank');
        },
        FactReq: function (cod) {

            $("#txt_id").val(cod);
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");

            $('#tab_factPP').show();
            $("#tab_infPP").removeClass("active in");
            $("#tab_inf").removeClass("active in");
            $("#tab_necePP").removeClass("active in");
            $("#tab_nece").removeClass("active in");
            $("#tab_esqPP").removeClass("active in");
            $("#tab_esq").removeClass("active in");

            $("#tab_factPP").addClass("active in");
            $("#tab_fact").addClass("active in");

            var existe = "";
            var datos = {
                ope: "cargaFactura",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#consFact").val(data['id_fact']);
                    $("#txt_CodFact").val(data['cons_fact']);
                    $("#txt_fecha_CreFact").val(data['fec_cre']);
                    $("#txt_CiudaFact").val(data['ciudad']);

                    $("#txt_vtotalFact").val(data['valor']);
                    $("#txt_valetra").val(data['val_letra']);
                    //
                    $("#tb_Deta").html(data['CadNec']);
                    $("#contDet").val(data['cont']);

                    if (data["existe"] === "s") {
                        $("#txt_idenFact").val(data['iden']);
                        $("#txt_NomCliFact").val(data['nom']);
                        $("#txt_DirFact").val(data['dir']);
                        $("#txt_TelCliFact").val(data['tel']);
                        $('#CbFpago').val(data["fpago"]).change();

                        $("#btn_guardarFact").prop('disabled', true);
                        $('#btn_impriFact').show();
                        $('#btn_Anular').show();
                    } else {
                        $("#txt_fecha_CreFact").val(data['fec_cre']);
                        $("#txt_CiudaFact").val(data['ciudad']);
//                        $("#txt_idenFact").val(data['iden']);
//                        $("#txt_NomCliFact").val(data['nom']);
//                        $("#txt_DirFact").val(data['dir']);
//                        $("#txt_TelCliFact").val(data['tel']);
                        $("#txt_vtotalFact").val(data['valor']);
                        $.NumLetr(data['valor']);

                        $("#tb_Deta").html(data['CadNec']);
                        $("#contDet").val(data['cont']);
                        $.conseFact();

                    }

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }

    });

    //======FUNCIONES========\\
    $.Requi();
    $.CargaDatos();

    $("#txt_Cod").on("change", function () {

        var datos = {
            ope: "busCodRequ",
            cod: $("#txt_Cod").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {
                if (data === 1) {
                    alert("Este Consecutivo ya ha sido Registrado");
                    $('#txt_Cod').focus();
                    $("#txt_Cod").val("");
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#txt_iden").on("change", function () {

        var datos = {
            ope: "ClientesInhuma",
            cod: $("#txt_iden").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {
                $('#txt_id_cli').val(data['iden']);
                $('#txt_NomCli').val(data['nom']);
                // $("#CbSexo").selectpicker("val", data['sex_cli']);
                //   $("#txt_FecNac").val(data['fec_cli']);
                $("#txt_Dir").val(data['dir']);
                $("#txt_Tel").val(data['tel']);
                $("#txt_nuevo").val(data['cliex']);
                if (data['cliex'] === "NO") {

                    $.CargUbi(data['id']);
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });



    $(':file').change(function () {
        //obtenemos un array con los datos del archivo
        var file = $("#imagen")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        //alert("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");


        var formData = new FormData($("#form")[0]);
        var message = "";
        //hacemos la petición ajax
        $.ajax({
            url: 'uploadFalle.php',
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function () {
                $('#cargando').modal('show');
            },
            complete: function () {

                $('#cargando').modal('hide');
            },
            //una vez finalizado correctamente
            success: function (data) {
                $('#cargando').modal('hide');
                $("#txt_src_archivo").val(data);
            },
            //si ha ocurrido un error
            error: function () {
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });
    });


    $("#btn_nuevo2").on("click", function () {
        $('#acc').val("1");


        $("#txt_Cod").val("");
        $("#txt_fecha_Cre").val($("#txt_fec").val());
        $("#txt_fecMod").val($("#txt_fec").val());
        $("#txt_Nomb").val("");
        $("#txt_RPres").val("");
        $("#CbEje").select2("val", " ");
        $("#CbProg").select2("val", " ");
        $("#CbSubProg").select2("val", " ");
        $("#CbDepen").select2("val", " ");
        $("#CbResp").select2("val", " ");
        $("#CbElab").select2("val", " ");
        $("#CbEstado").selectpicker("val", " ");
        $("#Cbvia").selectpicker("val", " ");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_fecha_Cre").prop('disabled', false);
        $("#txt_Nomb").prop('disabled', false);
        $("#CbEje").prop('disabled', false);
        $("#CbProg").prop('disabled', true);
        $("#CbSubProg").prop('disabled', true);
        $("#CbDepen").prop('disabled', false);
        $("#CbResp").prop('disabled', false);
        $("#CbElab").prop('disabled', false);
        $("#CbEstado").prop('disabled', false);
        $("#Cbvia").prop('disabled', false);
        $("#txt_RPres").prop('disabled', false);


    });

    $("#btn_volver").on("click", function () {
        $('#acc').val("1");

        $("#txt_Cod").val("");
        $("#txt_fecha_Cre").val($("#txt_fec").val());
        $("#txt_fecMod").val($("#txt_fec").val());
        $("#txt_Nomb").val("");
        $("#txt_RPres").val("");
        $("#CbEje").select2("val", " ");
        $("#CbProg").select2("val", " ");
        $("#CbSubProg").select2("val", " ");
        $("#CbDepen").select2("val", " ");
        $("#CbResp").select2("val", " ");
        $("#CbElab").select2("val", " ");
        $("#CbEstado").selectpicker("val", " ");
        $("#Cbvia").selectpicker("val", " ");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Cod").prop('disabled', false);
        $("#txt_fecha_Cre").prop('disabled', false);
        $("#txt_Nomb").prop('disabled', false);
        $("#CbEje").prop('disabled', false);
        $("#CbProg").prop('disabled', true);
        $("#CbSubProg").prop('disabled', true);
        $("#CbDepen").prop('disabled', false);
        $("#CbResp").prop('disabled', false);
        $("#CbElab").prop('disabled', false);
        $("#CbEstado").prop('disabled', false);
        $("#Cbvia").prop('disabled', false);
        $("#txt_RPres").prop('disabled', false);


    });

    $("#btn_impriFact").on("click", function () {
        window.open("PDF_FacturaRequi.php?id=" + $('#consFact').val() + "", '_blank');
    });
    $("#btn_impriCost").on("click", function () {
        window.open("PDF_Constancia.php?id=" + $('#txt_idCost').val() + "", '_blank');
    });

    $("#btn_volver").on("click", function () {
        window.location.href = "AdminServicios.php";
    });

    $("#btn_factura").on("click", function () {

        $('#tab_factPP').show();
        $("#tab_infPP").removeClass("active in");
        $("#tab_inf").removeClass("active in");
        $("#tab_necePP").removeClass("active in");
        $("#tab_nece").removeClass("active in");
        $("#tab_esqPP").removeClass("active in");
        $("#tab_esq").removeClass("active in");
        $("#tab_constPP").removeClass("active in");
        $("#tab_const").removeClass("active in");

        $("#tab_factPP").addClass("active in");
        $("#tab_fact").addClass("active in");

        $.conseFact();

        $('#txt_CiudaFact').val($('#txt_Ciuda').val());



        $.AddDetalles();


    });

    $("#btn_constancia").on("click", function () {

        $('#tab_constPP').show();
        $("#tab_infPP").removeClass("active in");
        $("#tab_inf").removeClass("active in");
        $("#tab_necePP").removeClass("active in");
        $("#tab_nece").removeClass("active in");
        $("#tab_esqPP").removeClass("active in");
        $("#tab_esq").removeClass("active in");
        $("#tab_factPP").removeClass("active in");
        $("#tab_fact").removeClass("active in");

        $("#tab_constPP").addClass("active in");
        $("#tab_const").addClass("active in");

        $.conseCos();

        $('#txt_CiudaCons').val($('#txt_Ciuda').val());



        $.AddDetallesCost();


    });

    $("#btn_cancelar").on("click", function () {
        window.location.href = 'GesOrdenInhumacion.php';
    });

    $("#btn_impri").on("click", function () {
        window.open("PDF_OrdenInhumacion.php?id=" + $('#txt_id').val() + "", '_blank');
    });



    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {

//        $.conse();



        if ($('#txt_Cod').val() === "") {
            alert("Ingrese el Codigo de la Inhumacion");
            $('#txt_Cod').focus();
            return;
        }

        if ($('#txt_iden').val() === "") {
            alert("Ingrese al Titular");
            $('#txt_iden').focus();
            return;
        }
        if ($('#CbCeme').val() === " ") {
            alert("Seleccione el Cementerio");
            $('#CbCeme').focus();
            return;
        }

        if ($("#acc").val() === "1") {
            if ($("#txt_nuevo").val() === "NO") {
                if ($('#CbUbic').val() === "") {
                    alert("Seleccione la Ubicacion");
                    $('#CbUbic').focus();
                    return;
                }
            } else {
                if ($('#txt_Ubic').val() === "") {
                    alert("Ingrese la Ubicacion");
                    $('#txt_Ubic').focus();
                    return;
                }
            }
        }




        if ($('#txt_NomFalle').val() === "") {
            alert("Ingrese el Nombre del Fallecido");
            $('#txt_NomFalle').focus();
            return;
        }

        var Ubic = "";
        var tip = "";
        var tip = "";
        var texubi = "";
        if ($("#txt_nuevo").val() === "NO") {
            var paubi = $("#CbUbic").val().split("-");
            Ubic = paubi[0];
            tip = paubi[1];
            texubi = $("#CbUbic option:selected").text();
        } else {
            texubi = $("#txt_Ubic").val();
        }

        var datos = "codigo=" + $("#txt_Cod").val() + "&fcreac=" + $("#txt_fecha_Cre").val()
                + "&txt_Ciuda=" + $("#txt_Ciuda").val() + "&txt_iden=" + $("#txt_iden").val() + "&ubi=" + Ubic + "&tip=" + tip
                + "&CbPosic=" + $("#CbPosic").val() + "&txt_NomFalle=" + $("#txt_NomFalle").val() + "&txt_nuevo=" + $("#txt_nuevo").val()
                + "&txt_fecha_fall=" + $("#txt_fecha_fall").val() + "&txt_fecha_nac=" + $("#txt_fecha_nac").val()
                + "&txt_fecha_Cere=" + $("#txt_fecha_Cere").val() + "&CbFune=" + $("#CbFune").val() + "&txt_obser=" + $("#txt_obser").val()
                + "&txt_NomJefe=" + $("#txt_NomJefe").val() + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val()
                + "&conse=" + $("#cons").val() + "&idvent=" + $("#txt_id_cont").val() + "&texubi=" + texubi
                + "&txt_NomCli=" + $("#txt_NomCli").val() + "&txt_Dir=" + $("#txt_Dir").val() + "&txt_Tel=" + $("#txt_Tel").val() + "&CbCeme=" + $("#CbCeme").val();


        var Alldata = datos;

        $.ajax({
            type: "POST",
            url: "GuardarInhumacion.php",
            data: Alldata,
            success: function (data) {
                var padata = data.split("/");
                if (trimAll(padata[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.Requi();
                    $("#txt_id").val(padata[1]);
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);
                    $('#btn_impri').show();
//                    $('#btn_constancia').show();
//                    $('#btn_factura').show();

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

    $("#btn_Anular").on("click", function () {
        if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

            var datos = {
                ope: "AnularFactura",
                cod: $("#consFact").val()
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                success: function (data) {
                    if (trimAll(data) === "bien") {
                        alert("Operacion Realizada Exitosamente");
                        $("#btn_guardarFact").prop('disabled', false);
                        $('#btn_impriFact').hide();
                        $('#btn_Anular').hide();
                        $.conseFact();
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        }
    });

    //BOTON GUARDAR  FACTURA-
    $("#btn_guardarFact").on("click", function () {

        if ($('#txt_CodFact').val() === "") {
            alert("Ingrese El Consecutivo");
            $('#txt_CodFact').focus();
            return;
        }
        if ($('#CbFpago').val() === " ") {
            alert("Seleccione la Forma de Pago");
            $('#CbFpago').focus();
            return;
        }

        if ($('#txt_NomCliFact').val() === "") {
            alert("Nombre del Cliente");
            $('#txt_NomCliFact').focus();
            return;
        }

        $.Dta_Deta();

        var datos = "consec=" + $("#txt_CodFact").val() + "&fcreac=" + $("#txt_fecha_CreFact").val()
                + "&txt_Ciuda=" + $("#txt_CiudaFact").val() + "&txt_iden=" + $("#txt_idenFact").val()
                + "&txt_NomCli=" + $("#txt_NomCliFact").val() + "&CbFpago=" + $("#CbFpago").val()
                + "&txt_DirFact=" + $("#txt_DirFact").val() + "&txt_TelCliFact=" + $("#txt_TelCliFact").val()
                + "&txt_vtotalFact=" + $("#txt_vtotalFact").val() + "&txt_valetra=" + $("#txt_valetra").val()
                + "&txt_NomFall=" + $("#txt_NomFall").val() + "&txt_FecNacFall=" + $("#txt_FecNacFall").val()
                + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val()
                + "&conse=" + $("#consFact").val();


        var Alldata = datos + Dat_Detalles;

        $.ajax({
            type: "POST",
            url: "GuardarFacturaRequisicion.php",
            data: Alldata,
            success: function (data) {

                var padata = data.split("/");
                if (trimAll(padata[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");

                    $("#consFact").val(padata[1]);
                    // $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardarFact").prop('disabled', true);
                    $('#btn_impriFact').show();
                    $('#btn_Anular').show();


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

    //BOTON GUARDAR  CONSTANCIA-
    $("#btn_guardarCost").on("click", function () {

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

        $.Dta_DetaConst();

        var datos = "consec=" + $("#txt_CodConst").val() + "&fcreac=" + $("#txt_fecha_CreCos").val()
                + "&txt_fecha_Cons=" + $("#txt_fecha_Cons").val() + "&txt_Ciuda=" + $("#txt_CiudaCons").val() + "&txt_iden=" + $("#txt_idenconst").val()
                + "&txt_NomCli=" + $("#txt_NomCliConst").val() + "&CbConsigConst=" + $("#CbConsigConst").val()
                + "&txt_DirConst=" + $("#txt_DirConst").val() + "&txt_TelCliConst=" + $("#txt_TelCliConst").val()
                + "&txt_vtotalConst=" + $("#txt_vtotalConst").val() + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val()
                + "&conse=" + $("#consConst").val() + "&txt_nuevo=" + $("#txt_nuevo").val();


        var Alldata = datos + Dat_DetallesCons;

        $.ajax({
            type: "POST",
            url: "GuardarConstaRequisicion.php",
            data: Alldata,
            success: function (data) {

                var padata = data.split("/");
                if (trimAll(padata[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");

                    $("#txt_idCost").val(padata[1]);
                    // $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardarCost").prop('disabled', true);
                    $('#btn_impriCost').show();


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
