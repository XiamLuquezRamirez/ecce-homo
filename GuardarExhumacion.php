<?php

session_start();
include "Conectar.php";

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");

$id_ord = "";

if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO exhumaciones VALUES(null,'" . $_POST['codigo'] . "','" . $_POST['fcreac'] . "',"
        . "'" . $_POST['txt_iden'] . "','" . $_POST['txt_Ciuda'] . "','" . $_POST['txt_NomFalle'] . "',"
        . "'" . $_POST['TipProp'] . "','" . $_POST['idvent'] . "','" . $_POST['ubi'] . "',"
        . "'" . $_POST['texubi'] . "','" . $_POST['CbPosic'] . "','" . $_POST['tip'] . "',"
        . "'" . $_POST['txt_fecha_Exh'] . "','" . $_POST['txt_NomAutori'] . "','" . $_POST['txt_FecInhu'] . "',"
        . "'" . $_POST['txt_obser'] . "','" . $_POST['txt_NomJefe'] . "','ACTIVO','" . $_POST['Cbcemen'] . "',"
        . "'" . $_POST['txt_obser'] . "','" . $_POST['txt_nuevo'] . "','" . $_POST['txt_DirAut'] . "',"
        . "'" . $_POST['txt_TelAut'] . "','" . $_POST['txt_Trasla'] . "')";

    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $sql = "SELECT MAX(id) AS id FROM exhumaciones";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_ord = $fila["id"];
        }
    }

    $consulta = "UPDATE consecutivos SET actual='" . $_POST['conse'] . "' WHERE grupo='EXHUMACION'";
    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 3;
    }

    if ($_POST['TipProp'] == "Arriendo") {
        $consulta = "UPDATE contrato_arriendo SET estado_contrato='Terminado',exhumacion='' WHERE id_arriendo=" . $_POST['txt_id_contrato'];
        $qc = mysqli_query($link, $consulta);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 4;
        }
 
    }

    if ($_POST['txt_nuevo'] == "SI") {
        $consulta2 = "INSERT INTO clientes VALUES(null,'" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
            . "' ','0000-00-00','" . $_POST['txt_Dir'] . "',"
            . "'" . $_POST['txt_Tel'] . "','','','ACTIVO','')";
        // echo $consulta2;
        $qc = mysqli_query($link, $consulta2);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 5;
        }
    }
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE exhumaciones SET conse='" . $_POST['codigo'] . "',fecha='" . $_POST['fcreac'] . "',"
        . "titular='" . $_POST['txt_iden'] . "',ciudad='" . $_POST['txt_Ciuda'] . "',muerto='" . $_POST['txt_NomFalle'] . "',"
        . "tprop='" . $_POST['TipProp'] . "',idcont='" . $_POST['idvent'] . "',idubi='" . $_POST['ubi'] . "',"
        . "ubi='" . $_POST['texubi'] . "',posi='" . $_POST['CbPosic'] . "',tip='" . $_POST['tip'] . "',"
        . "fechexhu='" . $_POST['txt_fecha_Exh'] . "',autori='" . $_POST['txt_NomAutori'] . "',fecinhuma='" . $_POST['txt_FecInhu'] . "',"
        . "observa='" . $_POST['txt_obser'] . "',jefe='" . $_POST['txt_NomJefe'] . "',"
        . "cementerio='" . $_POST['Cbcemen'] . "',obser='" . $_POST['txt_obser'] . "',dir_aut='" . $_POST['txt_DirAut'] . "',"
        . "tel_aut='" . $_POST['txt_TelAut'] . "',txt_Trasla='" . $_POST['txt_Trasla'] . "' WHERE id='" . $_POST['id'] . "'";

    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_ord = $_POST['id'];

    if ($_POST['txt_nuevo'] == "SI") {
        $consulta2 = "INSERT INTO clientes VALUES(null,'" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
            . "' ','0000-00-00','" . $_POST['txt_Dir'] . "',"
            . "'" . $_POST['txt_Tel'] . "','','','ACTIVO','')";
        // echo $consulta2;
        $qc = mysqli_query($link, $consulta2);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 4;
        }
    } else {

        $consulta2 = "UPDATE clientes SET nom_cli='" . $_POST['txt_NomCli'] . "',"
            . "dir_cli='" . $_POST['txt_Dir'] . "',"
            . "tel_cli='" . $_POST['txt_Tel'] . "' WHERE inde_cli='" . $_POST['txt_iden'] . "'";

        $qc = mysqli_query($link, $consulta2);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {

            $success = 0;

            $error = 2;
        }
    }
} else {
    $consulta = "UPDATE exhumaciones SET estado='DELETE' WHERE id='" . $_POST['cod'] . "'";
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
}

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Inhumacion " . $_POST['codigo'] . "' ,'INSERCION', 'GesOrdenExhumacion.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Inhumacion " . $_POST['codigo'] . "' ,'ACTUALIZACION', 'GesOrdenExhumacion.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Inhumacion
            " . $_POST['id'] . "' ,'ELIMINACION', 'GesOrdenExhumacion.php')";
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
    echo "bien/" . $id_ord;
}

mysqli_close($link);
