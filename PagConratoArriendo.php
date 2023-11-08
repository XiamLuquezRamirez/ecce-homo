<?php

session_start();

include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_set_charset($link, 'utf8');

$cad = "";
$cad2 = "";
$consulta = "";
$contador = 0;

$i = 0;
$j = 0;

$regmos = $_POST["nreg"];

$pag = $_POST["pag"];
$op = $_POST["pag"];
$buscar = array();
$cbp = "";

$regemp = 0;
$pagact = 1;
if ($pag != null) {
    $regemp = (intval($pag) - 1) * $regmos;

    $pagact = intval($pag);
}

$cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i>Inhumacion"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Fecha. Vencimiento"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Cementerio"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Fallecido"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Contratante"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Accion"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($busq != "") {
    $busq = str_replace("+", " ", $busq);
    $buscar = explode(" ", $busq);

    $consulta = "SELECT
                     id_arriendo id,
                    OrdInhum orden,
                    hasta fec,
                    CASE
                      WHEN cemen = 'NUEVO'
                      THEN 'CEMENTERIO NUEVO'
                      ELSE 'JARDINES DEL ECCE HOMO'
                    END cem,
                    muerto mur,
                    CONCAT(ced_cli, ' - ', nom_cli) contr
                  FROM
                    contrato_arriendo WHERE  ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT("
                . "  OrdInhum, "
                . "  ' ', "
                . "  fec_crea, "
                . "  ' ', "
                . "  cemen, "
                . "  ' ', "
                . "  muerto, "
                . "  ' ', "
                . "  ced_cli, "
                . "  ' ', "
                . "  nom_cli "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {
            
        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND estado='ACTIVO' order by muerto ASC LIMIT " . $regemp . "," . $regmos;
} else {

    $consulta = "SELECT
                id_arriendo id,
                OrdInhum orden,
                hasta fec,
                CASE
                  WHEN cemen = 'NUEVO'
                  THEN 'CEMENTERIO NUEVO'
                  ELSE 'JARDINES DEL ECCE HOMO'
                END cem,
                muerto mur,
                CONCAT(ced_cli, ' - ', nom_cli) contr
              FROM
                contrato_arriendo WHERE estado='ACTIVO' order by muerto ASC  LIMIT " . $regemp . "," . $regmos;
}
//echo $consulta;


$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {

        $cod = $fila["id"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["orden"] . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["fec"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . acentos($fila["cem"]) . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . acentos($fila["mur"]) . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . acentos($fila["contr"]) . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<a  onclick=\"$.editContr('" . $cod . "')\"  class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-edit\"></i> Editar</a>"
                . "<a   onclick=\"$.VerContr('" . $cod . "')\"  class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-search\"></i> Ver</a>"
                . "<a onclick=\"$.deletContr('" . $cod . "')\" class=\"btn default btn-xs red\">"
                . "<i class=\"fa fa-trash-o\"></i> Eliminar</a>"
                . "<a onclick=\"$.PrintContr('" . $cod . "')\" class=\"btn default btn-xs blue-dark\">"
                . "<i class=\"fa fa-file-pdf-o\"></i> Imprimir</a>"
                . "<a onclick=\"$.PrintAuto('" . $cod . "')\" class=\"btn default btn-xs blue-dark\">"
                . "<i class=\"fa fa-file-pdf-o\"></i> Imprimir Autorización</a>"
                . "<a onclick=\"$.AddProrroga('" . $cod . "')\" class=\"btn default btn-xs purple\">"
                . "<i class=\"fa fa-share\"></i> Agregar Prorroga</a>"
                . "</td>"
                . "</tr>";
    }
}

$consulta = "SELECT count(*) as conta FROM contrato_arriendo WHERE estado='ACTIVO'";
$resultado2 = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado2) > 0) {

    while ($fila = mysqli_fetch_array($resultado2)) {
        $contador = intval($fila["conta"]);
    }
}
$cad .= "</tbody>"
        . "</table>";

$pagant = $pagact - 1;
$pagsig = $pagact + 1;
$div = $contador / $regmos;
$mod = $contador % $regmos;
if ($mod > 0) {
    $div++;
}
if ($contador > $regmos) {
    $cad2 = "<br />"
            . "<table cellspacing=5 style=\"text-align: right;\">"
            . "<tr >";
    $cad2 = $cad2 . "<td><input type='hidden' value='" . $j . "' name='contador' id='contador' />";
    $cad2 = $cad2 . "<input type='button' style=\"width: 70px;\" class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' << ' onclick=\"$.paginador('1','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
    if ($pagact > 1) {
        $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' < ' onclick=\"$.paginador('" . $pagant . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
    } else {
        $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' < ' onclick=\"$.paginador('" . $pagant . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' /></td>";
    }
    $cbp = $cbp . "<td>Pagina No: <select id='selectpag' class='bs-select form-control small' onchange=\"$.combopag(this.value,'../paginador_centros')\">";
    for ($j = 1; $j <= $div; $j++) {
        if ($j == $pagact) {
            $cbp = $cbp . "<option value='" . $j . "' selected='selected'>" . $j . "</option>";
        } else {
            $cbp = $cbp . "<option value='" . $j . "'>" . $j . "</option>";
        }
    }
    $cbp = $cbp . "</select></td>";
    if ($pagact < $div - 1) {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' > ' onclick=\"$.paginador('" . $pagsig . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' />";
    } else {
        $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\"  class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' > ' onclick=\"$.paginador('" . $pagsig . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' />";
    }
    $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' >> ' onclick=\"$.paginador('" . $div . "','../paginador_centros');\"  style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . $div . "' />"
            . "<input type='hidden' id='codter' name='codter' value='' /></td>";
    $cad2 = $cad2 . "</tr>"
            . "</table>";
}

$salida = new stdClass();
$salida->cad = $cad;
$salida->cad2 = $cad2;
$salida->cbp = $cbp;

echo json_encode($salida);

mysqli_close($link);

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>