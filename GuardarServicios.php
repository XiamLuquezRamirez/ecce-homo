<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");



if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO servicios VALUES(null,'" . $_POST['cod'] . "','" . $_POST['des'] . "'," . $_POST['val'] . ",'" . $_POST['obs'] . "')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  servicios SET cod_serv='" . $_POST['cod'] . "',desc_serv='" . $_POST['des'] . "',val_serv=" . $_POST['val'] . ",obs_serv='" . $_POST['obs'] . "' WHERE id_serv='" . $_POST['id'] . "'";
} else {
    $consulta = "DELETE FROM  servicios WHERE id_serv='" . $_POST['cod'] . "' ";
}


$qc = mysqli_query($link, $consulta);

if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Servicio " . $_POST['des'] . "' ,'INSERCION', 'GesServicios.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Servicio " . $_POST['cod'] . "' ,'ACTUALIZACION', 'GesServicios.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Servicio
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GesServicios.php')";
}



$qc = mysqli_query($link, $consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 2;
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