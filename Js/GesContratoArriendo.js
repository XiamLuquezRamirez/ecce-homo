$(document).ready(function () {
    var Order = "b.nom_proyect ASC";
    // $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_serv").addClass("start active open");
    $("#menu_serv_arri").addClass("active");

//   $("#CbProyect,#CbDepen,#CbResp,#CbElab,#CbContratista,#CbDepa,#CbRubPres,#CbMod,#CbTipCont").select2();


    $("#txt_fecha_DesdPro,#txt_fecha_HastPro,#txt_fecha_Cre, #txt_fecha_Desd, #txt_fecha_Fall,#txt_FecNac,#txt_fecha_CreCos,#txt_fecha_Cons,#txt_fecha_CreFact").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });

    $("#txt_fecha_sepe").datetimepicker({
        isRTL: Metronic.isRTL(),
        format: "yyyy-mm-dd - HH:ii P",
        showMeridian: true,
        autoclose: true,
        pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left"),
        todayBtn: true,
        language: 'es'
    });

    $("#CbTiemPro,#CbFacNombFact,#CbFacNombCos,#CbCeme,#CbTiem,#CbSala,#CbSexo,#CbConsig,#CbFpago,#CbFormMuert,#CbEstado").selectpicker();


    var contNec = 0;
    var vtotalg = 0;
    var Dat_Nece = "";


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
            }

            $.ajax({
                type: "POST",
                url: "PagConratoArriendo.php",
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

            }

            $.ajax({
                type: "POST",
                url: "PagConratoArriendo.php",
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
        AddProrroga: function (id) {

            $("#txt_id").val(id);
            //  $("#txt_idcont").val(id);
            var datos = {
                ope: "CargDatArri",
                id: id
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#CodContr').html(data['OrdInhum']);
                    $("#txt_cement").val(data['cemen']);
                    if (data['cemen'] === "NUEVO") {
                        $('#ArriePro').html(" BOVEDA: " + data['boveda']);
                        $('#FechaVPro').html(data['hasta']);
                        $('#CementPro').html("CEMENTERIO NUEVO");

                    } else {
                        $('#ArriePro').html(" JARDIN: " + data['jardin'] + "  ZONA: " + data['zona'] + "  LOTE: " + data['lote']);
                        $('#FechaVPro').html(data['hasta']);
                        $('#CementPro').html("JARDINES DEL ECCE HOMO");

                    }

                    $('#div_rec').show();


                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $.CargarProrrog(id);
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");

            $('#tab_ProrrPP').show();
            $("#tab_infPP").removeClass("active in");
            $("#tab_inf").removeClass("active in");
            $("#tab_factPP").removeClass("active in");
            $("#tab_fact").removeClass("active in");
            $("#tab_constPP").removeClass("active in");
            $("#tab_const").removeClass("active in");
            $("#tab_ProrrPP").addClass("active in");
            $("#tab_Prorr").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Contrato</a>");


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
                    $("#tab_Clientes").html(data['tab_cli']);
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
            $("#CbSexo").selectpicker("val", par[3]);
            $("#txt_FecNac").val(par[4]);
            $("#txt_DirCli").val(par[5]);
            $("#txt_TelCli").val(par[6]);
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
        editContr: function (cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);


            var datos = {
                ope: "BusqEditContraArriendo",
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

                    $("#txt_Cod").val(data['OrdInhum']);
                    $("#txt_fecha_Cre").val(data['fec_crea']);
                    $("#txt_Ciuda").val(data['ciuda']);
                    $("#CbCeme").selectpicker("val", data["cemen"]);
                    $("#txt_boveda").val(data['boveda']);
                    $("#txt_jardin").val(data['jardin']);
                    $("#txt_zona").val(data['zona']);
                    $("#txt_lote").val(data['lote']);
                    $("#txt_NomMuert").val(data['muerto']);
                    patiem = data['tiempo'].split(" ");
                    $("#txt_tiem").val(patiem[0]);
                    $("#CbTiem").selectpicker("val", $.CambiarLetra_Doc(patiem[1]));
                    $("#txt_fecha_Desd").val(data['desde']);
                    $("#txt_fecha_Hast").val(data['hasta']);
                    $("#txt_fecha_Fall").val(data['fec_falle']);
                    $("#txt_Fune").select2("val", data['funeraria']);
                    $("#txt_fecha_sepe").val(data['fec_sepe']);
                    $("#txt_Tel").val(data['telef']);
                    $("#txt_iden").val(data['ced_cli']);
                    $("#txt_NomCli").val(data['nom_cli']);
                    $("#CbSexo").selectpicker("val", data["sex_cli"]);
                    $("#txt_FecNac").val(data['fec_cli']);
                    $('#txt_DirCli').val(data["dir_cli"]);
                    $('#txt_TelCli').val(data["tel_cli"]);
                    $('#txt_Dirbarrio').val(data["barrio"]);
                    $('#txt_obsercion').val(data["observ"]);
                    $('#txtemail').val(data["email_cli"]);
                    $("#CbFormMuert").selectpicker("val", data["form_muerte"]);
                    $("#CbEstado").selectpicker("val", data["estado_contrato"]);



                    if (data["cemen"] === "NUEVO") {
                        $("#ubbov").show();
                        $("#ubjar").hide();
                    } else {
                        $("#ubjar").show();
                        $("#ubbov").hide();
                    }

                    $('#btn_impri').show();
                    $('#btn_impriAut').show();
                    $('#btn_constancia').show();
                    if ($("#per_fact").val() === "s") {
                        $('#btn_factura').show();
                    }

                },
                beforeSend: function () {
                    $('#cargando').modal('show');
                },
                complete: function () {
                    $('#cargando').modal('hide');
                }

            });


            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Contrato</a>");


        },
        VerContr: function (cod) {
            $('#btn_impri').show();
            $('#btn_impriAut').show();
            $("#btn_guardar").prop('disabled', true);
            var datos = {
                ope: "BusqEditContraArriendo",
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

                    $("#txt_Cod").val(data['OrdInhum']);
                    $("#txt_fecha_Cre").val(data['fec_crea']);
                    $("#txt_Ciuda").val(data['ciuda']);
                    $("#CbCeme").selectpicker("val", data["cemen"]);
                    $("#txt_boveda").val(data['boveda']);
                    $("#txt_jardin").val(data['jardin']);
                    $("#txt_zona").val(data['zona']);
                    $("#txt_lote").val(data['lote']);
                    $("#txt_NomMuert").val(data['muerto']);
                    patiem = data['tiempo'].split(" ");
                    $("#txt_tiem").val(patiem[0]);
                    $("#CbTiem").selectpicker("val", patiem[1]);
                    $("#txt_fecha_Desd").val(data['desde']);
                    $("#txt_fecha_Hast").val(data['hasta']);
                    $("#txt_fecha_Fall").val(data['fec_falle']);
                    $("#txt_Fune").select2("val", data['funeraria']);
                    $("#txt_fecha_sepe").val(data['fec_sepe']);
                    $("#txt_Tel").val(data['telef']);
                    $("#txt_iden").val(data['ced_cli']);
                    $("#txt_NomCli").val(data['nom_cli']);
                    $("#CbSexo").selectpicker("val", data["sex_cli"]);
                    $("#txt_FecNac").val(data['fec_cli']);
                    $('#txt_DirCli').val(data["dir_cli"]);
                    $('#txt_TelCli').val(data["tel_cli"]);
                    $('#txt_Dirbarrio').val(data["barrio"]);
                    $('#txt_obsercion').val(data["observ"]);
                    $('#txtemail').val(data["email_cli"]);
                    $("#CbFormMuert").selectpicker("val", data["form_muerte"]);


                    if (data["cemen"] === "NUEVO") {
                        $("#ubbov").show();
                        $("#ubjar").hide();
                    } else {
                        $("#ubjar").show();
                        $("#ubbov").hide();
                    }

                    $('#btn_impri').show();
                    $('#btn_impriAut').show();
                    $('#btn_constancia').show();
                    if ($("#per_fact").val() === "s") {
                        $('#btn_factura').show();
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
                    $("#tab_Nece").show(100).html(data['tab_cli']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#necesidad").modal();


        },
        PrintContr: function (val) {
            window.open("PDF_ContArriendo.php?id=" + val + "", '_blank');
        },
        PrintAuto: function (val) {
            window.open("PDF_AutoEntrada.php?id=" + val + "", '_blank');
        },
        NewFune: function () {
            window.open("GesFunerarias.php", '_blank');
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
                    $("#txt_Fune").html(data['fune']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        calfecha: function () {

            var datos = {
                ope: "SumaFecha",
                fei: $("#txt_fecha_Desd").val(),
                tie: $("#CbTiem").val(),
                nsu: $("#txt_tiem").val()
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_fecha_Hast").val(data["nuevaFecha"]);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        calfecha2: function () {

            if ($("#CbTiem").val() !== " " && $("#txt_fecha_Desd").val() !== "") {
                var datos = {
                    ope: "SumaFecha",
                    fei: $("#txt_fecha_Desd").val(),
                    tie: $("#CbTiem").val(),
                    nsu: $("#txt_tiem").val()
                };

                $.ajax({
                    type: "POST",
                    url: "All.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                        $("#txt_fecha_Hast").val(data["nuevaFecha"]);
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }


        },
        calfechaPro: function () {

            var datos = {
                ope: "SumaFecha",
                fei: $("#txt_fecha_DesdPro").val(),
                tie: $("#CbTiemPro").val(),
                nsu: $("#txt_tiemPro").val()
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#txt_fecha_HastPro").val(data["nuevaFecha"]);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
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
                    url: "GuardarContratoArri.php",
                    data: datos,
                    success: function (data) {
                        var padata = data.split("/");
                        if (trimAll(padata[0]) === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.Contra();
                        } else {
                            alert("No se puede Eliminar la El Contrato de Arriendo porque este se encuentra relacionado a una Factura o Constancia");
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
                url: "PagConratoArriendo.php",
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
                url: "PagConratoArriendo.php",
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
                url: "PagConratoArriendo.php",
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

                    $("#txt_Fune").html(data['fune']);
                    $("#CbIgle").html(data['igle']);
                    $("#CbCem").html(data['ceme']);

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
//                    $('#txt_NomFall').val(data['nomfall_req']);
//                    $('#txt_FecNacFall').val(data['fecnfall_req']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        CargarProrrog: function (id) {



            var datos = {
                ope: "BusHistProrrog",
                id: id
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tb_HistProrrog').html(data['pro']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        },
        conse: function (tco) {

            var text = $("#atitulo").text();

            if (text === "Crear Contrato") {

                var datos = {
                    ope: "ConConsecutivo",
                    tco: tco
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
//        ReciboProrroga: function (rec) {
//           
//
//        },
        AddDetalles: function () {

            var concep = "";


            concep = $('#txt_tiem').val() + " " + $('#CbTiem').val();
            var cem = $("#CbCeme").val();

            if (cem === "NUEVO") {
                concep += " DE ARRIENDO DE BOVEDA PARA EL DIFUNTO ";
            } else {
                concep += " DE ARRIENDO DE LOTE PARA EL DIFUNTO ";
            }
            concep += $('#txt_NomMuert').val() + " FALLECIDO EN LA FECHA " + $('#txt_fecha_Fall').val();

            $('#txt_Detalle').val(concep);



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
                    //  $('#txt_NomFall').val(data['nomfall_req']);
                    //  $('#txt_FecNacFall').val(data['fecnfall_req']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
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

                    $("#gtotalDetLetra").html("SON: " + data['letra']);
                    $("#txt_valetra").val("SON: " + data['letra']);
                    $("#txt_ValLetra").val("SON: " + data['letra']);
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
        valtiem: function () {
            if ($("#txt_tiem").val() === "") {
                alert("Debe Ingresar el Tiempo");
                $('#txt_tiem').focus();

            } else {
                if ($("#txt_fecha_Desd").val() !== "") {
                    $.calfecha();
                }
            }

        },
        valtiemPro: function () {
            if ($("#txt_tiemPro").val() === "") {
                alert("Debe Ingresar el Tiempo");
                $('#txt_tiemPro').focus();
            }

        },
        CambiarLetra_Doc: function (String) {
            var New = "";
            New = String.replace(/Ã€/g, "A").
                    replace(/Ã�/g, "A").
                    replace(/Ã‚/g, "A").
                    replace(/Ãƒ/g, "A").
                    replace(/Ã„/g, "A").
                    replace(/Ã…/g, "A").
                    replace(/Ã†/g, "A").
                    replace(/Ã‡/g, "C").
                    replace(/Ãˆ/g, "E").
                    replace(/Ã‰/g, "E").
                    replace(/ÃŠ/g, "E").
                    replace(/Ã‹/g, "E").
                    replace(/ÃŒ/g, "I").
                    replace(/Ã�/g, "I").
                    replace(/ÃŽ/g, "I").
                    replace(/Ã�/g, "I").
                    replace(/Ã�/g, "D").
                    replace(/Ã‘/g, "N").
                    replace(/Ã’/g, "O").
                    replace(/Ã“/g, "O").
                    replace(/Ã”/g, "O").
                    replace(/Ã•/g, "O").
                    replace(/Ã–/g, "O").
                    replace(/Ã—/g, "X").
                    replace(/Ã˜/g, "O").
                    replace(/Ã™/g, "U").
                    replace(/Ãš/g, "U").
                    replace(/Ã›/g, "U").
                    replace(/Ãœ/g, "U").
                    replace(/Ã�/g, "Y").
                    replace(/Ãž/g, "_").
                    replace(/ÃŸ/g, "_").
                    replace(/Ã /g, "a").
                    replace(/Ã¡/g, "a").
                    replace(/Ã¢/g, "a").
                    replace(/Ã£/g, "a").
                    replace(/Ã¤/g, "a").
                    replace(/Ã¥/g, "a").
                    replace(/Ã¦/g, "a").
                    replace(/Ã§/g, "c").
                    replace(/Ã¨/g, "e").
                    replace(/Ã©/g, "e").
                    replace(/Ãª/g, "e").
                    replace(/Ã±/g, "ñ").
                    replace(/Ã«/g, "e").
                    replace(/Ã¬/g, "i").
                    replace(/Ã­/g, "i").
                    replace(/Ã®/g, "i").
                    replace(/Ã¯/g, "i").
                    replace(/Ã°/g, "_").
                    replace(/Ã±/g, "n").
                    replace(/Ã²/g, "o").
                    replace(/Ã³/g, "o").
                    replace(/Ã´/g, "o").
                    replace(/Ãµ/g, "o").
                    replace(/Ã¶/g, "o").
                    replace(/Ã·/g, "_").
                    replace(/Ã¸/g, "o").
                    replace(/Ã¹/g, "u").
                    replace(/Ãº/g, "u").
                    replace(/Ã»/g, "u").
                    replace(/Ã¼/g, "u").
                    replace(/Ã½/g, "y").
                    replace(/Ã¾/g, "_").
                    replace(/Ã¿/g, "y").
                    replace(/%/g, "_").
                    replace(/`/g, "_").
                    replace(/Â°/g, "_").
                    replace(/'/g, "_").
                    replace(/ /g, "_").
                    replace(/\//g, "_").
                    replace(/~/g, "_");
            return New;
        },
        constancia: function () {
            $('#tab_constPP').show();
            $("#tab_infPP").removeClass("active in");
            $("#tab_inf").removeClass("active in");
            $("#tab_factPP").removeClass("active in");
            $("#tab_fact").removeClass("active in");
            $("#tab_constPP").addClass("active in");
            $("#tab_const").addClass("active in");


            var existe = "";
            var datos = {
                ope: "cargaConstancia",
                cod: $("#txt_id").val()
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    if (data["exit"] === "s") {

                        $('#txt_CodConst').val(data["cons_constan"]);
                        $('#txt_fecha_CreCos').val(data["fec_cre"]);
                        $('#txt_fecha_Cons').val(data["fec_cons"]);
                        $("#CbConsig").selectpicker("val", data["consig_constan"]);
                        $('#txt_CiudaCons').val(data["ciudad"]);
                        $('#txt_idenconst').val(data["iden_constan"]);
                        $('#txt_NomCliConst').val(data["nom_constan"]);
                        $('#txt_DirConst').val(data["dircons"]);
                        $('#txt_TelCliConst').val(data["telcons"]);
                        $('#txt_Concep').val(data["concepto"]);
                        $('#txt_Val').val('$ ' + number_format2(data['valor'], 2, ',', '.'));
                        $("#txt_idCost").val(data["idcos"]);
                        $("#btn_guardarCost").prop('disabled', true);
                        $('#btn_impriCost').show();

                    } else {

                        $('#txt_CiudaCons').val($('#txt_Ciuda').val());

                        var concep = "";

                        concep = $('#txt_tiem').val() + " " + $('#CbTiem').val();
                        var cem = $("#CbCeme").val();

                        if (cem === "NUEVO") {
                            concep += " DE ARRIENDO DE BOVEDA PARA EL DIFUNTO ";
                        } else {
                            concep += " DE ARRIENDO DE LOTE PARA EL DIFUNTO ";
                        }
                        concep += $('#txt_NomMuert').val() + " FALLECIDO EN LA FECHA " + $('#txt_fecha_Fall').val();

                        $('#txt_Concep').val(concep);
                        $.conseCos();

                        $("#btn_guardarCost").prop('disabled', false);
                        $('#btn_impriCost').hide();
                    }

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        constanciaPro: function () {

            $('#tab_constPP').show();
            $("#tab_infPP").removeClass("active in");
            $("#tab_inf").removeClass("active in");
            $("#tab_factPP").removeClass("active in");
            $("#tab_fact").removeClass("active in");
            $("#tab_ProrrPP").removeClass("active in");
            $("#tab_Prorr").removeClass("active in");
            $("#tab_constPP").addClass("active in");
            $("#tab_const").addClass("active in");


            var existe = "";
            var datos = {
                ope: "cargaConstancia2",
                cod: $("#txt_id").val()
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    if (data["exit"] === "s") {

                        $('#txt_CodConst').val(data["cons_constan"]);
                        $('#txt_fecha_CreCos').val(data["fec_cre"]);
                        $('#txt_fecha_Cons').val(data["fec_cons"]);
                        $("#CbConsig").selectpicker("val", data["consig_constan"]);
                        $('#txt_CiudaCons').val(data["ciudad"]);
                        $('#txt_idenconst').val(data["iden_constan"]);
                        $('#txt_NomCliConst').val(data["nom_constan"]);
                        $('#txt_DirConst').val(data["dircons"]);
                        $('#txt_TelCliConst').val(data["telcons"]);
                        $('#txt_Concep').val(data["concepto"]);
                        $('#txt_Val').val('$ ' + number_format2(data['valor'], 2, ',', '.'));
                        $("#txt_idCost").val(data["idcos"]);
                        $("#btn_guardarCost").prop('disabled', true);
                        $('#btn_impriCost').show();

                    } else {

                        $('#txt_CiudaCons').val(data["ciuda"]);

                        var concep = "";

                        concep = data["tiempo"];
                        var cem = data["cemen"];

                        if (cem === "NUEVO") {
                            concep += " DE ARRIENDO DE BOVEDA PARA EL DIFUNTO ";
                        } else {
                            concep += " DE ARRIENDO DE LOTE PARA EL DIFUNTO ";
                        }
                        concep += data["muerto"] + " FALLECIDO EN LA FECHA " + data["fec_falle"];

                        $('#txt_Concep').val(concep);
                        $('#txt_Val').val($('#ValorProrr').val());
                        $.conseCos();

                        $("#btn_guardarCost").prop('disabled', false);
                        $('#btn_impriCost').hide();
                    }

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },

        ReciboProrroga: function (dat) {

            var ParRec = dat.split('/');


            if (ParRec[2] === "") {
                $("#VentRecibo").modal();
                var tiem = "";
                var muer = "";
                var ffa = "";
                var bov = "";
                var codpro = $("#txt_idPr").val()

                if (ParRec[0]) {
                    codpro = ParRec[1];
                }


                var datos = {
                    ope: "BusInfPror",
                    cod: codpro
                };

                $.ajax({
                    type: "POST",
                    url: "All.php",
                    async: false,
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {

                        $("#txt_fecha_RecPag").val(data['fec']);
                        $("#txt_ValRecib").val(data['val']);
                        $("#txt_indenRec").val(data['ced']);
                        $("#txt_NomRec").val(data['nom']);
                        tiem = data['tie'];
                        muer = data['muer'];
                        ffa = data['ffall'];
                        bov = data['bov'];
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });

                var pvalmes = $("#txt_ValRecib").val().split(" ");
                var num = parseFloat(pvalmes[1].replace(".", "").replace(".", "").replace(",", "."));
                $.NumLetr(num);

                $("#txt_ConcepRec").val(tiem + " DE ARRIENDO DE BOVEDA " + bov + " PARA EL DIFUNTO " + muer + " FALLECIDO EN LA FECHA " + ffa);


                $("#btn_guardarReci").prop('disabled', false);
                $("#txt_ConRec").prop('disabled', false);
                //    $('#btn_ImprRec').hide();
                $('#btn_Anular').hide();
            } else {
                window.open("PDF_ReciboPagoPro.php?id=" + ParRec[2] + "", '_blank');
            }





        },
        ContaciaProrroga: function () {

            $('#tab_constPP').show();
            $("#tab_infPP").removeClass("active in");
            $("#tab_inf").removeClass("active in");
            $("#tab_factPP").removeClass("active in");
            $("#tab_fact").removeClass("active in");
            $("#tab_ProrrPP").removeClass("active in");
            $("#tab_Prorr").removeClass("active in");
            $("#tab_constPP").addClass("active in");
            $("#tab_const").addClass("active in");


            var existe = "";
            var datos = {
                ope: "cargaConstancia3",
                cod: $("#txt_id").val()
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    if (data["exit"] === "s") {

                        $('#txt_CodConst').val(data["cons_constan"]);
                        $('#txt_fecha_CreCos').val(data["fec_cre"]);
                        $('#txt_fecha_Cons').val(data["fec_cons"]);
                        $("#CbConsig").selectpicker("val", data["consig_constan"]);
                        $('#txt_CiudaCons').val(data["ciudad"]);
                        $('#txt_idenconst').val(data["iden_constan"]);
                        $('#txt_NomCliConst').val(data["nom_constan"]);
                        $('#txt_DirConst').val(data["dircons"]);
                        $('#txt_TelCliConst').val(data["telcons"]);
                        $('#txt_Concep').val(data["concepto"]);
                        $('#txt_Val').val('$ ' + number_format2(data['valor'], 2, ',', '.'));
                        $("#txt_idCost").val(data["idcos"]);
                        $("#btn_guardarCost").prop('disabled', true);
                        $('#btn_impriCost').show();

                    } else {

                        $('#txt_CiudaCons').val(data["ciuda"]);

                        var concep = "";

                        concep = data["tiempo"];
                        var cem = data["cemen"];

                        if (cem === "NUEVO") {
                            concep += " DE ARRIENDO DE BOVEDA PARA EL DIFUNTO ";
                        } else {
                            concep += " DE ARRIENDO DE LOTE PARA EL DIFUNTO ";
                        }
                        concep += data["muerto"] + " FALLECIDO EN LA FECHA " + data["fec_falle"];

                        $('#txt_Concep').val(concep);
                        $('#txt_Val').val($('#ValorProrr').val());
                        $.conseCos();

                        $("#btn_guardarCost").prop('disabled', false);
                        $('#btn_impriCost').hide();
                    }

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
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
                $("#txt_TelCli").val(data['tel_cli']);
                $("#txt_Dirbarrio").val(data['barrio']);
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
            $.conse('CONARRINUEVO');

        } else {
            $("#ubjar").show();
            $("#ubbov").toggle();
            $("#txt_boveda").val("");
            $.conse('CONARRIECCE');
        }

    });


    $("#btn_Anular").on("click", function () {
        if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

            var datos = {
                ope: "AnularFacturaArriendo",
                cod: $("#txt_idFact").val()
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


    $("#btn_volver").on("click", function () {
        window.location.href = "AdminServicios.php";
    });


    $("#btn_constancia").on("click", function () {
        $.constancia();
    });

    $("#btn_GConstPro").on("click", function () {
        $.constanciaPro();
    });

    $("#btn_GRecPro").on("click", function () {
        var dat = "F/" + $("#txt_idPr").val() + "/";
        $.ReciboProrroga(dat);

    });



    $("#txt_ConRec").on("change", function () {

        var datos = {
            ope: "verfConseReciPror",
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


    $("#btn_factura").on("click", function () {

        $('#tab_factPP').show();
        $("#tab_infPP").removeClass("active in");
        $("#tab_inf").removeClass("active in");
        $("#tab_constPP").removeClass("active in");
        $("#tab_const").removeClass("active in");

        $("#tab_factPP").addClass("active in");
        $("#tab_fact").addClass("active in");

        var existe = "";
        var datos = {
            ope: "cargaFacturaArri",
            cod: $("#txt_id").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            dataType: 'JSON',
            success: function (data) {

                if (data["exit"] === "s") {

                    $('#txt_CodFact').val(data["cons_fact"]);
                    $('#txt_fecha_CreFact').val(data["fec_cre"]);
                    $("#CbFpago").selectpicker("val", data["fpago"]);
                    $('#txt_CiudaFact').val(data["ciudad"]);
                    $('#txt_idenFact').val(data["iden"]);
                    $('#txt_NomCliFact').val(data["nom"]);
                    $('#txt_DirFact').val(data["dirfact"]);
                    $('#txt_TelCliFact').val(data["telfact"]);
                    $("#txt_idFact").val(data["id_fact"]);
                    $('#txt_Detalle').val(data["detalle"]);
                    $('#txt_ValDeta').val('$ ' + number_format2(data['valor'], 2, ',', '.'));
                    $.NumLetr(data['valor']);
//                    $("#gtotalDetLetra").html("SON: " + data['letra']);


                    $("#btn_guardarFact").prop('disabled', true);
                    $('#btn_impriFact').show();
                    $('#btn_Anular').show();

                } else {

                    $('#txt_CiudaCons').val($('#txt_Ciuda').val());

                    $.conseFact();
                    $.AddDetalles();

                    $("#btn_guardarFact").prop('disabled', false);
                    $('#btn_impriFact').hide();
                }

            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });









    });


    $("#btn_cancelar").on("click", function () {
        window.location.href = 'GesContratoArriendo.php';
    });

    $("#btn_impri").on("click", function () {
        window.open("PDF_ContArriendo.php?id=" + $('#txt_id').val() + "", '_blank');
    });

    $("#btn_impriAut").on("click", function () {
        window.open("PDF_AutoEntrada.php?id=" + $('#txt_id').val() + "", '_blank');
    });

    $("#btn_impriFact").on("click", function () {
        window.open("PDF_FacturaArri.php?id=" + $('#txt_idFact').val() + "", '_blank');
    });

    $("#btn_impriCost").on("click", function () {
        window.open("PDF_ConstArriendo.php?id=" + $('#txt_idCost').val() + "", '_blank');
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

        if ($('#CbTiem').val() === " ") {
            alert("Seleccione la unidad de Tiempo");
            $('#CbTiem').focus();
            return;
        }


        var datos = "OrdInhum=" + $("#txt_Cod").val() + "&fcreac=" + $("#txt_fecha_Cre").val()
                + "&txt_Ciuda=" + $("#txt_Ciuda").val() + "&CbCeme=" + $("#CbCeme").val()
                + "&txt_boveda=" + $("#txt_boveda").val() + "&txt_jardin=" + $("#txt_jardin").val()
                + "&txt_zona=" + $("#txt_zona").val() + "&txt_lote=" + $("#txt_lote").val() + "&txt_obser=" + $("#txt_obsercion").val()
                + "&txt_NomMuert=" + $("#txt_NomMuert").val() + "&CbTiem=" + $("#txt_tiem").val() + " " + $("#CbTiem").val() + "&txt_fecha_Desd=" + $("#txt_fecha_Desd").val()
                + "&txt_fecha_Hast=" + $("#txt_fecha_Hast").val() + "&txt_fecha_Fall=" + $("#txt_fecha_Fall").val() + "&txt_fecha_sepe=" + $("#txt_fecha_sepe").val()
                + "&txt_Fune=" + $("#txt_Fune").val() + "&txt_Dir=" + $("#txt_DirCli").val() + "&txt_Tel=" + $("#txt_TelCli").val() + "&txt_Dirbarrio=" + $("#txt_Dirbarrio").val()
                + "&txt_iden=" + $("#txt_iden").val() + "&txt_NomCli=" + $("#txt_NomCli").val() + "&CbFormMuert=" + $("#CbFormMuert").val()
                + "&CbSexo=" + $("#CbSexo").val() + "&txt_FecNac=" + $("#txt_FecNac").val() + "&txtemail=" + $("#txtemail").val()
                + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val() + "&cons=" + $("#cons").val() + "&txt_nuevo=" + $("#txt_nuevo").val() + "&CbEstado=" + $("#CbEstado").val();


        var Alldata = datos;

        $.ajax({
            type: "POST",
            url: "GuardarContratoArri.php",
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
                    $('#btn_impriAut').show();
                    $('#btn_constancia').show();
                    if ($("#per_fact").val() === "s") {
                        $('#btn_factura').show();
                    }


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

    $("#btn_guardarPro").on("click", function () {

        if ($('#CbTiemPro').val() === " ") {
            alert("Seleccione la unidad de Tiempo");
            $('#CbTiemPro').focus();
            return;
        }

        if ($('#txt_fecha_DesdPro').val() === " ") {
            alert("Seleccione la Fecha de Inicio");
            $('#txt_fecha_DesdPro').focus();
            return;
        }
        if ($('#txt_fecha_HastPro').val() === " ") {
            alert("Seleccione la Fecha de Vencimiento");
            $('#txt_fecha_HastPro').focus();
            return;
        }
        if ($('#ValorProrr').val() === "$ 0,00") {
            alert("Ingrese el Valor de la Prorroga");
            $('#ValorProrr').focus();
            return;
        }

        var pNec = $("#ValorProrr").val().split(" ");
        var vreal = pNec[1].replace(".", "").replace(".", "").replace(",", ".");


        var datos = "txt_idcont=" + $("#txt_id").val() + "&CbTiem=" + $("#txt_tiemPro").val() + " " + $("#CbTiemPro").val()
                + "&txt_fecha_Desd=" + $("#txt_fecha_DesdPro").val() + "&n_recibo=" + $("#n_recibo").val()
                + "&txt_fecha_Hast=" + $("#txt_fecha_HastPro").val() + "&vpro=" + vreal;


        $.ajax({
            type: "POST",
            url: "GuardarProrroga.php",
            data: datos,
            success: function (data) {
                var par = data.split("-");
                $("#txt_idPr").val(par[1]);
                if (trimAll(par[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.CargarProrrog($("#txt_id").val());

                    $("#btn_guardarPro").prop('disabled', true);

                    if ($("#n_recibo").val() === "") {
                        $('#btn_GConstPro').show();

                    }


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

        var pNec = $("#txt_Val").val().split(" ");
        var vreal = pNec[1].replace(".", "").replace(".", "").replace(",", ".");

        var datos = "consec=" + $("#txt_CodConst").val() + "&fcreac=" + $("#txt_fecha_CreCos").val()
                + "&txt_Ciuda=" + $("#txt_CiudaCons").val() + "&txt_fecha_Cons=" + $("#txt_fecha_Cons").val()
                + "&txt_iden=" + $("#txt_idenconst").val() + "&txt_NomCli=" + $("#txt_NomCliConst").val()
                + "&txt_DirCli=" + $("#txt_DirConst").val() + "&txt_TelCli=" + $("#txt_TelCliConst").val()
                + "&CbConsig=" + $("#CbConsig").val() + "&txt_vtotal=" + vreal
                + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val() + "&txt_Concep=" + $("#txt_Concep").val()
                + "&conse=" + $("#consConst").val() + "&txt_nuevo=NO";


        var Alldata = datos;

        $.ajax({
            type: "POST",
            url: "GuardarConstanciaConsigArriendo.php",
            data: Alldata,
            success: function (data) {

                var padata = data.split("/");
                if (trimAll(padata[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.Contra();
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



        var pvalmes = $("#txt_ValRecib").val().split(" ");
        var valmes = pvalmes[1].replace(".", "").replace(".", "").replace(",", ".");

        var datos = {
            ope: 'InserRecibPagoProrr',
            codr: $("#txt_ConRec").val(),
            frec: $("#txt_fecha_RecPag").val(),
            inde: $("#txt_indenRec").val(),
            nomb: $("#txt_NomRec").val(),
            valp: valmes,
            vall: $("#txt_ValLetra").val(),
            conc: $("#txt_ConcepRec").val(),
            fpag: $("#cbx_Fpago").val(),
            nche: $("#txt_Ncheque").val(),
            nban: $("#txt_BancoRec").val(),
            paen: $("#cbx_Pagen").val(),
            pror: $("#txt_idPr").val()
        };

        $.ajax({
            type: "POST",
            url: "All.php",
            data: datos,
            success: function (data) {
                var padata = data.split("/");
                if (trimAll(padata[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    alert();
                    $('#txt_idRecib').val(padata[1]);
                    //     $('#txt_nRecibo').val(padata[2]);
                    $("#btn_guardarReci").prop('disabled', true);
                    $("#btn_GRecPro").prop('disabled', true);
                    //  $('#btn_ImprRec').show();
                    $('#btn_Anular').show();
                    window.open("PDF_ReciboPagoPro.php?id=" + $('#txt_idRecib').val() + "", '_blank');
                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


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

        var datos = "consec=" + $("#txt_CodFact").val() + "&fcreac=" + $("#txt_fecha_CreFact").val()
                + "&txt_Ciuda=" + $("#txt_CiudaFact").val() + "&txt_iden=" + $("#txt_idenFact").val()
                + "&txt_NomCli=" + $("#txt_NomCliFact").val() + "&CbFpago=" + $("#CbFpago").val()
                + "&txt_vtotalFact=" + $("#txt_vtotalFact").val() + "&txt_valetra=" + $("#txt_valetra").val()
                + "&txt_DirCli=" + $("#txt_DirFact").val() + "&txt_TelCli=" + $("#txt_TelCliFact").val()
                + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val() + "&txt_Detalle=" + $("#txt_Detalle").val()
                + "&conse=" + $("#consFact").val() + "&txt_idCost=" + $("#txt_idCost").val();


        var Alldata = datos;

        $.ajax({
            type: "POST",
            url: "GuardarFacturaArriendo.php",
            data: Alldata,
            success: function (data) {

                var padata = data.split("/");
                if (trimAll(padata[0]) === "bien") {
                    alert("Datos Guardados Exitosamente");

                    $("#txt_idFact").val(padata[1]);
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

});
///////////////////////
