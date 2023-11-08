<?php

session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');
mysqli_query($link, "BEGIN");



if ($_POST['acc'] == "1") {
    $consulta = "INSERT INTO contrato_prevision VALUES(null,'" . $_POST['codigo'] . "','" . $_POST['fcreac'] . "',"
            . "'" . $_POST['txt_Ciuda'] . "','CESAR','" . $_POST['CbPlanExe'] . "','" . $_POST['CbTipVinc'] . "',"
            . "'" . $_POST['txt_Empre'] . "','" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
            . "'" . $_POST['CbTipClien'] . "','" . $_POST['CbDirRecaudo'] . "','" . $_POST['txt_OtrDir'] . "',"
            . "'" . $_POST['txt_IdEmpl'] . "','" . $_POST['txt_NomEmpl'] . "','" . $_POST['txt_DirEmpl'] . "',"
            . "'" . $_POST['txt_CiuEmpl'] . "','" . $_POST['txt_DepEmpl'] . "','" . $_POST['txt_TelEmpl'] . "',"
            . "" . $_POST['txt_ValAn'] . "," . $_POST['txt_ValMe'] . ",'" . $_POST['CbFormPago'] . "',"
            . "'" . $_POST['txt_fecha_pago'] . "','" . $_POST['txt_Asesor'] . "','ACTIVO'," . $_POST['txt_ValAn'] . ",'','0000-00-00','" . $_POST['txt_obser'] . "')";


    // echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    $id_Con = "";
    $sql = "SELECT MAX(id_contr) AS id FROM contrato_prevision";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        while ($fila = mysqli_fetch_array($resulsql)) {
            $id_Con = $fila["id"];
        }
    }
    //GUARDAR GRUPO FAMILIAR BASICO

    $Tam_GrupBas = $_POST['Long_GrupBas'];
    // echo $Tam_Nece;

    for ($i = 1; $i <= $Tam_GrupBas; $i++) {
        $consulta2 = "";
        $parGruBas = explode("//", $_POST['GrupBas' . $i]);

        $consulta2 = "INSERT INTO grupo_fambasico VALUES(null,'" . $id_Con . "','" . $parGruBas[0] . "','" . $parGruBas[1] . "','" . $parGruBas[2] . "','" . $parGruBas[3] . "','" . $parGruBas[4] . "','" . $parGruBas[5] . "','" . $parGruBas[6] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
    }
    //GUARDAR GRUPO FAMILIAR SECUNDARIO

    $Tam_GrupSec = $_POST['Long_GrupSec'];
    // echo $Tam_Nece;

    for ($i = 1; $i <= $Tam_GrupSec; $i++) {
        $consulta2 = "";
        $parGruSec = explode("//", $_POST['GrupSec' . $i]);

        $consulta2 = "INSERT INTO grupo_famsecundario VALUES(null,'" . $id_Con . "','" . $parGruSec[0] . "','" . $parGruSec[1] . "','" . $parGruSec[2] . "','" . $parGruSec[3] . "','" . $parGruSec[4] . "','" . $parGruSec[5] . "','" . $parGruSec[6] . "')";
        // echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 3;
        }
    }


    /////GUARDAR ANEXOS////////
    $Tam_Anexos = $_POST['Long_Anexos'];

    for ($i = 1; $i <= $Tam_Anexos; $i++) {
        $consulta2 = "";
        $parAnexo = explode("///", $_POST['idAnexo' . $i]);

        $consulta2 = "INSERT INTO previ_anexos VALUES(null,'" . $id_Con . "','" . $parAnexo[0] . "','" . $parAnexo[1] . "','" . $parAnexo[2] . "')";
        //   echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 14;
        }
    }

    if ($_POST['txt_nuevo'] == "SI") {

        $consulta2 = "INSERT INTO clientes VALUES(null,'" . $_POST['txt_iden'] . "','" . $_POST['txt_NomCli'] . "',"
                . "'" . $_POST['CbSexo'] . "','" . $_POST['txt_FecNac'] . "','" . $_POST['txt_DirCli'] . "',"
                . "'" . $_POST['txt_TelCli'] . "','','" . $_POST['txtemail'] . "','ACTIVO','" . $_POST['txt_Dirbarrio'] . "')";
        //echo $consulta2;
        $qc = mysqli_query($link, $consulta2);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 4;
        }
        // echo $consulta2;
    } else {
        $consulta2 = "UPDATE clientes SET nom_cli='" . $_POST['txt_NomCli'] . "',"
                . "sex_cli='" . $_POST['CbSexo'] . "',dir_cli='" . $_POST['txt_DirCli'] . "',"
                . "tel_cli='" . $_POST['txt_TelCli'] . "',email_cli='" . $_POST['txtemail'] . "',barrio='" . $_POST['txt_Dirbarrio'] . "' WHERE inde_cli='" . $_POST['txt_iden'] . "'";
        //echo $consulta2;
        $qc = mysqli_query($link, $consulta2);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 4;
        }
    }

    $consulta = "UPDATE consecutivos SET actual='" . $_POST['conse'] . "' WHERE grupo='PREVISION'";
    $qc = mysqli_query($link, $consulta);
