<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");



if ($_POST['acc'] == "1") {

    $consulta = "INSERT INTO galerias VALUES(null,'" . $_POST['txt_Titu'] . "','" . str_replace(' ', '_', $_POST['txt_Titu']) . "',CURRENT_DATE(),'" . $_POST['txt_desc'] . "')";
  $qc = mysqli_query($link, $consulta);

  if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
    mkdir("galerias/" . str_replace(' ', '_', $_POST['txt_Titu']) . "", 0755);
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  galerias SET titulo='" . $_POST['txt_Titu'] . "',obser='" . $_POST['txt_desc'] . "' WHERE id_galeria='" . $_POST['id'] . "'";
  $qc = mysqli_query($link, $consulta);

   if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
} else {

    $consulta2 = "select * from imagenes where galeria='" . $_POST['cod'] . "'";

    $resultado2 = mysqli_query($link,$consulta2);
    if (mysqli_num_rows($resultado2) > 0) {
        echo 'no';
    } else {
        $consulta = "DELETE FROM  galerias WHERE id_galeria='" . $_POST['cod'] . "' ";
      $qc = mysqli_query($link, $consulta);
          if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }
    }
}




//echo $consulta;


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