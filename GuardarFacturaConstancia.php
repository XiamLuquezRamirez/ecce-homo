<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");


$consulta = "INSERT INTO facturas_costancias VALUES(null,'" . $_POST['consec'] . "','" . $_POST['fcreac'] . "',"
        . "'" . $_POST['txt_Ciuda'] . "','" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
        . "'" . $_POST['CbFpago'] . "'," . $_POST['txt_vtotalFact'] . ",'" . $_POST['txt_valetra'] . "',"
        . "'ACTIVO','" . $_POST['id'] . "','" . $_POST['txt_DirFact'] . "','" . $_POST['txt_TelCliFact'] . "')";


//echo $consulta;
$qc = mysqli_query($link, $consulta);
if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
    $success = 0;
    $error = 1;
}

$id_cosnt = "";
$sql = "SELECT MAX(id_fact) AS id FROM facturas_costancias";
$resulsql = mysqli_query($link, $sql);
if (mysqli_num_rows($resulsql) > 0) {
    while ($fila = mysqli_fetch_array($resulsql)) {
        $id_cosnt = $fila["id"];
    }
}
//GUARDAR SERVICIOS

$Tam_Concep = $_POST['Long_Deta'];
// echo $Tam_Nece;

for ($i = 1; $i <= $Tam_Concep; $i++) {
    $consulta2 = "";
    $parConcep = explode("//", $_POST['Detall' . $i]);

    $consulta2 = "INSERT INTO detalles_facturaconst VALUES(null,'" . $id_cosnt . "','" . $parConcep[0] . "','" . $parConcep[1] . "','" . $parConcep[2] . "'," . $parConcep[3] . ")";
//    echo $consulta2;
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
            NOW(),'Registro de Factura " . $_POST['consec'] . "' ,'INSERCION', 'GesConstaciasConsig.php')";


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