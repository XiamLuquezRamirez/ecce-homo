<?php

session_start();

include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
date_default_timezone_set('America/Bogota');

if ($_POST["ope"] == "CargarTabEmpresa") {

    $consulta = "SELECT * FROM config_empresa";
    $Data = "";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $Data .= "<tr>";
            $Data .= "<td>" . $fila['TK_NIT'] . "</td>";
            $Data .= "<td>" . $fila['TK_TIPO_NIT'] . "</td>";
            $Data .= "<td>" . $fila['TK_RAZON_SOCIAL'] . "</td>";
            $Data .= "<td>" . $fila['TK_MUNI'] . "</td>";
            $Data .= "<td>" . $fila['TK_DIRECCION'] . "</td>";
            $Data .= "<td>" . $fila['TK_TELEFONO'] . "</td>";
            $Data .= "<td>" . $fila['TK_FAX'] . "</td>";
            $Data .= "<td>" . $fila['TK_EMAIL'] . "</td>";
            $Data .= "<td>
                                    <a class='btn default btn-xs purple '
                                         onclick='$.Cargar_Datos_Empre(" . $fila['TK_ID'] . ")'>
                                        <i class='fa fa-pencil-square-o'></i> Editar
                                   </a>
                                </td>";
            $Data .= "</tr>";
        }
        echo $Data;
    }
} else if ($_POST['ope'] == "Cargar_DatosEmpresa") {

    $consulta = "SELECT * FROM config_empresa where TK_ID='" . $_POST['TK_ID'] . "'";
    $outp = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $outp .= '{"TK_ID":"' . $fila["TK_ID"] . '",';
            $outp .= '"TK_TIPO_NIT":"' . $fila["TK_TIPO_NIT"] . '",';
            $outp .= '"TK_NIT":"' . $fila["TK_NIT"] . '",';
            $outp .= '"TK_RAZON_SOCIAL":"' . $fila["TK_RAZON_SOCIAL"] . '",';
            $outp .= '"TK_MUNI":"' . $fila["TK_MUNI"] . '",';
            $outp .= '"TK_DIRECCION":"' . $fila["TK_DIRECCION"] . '",';
            $outp .= '"TK_TELEFONO":"' . $fila["TK_TELEFONO"] . '",';
            $outp .= '"TK_FAX":"' . $fila["TK_FAX"] . '",';
            $outp .= '"TK_EMAIL":"' . $fila["TK_EMAIL"] . '"}';
        }

        echo($outp);
    }
} else if ($_POST['ope'] == "BusqEditServ") {

    $consulta = "SELECT * FROM servicios where id_serv='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    $outp = "";
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $outp .= '{"cod_serv":"' . $fila["cod_serv"] . '",';
            $outp .= '"desc_serv":"' . acentos($fila["desc_serv"]) . '",';
            $outp .= '"val_serv":"' . "$ " . number_format($fila["val_serv"], 2, ",", ".") . '",';
            $outp .= '"obs_serv":"' . acentos($fila["obs_serv"]) . '"}';
        }

        echo($outp);
    }
} else if ($_POST['ope'] == "SumaFecha") {

    $myDat = new stdClass();

    $fechaInicial = $_POST['fei'];
    $suma = "";
    if ($_POST['tie'] == "Dia(s)") {
        $suma = $_POST['nsu'] . " day";
    } else if ($_POST['tie'] == "Mes(es)") {
        $suma = $_POST['nsu'] . " month";
    } else if ($_POST['tie'] == "Año(s)") {
        $suma = $_POST['nsu'] . " year";
    }


    $fecha = !empty($fechaInicial) ? $fechaInicial : date('Y-m-d');

    $nuevaFecha = strtotime($suma, strtotime($fecha));
    $nuevaFecha = date('Y-m-d', $nuevaFecha);

    $myDat->nuevaFecha = $nuevaFecha;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST['ope'] == "inseranio") {

    $consulta = "INSERT INTO anios_contrato VALUES(null,'" . $_POST['idpre'] . "','" . $_POST['anio'] . "',"
            . "" . $_POST['vani'] . "," . $_POST['vmes'] . "," . $_POST['vani'] . ",'" . $_POST['fech'] . "')";
    mysqli_query($link, $consulta);

    $consulta = "UPDATE contrato_prevision set form_pago='" . $_POST['fpag'] . "' WHERE id_contr='" . $_POST['idpre'] . "'";
    mysqli_query($link, $consulta);
    echo 'bien';
} else if ($_POST['ope'] == "UpdatetLote") {

    $consulta = "UPDATE venta_deta_lote set jardin_vent='" . $_POST['jar'] . "',zona_vent='" . $_POST['zon'] . "',"
            . "lote_vent='" . $_POST['lot'] . "',tlote='" . $_POST['tlo'] . "',precio_vent='" . $_POST['pre'] . "',"
            . "costru_vent='" . $_POST['cos'] . "',obser_vent='" . $_POST['obs'] . "' WHERE id='" . $_POST['idl'] . "'";
    mysqli_query($link, $consulta);

    $consulta = "UPDATE contrato_venta set precios_vent=precios_vent-" . $_POST['pra'] . "+" . $_POST['pre'] . ","
            . "saldo=saldo-" . $_POST['pra'] . "+" . $_POST['pre'] . "  WHERE id_contr='" . $_POST['idv'] . "'";
    mysqli_query($link, $consulta);
    echo 'bien';
} else if ($_POST['ope'] == "UpdateOsario") {

    $consulta = "UPDATE venta_deta_osario set jardin_vent='" . $_POST['jar'] . "',osario_vent='" . $_POST['nos'] . "',"
            . "tosario_vent='" . $_POST['tos'] . "',prec_vent='" . $_POST['pre'] . "',"
            . "costr_vent='" . $_POST['cos'] . "',obser_vent='" . $_POST['obs'] . "' WHERE id='" . $_POST['ido'] . "'";
    mysqli_query($link, $consulta);

    $consulta = "UPDATE contrato_venta set precios_vent=precios_vent-" . $_POST['pra'] . "+" . $_POST['pre'] . ","
            . "saldo=saldo-" . $_POST['pra'] . "+" . $_POST['pre'] . "  WHERE id_contr='" . $_POST['idv'] . "'";
    mysqli_query($link, $consulta);
    echo 'bien';
} else if ($_POST['ope'] == "InsertLote") {

    $consulta = "INSERT INTO venta_deta_lote VALUES(null,'" . $_POST['idv'] . "','" . $_POST['jar'] . "','" . $_POST['zon'] . "',"
            . "'" . $_POST['lot'] . "','" . $_POST['tlo'] . "','" . $_POST['pre'] . "',"
            . "'" . $_POST['cos'] . "','" . $_POST['obs'] . "')";

    mysqli_query($link, $consulta);

    $consulta = "UPDATE contrato_venta set precios_vent=precios_vent+" . $_POST['pre'] . ","
            . "saldo=saldo+" . $_POST['pre'] . "  WHERE id_contr='" . $_POST['idv'] . "'";
    mysqli_query($link, $consulta);
    echo 'bien';
} else if ($_POST['ope'] == "AddAnexo") {

    $consulta = "INSERT INTO anexo_afiliados VALUES(null,'" . $_POST['idAfilia'] . "','" . $_POST['txt_DesAnex'] . "','" . $_POST['Src_File'] . "')";
    mysqli_query($link, $consulta);

    echo 'bien';
} else if ($_POST['ope'] == "InsertOsario") {

    $consulta = "INSERT INTO venta_deta_osario VALUES(null,'" . $_POST['idv'] . "','" . $_POST['jar'] . "','" . $_POST['nos'] . "',"
            . "'" . $_POST['tos'] . "','" . $_POST['pre'] . "','" . $_POST['cos'] . "','" . $_POST['obs'] . "')";

    mysqli_query($link, $consulta);

    $consulta = "UPDATE contrato_venta set precios_vent=precios_vent+" . $_POST['pre'] . ","
            . "saldo=saldo+" . $_POST['pre'] . "  WHERE id_contr='" . $_POST['idv'] . "'";
    mysqli_query($link, $consulta);
    echo 'bien';
} else if ($_POST['ope'] == "InsertOcupacion") {

    if ($_POST['acc'] == "1") {
        $consulta = "INSERT INTO ocup_lot_osaid VALUES(null,'" . $_POST['ido'] . "','" . $_POST['idv'] . "',"
                . "'" . $_POST['nom'] . "','" . $_POST['fec'] . "','" . $_POST['obs'] . "')";
    } else {
        $consulta = "UPDATE ocup_lot_osaid SET nombr='" . $_POST['nom'] . "',fecha='" . $_POST['fec'] . "',obser='" . $_POST['obs'] . "' WHERE id='" . $_POST['ido'] . "'";
    }

    mysqli_query($link, $consulta);

    echo 'bien';
} else if ($_POST['ope'] == "AnularRecibo") {

    $consulta = "UPDATE recibos set estado='ANULADO' WHERE id='" . $_POST['cod'] . "'";
    mysqli_query($link, $consulta);

    $consulta = "UPDATE anios_detalles set recibo='' WHERE id='" . $_POST['iddet'] . "'";
    mysqli_query($link, $consulta);

    echo 'bien';
} else if ($_POST['ope'] == "AnularReciboEmpr") {

    $consulta = "UPDATE recibos_empr set estado='ANULADO' WHERE id='" . $_POST['cod'] . "'";
    mysqli_query($link, $consulta);

    $consulta = "UPDATE cartera set Recibo_cartera='' WHERE idCartera='" . $_POST['iddet'] . "'";
    mysqli_query($link, $consulta);

    echo 'bien';
} else if ($_POST['ope'] == "AnularFactura") {

    $consulta = "UPDATE facturas_requi set estado='ANULADO' WHERE id_fact='" . $_POST['cod'] . "'";
    mysqli_query($link, $consulta);

    $consulta = "DELETE FROM detalles_facturarequi  WHERE conse_cons='" . $_POST['cod'] . "'";
    mysqli_query($link, $consulta);

    echo 'bien';
    
    } else if ($_POST['ope'] == "AnularFacturaConst") {

    $consulta = "UPDATE facturas_costancias set estado='ANULADO' WHERE id_fact='" . $_POST['cod'] . "'";
    mysqli_query($link, $consulta);

    $consulta = "DELETE FROM detalles_facturaconst  WHERE conse_cons='" . $_POST['cod'] . "'";
    mysqli_query($link, $consulta);

    echo 'bien';
} else if ($_POST['ope'] == "AnularFacturaArriendo") {

    $consulta = "UPDATE facturas_arriendo set estado='ANULADO' WHERE id_fact='" . $_POST['cod'] . "'";

    mysqli_query($link, $consulta);

    echo 'bien';
} else if ($_POST['ope'] == "del_afiliado") {

    $consulta = "DELETE FROM cliente  WHERE idCliente='" . $_POST['cod'] . "'";

    mysqli_query($link, $consulta);

    echo 'bien';
} else if ($_POST['ope'] == "InserDetaAnio") {

    $mes = count($_POST['mesp']);
    $saldo = $_POST['sal'];
    $meses = "";
    $vtpag = "";
    $valor = 0;
    $flag = "old";

    $sql = "SELECT MAX(id) AS id FROM anios_detalles WHERE anio='" . $_POST['anio'] . "'";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_det = $fila["id"];
        }
    } else {
        $flag = "new";
    }
    if ($flag == "new") {
        $sql = "SELECT saldo FROM anios_contrato WHERE id='" . $_POST['anio'] . "' ";
        $resulsql = mysqli_query($link, $sql);
        if (mysqli_num_rows($resulsql) > 0) {
            while ($fila = mysqli_fetch_array($resulsql)) {
                $saldo = $fila["saldo"];
            }
        }
    } else {
        $sql = "SELECT saldo FROM anios_detalles WHERE id='" . $id_det . "' ";
        $resulsql = mysqli_query($link, $sql);
        if (mysqli_num_rows($resulsql) > 0) {
            while ($fila = mysqli_fetch_array($resulsql)) {
                $saldo = $fila["saldo"];
            }
        }
    }

    $newsaldo = $saldo - $_POST['valp'];

    for ($i = 0; $i < $mes; $i++) {
        $meses = $meses . $_POST['mesp'][$i] . ',';
    }

    $meses = trim($meses, ', ');
    $id_det = "";
    $salnew = "";
    if ($_POST['acc'] == "1") {
        $consulta = "INSERT INTO anios_detalles VALUES(null,'" . $_POST['anio'] . "','" . $_POST['fpag'] . "',"
                . "" . $_POST['valp'] . ",'" . $meses . "','" . $_POST['fven'] . "','" . $_POST['recp'] . "','" . $_POST['obs'] . "'," . $newsaldo . ",'" . $_POST['pag'] . "')";
        mysqli_query($link, $consulta);
        $sql = "SELECT MAX(id) AS id,saldo FROM anios_detalles WHERE anio='" . $_POST['anio'] . "'";
        $resulsql = mysqli_query($link, $sql);
        if (mysqli_num_rows($resulsql) > 0) {
            while ($fila = mysqli_fetch_array($resulsql)) {
                $id_det = $fila["id"];
            }
        }
    } else {
        $id_det = $_POST['id'];
        $sql = "SELECT saldo,valor FROM anios_detalles WHERE id='" . $id_det . "' ";
        $resulsql = mysqli_query($link, $sql);
        if (mysqli_num_rows($resulsql) > 0) {
            while ($fila = mysqli_fetch_array($resulsql)) {
                $saldo = $fila["saldo"];
                $valor = $fila["valor"];
            }
        }

        $newsaldo = ($saldo + $valor) - $_POST['valp'];

//        $salnew = $newsaldo;

        $consulta = "UPDATE anios_detalles SET fpago='" . $_POST['fpag'] . "',"
                . "valor=" . $_POST['valp'] . ",mes='" . $meses . "',fvenc='" . $_POST['fven'] . "',"
                . "observ='" . $_POST['obs'] . "',saldo='" . $newsaldo . "',pagoen='" . $_POST['pag'] . "' WHERE id='" . $id_det . "'";
        mysqli_query($link, $consulta);
    }
    $sql = "SELECT saldo FROM anios_detalles WHERE id='" . $id_det . "' ";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $salnew = $fila["saldo"];
        }
    }
    if ($_POST['pag'] == "COBRADORES") {
        $consulta = "UPDATE contrato_prevision SET cobrador='" . $_POST['ncob'] . "',saldo='" . $salnew . "',fech_vcenc='" . $_POST['fven'] . "' WHERE id_contr='" . $_POST['prev'] . "'";
    } else {
        $consulta = "UPDATE contrato_prevision SET saldo='" . $salnew . "',fech_vcenc='" . $_POST['fven'] . "' WHERE id_contr='" . $_POST['prev'] . "'";
    }
    mysqli_query($link, $consulta);

    $consulta = "UPDATE anios_contrato SET saldo='" . $salnew . "' WHERE id='" . $_POST['anio'] . "'";
    mysqli_query($link, $consulta);


    echo 'bien-' . $id_det;
} else if ($_POST['ope'] == "InserDetaAnioEmpresa") {

    $mes = count($_POST['mesp']);
    $meses = "";
    $vtpag = "";

    for ($i = 0; $i < $mes; $i++) {
        $meses = $meses . $_POST['mesp'][$i] . ',';
    }

    $meses = trim($meses, ', ');
    $id_det = "";
    if ($_POST['acc'] == "1") {
        $consulta = "INSERT INTO cartera VALUES(null,'" . $_POST['anio'] . "','" . $meses . "',"
                . "'" . $_POST['empr'] . "','" . $_POST['valp'] . "','','" . $_POST['fpag'] . "',"
                . "'" . $_POST['fven'] . "','" . $_POST['nafi'] . "','" . $_SESSION['ses_user'] . "',"
                . "'0000-00-00','" . $_POST['obs'] . "','" . $_POST['pag'] . "','" . $_POST['ncob'] . "')";
        //  echo $consulta;
        mysqli_query($link, $consulta);
        $sql = "SELECT MAX(idCartera) AS id FROM cartera";
        $resulsql = mysqli_query($link, $sql);
        if (mysqli_num_rows($resulsql) > 0) {
            while ($fila = mysqli_fetch_array($resulsql)) {
                $id_cart = $fila["id"];
            }
        }
    } else {
        $id_cart = $_POST['id'];
        $consulta = "UPDATE  cartera set mes_cartera='" . $meses . "',"
                . "Valor_cartera='" . $_POST['valp'] . "',Recibo_cartera='" . $_POST['recp'] . "',Fecha_pago_cartera='" . $_POST['fpag'] . "',"
                . "Fecha_vence_cartera='" . $_POST['fven'] . "',Total_clientes_cartera='" . $_POST['nafi'] . "',Usuario_cartera='" . $_SESSION['ses_user'] . "',"
                . "observ_cartera='" . $_POST['obs'] . "',pagoen_cartera='" . $_POST['pag'] . "',ncobrador_cartera='" . $_POST['ncob'] . "' WHERE idCartera='" . $_POST['id'] . "'";
        mysqli_query($link, $consulta);
    }
    //echo $consulta;


    echo 'bien-' . $id_cart;
} else if ($_POST['ope'] == "InserDetaPagVent") {

    $saldo = $_POST['sal'] - $_POST['valp'];
    if ($_POST['acc'] == "1") {
        $consulta = "INSERT INTO detalles_venta VALUES(null,'" . $_POST['vent'] . "','" . $_POST['fpag'] . "','" . $_POST['fven'] . "',"
                . "" . $_POST['valp'] . ",'" . $_POST['obs'] . "'," . $saldo . ")";
    } else {
        $consulta = "UPDATE detalles_venta SET fpago='" . $_POST['fpag'] . "',"
                . "fvenc='" . $_POST['fven'] . "',observ='" . $_POST['obs'] . "' WHERE id='" . $_POST['id'] . "' and contrato='" . $_POST['vent'] . "'";
    }
    mysqli_query($link, $consulta);
    if ($_POST['acc'] == "1") {
        $consulta = "UPDATE contrato_venta SET saldo='" . $saldo . "' WHERE id_contr='" . $_POST['vent'] . "'";
// echo $consulta;
        mysqli_query($link, $consulta);
    }


    echo 'bien';
} else if ($_POST['ope'] == "BusqAnexosAfiliados") {

    $myDat = new stdClass();
////ANEXOS

    $consulta = "SELECT * FROM\n" .
            "  anexo_afiliados  \n" .
            "WHERE id_afiliado = '" . $_POST["cod"] . "' ";
//    echo $consulta;
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Anexos = "<thead>\n" .
            "      <tr>\n" .
            "          <td>\n" .
            "              <i class='fa fa-angle-right'></i> #\n" .
            "          </td>\n" .
            "          <td>\n" .
            "              <i class='fa fa-angle-right'></i> Descripci&oacute;n\n" .
            "          </td>\n" .
            "          <td>\n" .
            "              <i class='fa fa-angle-right'></i> Nombre Del Archivo\n" .
            "          </td>\n" .
            "          <td>\n" .
            "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
            "          </td>\n" .
            "      </tr>\n" .
            "  </thead>"
            . "   <tbody >\n";

    $contAnexos = 0;

    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contAnexos++;
            $Tab_Anexos .= "<tr class='selected'><td>" . $contAnexos . "</td>";
            $Tab_Anexos .= "<td>" . $fila["desc_anexo"] . "</td>";
            $Tab_Anexos .= "<td>" . $fila["url_anexo"] . "</td>";
            $Tab_Anexos .= "<td><a href='" . "AnexosEmpresa/" . $fila["url_anexo"] . "' target='_blank' class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-search\"></i> Ver</a>";
            $Tab_Anexos .= "<a onclick=\"$.QuitarAnexo('" . $fila["id"] . "')\" class=\"btn default btn-xs red\">"
                    . "<i class=\"fa fa-trash-o\"></i> Quitar</a></td></tr>";
        }
    }
    $Tab_Anexos .= "</tbody>";
    $myDat->Tab_Anexos = $Tab_Anexos;



    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST['ope'] == "InserRecibPago") {

    $id_det = $_POST['deta'];
    $consulta = "INSERT INTO recibos VALUES(null,'" . $_POST['codr'] . "','" . $_POST['frec'] . "','" . $_POST['valp'] . "',"
            . "'" . $_POST['inde'] . "','" . $_POST['nomb'] . "','" . $_POST['vall'] . "','" . $_POST['conc'] . "',"
            . "'" . $_POST['cmes'] . "','" . $_POST['fpag'] . "','" . $_POST['nche'] . "','" . $_POST['nban'] . "',"
            . "'" . $_POST['prev'] . "','" . $_POST['anio'] . "','" . $id_det . "','ACTIVO')";
    // echo $consulta;
    mysqli_query($link, $consulta);

    $consulta = "UPDATE anios_detalles SET recibo='" . $_POST['codr'] . "' WHERE id='" . $id_det . "'";
    mysqli_query($link, $consulta);


    $id_rec = "";
    $sql = "SELECT MAX(id) AS id FROM recibos";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_rec = $fila["id"];
        }
    }
    if ($_POST['paen'] == "OFICINA") {
        $consulta = "UPDATE consecutivos SET actual='" . $_POST['crec'] . "' WHERE grupo='RECIBOPAE'";
        mysqli_query($link, $consulta);
    }


    echo 'bien' . "/" . $id_rec . "/" . $_POST['codr'];
} else if ($_POST['ope'] == "InserRecibPagoProrr") {

    $id_pro = $_POST['pror'];
    $consulta = "INSERT INTO recibos_prorrog VALUES(null,'" . $_POST['codr'] . "','" . $_POST['frec'] . "','" . $_POST['valp'] . "',"
            . "'" . $_POST['inde'] . "','" . $_POST['nomb'] . "','" . $_POST['vall'] . "','" . $_POST['conc'] . "',"
            . "'" . $_POST['fpag'] . "','" . $_POST['nche'] . "','" . $_POST['nban'] . "',"
            . "'ACTIVO')";
    // echo $consulta;
    mysqli_query($link, $consulta);



    $id_rec = "";
    $sql = "SELECT MAX(id) AS id FROM recibos_prorrog";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_rec = $fila["id"];
        }
    }


    $consulta = "UPDATE prorroga_arriendo SET recibo='" . $id_rec . "' WHERE id='" . $id_pro . "'";
    mysqli_query($link, $consulta);

    echo 'bien' . "/" . $id_rec . "/" . $_POST['codr'];
} else if ($_POST['ope'] == "InserRecibPagoEmpresa") {

    $id_det = $_POST['deta'];
    $consulta = "INSERT INTO recibos_empr VALUES(null,'" . $_POST['codr'] . "','" . $_POST['frec'] . "','" . $_POST['valp'] . "',"
            . "'" . $_POST['inde'] . "','" . $_POST['nomb'] . "','" . $_POST['vall'] . "','" . $_POST['conc'] . "',"
            . "'" . $_POST['cmes'] . "','" . $_POST['fpag'] . "','" . $_POST['nche'] . "','" . $_POST['nban'] . "',"
            . "'" . $id_det . "','" . $_POST['anio'] . "','ACTIVO')";
    // echo $consulta;
    mysqli_query($link, $consulta);

    $consulta = "UPDATE cartera SET Recibo_cartera='" . $_POST['codr'] . "' WHERE idCartera='" . $id_det . "'";
    mysqli_query($link, $consulta);


    $id_rec = "";
    $sql = "SELECT MAX(id) AS id FROM recibos_empr";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_rec = $fila["id"];
        }
    }
    if ($_POST['paen'] == "OFICINA") {
        $consulta = "UPDATE consecutivos SET actual='" . $_POST['crec'] . "' WHERE grupo='RECIBOPAE'";
        mysqli_query($link, $consulta);
    }


    echo 'bien' . "/" . $id_rec . "/" . $_POST['codr'];
} else if ($_POST['ope'] == "BusqEditCeme") {
    $outp = "";
    $consulta = "SELECT * FROM cementerios where id_cem='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $outp .= '{"cod_cem":"' . $fila["cod_cem"] . '",';
            $outp .= '"nom_cem":"' . acentos($fila["nom_cem"]) . '",';
            $outp .= '"obser_cem":"' . acentos($fila["obser_cem"]) . '"}';
        }

        echo($outp);
    }
} else if ($_POST['ope'] == "BusqEditUsu") {
    $outp = "";
    $consulta = "SELECT * FROM usuarios where cue_alias='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $outp .= '{"cue_inden":"' . $fila["cue_inden"] . '",';
            $outp .= '"cue_nombres":"' . $fila["cue_nombres"] . '",';
            $outp .= '"cue_sexo":"' . $fila["cue_sexo"] . '",';
            $outp .= '"niv_codigo":"' . $fila["niv_codigo"] . '",';
            $outp .= '"cue_alias":"' . $fila["cue_alias"] . '",';
            $outp .= '"cue_estado":"' . $fila["cue_estado"] . '",';
            $outp .= '"cue_correo":"' . $fila["cue_correo"] . '",';
            $outp .= '"cue_tele":"' . $fila["cue_tele"] . '",';
            $outp .= '"cue_dir":"' . $fila["cue_dir"] . '"}';
        }

        echo($outp);
    }
} else if ($_POST['ope'] == "BusqEditConse") {
    $outp = "";
    $consulta = "SELECT * FROM consecutivos where id_conse='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $outp .= '{"estruct":"' . $fila["estruct"] . '",';
            $outp .= '"descrip":"' . $fila["descrip"] . '",';
            $outp .= '"grupo":"' . $fila["grupo"] . '",';
            $outp .= '"inicio":"' . $fila["inicio"] . '",';
            $outp .= '"actual":"' . $fila["actual"] . '",';
            $outp .= '"vigencia":"' . $fila["vigencia"] . '",';
            $outp .= '"observ":"' . $fila["observ"] . '",';
            $outp .= '"estr_fin":"' . $fila["estr_fin"] . '",';
            $outp .= '"digitos":"' . $fila["digitos"] . '"}';
        }

        echo($outp);
    }
} else if ($_POST['ope'] == "BusqEdNot") {
    $outp = "";
    $consulta = "SELECT * FROM noticias where id_noticia='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $outp .= '{"titu_not":"' . $fila["titu_not"] . '",';
            $outp .= '"descr":"' . $fila["descr"] . '",';
            $outp .= '"img":"' . $fila["img"] . '",';
            $outp .= '"id_noticia":"' . $fila["id_noticia"] . '"}';
        }

        echo($outp);
    }
} else if ($_POST['ope'] == "BusqEdGal") {
    $outp = "";
    $consulta = "SELECT * FROM galerias where id_galeria='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {


            $outp .= '{"titulo":"' . $fila["titulo"] . '",';
            $outp .= '"obser":"' . $fila["obser"] . '",';
            $outp .= '"id_galeria":"' . $fila["id_galeria"] . '"}';
        }

        echo($outp);
    }
} else if ($_POST['ope'] == "BusqEditCli") {
    $outp = "";
    $consulta = "SELECT * FROM clientes where id_cli='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $outp .= '{"inde_cli":"' . $fila["inde_cli"] . '",';
            $outp .= '"nom_cli":"' . acentos($fila["nom_cli"]) . '",';
            $outp .= '"sex_cli":"' . $fila["sex_cli"] . '",';
            $outp .= '"fec_cli":"' . $fila["fec_cli"] . '",';
            $outp .= '"dir_cli":"' . acentos($fila["dir_cli"]) . '",';
            $outp .= '"email_cli":"' . acentos($fila["email_cli"]) . '",';
            $outp .= '"tel_cli":"' . $fila["tel_cli"] . '",';
            $outp .= '"obs_cli":"' . acentos($fila["obs_cli"]) . '"}';
        }

        echo($outp);
    }
} else if ($_POST['ope'] == "BusqEditAfil") {
    $outp = "";
    $consulta = "SELECT * FROM cliente where idCliente='" . $_POST['cod'] . "'";
    // echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $outp .= '{"Cedula_cliente":"' . $fila["Cedula_cliente"] . '",';
            $outp .= '"Nombres_cliente":"' . acentos($fila["Nombres_cliente"]) . '",';
            $outp .= '"Apellidos_cliente":"' . acentos($fila["Apellidos_cliente"]) . '",';
            $outp .= '"Fecha_ingreso_cliente":"' . $fila["Fecha_ingreso_cliente"] . '",';
            $outp .= '"direccion_cliente":"' . acentos($fila["direccion_cliente"]) . '",';
            $outp .= '"telefono_cliente":"' . $fila["telefono_cliente"] . '",';
            $outp .= '"celular_cliente":"' . $fila["celular_cliente"] . '",';
            $outp .= '"barrio_cliente":"' . $fila["barrio_cliente"] . '",';
            $outp .= '"correo_cliente":"' . $fila["correo_cliente"] . '",';
            $outp .= '"idEmpresa_cliente":"' . $fila["idEmpresa_cliente"] . '",';
            $outp .= '"idPlan_cliente":"' . $fila["idPlan_cliente"] . '",';
            $outp .= '"contrato_cliente":"' . $fila["contrato_cliente"] . '",';
            $outp .= '"Estado_cliente":"' . $fila["Estado_cliente"] . '",';
            $outp .= '"tipo_cliente":"' . $fila["tipo_cliente"] . '",';
            $outp .= '"fecha_nacimiento":"' . $fila["fecha_nacimiento"] . '",';
            $outp .= '"sexo":"' . $fila["sexo"] . '",';
            $outp .= '"tipo_vinculacion":"' . $fila["tipo_vinculacion"] . '",';
            $outp .= '"empresa_anterior":"' . $fila["empresa_anterior"] . '",';
            $outp .= '"fecha_creacion":"' . $fila["fecha_creacion"] . '",';
            $outp .= '"asesor":"' . $fila["asesor"] . '",';
            $outp .= '"Cuota_cliente":"' . $fila["Cuota_cliente"] . '"}';
        }

        echo($outp);
    }
} else if ($_POST['ope'] == "BusqEditBenefi") {
    $outp = "";
    $consulta = "SELECT * FROM beneficiario where idBeneficiario='" . $_POST['cod'] . "'";
    // echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $outp .= '{"nombre_beneficiario":"' . acentos($fila["nombre_beneficiario"]) . '",';
            $outp .= '"apellido_beneficiario":"' . acentos($fila["apellido_beneficiario"]) . '",';
            $outp .= '"parentesco_beneficiario":"' . acentos($fila["parentesco_beneficiario"]) . '",';
            $outp .= '"nacimiento_beneficiario":"' . $fila["edad_beneficiario"] . '",';
            $outp .= '"tipo_benefi":"' . $fila["tipo_benefi"] . '",';
            $outp .= '"ciudad_beneficiario":"' . $fila["ciudad_beneficiario"] . '",';
            $outp .= '"estado_beneficiario":"' . $fila["estado_beneficiario"] . '"}';
        }

        echo($outp);
    }
} else if ($_POST['ope'] == "BusqEditEmpr") {
    $outp = "";
    $consulta = "SELECT * FROM empresa where idEmpresa='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $outp .= '{"Nombre_empresa":"' . $fila["Nombre_empresa"] . '",';
            $outp .= '"Nit_empresa":"' . acentos($fila["Nit_empresa"]) . '",';
            $outp .= '"Direccion_empresa":"' . $fila["Direccion_empresa"] . '",';
            $outp .= '"Telefono_empresa":"' . $fila["Telefono_empresa"] . '",';
            $outp .= '"Celular_empresa":"' . acentos($fila["Celular_empresa"]) . '",';
            $outp .= '"email_empresa":"' . acentos($fila["email_empresa"]) . '",';
            $outp .= '"Contacto_empresa":"' . $fila["Contacto_empresa"] . '",';
            $outp .= '"Cobrador_empresa":"' . $fila["Cobrador_empresa"] . '",';
            $outp .= '"Fecha_ingreso_empresa":"' . $fila["Fecha_ingreso_empresa"] . '",';
            $outp .= '"Comentario_empresa":"' . acentos($fila["Comentario_empresa"]) . '"}';
        }

        echo($outp);
    }
} else if ($_POST['ope'] == "BusqEditFuner") {
    $outp = "";
    $consulta = "SELECT * FROM funerarias where id_fune='" . $_POST['cod'] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $outp .= '{"cod_fune":"' . $fila["cod_fune"] . '",';
            $outp .= '"nom_fune":"' . acentos($fila["nom_fune"]) . '",';
            $outp .= '"nit":"' . $fila["nit"] . '",';
            $outp .= '"dir":"' . acentos($fila["dir"]) . '",';
            $outp .= '"tel":"' . $fila["tel"] . '",';
            $outp .= '"obser_fune":"' . acentos($fila["obser_fune"]) . '"}';
        }

        echo($outp);
    }
} else if ($_POST['ope'] == "BusqEditIgle") {
    $outp = "";
    $consulta = "SELECT * FROM iglesias where id_igle='" . $_POST['cod'] . "'";
// echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $outp .= '{"cod_igle":"' . $fila["cod_igle"] . '",';
            $outp .= '"nom_igle":"' . acentos($fila["nom_igle"]) . '",';
            $outp .= '"obser_igle":"' . acentos($fila["obser_igle"]) . '"}';
        }

        echo($outp);
    }
} else if ($_POST["ope"] == "verfFune") {

    $consulta = "SELECT * FROM funerarias where cod_fune='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfConse") {

    $consulta = "SELECT * FROM constancias where cons_constan='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "busCodRequ") {

    $exist = "";
    $consulta = "SELECT * FROM requisiciones where cod_req='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $exist = "1";
    }
    $consulta = "SELECT * FROM inhumaciones where conse='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $exist = "1";
    }
    echo $exist;
} else if ($_POST["ope"] == "verfConseReciPrev") {

    $consulta = "SELECT * FROM recibos where conse='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfConseReciPror") {

    $consulta = "SELECT * FROM recibos_prorrog where conse='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfConsePrev") {

    $consulta = "SELECT * FROM contrato_prevision where ncontrato='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfIgle") {

    $consulta = "SELECT * FROM iglesias where cod_igle='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfServ") {

    $consulta = "SELECT * FROM servicios where cod_serv='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfUsu") {

    $consulta = "SELECT * FROM usuarios where cue_inden='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfNomUsu") {

    $consulta = "SELECT * FROM usuarios where cue_alias='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfCeme") {

    $consulta = "SELECT * FROM cementerios where cod_cem='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfClie") {

    $consulta = "SELECT * FROM clientes where inde_cli='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "val_anio") {

    $consulta = "SELECT * FROM anios_contrato where anio='" . $_POST['cod'] . "' and contrato='" . $_POST['contr'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfEmpr") {

    $consulta = "SELECT * FROM empresa where Nit_empresa='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "DelImg") {
    $nomgal = "";
    $nomimg = "";
    $consulta = "SELECT gal.id_galeria id, gal.nombre nomgal, img.ruta rut FROM imagenes img LEFT JOIN galerias gal ON img.galeria=gal.id_galeria WHERE img.id_img='" . $_POST['cod'] . "'";
// echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $nomgal = $fila["nomgal"];
            $nomimg = $fila["rut"];
        }
    }
    $ruta = "galerias/" . $nomgal . "/" . $nomimg;
