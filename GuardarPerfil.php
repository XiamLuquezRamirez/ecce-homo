<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");


if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO perfiles VALUES(null,'" . $_POST['txt_Nomb'] . "','" . $_POST['ggesserv'] . "',
           '" . $_POST['gesser1'] . "','" . $_POST['gesser2'] . "','" . $_POST['gesser3'] . "','" . $_POST['gesser4'] . "',"
            . "'" . $_POST['gesser5'] . "','" . $_POST['gesConsRetra'] . "','" . $_POST['gopgen'] . "','" . $_POST['gopgen1'] . "',"
            . "'" . $_POST['gopgen2'] . "','" . $_POST['gpargen'] . "','" . $_POST['gpargen1'] . "','" . $_POST['gpargen2'] . "','" . $_POST['gpargen3'] . "',"
            . "'" . $_POST['gpargen4'] . "','" . $_POST['gpargen5'] . "','" . $_POST['gpargen6'] . "','" . $_POST['gpargen7'] . "','" . $_POST['ggestUsu'] . "',"
            . "'" . $_POST['gestUsu1'] . "','" . $_POST['gestUsu2'] . "','" . $_POST['gesAudi'] . "','" . $_POST['gesFact'] . "','" . $_POST['gesCons'] . "',"
            . "'" . $_POST['gesReci'] . "','" . $_POST['gesser6'] . "','" . $_POST['gesser7'] . "','" . $_POST['gesser8'] . "','" . $_POST['gesser9'] . "','" . $_POST['gesConsPago'] . "')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE perfiles SET nomperfil='" . $_POST['txt_Nomb'] . "',ggesserv='" . $_POST['ggesserv'] . "',
           gesser1='" . $_POST['gesser1'] . "',gesser2='" . $_POST['gesser2'] . "',gesser3='" . $_POST['gesser3'] . "',gesser4='" . $_POST['gesser4'] . "',"
            . "gesser5='" . $_POST['gesser5'] . "',gesser6='" . $_POST['gesser6'] . "',gesser7='" . $_POST['gesser7'] . "',gesser8='" . $_POST['gesser8'] . "',gesser9='" . $_POST['gesser9'] . "',"
            . "gesConsRetra='" . $_POST['gesConsRetra'] . "',gesConsPago='" . $_POST['gesConsPago'] . "',gopgen='" . $_POST['gopgen'] . "',gopgen1='" . $_POST['gopgen1'] . "',"
            . "gopgen2='" . $_POST['gopgen2'] . "',gpargen='" . $_POST['gpargen'] . "',gpargen1='" . $_POST['gpargen1'] . "',gpargen2='" . $_POST['gpargen2'] . "',gpargen3='" . $_POST['gpargen3'] . "',"
            . "gpargen4='" . $_POST['gpargen4'] . "',gpargen5='" . $_POST['gpargen5'] . "',gpargen6='" . $_POST['gpargen6'] . "',gpargen7='" . $_POST['gpargen7'] . "',ggestUsu='" . $_POST['ggestUsu'] . "',"
            . "gestUsu1='" . $_POST['gestUsu1'] . "',gestUsu2='" . $_POST['gestUsu2'] . "',gesAudi='" . $_POST['gesAudi'] . "',gesFact='" . $_POST['gesFact'] . "',gesCons='" . $_POST['gesCons'] . "',"
            . "gesReci='" . $_POST['gesReci'] . "' where idperfil='" . $_POST['id'] . "'";
} else {
    $consulta = "DELETE FROM  perfiles WHERE idperfil='" . $_POST['cod'] . "'";
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
            NOW(),'Registro de Perfil " . $_POST['txt_Nomb'] . "' ,'INSERCION', 'GestionsrPerfil.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Perfil " . $_POST['txt_Nomb'] . "' ,'ACTUALIZACION', 'GestionsrPerfil.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Perfil " . $_POST['id'] . "' ,'ELIMINACION', 'GestionsrPerfil.php')";
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