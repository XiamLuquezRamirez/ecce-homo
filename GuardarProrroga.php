<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");


$consulta = "INSERT INTO prorroga_arriendo VALUES(null,'" . $_POST['txt_idcont'] . "','" . $_POST['CbTiem'] . "',"
        . "'" . $_POST['txt_fecha_Desd'] . "','" . $_POST['txt_fecha_Hast'] . "','" . $_POST['vpro'] . "','" . $_POST['n_recibo'] . "')";

//echo $consulta;
$qc = mysqli_query($link, $consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

$id_pro = "";

$sql = "SELECT MAX(id) AS id FROM prorroga_arriendo";

$resulsql = mysqli_query($link, $sql);

if (mysqli_num_rows($resulsql) > 0) {

    while ($fila = mysqli_fetch_array($resulsql)) {

        $id_pro = $fila["id"];
    }
}

$consulta = "UPDATE contrato_arriendo SET hasta='" . $_POST['txt_fecha_Hast'] . "' WHERE id_arriendo='" . $_POST['txt_idcont'] . "'";

$qc = mysqli_query($link, $consulta);
if ($success == 0) {
    mysqli_query($link, "ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link, "COMMIT");
    echo "bien-" . $id_pro;
}

mysqli_close($link);
?>