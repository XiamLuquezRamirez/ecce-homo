$(document).ready(function () {
    var mapa="";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_cons").addClass("start active open");
    $("#menu_cons_pago").addClass("active");
   
    $("#Cbconsu").selectpicker();
     $("#txt_fecha_ini,#txt_fecha_fin").datepicker({
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
                fin: $("#txt_fecha_ini").val(),
                ffi: $("#txt_fecha_fin").val(),              
                nreg: $("#nreg").val()
            };

             $.ajax({
                type: "POST",
                url: "PagConsultasPagos.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_TipDoc').show(100).html(data['cad']);
                    $('#bot_TipDoc').show(100).html(data['cad2']);
                     $('#cobpag').html(data['cbp']);
                     $('#val_atrasado').html("$ " + number_format2(data['totalpen'], 2, ',', '.'));
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
        },
       
        
        paginador: function (pag,servel) {
          regus = "n";
            if ($('#reusu').prop('checked')) {
                regus = "s";
            }
           var datos = {
                    pag: pag,
                    bus: $("#busq_centro").val(),
                    nreg: $("#nreg").val(),
                    fin: $("#txt_fecha_ini").val(),
                    ffi: $("#txt_fecha_fin").val(), 
                    tcon: $("#CbconsuTip").val()
                }

                $.ajax({
                    type: "POST",
                    url: "PagConsultasPagos.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                    $('#tab_TipDoc').show(100).html(data['cad']);
                    $('#bot_TipDoc').show(100).html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                    $('#val_atrasado').html("$ " + number_format2(data['totalpen'], 2, ',', '.'));
                },
                    error: function (error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            
        },
        combopag: function (pag,servel) {
          
           var datos = {
                    pag: pag,
                    bus: $("#busq_centro").val(),
                    nreg: $("#nreg").val(),
                    fin: $("#txt_fecha_ini").val(),
                    ffi: $("#txt_fecha_fin").val(), 
                    tcon: $("#CbconsuTip").val()
                    
                }

                $.ajax({
                    type: "POST",
                    url: "PagConsultasPagos.php",
                    data: datos,
                    dataType: 'JSON',
                    success: function (data) {
                    $('#tab_TipDoc').show(100).html(data['cad']);
                    $('#bot_TipDoc').show(100).html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                    $('#val_atrasado').html("$ " + number_format2(data['totalpen'], 2, ',', '.'));
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
                fin: $("#txt_fecha_ini").val(),
                ffi: $("#txt_fecha_fin").val(), 
                tcon: $("#CbconsuTip").val()

            };

            $.ajax({
                type: "POST",
                url: "PagConsultasPagos.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $('#tab_TipDoc').html(data['cad']);
                    $('#bot_TipDoc').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                    $('#val_atrasado').html("$ " + number_format2(data['totalpen'], 2, ',', '.'));
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        }
        
    });
    //======FUNCIONES========\\
    

    
     $("#btn_impriReport").on("click", function () {      
       window.open("PDF_ConsultasPagos.php?tcon="+$('#Cbconsu').val()+"&fini="+$('#txt_fecha_ini').val()+"&ffin="+$('#txt_fecha_fin').val(), '_blank');
     });
    
    });
    ///////////////////////