// echo $ruta;
    $consulta = "DELETE FROM imagenes where id_img='" . $_POST['cod'] . "'";
    $qc = mysqli_query($link, $consulta);
    if ($qc == true) {
        if (file_exists($ruta)) {
            unlink($ruta);
            echo 'bien';
        } else {
            echo 'mal';
        }
    }
} else if ($_POST["ope"] == "del_anios") {

    $consulta = "DELETE FROM anios_contrato where id='" . $_POST['cod'] . "'";
    $qc = mysqli_query($link, $consulta);
    if ($qc == true) {
        echo 'bien';
    } else {
        echo 'mal';
    }
} else if ($_POST["ope"] == "delectOcupa") {

    $consulta = "DELETE FROM ocup_lot_osaid where id='" . $_POST['cod'] . "'";
    $qc = mysqli_query($link, $consulta);
    if ($qc == true) {
        echo 'bien';
    } else {
        echo 'mal';
    }
} else if ($_POST["ope"] == "del_anexo_bene") {

    $consulta = "DELETE FROM anexo_afiliados where id='" . $_POST['cod'] . "'";
    $qc = mysqli_query($link, $consulta);
    if ($qc == true) {
        echo 'bien';
    } else {
        echo 'mal';
    }
} else if ($_POST["ope"] == "delectLote") {

    $consulta = "DELETE FROM venta_deta_lote where id='" . $_POST['cod'] . "'";
    $qc = mysqli_query($link, $consulta);


    if ($qc == true) {
        echo 'bien';
        $consulta = "UPDATE contrato_venta set precios_vent=precios_vent-" . $_POST['pre'] . ","
                . "saldo=saldo-" . $_POST['pre'] . "  WHERE id_contr='" . $_POST['idv'] . "'";
        mysqli_query($link, $consulta);
    } else {
        echo 'mal';
    }
} else if ($_POST["ope"] == "delectOsario") {

    $consulta = "DELETE FROM venta_deta_osario where id='" . $_POST['cod'] . "'";
    $qc = mysqli_query($link, $consulta);


    if ($qc == true) {
        echo 'bien';
        $consulta = "UPDATE contrato_venta set precios_vent=precios_vent-" . $_POST['pre'] . ","
                . "saldo=saldo-" . $_POST['pre'] . "  WHERE id_contr='" . $_POST['idv'] . "'";
        mysqli_query($link, $consulta);
    } else {
        echo 'mal';
    }
} else if ($_POST["ope"] == "deleteDetPago") {
    $flag = "ok";

    $consulta = "SELECT recibo, anio FROM anios_detalles WHERE id='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $rec = $fila['recibo'];
            $ani = $fila['anio'];
        }
    }


    $consulta = "SELECT MAX(id) id  FROM anios_detalles WHERE anio='" . $ani . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $id = $fila['id'];
        }
    }
    if ($rec != "") {
        $flag = "rec";
    }

    if ($id != $_POST['cod']) {
        $flag = "ult";
    }


    if ($flag == "ok") {
        $consulta = "UPDATE contrato_prevision SET saldo=saldo+'" . $_POST['val'] . "' WHERE id_contr='" . $_POST['idp'] . "'";
        mysqli_query($link, $consulta);

        $consulta = "UPDATE anios_contrato SET saldo=saldo+'" . $_POST['val'] . "' WHERE contrato='" . $_POST['idp'] . "'";
        mysqli_query($link, $consulta);

        $consulta = "DELETE FROM anios_detalles where id='" . $_POST['cod'] . "'";
        $qc = mysqli_query($link, $consulta);
        $flag = "bien";
    }
    echo $flag;
} else if ($_POST["ope"] == "deleteDetPagoEmpre") {
    $flag = "no";

    $consulta = "SELECT Recibo_cartera FROM cartera WHERE idCartera='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $rec = $fila['Recibo_cartera'];
        }
    }

    if ($rec == "") {
        $consulta = "DELETE FROM cartera where idCartera='" . $_POST['cod'] . "'";
        $qc = mysqli_query($link, $consulta);
        $flag = "bien";
    } else {
        $flag = 'no';
    }
    echo $flag;
} else if ($_POST["ope"] == "VentClientes") {

    $cad = "";
    $cad2 = "";
    $consulta = "";
    $contador = 0;
    $myDat = new stdClass();
    $i = 0;
    $j = 0;

    $regmos = 7;

    $buscar = array();
    $cbp = "";

    $regemp = 0;
    $pagact = 1;
    $pag = "1";
    if ($pag != null) {
        $regemp = (intval($pag) - 1) * $regmos;

        $pagact = intval($pag);
    }
    $cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Identificaci&oacute;n"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Nombre"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Acci&oacute;n"
            . "</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";

    $busq = $_POST["bus"];

    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT * FROM  clientes  WHERE ";

        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  inde_cli, "
                    . "  ' ', "
                    . "  nom_cli "
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {
                
            } else {
                $consulta .= " AND ";
            }
        }
        $consulta .= " order by nom_cli ASC LIMIT " . $regemp . "," . $regmos;
    } else {

        $consulta = "SELECT * FROM clientes order by nom_cli ASC  LIMIT " . $regemp . "," . $regmos;
    }


    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {


            $cad .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $fila["inde_cli"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . acentos($fila["nom_cli"]) . ""
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "<a  onclick=\"$.SelCli('" . $fila["id_cli"] . "//" . $fila["inde_cli"] . "//" . acentos($fila["nom_cli"]) . "//" . $fila["sex_cli"] . "//" . $fila["fec_cli"] . "//" . acentos($fila["dir_cli"]) . "//" . $fila["tel_cli"] . "//" . acentos($fila["barrio"]) . "//" . $fila["email_cli"] . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-check\"></i> Seleccionar</a>"
                    . "</td>"
                    . "</tr>";
        }
    }

    $myDat->tab_cli = $cad;
    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "VentClientesEstadoPagos") {

    $cad = "";
    $cad2 = "";
    $consulta = "";
    $contador = 0;
    $myDat = new stdClass();
    $i = 0;
    $j = 0;

    $regmos = 7;

    $buscar = array();
    $cbp = "";

    $regemp = 0;
    $pagact = 1;
    $pag = "1";
    if ($pag != null) {
        $regemp = (intval($pag) - 1) * $regmos;

        $pagact = intval($pag);
    }
    $cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Identificaci&oacute;n"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Nombre"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Acci&oacute;n"
            . "</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";

    $busq = $_POST["bus"];

    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        if ($_POST["tipcli"] == "INDIVIDUAL") {
            $consulta = "SELECT inde_cli cedu, nom_cli nomb FROM  clientes  WHERE ";
            for ($i = 0; $i < count($buscar, 1); $i++) {
                $consulta .= "CONCAT( "
                        . "  inde_cli, "
                        . "  ' ', "
                        . "  nom_cli "
                        . ") LIKE '%" . $buscar[$i] . "%' ";
                if (($i) == count($buscar, 1) - 1) {
                    
                } else {
                    $consulta .= " AND ";
                }
            }
            $consulta .= " AND estado='ACTIVO' order by nom_cli ASC LIMIT 30";
        } else {
            $consulta = "SELECT CONCAT(Nombres_cliente,' ',Apellidos_cliente) nomb, Cedula_cliente cedu  FROM  cliente  WHERE ";
            for ($i = 0; $i < count($buscar, 1); $i++) {
                $consulta .= "CONCAT( "
                        . "  Cedula_cliente, "
                        . "  ' ', "
                        . "  Nombres_cliente, "
                        . "  ' ', "
                        . "  Apellidos_cliente "
                        . ") LIKE '%" . $buscar[$i] . "%' ";
                if (($i) == count($buscar, 1) - 1) {
                    
                } else {
                    $consulta .= " AND ";
                }
            }
            $consulta .= " AND Estado_cliente='ACTIVO' order by Nombres_cliente ASC LIMIT 30";
        }
    } else {
        if ($_POST["tipcli"] == "INDIVIDUAL") {
            $consulta = "SELECT inde_cli cedu, nom_cli nomb FROM clientes WHERE estado='ACTIVO' order by nom_cli ASC  LIMIT 30";
        } else {
            $consulta = "SELECT CONCAT(Nombres_cliente,' ',Apellidos_cliente) nomb, Cedula_cliente cedu FROM cliente WHERE Estado_cliente='ACTIVO' order by Nombres_cliente ASC LIMIT 30";
        }
    }

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {


            $cad .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $fila["cedu"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . acentos($fila["nomb"]) . ""
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "<a  onclick=\"$.SelCli('" . $fila["cedu"] . "//" . acentos($fila["nomb"]) . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-check\"></i> Seleccionar</a>"
                    . "</td>"
                    . "</tr>";
        }
    }

    $myDat->tab_cli = $cad;
    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "VentCesionario") {

    $cad = "";
    $cad2 = "";
    $consulta = "";
    $contador = 0;
    $myDat = new stdClass();
    $i = 0;
    $j = 0;

    $regmos = 7;
    $buscar = array();


    $regemp = 0;
    $pagact = 1;
    $pag = "1";
    if ($pag != null) {
        $regemp = (intval($pag) - 1) * $regmos;

        $pagact = intval($pag);
    }
    $cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Identificaci&oacute;n"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Nombre"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Acci&oacute;n"
            . "</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";

    $busq = $_POST["bus"];

    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT * FROM  clientes  WHERE ";

        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  inde_cli, "
                    . "  ' ', "
                    . "  nom_cli "
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {
                
            } else {
                $consulta .= " AND ";
            }
        }
        $consulta .= " order by nom_cli ASC LIMIT " . $regemp . "," . $regmos;
    } else {

        $consulta = "SELECT * FROM clientes order by nom_cli ASC  LIMIT " . $regemp . "," . $regmos;
    }



    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {


            $cad .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $fila["inde_cli"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . acentos($fila["nom_cli"]) . ""
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "<a  onclick=\"$.SelCesio('" . $fila["id_cli"] . "//" . $fila["inde_cli"] . "//" . acentos($fila["nom_cli"]) . "//" . $fila["sex_cli"] . "//" . $fila["fec_cli"] . "//" . acentos($fila["dir_cli"]) . "//" . $fila["tel_cli"] . "//" . acentos($fila["barrio"]) . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-check\"></i> Seleccionar</a>"
                    . "</td>"
                    . "</tr>";
        }
    }

    $myDat->tab_cli = $cad;
    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "VentClientesVentLote") {

    $cad = "";
    $cad2 = "";
    $consulta = "";
    $contador = 0;
    $myDat = new stdClass();
    $i = 0;
    $j = 0;

    $regmos = 7;

    $buscar = array();

    $regemp = 0;
    $pagact = 1;
    $pag = "1";
    if ($pag != null) {
        $regemp = (intval($pag) - 1) * $regmos;

        $pagact = intval($pag);
    }
    $cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Identificaci&oacute;n"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Nombre"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> No. Contrato"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Acci&oacute;n"
            . "</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";

    $busq = $_POST["bus"];

    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT * FROM contrato_venta contv LEFT JOIN clientes cli ON contv.ident_vent=cli.inde_cli   WHERE ";

        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  inde_cli, "
                    . "  ' ', "
                    . "  nom_cli "
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {
                
            } else {
                $consulta .= " AND ";
            }
        }
        $consulta .= " AND contv.estado='ACTIVO' order by nom_cli ASC LIMIT " . $regemp . "," . $regmos;
    } else {

        $consulta = "SELECT * FROM contrato_venta contv LEFT JOIN clientes cli ON contv.ident_vent=cli.inde_cli WHERE contv.estado='ACTIVO' order by nom_cli ASC  LIMIT " . $regemp . "," . $regmos;
    }



    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {


            $cad .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $fila["inde_cli"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . acentos($fila["nom_cli"]) . ""
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["pedido_contr"] . ""
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "<a  onclick=\"$.SelCli('" . $fila["id_cli"] . "//" . $fila["inde_cli"] . "//" . acentos($fila["nom_cli"]) . "//" . $fila["sex_cli"] . "//" . $fila["fec_cli"] . "//" . acentos($fila["dir_cli"]) . "//" . $fila["tel_cli"] . "//" . $fila["barrio"] . "//" . $fila["id_contr"] . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-check\"></i> Seleccionar</a>"
                    . "</td>"
                    . "</tr>";
        }
    }

    $myDat->tab_cli = $cad;
    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "VentClientesExhumaciones") {

    $cad = "";
    $cad2 = "";
    $consulta = "";
    $contador = 0;
    $myDat = new stdClass();
    $i = 0;
    $j = 0;

    $regmos = 7;

    $buscar = array();

    $regemp = 0;
    $pagact = 1;
    $pag = "1";
    if ($pag != null) {
        $regemp = (intval($pag) - 1) * $regmos;

        $pagact = intval($pag);
    }
    $cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Identificaci&oacute;n"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Nombre"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> No. Contrato"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Acci&oacute;n"
            . "</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";

    $busq = $_POST["bus"];

    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);
        if ($_POST["tip"] == "Propio") {
            $consulta = "SELECT contr.id_contr id,contr.pedido_contr conse, cli.id_cli idcl,cli.sex_cli sex,cli.fec_cli fec,cli.dir_cli dir,cli.tel_cli tel,cli.barrio barr, cli.inde_cli iden,cli.nom_cli nom FROM contrato_venta contr LEFT JOIN clientes cli ON contr.ident_vent=cli.inde_cli WHERE ";
        } else {
            $consulta = "SELECT id_arriendo id,OrdInhum conse,cli.id_cli idcl,cli.sex_cli sex,cli.fec_cli fec,cli.dir_cli dir,cli.tel_cli tel,cli.barrio barr, cli.inde_cli iden,cli.nom_cli nom FROM contrato_arriendo contr LEFT JOIN clientes cli ON contr.ced_cli=cli.inde_cli WHERE  ";
        }


        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  cli.inde_cli, "
                    . "  ' ', "
                    . "  cli.nom_cli "
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {
                
            } else {
                $consulta .= " AND ";
            }
        }
        $consulta .= " AND contr.estado='ACTIVO' order by cli.nom_cli ASC LIMIT " . $regemp . "," . $regmos;
    } else {
        if ($_POST["tip"] == "Propio") {
            $consulta = "SELECT id_contr id,pedido_contr conse,cli.id_cli idcl,cli.sex_cli sex,cli.fec_cli fec,cli.dir_cli dir,cli.tel_cli tel,cli.barrio barr, cli.inde_cli iden,cli.nom_cli nom FROM contrato_venta contr LEFT JOIN clientes cli ON contr.ident_vent=cli.inde_cli WHERE contr.estado='ACTIVO' order by cli.nom_cli ASC  LIMIT " . $regemp . "," . $regmos;
        } else {
            $consulta = "SELECT id_arriendo id,OrdInhum conse,cli.id_cli idcl,cli.sex_cli sex,cli.fec_cli fec,cli.dir_cli dir,cli.tel_cli tel,cli.barrio barr, cli.inde_cli iden,cli.nom_cli nom FROM contrato_arriendo contr LEFT JOIN clientes cli ON contr.ced_cli=cli.inde_cli WHERE contr.estado='ACTIVO' order by cli.nom_cli ASC  LIMIT " . $regemp . "," . $regmos;
        }
    }
