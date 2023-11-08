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
$total = 0;
$pendi = 0;


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

$cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
        . "<thead>"
        . "<tr>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> #"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Fecha"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Titular"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Contrato"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Valor"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($con == "VENTA") {
    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT
  dtve.fpago fp,
  dtve.valor val,
  cvent.pedido_contr conse,
  CONCAT(
    cvent.ident_vent,
    ' - ',
    cvent.nombre_venta
  ) clien
FROM
  detalles_venta dtve
  LEFT JOIN contrato_venta cvent
    ON dtve.contrato = cvent.id_contr
     WHERE  ";
        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  andet.fpago, "
                    . "  ' ', "
                    . "  contr.id_titu, "
                    . "  ' ', "
                    . "  contr.nomb_titu "
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {

            } else {
                $consulta .= " AND ";
            }
        }
        $consulta .= " AND dtve.fpago BETWEEN '" . $_POST["fin"] . "'  AND '" . $_POST["ffi"] . "' order by cvent.nombre_vent ASC LIMIT " . $regemp . "," . $regmos;
    } else {

        $consulta = "SELECT
  dtve.fpago fp,
  dtve.valor val,
  cvent.pedido_contr conse,
  CONCAT(
    cvent.ident_vent,
    ' - ',
    cvent.nombre_venta
  ) clien
FROM
  detalles_venta dtve
  LEFT JOIN contrato_venta cvent
    ON dtve.contrato = cvent.id_contr
     WHERE dtve.fpago BETWEEN '" . $_POST["fin"] . "'  AND '" . $_POST["ffi"] . "' order by cvent.nombre_venta ASC  LIMIT " . $regemp . "," . $regmos;
    }
} else if ($con == "PREVI") {
    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT
   andet.fpago fp,
  andet.valor val,
  contr.ncontrato conse,
  CONCAT(
    contr.id_titu,
    ' - ',
    contr.nomb_titu
  ) clien
FROM
  anios_detalles andet
  LEFT JOIN anios_contrato ancont
    ON andet.anio=ancont.id
    LEFT JOIN contrato_prevision contr
    ON ancont.contrato=contr.id_contr
     WHERE  ";
        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  andet.fpago, "
                    . "  ' ', "
                    . "  contr.id_titu, "
                    . "  ' ', "
                    . "  contr.nomb_titu "
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {

            } else {
                $consulta .= " AND ";
            }
        }
        $consulta .= " AND contr.fecha_cre BETWEEN '" . $_POST["fin"] . "'  AND '" . $_POST["ffi"] . "' ORDER BY contr.nomb_titu ASC  LIMIT  " . $regemp . "," . $regmos;
    } else {

        $consulta = "SELECT
   andet.fpago fp,
  andet.valor val,
  contr.ncontrato conse,
  CONCAT(
    contr.id_titu,
    ' - ',
    contr.nomb_titu
  ) clien
FROM
  anios_detalles andet
  LEFT JOIN anios_contrato ancont
    ON andet.anio=ancont.id
    LEFT JOIN contrato_prevision contr
    ON ancont.contrato=contr.id_contr
     WHERE contr.fecha_cre BETWEEN '" . $_POST["fin"] . "'  AND '" . $_POST["ffi"] . "' ORDER BY contr.nomb_titu ASC  LIMIT  " . $regemp . "," . $regmos;
    }
}
// echo $consulta;

$contador = 0;

$consulta2 = "TRUNCATE TABLE consulpagos;";
mysqli_query($link,$consulta2);
$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $contador++;

        $total = $total + $fila["val"];

        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $contador . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["fp"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["clien"] . " "
                . "</td>"
                . "<td class=\"highlight\"> "
                . $fila["conse"] . " "
                . "</td>"
                . "<td class=\"highlight\">$ "
                . number_format($fila["val"], 2, ",", ".") . " "
                . "</td>"
                . "</tr>";

        $consulta3 = "INSERT INTO consulpagos VALUES('" . $contador . "','" . $fila["fp"] . "',"
                . "'" . $fila["conse"] . "',' " . $fila["clien"] . "',' " . $fila["val"] . "')";
        mysqli_query($link,$consulta3);
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
    $cad2 = $cad2 . "</select></td>";
    if ($pagact < $div-1) {
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
$salida->totalpen = $total;

echo json_encode($salida);

mysqli_close($link);
?>