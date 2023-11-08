<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");


$consulta = "INSERT INTO constanciasventas VALUES(null,'" . $_POST['consec'] . "','" . $_POST['fcreac'] . "',"
        . "'" . $_POST['txt_fecha_Cons'] . "','" . $_POST['txt_Ciuda'] . "','" . $_POST['txt_iden'] . "',"
        . "'" . $_POST['txt_NomCli'] . "','" . $_POST['CbConsig'] . "',"
        . "'ACTIVO'," . $_POST['ValTot'] . ",'" . $_POST['id'] . "')";


//echo $consulta;
$qc = mysqli_query($link, $consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

$id_cosnt = "";
$sql = "SELECT MAX(id_constan) AS id FROM constanciasventas";
$resulsql = mysqli_query($link, $sql);
if (mysqli_num_rows($resulsql) > 0) {
    while ($fila = mysqli_fetch_array($resulsql)) {
        $id_cosnt = $fila["id"];
    }
}

$Tam_Concep = $_POST['Long_ConcetCost'];
// echo $Tam_Nece;

for ($i = 1; $i <= $Tam_Concep; $i++) {
    $consulta2 = "";
    $parConcep = explode("//", $_POST['consta' . $i]);

    $consulta2 = "INSERT INTO constanciasventas_detalles VALUES(null,'" . $_POST['id'] . "','" . $id_cosnt . "','" . $parConcep[0] . "'," . $parConcep[1] . ")";
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