// echo $consulta;

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {


            $cad .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $fila["iden"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . acentos($fila["nom"]) . ""
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["conse"] . ""
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "<a  onclick=\"$.SelCli('" . $fila["idcl"] . "//" . $fila["iden"] . "//" . acentos($fila["nom"]) . "//" . $fila["sex"] . "//" . $fila["fec"] . "//" . acentos($fila["dir"]) . "//" . $fila["tel"] . "//" . $fila["barr"] . "//" . $fila["id"] . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-check\"></i> Seleccionar</a>"
                    . "</td>"
                    . "</tr>";
        }
    }

    $myDat->tab_cli = $cad;
    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "VentContratosExhumaciones") {

    $cad = "";
    $cad2 = "";
    $consulta = "";
    $contador = 0;
    $myDat = new stdClass();
    $i = 0;
    $j = 0;

    $regmos = 7;

    $buscar = array();

    $regemp = 0;
    $pagact = 1;
    $pag = "1";
    if ($pag != null) {
        $regemp = (intval($pag) - 1) * $regmos;

        $pagact = intval($pag);
    }
    $cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Contrato"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Titular"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Ubicacion"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Fallecido"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Acci&oacute;n"
            . "</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";

    $busq = $_POST["bus"];

    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);
    
            $consulta = "SELECT id_arriendo, OrdInhum, CONCAT(ced_cli, ' ', nom_cli) titular,  cemen, boveda, jardin, zona, lote, muerto, desde FROM contrato_arriendo  WHERE  ";
        


        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  ced_cli, "
                    . "  ' ', "
                    . "  OrdInhum, "
                    . "  ' ', "
                    . "  muerto, "
                    . "  ' ', "
                    . "  nom_cli "
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {
                
            } else {
                $consulta .= " AND ";
            }
        }
        $consulta .= " AND estado='ACTIVO' order by nom_cli ASC LIMIT " . $regemp . "," . $regmos;
    } else {
        
            $consulta = "SELECT id_arriendo, OrdInhum, CONCAT(ced_cli, ' ', nom_cli) titular,  cemen, boveda, jardin, zona, lote, muerto, desde FROM contrato_arriendo  WHERE estado='ACTIVO' order by nom_cli ASC  LIMIT " . $regemp . "," . $regmos;
        
    }
