<?php

session_start();

include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');

$cad = "";
$cad2 = "";
$cbp = "";
$consulta = "";
$contador = 0;

$i = 0;
$j = 0;

$regmos = $_POST["nreg"];

$pag = $_POST["pag"];
$op = $_POST["pag"];
$con = $_POST["con"];
$buscar = array();
$cbp="";

$regemp = 0;
$pagact = 1;
if ($pag != null) {
    $regemp = (intval($pag) - 1) * $regmos;

    $pagact = intval($pag);
}



$busq = $_POST["bus"];

if ($con == "CONSUL1") {
    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT ncontrato, CONCAT(id_titu,' - ',nomb_titu) nomti,val_mes,val_anual,saldo,fech_vcenc, DATEDIFF(fech_vcenc,CURDATE()) diav,IFNULL(cli.email_cli,'NO REGISTRADO') email FROM contrato_prevision pre LEFT JOIN clientes cli ON pre.id_titu=cli.id_cli WHERE ";
        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  ncontrato, "
                    . "  ' ', "
                    . "  id_titu, "
                    . "  ' ', "
                    . "  nomb_titu"
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {

            } else {
                $consulta .= " AND ";
            }
        }
        $consulta .= " AND estado='ACTIVO' order by nomb_titu ASC";
    } else {

        $consulta = "SELECT ncontrato, CONCAT(id_titu,' - ',nomb_titu) nomti,val_mes,val_anual,saldo,fech_vcenc, DATEDIFF(fech_vcenc,CURDATE()) diav,IFNULL(cli.email_cli,'NO REGISTRADO') email FROM contrato_prevision pre LEFT JOIN clientes cli ON pre.id_titu=cli.id_cli WHERE  estado='ACTIVO' order by nomb_titu ASC";
    }
    ///////////CONSULTA CLIENTES AL DIA/////////////////////////////////
} else if ($con == "CONSUL1") {
    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT ncontrato, CONCAT(id_titu,' - ',nomb_titu) nomti,val_mes,val_anual,saldo,fech_vcenc, DATEDIFF(fech_vcenc,CURDATE()) diav,IFNULL(cli.email_cli,'NO REGISTRADO') email FROM contrato_prevision pre LEFT JOIN clientes cli ON pre.id_titu=cli.id_cli WHERE ";
        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  ncontrato, "
                    . "  ' ', "
                    . "  id_titu, "
                    . "  ' ', "
                    . "  nomb_titu"
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {

            } else {
                $consulta .= " AND ";
            }
        }
        $consulta .= " AND DATEDIFF(fech_vcenc,CURDATE()) > 0 AND estado='ACTIVO' order by nomb_titu ASC";
    } else {

        $consulta = "SELECT ncontrato, CONCAT(id_titu,' - ',nomb_titu) nomti,val_mes,val_anual,saldo,fech_vcenc, DATEDIFF(fech_vcenc,CURDATE()) diav,IFNULL(cli.email_cli,'NO REGISTRADO') email FROM contrato_prevision pre LEFT JOIN clientes cli ON pre.id_titu=cli.id_cli WHERE DATEDIFF(fech_vcenc,CURDATE()) > 0 AND estado='ACTIVO' order by nomb_titu ASC ";
    }
} else if ($con == "CONSUL2") {
    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT ncontrato, CONCAT(id_titu,' - ',nomb_titu) nomti,val_mes,val_anual,saldo,fech_vcenc, DATEDIFF(fech_vcenc,CURDATE()) diav,IFNULL(cli.email_cli,'NO REGISTRADO') email FROM contrato_prevision pre LEFT JOIN clientes cli ON pre.id_titu=cli.id_cli WHERE ";
        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  ncontrato, "
                    . "  ' ', "
                    . "  id_titu, "
                    . "  ' ', "
                    . "  nomb_titu"
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {

            } else {
                $consulta .= " AND ";
            }
        }
        $consulta .= " AND DATEDIFF(CURDATE(),fech_vcenc) > 30 AND DATEDIFF(CURDATE(),fech_vcenc) < 60 AND estado='ACTIVO' order by nomb_titu ASC ";
    } else {

        $consulta = "SELECT ncontrato, CONCAT(id_titu,' - ',nomb_titu) nomti,val_mes,val_anual,saldo,fech_vcenc, DATEDIFF(fech_vcenc,CURDATE()) diav,IFNULL(cli.email_cli,'NO REGISTRADO') email FROM contrato_prevision pre LEFT JOIN clientes cli ON pre.id_titu=cli.id_cli WHERE DATEDIFF(CURDATE(),fech_vcenc) > 30 AND DATEDIFF(CURDATE(),fech_vcenc) < 60 AND estado='ACTIVO' order by nomb_titu ASC";
    }
} else if ($con == "CONSUL3") {
    $cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> #"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Contrato"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Titular"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> CEMENTERIO"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Fecha Vencimiento"
            . "</th>"            
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Dias"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Correo"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Sel."
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> Acción"
            . "</th>"
            . "<th>"
            . "</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";

    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT OrdInhum,CONCAT(ced_cli,' - ',nom_cli) tit, hasta,  DATEDIFF(hasta,CURDATE()) dias,CASE WHEN cli.email_cli='' THEN 'NO REGISTRADO' ELSE cli.email_cli END email,cemen cementerio FROM contrato_arriendo arri LEFT JOIN clientes cli ON arri.ced_cli=cli.inde_cli WHERE ";
        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "OrdInhum( "
                    . "  ncontrato, "
                    . "  ' ', "
                    . "  ced_cli, "
                    . "  ' ', "
                    . "  nom_cli"
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {

            } else {
                $consulta .= " AND cemen='".$_POST['Ceme']."' AND ";
            }
        }
        $consulta .= " arri.estado='ACTIVO' and arri.estado_contrato='Activo' and hasta BETWEEN  '" . $_POST['ini'] . "' AND '" . $_POST['fin'] . "' order by hasta ASC ";
        echo $consulta;
    } else {

        $consulta = "SELECT id_arriendo,OrdInhum,CONCAT(arri.ced_cli,' - ',arri.nom_cli) tit, hasta,  DATEDIFF(hasta,CURDATE()) dias,CASE WHEN cli.email_cli='' THEN 'NO REGISTRADO' ELSE cli.email_cli END email,cemen cementerio FROM contrato_arriendo arri LEFT JOIN clientes cli ON arri.ced_cli=cli.inde_cli WHERE arri.estado='ACTIVO' and arri.estado_contrato='Activo' and cemen='".$_POST['Ceme']."' AND hasta BETWEEN  '" . $_POST['ini'] . "' AND '" . $_POST['fin'] . "' order by hasta ASC ";
    }
}
// echo $consulta;

