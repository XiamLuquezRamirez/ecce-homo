$(document).ready(function () {
    var mapa = "";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
   $("#menu_opcige").addClass("start active open");
    $("#menu_op_noti").addClass("active");

    ///////////////////////CARGAR MUNICIPIOS: 
    $.extend({
        noti: function () {
            var datos = {
                opc: "CargProyectos",
                pag: "1",
                op: "1",
                bus: "",
                rus: "n",
                nreg: $("#nreg").val()
            };


            $.ajax({
                type: "POST",
                url: "PagNoticias.php",
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
        busqNoti: function (val) {


            var datos = {
                opc: "BusqDepe",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "PagNoticias.php",
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
        editNot: function (cod) {
            $('#acc').val("2");
           
            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEdNot",
                cod: cod
            }

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {
                    $("#idnoti").val(data['id_noticia']);
                    $("#txt_Titu").val(data['titu_not']);
                    $("#txt_src_archivo").val(data['img']);
                    $("#txt_desc").val(data["descr"].replace(new RegExp("<br/>", "g"), "\n"));

                    $("#acc").val("2");

                    
                    $("#txt_Titu").prop('disabled', false);
                    $("#txt_desc").prop('disabled', false);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').show();


        },
        VerNot: function (cod) {

            var datos = {
                ope: "BusqEdNot",
                cod: cod
            }

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $("#txt_Cod").val(data['cod_proyecto']);
                    $("#txt_Nomb").val(data['nom_proyecto']);
                    $("#txt_desc").val(data['des_proyecto']);
                    $("#txt_fec_ini").val(data['fini']);
                    $("#txt_fec_fin").val(data['ffin']);
                    $("#CbRespon").select2("val", data['idresp_proyecto']);
                    $("#CbCola").select2("val", data['idcola_proyecto']);
                    $("#CbDepa").select2("val", data['dep_proyecto']);
                    $("#CbMun").select2("val", data['mun_proyecto']);
                },
                error: function (error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').hide();

        },
        deletNot: function (cod) {
            $("#acc").val("3");

            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                }

                $.ajax({
                    type: "POST",
                    url: "GuardarNoticia.php",
                    data: datos,
                    success: function (data) {
                        if (trimAll(data) == "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.noti();
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
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "PagNoticias.php",
                data: datos,
                dataType: 'JSON',
                success: function (data) {

                    $('#tab_TipDoc').show(100).html(data['cad']);
                    $('#bot_TipDoc').show(100).data(data['cad2']);
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
                url: "PagNoticias.php",
                data: datos,
                 dataType: 'JSON',
                success: function (data) {

                    $('#tab_TipDoc').show(100).html(data['cad']);
                    $('#bot_TipDoc').show(100).data(data['cad2']);
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

            };

            $.ajax({
                type: "POST",
               url: "PagGalerias.php",
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

    $("#btn_nuevo1").on("click", function () {
        $('#acc').val("1");


        $("#txt_Titu").val("");
        $("#txt_desc").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Titu").prop('disabled', false);
        $("#txt_desc").prop('disabled', false);


        $("#responsive").modal();
        $('#mopc').show();
    });


    $.noti();
  

    $(':file').change(function ()
    {
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


        var formData = new FormData($("#formnot")[0]);
        var message = "";
        //hacemos la petición ajax  
        $.ajax({
            url: 'upload.php',
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

        $("#txt_Titu").val("");
        $("#txt_desc").val("");

        $("#btn_nuevo2").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#txt_Titu").prop('disabled', false);
        $("#txt_desc").prop('disabled', false);


    });

    $("#btn_guardar").on("click", function () {


        if ($('#txt_Titu').val() == "") {
            alert("Ingrese El Titulo de la Noticia");
            $('#txt_Titu').focus();
            return;
        }

        if ($('#txt_desc').val() == "") {
            alert("Ingrese La Información");
            $('#txt_desc').focus();
            return;
        }
        var textno = $("#txt_src_archivo").val();

        var datos = {
            txt_Titu: $("#txt_Titu").val(),
            txt_desc: $("#txt_desc").val().replace(new RegExp("\n", "g"), "<br/>"),
            txt_src_archivo: $("#txt_src_archivo").val(),
            idnoti: $("#idnoti").val(),
            acc: $("#acc").val()
        };

        $.ajax({
            type: "POST",
            url: "GuardarNoticia.php",
            data: datos,
            success: function (data) {
                if (trimAll(data) == "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.noti();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_Titu").prop('disabled', true);
                    $("#txt_desc").prop('disabled', true);

                }
            },
            error: function (error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });
    });
});
///////////////////////
