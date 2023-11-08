<?php

session_start();
header('Content-Type: text/html; charset=UTF-8');
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


$buscar = array();
$cbp = "";


$cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> N° Factura"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Fecha"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Identificación"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Nombre"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Difunto"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Valor"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Acci&oacute;n"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);

    $consulta = "SELECT 
  id_fact,
  cons_fact,
  fec_cre,
  iden,
  nom,
  nomb_difunto,
  valor
FROM
  facturas_requi fact 
  LEFT JOIN requisiciones req 
    ON fact.requi = req.id_req  WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT( "
                . "  cons_fact, "
                . "  ' ', "
                . "  iden, "
                . "  ' ', "
                . "  nom, "
                . "  ' ', "
                . "  nomb_difunto, "
                . "  ' ', "
                . "  req.ced_contra, "
                . "  ' ', "
                . "  req.nom_contr "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {
            
        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND fact.estado = 'ACTIVO' 
ORDER BY id_fact DESC limit 20";
} else {

    $consulta = "SELECT 
  id_fact,
  cons_fact,
  fec_cre,
  iden,
  nom,
  nomb_difunto,
  valor
FROM
  facturas_requi fact 
  LEFT JOIN requisiciones req 
    ON fact.requi = req.id_req 
WHERE fact.estado = 'ACTIVO' 
ORDER BY id_fact DESC limit 20";
}
//echo $consulta;


$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {

        $cod = $fila["id_fact"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["cons_fact"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . acentos($fila["fec_cre"]) . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . acentos($fila["iden"]) . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . acentos($fila["nom"]) . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . acentos($fila["nomb_difunto"]) . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . '$ ' . number_format($fila['valor'], 2, ",", ".") . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<a  onclick=\"$.ImprimirFactReq('" . $cod . "')\"  class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-print\"></i> Imprimir</a>"
           
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