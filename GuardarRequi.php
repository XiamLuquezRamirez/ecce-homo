<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");



if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO requisiciones VALUES(null,'" . $_POST['codigo'] . "','" . $_POST['fcreac'] . "',"
            . "'" . $_POST['txt_Ciuda'] . "','" . $_POST['CbFune'] . "','" . $_POST['txt_ObsFun'] . "',"
            . "'" . $_POST['txt_NomPadr'] . "','" . $_POST['txt_NomMadr'] . "','" . $_POST['txt_id_cli'] . "',"
            . "'" . $_POST['txt_IdFall'] . "','" . $_POST['txt_NomFall'] . "','" . $_POST['CbSexoFall'] . "',"
            . "'" . $_POST['txt_FecNacFall'] . "','" . $_POST['txt_src_archivo'] . "','" . $_POST['fvelac'] . "',"
            . "'" . $_POST['horvelac'] . "','" . $_POST['CbSala'] . "','" . $_POST['fecex'] . "',"
            . "'" . $_POST['horex'] . "','" . $_POST['CbIgle'] . "','" . $_POST['CbCem'] . "',"
            . "'" . $_POST['txt_obsEq'] . "','" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
            . "'" . $_POST['txt_SerPre'] . "','" . $_POST['txt_DirSer'] . "','" . $_POST['txt_TelSer'] . "','" . $_POST['txt_CiuSer'] . "','ACTIVO','" . $_POST['velcasa'] . "')";


    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_req = "";
    $sql = "SELECT MAX(id_req) AS id FROM requisiciones";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_req = $fila["id"];
        }
    }
    //GUARDAR SERVICIOS

    $Tam_Nece = $_POST['Long_Nece'];
    // echo $Tam_Nece;

    for ($i = 1; $i <= $Tam_Nece; $i++) {
        $consulta2 = "";
        $parNec = explode("//", $_POST['Neces' . $i]);

        $consulta2 = "INSERT INTO requi_servicios VALUES(null,'" . $id_req . "','" . $parNec[0] . "','" . $parNec[1] . "'," . $parNec[2] . ",'" . $parNec[3] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
    }

    if ($_POST['txt_nuevo'] == "SI") {

        $consulta2 = "INSERT INTO clientes VALUES(null,'" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
                . "' ','0000-00-00','" . $_POST['txt_Dir'] . "',"
                . "'" . $_POST['txt_Tel'] . "','','" . $_POST['txtemail'] . "','ACTIVO','" . $_POST['txt_Dirbarrio'] . "')";
        // echo $consulta2;
        $qc = mysqli_query($link, $consulta2);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 4;
        }
        // echo $consulta2;
    } else {
        $consulta2 = "UPDATE clientes SET nom_cli='" . $_POST['txt_NomCli'] . "',"
                . "dir_cli='" . $_POST['txt_Dir'] . "',"
                . "tel_cli='" . $_POST['txt_Tel'] . "',barrio='" . $_POST['txt_Dirbarrio'] . "',email_cli='" . $_POST['txtemail'] . "' WHERE inde_cli='" . $_POST['txt_iden'] . "'";

        $qc = mysqli_query($link, $consulta2);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {

            $success = 0;

            $error = 8;
        }
    }

    $consulta = "UPDATE consecutivos SET actual='" . $_POST['conse'] . "' WHERE grupo='REQUISICION'";
    $qc = mysqli_query($link, $consulta);

    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 3;
    }
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE  requisiciones SET cod_req='" . $_POST['codigo'] . "',fech_req='" . $_POST['fcreac'] . "',"
            . "ciu_req='" . $_POST['txt_Ciuda'] . "',funau_req='" . $_POST['CbFune'] . "',naut_req='" . $_POST['txt_ObsFun'] . "',"
            . "nompad_req='" . $_POST['txt_NomPadr'] . "',nommad_req='" . $_POST['txt_NomMadr'] . "',idcont_req='" . $_POST['txt_id_cli'] . "',"
            . "idfall_req='" . $_POST['txt_IdFall'] . "',nomfall_req='" . $_POST['txt_NomFall'] . "',sexfall_req='" . $_POST['CbSexoFall'] . "',"
            . "fecnfall_req='" . $_POST['txt_FecNacFall'] . "',fotfall_req='" . $_POST['txt_src_archivo'] . "',fecve_req='" . $_POST['fvelac'] . "',"
            . "horve_req='" . $_POST['horvelac'] . "',salve_req='" . $_POST['CbSala'] . "',fecexe_req='" . $_POST['fecex'] . "',"
            . "horexe_req='" . $_POST['horex'] . "',igle_req='" . $_POST['CbIgle'] . "',ceme_req='" . $_POST['CbCem'] . "',"
            . "obse_req='" . $_POST['txt_obsEq'] . "',ced_contra='" . $_POST['txt_iden'] . "',nom_contr='" . $_POST['txt_NomCli'] . "',"
            . "serpres='" . $_POST['txt_SerPre'] . "',dirser='" . $_POST['txt_DirSer'] . "',telser='" . $_POST['txt_TelSer'] . "',"
            . "ciuserv='" . $_POST['txt_CiuSer'] . "',velcasa='" . $_POST['velcasa'] . "' WHERE id_req='" . $_POST['id'] . "'";

    // echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    //GUARDAR SERVICIOS

    $Tam_Nece = $_POST['Long_Nece'];
    // echo $Tam_Nece;

    $consulta = "DELETE FROM requi_servicios WHERE id_req='" . $_POST['id'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 2;
    }

    for ($i = 1; $i <= $Tam_Nece; $i++) {
        $consulta2 = "";
        $parNec = explode("//", $_POST['Neces' . $i]);

        $consulta2 = "INSERT INTO requi_servicios VALUES(null,'" . $_POST['id'] . "','" . $parNec[0] . "','" . $parNec[1] . "'," . $parNec[2] . ",'" . $parNec[3] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 3;
        }
    }

    $id_req = $_POST['id'];


    if ($_POST['txt_nuevo'] == "SI") {

        $consulta2 = "INSERT INTO clientes VALUES(null,'" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
                . "' ','0000-00-00','" . $_POST['txt_Dir'] . "',"
                . "'" . $_POST['txt_Tel'] . "','','" . $_POST['txtemail'] . "','ACTIVO','" . $_POST['txt_Dirbarrio'] . "')";
        // echo $consulta2;
        $qc = mysqli_query($link, $consulta2);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 4;
        }
        // echo $consulta2;
    } else {


        $consulta2 = "UPDATE clientes SET nom_cli='" . $_POST['txt_NomCli'] . "',"
                . "dir_cli='" . $_POST['txt_Dir'] . "',"
                . "tel_cli='" . $_POST['txt_Tel'] . "',barrio='" . $_POST['txt_Dirbarrio'] . "',email_cli='" . $_POST['txtemail'] . "' WHERE inde_cli='" . $_POST['txt_iden'] . "'";
        $qc = mysqli_query($link, $consulta2);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {

            $success = 0;

            $error = 8;
        }
    }
} else {
    $flag = "s";
    $sql = "SELECT * FROM constancias where requi='" . $_POST['cod'] . "'";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        $flag = "n";
    }

    $sql = "SELECT * FROM facturas_requi where requi='" . $_POST['cod'] . "'";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        $flag = "n";
    }
    if ($flag == "s") {
        $consulta = "UPDATE requisiciones SET estado='DELETE'  WHERE id_req='" . $_POST['cod'] . "' ";

        //   echo $consulta;
        $qc = mysqli_query($link, $consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }
    } else {
        echo "no";
    }
    $id_req = $_POST['cod'];
}





if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Registro de Requisicion " . $_POST['codigo'] . "' ,'INSERCION', 'GesRequisicion.php')";
} else if ($_POST['acc'] == "2") {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Actualizacion de Requisicion " . $_POST['codigo'] . "' ,'ACTUALIZACION', 'GesRequisicion.php')";
} else {
    $consulta = "INSERT INTO logs (usuario_id, log_direccion, log_fecha,
            log_hora, log_accion, log_tipo, log_interfaz) VALUES
            ('" . $_SESSION['ses_user'] . "','" . $_SERVER['REMOTE_ADDR'] . "',CURRENT_DATE(),
            NOW(),'Eliminacion de Requisicion
            " . $_POST['cod'] . "' ,'ELIMINACION', 'GesRequisicion.php')";
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
    echo "bien/" . $id_req;
}

mysqli_close($link);
?>