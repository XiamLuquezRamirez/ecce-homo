<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");


if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO config_empresa VALUES(null,'" . $_POST['TK_NIT'] . "','" . $_POST['TK_TIPO_NIT'] . "',
           '" . $_POST['TK_RAZON_SOCIAL'] . "','" . $_POST['TK_MUNI'] . "','" . $_POST['TK_DIRECCION'] . "',
           '" . $_POST['TK_TELEFONO'] . "','" . $_POST['TK_FAX'] . "','" . $_POST['TK_EMAIL'] . "')";

//echo $consulta;
} else {
    $consulta = "UPDATE config_empresa SET
                            TK_NIT='" . $_POST['TK_NIT'] . "',
                            TK_TIPO_NIT='" . $_POST['TK_TIPO_NIT'] . "',
                            TK_RAZON_SOCIAL='" . $_POST['TK_RAZON_SOCIAL'] . "',
                            TK_MUNI='" . $_POST['TK_MUNI'] . "',
                            TK_DIRECCION='" . $_POST['TK_DIRECCION'] . "',
                            TK_TELEFONO='" . $_POST['TK_TELEFONO'] . "',
                            TK_FAX='" . $_POST['TK_FAX'] . "',
                            TK_EMAIL='" . $_POST['TK_EMAIL'] . "'
                        WHERE TK_ID='" . $_POST['TK_ID'] . "'";
}

//echo $consulta;
$qc = mysqli_query($link,$consulta);

if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

if ($_POST['acc'] == "1") {


    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Empresa " . $_POST['TK_NIT'] . "-" . $_POST['TK_RAZON_SOCIAL'] . "' ,'INSERCION', 'Config_Empresa.php')";
} else {

    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Empresa " . $_POST['TK_NIT'] . "-" . $_POST['TK_RAZON_SOCIAL'] . "' ,'ACTUALIZACION', 'Config_Empresa.php')";
}



$qc = mysqli_query($link,$consulta);
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
    echo "1";
}

mysqli_close($link);
?>