// echo $consulta;
    $ubicacion = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {


            $cad .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $fila["OrdInhum"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . acentos($fila["titular"]) . ""
                    . "</td>";
                    
                    if($fila["cemen"]=="JARDINES"){
                        $cad .= "<td class=\"highlight\">Jardin: ". $fila["jardin"] . ", Zona: ". $fila["zona"] . ", Lote: ". $fila["lote"] . "</td>";
                        $ubicacion = "Jardin: ". $fila["jardin"] . ", Zona: ". $fila["zona"] . ", Lote: ". $fila["lote"];
                    }else{
                        $cad .= "<td class=\"highlight\">Bóveda: ". $fila["boveda"] . "</td>";
                        $ubicacion = "Bóveda: ". $fila["boveda"];
                    }
                

                    $cad .= "<td class=\"highlight\">"
                    . acentos($fila["muerto"]) . ""
                    . "</td>"
                    . " <td class=\"highlight\">"
                    . "<a  onclick=\"$.SelContrato('" . $fila["id_arriendo"] . "//" .$fila["OrdInhum"] . "//" . $fila["cemen"] . "//" . acentos($fila["muerto"]) . "//" . $fila["desde"] ."//" . $ubicacion . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-check\"></i> Seleccionar</a>"
                    . "</td>"
                    . "</tr>";
        }
    }

    $myDat->tab_cli = $cad;
    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "ClientesExhumaciones") {

    $cad = "";
    $cad2 = "";
    $consulta = "";
    $contador = 0;
    $myDat = new stdClass();

    if ($_POST["tip"] == "Propio") {
        $consulta = "SELECT id_contr id,pedido_contr conse,cli.id_cli idcl,cli.sex_cli sex,"
                . "cli.fec_cli fec,cli.dir_cli dir,cli.tel_cli tel,cli.barrio barr, "
                . "cli.inde_cli iden,cli.nom_cli nom FROM contrato_venta contr "
                . "LEFT JOIN clientes cli ON contr.ident_vent=cli.inde_cli WHERE "
                . " cli.inde_cli='" . $_POST["cod"] . "' AND contr.estado='ACTIVO'";
    } else {
        $consulta = "SELECT id_arriendo id,OrdInhum conse,cli.id_cli idcl,"
                . "cli.sex_cli sex,cli.fec_cli fec,cli.dir_cli dir,cli.tel_cli tel,"
                . "cli.barrio barr, cli.inde_cli iden,cli.nom_cli nom FROM "
                . "contrato_arriendo contr LEFT JOIN clientes cli ON contr.ced_cli=cli.inde_cli WHERE"
                . " cli.inde_cli='" . $_POST["cod"] . "' AND  contr.estado='ACTIVO'";
    }
    //echo $consulta;
    $cliex = "SI";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $cliex = "NO";
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->id = $fila['id'];
            $myDat->conse = $fila['conse'];
            $myDat->iden = $fila['iden'];
            $myDat->nom = $fila['nom'];
            $myDat->dir = $fila['dir'];
            $myDat->tel = $fila['tel'];
        }
    }
    $myDat->cliex = $cliex;


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "ClientesInhuma") {

    $cad = "";
    $cad2 = "";
    $consulta = "";
    $contador = 0;
    $myDat = new stdClass();


    $consulta = "SELECT * FROM contrato_venta contv LEFT JOIN clientes cli ON "
            . "contv.ident_vent=cli.inde_cli WHERE cli.inde_cli='" . $_POST["cod"] . "' AND contv.estado='ACTIVO'";

    //echo $consulta;
    $cliex = "SI";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $cliex = "NO";
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->id = $fila['id_contr'];
            $myDat->conse = $fila['pedido_contr'];
            $myDat->iden = $fila['ident_vent'];
            $myDat->nom = $fila['nombre_venta'];
            $myDat->dir = $fila['dir_cli'];
            $myDat->tel = $fila['tel_cli'];
        }
    }
    $myDat->cliex = $cliex;


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "tabimg") {

    $tabImg = "";

    $consulta = "";

    $myDat = new stdClass();



    $tabImg = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Nombre"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Acci&oacute;n"
            . "</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";



    $consulta = "SELECT gal.id_galeria id,img.id_img idimg,gal.nombre nomgal, img.ruta rut FROM galerias gal LEFT JOIN "
            . "imagenes img ON gal.id_galeria=img.galeria WHERE gal.id_galeria='" . $_POST['cod'] . "'";



    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $nomgal = $fila["nomgal"];
            $idgal = $fila["id"];
            $tabImg .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $fila["rut"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "<a  onclick=\"$.VerImg('" . $nomgal . '/' . $fila["rut"] . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-search\"></i> Ver</a>"
                    . "<a  onclick=\"$.DelImg('" . $fila["idimg"] . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-trash-o\"></i> Borrar</a>"
                    . "</td>"
                    . "</tr>";
        }
    }


    $_SESSION['ses_nomgal'] = $nomgal;
    $_SESSION['ses_idgal'] = $idgal;
    $myDat->tabImg = $tabImg;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "tab_DetaOcupa") {


    $myDat = new stdClass();

    $tabOcup = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> #"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Nombre"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Fec. Inhumado"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Posición"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Observaci&oacute;n"
            . "</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";

    $consulta = "SELECT * FROM ocup_lot_osaid WHERE id_ocup='" . $_POST['ocup'] . "' AND tip='" . $_POST['tip'] . "'";


    $cont = 0;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;

            $idOcu = $fila["id"];
            $tabOcup .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $cont . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["nombr"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["fecha"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["posicion"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["obser"] . " "
                    . "</td>"
                    . "</tr>";
        }
    }



    $myDat->tabOcup = $tabOcup;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "tab_DetaLote") {

    $myDat = new stdClass();

/////////////TABLA LOTES///////////////////
    $contLote = 0;
    $CadLote = "<thead>
    <tr>
    <td>
        <i></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Ubicaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Tipo de Lote
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Precio
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Construcci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Observaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Ocupado
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Acci&oacute;n
    </td>
</tr>
</thead>
<tbody>";
    $consulta = "SELECT * FROM venta_deta_lote
              WHERE id_venta='" . $_POST["idc"] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $contLote++;
            $CadLote .= '<tr class="selected" id="filaLote' . $contLote . '" >';
            $CadLote .= "<td>" . $contLote . "</td>";
            $CadLote .= "<td>" . "Jardin:" . $fila["jardin_vent"] . " Zona:" . $fila["zona_vent"] . " Lote:" . $fila["lote_vent"] . "</td>";
            $CadLote .= "<td>" . $fila["tlote"] . "</td>";
            $CadLote .= "<td>$ " . number_format($fila["precio_vent"], 2, ",", ".") . "</td>";
            $CadLote .= "<td>" . $fila["costru_vent"] . "</td>";
            $CadLote .= "<td>" . $fila["obser_vent"] . "</td>";
            $CadLote .= "<td><a  onclick=\"$.OcupantesLote('" . $fila["id"] . "')\"> Ocupado</a></td>";
            $CadLote .= "<td><input type='hidden' id='Lotes" . $contLote . "' name='Lotes' value='" . $fila["jardin_vent"] . "//" . $fila["zona_vent"] . "//" . $fila["lote_vent"] . "//" . $fila["tlote"] . "//" . $fila["precio_vent"] . "//" . $fila["costru_vent"] . "//" . $fila["obser_vent"] . "//" . $fila["id"] . "' />"
                    . "<a onclick=\"$.QuitarLote('Lotes" . $contLote . "')\" class=\"btn default btn-xs red\">"
                    . "<i class=\"fa fa-trash-o\"></i> Borrar</a>"
                    . "<a onclick=\"$.EditarLote('Lotes" . $contLote . "')\" class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-edit\"></i> Editar</a></td></tr>";
        }
    }

    $CadLote .= "</tbody>";

    $myDat->CadLote = $CadLote;
    $myDat->contLote = $contLote;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "tab_DetaOsario") {

    $myDat = new stdClass();


/////////////TABLA OSARIOS///////////////////
    $contOsa = 0;
    $CadOsa = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Ubicaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Tipo de Osario
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Precio
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Construcci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Observaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Ocupado
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Acci&oacute;n
    </td>
</tr>
</thead>
<tbody >";
    $consulta = "SELECT * FROM venta_deta_osario
              WHERE id_venta='" . $_POST["idc"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $contOsa++;
            $CadOsa .= '<tr class="selected" id="filaOsario' . $contOsa . '" >';

            $CadOsa .= "<td>" . $contOsa . "</td>";
            $CadOsa .= "<td>" . "Jardin:" . $fila["jardin_vent"] . " Número:" . $fila["osario_vent"] . "</td>";
            $CadOsa .= "<td>" . $fila["tosario_vent"] . "</td>";
            $CadOsa .= "<td>$ " . number_format($fila["prec_vent"], 2, ",", ".") . "</td>";
            $CadOsa .= "<td>" . $fila["costr_vent"] . "</td>";
            $CadOsa .= "<td>" . $fila["obser_vent"] . "</td>";
            $CadOsa .= "<td><a  onclick=\"$.OcupantesOsa('" . $fila["id"] . "')\"> Ocupado</a></td>";
            $CadOsa .= "<td><input type='hidden' id='Osario" . $contOsa . "' name='Osario' value='" . $fila["jardin_vent"] . "//" . $fila["osario_vent"] . "//" . $fila["tosario_vent"] . "//" . $fila["prec_vent"] . "//" . $fila["costr_vent"] . "//" . $fila["obser_vent"] . "//" . $fila["id"] . "' />"
                    . "<a onclick=\"$.QuitarOsario('Osario" . $contOsa . "')\" class=\"btn default btn-xs red\">"
                    . "<i class=\"fa fa-trash-o\"></i> Borrar</a>"
                    . "<a onclick=\"$.EditarOsario('Osario" . $contOsa . "')\" class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-edit\"></i> Editar</a></td></tr>";
        }
    }

    $CadOsa .= "</tbody>";

    $myDat->CadOsa = $CadOsa;
    $myDat->contOsa = $contOsa;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "tab_anios") {

    $tabla_anios = "";
    $consulta = "";
    $myDat = new stdClass();

    $tabla_anios = "<thead>
                    <tr>
                        <td>
                            <i class='fa fa-angle-right'></i>Año
                        </td>

                        <td>
                            <i class='fa fa-angle-right'></i> Acci&oacute;n
                        </td>
                    </tr>
                </thead>
                <tbody >";



    $consulta = "SELECT * FROM anios_contrato WHERE contrato='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $idanio = $fila["id"];
            $tabla_anios .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $fila["anio"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "<a  onclick=\"$.VerDetPagos('" . $idanio . '//' . $fila["anio"] . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-search\"></i> Ver</a>"
                    . "<a  onclick=\"$.DelAnio('" . $idanio . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-trash-o\"></i> Borrar</a>"
                    . "</td>"
                    . "</tr>";
        }
    }

    $tabla_anios .= "</thead>";
    $myDat->tabla_anios = $tabla_anios;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "tab_aniosDeta") {

    $tabla_aniosDet = "";
    $consulta = "";
    $myDat = new stdClass();

    $tabla_aniosDet = "<table class=\"table table-bordered table-striped table-condensed flip-content\" role=\"grid\" ><thead>
                    <tr>
                    <td>
                        <i class='fa fa-angle-right'></i>Cuota
                    </td>
                    <td width=\"50\">
                        <i class='fa fa-angle-right'></i>Mes Pagado
                    </td>
                    <td>
                        <i class='fa fa-angle-right'></i>Fecha
                    </td>
                    <td>
                        <i class='fa fa-angle-right'></i>Recibo
                    </td>
                    <td>
                        <i class='fa fa-angle-right'></i>Valor
                    </td>
                    <td>
                        <i class='fa fa-angle-right'></i>Pago Hasta
                    </td>
                    <td>
                        <i class='fa fa-angle-right'></i>Saldo
                    </td>

                    <td>
                        <i class='fa fa-angle-right'></i> Acci&oacute;n
                    </td>
                </tr>
                </thead>
                <tbody >";


    $cont = 0;
    $consulta = "SELECT * FROM anios_detalles WHERE anio='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $idDet = $fila["id"];
            $cont++;
            $tabla_aniosDet .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $cont . " "
                    . "</td>"
                    . "<td style=\"width:50px;\">"
                    . $fila["mes"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["fpago"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "<a  onclick=\"$.MostrarRecibo('" . $fila["recibo"] . "/" . $idDet . "')\"> " . $fila["recibo"] . "</a>"
                    . "</td>"
                    . "<td class=\"highlight\">$ "
                    . number_format($fila["valor"], 2, ",", ".") . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["fvenc"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">$ "
                    . number_format($fila["saldo"], 2, ",", ".") . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "<a  onclick=\"$.EditDetPagos('" . $idDet . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-pencil-square-o\"></i> Editar</a>"
                    . "<a  onclick=\"$.DelDetPagos('" . $idDet . '/' . $fila["valor"] . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-trash-o\"></i> Borrar</a>"
                    . "</td>"
                    . "</tr>";
        }
    }
    $tabla_aniosDet .= "</tbody>"
            . "</table>";

    $consulta = "SELECT * FROM anios_contrato WHERE id='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->valor = $fila["valor"];
            $myDat->cuota = $fila["cuota"];
            $myDat->saldo = $fila["saldo"];
        }
    }
    $tabla_aniosDet .= "</tbody>"
            . "</table>";
    $myDat->tabla_aniosDet = $tabla_aniosDet;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "tab_aniosDetaEmpresa") {

    $tabla_aniosDet = "";
    $consulta = "";
    $myDat = new stdClass();

    $tabla_aniosDet = "<table class=\"table table-bordered table-striped table-condensed flip-content\" role=\"grid\" ><thead>
                    <tr>
                    <td>
                    <i class='fa fa-angle-right'></i>#
                </td>
                <td>
                    <i class='fa fa-angle-right'></i>Mes Pagado
                </td>
                <td>
                    <i class='fa fa-angle-right'></i>Fecha
                </td>
                <td>
                    <i class='fa fa-angle-right'></i>Recibo
                </td>
                <td>
                    <i class='fa fa-angle-right'></i>Valor
                </td>
                <td>
                    <i class='fa fa-angle-right'></i>Pago Hasta
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Acci&oacute;n
                </td>
                </tr>
                </thead>
                <tbody >";


    $cont = 0;
    $consulta = "SELECT	idcartera, mes_cartera, Valor_cartera, Recibo_cartera, Fecha_pago_cartera, "
            . "Fecha_vence_cartera FROM cartera "
            . "WHERE anio_cartera='" . $_POST["anio"] . "' AND idempresa_cartera='" . $_POST["empr"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $idCart = $fila["idcartera"];
            $cont++;
            $tabla_aniosDet .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $cont . " "
                    . "</td>"
                    . "<td style=\"width:50px;\">"
                    . $fila["mes_cartera"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["Fecha_pago_cartera"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "<a  onclick=\"$.MostrarRecibo('" . $fila["Recibo_cartera"] . "/" . $idCart . "')\"> " . $fila["Recibo_cartera"] . "</a>"
                    . "</td>"
                    . "<td class=\"highlight\">$ "
                    . number_format($fila["Valor_cartera"], 2, ",", ".") . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["Fecha_vence_cartera"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "<a  onclick=\"$.EditDetPagos('" . $idCart . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-pencil-square-o\"></i> Editar</a>"
                    . "<a  onclick=\"$.DelDetPagos('" . $idCart . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-trash-o\"></i> Borrar</a>"
                    . "</td>"
                    . "</tr>";
        }
    }
    $tabla_aniosDet .= "</tbody>"
            . "</table>";

    $consulta = "SELECT	SUM(valor_cartera) total FROM cartera WHERE anio_cartera='" . $_POST["anio"] . "' AND idempresa_cartera='" . $_POST["empr"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->valor = $fila["total"];
        }
    }
    $tabla_aniosDet .= "</tbody>"
            . "</table>";
    $myDat->tabla_aniosDet = $tabla_aniosDet;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "tab_Deta") {

    $tabla_Det = "";
    $consulta = "";
    $myDat = new stdClass();

    $tabla_Det = "<thead>
                    <tr>
                    <td>
                        <i class='fa fa-angle-right'></i>Cuota
                    </td>

                    <td>
                        <i class='fa fa-angle-right'></i>Fecha
                    </td>

                    <td>
                        <i class='fa fa-angle-right'></i>Valor
                    </td>
                    <td>
                        <i class='fa fa-angle-right'></i>Pago Hasta
                    </td>
                    <td>
                        <i class='fa fa-angle-right'></i>Saldo
                    </td>

                    <td>
                        <i class='fa fa-angle-right'></i> Acci&oacute;n
                    </td>
                </tr>
                </thead>
                <tbody >";


    $cont = 0;
    $consulta = "SELECT * FROM detalles_venta WHERE contrato='" . $_POST['vent'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $idDet = $fila["id"];
            $cont++;
            $tabla_Det .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $cont . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["fpago"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">$ "
                    . number_format($fila["valor"], 2, ",", ".") . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["fvenc"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">$ "
                    . number_format($fila["saldo"], 2, ",", ".") . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "<a  onclick=\"$.EditDetPagos('" . $idDet . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-pencil-square-o\"></i> Editar</a>"
                    . "<a  onclick=\"$.DelDetPagos('" . $idDet . '/' . $fila["valor"] . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-trash-o\"></i> Borrar</a>"
                    . "</td>"
                    . "</tr>";
        }
    }

    $consulta = "SELECT * FROM contrato_venta WHERE id_contr='" . $_POST['vent'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->saldo = $fila["saldo"];
        }
    }
    $tabla_Det .= "</thead>";
    $myDat->tabla_aniosDet = $tabla_Det;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "VerDetallePago") {

    $consulta = "";
    $myDat = new stdClass();

    $consulta = "SELECT * FROM anios_detalles WHERE id='" . $_POST['cod'] . "' and anio='" . $_POST['ida'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->fpago = $fila["fpago"];

            $myDat->mes = $fila["mes"];
            $myDat->fvenc = $fila["fvenc"];
            $myDat->recibo = $fila["recibo"];
            $myDat->observ = acentos($fila["observ"]);
            $myDat->saldo = $fila["saldo"];
            $myDat->pagoen = $fila["pagoen"];
            $myDat->valor = $fila["valor"];
        }
    }

    $consulta = "SELECT cobrador,val_mes FROM contrato_prevision WHERE id_contr='" . $_POST['idp'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cobrador = acentos($fila["cobrador"]);
        }
    }


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "VerDetallePagoEmpre") {

    $consulta = "";
    $myDat = new stdClass();

    $consulta = "SELECT * FROM cartera WHERE idCartera='" . $_POST['cod'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {

            $myDat->mes = $fila["mes_cartera"];
            $myDat->val = $fila["Valor_cartera"];
            $myDat->fpag = $fila["Fecha_pago_cartera"];
            $myDat->fven = $fila["Fecha_vence_cartera"];
            $myDat->recibo = $fila["Recibo_cartera"];
            $myDat->observ = acentos($fila["observ_cartera"]);
            $myDat->pagoen = $fila["pagoen_cartera"];
            $myDat->ncobrador = $fila["ncobrador_cartera"];
        }
    }


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "CargaDatAfilNot") {

    $consulta = "";
    $myDat = new stdClass();

    $consulta = "SELECT * FROM cliente WHERE idCliente='" . $_POST['idaf'] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->Nombres_cliente = $fila["Nombres_cliente"];
            $myDat->Apellidos_cliente = $fila["Apellidos_cliente"];
            $myDat->Cedula_cliente = $fila["Cedula_cliente"];
            $myDat->contrato_cliente = $fila["contrato_cliente"];
            $myDat->correo_cliente = $fila["correo_cliente"];
        }
    }


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "VerDetalleRecibo") {
    $cod = explode("/", $_POST["cod"]);
    $consulta = "";
    $myDat = new stdClass();

    $consulta = "SELECT * FROM recibos WHERE conse='" . $cod[0] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->id = $fila["id"];
            $myDat->fecha = $fila["fecha"];
            $myDat->valor = $fila["valor"];
            $myDat->iden = $fila["iden"];
            $myDat->nombre = $fila["nombre"];
            $myDat->valletra = $fila["valletra"];
            $myDat->concepto = $fila["concepto"];
            $myDat->cuotames = $fila["cuotames"];
            $myDat->fpago = $fila["fpago"];
            $myDat->ncheque = $fila["ncheque"];
            $myDat->nbanco = $fila["nbanco"];
        }
    }

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "VentNece") {

    $cad = "";
    $cad2 = "";
    $consulta = "";
    $contador = 0;
    $myDat = new stdClass();
    $i = 0;
    $j = 0;

    $regmos = 7;

    $buscar = array();

    $regemp = 0;
    $pagact = 1;
    $pag = "1";
    if ($pag != null) {
        $regemp = (intval($pag) - 1) * $regmos;

        $pagact = intval($pag);
    }
    $cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> C&oacute;digo"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Descripci&oacute;n"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Valor"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Acci&oacute;n"
            . "</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";

    $busq = $_POST["bus"];

    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT * FROM  servicios  WHERE ";

        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  cod_serv, "
                    . "  ' ', "
                    . "  desc_serv "
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {
                
            } else {
                $consulta .= " AND ";
            }
        }
        $consulta .= " order by desc_serv ASC LIMIT " . $regemp . "," . $regmos;
    } else {

        $consulta = "SELECT * FROM servicios order by desc_serv ASC  LIMIT " . $regemp . "," . $regmos;
    }

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {


            $cad .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $fila["cod_serv"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["desc_serv"] . ""
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "$ " . number_format($fila["val_serv"], 2, ",", ".") . ""
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . "<a  onclick=\"$.SelNece('" . $fila["id_serv"] . "//" . $fila["desc_serv"] . "//$ " . number_format($fila["val_serv"], 2, ",", ".") . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-check\"></i> Seleccionar</a>"
                    . "</td>"
                    . "</tr>";
        }
    }

    $myDat->tab_nece = $cad;
    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "CargaTodDatos") {

    $myDat = new stdClass();


//Cargar  funeraria
    $fune = "";
    $igle = "";
    $ceme = "";
    $nece = "<option value=' '>Select</option>";

    $consulta = "SELECT * FROM funerarias";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $fune .= "<option value='" . $fila["id_fune"] . "'>" . $fila["nit"] . ' - ' . $fila["nom_fune"] . "</option>";
        }
        $myDat->fune = $fune;
    }



//Cargar  iglesia

    $consulta = "SELECT * FROM iglesias";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $igle .= "<option value='" . $fila["id_igle"] . "'>" . $fila["nom_igle"] . "</option>";
        }
        $myDat->igle = $igle;
    }

//Cargar  cementerios

    $consulta = "SELECT * FROM cementerios";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $ceme .= "<option value='" . $fila["id_cem"] . "'>" . $fila["nom_cem"] . "</option>";
        }
        $myDat->ceme = $ceme;
    }

//Cargar  necesidades

    $consulta = "SELECT * FROM servicios";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $nece .= "<option value='" . $fila["id_serv"] . '//' . $fila["desc_serv"] . '//$ ' . number_format($fila["val_serv"], 2, ",", ".") . "'>" . acentos($fila["desc_serv"]) . " -- $ " . number_format($fila["val_serv"], 2, ",", ".") . "</option>";
        }
        $myDat->nece = $nece;
    }


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "CargaTodDatosPlanes") {

    $myDat = new stdClass();

    $planes = "";
//Cargar  funeraria

    $consulta = "SELECT idPlan,UPPER(Nombre_plan) npla FROM plan";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $planes .= "<option value='" . $fila["idPlan"] . "'>" . $fila["npla"] . "</option>";
        }
        $myDat->planes = $planes;
    }


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "CargaEmpresas") {

    $myDat = new stdClass();


//Cargar  funeraria

    $consulta = "SELECT idEmpresa,Nombre_empresa FROM empresa";
    $empresa = "";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $empresa .= "<option value='" . $fila["idEmpresa"] . "'>" . $fila["Nombre_empresa"] . "</option>";
        }
        $myDat->empre = $empresa;
    }


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "UpdateFune") {

    $myDat = new stdClass();
    $fune = "";

//Cargar  funeraria

    $consulta = "SELECT * FROM funerarias";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $fune .= "<option value='" . $fila["id_fune"] . "'>" . $fila["nit"] . ' - ' . $fila["nom_fune"] . "</option>";
        }
        $myDat->fune = $fune;
    }


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "UpdateCeme") {

    $myDat = new stdClass();
    $ceme = "";

//Cargar  funeraria

    $consulta = "SELECT * FROM cementerios";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $ceme .= "<option value='" . $fila["id_cem"] . "'>" . $fila["nom_cem"] . "</option>";
        }
        $myDat->ceme = $ceme;
    }


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "UpdateIgle") {

    $myDat = new stdClass();
    $igle = "";

//Cargar  funeraria

    $consulta = "SELECT * FROM iglesias";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $igle .= "<option value='" . $fila["id_igle"] . "'>" . $fila["nom_igle"] . "</option>";
        }
        $myDat->igle = $igle;
    }


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "cargubiVenta") {

    $myDat = new stdClass();

    $ubi = "";
//Cargar  funeraria

    $consulta = "SELECT CONCAT(id,'-','lote') idlo, CONCAT('JARDIN: ',jardin_vent,' ZONA: ', zona_vent, ' LOTE: ', tlote,' ',lote_vent) ubi FROM venta_deta_lote WHERE id_venta='" . $_POST["cod"] . "'
UNION ALL
SELECT CONCAT(id,'-','osa') idlo, CONCAT('JARDIN: ',jardin_vent,' OSARIO. ',tosario_vent,' No.',osario_vent) ubi FROM venta_deta_osario WHERE id_venta='" . $_POST["cod"] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $ubi .= "<option value='" . $fila["idlo"] . "'>" . $fila["ubi"] . "</option>";
        }
        $myDat->ubi = $ubi;
    }


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "cargubiExhumacion") {

    $myDat = new stdClass();
    $ubi = "";

//Cargar  funeraria
    if ($_POST["tpr"] == "Propio") {
        $consulta = "SELECT CONCAT(id,'-','lote') idlo, CONCAT('JARDIN: ',jardin_vent,' ZONA: ', zona_vent, ' LOTE: ', tlote,' ',lote_vent) ubi FROM venta_deta_lote WHERE id_venta='" . $_POST["cod"] . "'
UNION ALL
SELECT CONCAT(id,'-','osa') idlo, CONCAT('JARDIN: ',jardin_vent,' OSARIO. ',tosario_vent,' No.',osario_vent) ubi FROM venta_deta_osario WHERE id_venta='" . $_POST["cod"] . "'";
    } else {
        $consulta = "SELECT CONCAT(id_arriendo,'-',cemen) idlo, CASE WHEN cemen='NUEVO' THEN CONCAT('BOVEDA: ',boveda) ELSE CONCAT('JARDIN: ',jardin,' ZONA: ',zona,' LOTE: ',lote) END ubi  FROM contrato_arriendo WHERE id_arriendo='" . $_POST["cod"] . "'";
    }

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $ubi .= "<option value='" . $fila["idlo"] . "'>" . $fila["ubi"] . "</option>";
        }
        $myDat->ubi = $ubi;
    }


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "busDatCli") {

    $myDat = new stdClass();


//Cargar  funeraria
    $cliex = "SI";
    $consulta = "SELECT * FROM clientes WHERE inde_cli='" . $_POST["cod"] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $cliex = "NO";
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->id_cli = $fila["id_cli"];
            $myDat->nom_cli = $fila["nom_cli"];
            $myDat->sex_cli = $fila["sex_cli"];
            $myDat->fec_cli = $fila["fec_cli"];
            $myDat->dir_cli = $fila["dir_cli"];
            $myDat->tel_cli = $fila["tel_cli"];
            $myDat->email_cli = $fila["email_cli"];
            $myDat->barrio = $fila["barrio"];
        }
    } else {
        $cliex = "SI";
    }
    $myDat->cliex = $cliex;

    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST["ope"] == "ConConsecutivo") {

    $myDat = new stdClass();
    $StrAct = "";
    $est = "";
    $act = 0;
    $dig = "";
    $cons = 0;
    $vig = "";

    $consulta = "SELECT * FROM consecutivos WHERE grupo='" . $_POST["tco"] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $est = $fila["estruct"];
            $act = $fila["inicio"];
            $cons = $fila["actual"];
            $vig = $fila["vigencia"];
            $dig = $fila["digitos"];
        }
    }


    if ($act > $cons) {
        $cons = $act;
    }
    $cons += 1;

    if ($vig == "SI") {
        $StrAct = $est . "-" . date('Y') . "-" . sprintf("%0" . $dig . "d", $cons);
    } else {
        $StrAct = $est . "-" . sprintf("%0" . $dig . "d", $cons);
    }
    $myDat->StrAct = $StrAct;
    $myDat->cons = $cons;


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusqEdperfil") {

    $myDat = new stdClass();

//Cargar  cementerios

    $consulta = "SELECT * FROM perfiles where idperfil='" . $_POST["cod"] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->nomperfil = $fila["nomperfil"];
            $myDat->ggesserv = $fila["ggesserv"];
            $myDat->gesser1 = $fila["gesser1"];
            $myDat->gesser2 = $fila["gesser2"];
            $myDat->gesser3 = $fila["gesser3"];
            $myDat->gesser4 = $fila["gesser4"];
            $myDat->gesser5 = $fila["gesser5"];
            $myDat->gesConsRetra = $fila["gesConsRetra"];
            $myDat->gopgen = $fila["gopgen"];
            $myDat->gopgen1 = $fila["gopgen1"];
            $myDat->gopgen2 = $fila["gopgen2"];
            $myDat->gpargen = $fila["gpargen"];
            $myDat->gpargen1 = $fila["gpargen1"];
            $myDat->gpargen2 = $fila["gpargen2"];
            $myDat->gpargen3 = $fila["gpargen3"];
            $myDat->gpargen4 = $fila["gpargen4"];
            $myDat->gpargen5 = $fila["gpargen5"];
            $myDat->gpargen6 = $fila["gpargen6"];
            $myDat->gpargen7 = $fila["gpargen7"];
            $myDat->ggestUsu = $fila["ggestUsu"];
            $myDat->gestUsu1 = $fila["gestUsu1"];
            $myDat->gestUsu2 = $fila["gestUsu2"];
            $myDat->gesAudi = $fila["gesAudi"];
            $myDat->gesFact = $fila["gesFact"];
            $myDat->gesCons = $fila["gesCons"];
            $myDat->gesReci = $fila["gesReci"];
        }
    }


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusqEditRequis") {

    $myDat = new stdClass();

