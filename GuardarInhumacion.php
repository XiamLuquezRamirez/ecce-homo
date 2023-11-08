<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");

$id_ord = "";

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO inhumaciones VALUES(null,'" . $_POST['codigo'] . "','" . $_POST['fcreac'] . "',"
            . "'" . $_POST['txt_iden'] . "','" . $_POST['txt_Ciuda'] . "','" . $_POST['txt_NomFalle'] . "',"
            . "'" . $_POST['txt_fecha_fall'] . "','" . $_POST['txt_fecha_nac'] . "','" . $_POST['txt_fecha_Cere'] . "',"
            . "'" . $_POST['CbFune'] . "','" . $_POST['txt_NomJefe'] . "','ACTIVO','" . $_POST['texubi'] . "',"
            . "'" . $_POST['txt_obser'] . "','" . $_POST['txt_nuevo'] . "','" . $_POST['CbCeme'] . "')";


    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }


    $sql = "SELECT MAX(id) AS id FROM inhumaciones";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_ord = $fila["id"];
        }
    }
    if ($_POST['txt_nuevo'] == "SI") {
        $consulta = "insert into ocup_lot_osaid_old VALUES(null, '" . $_POST['txt_Ubic'] . "',"
                . "'" . $_POST['txt_NomFalle'] . "','" . $_POST['fcreac'] . "','" . $_POST['CbPosic'] . "',"
                . "'" . $_POST['txt_obser'] . "','" . $id_ord . "')";
    } else {
        $consulta = "insert into ocup_lot_osaid VALUES(null, '" . $_POST['ubi'] . "','" . $_POST['idvent'] . "',"
                . "'" . $_POST['txt_NomFalle'] . "','" . $_POST['fcreac'] . "','" . $_POST['CbPosic'] . "',"
                . "'" . $_POST['tip'] . "','" . $_POST['txt_obser'] . "','" . $id_ord . "')";
    }


    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }


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
    }
} else if ($_POST['acc'] == "2") {

    $id_ord = $_POST['id'];
    $consulta = "UPDATE inhumaciones SET conse='" . $_POST['codigo'] . "',fecha='" . $_POST['fcreac'] . "',"
            . "titular='" . $_POST['txt_iden'] . "',ciudad='" . $_POST['txt_Ciuda'] . "',falle='" . $_POST['txt_NomFalle'] . "',"
            . "fec_falle='" . $_POST['txt_fecha_fall'] . "',fec_naci='" . $_POST['txt_fecha_nac'] . "',fec_cere='" . $_POST['txt_fecha_Cere'] . "',"
            . "funeraria='" . $_POST['CbFune'] . "',jefe_ceme='" . $_POST['txt_NomJefe'] . "',ubic='" . $_POST['texubi'] . "',obser='" . $_POST['txt_obser'] . "',cementerio='" . $_POST['CbCeme'] . "' WHERE id='" . $_POST['id'] . "'";

    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
} else {
    
    $id_ord=$_POST['cod'] ;
    $consulta = "UPDATE inhumaciones SET estado='DELETE' WHERE id='" . $_POST['cod'] . "'";
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $consulta = "DELETE FROM ocup_lot_osaid WHERE id_inhum='" . $_POST['cod'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }
}



if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Inhumacion " . $_POST['codigo'] . "' ,'INSERCION', 'GesOrdenInhumacion.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Inhumacion " . $_POST['codigo'] . "' ,'ACTUALIZACION', 'GesOrdenInhumacion.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Inhumacion
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GesOrdenInhumacion.php')";
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
?>