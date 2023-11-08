$(document).ready(function () {
    var Order = "b.nom_proyect ASC";
    // $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_serv").addClass("start active open");
    $("#menu_serv_cespred").addClass("active");

//   $("#CbProyect,#CbDepen,#CbResp,#CbElab,#CbContratista,#CbDepa,#CbRubPres,#CbMod,#CbTipCont").select2();


    $("#txt_fecha_Cre").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });


    $("#CbTipTras,#CbEntDoc").selectpicker();

    var contNec = 0;
    var vtotalg = 0;
    var Dat_Nece = "";
    var Dat_Detalles = "";
    var Dat_DetallesCons = "";
    var Dat_Perso = "";


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
                url: "PagCesionContrato.php",
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
                url: "PagCesionContrato.php",
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
        busqCli2: function (val) {


            var datos = {
                ope: "VentCesionario",
                bus: val
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tab_Clientes2").show(100).html(data['tab_cli']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        AddPersona: function () {

            var txt_idenPers = $("#txt_idenPers").val();
            var txt_NomPers = $('#txt_NomPers').val();
            var txt_TelPers = $('#txt_TelPers').val();

            contPers = $("#contPers").val();
            contPers++;

            var fila = '<tr class="selected" id="filaPers' + contPers + '" >';

            fila += "<td>" + contPers + "</td>";
            fila += "<td>" + txt_idenPers + "</td>";
            fila += "<td>" + txt_NomPers + "</td>";
            fila += "<td>" + txt_TelPers + "</td>";
            fila += "<td><input type='hidden' id='Perso" + contPers + "' name='Perso' value='" + txt_idenPers + "//" + txt_NomPers + "//" + txt_TelPers + "' /><a onclick=\"$.QuitarPerso('filaPers" + contPers + "')\" class=\"btn default btn-xs red\">"
                    + "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
            $('#tb_Perso').append(fila);

            $.reordenarPerso();
            $.limpiarPerso();
            $("#contPers").val(contPers);
        },
        limpiarPerso: function () {

            $("#txt_idenPers").val("");
            $("#txt_NomPers").val("");
            $("#txt_TelPers").val("");
        },
        titpro: function () {

            if ($("#CbEntDoc").val() === "TITULO DE PROPIEDAD") {
                $("#txt_TitPro").prop('disabled', false);
            } else {
                $("#txt_TitPro").prop('disabled', true);
                $("#txt_TitPro").val("");
            }


        },
        reordenarPerso: function () {
            var num = 1;
            $('#tb_Perso tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_Perso tbody input').each(function () {
                $(this).attr('id', "Perso" + num);
                num++;
            });

        },
        QuitarPerso: function (id_fila, valor) {
            $('#' + id_fila).remove();
            $.reordenarPerso();
            contPers = $('#contPers').val();
            contPers = contPers - 1;
            $("#contPers").val(contPers);


        },
        CargUbi: function (cod) {

            $('#TextUbi').hide();
            $('#CobUbi').show();

            $("#txt_id_cont").val(cod);
            var datos = {
                ope: "cargubiVenta",
                cod: cod
            };
            var sel = "<option value=''>Select...</option>";
            $.ajax({
                type: "POST",
                async: false,
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
            //   $("#CbSexo").selectpicker("val", par[3]);
            //  $("#txt_FecNac").val(par[4]);
            $("#txt_Dir").val(par[5] + " " + par[7]);
            $("#txt_Tel").val(par[6]);
            $("#txt_nuevo").val("NO");

            $('#clientes').modal('toggle');

            $.CargUbi(par[8]);

        },
        SelCesio: function (val) {
            var par = val.split("//");

            //$("#txt_id_cli").val(par[0]);
            $("#txt_idenCesi").val(par[1]);
            $("#txt_NomCesi").val(par[2]);
            $("#txt_DirCesi").val(par[5]);
            $("#txt_TelCesi").val(par[6]);
            $("#txt_BarrCesi").val(par[7]);
            $("#txt_nuevoSec").val("NO");

            $('#clientes2').modal('toggle');

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
        editCesCon: function (cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);


            var datos = {
                ope: "BusqEditCesCon",
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
                    $("#txt_fecha_Cre").val(data['fec']);
                    $("#txt_iden").val(data['identit']);
                    $("#txt_NomCli").val(data['nomtit']);
                    $("#txt_Dir").val(data['dirtit']);
                    $("#txt_Tel").val(data['telcli']);
                    $("#txt_fecha_Cere").val(data['fcer']);////
                    $("#txt_idenCesi").val(data['indecesi']);
                    $("#txt_NomCesi").val(data['nomcesi']);
                    $("#txt_DirCesi").val(data['dircesi']);
                    $("#txt_BarrCesi").val(data['barr']);
                    $("#txt_TelCesi").val(data['telcesi']);
                    if (data['ubi'] === "-") {
                        $("#txt_Ubic").val(data['textub']);
                        $('#TextUbi').show();
                        $('#CobUbi').hide();
                    } else {
                        $.CargUbi(data['contrato']);
                        alert("Editar Cesion de Contrato");
                        $("#CbUbic").select2("val", data['ubi']);
                    }

                    $("#tb_Perso").html(data['CadPers']);
                    $("#contPers").val(data['cont']);

                    $("#CbTipTras").selectpicker("val", data["tras"]);
                    $("#CbEntDoc").selectpicker("val", data["doc"]);
                    $("#txt_Nota").val(data['nota']);
                    $("#txt_TitPro").val(data['ntitprop']);
                }
            });


            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Cesión de Contrato</a>");


        },
        VerCesCon: function (cod) {
            $('#btn_impri').show();
            $("#btn_guardar").prop('disabled', true);
            var datos = {
                ope: "BusqEditCesCon",
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
                    $("#txt_fecha_Cre").val(data['fec']);
                    $("#txt_iden").val(data['identit']);
                    $("#txt_NomCli").val(data['nomtit']);
                    $("#txt_Dir").val(data['dirtit']);
                    $("#txt_Tel").val(data['telcli']);
                    $("#txt_fecha_Cere").val(data['fcer']);////
                    $("#txt_idenCesi").val(data['indecesi']);
                    $("#txt_NomCesi").val(data['nomcesi']);
                    $("#txt_DirCesi").val(data['dircesi']);
                    $("#txt_BarrCesi").val(data['barr']);
                    $("#txt_TelCesi").val(data['telcesi']);
                    if (data['ubi'] === "-") {
                        $("#txt_Ubic").val(data['textub']);
                        $('#TextUbi').show();
                        $('#CobUbi').hide();
                    } else {
                        $.CargUbi(data['contrato']);
                        alert("Ver Cesion de Contrato");
                        $("#CbUbic").select2("val", data['ubi']);
                    }

                    $("#tb_Perso").html(data['CadPers']);
                    $("#contPers").val(data['cont']);

                    $("#CbTipTras").selectpicker("val", data["tras"]);
                    $("#CbEntDoc").selectpicker("val", data["doc"]);
                    $("#txt_Nota").val(data['nota']);
                    $("#txt_TitPro").val(data['ntitprop']);
                }
            });


            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Ver Cesión de Contrato</a>");



        },
        AbrirClien: function () {

            var datos = {
                ope: "VentClientesVentLote",
                bus: ""
            }


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
        AbrirCesionario: function () {

            var datos = {
                ope: "VentCesionario",
                bus: ""
            };


            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tab_Clientes2").show(100).html(data['tab_cli']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#clientes2").modal();


        },

        deletCesCon: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "GuardarCesionContrato.php",
                    data: datos,
                    success: function (data) {
                        var padata = data.split("/");
                        if (trimAll(padata[0]) === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.Requi();
                        } else {
                            alert("No se puede Eliminar la Necesidad ya que se ha iniciado un Proceso de Contratación");
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
                url: "PagCesionContrato.php",
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
                url: "PagCesionContrato.php",
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
                url: "PagCesionContrato.php",
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

        Dta_Perso: function () {
            Dat_Perso = "";
            $("#tb_Perso").find(':input').each(function () {
                Dat_Perso += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Perso += "&Long_Perso=" + $("#contPers").val();

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
        PrintCesCon: function (val) {
            window.open("PDF_CesionContrato.php?id=" + val + "", '_blank');
        }

    });

    //======FUNCIONES========\\
    $.Requi();
    //$.CargaDatos();



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
                //  $('#txt_iden').val(data['iden']);
                $('#txt_NomCli').val(data['nom']);
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
    $("#txt_idenCesi").on("change", function () {

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
                //  $('#txt_iden').val(data['iden']);
                $('#txt_NomCesi').val(data['nom_cli']);
                $("#txt_DirCesi").val(data['dir_cli']);
                $("#txt_TelCesi").val(data['tel_cli']);
                $("#txt_BarrCesi").val(data['barrio']);
                $("#txt_nuevoSec").val(data['cliex']);

            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

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


    $("#btn_volver").on("click", function () {
        window.location.href = "AdminServicios.php";
    });



    $("#btn_cancelar").on("click", function () {
        window.location.href = 'GesCesionContrato.php';
    });

    $("#btn_impri").on("click", function () {
        window.open("PDF_CesionContrato.php?id=" + $('#txt_id').val() + "", '_blank');
    });



    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {

        if ($('#txt_iden').val() === "") {
            alert("Ingrese al Titular");
            $('#txt_iden').focus();
            return;
        }
        if ($('#txt_idenCesi').val() === "") {
            alert("Ingrese al Cesionario");
            $('#txt_idenCesi').focus();
            return;
        }


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

        $.Dta_Perso();

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


        var datos = "fcreac=" + $("#txt_fecha_Cre").val()
                + "&txt_iden=" + $("#txt_iden").val() + "&ubi=" + Ubic + "&tiu=" + tip + "&txt_nuevoSec=" + $("#txt_nuevoSec").val()
                + "&txt_idenCesi=" + $("#txt_idenCesi").val() + "&txt_NomCesi=" + $("#txt_NomCesi").val()
                + "&txt_DirCesi=" + $("#txt_DirCesi").val() + "&txt_TelCesi=" + $("#txt_TelCesi").val() + "&txt_BarrCesi=" + $("#txt_BarrCesi").val()
                + "&CbTipTras=" + $("#CbTipTras").val() + "&CbEntDoc=" + $("#CbEntDoc").val() + "&txt_nuevo=" + $("#txt_nuevo").val()
                + "&txt_Nota=" + $("#txt_Nota").val() + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val() + "&txt_TitPro=" + $("#txt_TitPro").val()
                + "&txt_NomCli=" + $("#txt_NomCli").val() + "&txt_Dir=" + $("#txt_Dir").val() + "&txt_Tel=" + $("#txt_Tel").val()
                + "&conse=" + $("#cons").val() + "&idvent=" + $("#txt_id_cont").val() + "&texubi=" + texubi;


        var Alldata = datos + Dat_Perso;

        $.ajax({
            type: "POST",
            url: "GuardarCesionContrato.php",
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






});
///////////////////////