//Cargar  cementerios

    $consulta = "SELECT * FROM requisiciones req LEFT JOIN clientes cli ON req.ced_contra=cli.inde_cli where id_req='" . $_POST["cod"] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cod_req = $fila["cod_req"];
            $myDat->fech_req = $fila["fech_req"];
            $myDat->ciu_req = acentos($fila["ciu_req"]);
            $myDat->funau_req = acentos($fila["funau_req"]);
            $myDat->naut_req = $fila["naut_req"];
            $myDat->nompad_req = acentos($fila["nompad_req"]);
            $myDat->nommad_req = acentos($fila["nommad_req"]);
            $myDat->idcont_req = $fila["idcont_req"];
            $myDat->inde_cli = $fila["inde_cli"];
            $myDat->nom_cli = acentos($fila["nom_cli"]);
            $myDat->sex_cli = $fila["sex_cli"];
            $myDat->fec_cli = $fila["fec_cli"];
            $myDat->dir_cli = acentos($fila["dir_cli"]);
            $myDat->email_cli = $fila["email_cli"];
            $myDat->barrio = acentos($fila["barrio"]);
            $myDat->tel_cli = $fila["tel_cli"];
            $myDat->idfall_req = $fila["idfall_req"];
            $myDat->nomfall_req = acentos($fila["nomfall_req"]);
            $myDat->sexfall_req = $fila["sexfall_req"];
            $myDat->fecnfall_req = $fila["fecnfall_req"];
            $myDat->fotfall_req = $fila["fotfall_req"];
            $myDat->fecve_req = $fila["fecve_req"] . " - " . $fila["horve_req"];
            $myDat->salve_req = $fila["salve_req"];
            $myDat->fecexe_req = $fila["fecexe_req"] . " - " . $fila["horexe_req"];
            $myDat->igle_req = acentos($fila["igle_req"]);
            $myDat->ceme_req = acentos($fila["ceme_req"]);
            $myDat->obse_req = acentos($fila["obse_req"]);
            $myDat->velcasa = $fila["velcasa"];
        }
    }
    $cont = 0;
    $totalg = 0;
    $CadNec = "<thead>
    <tr>
        <td>
            <i class='fa fa-angle-right'></i> #
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Necesidad
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Observaci&oacute;n
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Cantidad
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Valor
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Total
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Acci&oacute;n
        </td>
    </tr>
</thead>
<tbody >";
    $consulta = "SELECT
                ser.id_serv idser,
                ser.desc_serv descr,
                nec.obs obs,
                nec.cant cant,
                nec.val val
              FROM
                requi_servicios nec
                LEFT JOIN servicios ser
                  ON nec.nece = ser.id_serv
              WHERE nec.id_req='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $total = $fila["val"] * $fila["cant"];
            $totalg = $totalg + $total;
            $CadNec .= '<tr class="selected" id="filaNece' . $cont . '" >';

            $CadNec .= "<td>" . $cont . "</td>";
            $CadNec .= "<td>" . acentos($fila["descr"]) . "</td>";
            $CadNec .= "<td>" . acentos($fila["obs"]) . "</td>";
            $CadNec .= "<td>" . $fila["cant"] . "</td>";
            $CadNec .= "<td>$ " . number_format($fila["val"], 2, ",", ".") . "</td>";
            $CadNec .= "<td>$ " . number_format($total, 2, ",", ".") . "</td>";
            $CadNec .= "<td><input type='hidden' id='Neces" . $cont . "' name='Neces' value='" . $fila["idser"] . "//" . $fila["cant"] . "//" . $fila["val"] . "//" . acentos($fila["obs"]) . "//" . acentos($fila["descr"]) . "' /><a onclick=\"$.QuitarNeces('filaNece" . $cont . "'," . $total . ")\" class=\"btn default btn-xs red\">"
                    . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }

    $CadNec .= "</tbody><tfoot>
    <tr>
        <th colspan='5' style='text-align: right;'>Total:</th>
        <th colspan='2'><label id='gtotal' style='font-weight: bold;'>$ " . number_format($totalg, 2, ",", ".") . "</label></th>
    </tr>
  </tfoot>";

    $myDat->CadNec = $CadNec;
    $myDat->cont = $cont;
    $myDat->totalg = $totalg;
    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusqEdiInhum") {

    $myDat = new stdClass();

//Cargar  cementerios

    $consulta = "SELECT
  inh.conse conse,
  inh.fecha fec,
  inh.ciudad ciu,
  inh.falle fall,
  inh.fec_falle ffall,
  inh.fec_naci fnac,
  inh.fec_cere fcer,
  inh.funeraria fun,
  inh.jefe_ceme jef,
  inh.ubic ubic,
  IFNULL(ocup.id_vent, '') idv,
  CONCAT(ocup.id_ocup,'-',ocup.tip) ido,
  ocup.posicion posi,
  cli.inde_cli cedcli,
  cli.nom_cli nomcli,
  CONCAT(cli.dir_cli,' ',cli.barrio) dir,
  cli.tel_cli tel,
  inh.ubic ub,
  inh.obser obs,
  inh.cementerio cem
FROM
  inhumaciones inh
  LEFT JOIN clientes cli
    ON inh.titular = cli.inde_cli
  LEFT JOIN ocup_lot_osaid ocup
    ON inh.id=ocup.id_inhum where inh.id='" . $_POST["cod"] . "'";
// echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->conse = $fila["conse"];
            $myDat->fec = $fila["fec"];
            $myDat->ciu = $fila["ciu"];
            $myDat->fall = acentos($fila["fall"]);
            $myDat->ffall = $fila["ffall"];
            $myDat->fnac = $fila["fnac"];
            $myDat->fcer = $fila["fcer"];
            $myDat->fun = acentos($fila["fun"]);
            $myDat->jef = acentos($fila["jef"]);
            $myDat->idv = $fila["idv"];
            $myDat->ubic = $fila["ubic"];
            $myDat->ido = $fila["ido"];
            $myDat->posi = $fila["posi"];
            $myDat->cedcli = $fila["cedcli"];
            $myDat->nomcli = acentos($fila["nomcli"]);
            $myDat->dir = acentos($fila["dir"]);
            $myDat->tel = $fila["tel"];
            $myDat->obs = acentos($fila["obs"]);
            $myDat->cem = $fila["cem"];
        }
    }

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusqEditCesCon") {

    $myDat = new stdClass();

//Cargar  cementerios

    $consulta = "SELECT
  ces.id id,
  ces.fecha fec,
  cli1.inde_cli identit,
  cli1.nom_cli nomtit,
  CONCAT(cli1.dir_cli,' ',cli1.barrio) dirtit,
  cli1.tel_cli telcli,
  cli2.inde_cli indecesi,
  cli2.nom_cli nomcesi,
  cli2.dir_cli dircesi,
  cli2.barrio barr,
  cli2.tel_cli telcesi,
  CONCAT(ces.idubi,'-',tubi) ubi,
  ces.textubica textub,
  ces.documento doc,
  ces.ttraspado tras,
  ces.nota nota,
  ces.contrato contrato,
  ces.ntitprop ntitprop
FROM
  cesioncontrato ces
  LEFT JOIN clientes cli1
    ON ces.titular = cli1.inde_cli
  LEFT JOIN clientes cli2
    ON ces.cesionario = cli2.inde_cli
 where id='" . $_POST["cod"] . "'";
//echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->fec = $fila["fec"];
            $myDat->identit = $fila["identit"];
            $myDat->nomtit = acentos($fila["nomtit"]);
            $myDat->dirtit = acentos($fila["dirtit"]);
            $myDat->telcli = $fila["telcli"];
            $myDat->indecesi = $fila["indecesi"];
            $myDat->nomcesi = acentos($fila["nomcesi"]);
            $myDat->dircesi = acentos($fila["dircesi"]);
            $myDat->barr = acentos($fila["barr"]);
            $myDat->telcesi = $fila["telcesi"];
            $myDat->ubi = $fila["ubi"];
            $myDat->textub = $fila["textub"];
            $myDat->doc = $fila["doc"];
            $myDat->tras = $fila["tras"];
            $myDat->nota = acentos($fila["nota"]);
            $myDat->contrato = $fila["contrato"];
            $myDat->ntitprop = $fila["ntitprop"];
        }
    }


    /////////////TABLA PERSONAS///////////////////
    $cont = 0;
    $CadPers = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Identificaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Nombre
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Tel&eacute;fono
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Acci&oacute;n
    </td>
</tr>
</thead>
<tbody >";
    $consulta = "SELECT * FROM personas_contrato_cesion  WHERE idcontr_cesion='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $CadPers .= '<tr class="selected" id="filaPers' . $cont . '" >';

            $CadPers .= "<td>" . $cont . "</td>";
            $CadPers .= "<td>" . $fila["iden_persocont"] . "</td>";
            $CadPers .= "<td>" . acentos($fila["nom_persocont"]) . "</td>";
            $CadPers .= "<td>" . $fila["tel_persocont"] . "</td>";
            $CadPers .= "<td><input type='hidden' id='Perso" . $cont . "' name='Perso' value='" . $fila["iden_persocont"] . "//" . acentos($fila["nom_persocont"]) . "//" . $fila["tel_persocont"] . "' /><a onclick=\"$.QuitarPerso('filaPers" . $cont . "')\" class=\"btn default btn-xs red\">"
                    . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }

    $CadPers .= "</tbody>";

    $myDat->CadPers = $CadPers;
    $myDat->cont = $cont;


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusqEditExhu") {

    $myDat = new stdClass();

//Cargar  cementerios

    $consulta = "SELECT
  inh.conse conse,
  inh.fecha fec,
  inh.ciudad ciu,
  inh.muerto fall,
  inh.tprop tprop,
  IFNULL(inh.idcont, '') idcont,
  CONCAT(inh.idubi,'-',inh.tip) ido,
  inh.posi posi,
  inh.tip tip,
  inh.ubi ubi,
  inh.obser obser,
  inh.fechexhu fechexhu,
  inh.autori autori,
  inh.fecinhuma fecinhuma,
  inh.observa observa,
  inh.txt_Trasla txt_Trasla,
  inh.tel_aut tel_aut,
  inh.dir_aut dir_aut,
  inh.cementerio cementerio,
  inh.jefe jefe,
  cli.inde_cli cedcli,
  cli.nom_cli nomcli,
  CONCAT(cli.dir_cli,' ',cli.barrio) dir,
  cli.tel_cli tel
FROM
  exhumaciones inh
  LEFT JOIN clientes cli
    ON inh.titular = cli.inde_cli
 where inh.id='" . $_POST["cod"] . "'";
//echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->conse = $fila["conse"];
            $myDat->fec = $fila["fec"];
            $myDat->ciu = $fila["ciu"];
            $myDat->fall = acentos($fila["fall"]);
            $myDat->tprop = $fila["tprop"];
            $myDat->idcont = $fila["idcont"];
            $myDat->ido = $fila["ido"];
            $myDat->posi = $fila["posi"];
            $myDat->fechexhu = $fila["fechexhu"];
            $myDat->autori = $fila["autori"];
            $myDat->fecinhuma = $fila["fecinhuma"];
            $myDat->observa = acentos($fila["observa"]);
            $myDat->jefe = acentos($fila["jefe"]);
            $myDat->cement = $fila["cementerio"];
            $myDat->cedcli = $fila["cedcli"];
            $myDat->nomcli = acentos($fila["nomcli"]);
            $myDat->dir = acentos($fila["dir"]);
            $myDat->tel = $fila["tel"];
            $myDat->obser = acentos($fila["obser"]);
            $myDat->ubic = $fila["ubi"];
            $myDat->txt_Trasla = acentos($fila["txt_Trasla"]);
            $myDat->tel_aut = $fila["tel_aut"];
            $myDat->dir_aut = acentos($fila["dir_aut"]);
        }
    }

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusqEditConstancia") {

    $myDat = new stdClass();

//Cargar  cementerios

    $consulta = "SELECT * FROM constancias costan LEFT JOIN clientes cli ON costan.iden_constan=cli.inde_cli where id_constan='" . $_POST["cod"] . "'";
//echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->cons_constan = $fila["cons_constan"];
            $myDat->fec_cre = $fila["fec_cre"];
            $myDat->fec_cons = $fila["fec_cons"];
            $myDat->ciudad = acentos($fila["ciudad"]);
            $myDat->iden_constan = $fila["iden_constan"];
            $myDat->inde_cli = $fila["inde_cli"];
            $myDat->nom_cli = acentos($fila["nom_cli"]);
            $myDat->dir_cli = acentos($fila["dir_cli"]);
            $myDat->tel_cli = $fila["tel_cli"];
            $myDat->consig_constan = $fila["consig_constan"];
            $myDat->valor = $fila["valor"];
        }
    }
    $cont = 0;
    $totalg = 0;
    $CadNec = "<thead>
    <tr>
        <td>
            <i class='fa fa-angle-right'></i> #
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Concepto
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Observaci&oacute;n
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Cantidad
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Valor
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Total
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Acci&oacute;n
        </td>
    </tr>
</thead>
<tbody >";
    $consulta = "SELECT
                ser.id_serv idser,
                ser.desc_serv descr,
                concep.obs obs,
                concep.cant cant,
                concep.val val
              FROM
                concep_constancias concep
                LEFT JOIN servicios ser
                  ON concep.concep = ser.id_serv
              WHERE concep.conse_cons='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $total = $fila["val"] * $fila["cant"];
            $totalg = $totalg + $total;
            $CadNec .= '<tr class="selected" id="filaNece' . $cont . '" >';

            $CadNec .= "<td>" . $cont . "</td>";
            $CadNec .= "<td>" . acentos($fila["descr"]) . "</td>";
            $CadNec .= "<td>" . acentos($fila["obs"]) . "</td>";
            $CadNec .= "<td>" . $fila["cant"] . "</td>";
            $CadNec .= "<td>$ " . number_format($fila["val"], 2, ",", ".") . "</td>";
            $CadNec .= "<td>$ " . number_format($total, 2, ",", ".") . "</td>";
            $CadNec .= "<td><input type='hidden' id='Neces" . $cont . "' name='Neces' value='" . $fila["idser"] . "//" . $fila["cant"] . "//" . $fila["val"] . "//" . $fila["obs"] . "' /><a onclick=\"$.QuitarNeces('filaNece" . $cont . "'," . $total . ")\" class=\"btn default btn-xs red\">"
                    . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }

    $CadNec .= "</tbody><tfoot>
    <tr>
        <th colspan='5' style='text-align: right;'>Total:</th>
        <th colspan='2'><label id='gtotal' style='font-weight: bold;'>$ " . number_format($totalg, 2, ",", ".") . "</label></th>
    </tr>
  </tfoot>";

    $myDat->CadNec = $CadNec;
    $myDat->cont = $cont;
    $myDat->totalg = $totalg;
    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusqEditPrev") {

    $myDat = new stdClass();

    $consulta = "SELECT * FROM contrato_prevision previ LEFT JOIN clientes cli ON previ.id_titu=cli.inde_cli where previ.id_contr='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->ncontrato = $fila["ncontrato"];
            $myDat->fecha_cre = $fila["fecha_cre"];
            $myDat->ciudad = $fila["ciudad"];
            $myDat->plan = $fila["plan"];
            $myDat->tipo_vinc = $fila["tipo_vinc"];
            $myDat->empresa = acentos($fila["empresa"]);
            $myDat->id_titu = $fila["id_titu"];
            $myDat->nomb_titu = acentos($fila["nomb_titu"]);
            $myDat->tipo_cli = $fila["tipo_cli"];
            $myDat->sex_cli = $fila["sex_cli"];
            $myDat->fec_cli = $fila["fec_cli"];
            $myDat->dir_cli = acentos($fila["dir_cli"]);
            $myDat->tel_cli = $fila["tel_cli"];
            $myDat->dir_recau = acentos($fila["dir_recau"]);
            $myDat->otr_dir = acentos($fila["otr_dir"]);
            $myDat->id_emple = $fila["id_emple"];
            $myDat->nom_emple = acentos($fila["nom_emple"]);
            $myDat->dir_emple = acentos($fila["dir_emple"]);
            $myDat->ciud_emple = $fila["ciud_emple"];
            $myDat->depar_emple = $fila["depar_emple"];
            $myDat->tel_emple = $fila["tel_emple"];
            $myDat->val_anual = number_format($fila["val_anual"], 2, ",", ".");
            $myDat->val_mes = number_format($fila["val_mes"], 2, ",", ".");
            $myDat->form_pago = $fila["form_pago"];
            $myDat->fech_ini = $fila["fech_ini"];
            $myDat->asesor = acentos($fila["asesor"]);
            $myDat->barrio = acentos($fila["barrio"]);
//            $myDat->cobrador = acentos($fila["cobrador"]);
            $myDat->observ = acentos($fila["observ"]);
        }
    }
    $contGrupBas = 0;
    $CadGrupBas = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Identificaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Apellido y Nombres
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Parentesco
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Estado Salud
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Sexo
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Edad
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Ciudad
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Acci&oacute;n
    </td>
</tr>
</thead>
<tbody >";
    $consulta = "SELECT * FROM grupo_fambasico WHERE id_cont='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $contGrupBas++;

            $CadGrupBas .= '<tr class="selected" id="filaGruBas' . $contGrupBas . '" >';

            $CadGrupBas .= "<td>" . $contGrupBas . "</td>";
            $CadGrupBas .= "<td>" . $fila["ident"] . "</td>";
            $CadGrupBas .= "<td>" . acentos($fila["nombre"]) . "</td>";
            $CadGrupBas .= "<td>" . acentos($fila["parent"]) . "</td>";
            $CadGrupBas .= "<td>" . $fila["estad"] . "</td>";
            $CadGrupBas .= "<td>" . $fila["sexo"] . "</td>";
            $CadGrupBas .= "<td>" . $fila["edad"] . "</td>";
            $CadGrupBas .= "<td>" . acentos($fila["ciudad"]) . "</td>";
            $CadGrupBas .= "<td><input type='hidden' id='GrupBas" . $contGrupBas . "' name='GrupBas' value='" . $fila["ident"] . "//" . acentos($fila["nombre"]) . "//" . $fila["parent"] . "//" . $fila["estad"] . "//" . $fila["sexo"] . "//" . $fila["edad"] . "//" . $fila["ciudad"] . "' />"
                    . "<a onclick=\"$.QuitarGrupBas('filaGruBas" . $contGrupBas . "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>"
                    . "<a onclick=\"$.EditGrupBas('filaGruBas" . $contGrupBas . "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-edit\"></i> Editar</a>"
                    . "</td></tr>";
        }
    }

    $CadGrupBas .= "</tbody>";

    $myDat->CadGrupBas = $CadGrupBas;
    $myDat->contGrupBas = $contGrupBas;


    $contGrupSec = 0;
    $CadGrupSec = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Identificaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Apellido y Nombres
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Parentesco
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Estado Salud
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Sexo
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Edad
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Ciudad
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Acci&oacute;n
    </td>
</tr>
</thead>
<tbody >";
    $consulta = "SELECT * FROM grupo_famsecundario WHERE id_cont='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $contGrupSec++;

            $CadGrupSec .= '<tr class="selected" id="filaGruSec' . $contGrupSec . '" >';

            $CadGrupSec .= "<td>" . $contGrupBas . "</td>";
            $CadGrupSec .= "<td>" . $fila["ident"] . "</td>";
            $CadGrupSec .= "<td>" . acentos($fila["nombre"]) . "</td>";
            $CadGrupSec .= "<td>" . acentos($fila["parent"]) . "</td>";
            $CadGrupSec .= "<td>" . $fila["estad"] . "</td>";
            $CadGrupSec .= "<td>" . $fila["sexo"] . "</td>";
            $CadGrupSec .= "<td>" . $fila["edad"] . "</td>";
            $CadGrupSec .= "<td>" . acentos($fila["ciudad"]) . "</td>";
            $CadGrupSec .= "<td><input type='hidden' id='GrupSec" . $contGrupSec . "' name='GrupSec' value='" . $fila["ident"] . "//" . acentos($fila["nombre"]) . "//" . $fila["parent"] . "//" . $fila["estad"] . "//" . $fila["sexo"] . "//" . $fila["edad"] . "//" . $fila["ciudad"] . "' />"
                    . "<a onclick=\"$.QuitarGrupSec('filaGruSec" . $contGrupSec . "')\" class=\"btn default btn-xs red\"><i class=\"fa fa-trash-o\"></i> Borrar</a>"
                    . "<a onclick=\"$.EditGrupSec('filaGruSec" . $contGrupSec . "')\" class=\"btn default btn-xs blue\"><i class=\"fa fa-edit\"></i> Editar</a>"
                    . "</td></tr>";
        }
    }

    $CadGrupSec .= "</tbody>";

    $myDat->CadGrupSec = $CadGrupSec;
    $myDat->contGrupSec = $contGrupSec;



