<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");



if ($_POST['accBenef'] == "1") {
    $consulta = "INSERT INTO beneficiario VALUES(null,'" . $_POST['txt_NombreBenef'] . "','" . $_POST['txt_ApelliBenef'] . "',"
            . "'" . $_POST['CbParentescoBenef'] . "','" . $_POST['txt_FecNacBenef'] . "','" . $_POST['CbEstadoBenefi'] . "',"
            . "'0000-00-00','','" . $_POST['text_idAfi'] . "','" . $_SESSION['ses_user'] . "',"
            . "'" . $_POST['idmepre'] . "','0000-00-00','" . $_POST['CbTbenefi'] . "','" . $_POST['txt_ciuResi'] . "')";
} else if ($_POST['accBenef'] == "2") {
    $consulta = "UPDATE  beneficiario SET nombre_beneficiario='" . $_POST['txt_NombreBenef'] . "',apellido_beneficiario='" . $_POST['txt_ApelliBenef'] . "',"
            . "parentesco_beneficiario='" . $_POST['CbParentescoBenef'] . "',edad_beneficiario='" . $_POST['txt_FecNacBenef'] . "',"
            . "estado_beneficiario='" . $_POST['CbEstadoBenefi'] . "',tipo_benefi='" . $_POST['CbTbenefi'] . "',ciudad_beneficiario='" . $_POST['txt_ciuResi'] . "' WHERE idBeneficiario='" . $_POST['text_idBenef'] . "'";
} else {
    $consulta = "DELETE FROM beneficiario  WHERE idBeneficiario='" . $_POST['cod'] . "' ";
}


//echo $consulta;
$qc = mysqli_query($link, $consulta);

if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

if ($_POST['accBenef'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Clientes " . $_POST['txt_NombreBenef'] . "' ,'INSERCION', 'GesClientes.php')";
} else if ($_POST['accBenef'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Clientes " . $_POST['txt_NombreBenef'] . "' ,'ACTUALIZACION', 'GesClientes.php')";
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