$contador = 0;


$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $contador++;
        $cod = $fila["id_arriendo"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $contador . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["OrdInhum"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . acentos($fila["tit"]) . " "
                . "</td>";
                if($fila["cementerio"]=="JARDINES"){
                      $cad .= "<td class=\"highlight\">JARDINES DEL ECCE HOMO</td>";
                }else{
                     $cad .= "<td class=\"highlight\">CEMENTERIO NUEVO</td>"; 
                }
              
               $cad .= "<td class=\"highlight\">"
                . $fila["hasta"] . " "
                . "</td>";
        $dias = "";
        if ($fila["dias"] > 0) {
            $cad .= "<td class=\"highlight\">"
                    . $fila["dias"] . " Restantes";
            $dias = $fila["dias"] . " Restantes";
           
        } else {
            $cad .= "<td class=\"highlight\" style=\"color:#E52117\"> "
                    . abs($fila["dias"]) . " De Retraso";
            $dias = abs($fila["dias"]) . " De Retraso";
            
        }
        
           $cad .=  "<td class=\"highlight\">"
                . $fila["email"] . " "
                . "</td>";
       
        
        if($fila["email"]==="NO REGISTRADO"){
                $cad .= "<td>"
                . "   <input type='hidden' id='Contr" . $contador . "' name='Contr' value='" . $fila["id_arriendo"] . "' /><input type='checkbox' disabled id='sel" . $contador . "'  class='form-control' name='sel'  value='ON' />"
                . "</td>"; 
        }else{
                 $cad .= "<td>"
                . "   <input type='hidden' id='Contr" . $contador . "' name='Contr' value='" . $fila["id_arriendo"] . "' /><input type='checkbox' id='sel" . $contador . "'  class='form-control' name='sel'  value='ON' />"
                . "</td>";
        }
          
                 $cad .= "<td>"
                . "<a onclick=\"$.PrintNotiArri('" . $cod . "')\" class=\"btn default btn-xs blue-dark\">"
                . "<i class=\"fa fa-file-pdf-o\"></i> Imprimir</a>"
                . "</td>"
                . "</tr>";


    }
}


$cad .= "</tbody>"
        . "</table>";


$salida = new stdClass();
$salida->cad = $cad;


echo json_encode($salida);

mysqli_close($link);

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>