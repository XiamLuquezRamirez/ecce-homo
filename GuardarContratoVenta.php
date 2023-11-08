<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");



if ($_POST['acc'] == "1") {
    $saldo = "";
    if ($_POST['CbFpago'] == "CUOTAS") {
        $saldo = $_POST['txt_Prec'];
    } else {
        $saldo = "0";
    }
    $consulta = "INSERT INTO contrato_venta VALUES(null,'" . $_POST['PedContra'] . "','" . $_POST['fcreac'] . "',"
            . "'" . $_POST['txt_Ciuda'] . "','" . $_POST['CbFpago'] . "','" . $_POST['txt_Cuota'] . "',"
            . "" . $_POST['txt_Prec'] . "," . $_POST['txt_CuIni'] . "," . $_POST['txt_CuMes'] . ",'" . $_POST['txt_iden'] . "',"
            . "'" . $_POST['txt_NomCli'] . "','ACTIVO'," . $_POST['txt_Prec'] . ",'" . $_POST['txt_obser'] . "')";


    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_Ven = "";
    $sql = "SELECT MAX(id_contr) AS id FROM contrato_venta";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_Ven = $fila["id"];
        }
    }


    if ($_POST['txt_nuevo'] == "SI") {

        $consulta2 = "INSERT INTO clientes VALUES(null,'" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
                . "'" . $_POST['CbSexo'] . "','0000-00-00','" . $_POST['txt_DirCli'] . "',"
                . "'" . $_POST['txt_TelCli'] . "','','" . $_POST['txtemail'] . "','ACTIVO','" . $_POST['txt_Dirbarrio'] . "')";

        $qc = mysqli_query($link, $consulta2);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
        // echo $consulta2;
    } else {
        $consulta2 = "UPDATE clientes SET nom_cli='" . $_POST['txt_NomCli'] . "',"
                . "sex_cli='" . $_POST['CbSexo'] . "',dir_cli='" . $_POST['txt_Dir'] . "',"
                . "tel_cli='" . $_POST['txt_TelCli'] . "',barrio='" . $_POST['txt_Dirbarrio'] . "',email_cli='" . $_POST['txtemail'] . "' WHERE inde_cli='" . $_POST['txt_iden'] . "'";
        
        $qc = mysqli_query($link, $consulta2);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {

            $success = 0;

            $error = 2;
        }
    }

    /////GUARDAR PERSONAS////////

    $Tam_Nece = $_POST['Long_Perso'];
    // echo $Tam_Nece;

    for ($i = 1; $i <= $Tam_Nece; $i++) {
        $consulta2 = "";
        $parPerso = explode("//", $_POST['Perso' . $i]);

        $consulta2 = "INSERT INTO personas_contrato_venta VALUES(null,'" . $id_Ven . "','" . $parPerso[0] . "','" . $parPerso[1] . "','" . $parPerso[2] . "','ACTIVO')";
        // echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 3;
        }
    }

    /////GUARDAR LOTES////////

    $Tam_Lote = $_POST['Long_Lote'];
    // echo $Tam_Nece;

    for ($i = 1; $i <= $Tam_Lote; $i++) {
        $consulta2 = "";
        $parLotes = explode("//", $_POST['Lotes' . $i]);

        $consulta2 = "INSERT INTO venta_deta_lote VALUES(null,'" . $id_Ven . "','" . $parLotes[0] . "','" . $parLotes[1] . "','" . $parLotes[2] . "','" . $parLotes[3] . "'," . $parLotes[4] . ",'" . $parLotes[5] . "','" . $parLotes[6] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 4;
        }
    }
    /////GUARDAR LOTES////////

    $Tam_Osa = $_POST['Long_Osa'];
    // echo $Tam_Nece;

    for ($i = 1; $i <= $Tam_Osa; $i++) {
        $consulta2 = "";
        $parOsario = explode("//", $_POST['Osario' . $i]);

        $consulta2 = "INSERT INTO venta_deta_osario VALUES(null,'" . $id_Ven . "','" . $parOsario[0] . "','" . $parOsario[1] . "','" . $parOsario[2] . "'," . $parOsario[3] . ",'" . $parOsario[4] . "','" . $parOsario[5] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 5;
        }
    }

    $consulta = "UPDATE consecutivos SET actual='" . $_POST['cons'] . "' WHERE grupo='CONVENTA'";
    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 6;
    }
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE contrato_venta SET pedido_contr='" . $_POST['PedContra'] . "',fecha_vent='" . $_POST['fcreac'] . "',"
            . "ciudad_vent='" . $_POST['txt_Ciuda'] . "',fpago_vent='" . $_POST['CbFpago'] . "',cuota_vent='" . $_POST['txt_Cuota'] . "',"
            . "precios_vent=" . $_POST['txt_Prec'] . ",valcuini_vent=" . $_POST['txt_CuIni'] . ",valcumes_vent=" . $_POST['txt_CuMes'] . ",ident_vent='" . $_POST['txt_iden'] . "',"
            . "nombre_venta='" . $_POST['txt_NomCli'] . "',observ='" . $_POST['txt_obser'] . "' WHERE id_contr='" . $_POST['id'] . "'";
    //    echo $consulta;
    $id_Ven = $_POST['id'];
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    //GUARDAR SERVICIOS

    $Tam_Nece = $_POST['Long_Perso'];
    // echo $Tam_Nece;

    $consulta = "DELETE FROM personas_contrato_venta WHERE idcontr_persocont='" . $_POST['id'] . "'";
    //  echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }

    for ($i = 1; $i <= $Tam_Nece; $i++) {
        $consulta2 = "";
        $parPerso = explode("//", $_POST['Perso' . $i]);

        $consulta2 = "INSERT INTO personas_contrato_venta VALUES(null,'" . $_POST['id'] . "','" . $parPerso[0] . "','" . $parPerso[1] . "','" . $parPerso[2] . "','ACTIVO')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 3;
        }
    }


    /////GUARDAR LOTES////////

    $Tam_Lote = $_POST['Long_Lote'];
    // echo $Tam_Nece;

    $consulta = "DELETE FROM venta_deta_lote WHERE id_venta='" . $_POST['id'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 4;
    }


    for ($i = 1; $i <= $Tam_Lote; $i++) {
        $consulta2 = "";
        $parLotes = explode("//", $_POST['Lotes' . $i]);

        $consulta2 = "INSERT INTO venta_deta_lote VALUES(null,'" . $id_Ven . "','" . $parLotes[0] . "','" . $parLotes[1] . "','" . $parLotes[2] . "','" . $parLotes[3] . "'," . $parLotes[4] . ",'" . $parLotes[5] . "','" . $parLotes[6] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 5;
        }
    }
    /////GUARDAR LOTES////////

    $Tam_Osa = $_POST['Long_Osa'];
    // echo $Tam_Nece;
    $consulta = "DELETE FROM venta_deta_osario WHERE id_venta='" . $_POST['id'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 6;
    }


    for ($i = 1; $i <= $Tam_Osa; $i++) {
        $consulta2 = "";
        $parOsario = explode("//", $_POST['Osario' . $i]);

        $consulta2 = "INSERT INTO venta_deta_osario VALUES(null,'" . $id_Ven . "','" . $parOsario[0] . "','" . $parOsario[1] . "','" . $parOsario[2] . "'," . $parOsario[3] . ",'" . $parOsario[4] . "','" . $parOsario[5] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 7;
        }
    }

    if ($_POST['txt_nuevo'] == "SI") {

        $consulta2 = "INSERT INTO clientes VALUES(null,'" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
                . "'" . $_POST['CbSexo'] . "','0000-00-00','" . $_POST['txt_DirCli'] . "',"
                . "'" . $_POST['txt_TelCli'] . "','','" . $_POST['txtemail'] . "','ACTIVO','" . $_POST['txt_Dirbarrio'] . "')";

        $qc = mysqli_query($link, $consulta2);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 8;
        }
        //echo $consulta2;
    } else {
        $consulta2 = "UPDATE clientes SET nom_cli='" . $_POST['txt_NomCli'] . "',"
                . "sex_cli='" . $_POST['CbSexo'] . "',dir_cli='" . $_POST['txt_DirCli'] . "',"
                . "tel_cli='" . $_POST['txt_TelCli'] . "',barrio='" . $_POST['txt_Dirbarrio'] . "',email_cli='" . $_POST['txtemail'] . "' WHERE inde_cli='" . $_POST['txt_iden'] . "'";
//echo $consulta2;
        $qc = mysqli_query($link, $consulta2);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {

            $success = 0;

            $error = 8;
        }
    }
} else {
    $id_Ven = $_POST['cod'];
    $flag = "s";
    $sql = "SELECT * FROM detalles_venta where contrato='" . $_POST['cod'] . "'";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        $flag = "n";
    }

    if ($flag == "s") {
        $consulta = "UPDATE contrato_venta SET estado='DELETE' WHERE id_contr='" . $_POST['cod'] . "' ";

        //   echo $consulta;
        $qc = mysqli_query($link, $consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }
    } else {
        echo "n";
    }
}





if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Requisicion " . $_POST['codigo'] . "' ,'INSERCION', 'GesRequisicion.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Requisicion " . $_POST['id'] . "' ,'ACTUALIZACION', 'GesRequisicion.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Requisicion
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GesRequisicion.php')";
}



$qc = mysqli_query($link, $consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 4;
}

if ($success == 0) {
    mysqli_query($link, "ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link, "COMMIT");
    echo "bien/" . $id_Ven;
}

mysqli_close($link);
?>