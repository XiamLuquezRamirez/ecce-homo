$(document).ready(function () {
    var Order = "b.nom_proyect ASC";
    // $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_serv").addClass("start active open");
    $("#menu_serv_vent").addClass("active");


    $("#txt_FechInhumOcu,#txt_fecha_Pago,#txt_fecha_PagoHas,#txt_fecha_Cre, #txt_fecha_Desd, #txt_fecha_Hast, #txt_fecha_Fall,#txt_FecNac,#txt_fecha_CreCos,#txt_fecha_Cons").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });


    $("#CbFpagoFact,#CbFormPagoC,#CbTipLote,#CbTipOsa,#CbSexo,#CbFpago,#CbConsig").selectpicker();


    var contPers = 0;
    var vtotalg = 0;
    var Dat_Perso = "";
    var Dat_DetLote = "";
    var Dat_DetOsa = "";
    var Dat_ConceptosCost = "";
    var Dat_ConceptosFact = "";
    var contLote = "";
    var contOsa = "";


    $.extend({
        Contra: function () {
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
                url: "PagConratoVenta.php",
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
                url: "PagConratoVenta.php",
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
        AddDetPago: function () {
            $("#DetallPago").modal();

            $("#btn_nuevoDet").prop('disabled', true);
            $("#btn_guardarDet").prop('disabled', false);


            $("#txt_fecha_Pago").prop('disabled', false);
            $("#txt_fecha_PagoHas").prop('disabled', false);
            $("#txt_obserDetPag").prop('disabled', false);

            $("#txt_obserDetPag").val('');

            $("#txt_ValCuota").val("$ " + number_format2($("#mes").val(), 2, ',', '.'));


        },
        Deta: function () {

            var datos = {
                ope: "tab_Deta",
                vent: $("#id_venta").val()
            };
            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tb_Deta").show(100).html(data['tabla_aniosDet']);
                    $("#saldo").val(data['saldo']);
                    $("#val_Saldo").html('$ ' + number_format2(data['saldo'], 2, ',', '.'));
//                    $("#val_contrato").html('$ '+number_format2(data['valor'], 2, ',', '.'));
//                    $("#val_Mens_contrato").html('$ '+number_format2(data['cuota'], 2, ',', '.'));
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        DetaOcup: function (tip) {

            var datos = {
                ope: "tab_DetaOcupa",
                ocup: $("#id_ocup").val(),
                tip: tip
            };
            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tab_Ocup").show(100).html(data['tabOcup']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        DetaLote: function () {

            var datos = {
                ope: "tab_DetaLote",
                idc: $("#txt_id").val()
            };
            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tb_lote").html(data['CadLote']);
                    $("#contLote").val(data['contLote']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        DetaOsario: function () {

            var datos = {
                ope: "tab_DetaOsario",
                idc: $("#txt_id").val()
            };
            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tb_osar").html(data['CadOsa']);
                    $("#contOsa").val(data['contOsa']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        AddPago: function (id) {

            $('#id_venta').val(id);
            $('#txt_id').val(id);

            var datos = {
                ope: "BusqContVenta",
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
                    $("#CbFormPagoC").selectpicker("val", data["fpago"]);
                    $("#txt_titular").val(data['ident_vent'] + " - " + data['nombre_venta']);
                    $("#saldo").val(data['saldo']);
                    $("#mes").val(data['cuota_vent']);
                    $("#txt_NCuot").val(data['cuota']);
                    $("#val_Mens_contrato").html('$ ' + number_format2(data['cuota_vent'], 2, ',', '.'));
                    $("#val_Saldo").html('$ ' + number_format2(data['saldo'], 2, ',', '.'));
                    $("#val_contrato").html('$ ' + number_format2(data['precio'], 2, ',', '.'));


                }

            });

            $.Deta();


            $('#tab_03_pp').show();
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").removeClass("active in");
            $("#tab_02_pp").removeClass("active in");
            $("#tab_03").addClass("active in");
            $("#tab_03_pp").addClass("active in");


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
            fila += "<td><input type='hidden' id='Perso" + contPers + "' name='Perso' value='" + txt_idenPers + "//" + txt_NomPers + "//" + txt_TelPers + "' /><a onclick=\"$.QuitarNeces('filaPers" + contPers + "')\" class=\"btn default btn-xs red\">"
                    + "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
            $('#tb_Perso').append(fila);

            $.reordenarPerso();
            $.limpiarPerso();
            $("#contPers").val(contPers);
        },
        AddLote: function () {

            if ($("#acc").val() === "2") {
                $.AddLoteBD("1");
            } else {


                if ($('#txt_jardin').val() === "") {
                    alert("Ingrese el Numero del Jardin");
                    $('#txt_jardin').focus();
                    return;
                }

                if ($('#txt_zona').val() === "") {
                    alert("Ingrese el Numero de la Zona");
                    $('#txt_zona').focus();
                    return;
                }

                if ($('#txt_lote').val() === "") {
                    alert("Ingrese el Numero del Lote");
                    $('#txt_lote').focus();
                    return;
                }

                if ($('#CbTipLote').val() === "") {
                    alert("Seleccione el Tipo de Lote");
                    $('#CbTipLote').focus();
                    return;
                }

                if ($('#txt_Prec').val() === "$ 0,00") {
                    alert("Ingrese el Precio de Lote");
                    $('#txt_Prec').focus();
                    return;
                }

                var txt_jardin = $("#txt_jardin").val();
                var txt_zona = $('#txt_zona').val();
                var txt_lote = $('#txt_lote').val();
                var CbTipLote = $('#CbTipLote').val();
                var txt_Prec = $('#txt_Prec').val();


                var txt_CostruLot = $('#txt_CostruLot').val();
                var txt_obser = $('#txt_obser').val();

                var ubi = "Jardin:" + txt_jardin + " Zona:" + txt_zona + " Lote:" + txt_lote;

                contLote = $("#contLote").val();
                contLote++;

                var precio = $("#txt_Prec").val().split(" ");
                var preciolot = precio[1].replace(".", "").replace(".", "").replace(",", ".");


                var fila = '<tr class="selected" id="filaLote' + contLote + '" >';

                fila += "<td>" + contLote + "</td>";
                fila += "<td>" + ubi + "</td>";
                fila += "<td>" + CbTipLote + "</td>";
                fila += "<td>" + txt_Prec + "</td>";
                fila += "<td>" + txt_CostruLot + "</td>";
                fila += "<td>" + txt_obser + "</td>";
                fila += "<td></td>";
                fila += "<td><input type='hidden' id='Lotes" + contLote + "' name='Lotes' value='" + txt_jardin + "//" + txt_zona + "//" + txt_lote + "//" + CbTipLote + "//" + preciolot + "//" + txt_CostruLot + "//" + txt_obser + "' />"

                fila += "<a onclick=\"$.QuitarLote('filaLote" + contLote + "'," + preciolot + ")\" class=\"btn default btn-xs red\">"
                fila += "<i class=\"fa fa-trash-o\"></i> Borrar</a>";
                //  fila += "<a onclick=\"$.EditarLote('filaLote" + contLote + "')\" class=\"btn default btn-xs blue\">"
                //     fila += "<i class=\"fa fa-edit\"></i> Editar</a></td></tr>";

                $('#tb_lote').append(fila);

                $.reordenarLote();
                $.limpiarLote();
                $("#contLote").val(contLote);
                var totapre = parseFloat(preciolot) + parseFloat($("#txt_prec2").val());

                $("#txt_prec2").val(totapre);
                $("#txt_PrecTot").val("$ " + number_format2(totapre, 2, ',', '.'));

                $("#btn_addlote").html('<a onclick="$.AddLote()" id="btn_addlote" class="btn green"> Agregar <i class="fa fa-plus"></i></a>');
            }
        },
        AddLoteBD: function (op) {

            if ($('#txt_jardin').val() === "") {
                alert("Ingrese el Numero del Jardin");
                $('#txt_jardin').focus();
                return;
            }

            if ($('#txt_zona').val() === "") {
                alert("Ingrese el Numero de la Zona");
                $('#txt_zona').focus();
                return;
            }

            if ($('#txt_lote').val() === "") {
                alert("Ingrese el Numero del Lote");
                $('#txt_lote').focus();
                return;
            }

            if ($('#CbTipLote').val() === "") {
                alert("Seleccione el Tipo de Lote");
                $('#CbTipLote').focus();
                return;
            }

            if ($('#txt_Prec').val() === "$ 0,00") {
                alert("Ingrese el Precio de Lote");
                $('#txt_Prec').focus();
                return;
            }

            var txt_jardin = $("#txt_jardin").val();
            var txt_zona = $('#txt_zona').val();
            var txt_lote = $('#txt_lote').val();
            var CbTipLote = $('#CbTipLote').val();
            var txt_PrecAnt = $('#txt_PrecAnt').val();

            var txt_CostruLot = $('#txt_CostruLot').val();
            var txt_obser = $('#txt_obser').val();

            var precio = $("#txt_Prec").val().split(" ");
            var preciolot = precio[1].replace(".", "").replace(".", "").replace(",", ".");
            var totapre = parseFloat($("#txt_prec2").val());
            var ope = "";
            if (op === "1") {
                ope = "InsertLote";
                totapre = totapre + parseFloat(preciolot);
            } else {
                ope = "UpdatetLote";
                totapre = totapre - parseFloat(txt_PrecAnt);
                totapre = totapre + parseFloat(preciolot);
            }


            $("#txt_prec2").val(totapre);
            $("#txt_PrecTot").val("$ " + number_format2(totapre, 2, ',', '.'));


            var datos = {
                ope: ope,
                jar: txt_jardin,
                zon: txt_zona,
                lot: txt_lote,
                tlo: CbTipLote,
                pre: preciolot,
                pra: txt_PrecAnt,
                cos: txt_CostruLot,
                obs: txt_obser,
                idv: $('#txt_id').val(),
                idl: $('#txt_IdLote').val()

            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                success: function (data) {
                    if (data === "bien") {
                        alert("Datos Guardados Exitosamente");
                        $.DetaLote();
                        $.limpiarLote();
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });



//            var totapre = parseFloat(preciolot) + parseFloat($("#txt_prec2").val());
//
//            $("#txt_prec2").val(totapre);
//            $("#txt_PrecTot").val("$ " + number_format2(totapre, 2, ',', '.'));
//
            $("#btn_addlote").html('<a onclick="$.AddLote()" id="btn_addlote" class="btn green"> Agregar <i class="fa fa-plus"></i></a>');

        },
        AddOsario: function () {

            if ($("#acc").val() === "2") {
                $.AddOsarioBD("1");
            } else {

                if ($('#txt_jardinOsa').val() === "") {
                    alert("Ingrese el Numero del Jardin");
                    $('#txt_jardinOsa').focus();
                    return;
                }

                if ($('#txt_nosa').val() === "") {
                    alert("Ingrese el Numero del Osario");
                    $('#txt_nosa').focus();
                    return;
                }

                if ($('#CbTipOsa').val() === "") {
                    alert("Seleccione el Tipo de Osario");
                    $('#CbTipOsa').focus();
                    return;
                }

                if ($('#txt_PreOsa').val() === "$ 0,00") {
                    alert("Ingrese el Precio de Lote");
                    $('#txt_PreOsa').focus();
                    return;
                }

                var txt_jardinOsa = $("#txt_jardinOsa").val();
                var txt_nosa = $('#txt_nosa').val();
                var CbTipOsa = $('#CbTipOsa').val();
                var txt_PreOsa = $('#txt_PreOsa').val();


                var txt_CostruOsa = $('#txt_CostruOsa').val();
                var txt_obserOsa = $('#txt_obserOsa').val();

                var ubi = "Jardin:" + txt_jardinOsa + " Número:" + txt_nosa;

                contOsa = $("#contOsa").val();
                contOsa++;

                var precio = $("#txt_PreOsa").val().split(" ");
                var precioOsa = precio[1].replace(".", "").replace(".", "").replace(",", ".");

                var fila = '<tr class="selected" id="filaOsario' + contOsa + '" >';

                fila += "<td>" + contOsa + "</td>";
                fila += "<td>" + ubi + "</td>";
                fila += "<td>" + CbTipOsa + "</td>";
                fila += "<td>" + txt_PreOsa + "</td>";
                fila += "<td>" + txt_CostruOsa + "</td>";
                fila += "<td>" + txt_obserOsa + "</td>";
                fila += "<td></td>";
                fila += "<td><input type='hidden' id='Osario" + contOsa + "' name='Osario' value='" + txt_jardinOsa + "//" + txt_nosa + "//" + CbTipOsa + "//" + precioOsa + "//" + txt_CostruOsa + "//" + txt_obserOsa + "' />"

                fila += "<a onclick=\"$.QuitarOsario('filaOsario" + contOsa + "'," + txt_PreOsa + ")\" class=\"btn default btn-xs red\">"
                fila += "<i class=\"fa fa-trash-o\"></i> Borrar</a>";
                fila += "<a onclick=\"$.EditarOsario('filaOsario" + contOsa + "')\" class=\"btn default btn-xs blue\">"
                fila += "<i class=\"fa fa-edit\"></i> Editar</a></td></tr>";

                $('#tb_osar').append(fila);

                $.reordenarOsario();
                $.limpiarOsario();
                $("#contOsa").val(contOsa);
                var totapre = parseFloat(precioOsa) + parseFloat($("#txt_prec2").val());

                $("#txt_prec2").val(totapre);
                $("#txt_PrecTot").val("$ " + number_format2(totapre, 2, ',', '.'));

            }
        },
        AddOsarioBD: function (op) {


            if ($('#txt_jardinOsa').val() === "") {
                alert("Ingrese el Numero del Jardin");
                $('#txt_jardinOsa').focus();
                return;
            }

            if ($('#txt_nosa').val() === "") {
                alert("Ingrese el Numero del Osario");
                $('#txt_nosa').focus();
                return;
            }

            if ($('#CbTipOsa').val() === "") {
                alert("Seleccione el Tipo de Osario");
                $('#CbTipOsa').focus();
                return;
            }

            if ($('#txt_PreOsa').val() === "$ 0,00") {
                alert("Ingrese el Precio de Lote");
                $('#txt_PreOsa').focus();
                return;
            }

            var txt_jardinOsa = $("#txt_jardinOsa").val();
            var txt_nosa = $('#txt_nosa').val();
            var CbTipOsa = $('#CbTipOsa').val();
            var txt_PreOsa = $('#txt_PreOsa').val();
            var txt_PrecAnt = $('#txt_PrecAntOsa').val();

            var txt_CostruOsa = $('#txt_CostruOsa').val();
            var txt_obserOsa = $('#txt_obserOsa').val();


            var precio = $("#txt_PreOsa").val().split(" ");
            var precioOsa = precio[1].replace(".", "").replace(".", "").replace(",", ".");
            var totapre = parseFloat($("#txt_prec2").val());
            var ope = "";
            if (op === "1") {
                ope = "InsertOsario";
                totapre = totapre + parseFloat(precioOsa);
            } else {
                ope = "UpdateOsario";
                totapre = totapre - parseFloat(txt_PrecAnt);
                totapre = totapre + parseFloat(precioOsa);
            }


            $("#txt_prec2").val(totapre);
            $("#txt_PrecTot").val("$ " + number_format2(totapre, 2, ',', '.'));

            var datos = {
                ope: ope,
                jar: txt_jardinOsa,
                nos: txt_nosa,
                tos: CbTipOsa,
                pre: precioOsa,
                pra: txt_PrecAnt,
                cos: txt_CostruOsa,
                obs: txt_obserOsa,
                idv: $('#txt_id').val(),
                ido: $('#txt_IdOsa').val()

            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                success: function (data) {
                    if (data === "bien") {
                        alert("Datos Guardados Exitosamente");
                        $.DetaOsario();
                        $.limpiarOsario();
                    }
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $("#btn_addOsario").html('<a onclick="$.AddOsario()" class="btn green"> Agregar <i class="fa fa-plus"></i></a>');
        },
        limpiarPerso: function () {

            $("#txt_idenPers").val("");
            $("#txt_NomPers").val("");
            $("#txt_TelPers").val("");


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
        limpiarLote: function () {

            $("#txt_jardin").val("");
            $("#txt_zona").val("");
            $("#txt_lote").val("");
            $("#txt_Prec").val("$ 0,00");
            $("#txt_CostruLot").val("");
            $("#txt_obser").val("");
            $("#CbTipLote").selectpicker("val", " ");


        },
        reordenarLote: function () {
            var num = 1;
            $('#tb_lote tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_lote tbody input').each(function () {
                $(this).attr('id', "Lotes" + num);
                num++;
            });

        },
        QuitarLote: function (id_fila, valor) {
            if ($("#acc").val() === "2") {

                if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {
                    var plote = $("#" + id_fila).val().split("//");

                    var datos = {
                        ope: "delectLote",
                        cod: plote[7],
                        pre: plote[4],
                        idv: $("#txt_id").val()
                    }

                    $.ajax({
                        type: "POST",
                        url: "All.php",
                        data: datos,
                        success: function (data) {
                            if (data === "bien") {
                                alert("Operacion Realizada Exitosamente");
                                $.DetaLote();
                            }
                        },
                        error: function (error_messages) {
                            alert('HA OCURRIDO UN ERROR');
                        }
                    });
                    vtotalg = $('#txt_prec2').val();

                    vtotalg = vtotalg - plote[4];
                    $("#txt_PrecTot").val("$ " + number_format2(vtotalg, 2, ',', '.'));
                    $('#txt_prec2').val(vtotalg);
                }

            } else {
                $('#' + id_fila).remove();
                $.reordenarLote();
                contLote = $('#contLote').val();
                contLote = contLote - 1;
                $("#contLote").val(contLote);

                vtotalg = $('#txt_prec2').val();

                vtotalg = vtotalg - valor;
                $("#txt_PrecTot").val("$ " + number_format2(vtotalg, 2, ',', '.'));
                $('#txt_prec2').val(vtotalg);
            }



        },
        limpiarOsario: function () {

            $("#txt_jardinOsa").val("");
            $("#txt_nosa").val("");
            $("#txt_PreOsa").val("$ 0,00");
            $("#txt_CostruOsa").val("");
            $("#txt_obserOsa").val("");
            $("#CbTipOsa").selectpicker("val", "----");

        },
        reordenarOsario: function () {
            var num = 1;
            $('#tb_osar tbody tr').each(function () {
                $(this).find('td').eq(0).text(num);
                num++;
            });
            num = 1;
            $('#tb_osar tbody input').each(function () {
                $(this).attr('id', "Osario" + num);
                num++;
            });

        },
        QuitarOsario: function (id_fila, valor) {

            if ($("#acc").val() === "2") {

                if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {
                    var plote = $("#" + id_fila).val().split("//");

                    var datos = {
                        ope: "delectOsario",
                        cod: plote[6],
                        pre: plote[3],
                        idv: $("#txt_id").val()
                    }

                    $.ajax({
                        type: "POST",
                        url: "All.php",
                        data: datos,
                        success: function (data) {
                            if (data === "bien") {
                                alert("Operacion Realizada Exitosamente");
                                $.DetaOsario();
                            }
                        },
                        error: function (error_messages) {
                            alert('HA OCURRIDO UN ERROR');
                        }
                    });
                    vtotalg = $('#txt_prec2').val();

                    vtotalg = vtotalg - plote[3];
                    $("#txt_PrecTot").val("$ " + number_format2(vtotalg, 2, ',', '.'));
                    $('#txt_prec2').val(vtotalg);
                }

            } else {
                $('#' + id_fila).remove();
                $.reordenarLote();
                contOsa = $('#contOsa').val();
                contOsa = contOsa - 1;
                $("#contOsa").val(contOsa);

                vtotalg = $('#txt_prec2').val();

                vtotalg = vtotalg - valor;
                $("#txt_PrecTot").val("$ " + number_format2(vtotalg, 2, ',', '.'));
                $('#txt_prec2').val(vtotalg);
            }
        },
        QuitarNeces: function (id_fila, valor) {
            $('#' + id_fila).remove();
            $.reordenarPerso();
            contPers = $('#contPers').val();
            contPers = contPers - 1;
            $("#contPers").val(contPers);


        },
        SelCli: function (val) {
            var par = val.split("//");

            $("#txt_id_cli").val(par[0]);
            $("#txt_iden").val(par[1]);
            $("#txt_NomCli").val(par[2]);
            $("#CbSexo").selectpicker("val", par[3]);
            $("#txt_FecNac").val(par[4]);
            $("#txt_DirCli").val(par[5]);
            $("#txt_TelCli").val(par[6]);
            $("#txt_Dirbarrio").val(par[7]);
            $("#txtemail").val(par[8]);
            $("#txt_nuevo").val("NO");

            $('#clientes').modal('toggle');

        },
        conse: function () {

            var text = $("#atitulo").text();

            if (text === "Crear Contrato") {

                var datos = {
                    ope: "ConConsecutivo",
                    tco: "CONVENTA"
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

            }

        },
        SelNece: function (val) {
            var par = val.split("//");

            $("#txt_id_Nec").val(par[0]);
            $("#txt_nomNec").val(par[1]);
            $("#txt_Cant").val("1");
            $("#txt_Val").val(par[2]);
            $('#necesidad').modal('toggle');
        },
        OcupantesLote: function (val) {
            $("#id_ocup").val(val);
            $.DetaOcup('lote');
            $('#ventOcupa').modal('toggle');
        },
        OcupantesOsa: function (val) {
            $("#id_ocup").val(val);
            $.DetaOcup('osa');
            $('#ventOcupa').modal('toggle');
        },
        editContr: function (cod) {

            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);


            var datos = {
                ope: "BusqEditContraVenta",
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

                    $("#txt_Cod").val(data['pedido_contr']);
                    $("#txt_fecha_Cre").val(data['fecha_vent']);
                    $("#txt_Ciuda").val(data['ciudad_vent']);
                    $("#txt_Cuota").val(data['cuota_vent']);
                    $("#CbFpago").selectpicker("val", data['fpago_vent']);

                    $("#txt_NomMuert").val(data['muerto']);

                    $("#txt_prec2").val(data['precio']);

                    $("#txt_PrecTot").val("$ " + data['precios_vent']);
                    $("#txt_CuIniTot").val("$ " + data['valcuini_vent']);
                    $("#txt_CuMesTot").val("$ " + data['valcumes_vent']);

                    $("#txt_iden").val(data['inde_cli']);
                    $("#txt_NomCli").val(data['nom_cli']);
                    $("#CbSexo").selectpicker("val", data["sex_cli"]);
                    //  $("#txt_FecNac").val(data['fec_cli']);
                    $('#txt_DirCli').val(data["dir_cli"]);
                    $('#txt_TelCli').val(data["tel_cli"]);
                    $('#txt_TelCli').val(data["tel_cli"]);
                    $('#txt_Dirbarrio').val(data["barrio"]);
                    $('#txtemail').val(data["email_cli"]);
                    $('#txt_obsercion').val(data["observ"]);

                    $("#tb_Perso").html(data['CadPers']);
                    $("#contPers").val(data['cont']);

                    $("#tb_lote").html(data['CadLote']);
                    $("#contLote").val(data['contLote']);

                    $("#tb_osar").html(data['CadOsa']);
                    $("#contOsa").val(data['contOsa']);

                    if (data['fpago_vent'] === "CUOTAS") {
                        $("#txt_Cuota").prop('disabled', false);
                    } else {
                        $("#txt_Cuota").prop('disabled', true);
                    }


                }

            });

            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Contrato</a>");

        },
        EditOcu: function (cod) {
            $('#accOcu').val("2");
            $("#btn_nuevoOcu").prop('disabled', true);
            $("#btn_guardarOcup").prop('disabled', false);


            var datos = {
                ope: "BusqEditOcupa",
                cod: cod
            };

            $.ajax({
                async: false,
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#id_ocup").val(cod);

                    $("#txt_NomOcu").val(data['nombr']);
                    $("#txt_FechInhumOcu").val(data['fecha']);
                    $("#txt_obserOcu").val(data['obser']);

                }

            });

            $("#tab_01Ocu").removeClass("active in");
            $("#tab_01_ppOcu").removeClass("active in");
            $("#tab_02Ocu").addClass("active in");
            $("#tab_02_ppOcu").addClass("active in");

        },
        VerContr: function (cod) {

            $("#btn_guardar").prop('disabled', true);

            var datos = {
                ope: "BusqEditContraVenta",
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

                    $("#txt_Cod").val(data['pedido_contr']);
                    $("#txt_fecha_Cre").val(data['fecha_vent']);
                    $("#txt_Ciuda").val(data['ciudad_vent']);
                    $("#txt_Cuota").val(data['cuota_vent']);
                    $("#CbFpago").selectpicker("val", data['fpago_vent']);

                    $("#txt_NomMuert").val(data['muerto']);

                    $("#txt_prec2").val(data['precio']);

                    $("#txt_PrecTot").val("$ " + data['precios_vent']);
                    $("#txt_CuIniTot").val("$ " + data['valcuini_vent']);
                    $("#txt_CuMesTot").val("$ " + data['valcumes_vent']);

                    $("#txt_iden").val(data['inde_cli']);
                    $("#txt_NomCli").val(data['nom_cli']);
                    $("#CbSexo").selectpicker("val", data["sex_cli"]);
                    $("#txt_FecNac").val(data['fec_cli']);
                    $('#txt_DirCli').val(data["dir_cli"]);
                    $('#txt_TelCli').val(data["tel_cli"]);
                    $('#txt_Dirbarrio').val(data["barrio"]);
                    $('#txtemail').val(data["email_cli"]);
                    $('#txt_obsercion').val(data["observ"]);

                    $("#tb_Perso").html(data['CadPers']);
                    $("#contPers").val(data['cont']);

                    $("#tb_lote").html(data['CadLote']);
                    $("#contLote").val(data['contLote']);

                    $("#tb_osar").html(data['CadOsa']);
                    $("#contOsa").val(data['contOsa']);

                    if (data['fpago_vent'] === "CUOTAS") {
                        $("#txt_Cuota").prop('disabled', false);
                    } else {
                        $("#txt_Cuota").prop('disabled', true);
                    }


                }

            });


            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Ver Contrato</a>");


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
        PrintVent: function (val) {
            window.open("PDF_ContVenta.php?id=" + val + "", '_blank');
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
        busAct: function () {
            var datos = {
                ope: "VentActividades",
                tac: "ETAPA PREPARATIVA",
                bus: ""
            }


            $.ajax({
                type: "POST",
                url: "../All",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#tab_Actividades").show(100).html(data['tabla_actividades']);
                }
//                error: function (error_messages) {
//                    alert('HA OCURRIDO UN ERROR');
//                }
            });
            $("#responsiveAct").modal();
            //  $('#mopc').hide();



        },
        deletContr: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "GuardarContratoVenta.php",
                    data: datos,
                    success: function (data) {
                        var padata = data.split("/");
                        if (trimAll(padata[0]) === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.Contra();
                        }else{
                              alert("No se puede Eliminar la El Contrato de Venta porque tiene Pagos Relacionados");
                        }
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        DelOcup: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    ope: "delectOcupa",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "All.php",
                    data: datos,
                    success: function (data) {
                        if (data === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.DetaOcup();
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
                url: "PagConratoVenta.php",
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
                url: "PagConratoVenta.php",
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
                url: "PagConratoVenta.php",
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
                    $("#CbIgle").html(data['igle']);
                    $("#CbCem").html(data['ceme']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });



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
        AddDetalles: function () {

            var valTot = 0;

            if ($('#txt_lote').val() !== "") {
                $('#tconc1F').show();
                $('#tval1F').show();

                var concep1 = "VENTA DE LOTE TIPO " + $('#CbTipLote').val() + " UBICADO EN EL JARDIN " + $('#txt_jardin').val() + " ZONA " + $('#txt_zona').val() + " LOTE No. " + $('#txt_lote').val();

                $('#txt_Concep1F').val(concep1);
                $('#txt_Val1F').val($('#txt_CuIni').val());

                var txt_Val = $('#txt_CuIni').val().split(" ");
                valTot = parseFloat(txt_Val[1].replace(".", "").replace(".", "").replace(",", "."));

            } else {
                $('#tconc1F').hide();
                $('#tval1F').hide();
            }

            if ($('#CbTipOsa').val() !== "----") {
                $('#tconc2F').show();
                $('#tval2F').show();

                var concep2 = "VENTA DE OSARIO TIPO " + $('#CbTipOsa').val();

                $('#txt_Concep2F').val(concep2);
                $('#txt_Val2F').val($('#txt_CuIniOsa').val());


                var txt_Val = $('#txt_CuIniOsa').val().split(" ");
                valTot = parseFloat(valTot) + parseFloat(txt_Val[1].replace(".", "").replace(".", "").replace(",", "."));

            } else {
                $('#tconc2F').hide();
                $('#tval2F').hide();
            }



            $('#txt_ValTotF').val("$ " + number_format2(valTot, 2, ',', '.'));
            $.NumLetr(valTot);


        },
        NumLetr: function (num) {
            //  $("#txt_vtotalFactF").val(num);
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
        Dta_Perso: function () {
            Dat_Perso = "";
            $("#tb_Perso").find(':input').each(function () {
                Dat_Perso += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Perso += "&Long_Perso=" + $("#contPers").val();

        },
        Dta_DetLote: function () {
            Dat_DetLote = "";
            $("#tb_lote").find(':input').each(function () {
                Dat_DetLote += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_DetLote += "&Long_Lote=" + $("#contLote").val();

        },
        Dta_ConcepConst: function () {
            Dat_ConceptosCost = "";
            $("#tb_Constancia").find(':input').each(function () {
                Dat_ConceptosCost += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_ConceptosCost += "&Long_ConcetCost=" + $("#contConst").val();

        },
        Dta_ConcepFact: function () {
            Dat_ConceptosFact = "";
            $("#tb_Factura").find(':input').each(function () {
                Dat_ConceptosFact += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_ConceptosFact += "&Long_ConcetFact=" + $("#contFactura").val();

        },
        Dta_DetOsa: function () {
            Dat_DetOsa = "";
            $("#tb_osar").find(':input').each(function () {
                Dat_DetOsa += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_DetOsa += "&Long_Osa=" + $("#contOsa").val();

        },
        EditarLote: function (id) {
            datos = $("#" + id).val();
            pdatos = datos.split("//");

            $("#txt_jardin").val(pdatos[0]);
            $('#txt_zona').val(pdatos[1]);
            $('#txt_lote').val(pdatos[2]);
            $("#CbTipLote").selectpicker("val", pdatos[3]);
            $('#txt_Prec').val("$ " + number_format2(pdatos[4], 2, ',', '.'));
            $('#txt_PrecAnt').val(pdatos[4]);
            $('#txt_CostruLot').val(pdatos[5]);
            $('#txt_obser').val(pdatos[6]);
            $('#txt_IdLote').val(pdatos[7]);

            $("#btn_addlote").html('<a onclick="$.AddLoteBD(2)"  class="btn blue"> Modificar <i class="fa fa-edit"></i></a>');

        },
        EditDetPagos: function (id) {
            $("#DetallPago").modal();
            $("#acc_detpago").val("2");
            $("#id_deta_pago").val(id);

            $("#btn_nuevoDet").prop('disabled', true);
            $("#btn_guardarDet").prop('disabled', false);
            $("#txt_fecha_Pago").prop('disabled', false);
            $("#txt_fecha_PagoHas").prop('disabled', false);
            $("#txt_obserDetPag").prop('disabled', false);

            var datos = {
                id: id,
                ope: "EditPagosVenta",
                idve: $("#id_venta").val()
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#txt_fecha_Pago').val(data['fpago']);
                    $('#txt_fecha_PagoHas').val(data['fpago']);
                    $('#txt_obserDetPag').val(data['observ']);
                    $("#txt_ValCuota").val("$ " + number_format2(data['valor'], 2, ',', '.'));
                    $.Deta();
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        DelDetPagos: function (id) {
            var parde = id.split("/");
            $("#id_deta_pago").val(parde[0]);


            if (confirm("\xbfEsta seguro de realizar la Operaci\xf3n?")) {
                var datos = {
                    id: parde[0],
                    ope: "DeletPagosVenta",
                    idve: $("#id_venta").val(),
                    val: parde[1]
                };

                $.ajax({
                    type: "POST",
                    url: "All.php",
                    data: datos,
                    success: function (data) {
                        if (trimAll(data) === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.Deta();
                        }
                    }
                });
            }
        },
        EditarOsario: function (id) {
            datos = $("#" + id).val();

            pdatos = datos.split("//");

            $("#txt_jardinOsa").val(pdatos[0]);
            $('#txt_nosa').val(pdatos[1]);
            $("#CbTipOsa").selectpicker("val", pdatos[2]);
            $('#txt_PreOsa').val("$ " + number_format2(pdatos[3], 2, ',', '.'));
            $('#txt_PrecAntOsa').val(pdatos[3]);
            $('#txt_CostruOsa').val(pdatos[4]);
            $('#txt_obserOsa').val(pdatos[5]);
            $('#txt_IdOsa').val(pdatos[6]);

            $("#btn_addOsario").html('<a onclick="$.AddOsarioBD(2)"  class="btn blue"> Modificar <i class="fa fa-edit"></i></a>');


        }

    });

    //======FUNCIONES========\\
    $.Contra();
    $.CargaDatos();

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
                $("#txt_Dirbarrio").val(data['barrio']);
                $("#txt_TelCli").val(data['tel_cli']);
                $("#txtemail").val(data['email_cli']);
                $("#txt_nuevo").val(data['cliex']);
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });

    $("#CbCeme").on("change", function () {
        var cem = $("#CbCeme").val();

        if (cem === "NUEVO") {
            $("#ubbov").show();
            $("#ubjar").toggle();
            $("#txt_jardin").val("");
            $("#txt_zona").val("");
            $("#txt_lote").val("");
        } else {
            $("#ubjar").show();
            $("#ubbov").toggle();
            $("#txt_boveda").val("");
        }

    });

    $("#CbFpago").on("change", function () {
        if ($("#CbFpago").val() === "CUOTAS") {
            $("#txt_Cuota").prop('disabled', false);
        } else {
            $("#txt_Cuota").prop('disabled', true);
            $("#txt_Cuota").val("");
        }
    });

    $("#btn_constancia").on("click", function () {
        $('#tb_Constancia').html("<thead>"
                + "                                      <tr>"
                + "                                        <td>"
                + "                                            <i class='fa fa-angle-right'></i> #"
                + "                                        </td>"
                + "                                        <td>"
                + "                                           <i class='fa fa-angle-right'></i> Concepto"
                + "                                       </td>"
                + "                                       <td>"
                + "                                          <i class='fa fa-angle-right'></i> Valor"
                + "                                      </td>"
                + "                                  </tr>"
                + "                              </thead>"
                + "                              <tbody >"
                + "                              </tbody>"
                + "                              <tfoot>"
                + "                              <tr>"
                + "                                  <th colspan='2' style='text-align: right;'>Total a Pagar:</th>"
                + "                                  <th colspan='1'><label id='gtotalCostancia' style='font-weight: bold;'></label></th>"
                + "                              </tr>"
                + "                            </tfoot>");
        $('#tab_constPP').show();
        $("#tab_infPP").removeClass("active in");
        $("#tab_inf").removeClass("active in");
        $("#tab_constPP").addClass("active in");
        $("#tab_const").addClass("active in");

        $.conseCos();

        $('#txt_CiudaCons').val($('#txt_Ciuda').val());
        $('#txt_idenconst').val($('#txt_iden').val());
        $('#txt_NomCliConst').val($('#txt_NomCli').val());
        $('#txt_DirConst').val($('#txt_DirCli').val());
        $('#txt_TelCliConst').val($('#txt_TelCli').val());

        var valTot = 0;
        var cont = 0;
        var fila = "";
        $("#tb_lote").find(':input').each(function () {
            cont += 1;
            var parlot = $(this).val().split("//");
            var concep1 = "VENTA DE LOTE TIPO " + parlot[3] + " UBICADO EN EL JARDIN " + parlot[0] + " ZONA " + parlot[1] + " LOTE No. " + parlot[2];
            var valor = "$ " + number_format2(parseFloat(parlot[4]), 2, ',', '.');

            fila = '<tr class="selected" id="filaConsta' + cont + '" >';

            fila += "<td>" + cont + "</td>";
            fila += "<td>" + concep1 + "</td>";
            fila += "<td>" + valor + "</td>";

            fila += "<td><input type='hidden' id='consta" + cont + "' name='consta' value='" + concep1 + "//" + parlot[4] + "' />";


            $('#tb_Constancia').append(fila);

        });

        $("#tb_osar").find(':input').each(function () {
            cont += 1;

            var parlot = $(this).val().split("//");
            var concep2 = "VENTA DE OSARIO TIPO " + parlot[2] + " UBICADO EN EL JARDIN:" + parlot[0] + " No." + parlot[1];


            var valor = "$ " + number_format2(parseFloat(parlot[3]), 2, ',', '.');

            fila = '<tr class="selected" id="filaConsta' + cont + '" >';

            fila += "<td>" + cont + "</td>";
            fila += "<td>" + concep2 + "</td>";
            fila += "<td>" + valor + "</td>";

            fila += "<td><input type='hidden' id='consta" + cont + "' name='consta' value='" + concep2 + "//" + parlot[3] + "' />";


            $('#tb_Constancia').append(fila);

        });
        $('#contConst').val(cont);
        $('#gtotalCostancia').html($("#txt_CuIniTot").val());

    });

    $("#btn_CostaciaDetPag").on("click", function () {

        $('#tab_constPP').show();
        $("#DetallPago").modal('hide');

        $("#tab_01").removeClass("active in");
        $("#tab_01_pp").removeClass("active in");
        $("#tab_03").removeClass("active in");
        $("#tab_03_pp").removeClass("active in");
        $("#tab_02").addClass("active in");
        $("#tab_02_pp").addClass("active in");


        $("#tab_infPP").removeClass("active in");
        $("#tab_inf").removeClass("active in");

        $("#tab_constPP").addClass("active in");
        $("#tab_const").addClass("active in");

        var datos = {
            ope: 'consultarDetVenta',
            id: $("#id_venta").val()
        };


        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {
//                $("#gtotalDetLetra").html("SON: " + data['letra']);
//                $("#txt_valetra").val("SON: " + data['letra']);

                $('#txt_CiudaCons').val(data['ciudad_vent']);
                $('#txt_idenconst').val(data['ident_vent']);
                $('#txt_NomCliConst').val(data['nombre_venta']);
                $('#txt_DirConst').val(data['dir_cli']);
                $('#txt_TelCliConst').val(data['tel_cli']);


                $('#tb_Constancia').html(data['Cad']);
                $('#contConst').val(data['cont']);
                $('#txt_CuIniTot').val("$ " + number_format2(data['valcumes_vent'], 2, ',', '.'));
                // $('#gtotalCostancia').html("$ " + number_format2(data['valcumes_vent'], 2, ',', '.'));


                //     $('#txt_ValTot').val("$ " + number_format2(valTot, 2, ',', '.'));
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });



        $.conseCos();
    });


    $("#btn_factura").on("click", function () {


        $('#tb_Factura').html("<thead>"
                + "                                      <tr>"
                + "                                        <td>"
                + "                                            <i class='fa fa-angle-right'></i> #"
                + "                                        </td>"
                + "                                        <td>"
                + "                                           <i class='fa fa-angle-right'></i> Concepto"
                + "                                       </td>"
                + "                                       <td>"
                + "                                          <i class='fa fa-angle-right'></i> Valor"
                + "                                      </td>"
                + "                                  </tr>"
                + "                              </thead>"
                + "                              <tbody >"
                + "                              </tbody>"
                + "                              <tfoot>"
                + "                              <tr>"
                + "                                  <th colspan='2' style='text-align: right;'>Total a Pagar:</th>"
                + "                                  <th colspan='1'><label id='gtotalFactura' style='font-weight: bold;'></label></th>"
                + "                              </tr>"
                + "                            </tfoot>");
        $('#tab_factPP').show();
        $("#tab_infPP").removeClass("active in");
        $("#tab_inf").removeClass("active in");
        $("#tab_constPP").removeClass("active in");
        $("#tab_const").removeClass("active in");

        $("#tab_factPP").addClass("active in");
        $("#tab_fact").addClass("active in");

        $.conseFact();

        $('#txt_CiudaFact').val($('#txt_Ciuda').val());
        $('#txt_idenFact').val($('#txt_iden').val());
        $('#txt_NomCliFact').val($('#txt_NomCli').val());
        $('#txt_DirFact').val($('#txt_DirCli').val());
        $('#txt_TelCliFact').val($('#txt_TelCli').val());


        var valTot = 0;
        var cont = 0;
        var fila = "";
        $("#tb_lote").find(':input').each(function () {
            cont += 1;
            var parlot = $(this).val().split("//");
            var concep1 = "VENTA DE LOTE TIPO " + parlot[3] + " UBICADO EN EL JARDIN " + parlot[0] + " ZONA " + parlot[1] + " LOTE No. " + parlot[2];
            var valor = "$ " + number_format2(parseFloat(parlot[4]), 2, ',', '.');

            fila = '<tr class="selected" id="filaFact' + cont + '" >';

            fila += "<td>" + cont + "</td>";
            fila += "<td>" + concep1 + "</td>";
            fila += "<td>" + valor + "</td>";

            fila += "<td><input type='hidden' id='fact" + cont + "' name='fact' value='" + concep1 + "//" + parlot[4] + "' />";


            $('#tb_Factura').append(fila);

        });

        $("#tb_osar").find(':input').each(function () {
            cont += 1;

            var parlot = $(this).val().split("//");
            var concep2 = "VENTA DE OSARIO TIPO " + parlot[2] + " UBICADO EN EL JARDIN:" + parlot[0] + " No." + parlot[1];


            var valor = "$ " + number_format2(parseFloat(parlot[3]), 2, ',', '.');

            fila = '<tr class="selected" id="filaFact' + cont + '" >';

            fila += "<td>" + cont + "</td>";
            fila += "<td>" + concep2 + "</td>";
            fila += "<td>" + valor + "</td>";

            fila += "<td><input type='hidden' id='fact" + cont + "' name='fact' value='" + concep2 + "//" + parlot[3] + "' />";


            $('#tb_Factura').append(fila);

        });
        $('#contFactura').val(cont);

        $('#gtotalFactura').html($("#txt_CuIniTot").val());
        var precio = $("#txt_CuIniTot").val().split(" ");
        var precioTot = precio[1].replace(".", "").replace(".", "").replace(",", ".");
        $.NumLetr(precioTot);

    });


    $("#btn_volver").on("click", function () {
        window.location.href = "AdminServicios.php";
    });

    $("#btn_impri").on("click", function () {
        window.open("PDF_ContVenta.php?id=" + $('#txt_id').val() + "", '_blank');
    });
    $("#btn_impriCost").on("click", function () {
        window.open("PDF_ConstVenta.php?id=" + $('#txt_idCost').val() + "", '_blank');
    });

    $("#btn_impriFact").on("click", function () {
        window.open("PDF_FacturaVenta.php?id=" + $('#txt_idFact').val() + "", '_blank');
    });


    $("#btn_cancelar").on("click", function () {
        window.location.href = 'GesContratoVenta.php';
    });


    $("#btn_nuevoOcu").on("click", function () {

        $("#accOcu").val('1');
        $("#txt_NomOcu").val('');
        $("#txt_FechInhumOcu").val('');
        $("#txt_obserOcu").val('');

        $("#txt_NomOcu").prop('disabled', false);
        $("#txt_FechInhumOcu").prop('disabled', false);
        $("#txt_obserOcu").prop('disabled', false);

        $("#btn_nuevoOcu").prop('disabled', true);
        $("#btn_guardarOcup").prop('disabled', false);
    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {


        if ($('#txt_Cod').val() === "") {
            alert("Ingrese LA Orden de Inhumacion");
            $('#txt_Cod').focus();
            return;
        }

        if ($('#txt_NomMuert').val() === "") {
            alert("Ingrese el Nombre del Fallecido");
            $('#txt_NomMuert').focus();
            return;
        }

        if ($('#txt_iden').val() === "") {
            alert("Ingrese la Identificacion del Contratante");
            $('#txt_iden').focus();
            return;
        }

        $.Dta_Perso();
        $.Dta_DetLote();
        $.Dta_DetOsa();

        var precio = $("#txt_PrecTot").val().split(" ");
        var precioTot = precio[1].replace(".", "").replace(".", "").replace(",", ".");

        var CuIni = $("#txt_CuIniTot").val().split(" ");
        var CuIniTot = CuIni[1].replace(".", "").replace(".", "").replace(",", ".");

        var CuMes = $("#txt_CuMesTot").val().split(" ");
        var CuMesTot = CuMes[1].replace(".", "").replace(".", "").replace(",", ".");



        var datos = "PedContra=" + $("#txt_Cod").val() + "&fcreac=" + $("#txt_fecha_Cre").val()
                + "&txt_Ciuda=" + $("#txt_Ciuda").val() + "&txt_Cuota=" + $("#txt_Cuota").val()
                + "&CbFpago=" + $("#CbFpago").val() + "&txt_Prec=" + precioTot
                + "&txt_CuIni=" + CuIniTot + "&txt_CuMes=" + CuMesTot
                + "&txt_iden=" + $("#txt_iden").val() + "&txt_obser=" + $("#txt_obsercion").val()
                + "&txt_NomCli=" + $("#txt_NomCli").val() + "&CbSexo=" + $("#CbSexo").val()
                + "&txt_FecNac=" + $("#txt_FecNac").val() + "&txt_DirCli=" + $("#txt_DirCli").val() + "&txtemail=" + $("#txtemail").val()
                + "&txt_TelCli=" + $("#txt_TelCli").val() + "&txt_Dirbarrio=" + $("#txt_Dirbarrio").val() + "&acc=" + $("#acc").val()
                + "&id=" + $("#txt_id").val() + "&txt_nuevo=" + $("#txt_nuevo").val() + "&cons=" + $("#cons").val();


        var Alldata = datos + Dat_Perso + Dat_DetLote + Dat_DetOsa;

        $.ajax({
            type: "POST",
            url: "GuardarContratoVenta.php",
            data: Alldata,
            success: function (data) {
                var padata = data.split("/");
                if (trimAll(padata[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.Contra();
                    $("#txt_id").val(padata[1]);
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);
                    $('#btn_impri').show();
//                    $('#btn_constancia').show();
//                    $('#btn_factura').show();
                    $('#btn_Pago').show();

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



    //BOTON GUARDAR DETALLE PAGO-
    $("#btn_Pago").on("click", function () {

        $.AddPago($("#txt_id").val());

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

        var pvalmes = $("#txt_ValCuota").val().split(" ");
        var valmes = pvalmes[1].replace(".", "").replace(".", "").replace(",", ".");

        var datos = {
            ope: 'InserDetaPagVent',
            fpag: $("#txt_fecha_Pago").val(),
            valp: valmes,
            fven: $("#txt_fecha_PagoHas").val(),
            obs: $("#txt_obserDetPag").val(),
            sal: $("#saldo").val(),
            vent: $("#id_venta").val(),
            acc: $("#acc_detpago").val(),
            id: $("#id_deta_pago").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            success: function (data) {
                if (data === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.Deta();
                    $("#btn_nuevoDet").prop('disabled', false);
                    $("#btn_CostaciaDetPag").prop('disabled', false);
                    $("#btn_guardarDet").prop('disabled', true);

                    $("#txt_fecha_Pago").prop('disabled', true);
                    $("#txt_fecha_PagoHas").prop('disabled', true);
                    $("#txt_obserDetPag").prop('disabled', true);


                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });
    //BOTON GUARDAR OCUPACION-
    $("#btn_guardarOcup").on("click", function () {


        if ($('#txt_NomOcu').val() === "") {
            alert("Ingres el Nombre");
            $('#txt_NomOcu').focus();
            return;
        }

        if ($('#txt_FechInhumOcu').val() === "") {
            alert("Ingrese La Fecha de Inhumacion");
            $('#txt_FechInhumOcu').focus();
            return;
        }

        var datos = {
            ope: 'InsertOcupacion',
            nom: $("#txt_NomOcu").val(),
            fec: $("#txt_FechInhumOcu").val(),
            obs: $("#txt_obserOcu").val(),
            ido: $("#id_ocup").val(),
            idv: $("#txt_id").val(),
            acc: $("#accOcu").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            success: function (data) {
                if (data === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.DetaOcup();
                    $("#btn_nuevoOcu").prop('disabled', false);
                    $("#btn_guardarOcup").prop('disabled', true);

                    $("#txt_NomOcu").prop('disabled', true);
                    $("#txt_FechInhumOcu").prop('disabled', true);
                    $("#txt_obserOcu").prop('disabled', true);
                }
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
        if ($('#CbConsig').val() === " ") {
            alert("Seleccione la Consignación");
            $('#CbConsig').focus();
            return;
        }

        if ($('#txt_NomCliConst').val() === "") {
            alert("Nombre de quien Consigna");
            $('#txt_NomCliConst').focus();
            return;
        }

        $.Dta_ConcepConst();

        var precio = $("#txt_CuIniTot").val().split(" ");
        var precioTot = precio[1].replace(".", "").replace(".", "").replace(",", ".");

        var datos = "consec=" + $("#txt_CodConst").val() + "&fcreac=" + $("#txt_fecha_CreCos").val()
                + "&txt_Ciuda=" + $("#txt_CiudaCons").val() + "&txt_fecha_Cons=" + $("#txt_fecha_Cons").val()
                + "&txt_iden=" + $("#txt_idenconst").val() + "&txt_NomCli=" + $("#txt_NomCliConst").val()
                + "&txt_DirCli=" + $("#txt_DirConst").val() + "&txt_TelCli=" + $("#txt_TelCliConst").val()
                + "&CbConsig=" + $("#CbConsig").val() + "&ValTot=" + precioTot
                + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val()
                + "&conse=" + $("#consConst").val() + "&txt_nuevo=NO";


        var Alldata = datos + Dat_ConceptosCost;

        $.ajax({
            type: "POST",
            url: "GuardarConstanciaConsigVenta.php",
            data: Alldata,
            success: function (data) {

                var padata = data.split("/");
                if (trimAll(padata[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    //  $.Contra();
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
    
    
    
    $("#btn_impriReport").on("click", function () {
           window.open("Print_ContrVentas.php", '_blank');
    });
    
    //BOTON GUARDAR  FACTURA-
    $("#btn_guardarFact").on("click", function () {

        if ($('#txt_CodFact').val() === "") {
            alert("Ingrese El Consecutivo");
            $('#txt_CodFact').focus();
            return;
        }
        if ($('#CbFpagoFact').val() === " ") {
            alert("Seleccione la Forma de Pago");
            $('#CbFpagoFact').focus();
            return;
        }

        if ($('#txt_NomCliFact').val() === "") {
            alert("Nombre del Cliente");
            $('#txt_NomCliFact').focus();
            return;
        }

        $.Dta_ConcepFact();
        var precio = $("#txt_CuIniTot").val().split(" ");
        var precioTot = precio[1].replace(".", "").replace(".", "").replace(",", ".");


        var datos = "consec=" + $("#txt_CodFact").val() + "&fcreac=" + $("#txt_fecha_CreFact").val()
                + "&txt_Ciuda=" + $("#txt_CiudaFact").val() + "&txt_iden=" + $("#txt_idenFact").val()
                + "&txt_NomCli=" + $("#txt_NomCliFact").val() + "&CbFpago=" + $("#CbFpagoFact").val()
                + "&txt_DirCli=" + $("#txt_DirFact").val() + "&txt_TelCli=" + $("#txt_TelCliFact").val()
                + "&txt_vtotalFact=" + precioTot + "&txt_valetra=" + $("#txt_valetra").val()
                + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val()
                + "&conse=" + $("#consFact").val() + "&txt_idCost=" + $("#txt_idCost").val();


        var Alldata = datos + Dat_ConceptosFact;
        $.ajax({
            type: "POST",
            url: "GuardarFacturaVenta.php",
            data: Alldata,
            success: function (data) {

                var padata = data.split("/");
                if (trimAll(padata[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");

                    $("#txt_idFact").val(padata[1]);
                    $("#btn_guardarFact").prop('disabled', true);
                    $('#btn_impriFact').show();
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
