<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");



if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO constancias VALUES(null,'" . $_POST['consec'] . "','" . $_POST['fcreac'] . "',"
            . "'" . $_POST['txt_fecha_Cons'] . "','" . $_POST['txt_Ciuda'] . "','" . $_POST['txt_iden'] . "',"
            . "'" . $_POST['txt_NomCli'] . "','" . $_POST['CbConsig'] . "'," . $_POST['txt_vtotal'] . ",'ACTIVO',"
            . "'" . $_POST['txt_DirCli'] . "','" . $_POST['txt_TelCli'] . "','')";


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

    $Tam_Concep = $_POST['Long_Concep'];
    // echo $Tam_Nece;

    for ($i = 1; $i <= $Tam_Concep; $i++) {
        $consulta2 = "";
        $parConcep = explode("//", $_POST['Neces' . $i]);

        $consulta2 = "INSERT INTO concep_constancias VALUES(null,'" . $id_cosnt . "','" . $parConcep[0] . "','" . $parConcep[1] . "'," . $parConcep[2] . ",'" . $parConcep[3] . "')";
        //echo $consulta2;
       $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
    }

    if ($_POST['txt_nuevo'] == "SI") {

        $consulta2 = "INSERT INTO clientes VALUES(null,'" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
                . "' ','0000-00-00','" . $_POST['txt_DirCli'] . "',"
                . "'" . $_POST['txt_TelCli'] . "','','','ACTIVO','')";
        //echo $consulta2;
        $qc = mysqli_query($link, $consulta2);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 4;
        }
        // echo $consulta2;
    }

    $consulta = "UPDATE consecutivos SET actual='" . $_POST['conse'] . "' WHERE grupo='CONSTANCIAS'";
    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 3;
    }
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  constancias SET cons_constan='" . $_POST['consec'] . "',fec_cre='" . $_POST['fcreac'] . "',"
            . "fec_cons='" . $_POST['txt_fecha_Cons'] . "',ciudad='" . $_POST['txt_Ciuda'] . "',iden_constan='" . $_POST['txt_iden'] . "',"
            . "nom_constan='" . $_POST['txt_NomCli'] . "',consig_constan='" . $_POST['CbConsig'] . "',valor=" . $_POST['txt_vtotal'] . " WHERE id_constan='" . $_POST['id'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    //GUARDAR SERVICIOS

    $Tam_Concep = $_POST['Long_Concep'];
    // echo $Tam_Nece;

    $consulta = "DELETE FROM concep_constancias WHERE conse_cons='" . $_POST['id'] . "'";

    $qc = mysqli_query($link, $consulta);
 if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 5;
    }

    for ($i = 1; $i <= $Tam_Concep; $i++) {
        $consulta2 = "";
        $parConcep = explode("//", $_POST['Neces' . $i]);

        $consulta2 = "INSERT INTO concep_constancias VALUES(null,'" . $_POST['id'] . "','" . $parConcep[0] . "','" . $parConcep[1] . "'," . $parConcep[2] . ",'" . $parConcep[3] . "')";
        //echo $consulta2;
       $qc2 = mysqli_query($link,$consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
    }
    $id_cosnt = $_POST['id'];
} else {
    $id_cosnt= $_POST['cod'];
    $consulta = "UPDATE constancias SET estado='DELETE'  WHERE id_constan='" . $_POST['cod'] . "' ";

    //   echo $consulta;
    $qc = mysqli_query($link, $consulta);
  if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }
}

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