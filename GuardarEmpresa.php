<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO empresa VALUES(null,'" . $_POST['nom'] . "','" . $_POST['iden'] . "',"
            . "'" . $_POST['dir'] . "','" . $_POST['tel'] . "','" . $_POST['cel'] . "','" . $_POST['ema'] . "',"
            . "'" . $_POST['cont'] . "','" . $_POST['cobr'] . "','" . $_POST['afil'] . "',"
            . "'" . $_POST['obs'] . "','ACTIVO','" . $_SESSION['ses_user'] . "','0000-00-00')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  empresa SET Nombre_empresa='" . $_POST['nom'] . "',Nit_empresa='" . $_POST['iden'] . "',"
            . "Direccion_empresa='" . $_POST['dir'] . "',Telefono_empresa='" . $_POST['tel'] . "',Celular_empresa='" . $_POST['cel'] . "',email_empresa='" . $_POST['ema'] . "',"
            . "Contacto_empresa='" . $_POST['cont'] . "',Cobrador_empresa='" . $_POST['cobr'] . "',Fecha_ingreso_empresa='" . $_POST['afil'] . "',"
            . "Comentario_empresa='" . $_POST['obs'] . "' WHERE idEmpresa='" . $_POST['id'] . "'";
} else {
    $consulta = "UPDATE empresa SET Estado_empresa='DESAFILIADA' WHERE idEmpresa='" . $_POST['cod'] . "' ";
}


//echo $consulta;
$qc = mysqli_query($link, $consulta);

if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Clientes " . $_POST['nom'] . "' ,'INSERCION', 'GesClientes.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Clientes " . $_POST['iden'] . "' ,'ACTUALIZACION', 'GesClientes.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Clientes
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GesClientes.php')";
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