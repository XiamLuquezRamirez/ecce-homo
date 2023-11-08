<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");



if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO contrato_arriendo VALUES(null,'" . $_POST['OrdInhum'] . "','" . $_POST['fcreac'] . "',"
            . "'" . $_POST['txt_Ciuda'] . "','" . $_POST['CbCeme'] . "','" . $_POST['txt_boveda'] . "',"
            . "'" . $_POST['txt_jardin'] . "','" . $_POST['txt_zona'] . "','" . $_POST['txt_lote'] . "',"
            . "'" . $_POST['txt_NomMuert'] . "','" . $_POST['CbTiem'] . "','" . $_POST['txt_fecha_Desd'] . "',"
            . "'" . $_POST['txt_fecha_Hast'] . "','" . $_POST['txt_fecha_Fall'] . "','" . $_POST['txt_Fune'] . "',"
            . "'" . $_POST['txt_fecha_sepe'] . "','" . $_POST['txt_Dir'] . ' ' . $_POST['txt_Dirbarrio'] . "','" . $_POST['txt_Tel'] . "','" . $_POST['txt_iden'] . "',"
            . "'" . $_POST['txt_NomCli'] . "','ACTIVO','" . $_POST['txt_obser'] . "','" . $_POST['CbFormMuert'] . "','" . $_POST['CbEstado'] . "')";

    // echo $consulta;

    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {

        $success = 0;

        $error = 1;
    }

    if ($_POST['txt_nuevo'] == "SI") {

        $consulta2 = "INSERT INTO clientes VALUES(null,'" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
                . "'" . $_POST['CbSexo'] . "','0000-00-00','" . $_POST['txt_Dir'] . "',"
                . "'" . $_POST['txt_Tel'] . "','','" . $_POST['txtemail'] . "','ACTIVO','" . $_POST['txt_Dirbarrio'] . "')";

        $qc = mysqli_query($link, $consulta2);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {

            $success = 0;

            $error = 2;
        }
    } else {

        $consulta2 = "UPDATE clientes SET nom_cli='" . $_POST['txt_NomCli'] . "',"
                . "sex_cli='" . $_POST['CbSexo'] . "',dir_cli='" . $_POST['txt_Dir'] . "',"
                . "tel_cli='" . $_POST['txt_Tel'] . "',barrio='" . $_POST['txt_Dirbarrio'] . "',
                email_cli='" . $_POST['txtemail'] . "' WHERE inde_cli='" . $_POST['txt_iden'] . "'";

        $qc = mysqli_query($link, $consulta2);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {

            $success = 0;

            $error = 2;
        }
    }


    $id_cont = "";

    $sql = "SELECT MAX(id_arriendo) AS id FROM contrato_arriendo";

    $resulsql = mysqli_query($link, $sql);

    if (mysqli_num_rows($resulsql) > 0) {

        while ($fila = mysqli_fetch_array($resulsql)) {

            $id_cont = $fila["id"];
        }
    }

    if ($_POST['CbCeme'] == "NUEVO") {

        $consulta3 = "UPDATE consecutivos SET actual='" . $_POST['cons'] . "' WHERE grupo='CONARRINUEVO'";
    } else {

        $consulta3 = "UPDATE consecutivos SET actual='" . $_POST['cons'] . "' WHERE grupo='CONARRIECCE'";
    }

    mysqli_query($link, $consulta3);

    $consulta4 = "INSERT INTO prorroga_arriendo VALUES(null,'" . $id_cont . "','" . $_POST['CbTiem'] . "',"
            . "'" . $_POST['txt_fecha_Desd'] . "','" . $_POST['txt_fecha_Hast'] . "','0.00','')";

//echo $consulta;
    $qc = mysqli_query($link, $consulta4);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
} else if ($_POST['acc'] == "2") {

    $consulta = "UPDATE contrato_arriendo SET OrdInhum='" . $_POST['OrdInhum'] . "',fec_crea='" . $_POST['fcreac'] . "',"
            . "ciuda='" . $_POST['txt_Ciuda'] . "',cemen='" . $_POST['CbCeme'] . "',boveda='" . $_POST['txt_boveda'] . "',"
            . "jardin='" . $_POST['txt_jardin'] . "',zona='" . $_POST['txt_zona'] . "',lote='" . $_POST['txt_lote'] . "',"
            . "muerto='" . $_POST['txt_NomMuert'] . "',tiempo='" . $_POST['CbTiem'] . "',desde='" . $_POST['txt_fecha_Desd'] . "',"
            . "hasta='" . $_POST['txt_fecha_Hast'] . "',fec_falle='" . $_POST['txt_fecha_Fall'] . "',funeraria='" . $_POST['txt_Fune'] . "',"
            . "direc='" . $_POST['txt_Dir'] . ' ' . $_POST['txt_Dirbarrio'] . "',telef='" . $_POST['txt_Tel'] . "',ced_cli='" . $_POST['txt_iden'] . "',"
            . "nom_cli='" . $_POST['txt_NomCli'] . "',observ='" . $_POST['txt_obser'] . "', form_muerte='" . $_POST['CbFormMuert'] . "',estado_contrato='" . $_POST['CbEstado'] . "' WHERE id_arriendo='" . $_POST['id'] . "'";

    // echo $consulta;

    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {

        $success = 0;

        $error = 1;
    }

    if ($_POST['txt_nuevo'] == "SI") {

        $consulta2 = "INSERT INTO clientes VALUES(null,'" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
                . "'" . $_POST['CbSexo'] . "','0000-00-00','" . $_POST['txt_Dir'] . "',"
                . "'" . $_POST['txt_Tel'] . "','','" . $_POST['txtemail'] . "','ACTIVO','" . $_POST['txt_Dirbarrio'] . "')";

        $qc = mysqli_query($link, $consulta2);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {

            $success = 0;

            $error = 2;
        }
    } else {

        $consulta2 = "UPDATE clientes SET nom_cli='" . $_POST['txt_NomCli'] . "',"
                . "sex_cli='" . $_POST['CbSexo'] . "',dir_cli='" . $_POST['txt_Dir'] . "',"
                . "tel_cli='" . $_POST['txt_Tel'] . "',barrio='" . $_POST['txt_Dirbarrio'] . "',email_cli='" . $_POST['txtemail'] . "' WHERE inde_cli='" . $_POST['txt_iden'] . "'";

        $qc = mysqli_query($link, $consulta2);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {

            $success = 0;

            $error = 2;
        }
    }

    $id_cont = $_POST['id'];
} else {
    
    $id_cont=$_POST['cod']; 

    $flag = "s";
    $sql = "SELECT * FROM constanciasarriendo where cont_arriendo='" . $_POST['cod'] . "'";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        $flag = "n";
    }

    $sql = "SELECT * FROM facturas_arriendo where arri='" . $_POST['cod'] . "'";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        $flag = "n";
    }

    if ($flag == "s") {
        $consulta = "UPDATE contrato_arriendo SET estado='DELETE' WHERE id_arriendo='" . $_POST['cod'] . "' ";
        $qc = mysqli_query($link, $consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }
    } else {
        echo "no";
    }
}

if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,

            log_hora, log_accion, log_tipo, log_interfaz) VALUES

            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),

            NOW(),'Registro de Contrato de Arriendo " . $_POST['OrdInhum'] . "' ,'INSERCION', 'GesRequisicion.php')";
} else if ($_POST['acc'] == "2") {

    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,

            log_hora, log_accion, log_tipo, log_interfaz) VALUES

            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),

            NOW(),'Actualizacion de Contrato de Arriendo " . $_POST['OrdInhum'] . "' ,'ACTUALIZACION', 'GesRequisicion.php')";
} else {

    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,

            log_hora, log_accion, log_tipo, log_interfaz) VALUES

            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),

            NOW(),'Eliminacion de Contrato de Arriendo

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

    echo "bien/" . $id_cont;
}

mysqli_close($link);
?>