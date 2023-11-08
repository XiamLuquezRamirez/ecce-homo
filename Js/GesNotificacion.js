$(document).ready(function () {
    var mapa = "";
    var Dat_Clie = "";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_serv").addClass("start active open");
    $("#menu_serv_notif").addClass("active");

    $("#Cbconsu").selectpicker();

    $("#txt_fecha_ini, #txt_fecha_fin").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: 'linked',
        todayHighlight: true,
        language: 'es'
    });

    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        consu: function () {
            var datos = {
                opc: "CargDepartamento",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                con: $("#Cbconsu").val(),
                nreg: $("#nreg").val(),
                ini: $("#txt_fecha_ini").val(),
                fin: $("#txt_fecha_fin").val(),
                Ceme: $("#CbCeme").val()
            };

            $.ajax({
                type: "POST",
                url: "PagClientesNotificar.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_TipDoc').show(100).html(data['cad']);
                    $('#bot_TipDoc').show(100).html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
        
        busqFunera: function (val) {


            var datos = {
                opc: "BusqDepart",
                bus: val,
                pag: "1",
                op: "1",
                con: $("#Cbconsu").val(),
                nreg: $("#nreg").val(),
                ini: $("#txt_fecha_ini").val(),
                fin: $("#txt_fecha_fin").val()


            };

            $.ajax({
                type: "POST",
                url: "PagClientesNotificar.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_TipDoc').show(100).html(data['cad']);
                    $('#bot_TipDoc').show(100).html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },

        PrintNotiArri: function (cod) {
            $("#idContArr").val(cod);
            $("#txt_Tiempo_").val("");
            $("#ImprNoti").modal();
            var datos = {
                ope: "BusProCont",
                cod: cod
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
//           
        },
        Dta_Clien: function () {
            Dat_Clie = "";
            var num_elementos = document.getElementsByName("Contr").length;
            for (var contador = 0; contador < num_elementos; contador++) {			//
//                if (document.getElementsByName("sel")[contador].checked === true)	//> se obtiene el value del check seleccionado
                Dat_Clie += document.getElementsByName("Contr")[contador].value + "/"; //
            }

        }

    });
    //======FUNCIONES========\\

    //   $.consu();

    $("#btn_impriReport").on("click", function () {
        window.open("PDF_Consultas.php?tcon=" + $('#Cbconsu').val() + "", '_blank');
    });

    $("#btn_Notificar").on("click", function () {
        $.Dta_Clien();

        var Alldata = "dat_cli=" + Dat_Clie + "&tcon=" + $('#Cbconsu').val();

        $.ajax({
            type: "POST",
            url: "EnvioNotificacion.php",
            data: Alldata,
            dataType: 'JSON',
            success: function (data) {

            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });

    });


    $("#btn_PrintNotif").on("click", function () {
   
        var cemen=$("#CbCeme").val();
        var fini=$("#txt_fecha_ini").val();
        var ffin=$("#txt_fecha_fin").val();
        window.open("PrintNotif.php?cemen="+cemen+"&fini="+fini+"&ffin="+ffin, '_blank');

    });

    $("#btn_PrintNotifi").on("click", function () {
        var codCont = $("#idContArr").val();
        var tiempo = $("#txt_Tiempo_").val();
        if (tiempo === "") {
            alert("Ingrese el Tiempo de Arriendo.");
        } else {
            window.open("PDF_NotificacionArri.php?id=" + codCont + "&tiempo=" + tiempo, '_blank');

        }

    });

});
///////////////////////