//
} else if ($_POST['acc'] == "2") {
    $consulta = "UPDATE contrato_prevision SET ncontrato='" . $_POST['codigo'] . "',fecha_cre='" . $_POST['fcreac'] . "',"
            . "ciudad='" . $_POST['txt_Ciuda'] . "',plan='" . $_POST['CbPlanExe'] . "',tipo_vinc='" . $_POST['CbTipVinc'] . "',"
            . "empresa='" . $_POST['txt_Empre'] . "',id_titu='" . $_POST['txt_iden'] . "',nomb_titu='" . $_POST['txt_NomCli'] . "',"
            . "tipo_cli='" . $_POST['CbTipClien'] . "',dir_recau='" . $_POST['CbDirRecaudo'] . "',otr_dir='" . $_POST['txt_OtrDir'] . "',"
            . "id_emple='" . $_POST['txt_IdEmpl'] . "',nom_emple='" . $_POST['txt_NomEmpl'] . "',dir_emple='" . $_POST['txt_DirEmpl'] . "',"
            . "ciud_emple='" . $_POST['txt_CiuEmpl'] . "',depar_emple='" . $_POST['txt_DepEmpl'] . "',tel_emple='" . $_POST['txt_TelEmpl'] . "',"
            . "val_anual=" . $_POST['txt_ValAn'] . ",val_mes=" . $_POST['txt_ValMe'] . ",form_pago='" . $_POST['CbFormPago'] . "',"
            . "fech_ini='" . $_POST['txt_fecha_pago'] . "',asesor='" . $_POST['txt_Asesor'] . "',observ='" . $_POST['txt_obser'] . "' WHERE id_contr= '" . $_POST['id'] . "'";
    //echo $consulta;
    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 1;
    }

    //GUARDAR SERVICIOS

    $Tam_GrupBas = $_POST['Long_GrupBas'];
    // echo $Tam_Nece;

    $consulta = "DELETE FROM grupo_fambasico WHERE id_cont='" . $_POST['id'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 5;
    }

    for ($i = 1; $i <= $Tam_GrupBas; $i++) {
        $consulta2 = "";
        $parGruBas = explode("//", $_POST['GrupBas' . $i]);

        $consulta2 = "INSERT INTO grupo_fambasico VALUES(null,'" . $_POST['id'] . "','" . $parGruBas[0] . "','" . $parGruBas[1] . "','" . $parGruBas[2] . "','" . $parGruBas[3] . "','" . $parGruBas[4] . "','" . $parGruBas[5] . "','" . $parGruBas[6] . "')";
        //echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 2;
        }
    }

    //ACTUALIZAR GRUPO SECUNDARIO
    $Tam_GrupSec = $_POST['Long_GrupSec'];
    // echo $Tam_Nece;

    $consulta = "DELETE FROM grupo_famsecundario WHERE id_cont='" . $_POST['id'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 5;
    }

    for ($i = 1; $i <= $Tam_GrupSec; $i++) {
        $consulta2 = "";
        $parGruSec = explode("//", $_POST['GrupSec' . $i]);

        $consulta2 = "INSERT INTO grupo_famsecundario VALUES(null,'" . $_POST['id'] . "','" . $parGruSec[0] . "','" . $parGruSec[1] . "','" . $parGruSec[2] . "','" . $parGruSec[3] . "','" . $parGruSec[4] . "','" . $parGruSec[5] . "','" . $parGruSec[6] . "')";
        // echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 3;
        }
    }

    /////GUARDAR ANEXOS////////

    $consulta = "DELETE FROM previ_anexos WHERE id_prev='" . $_POST['id'] . "'";

    $qc = mysqli_query($link, $consulta);
    if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 26;
    }
    $Tam_Anexos = $_POST['Long_Anexos'];

    for ($i = 1; $i <= $Tam_Anexos; $i++) {
        $consulta2 = "";
        $parAnexo = explode("///", $_POST['idAnexo' . $i]);

        $consulta2 = "INSERT INTO previ_anexos VALUES(null,'" . $_POST['id'] . "','" . $parAnexo[0] . "','" . $parAnexo[1] . "','" . $parAnexo[2] . "')";
        //   echo $consulta2;
        $qc2 = mysqli_query($link, $consulta2);
        if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 14;
        }
    }

    $consulta2 = "UPDATE clientes SET nom_cli='" . $_POST['txt_NomCli'] . "',"
            . "sex_cli='" . $_POST['CbSexo'] . "',dir_cli='" . $_POST['txt_DirCli'] . "',"
            . "tel_cli='" . $_POST['txt_TelCli'] . "',email_cli='" . $_POST['txtemail'] . "',"
            . "barrio='" . $_POST['txt_Dirbarrio'] . "' WHERE inde_cli='" . $_POST['txt_iden'] . "'";
    //echo $consulta2;
    $qc2 = mysqli_query($link, $consulta2);
    if (($qc2 == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
        $success = 0;
        $error = 4;
    }
} else {

    $flag = "s";
    $sql = "SELECT * FROM anios_contrato where contrato='" . $_POST['cod'] . "'";
    $resulsql = mysqli_query($link, $sql);
    if (mysqli_num_rows($resulsql) > 0) {
        $flag = "n";
    }
    if ($flag == "s") {
        $consulta = "UPDATE contrato_prevision SET estado='DELETE' WHERE id_contr='" . $_POST['cod'] . "' ";

        //   echo $consulta;
        $qc = mysqli_query($link, $consulta);
        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }
    } else {
        echo $flag;
    }
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
            NOW(),'Actualizacion de Requisicion " . $_POST['id'] . "' ,'ACTUALIZACION', 'GesRequisicion.php')";
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
    echo "bien";
}

mysqli_close($link);
?>