////ANEXOS

    $consulta = "SELECT * FROM\n" .
            "  previ_anexos  \n" .
            "WHERE id_prev = '" . $_POST["cod"] . "' ";
//    echo $consulta;
    $resultado1 = mysqli_query($link, $consulta);

    $Tab_Anexos = "<thead>\n" .
            "      <tr>\n" .
            "          <td>\n" .
            "              <i class='fa fa-angle-right'></i> #\n" .
            "          </td>\n" .
            "          <td>\n" .
            "              <i class='fa fa-angle-right'></i> Descripci&oacute;n\n" .
            "          </td>\n" .
            "          <td>\n" .
            "              <i class='fa fa-angle-right'></i> Nombre Del Archivo\n" .
            "          </td>\n" .
            "          <td>\n" .
            "              <i class='fa fa-angle-right'></i> Acci&oacute;n\n" .
            "          </td>\n" .
            "      </tr>\n" .
            "  </thead>"
            . "   <tbody >\n";

    $contAnexos = 0;

    if (mysqli_num_rows($resultado1) > 0) {
        while ($fila = mysqli_fetch_array($resultado1)) {
            $contAnexos++;
            $Tab_Anexos .= "<tr class='selected' id='filaAnexo" . $contAnexos . "' ><td>" . $contAnexos . "</td>";
            $Tab_Anexos .= "<td>" . $fila["descr"] . "</td>";
            $Tab_Anexos .= "<td>" . $fila["nombre_arch"] . "</td>";
            $Tab_Anexos .= "<td><a href='" . "Anexos/" . $fila["src_arch"] . "' target='_blank' class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-search\"></i> Ver</a>";
            $Tab_Anexos .= "<input type='hidden' id='idAnexo" . $contAnexos . "' name='idAnexo' value='" . $fila["descr"] . "///" . $fila["nombre_arch"] . "///" . $fila["src_arch"] . "' /><a onclick=\"$.QuitarAnexo('filaAnexo" . $contAnexos . "')\" class=\"btn default btn-xs red\">"
                    . "<i class=\"fa fa-trash-o\"></i> Quitar</a></td></tr>";
        }
    }
    $Tab_Anexos .= "</tbody>";
    $myDat->Tab_Anexos = $Tab_Anexos;
    $myDat->contAnexos = $contAnexos;



    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusqPrevi") {

    $myDat = new stdClass();

    $consulta = "SELECT * FROM contrato_prevision previ LEFT JOIN clientes cli ON previ.id_titu=cli.inde_cli where previ.id_contr='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->ncontrato = $fila["ncontrato"];
            $myDat->fecha_cre = $fila["fecha_cre"];
            $myDat->ciudad = $fila["ciudad"];
            $myDat->plan = $fila["plan"];
            $myDat->tipo_vinc = $fila["tipo_vinc"];
            $myDat->nomb_titu = $fila["id_titu"] . " - " . acentos($fila["nomb_titu"]);
            $myDat->val_anual = number_format($fila["val_anual"], 2, ",", ".");
            $myDat->val_mes = number_format($fila["val_mes"], 2, ",", ".");
            $myDat->form_pago = $fila["form_pago"];
            $myDat->fech_ini = $fila["fech_ini"];
            $myDat->asesor = acentos($fila["asesor"]);
            $myDat->cobrador = acentos($fila["cobrador"]);
            $myDat->saldo = $fila["saldo"];
            $myDat->mes = $fila["val_mes"];
        }
    }

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusqPreviEmpr") {

    $myDat = new stdClass();

    $consulta = "SELECT Nit_empresa,Nombre_empresa,COUNT(*) conta,SUM(cli.Cuota_cliente) tot, "
            . "IFNULL(Direccion_empresa,'') Direccion_empresa,IFNULL(Telefono_empresa,'') Telefono_empresa "
            . "FROM empresa emp LEFT JOIN cliente cli ON emp.idEmpresa=cli.idEmpresa_cliente  "
            . "WHERE emp.idEmpresa='" . $_POST["cod"] . "' AND cli.Estado_cliente='ACTIVO' ";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->Nit_empresa = $fila["Nit_empresa"];
            $myDat->Nombre_empresa = $fila["Nombre_empresa"];
            $myDat->Direccion_empresa = $fila["Direccion_empresa"];
            $myDat->Telefono_empresa = $fila["Telefono_empresa"];
            $myDat->conta = $fila["conta"];
            $myDat->tot = $fila["tot"];
        }
    }
    // echo $consulta;

    $tabla_anios = "";
    $consulta = "";
    $tabla_anios = "<thead>
                    <tr>
                        <td>
                            <i class='fa fa-angle-right'></i>Año
                        </td>

                        <td>
                            <i class='fa fa-angle-right'></i> Acci&oacute;n
                        </td>
                    </tr>
                </thead>
                <tbody >";

    $cont = 0;

    $consulta = "SELECT anio_cartera FROM cartera WHERE idEmpresa_cartera='" . $_POST["cod"] . "' GROUP BY anio_cartera";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {

        while ($fila = mysqli_fetch_array($resultado)) {
            $idanio = $fila["anio_cartera"];
            $cont++;
            $tabla_anios .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $fila["anio_cartera"] . " "
                    . "</td>"
                    . "<td class=\"highlight\"><input type='hidden' id='idanios" . $cont . "' name='GrupSec' value='" . $idanio . "' />"
                    . "<a  onclick=\"$.VerDetPagos('" . $idanio . "')\"  class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-search\"></i> Ver</a>"
                    . "</td>"
                    . "</tr>";
        }
    }


    $tabla_anios .= "</thead>";
    $myDat->tabla_anios = $tabla_anios;


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "EditPagosVenta") {

    $myDat = new stdClass();

    $consulta = "SELECT * FROM detalles_venta previ where id='" . $_POST["id"] . "' and contrato='" . $_POST["idve"] . "'";
//echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->fpago = $fila["fpago"];
            $myDat->fvenc = $fila["fvenc"];
            $myDat->valor = $fila["valor"];
            $myDat->observ = $fila["observ"];
//  $myDat->tipo_vinc = $fila["tipo_vinc"];
        }
    }

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusProCont") {

    $myDat = new stdClass();


    $pro = " <thead>
            <tr>
                <td>
                    <i class='fa fa-angle-right'></i> #
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Tiempo
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Fecha
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Vigencia
                </td>
            </tr>
        </thead>
<tbody >";

    $consulta = "SELECT 
  * 
FROM
  contrato_arriendo ca 
  LEFT JOIN prorroga_arriendo pa 
    ON ca.id_arriendo = pa.contrato 
WHERE ca.id_arriendo = '" . $_POST['cod'] . "' AND valor='0.00';";
    $resultado = mysqli_query($link, $consulta);

    if (mysqli_num_rows($resultado) > 0) {

        $consulta = "SELECT * FROM prorroga_arriendo where contrato='" . $_POST['cod'] . "'";
        //echo $consulta;
        $cont = 0;
        $resultado = mysqli_query($link, $consulta);
        //echo mysqli_num_rows($resultado);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $cont++;
                $pro .= '<tr class="selected" id="filaDetaCons' . $cont . '" >';
                $pro .= "<td>" . $cont . "</td>";
                $pro .= "<td>" . $fila["tiempo"] . "</td>";
                $pro .= "<td>" . $fila["fecha"] . "</td>";
                $pro .= "<td>" . $fila["vigencia"] . "</td>";
            }
        }
    } else {

        $consulta = "SELECT * FROM contrato_arriendo where id_arriendo='" . $_POST['cod'] . "'";
        // echo $consulta;
        $cont = 0;
        $resultado = mysqli_query($link, $consulta);
        //echo mysqli_num_rows($resultado);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $cont++;
                $pro .= '<tr class="selected" id="filaDetaCons' . $cont . '" >';
                $pro .= "<td>" . $cont . "</td>";
                $pro .= "<td>" . acentos($fila["tiempo"]) . "</td>";
                $pro .= "<td>" . $fila["desde"] . "</td>";
                $pro .= "<td>" . $fila["hasta"] . "</td>";
            }
        }

        $consulta = "SELECT * FROM prorroga_arriendo where contrato='" . $_POST['cod'] . "'";
        //echo $consulta;
        $resultado = mysqli_query($link, $consulta);
        //echo mysqli_num_rows($resultado);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $cont++;
                $pro .= '<tr class="selected" id="filaDetaCons' . $cont . '" >';
                $pro .= "<td>" . $cont . "</td>";
                $pro .= "<td>" . $fila["tiempo"] . "</td>";
                $pro .= "<td>" . $fila["fecha"] . "</td>";
                $pro .= "<td>" . $fila["vigencia"] . "</td>";
            }
        }
    }

    $pro .= "</tbody>";
    $myDat->pro = $pro;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "DeletPagosVenta") {

    $consulta = "DELETE FROM detalles_venta  WHERE id='" . $_POST["id"] . "' and contrato='" . $_POST["idve"] . "'";
    mysqli_query($link, $consulta);


    $consulta = "UPDATE contrato_venta set saldo=saldo+" . $_POST['val'] . "  WHERE id_contr='" . $_POST['idve'] . "'";
    mysqli_query($link, $consulta);

    echo 'bien';
} else if ($_POST["ope"] == "BusqContVenta") {

    $myDat = new stdClass();

    $flag = "0";
    $consulta = "select * from detalles_venta where contrato='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        $flag = "1";
    }

    $consulta = "SELECT * FROM contrato_venta where id_contr='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->ncontrato = $fila["pedido_contr"];
            $myDat->fecha_cre = $fila["fecha_vent"];
            $myDat->ciudad = $fila["ciudad_vent"];
            $myDat->ident_vent = $fila["ident_vent"];
            $myDat->nombre_venta = acentos($fila["nombre_venta"]);
            $myDat->cuota = $fila["cuota_vent"];
            $myDat->fpago = $fila["fpago_vent"];
            if ($flag == "1") {
                $myDat->cuota_vent = $fila["valcumes_vent"];
            } else {
                $myDat->cuota_vent = $fila["valcuini_vent"];
            }

            $myDat->saldo = $fila["saldo"];
            $myDat->precio = $fila["precios_vent"];
        }
    }

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "consultarDetVenta") {

    $conta = "";
    $consulta = "select count(*) co  from detalles_venta where contrato='" . $_POST["id"] . "'";
//  echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $conta = $fila["co"];
        }
    }

    $myDat = new stdClass();
    $valvent = "";
    $consulta = "SELECT * FROM contrato_venta contr LEFT JOIN clientes cli ON contr.ident_vent=cli.inde_cli where id_contr='" . $_POST["id"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {

            $myDat->fecha_cre = $fila["fecha_vent"];
            $myDat->ciudad = $fila["ciudad_vent"];
            $myDat->ident_vent = $fila["ident_vent"];
            $myDat->nombre_venta = $fila["nombre_venta"];
            $myDat->dir_cli = $fila["dir_cli"];
            $myDat->tel_cli = $fila["tel_cli"];

            if ($conta <= 1) {
                $myDat->valcumes_vent = $fila["valcuini_vent"];
                $valvent = $fila["valcuini_vent"];
            } else if ($conta > 1) {

                $myDat->valcumes_vent = $fila["valcumes_vent"];
                $valvent = $fila["valcumes_vent"];
            }
//   $myDat->valcumes_vent = $fila["valcumes_vent"];
        }
    }

    $consulta = "SELECT CONCAT('VENTA DE LOTE TIPO ',tlote,' UBICADO EN EL JARDIN: ',jardin_vent,' ZONA: ', zona_vent, ' LOTE: ', tlote,' ',lote_vent) ubi, precio_vent prec FROM venta_deta_lote WHERE id_venta='" . $_POST["id"] . "'
     UNION ALL
     SELECT  CONCAT('VENTA DE OSARIO TIPO ',tosario_vent,' UBICADO EN EL JARDIN: ',tosario_vent,' No.',osario_vent) ubi, prec_vent prec FROM venta_deta_osario WHERE id_venta='" . $_POST["id"] . "';";
    $resultado = mysqli_query($link, $consulta);
    $cont = 0;

    $Cad = "<thead>
    <tr>
        <td>
            <i class='fa fa-angle-right'></i> #
        </td>
        <td>
            <i class='fa fa-angle-right'></i> Concepto
        </td>

        <td>
            <i class='fa fa-angle-right'></i> Valor
        </td>
    </tr>
</thead>
<tbody >";
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;

            $Cad .= '<tr class="selected" id="filaConsta' . $cont . '" >';
            $Cad .= "<td>" . $cont . "</td>";
            $Cad .= "<td>" . $fila["ubi"] . "</td>";
            $Cad .= "<td>$ " . number_format($fila["prec"], 2, ",", ".") . "</td>";
            $Cad .= "<td><input type='hidden' id='consta" . $cont . "' name='consta' value='" . $fila["ubi"] . "//" . $fila["prec"] . "' />";
        }
    }
    $Cad .= "</tbody><tfoot>
    <tr>
        <th colspan='2' style='text-align: right;'>Total a Pagar:</th>
        <th colspan='1'><label id='gtotalCostancia' style='font-weight: bold;'>$ " . number_format($valvent, 2, ",", ".") . "</label></th>
    </tr>
  </tfoot>";

    $myDat->Cad = $Cad;
    $myDat->cont = $cont;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "mostbenefi") {

    $myDat = new stdClass();

    $contGrupBas = 0;
    $CadGrupBas = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Identificaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Apellido y Nombres
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Parentesco
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Estado Salud
    </td>

    <td>
        <i class='fa fa-angle-right'></i> Edad
    </td>


</tr>
</thead>
<tbody >";
    $consulta = "SELECT * FROM grupo_fambasico WHERE id_cont='" . $_POST["cod"] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $contGrupBas++;

            $CadGrupBas .= '<tr class="selected" id="filaGruBas' . $contGrupBas . '" >';

            $CadGrupBas .= "<td>" . $contGrupBas . "</td>";
            $CadGrupBas .= "<td>" . $fila["ident"] . "</td>";
            $CadGrupBas .= "<td>" . $fila["nombre"] . "</td>";
            $CadGrupBas .= "<td>" . $fila["parent"] . "</td>";
            $CadGrupBas .= "<td>" . $fila["estad"] . "</td>";
            $CadGrupBas .= "<td>" . $fila["edad"] . "</td>";
        }
    }

    $CadGrupBas .= "</tbody>";

    $myDat->CadGrupBas = $CadGrupBas;



    $contGrupSec = 0;
    $CadGrupSec = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Identificaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Apellido y Nombres
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Parentesco
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Estado Salud
    </td>

    <td>
        <i class='fa fa-angle-right'></i> Edad
    </td>


</tr>
</thead>
<tbody >";
    $consulta = "SELECT * FROM grupo_famsecundario WHERE id_cont='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $contGrupSec++;

            $CadGrupSec .= '<tr class="selected" id="filaGruSec' . $contGrupSec . '" >';
            $CadGrupSec .= "<td>" . $contGrupBas . "</td>";
            $CadGrupSec .= "<td>" . $fila["ident"] . "</td>";
            $CadGrupSec .= "<td>" . $fila["nombre"] . "</td>";
            $CadGrupSec .= "<td>" . $fila["parent"] . "</td>";
            $CadGrupSec .= "<td>" . $fila["estad"] . "</td>";
            $CadGrupSec .= "<td>" . $fila["edad"] . "</td>";
        }
    }

    $CadGrupSec .= "</tbody>";

    $myDat->CadGrupSec = $CadGrupSec;


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusInfConsulPago") {

    $myDat = new stdClass();
    $dias = "";
    $idcont = "";
    if ($_POST["tipcli"] == "INDIVIDUAL") {
        $consulta = "SELECT id_contr,ncontrato, plan, fech_vcenc,TIMESTAMPDIFF(MONTH,fech_vcenc,CURDATE()) meses, "
                . "DATEDIFF(fech_vcenc,CURDATE()) diav FROM contrato_prevision where id_titu='" . $_POST["ident"] . "'";
    } else {
        $consulta = "SELECT 
 emp.Nombre_empresa nom,cart.Fecha_vence_cartera fech_vcenc,DATEDIFF(cart.Fecha_vence_cartera,CURDATE()) diav,
 pl.Nombre_plan plan, cli.contrato_cliente ncontrato,cli.idCliente id_contr
FROM
  cartera cart 
  LEFT JOIN empresa emp 
    ON cart.idEmpresa_cartera = emp.idEmpresa
    LEFT JOIN cliente cli 
    ON cart.idEmpresa_cartera=cli.idEmpresa_cliente
    LEFT JOIN plan pl ON cli.idPlan_cliente=pl.idPlan
WHERE idCartera IN 
  (SELECT 
    MAX(idCartera) 
  FROM
    cartera 
  GROUP BY idEmpresa_cartera) AND LTRIM(RTRIM(cli.Cedula_cliente)) ='" . $_POST["ident"] . "'";
    }

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->contrato = $fila["ncontrato"];
            $myDat->fech_vcenc = $fila["fech_vcenc"];
            $myDat->plan = $fila["plan"];
            $idcont = $fila["id_contr"];
            if ($fila["diav"] > 0) {
                $dias = $fila["diav"] . " Restantes";
            } else {
                $dias = abs($fila["diav"]) . " De Retraso";
            }
            $myDat->diav = $dias;

            if ($_POST["tipcli"] == "EMPRESARIAL") {
                $myDat->nom = $fila["nom"];
            }
        }
    }

    $contGrupBas = 0;
    $CadGrupBas = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Identificaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Apellido y Nombres
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Parentesco
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Estado Salud
    </td>

   
</tr>
</thead>
<tbody >";

    if ($_POST["tipcli"] == "INDIVIDUAL") {
        $consulta = "SELECT * FROM grupo_fambasico WHERE id_cont='" . $idcont . "'";

        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $contGrupBas++;

                $CadGrupBas .= '<tr class="selected">';
                $CadGrupBas .= "<td>" . $contGrupBas . "</td>";
                $CadGrupBas .= "<td>" . $fila["ident"] . "</td>";
                $CadGrupBas .= "<td>" . $fila["nombre"] . "</td>";
                $CadGrupBas .= "<td>" . $fila["parent"] . "</td>";
                $CadGrupBas .= "<td>" . $fila["estad"] . "</td></tr>";
            }
        }
        $consulta = "SELECT * FROM grupo_famsecundario WHERE id_cont='" . $idcont . "'";
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $contGrupBas++;

                $CadGrupBas .= '<tr class="selected">';
                $CadGrupBas .= "<td>" . $contGrupBas . "</td>";
                $CadGrupBas .= "<td>" . $fila["ident"] . "</td>";
                $CadGrupBas .= "<td>" . $fila["nombre"] . "</td>";
                $CadGrupBas .= "<td>" . $fila["parent"] . "</td>";
                $CadGrupBas .= "<td>" . $fila["estad"] . "</td></tr>";
            }
        }

        $CadGrupBas .= "</tbody>";
    } else {
        $consulta = "SELECT '' ident, CONCAT(nombre_beneficiario,' ',apellido_beneficiario) nombre,"
                . " parentesco_beneficiario parent,estado_beneficiario estad FROM beneficiario "
                . "WHERE idCliente_beneficiario='" . $idcont . "'";
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $contGrupBas++;

                $CadGrupBas .= '<tr class="selected">';
                $CadGrupBas .= "<td>" . $contGrupBas . "</td>";
                $CadGrupBas .= "<td>" . $fila["ident"] . "</td>";
                $CadGrupBas .= "<td>" . $fila["nombre"] . "</td>";
                $CadGrupBas .= "<td>" . $fila["parent"] . "</td>";
                $CadGrupBas .= "<td>" . $fila["estad"] . "</td></tr>";
            }
        }
    }

    $myDat->CadGrupBas = $CadGrupBas;
    $AnexosBenf = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Descripción
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Opción
    </td>

   
