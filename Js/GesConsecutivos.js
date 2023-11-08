$(document).ready(function () {
 
    $("#home").removeClass("start active open");
    $("#menu_op").addClass("start active open");
    $("#menu_op_conse").addClass("active");

    $("#CbGrupo, #CbVige, #Cbdigi").selectpicker();
    ///////////////////////CARGAR CONSECUTIVOS: 
    $.extend({
        conse: function () {
            var datos = {
                opc: "CargSecretarias",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            }

            $.ajax({
                type: "POST",
                url: "PagConsecut.php",
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
        busqSecre: function (val) {


            var datos = {
                opc: "BusqDepe",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            }

            $.ajax({
                type: "POST",
                url: "PagConsecut.php",
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
        editConse: function (cod) {
            $('#acc').val("2");
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEditConse",
                cod: cod
            }

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#txt_Estr').val(data['estruct']);
                    $("#CbGrupo").selectpicker("val", data['grupo']);
                    $("#CbVige").selectpicker("val", data['vigencia']);
                    $("#Cbdigi").selectpicker("val", data['digitos']);
                    $('#txt_Desc').val(data['descrip']);
                    $('#txt_ini').val(data['inicio']);
                    $('#txt_act').val(data['actual']);
                    $('#txt_obser').val(data['observ']);
                    $('#txt_EstrucEst').val(data['estr_fin']);
                    
                    $('#txt_id').val(cod);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').show();

                    $("#txt_Estr").prop('disabled', false);
                    $("#CbGrupo").prop('disabled', false);
                    $("#txt_Desc").prop('disabled', false);
                    $("#txt_ini").prop('disabled', false);
                    $("#txt_act").prop('disabled', false);
                    $("#CbVige").prop('disabled', false);
                    $("#txt_obser").prop('disabled', false);


        },
        verConse: function (cod) {

           var datos = {
                ope: "BusqEditConse",
                cod: cod
            }

            $.ajax({
                type: "POST",
                url: "../All",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#txt_Estr').val(data['estruct']);
                    $("#CbGrupo").selectpicker("val", data['grupo']);
                    $("#CbVige").selectpicker("val", data['vigencia']);
                    $('#txt_Desc').val(data['descrip']);
                    $('#txt_ini').val(data['inicio']);
                    $('#txt_act').val(data['actual']);
                    $('#txt_obser').val(data['observ']);
                    $('#txt_EstrucEst').val(data['estr_fin']);
                    
                    $('#txt_id').val(data['id_conse']);

                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').show();

                    $("#txt_Estr").prop('disabled', true);
                    $("#CbGrupo").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', true);
                    $("#txt_ini").prop('disabled', true);
                    $("#txt_act").prop('disabled', true);
                    $("#CbVige").prop('disabled', true);
                    $("#txt_obser").prop('disabled', true);
            $('#mopc').hide();

        },
        addLeadingZeros: function(n, length)
            {
            var str = (n > 0 ? n : -n) + "";
            var zeros = "";
            for (var i = length - str.length; i > 0; i--)
                zeros += "0";
            zeros += str;
            return n >= 0 ? zeros : "-" + zeros;
            },
        deletConse: function (cod) {
            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    ope: "delecSecre",
                    cod: cod
                }

                $.ajax({
                    type: "POST",
                    url: "GuardarConse.php",
                    data: datos,
                    success: function (data) {
                        if (data === "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.conse();
                        }
                    },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        estruct: function () {
             
             var struc="";
            $("#txt_act").val($("#txt_ini").val());  
            num= $.addLeadingZeros($("#txt_ini").val(),$("#Cbdigi").val());
             var vig=$("#txt_fec").val().split("-");
             if($("#CbVige").val()==="SI"){
                 struc=$("#txt_Estr").val()+"-"+vig[0]+"-"+num; 
             }else{
                struc=$("#txt_Estr").val()+"-"+num;  
             }
           
            $("#txt_EstrucEst").val(struc);
           
        },
        paginador: function (pag, servel) {

            var datos = {
                pag: pag,
                bus: $("#busq_centro").val(),
                nreg: $("#nreg").val()
            }

            $.ajax({
                type: "POST",
                url: "PagConsecut.php",
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
                nreg: $("#nreg").val()

            }

            $.ajax({
                type: "POST",
                url: "PagConsecut.php",
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
                pag: $("#selectpag").val()

            }

            $.ajax({
                type: "POST",
                url: "PagConsecut.php",
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

        }
      

    });
    //======FUNCIONES========\\
    $.conse();
    $("#btn_nuevo1").on("click", function () {
        $('#acc').val("1");
        $("#txt_Estr").val("");
        $("#txt_Desc").val("");
        $("#txt_ini").val("0");
        $("#txt_act").val("");
        $("#txt_obser").val("");
         $("#txt_EstrucEst").val("");
        $("#CbGrupo").selectpicker("val", " ");
        $("#Cbdigi").selectpicker("val", "1");
        $("#CbVige").selectpicker("val", " ");
        
        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Estr").prop('disabled', false);
        $("#CbGrupo").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_ini").prop('disabled', false);
        $("#Cbdigi").prop('disabled', false);
        $("#CbVige").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);
        
        $("#responsive").modal();
        $('#mopc').show();


    });

    
    $("#btn_nuevo2").on("click", function () {
        $('#acc').val("1");

        $("#txt_Estr").val("");
        $("#txt_Desc").val("");
        $("#txt_ini").val("0");
        $("#txt_act").val("");
        $("#txt_obser").val("");
        $("#txt_EstrucEst").val("");
        $("#CbGrupo").selectpicker("val", " ");
        $("#Cbdigi").selectpicker("val", "1");
        $("#CbVige").selectpicker("val", " ");
        
        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Estr").prop('disabled', false);
        $("#CbGrupo").prop('disabled', false);
        $("#txt_Desc").prop('disabled', false);
        $("#txt_ini").prop('disabled', false);
         $("#Cbdigi").prop('disabled', false);
        $("#CbVige").prop('disabled', false);
        $("#txt_obser").prop('disabled', false);


    });

    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function () {


        if ($('#txt_Estr').val() === "") {
            alert("Ingrese la Estructura");
            $('#txt_Estr').focus();
            return;
        }

        if ($('#CbVige').val() === "") {
            alert("Seleccione si desea Agregar la Vigencia Actual");
            $('#CbVige').focus();
            return;
        }

        var datos = {
            txt_Estr: $("#txt_Estr").val(),            
            txt_Desc: $("#txt_Desc").val(),
            CbGrupo: $("#CbGrupo").val(),
            txt_ini: $("#txt_ini").val(),            
            txt_act: $("#txt_act").val(),
            CbVige: $("#CbVige").val(),            
            txt_obser: $("#txt_obser").val(),           
            txt_EstrucEst: $("#txt_EstrucEst").val(),
            Cbdigi: $("#Cbdigi").val(),
            acc: $("#acc").val(),
            id: $("#txt_id").val()
        }

        $.ajax({
            type: "POST",
            url: "GuardarConse.php",
            data: datos,
            success: function (data) {
                if (trimAll(data) === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.conse();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);
                    
                    $("#txt_Estr").prop('disabled', true);
                    $("#CbGrupo").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', true);
                    $("#txt_ini").prop('disabled', true);
                    $("#txt_act").prop('disabled', true);
                     $("#Cbdigi").prop('disabled', true);
                    $("#CbVige").prop('disabled', true);
                    $("#txt_obser").prop('disabled', true);

                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });



});
///////////////////////
