<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");


if ($_POST['accAfi'] == "1") {
    $consulta = "INSERT INTO cliente VALUES(null,'" . $_POST['txt_NombreAfi'] . "','" . $_POST['txt_ApelliAfi'] . "',"
            . "'" . $_POST['txt_IdentiAfi'] . "','" . $_POST['txt_FecAfil'] . "','" . $_POST['txt_DirAfi'] . "',"
            . "'" . $_POST['txt_TelAfi'] . "','" . $_POST['txt_CelAfi'] . "','" . $_POST['txt_BarrAfi'] . "',"
            . "'" . $_POST['txt_emailAfi'] . "','" . $_POST['idmepre'] . "','" . $_POST['CbTipPlan'] . "',"
            . "'" . $_POST['txt_NContratoAfi'] . "','ACTIVO','" . $_POST['valcuota'] . "',"
            . "'" . $_SESSION['ses_user'] . "','0000-00-00','" . $_POST['CbTipClien'] . "',"
            . "'" . $_POST['txt_FecNac'] . "','" . $_POST['CbSexo'] . "','" . $_POST['CbTipVinc'] . "',"
            . "'" . $_POST['txt_Empre'] . "','" . $_POST['txt_FecCont'] . "','" . $_POST['txt_Asesor'] . "')";
    //echo $consulta;
    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }


    $sql = "SELECT MAX(idCliente) AS id FROM cliente";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_cli = $fila["id"];
        }
    }
} else if ($_POST['accAfi'] == "2") {
    $consulta = "UPDATE  cliente SET Nombres_cliente='" . $_POST['txt_NombreAfi'] . "',Apellidos_cliente='" . $_POST['txt_ApelliAfi'] . "',"
            . "Cedula_cliente='" . $_POST['txt_IdentiAfi'] . "',Fecha_ingreso_cliente='" . $_POST['txt_FecAfil'] . "',direccion_cliente='" . $_POST['txt_DirAfi'] . "',"
            . "telefono_cliente='" . $_POST['txt_TelAfi'] . "',celular_cliente='" . $_POST['txt_CelAfi'] . "',barrio_cliente='" . $_POST['txt_BarrAfi'] . "',"
            . "correo_cliente='" . $_POST['txt_emailAfi'] . "',idEmpresa_cliente='" . $_POST['idmepre'] . "',idPlan_cliente='" . $_POST['CbTipPlan'] . "',"
            . "contrato_cliente='" . $_POST['txt_NContratoAfi'] . "',Cuota_cliente='" . $_POST['valcuota'] . "',Estado_cliente='" . $_POST['CbEstado'] . "',tipo_cliente='" . $_POST['CbTipClien'] . "',"
            . "fecha_nacimiento='" . $_POST['txt_FecNac'] . "',sexo='" . $_POST['CbSexo'] . "',tipo_vinculacion='" . $_POST['CbTipVinc'] . "',"
            . "empresa_anterior='" . $_POST['txt_Empre'] . "',fecha_creacion='" . $_POST['txt_FecCont'] . "',asesor='" . $_POST['txt_Asesor'] . "' WHERE idCliente='" . $_POST['text_idAfi'] . "'";
//echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
    $id_cli = $_POST['text_idAfi'];
} else {
    $consulta = "UPDATE clientes SET estado='ELIMINADO' WHERE id_cli='" . $_POST['cod'] . "' ";
}


if ($success == 0) {
    mysqli_query($link, "ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link, "COMMIT");
    echo "bien-" . $id_cli;
}

mysqli_close($link);
?>