</tr>
</thead>
<tbody >";
    $ruta = "";
    if ($_POST["tipcli"] == "INDIVIDUAL") {
        $consulta = "SELECT descr descri, src_arch archivo FROM previ_anexos WHERE id_prev='" . $idcont . "'";
        $ruta = "Anexos/";
    } else {
        $consulta = "SELECT desc_anexo descri, url_anexo archivo FROM anexo_afiliados WHERE id_afiliado='" . $idcont . "'";
        $ruta = "AnexosEmpresa/";
    }

    $resultado = mysqli_query($link, $consulta);
    $contAnex = 1;
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $AnexosBenf .= '<tr class="selected">';
            $AnexosBenf .= "<td>" . $contAnex . "</td>";
            $AnexosBenf .= "<td>" . $fila["descri"] . "</td>";
            $AnexosBenf .= "<td><a href='" . $ruta . $fila["archivo"] . "' target='_blank' class=\"btn default btn-xs red\">"
                    . "<i class=\"fa fa-file-text-o\"></i> Descargar</a></td>";
            $contAnex++;
        }
    }
    $AnexosBenf .= "</tbody>";

    $myDat->AnexosBenf = $AnexosBenf;
    $myDat->contAnex = $contAnex;



    $myJSONDat = json_encode($myDat);
    echo $myJSONDat;
} else if ($_POST["ope"] == "BusqEditContraArriendo") {

    $myDat = new stdClass();

    $consulta = "SELECT * FROM contrato_arriendo contr LEFT JOIN clientes cli ON contr.ced_cli=cli.inde_cli where contr.id_arriendo='" . $_POST["cod"] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->OrdInhum = $fila["OrdInhum"];
            $myDat->fec_crea = $fila["fec_crea"];
            $myDat->ciuda = $fila["ciuda"];
            $myDat->cemen = acentos($fila["cemen"]);
            $myDat->boveda = acentos($fila["boveda"]);
            $myDat->jardin = $fila["jardin"];
            $myDat->zona = $fila["zona"];
            $myDat->lote = $fila["lote"];
            $myDat->muerto = acentos($fila["muerto"]);
            $myDat->tiempo = acentos($fila["tiempo"]);
            $myDat->desde = $fila["desde"];
            $myDat->hasta = $fila["hasta"];
            $myDat->fec_falle = $fila["fec_falle"];
            $myDat->fec_sepe = $fila["txt_fecha_sepe"];
            $myDat->funeraria = acentos($fila["funeraria"]);
            $myDat->direc = acentos($fila["direc"]);
            $myDat->telef = $fila["telef"];
            $myDat->ced_cli = $fila["ced_cli"];
            $myDat->nom_cli = acentos($fila["nom_cli"]);
            $myDat->sex_cli = $fila["sex_cli"];
            $myDat->fec_cli = $fila["fec_cli"];
            $myDat->dir_cli = acentos($fila["dir_cli"]);
            $myDat->tel_cli = $fila["tel_cli"];
            $myDat->barrio = acentos($fila["barrio"]);
            $myDat->email_cli = acentos($fila["email_cli"]);
            $myDat->observ = acentos($fila["observ"]);
            $myDat->form_muerte = acentos($fila["form_muerte"]);
            $myDat->estado_contrato = acentos($fila["estado_contrato"]);
        }
    }



    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "CargDatArri") {

    $myDat = new stdClass();

    $consulta = "SELECT * FROM contrato_arriendo contr LEFT JOIN clientes cli ON contr.ced_cli=cli.inde_cli where contr.id_arriendo='" . $_POST["id"] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->OrdInhum = $fila["OrdInhum"];
            $myDat->fec_crea = $fila["fec_crea"];
            $myDat->cemen = acentos($fila["cemen"]);
            $myDat->boveda = acentos($fila["boveda"]);
            $myDat->jardin = $fila["jardin"];
            $myDat->zona = $fila["zona"];
            $myDat->lote = $fila["lote"];
            $myDat->hasta = $fila["hasta"];
            $myDat->client = $fila["ced_cli"] . '-' . $fila["nom_cli"];
            $myDat->hasta = $fila["hasta"];
        }
    }



    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusinfFunera") {

    $myDat = new stdClass();

    if ($_POST["ori"] == "Arriendo") {
        $consulta = "SELECT * FROM contrato_arriendo  where id_arriendo='" . $_POST["idr"] . "'";
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $ced_contra = $fila["ced_cli"];
                $funau_req = acentos($fila["funeraria"]);
            }
        }
    } else {
        $consulta = "SELECT * FROM requisiciones  where id_req='" . $_POST["idr"] . "'";
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $ced_contra = $fila["ced_contra"];
                $funau_req = $fila["funau_req"];
                $myDat->nomfall_req = acentos($fila["nomfall_req"]);
                $myDat->fecnfall_req = $fila["fecnfall_req"];
            }
        }
    }



    if ($_POST["cno"] === "FUNERARIA") {
        $consulta = "SELECT * FROM funerarias  where id_fune='" . $funau_req . "'";

        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $myDat->nit = $fila["nit"];
                $myDat->nom_fune = acentos($fila["nom_fune"]);
                $myDat->dir = acentos($fila["dir"]);
                $myDat->tel = $fila["tel"];
            }
        }
    } else if ($_POST["cno"] === "CLIENTE") {
        $consulta = "SELECT * FROM clientes where inde_cli='" . $ced_contra . "'";

        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $myDat->nit = $fila["inde_cli"];
                $myDat->nom_fune = acentos($fila["nom_cli"]);
                $myDat->dir = acentos($fila["dir_cli"] . " " . $fila["barrio"]);
                $myDat->tel = $fila["tel_cli"];
            }
        }
    }



    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusqEditOcupa") {

    $myDat = new stdClass();

    $consulta = "SELECT * FROM ocup_lot_osaid  where id='" . $_POST["cod"] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->nit = $fila["nit"];
            $myDat->nombr = $fila["nombr"];
            $myDat->fecha = $fila["fecha"];
            $myDat->obser = $fila["obser"];
        }
    }



    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusqEditContraVenta") {

    $myDat = new stdClass();

    $consulta = "SELECT * FROM contrato_venta contr LEFT JOIN clientes cli ON contr.ident_vent=cli.inde_cli where contr.id_contr='" . $_POST["cod"] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->pedido_contr = $fila["pedido_contr"];
            $myDat->fecha_vent = $fila["fecha_vent"];
            $myDat->ciudad_vent = $fila["ciudad_vent"];
            $myDat->cuota_vent = $fila["cuota_vent"];
            $myDat->fpago_vent = $fila["fpago_vent"];

            $myDat->precio = $fila["precios_vent"];
            $myDat->precios_vent = number_format($fila["precios_vent"], 2, ",", ".");
            $myDat->valcuini_vent = number_format($fila["valcuini_vent"], 2, ",", ".");
            $myDat->valcumes_vent = number_format($fila["valcumes_vent"], 2, ",", ".");

            $myDat->inde_cli = $fila["inde_cli"];
            $myDat->nom_cli = acentos($fila["nom_cli"]);
            $myDat->sex_cli = $fila["sex_cli"];
            $myDat->fec_cli = $fila["fec_cli"];
            $myDat->dir_cli = acentos($fila["dir_cli"]);
            $myDat->tel_cli = $fila["tel_cli"];
            $myDat->barrio = $fila["barrio"];
            $myDat->email_cli = $fila["email_cli"];
            $myDat->observ = acentos($fila["observ"]);
        }
    }

/////////////TABLA PERSONAS///////////////////
    $cont = 0;
    $CadPers = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Identificaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Nombre
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Tel&eacute;fono
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Acci&oacute;n
    </td>
</tr>
</thead>
<tbody >";
    $consulta = "SELECT * FROM personas_contrato_venta
              WHERE idcontr_persocont='" . $_POST["cod"] . "'";
    $cont = 0;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $CadPers .= '<tr class="selected" id="filaPers' . $cont . '" >';

            $CadPers .= "<td>" . $cont . "</td>";
            $CadPers .= "<td>" . $fila["iden_persocont"] . "</td>";
            $CadPers .= "<td>" . acentos($fila["nom_persocont"]) . "</td>";
            $CadPers .= "<td>" . $fila["tel_persocont"] . "</td>";
            $CadPers .= "<td><input type='hidden' id='Perso" . $cont . "' name='Perso' value='" . $fila["iden_persocont"] . "//" . $fila["nom_persocont"] . "//" . $fila["tel_persocont"] . "' /><a onclick=\"$.QuitarNeces('filaPers" . $cont . "')\" class=\"btn default btn-xs red\">"
                    . "<i class=\"fa fa-trash-o\"></i> Borrar</a></td></tr>";
        }
    }

    $CadPers .= "</tbody>";

    $myDat->CadPers = $CadPers;
    $myDat->cont = $cont;



/////////////TABLA LOTES///////////////////
    $contLote = 0;
    $CadLote = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Ubicaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Tipo de Lote
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Precio
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Construcci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Observaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Ocupado
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Acci&oacute;n
    </td>
</tr>
</thead>
<tbody>";
    $consulta = "SELECT * FROM venta_deta_lote
              WHERE id_venta='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $contLote++;
            $CadLote .= '<tr class="selected" id="filaLote' . $contLote . '" >';
            $CadLote .= "<td>" . $contLote . "</td>";
            $CadLote .= "<td>" . "Jardin:" . $fila["jardin_vent"] . " Zona:" . $fila["zona_vent"] . " Lote:" . $fila["lote_vent"] . "</td>";
            $CadLote .= "<td>" . $fila["tlote"] . "</td>";
            $CadLote .= "<td>$ " . number_format($fila["precio_vent"], 2, ",", ".") . "</td>";
            $CadLote .= "<td>" . acentos($fila["costru_vent"]) . "</td>";
            $CadLote .= "<td>" . acentos($fila["obser_vent"]) . "</td>";
            $CadLote .= "<td><a  onclick=\"$.OcupantesLote('" . $fila["id"] . "')\"> Ocupado</a></td>";
            $CadLote .= "<td><input type='hidden' id='Lotes" . $contLote . "' name='Lotes' value='" . $fila["jardin_vent"] . "//" . $fila["zona_vent"] . "//" . $fila["lote_vent"] . "//" . $fila["tlote"] . "//" . $fila["precio_vent"] . "//" . $fila["costru_vent"] . "//" . $fila["obser_vent"] . "//" . $fila["id"] . "' />"
                    . "<a onclick=\"$.QuitarLote('Lotes" . $contLote . "')\" class=\"btn default btn-xs red\">"
                    . "<i class=\"fa fa-trash-o\"></i> Borrar</a>"
                    . "<a onclick=\"$.EditarLote('Lotes" . $contLote . "')\" class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-edit\"></i> Editar</a></td></tr>";
        }
    }

    $CadLote .= "</tbody>";

    $myDat->CadLote = $CadLote;
    $myDat->contLote = $contLote;


/////////////TABLA OSARIOS///////////////////
    $contOsa = 0;
    $CadOsa = "<thead>
    <tr>
    <td>
        <i class='fa fa-angle-right'></i> #
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Ubicaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Tipo de Lote
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Precio
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Construcci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Observaci&oacute;n
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Ocupado
    </td>
    <td>
        <i class='fa fa-angle-right'></i> Acci&oacute;n
    </td>
</tr>
</thead>
<tbody >";
    $consulta = "SELECT * FROM venta_deta_osario
              WHERE id_venta='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $contOsa++;
            $CadOsa .= '<tr class="selected" id="filaOsario' . $contLote . '" >';

            $CadOsa .= "<td>" . $contOsa . "</td>";
            $CadOsa .= "<td>" . "Jardin:" . $fila["jardin_vent"] . " Número:" . $fila["osario_vent"] . "</td>";
            $CadOsa .= "<td>" . $fila["tosario_vent"] . "</td>";
            $CadOsa .= "<td>$ " . number_format($fila["prec_vent"], 2, ",", ".") . "</td>";
            $CadOsa .= "<td>" . acentos($fila["costr_vent"]) . "</td>";
            $CadOsa .= "<td>" . acentos($fila["obser_vent"]) . "</td>";
            $CadOsa .= "<td><a  onclick=\"$.OcupantesOsa('" . $fila["id"] . "')\"> Ocupado</a></td>";
            $CadOsa .= "<td><input type='hidden' id='Osario" . $contOsa . "' name='Osario' value='" . $fila["jardin_vent"] . "//" . $fila["osario_vent"] . "//" . $fila["tosario_vent"] . "//" . $fila["prec_vent"] . "//" . $fila["costr_vent"] . "//" . $fila["obser_vent"] . "//" . $fila["id"] . "' />"
                    . "<a onclick=\"$.QuitarOsario('Osario" . $contOsa . "')\" class=\"btn default btn-xs red\">"
                    . "<i class=\"fa fa-trash-o\"></i> Borrar</a>"
                    . "<a onclick=\"$.EditarOsario('Osario" . $contOsa . "')\" class=\"btn default btn-xs blue\">"
                    . "<i class=\"fa fa-edit\"></i> Editar</a></td></tr>";
        }
    }

    $CadOsa .= "</tbody>";

    $myDat->CadOsa = $CadOsa;
    $myDat->contOsa = $contOsa;


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "cargaConstancia") {

    $myDat = new stdClass();
    $exit = "n";
    $consulta = "SELECT * FROM constanciasarriendo WHERE cont_arriendo='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->idcos = $fila["id_constan"];
            $myDat->cons_constan = $fila["cons_constan"];
            $myDat->fec_cre = $fila["fec_cre"];
            $myDat->fec_cons = $fila["fec_cons"];
            $myDat->ciudad = $fila["ciudad"];
            $myDat->iden_constan = $fila["iden_constan"];
            $myDat->nom_constan = $fila["nom_constan"];
            $myDat->consig_constan = $fila["consig_constan"];
            $myDat->valor = $fila["valor"];
            $myDat->concepto = $fila["concepto"];
            $myDat->dircons = $fila["dircons"];
            $myDat->telcons = $fila["telcons"];
            $exit = "s";
        }
    }
    $myDat->exit = $exit;
    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "cargaConstancia2") {

    $myDat = new stdClass();
    $exit = "n";
//    $consulta = "SELECT * FROM constanciasarriendo WHERE cont_arriendo='" . $_POST["cod"] . "'";
//    $resultado = mysqli_query($link,$consulta);
//    if (mysqli_num_rows($resultado) > 0) {
//        while ($fila = mysqli_fetch_array($resultado)) {
//            $myDat->idcos = $fila["id_constan"];
//            $myDat->cons_constan = $fila["cons_constan"];
//            $myDat->fec_cre = $fila["fec_cre"];
//            $myDat->fec_cons = $fila["fec_cons"];
//            $myDat->ciudad = $fila["ciudad"];
//            $myDat->iden_constan = $fila["iden_constan"];
//            $myDat->nom_constan = $fila["nom_constan"];
//            $myDat->consig_constan = $fila["consig_constan"];
//            $myDat->valor = $fila["valor"];
//            $myDat->concepto = $fila["concepto"];
//            $myDat->dircons = $fila["dircons"];
//            $myDat->telcons = $fila["telcons"];
//            $exit = "s";
//        }
//    }
    if ($exit == "n") {
        $consulta = "SELECT * FROM contrato_arriendo WHERE id_arriendo='" . $_POST["cod"] . "'";
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $myDat->cemen = $fila["cemen"];
                $myDat->ciuda = $fila["ciuda"];
                $myDat->tiempo = $fila["tiempo"];
                $myDat->muerto = $fila["muerto"];
                $myDat->fec_falle = $fila["fec_falle"];
            }
        }
    }
    $myDat->exit = $exit;
    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "cargaConstancia3") {

    $myDat = new stdClass();
    $exit = "n";
    $consulta = "SELECT * FROM constanciasarriendo WHERE cont_arriendo='" . $_POST["cod"] . "'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->idcos = $fila["id_constan"];
            $myDat->cons_constan = $fila["cons_constan"];
            $myDat->fec_cre = $fila["fec_cre"];
            $myDat->fec_cons = $fila["fec_cons"];
            $myDat->ciudad = $fila["ciudad"];
            $myDat->iden_constan = $fila["iden_constan"];
            $myDat->nom_constan = $fila["nom_constan"];
            $myDat->consig_constan = $fila["consig_constan"];
            $myDat->valor = $fila["valor"];
            $myDat->concepto = $fila["concepto"];
            $myDat->dircons = $fila["dircons"];
            $myDat->telcons = $fila["telcons"];
            $exit = "s";
        }
    }
    if ($exit == "n") {
        $consulta = "SELECT * FROM contrato_arriendo WHERE id_arriendo='" . $_POST["cod"] . "'";
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $myDat->cemen = $fila["cemen"];
                $myDat->ciuda = $fila["ciuda"];
                $myDat->tiempo = $fila["tiempo"];
                $myDat->muerto = $fila["muerto"];
                $myDat->fec_falle = $fila["fec_falle"];
            }
        }
    }
    $myDat->exit = $exit;
    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "cargaFacturaArri") {

    $myDat = new stdClass();
    $exit = "n";
    $consulta = "SELECT * FROM facturas_arriendo WHERE arri='" . $_POST["cod"] . "' and estado='ACTIVO'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->id_fact = $fila["id_fact"];
            $myDat->cons_fact = $fila["cons_fact"];
            $myDat->fec_cre = $fila["fec_cre"];
            $myDat->ciudad = $fila["ciudad"];
            $myDat->iden = $fila["iden"];
            $myDat->nom = acentos($fila["nom"]);
            $myDat->fpago = $fila["fpago"];
            $myDat->valor = $fila["valor"];
            $myDat->detalle = acentos($fila["detalle"]);
            $myDat->dirfact = acentos($fila["dirfact"]);
            $myDat->telfact = $fila["telfact"];
            $exit = "s";
        }
    }
    $myDat->exit = $exit;
    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusInfPror") {

    $myDat = new stdClass();
    $consulta = "SELECT pa.valor val, pa.fecha fec, ca.ced_cli ced,ca.nom_cli nom, pa.tiempo tie, 
        ca.muerto muer, ca.fec_falle ffall, ca.boveda bov FROM contrato_arriendo ca 
LEFT JOIN prorroga_arriendo pa ON ca.id_arriendo=pa.contrato WHERE pa.id='" . $_POST["cod"] . "'";
    //echo $consulta;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->val = "$ " . number_format($fila["val"], 2, ",", ".");
            $myDat->fec = $fila["fec"];
            $myDat->ced = $fila["ced"];
            $myDat->nom = $fila["nom"];
            $myDat->tie = $fila["tie"];
            $myDat->muer = $fila["muer"];
            $myDat->ffall = $fila["ffall"];
            $myDat->bov = $fila["bov"];
        }
    }

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "InfUbic") {
    $infub = explode("-", $_POST["cod"]);
    $myDat = new stdClass();

    $consulta = "SELECT * FROM venta_deta_lote WHERE id='" . $infub[0] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->tlote = $fila["tlote"];
//            $myDat->cons_fact = $fila["cons_fact"];
//            $myDat->fec_cre = $fila["fec_cre"];
        }
    }

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "InfUbicExhumacion") {
    $infub = explode("-", $_POST["cod"]);
    $myDat = new stdClass();
    if ($_POST["tpr"] == "Arriendo") {
        $consulta = "SELECT txt_fecha_sepe fec,muerto fall,'nn' tlote FROM contrato_arriendo WHERE id_arriendo='" . $infub[0] . "'";
    } else {
        if ($infub[1] == "lote") {
            $consulta = "SELECT ocu.fecha fec, ocu.nombr fall, vl.tlote tlote FROM venta_deta_lote vl LEFT JOIN ocup_lot_osaid ocu ON vl.id=ocu.id_ocup WHERE vl.id='" . $infub[0] . "' AND ocu.tip='" . $infub[1] . "'";
        } else {
            $consulta = "SELECT ocu.fecha fec, ocu.nombr fall, vl.tosario_vent tlote FROM venta_deta_osario vl LEFT JOIN ocup_lot_osaid ocu ON vl.id=ocu.id_ocup WHERE vl.id='" . $infub[0] . "' AND ocu.tip='" . $infub[1] . "'";
        }
    }



    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $myDat->tlote = $fila["tlote"];
            $myDat->fec = $fila["fec"];
            $myDat->fall = $fila["fall"];
        }
    }

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "cargaFactura") {

    $myDat = new stdClass();

    $existe = "n";
    $idfac = "";
    $consulta = "SELECT * FROM facturas_requi  WHERE requi='" . $_POST["cod"] . "' AND estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $existe = "s";
            $idfac = $fila["id_fact"];
            $val_letra = $fila["val_letra"];
            $val = $fila["valor"];

            $myDat->id_fact = $fila["id_fact"];
            $myDat->cons_fact = $fila["cons_fact"];
            $myDat->fec_cre = $fila["fec_cre"];
            $myDat->ciudad = $fila["ciudad"];
            $myDat->iden = $fila["iden"];
            $myDat->nom = acentos($fila["nom"]);
            $myDat->dir = acentos($fila["dirfact"]);
            $myDat->tel = $fila["telfact"];
            $myDat->fpago = $fila["fpago"];
            $myDat->valor = $fila["valor"];
            $myDat->val_letra = $fila["val_letra"];
        }
    }

    if ($existe == "s") {


        $CadNec = " <thead>
            <tr>
                <td>
                    <i class='fa fa-angle-right'></i> #
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Detalle
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Cantidad
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Valor Unitario
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Valor Total
                </td>
            </tr>
        </thead>
<tbody >";
        $consulta = "SELECT det.detalle det, det.cant cant,det.val val, (val*cant) tot, serv.desc_serv descr FROM detalles_facturarequi det LEFT JOIN servicios serv ON det.detalle=serv.id_serv WHERE det.conse_cons='" . $idfac . "'";
//echo $consulta;
        $cont = 0;
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $cont++;
                $CadNec .= '<tr class="selected" id="filaDeta' . $cont . '" >';
                $CadNec .= "<td>" . $cont . "</td>";
                $CadNec .= "<td>" . acentos($fila["descr"]) . "</td>";
                $CadNec .= "<td>" . $fila["cant"] . "</td>";
                $CadNec .= "<td>$ " . number_format($fila["val"], 2, ",", ".") . "</td>";
                $CadNec .= "<td>$ " . number_format($fila["tot"], 2, ",", ".") . "</td>";
                $CadNec .= "<td><input type='hidden' id='Detall" . $cont . "' name='Neces' value='" . $fila["det"] . "//" . $fila["cant"] . "//" . $fila["val"] . "//" . $fila["descr"] . "' /></td></tr>";
            }
        }

        $CadNec .= "</tbody><tfoot>
    <tr>
         <th colspan='3' ><label id='gtotalDetLetra' style='font-weight: bold;'>" . $val_letra . "</label></th>
        <th colspan='1' style='text-align: right;'>Total:</th>
        <th colspan='1'><label id='gtotalDet' style='font-weight: bold;'>$ " . number_format($val, 2, ",", ".") . "</label></th>

    </tr>
  </tfoot>";
    } else {

        $consulta = "select * from requisiciones req left join clientes cli on req.ced_contra=cli.inde_cli WHERE id_req='" . $_POST["cod"] . "'";
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {

                $myDat->fec_cre = $fila["fech_req"];
                $myDat->ciudad = $fila["ciu_req"];
                $myDat->iden = $fila["ced_contra"];
                $myDat->nom = acentos($fila["nom_contr"]);
                $myDat->dir = acentos($fila["dir_cli"]);
                $myDat->tel = $fila["tel_cli"];
            }
        }


        $CadNec = " <thead>
            <tr>
                <td>
                    <i class='fa fa-angle-right'></i> #
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Detalle
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Cantidad
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Valor Unitario
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Valor Total
                </td>
            </tr>
        </thead>
