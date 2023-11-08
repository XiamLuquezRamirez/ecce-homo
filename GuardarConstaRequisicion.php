<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");


//   if ($_POST['acc'] == "1") {
$consulta = "INSERT INTO constancias VALUES(null,'" . $_POST['consec'] . "','" . $_POST['fcreac'] . "',"
        . "'" . $_POST['txt_fecha_Cons'] . "','" . $_POST['txt_Ciuda'] . "','" . $_POST['txt_iden'] . "',"
        . "'" . $_POST['txt_NomCli'] . "','" . $_POST['CbConsigConst'] . "'," . $_POST['txt_vtotalConst'] . ","
        . "'ACTIVO','" . $_POST['txt_DirConst'] . "','" . $_POST['txt_TelCliConst'] . "','" . $_POST['id'] . "')";

//echo $consulta;
$qc = mysqli_query($link, $consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

$id_cosnt = "";
$sql = "SELECT MAX(id_constan) AS id FROM constancias";
$resulsql = mysqli_query($link, $sql);
if (mysqli_num_rows($resulsql) > 0) {
    while ($fila = mysqli_fetch_array($resulsql)) {
        $id_cosnt = $fila["id"];
    }
}
//GUARDAR SERVICIOS

$Tam_Concep = $_POST['Long_DetaCons'];
// echo $Tam_Nece;

for ($i = 1; $i <= $Tam_Concep; $i++) {
    $consulta2 = "";
    $parConcep = explode("//", $_POST['DetallCons' . $i]);

    $consulta2 = "INSERT INTO concep_constancias VALUES(null,'" . $id_cosnt . "','" . $parConcep[0] . "','" . $parConcep[1] . "'," . $parConcep[2] . ",'')";
    //echo $consulta2;
    $qc2 = mysqli_query($link, $consulta2);
    if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }
}


$consulta = "UPDATE consecutivos SET actual='" . $_POST['conse'] . "' WHERE grupo='CONSTANCIAS'";
$qc = mysqli_query($link, $consulta);

if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 3;
}



$consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Constancia " . $_POST['consec'] . "' ,'INSERCION', 'GesRequisicion.php')";

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
    echo "bien/" . $id_cosnt;
}

mysqli_close($link);
?>