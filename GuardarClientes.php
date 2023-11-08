<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO clientes VALUES(null,'" . $_POST['iden'] . "','" . $_POST['nom'] . "',"
            . "'" . $_POST['sex'] . "','" . $_POST['fec'] . "','" . $_POST['dir'] . "',"
            . "'" . $_POST['tel'] . "','" . $_POST['obs'] . "','" . $_POST['ema'] . "','ACTIVO','')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  clientes SET inde_cli='" . $_POST['iden'] . "',nom_cli='" . $_POST['nom'] . "',"
            . "sex_cli='" . $_POST['sex'] . "',fec_cli='" . $_POST['fec'] . "',"
            . "dir_cli='" . $_POST['dir'] . "',tel_cli='" . $_POST['tel'] . "',obs_cli='" . $_POST['obs'] . "',"
            . "email_cli='" . $_POST['ema'] . "' WHERE id_cli='" . $_POST['id'] . "'";
} else {
    $consulta = "UPDATE clientes SET estado='ELIMINADO' WHERE id_cli='" . $_POST['cod'] . "' ";
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