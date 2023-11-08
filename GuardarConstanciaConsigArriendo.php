<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");


$consulta = "INSERT INTO constanciasarriendo VALUES(null,'" . $_POST['consec'] . "','" . $_POST['fcreac'] . "',"
        . "'" . $_POST['txt_fecha_Cons'] . "','" . $_POST['txt_Ciuda'] . "','" . $_POST['txt_iden'] . "',"
        . "'" . $_POST['txt_NomCli'] . "','" . $_POST['CbConsig'] . "'," . $_POST['txt_vtotal'] . ",'ACTIVO','" . $_POST['txt_Concep'] . "','" . $_POST['id'] . "','" . $_POST['txt_DirCli'] . "','" . $_POST['txt_TelCli'] . "')";


//echo $consulta;
$qc = mysqli_query($link, $consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

$id_cosnt = "";
$sql = "SELECT MAX(id_constan) AS id FROM constanciasarriendo";
$resulsql = mysqli_query($link, $sql);
if (mysqli_num_rows($resulsql) > 0) {
    while ($fila = mysqli_fetch_array($resulsql)) {
        $id_cosnt = $fila["id"];
    }
}


$consulta = "UPDATE consecutivos SET actual='" . $_POST['conse'] . "' WHERE grupo='CONSTANCIAS'";
$qc = mysqli_query($link, $consulta);

if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 3;
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