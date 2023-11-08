<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");



if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO cesioncontrato VALUES(null,'" . $_POST['fcreac'] . "',"
            . "'" . $_POST['txt_iden'] . "','" . $_POST['txt_idenCesi'] . "','" . $_POST['idvent'] . "',"
            . "'" . $_POST['ubi'] . "','" . $_POST['tiu'] . "','" . $_POST['texubi'] . "',"
            . "'" . $_POST['CbTipTras'] . "','" . $_POST['CbEntDoc'] . "','" . $_POST['txt_Nota'] . "','ACTIVO','" . $_POST['txt_TitPro'] . "')";

    //  echo $consulta;
    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_ord = "";
    $sql = "SELECT MAX(id) AS id FROM cesioncontrato";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_ord = $fila["id"];
        }
    }

    if ($_POST['tiu'] == "lote") {
        $consulta = "DELETE FROM venta_deta_lote WHERE id='" . $_POST['ubi'] . "' AND id_venta='" . $_POST['idvent'] . "'";
    } else {
        $consulta = "DELETE FROM venta_deta_osario WHERE id='" . $_POST['ubi'] . "' AND id_venta='" . $_POST['idvent'] . "'";
    }
    mysqli_query($link, $consulta);

    if ($_POST['txt_nuevo'] == "SI") {

        $consulta2 = "INSERT INTO clientes VALUES(null,'" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
                . "'','0000-00-00','" . $_POST['txt_Dir'] . "',"
                . "'" . $_POST['txt_Tel'] . "','','','ACTIVO','')";

        $qc = mysqli_query($link, $consulta2);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
        // echo $consulta2;
    }
    if ($_POST['txt_nuevoSec'] == "SI") {

        $consulta2 = "INSERT INTO clientes VALUES(null,'" . $_POST['txt_idenCesi'] . "','" . $_POST['txt_NomCesi'] . "',"
                . "'','0000-00-00','" . $_POST['txt_DirCesi'] . "',"
                . "'" . $_POST['txt_TelCesi'] . "','','','ACTIVO','" . $_POST['txt_BarrCesi'] . "')";

        $qc = mysqli_query($link, $consulta2);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
        // echo $consulta2;
    }


    /////GUARDAR PERSONAS////////

    $Tam_Nece = $_POST['Long_Perso'];
    // echo $Tam_Nece;

    for ($i = 1; $i <= $Tam_Nece; $i++) {
        $consulta2 = "";
        $parPerso = explode("//", $_POST['Perso' . $i]);

        $consulta2 = "INSERT INTO personas_contrato_cesion VALUES(null,'" . $id_ord . "','" . $parPerso[0] . "','" . $parPerso[1] . "','" . $parPerso[2] . "','ACTIVO')";
        // echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 3;
        }
    }
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE cesioncontrato SET fecha='" . $_POST['fcreac'] . "',"
            . "titular='" . $_POST['txt_iden'] . "',cesionario='" . $_POST['txt_idenCesi'] . "',contrato='" . $_POST['idvent'] . "',"
            . "idubi='" . $_POST['ubi'] . "',tubi='" . $_POST['tiu'] . "',textubica='" . $_POST['texubi'] . "',"
            . "ttraspado='" . $_POST['CbTipTras'] . "',documento='" . $_POST['CbEntDoc'] . "',nota='" . $_POST['txt_Nota'] . "' WHERE id='" . $_POST['id'] . "'";
    //  echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_ord = $_POST['id'];
} else {
    $id_ord = $_POST['cod'];
    $consulta = "UPDATE cesioncontrato SET estado='DELETE' WHERE id='" . $_POST['cod'] . "'";
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
}

if ($success == 0) {
    mysqli_query($link, "ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query($link, "COMMIT");
    echo "bien/" . $id_ord;
}

mysqli_close($link);
?>