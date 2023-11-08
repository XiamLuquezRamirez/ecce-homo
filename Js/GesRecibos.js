$(document).ready(function () {
    var Order = "b.nom_proyect ASC";
    // $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_serv").addClass("start active open");
    $("#menu_serv_recibos").addClass("active");

//   $("#CbProyect,#CbDepen,#CbResp,#CbElab,#CbContratista,#CbDepa,#CbRubPres,#CbMod,#CbTipCont").select2();


    $("#txt_fecha_Cre, #txt_fecha_Desd, #txt_fecha_Hast, #txt_fecha_Fall,#txt_FecNac").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });
      
       
    $("#CbConsig").selectpicker();   
  
    var contConcep = 0;
    var vtotalg = 0;
    var Dat_Concep = "";


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
            $("#txt_DirCli").val(par[5]);
            $("#txt_TelCli").val(par[6]);
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
      
      
        editConst: function (cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            
            
            var datos = {
                ope: "BusqEditConstancia",
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
                    
                    $("#txt_Cod").val(data['cons_constan']);
                    $("#txt_fecha_Cre").val(data['fec_cre']);
                    $("#txt_fecha_Cons").val(data['fec_cons']);
                    $("#txt_Ciuda").val(data['ciuda']);
                    $("#txt_iden").val(data['inde_cli']); 
                    $("#txt_NomCli").val(data['nom_cli']);
                    $('#txt_DirCli').val(data["dir_cli"]); 
                    $('#txt_TelCli').val(data["tel_cli"]);
                    $('#txt_vtotal').val(data["valor"]);
                   
                    $("#tb_Nece").html(data['CadNec']);                
                    $("#contNec").val(data['cont']);
                    

                }

            });
            
            
            $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Editar Constancia</a>");


        },
        VerConst: function (cod) {

            $("#btn_guardar").prop('disabled', true);
          var datos = {
                ope: "BusqEditConstancia",
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
                    
                    $("#txt_Cod").val(data['cons_constan']);
                    $("#txt_fecha_Cre").val(data['fec_cre']);
                    $("#txt_fecha_Cons").val(data['fec_cons']);
                    $("#txt_Ciuda").val(data['ciuda']);
                    $("#txt_iden").val(data['inde_cli']); 
                    $("#txt_NomCli").val(data['nom_cli']);
                    $('#txt_DirCli').val(data["dir_cli"]); 
                    $('#txt_TelCli').val(data["tel_cli"]);
                    $('#txt_vtotal').val(data["valor"]);
                   
                    $("#tb_Nece").html(data['CadNec']);                
                    $("#contNec").val(data['cont']);
                    

                }

            });
            
            
             $("#tab_01").removeClass("active in");
            $("#tab_01_pp").removeClass("active in");
            $("#tab_02").addClass("active in");
            $("#tab_02_pp").addClass("active in");
            $('#atitulo').show(100).html("<a href='#tab_02' data-toggle='tab' id='atitulo'>Ver Constancia</a>");


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
                    $("#tab_Clientes").show(100).html(data['tab_cli']);
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
        deletConst: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    ope: "delecContrato",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "GuardarConstanciaConsig.php",
                    data: datos,
                    success: function (data) {
                        if (data === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.Contra();
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
        combopag: function (pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val(),
                ord: Order

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
         conse: function () {

            var text = $("#atitulo").text();
           
            if (text === "Crear Constancia") {

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
        combopag2: function (nre) {

            var datos = {
                nreg: nre,
                bus: $("#busq_centro").val(),
                pag: $("#selectpag").val(),
                ord: Order

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
        
        AddConcepto: function () {

            var txt_id_Nec = $("#txt_id_Nec").val();
            var txt_nomNec = $('#txt_nomNec').val();
            var txt_Cant = $('#txt_Cant').val();
            var txt_Val = $('#txt_Val').val();            
            var txt_obseNec = $('#txt_obseNec').val();
            
            vtotalg = $("#txt_vtotal").val();
            var pNec=txt_Val.split(" ");
            var vreal=pNec[1].replace(".","").replace(".","").replace(",",".");
            var vtotal=parseFloat(vreal)*parseInt(txt_Cant);
              
            vtotalg=parseFloat(vtotalg)+parseFloat(vtotal);
          
            
            contConcep=$("#contNec").val();

            contConcep++;
           
            var fila = '<tr class="selected" id="filaNece' + contConcep + '" >';

            fila += "<td>" + contConcep + "</td>";
            fila += "<td>" + txt_nomNec + "</td>";
            fila += "<td>" + txt_obseNec + "</td>";
            fila += "<td>" + txt_Cant + "</td>";
            fila += "<td>" + txt_Val + "</td>";
            fila += "<td>$ " + number_format2(vtotal, 2, ',', '.') + "</td>";
            
            fila += "<td><input type='hidden' id='Neces" + contConcep + "' name='Neces' value='" + txt_id_Nec + "//" + txt_Cant + "//" + vreal +"//"+txt_obseNec+ "' /><a onclick=\"$.QuitarNeces('filaNece" + contConcep+"',"+vtotal+")\" class=\"btn default btn-xs red\">"
                    + "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
            
            
            $('#tb_Nece').append(fila);
            $("#gtotal").html("$ "+number_format2(vtotalg, 2, ',', '.'));
            $('#txt_vtotal').val(vtotalg);
            $.reordenarNece();
            $.limpiarNece();
             $("#contNec").val(contConcep);
        },
        limpiarNece: function () {

            $("#txt_id_Nec").val("");
            $("#txt_nomNec").val("");
            $("#txt_Val").val("0,00");
            $("#txt_Cant").val("");
            $("#txt_obseNec").val("");
            

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
        QuitarNeces: function (id_fila,valor) {
            $('#' + id_fila).remove();
            $.reordenarNece();
            contConcep = $('#contNec').val();
            contConcep = contConcep - 1;
            $("#contNec").val(contConcep);
            vtotalg= $('#txt_vtotal').val();
            
            vtotalg=vtotalg-valor;
            $("#gtotal").html("$ "+number_format2(vtotalg, 2, ',', '.'));
            $('#txt_vtotal').val(vtotalg);
            
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
        
             
       Dta_Concep: function () {
            Dat_Concep = "";
            $("#tb_Nece").find(':input').each(function () {
                Dat_Concep += "&" + $(this).attr("id") + "=" + $(this).val();
            });
            Dat_Concep += "&Long_Concep=" + $("#contNec").val();

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
                $("#txt_DirCli").val(data['dir_cli']);
                $("#txt_TelCli").val(data['tel_cli']);
                $("#txt_nuevo").val(data['cliex']);
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });
    
    $("#txt_Cod").on("change", function () {

        var datos = {
            ope: "verfConse",
            cod: $("#txt_iden").val()
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
    
    $("#CbCeme").on("change", function () {
     var cem=$("#CbCeme").val();
      
      if(cem==="NUEVO"){
          $("#ubbov").show();          
          $("#ubjar").toggle();   
          $("#txt_jardin").val("");
          $("#txt_zona").val("");
          $("#txt_lote").val("");
      }else{
          $("#ubjar").show();          
          $("#ubbov").toggle(); 
          $("#txt_boveda").val("");
      }        

    });

    
    $("#btn_volver").on("click", function () {        
       window.location.href = "AdminServicios.php";
     });
    
  
    $("#btn_cancelar").on("click", function () {
        window.location.href = 'GesCostanciasConsig.php';
    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {

        if ($('#txt_Cod').val() === "") {
            alert("Ingrese El Consecutivo");
            $('#txt_Cod').focus();
            return;
        }

        if ($('#txt_NomMuert').val() === "") {
            alert("Nombre de quien Consigna");
            $('#txt_NomMuert').focus();
            return;
        }
         
           $.Dta_Concep();
      
        var datos = "consec=" + $("#txt_Cod").val() + "&fcreac=" + $("#txt_fecha_Cre").val()
                + "&txt_Ciuda=" + $("#txt_Ciuda").val() + "&txt_fecha_Cons=" + $("#txt_fecha_Cons").val()
                + "&txt_iden=" + $("#txt_iden").val() + "&txt_NomCli=" + $("#txt_NomCli").val()
                + "&txt_DirCli=" + $("#txt_DirCli").val() + "&txt_TelCli=" + $("#txt_TelCli").val()
                + "&CbConsig=" + $("#CbConsig").val() + "&txt_vtotal=" + $("#txt_vtotal").val() 
                + "&acc=" + $("#acc").val() + "&id=" + $("#txt_id").val()
                + "&conse=" + $("#cons").val() + "&txt_nuevo=" + $("#txt_nuevo").val();


        var Alldata = datos + Dat_Concep;
        
        $.ajax({
            type: "POST",
            url: "GuardarConstanciaConsig.php",
            data: Alldata,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.Contra();

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
