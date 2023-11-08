$(document).ready(function() {
    var mapa = "";
    $("#fecha").inputmask("d/m/y", {autoUnmask: true});

    $("#home").removeClass("start active open");
    $("#menu_opcige").addClass("start active open");
    $("#menu_op_gal").addClass("active");

    ///////////////////////CARGAR MUNICIPIOS:
    $.extend({
        noti: function() {
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
                url: "PagGalerias.php",
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
        busqGale: function(val) {
            var datos = {
                opc: "BusqDepe",
                bus: val,
                pag: "1",
                op: "1",
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "PagGalerias.php",
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
        editGal: function(cod) {
            $('#acc').val("2");
            $('#txt_id').val(cod);

            $("#btn_nuevo2").prop('disabled', true);
            $("#btn_guardar").prop('disabled', false);
            var datos = {
                ope: "BusqEdGal",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $("#idnoti").val(data['id_galeria']);
                    $("#txt_Titu").val(data['titulo']);
                    $("#txt_desc").val(data['obser']);

                    $("#acc").val("2");

                    $("#txt_Titu").prop('disabled', false);
                    $("#txt_desc").prop('disabled', false);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });
            $("#responsive").modal();
            $('#mopc').show();


        },
        VerGal: function(cod) {

            $("#idGal").val(cod);
            var datos = {
                ope: "tabimg",
                cod: cod
            };

            $.ajax({
                type: "POST",
                url: "All.php",
                data: datos,
                dataType: 'JSON',
                success: function(data) {
                    $('#tab_Img').html(data['tabImg']);

                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

            $("#responsive2").modal();


        },
        VerImg: function(rut) {

            $("#contenedor img").attr("src", "galerias/" + rut);
            $("#responsiveImg").modal();


        },
        deletGal: function(cod) {
            $("#acc").val("3");

            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    acc: "3",
                    cod: cod
                }

                $.ajax({
                    type: "POST",
                    url: "GuardarGaleria.php",
                    data: datos,
                    success: function(data) {
                        if (trimAll(data) == "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.noti();
                        } else if (trimAll(data) == "nobien") {
                            alert("Esta Galeria Tiene Imagenes Cargadas");
                        }
                    },
                    error: function(error_messages) {
                        alert('HA OCURRIDO UN ERROR');
                    }
                });
            }
        },
        DelImg: function(cod) {

            if (confirm("\xbfEsta seguro de realizar la operaci\xf3n?")) {

                var datos = {
                    ope: "DelImg",
                    cod: cod
                };

                $.ajax({
                    type: "POST",
                    url: "All.php",
                    data: datos,
                    success: function(data) {
                        if (trimAll(data) == "bien") {
                            alert("Operacion Realizada Exitosamente");
                            $.VerGal($("#idGal").val());
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
                nreg: $("#nreg").val()
            };

            $.ajax({
                type: "POST",
                url: "PagGalerias.php",
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
                nreg: $("#nreg").val()

            };

            $.ajax({
                type: "POST",
                url: "PagGalerias.php",
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
        combopag2: function(nre) {

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
                success: function(data) {
                    $('#tab_TipDoc').html(data['cad']);
                    $('#bot_TipDoc').html(data['cad2']);
                    $('#cobpag').html(data['cbp']);
                },
                error: function(error_messages) {
                    alert('HA OCURRIDO UN ERROR');
                }
            });

        }



    });



    $.noti();


    $("#archivos").on("change", function() {
        /* Limpiar vista previa */
        $("#vista-previa").html('');
        var archivos = document.getElementById('archivos').files;
        var navegador = window.URL || window.webkitURL;
        /* Recorrer los archivos */
        for (x = 0; x < archivos.length; x++)
        {
            /* Validar tamaño y tipo de archivo */
            var size = archivos[x].size;
            var type = archivos[x].type;
            var name = archivos[x].name;
            if (size > 10485760)
            {
                $("#vista-previa").append("<p style='color: red'>El archivo " + name + " supera el máximo permitido 10MB</p>");
            } else if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png' && type != 'image/gif')
            {
                $("#vista-previa").append("<p style='color: red'>El archivo " + name + " no es del tipo de imagen permitida.</p>");
            } else
            {
                var objeto_url = navegador.createObjectURL(archivos[x]);
                $("#vista-previa").append("<img src=" + objeto_url + " width='100' height='100'>&nbsp;");
            }
        }
    });




    $("#btn_nuevo1").on("click", function() {

        $("#archivos").val("");
        $("#respuesta").html("");
        $("#vista-previa").html("");

        $("#btn_nuevo").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

        $("#responsive").modal();
        $('#mopc').show();

    });

    $("#btn_nuevo").on("click", function() {

        $("#archivos").val("");
        $("#respuesta").html("");
        $("#vista-previa").html("");
        $("#btn_nuevo").prop('disabled', true);
        $("#btn_guardar").prop('disabled', false);

    });


    //BOTON GUARDAR-
    $("#btn_guardar").on("click", function() {


        if ($('#txt_Cod').val() == "") {
            alert("Ingrese el Código de la Iglesia");
            $('#txt_Cod').focus();
            return;
        }

        if ($('#txt_Desc').val() === "") {
            alert("Ingrese el Nombre de la Iglesia");
            $('#txt_Desc').focus();
            return;
        }

        var datos = {
            txt_Titu: $("#txt_Titu").val(),
            txt_desc: $("#txt_desc").val(),
            id: $("#text_id").val(),
            acc: $("#acc").val()
        }

        $.ajax({
            type: "POST",
            url: "GuardarGaleria.php",
            data: datos,
            success: function(data) {
                if (data === "bien") {
                    alert("Datos Guardados Exitosamente");
                    $.noti();
                    $("#btn_nuevo2").prop('disabled', false);
                    $("#btn_guardar").prop('disabled', true);

                    $("#txt_Cod").prop('disabled', true);
                    $("#txt_Desc").prop('disabled', true);
                    $("#txt_obser").prop('disabled', true);

                }
            },
            error: function(error_messages) {
                alert('HA OCURRIDO UN ERROR');
            }
        });


    });

    $("#btn_guardarImg").on("click", function() {

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

        var ruta = "upload_img.php";
        $.ajax({
            url: ruta,
            type: "POST",
            data: archivos,
            contentType: false,
            processData: false,
            success: function(datos)
            {
                $("#respuesta").html(datos);
                $.VerGal($("#idGal").val());
                $("#btn_nuevo").prop('disabled', false);
                $("#btn_guardar").prop('disabled', true);


            }
        });
    });
});
///////////////////////
