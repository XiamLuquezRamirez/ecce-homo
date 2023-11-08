<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");
$flag = '0';



if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO funerarias VALUES(null,'" . $_POST['cod'] . "','" . $_POST['nit'] . "','" . $_POST['des'] . "','" . $_POST['dir'] . "','" . $_POST['tel'] . "','" . $_POST['obs'] . "')";
    // echo $consulta;
    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  funerarias SET cod_fune='" . $_POST['cod'] . "',nit='" . $_POST['nit'] . "', dir='" . $_POST['dir'] . "',tel='" . $_POST['tel'] . "',nom_fune='" . $_POST['des'] . "',obser_fune='" . $_POST['obs'] . "' WHERE id_fune='" . $_POST['id'] . "'";
    // echo $consulta;
    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
} else {

    $sql = "SELECT * FROM contrato_arriendo WHERE funeraria='" . $_POST['cod'] . "'";

    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        $flag = '1';
    }

    $sql = "SELECT * FROM inhumaciones WHERE funeraria='" . $_POST['cod'] . "'";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        $flag = '1';
    }

    if ($flag == "0") {
        $consulta = "DELETE FROM  funerarias WHERE id_fune='" . $_POST['cod'] . "' ";
        // echo $consulta;
        $qc = mysqli_query($link, $consulta);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }
    } else {
        echo 'no';
    }
}


if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Funeraria " . $_POST['des'] . "' ,'INSERCION', 'GesFunerarias.php')";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Funeraria " . $_POST['cod'] . "' ,'ACTUALIZACION', 'GesFunerarias.php')";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }
} else {
    if ($flag == "0") {
        $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Funeraria
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GesFunerarias.php')";

        $qc = mysqli_query($link, $consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
    }
}




if ($success == 0) {
    mysqli_query($link, "ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link, "COMMIT");
    echo "bien";
}

mysqli_close($link);
?>