<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");



if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO noticias VALUES(null,'" . $_POST['txt_Titu'] . "',CURRENT_DATE(),'" . $_POST['txt_desc'] . "','" . $_POST['txt_src_archivo'] . "')";
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  noticias SET titu_not='" . $_POST['txt_Titu'] . "',descr='" . $_POST['txt_desc'] . "',img='" . $_POST['txt_src_archivo'] . "' WHERE id_noticia='" . $_POST['idnoti'] . "'";
} else {
    $consulta = "DELETE FROM  noticias WHERE id_noticia='" . $_POST['cod'] . "' ";
}


// echo $consulta;
$qc = mysqli_query($link, $consulta);

if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Noticia " . $_POST['txt_Titu'] . "' ,'INSERCION', 'GesNoticias.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Noticia " . $_POST['txt_Titu'] . "' ,'ACTUALIZACION', 'GesNoticias.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Noticia " . $_POST['cod'] . "' ,'ELIMINACION', 'GesNoticias.php')";
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