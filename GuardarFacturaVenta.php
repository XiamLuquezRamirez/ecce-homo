<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");


$consulta = "INSERT INTO facturas_venta VALUES(null,'" . $_POST['consec'] . "','" . $_POST['fcreac'] . "',"
        . "'" . $_POST['txt_Ciuda'] . "','" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
        . "'" . $_POST['CbFpago'] . "'," . $_POST['txt_vtotalFact'] . ","
        . "'" . $_POST['txt_valetra'] . "','ACTIVO','" . $_POST['id'] . "','" . $_POST['txt_idCost'] . "')";


//echo $consulta;
$qc = mysqli_query($link, $consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

$id_fact = "";
$sql = "SELECT MAX(id_fact) AS id FROM facturas_venta";
$resulsql = mysqli_query($link, $sql);
if (mysqli_num_rows($resulsql) > 0) {
    while ($fila = mysqli_fetch_array($resulsql)) {
        $id_fact = $fila["id"];
    }
}


$Tam_Concep = $_POST['Long_ConcetFact'];
// echo $Tam_Nece;

for ($i = 1; $i <= $Tam_Concep; $i++) {
    $consulta2 = "";
    $parConcep = explode("//", $_POST['fact' . $i]);

    $consulta2 = "INSERT INTO facturasventas_detalles VALUES(null,'" . $_POST['id'] . "','" . $id_fact . "','" . $parConcep[0] . "'," . $parConcep[1] . ")";
    //echo $consulta2;
    $qc2 = mysqli_query($link, $consulta2);
    if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }
}


$consulta = "UPDATE consecutivos SET actual='" . $_POST['conse'] . "' WHERE grupo='FACTURA'";
$qc = mysqli_query($link, $consulta);

if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 3;
}


$consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Factura de Venta " . $_POST['codigo'] . "' ,'INSERCION', 'GesRequisicion.php')";




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
    echo "bien/" . $id_fact;
}

mysqli_close($link);
?>