<tbody >";
        $totalg = 0;
        $cont = 0;

        $consulta = "SELECT dre.nece det, dre.cant cant,dre.val val, (dre.val*dre.cant) tot, serv.desc_serv descr FROM requi_servicios dre LEFT JOIN servicios serv ON  dre.nece=serv.id_serv WHERE id_req='" . $_POST["cod"] . "'";
// echo $consulta;
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $cont++;
                $totalg = $totalg + $fila["tot"];
                $CadNec .= '<tr class="selected" id="filaDeta' . $cont . '" >';
                $CadNec .= "<td>" . $cont . "</td>";
                $CadNec .= "<td>" . acentos($fila["descr"]) . "</td>";
                $CadNec .= "<td>" . $fila["cant"] . "</td>";
                $CadNec .= "<td>$ " . number_format($fila["val"], 2, ",", ".") . "</td>";
                $CadNec .= "<td>$ " . number_format($fila["tot"], 2, ",", ".") . "</td>";
                $CadNec .= "<td><input type='hidden' id='Detall" . $cont . "' name='Neces' value='" . $fila["det"] . "//" . $fila["cant"] . "//" . $fila["val"] . "//" . $fila["descr"] . "' /></td></tr>";
            }
        }

        $CadNec .= "</tbody><tfoot>
    <tr>
         <th colspan='3' ><label id='gtotalDetLetra' style='font-weight: bold;'></label></th>
        <th colspan='1' style='text-align: right;'>Total:</th>
        <th colspan='1'><label id='gtotalDet' style='font-weight: bold;'>$ " . number_format($totalg, 2, ",", ".") . "</label></th>

    </tr>
  </tfoot>";
        $myDat->valor = $totalg;
    }


    $myDat->CadNec = $CadNec;
    $myDat->cont = $cont;
    $myDat->existe = $existe;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "cargaFacturaCost") {

    $myDat = new stdClass();

    $existe = "n";
    $idfac = "";
    $consulta = "SELECT * FROM facturas_costancias  WHERE constancia='" . $_POST["cod"] . "' AND estado='ACTIVO'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $existe = "s";
            $idfac = $fila["id_fact"];
            $val_letra = $fila["val_letra"];
            $val = $fila["valor"];

            $myDat->id_fact = $fila["id_fact"];
            $myDat->cons_fact = $fila["cons_fact"];
            $myDat->fec_cre = $fila["fec_cre"];
            $myDat->ciudad = $fila["ciudad"];
            $myDat->iden = $fila["iden"];
            $myDat->nom = acentos($fila["nom"]);
            $myDat->dir = acentos($fila["dirfact"]);
            $myDat->tel = $fila["telfact"];
            $myDat->fpago = $fila["fpago"];
            $myDat->valor = $fila["valor"];
            $myDat->val_letra = $fila["val_letra"];
        }
    }

    if ($existe == "s") {


        $CadNec = " <thead>
            <tr>
                  <td>
                    <i class='fa fa-angle-right'></i> #
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Concepto
                    
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Observación
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Cantidad 
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Valor Unitario
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Valor Total
                </td>
            </tr>
        </thead>
<tbody >";
        $consulta = "SELECT serv.desc_serv descr, df.concep idserv, serv.desc_serv obs, df.cant cant,df.val val FROM detalles_facturaconst df left join servicios serv on df.concep=serv.id_serv WHERE conse_cons='" . $idfac . "'";
//echo $consulta;
        $total = 0;
        $totalg = 0;
        $cont = 0;
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $cont++;
                 $total = $fila["val"] * $fila["cant"];
                $totalg = $totalg + $total;
                $CadNec .= '<tr class="selected" id="filaDeta' . $cont . '" >';
                $CadNec .= "<td>" . $cont . "</td>";
                $CadNec .= "<td>" . acentos($fila["descr"]) . "</td>";
                $CadNec .= "<td>" . acentos($fila["obs"]) . "</td>";
                $CadNec .= "<td>" . $fila["cant"] . "</td>";
                $CadNec .= "<td>$ " . number_format($fila["val"], 2, ",", ".") . "</td>";
                $CadNec .= "<td>$ " . number_format($total, 2, ",", ".") . "</td>";
                $CadNec .= "<td><input type='hidden' id='Detall" . $cont . "' name='Neces' value='" . $fila["idserv"] . "//". $fila["obs"] . "//" . $fila["cant"] . "//" . $fila["val"] . "' /></td></tr>";
            }
        }

        $CadNec .= "</tbody><tfoot>
    <tr>
         <th colspan='4' ><label id='gtotalDetLetra' style='font-weight: bold;'>" . $val_letra . "</label></th>
        <th colspan='1' style='text-align: right;'>Total:</th>
        <th colspan='1'><label id='gtotalDet' style='font-weight: bold;'>$ " . number_format($val, 2, ",", ".") . "</label></th>

    </tr>
  </tfoot>";
    } else {

        $consulta = "select * from constancias req left join clientes cli on req.iden_constan=cli.inde_cli WHERE req.id_constan='" . $_POST["cod"] . "'";
//        echo $consulta;
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {

                $myDat->fec_cre = $fila["fec_cre"];
                $myDat->ciudad = $fila["ciudad"];
                $myDat->iden = $fila["iden_constan"];
                $myDat->nom = acentos($fila["nom_constan"]);
                $myDat->dir = acentos($fila["dircons"]);
                $myDat->tel = $fila["telcons"];
            }
        }


        $CadNec = " <thead>
            <tr>
                     <td>
                    <i class='fa fa-angle-right'></i> #
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Concepto
                    
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Observación
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Cantidad 
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Valor Unitario
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Valor Total
                </td>
            </tr>
        </thead>
<tbody >";
        $total = 0;
        $totalg = 0;
        $cont = 0;

        $consulta = "SELECT serv.desc_serv concep,conc.concep idconcep, conc.cant cant,conc.val val,conc.obs obs FROM concep_constancias conc "
                . "left join servicios serv on conc.concep=serv.id_serv WHERE conse_cons='" . $_POST["cod"] . "'";

// echo $consulta;
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $cont++;
                $total = $fila["val"] * $fila["cant"];
                $totalg = $totalg + $total;
                $CadNec .= '<tr class="selected" id="filaDeta' . $cont . '" >';
                $CadNec .= "<td>" . $cont . "</td>";
                $CadNec .= "<td>" . acentos($fila["concep"]) . "</td>";
                $CadNec .= "<td>" . acentos($fila["obs"]) . "</td>";
                $CadNec .= "<td>" . $fila["cant"] . "</td>";
                $CadNec .= "<td>$ " . number_format($fila["val"], 2, ",", ".") . "</td>";
                $CadNec .= "<td>$ " . number_format($total, 2, ",", ".") . "</td>";
                $CadNec .= "<td><input type='hidden' id='Detall" . $cont . "' name='Neces' value='" . $fila["idconcep"] . "//" . $fila["obs"] . "//" . $fila["cant"] . "//" . $fila["val"] . "' /></td></tr>";
            }
        }

        $CadNec .= "</tbody><tfoot>
    <tr>
         <th colspan='4' ><label id='gtotalDetLetra' style='font-weight: bold;'></label></th>
        <th colspan='1' style='text-align: right;'>Total:</th>
        <th colspan='1'><label id='gtotalDet' style='font-weight: bold;'>$ " . number_format($totalg, 2, ",", ".") . "</label></th>

    </tr>
  </tfoot>";
        $myDat->valor = $totalg;
    }


    $myDat->CadNec = $CadNec;
    $myDat->cont = $cont;
    $myDat->existe = $existe;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "cargaCostanciaRequi") {

    $myDat = new stdClass();

    $existe = "n";
    $idcons = "";
    $valor = 0;
    $consulta = "SELECT * FROM constancias  WHERE requi='" . $_POST["cod"] . "' AND estado='ACTIVO'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $existe = "s";
            $idcons = $fila["id_constan"];
            $myDat->id_constan = $fila["id_constan"];
            $myDat->cons_constan = $fila["cons_constan"];
            $myDat->fec_cre = $fila["fec_cre"];
            $myDat->fec_cons = $fila["fec_cons"];
            $myDat->ciudad = $fila["ciudad"];
            $myDat->iden = $fila["iden_constan"];
            $myDat->nom = $fila["nom_constan"];
            $myDat->dir = $fila["dircons"];
            $myDat->tel = $fila["telcons"];
            $myDat->consig_constan = $fila["consig_constan"];
            $myDat->valor = $fila["valor"];
            $valor = $fila["valor"];
        }
    }

    $CadNec = " <thead>
            <tr>
                     <td>
                    <i class='fa fa-angle-right'></i> #
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Concepto
                    
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Observación
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Cantidad 
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Valor Total
                </td>
            </tr>
        </thead>
<tbody >";
    $consulta = "SELECT det.concep det, det.cant cant,det.val val, (val*cant) tot, serv.desc_serv descr FROM concep_constancias det LEFT JOIN servicios serv ON det.concep=serv.id_serv WHERE det.conse_cons='" . $idcons . "'";
//echo $consulta;
    $cont = 0;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $CadNec .= '<tr class="selected" id="filaDetaCons' . $cont . '" >';
            $CadNec .= "<td>" . $cont . "</td>";
            $CadNec .= "<td>" . $fila["descr"] . "</td>";
            $CadNec .= "<td>" . $fila["cant"] . "</td>";
            $CadNec .= "<td>$ " . number_format($fila["val"], 2, ",", ".") . "</td>";
            $CadNec .= "<td>$ " . number_format($fila["tot"], 2, ",", ".") . "</td>";
            $CadNec .= "<td><input type='hidden' id='DetallCons" . $cont . "' name='DetallCons' value='" . $fila["det"] . "//" . $fila["cant"] . "//" . $fila["val"] . "//" . $fila["descr"] . "' /></td></tr>";
        }
    }

    $CadNec .= "</tbody><tfoot>
    <tr>

        <th colspan='4' style='text-align: right;'>Total:</th>
        <th colspan='1'><label id='gtotalcost' style='font-weight: bold;'>$ " . number_format($valor, 2, ",", ".") . "</label></th>

    </tr>
  </tfoot>";


    $myDat->CadNec = $CadNec;
    $myDat->cont = $cont;
    $myDat->existe = $existe;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "cargaCostanciaEmpre") {

    $myDat = new stdClass();

    $existe = "n";
    $idcons = "";
    $valor = 0;
    $consulta = "SELECT * FROM constancias  WHERE requi='" . $_POST["cod"] . "' AND estado='ACTIVO'";
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $existe = "s";
            $idcons = $fila["id_constan"];
            $myDat->id_constan = $fila["id_constan"];
            $myDat->cons_constan = $fila["cons_constan"];
            $myDat->fec_cre = $fila["fec_cre"];
            $myDat->fec_cons = $fila["fec_cons"];
            $myDat->ciudad = $fila["ciudad"];
            $myDat->iden = $fila["iden_constan"];
            $myDat->nom = $fila["nom_constan"];
            $myDat->dir = $fila["dircons"];
            $myDat->tel = $fila["telcons"];
            $myDat->consig_constan = $fila["consig_constan"];
            $myDat->valor = $fila["valor"];
            $valor = $fila["valor"];
        }
    }

    $CadNec = " <thead>
            <tr>
                <td>
                    <i class='fa fa-angle-right'></i> #
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Concepto
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Cantidad
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Valor
                </td>
                <td>
                    <i class='fa fa-angle-right'></i>  Total
                </td>
            </tr>
        </thead>
<tbody >";
    $consulta = "SELECT det.concep det, det.cant cant,det.val val, (val*cant) tot, serv.desc_serv descr FROM concep_constancias det LEFT JOIN servicios serv ON det.concep=serv.id_serv WHERE det.conse_cons='" . $idcons . "'";
//echo $consulta;
    $cont = 0;
    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $cont++;
            $CadNec .= '<tr class="selected" id="filaDetaCons' . $cont . '" >';
            $CadNec .= "<td>" . $cont . "</td>";
            $CadNec .= "<td>" . $fila["descr"] . "</td>";
            $CadNec .= "<td>" . $fila["cant"] . "</td>";
            $CadNec .= "<td>$ " . number_format($fila["val"], 2, ",", ".") . "</td>";
            $CadNec .= "<td>$ " . number_format($fila["tot"], 2, ",", ".") . "</td>";
            $CadNec .= "<td><input type='hidden' id='DetallCons" . $cont . "' name='DetallCons' value='" . $fila["det"] . "//" . $fila["cant"] . "//" . $fila["val"] . "//" . $fila["descr"] . "' /></td></tr>";
        }
    }

    $CadNec .= "</tbody><tfoot>
    <tr>

        <th colspan='4' style='text-align: right;'>Total:</th>
        <th colspan='1'><label id='gtotalcost' style='font-weight: bold;'>$ " . number_format($valor, 2, ",", ".") . "</label></th>

    </tr>
  </tfoot>";


    $myDat->CadNec = $CadNec;
    $myDat->cont = $cont;
    $myDat->existe = $existe;

    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "BusHistProrrog") {

    $myDat = new stdClass();


    $pro = " <thead>
            <tr>
                <td>
                    <i class='fa fa-angle-right'></i> #
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Tiempo
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Fecha
                </td>
                <td>
                    <i class='fa fa-angle-right'></i> Vigencia
                </td>
                <td>
                    <i class='fa fa-angle-right'></i>  Valor
                </td>
                <td>
                    <i class='fa fa-angle-right'>Recibo/Costancia</i>  
                </td>
            </tr>
        </thead>
<tbody >";

    $consulta = "SELECT 
  * 
FROM
  contrato_arriendo ca 
  LEFT JOIN prorroga_arriendo pa 
    ON ca.id_arriendo = pa.contrato 
WHERE ca.id_arriendo = '" . $_POST['id'] . "' AND valor='0.00';";
    $resultado = mysqli_query($link, $consulta);

    if (mysqli_num_rows($resultado) > 0) {

        $consulta = "SELECT * FROM prorroga_arriendo where contrato='" . $_POST['id'] . "'";
        //echo $consulta;
        $cont = 0;
        $resultado = mysqli_query($link, $consulta);
        //echo mysqli_num_rows($resultado);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $cont++;
                $pro .= '<tr class="selected" id="filaDetaCons' . $cont . '" >';
                $pro .= "<td>" . $cont . "</td>";
                $pro .= "<td>" . $fila["tiempo"] . "</td>";
                $pro .= "<td>" . $fila["fecha"] . "</td>";
                $pro .= "<td>" . $fila["vigencia"] . "</td>";
                if ($fila["valor"] == "0,00") {
                    $pro .= "<td>--</td>";
                } else {
                    $pro .= "<td>$ " . number_format($fila["valor"], 2, ",", ".") . "</td>";
                }

                if ($fila["recibo"] === "") {
                    $pro .= "<td><a onclick=\"$.ContaciaProrroga('" . $fila['id'] . "')\" class=\"btn default btn-xs red\">"
                            . "<i class=\"fa fa-file-text-o\"></i> Constancia</a></td></tr>";
                } else {
                    $pro .= "<td>" . $fila["recibo"] . "</td>";
//                $pro .= "<td><a onclick=\"$.ReciboProrroga('" ."T/". $fila['id']."/".$fila['recibo']. "')\" class=\"btn default btn-xs red\">"
//                    . "<i class=\"fa fa-file-text-o\"></i> Recibo</a></td></tr>";
                }
            }
        }
    } else {

        $consulta = "SELECT * FROM contrato_arriendo where id_arriendo='" . $_POST['id'] . "'";
        // echo $consulta;
        $cont = 0;
        $resultado = mysqli_query($link, $consulta);
        //echo mysqli_num_rows($resultado);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $cont++;
                $pro .= '<tr class="selected" id="filaDetaCons' . $cont . '" >';
                $pro .= "<td>" . $cont . "</td>";
                $pro .= "<td>" . acentos($fila["tiempo"]) . "</td>";
                $pro .= "<td>" . $fila["desde"] . "</td>";
                $pro .= "<td>" . $fila["hasta"] . "</td>";
                $pro .= "<td>--</td>";
                $pro .= "<td>--</td>";
            }
        }

        $consulta = "SELECT * FROM prorroga_arriendo where contrato='" . $_POST['id'] . "'";
        //echo $consulta;
        $resultado = mysqli_query($link, $consulta);
        //echo mysqli_num_rows($resultado);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $cont++;
                $pro .= '<tr class="selected" id="filaDetaCons' . $cont . '" >';
                $pro .= "<td>" . $cont . "</td>";
                $pro .= "<td>" . $fila["tiempo"] . "</td>";
                $pro .= "<td>" . $fila["fecha"] . "</td>";
                $pro .= "<td>" . $fila["vigencia"] . "</td>";
                if ($fila["valor"] == "0.00") {
                    $pro .= "<td>--</td>";
                } else {
                    $pro .= "<td>$ " . number_format($fila["valor"], 2, ",", ".") . "</td>";
                }

                if ($fila["recibo"] === "") {
                    $pro .= "<td><a onclick=\"$.ContaciaProrroga('" . $fila['id'] . "')\" class=\"btn default btn-xs red\">"
                            . "<i class=\"fa fa-file-text-o\"></i> Constancia</a></td></tr>";
                } else {
                    $pro .= "<td>" . $fila["recibo"] . "</td>";
//                $pro .= "<td><a onclick=\"$.ReciboProrroga('" ."T/". $fila['id']."/".$fila['recibo']. "')\" class=\"btn default btn-xs red\">"
//                    . "<i class=\"fa fa-file-text-o\"></i> Recibo</a></td></tr>";
                }
            }
        }
    }

    $pro .= "</tbody>";
    $myDat->pro = $pro;


    $myJSONDat = json_encode($myDat);

    echo $myJSONDat;
} else if ($_POST["ope"] == "cargaPerfil") {
    $perf = "<option value=''>Select...</option>";
    $consulta = "SELECT nomperfil nom FROM perfiles";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $perf .= "<option value='" . $fila["nom"] . "'>" . $fila["nom"] . "</option>";
        }
        echo($perf);
    }
} else if ($_POST["ope"] == "verfNcontratoAfi") {

    $consulta = "SELECT * FROM cliente where contrato_cliente='" . $_POST['cod'] . "'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
} else if ($_POST["ope"] == "verfIdentAfil") {

    $consulta = "SELECT * FROM cliente where Cedula_cliente='" . $_POST['cod'] . "' AND Estado_cliente='ACTIVO'";

    $resultado = mysqli_query($link, $consulta);
    if (mysqli_num_rows($resultado) > 0) {
        echo "1";
    }
}

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

mysqli_close($link);
?>