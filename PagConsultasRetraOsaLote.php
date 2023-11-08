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
$totalpen = 0;
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
        . "<i class=\"fa fa-angle-right\"></i> Contrato"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Titular"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Val. Mensual"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Val. Anula"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Val. Saldo"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Fecha Vencimiento"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Días"
        . "</th>"
        . "</tr>"
        . "</thead>"
        . "<tbody>";

$busq = $_POST["bus"];

if ($con == " ") {
    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT
  id_contr, pedido_contr ncontrato,CONCAT(ident_vent, ' - ', nombre_venta) nomti,valcumes_vent valmes,precios_vent valven,conve.saldo,
  MAX(dtv.fvenc) fven,
  TIMESTAMPDIFF(MONTH, MAX(dtv.fvenc), CURDATE()) meses,
  DATEDIFF(MAX(dtv.fvenc), CURDATE()) diav
FROM
  contrato_venta conve
  LEFT JOIN detalles_venta dtv
  ON conve.id_contr=dtv.contrato WHERE ";
        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  pedido_contr, "
                    . "  ' ', "
                    . "  ident_vent, "
                    . "  ' ', "
                    . "  nombre_venta"
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {

            } else {
                $consulta .= " AND ";
            }
        }
        $consulta .= "  AND conve.estado='ACTIVO' AND conve.fpago_vent='CUOTAS'
  GROUP BY id_contr order by nombre_venta ASC ";
    } else {

        $consulta = "SELECT
  id_contr, pedido_contr ncontrato,CONCAT(ident_vent, ' - ', nombre_venta) nomti,valcumes_vent valmes,precios_vent valven,conve.saldo,
  MAX(dtv.fvenc) fven,
  TIMESTAMPDIFF(MONTH, MAX(dtv.fvenc), CURDATE()) meses,
  DATEDIFF(MAX(dtv.fvenc), CURDATE()) diav
FROM
  contrato_venta conve
  LEFT JOIN detalles_venta dtv
  ON conve.id_contr=dtv.contrato WHERE conve.estado='ACTIVO' AND conve.fpago_vent='CUOTAS'
  GROUP BY id_contr order by nombre_venta ASC  ";
    }
    ///////////CONSULTA CLIENTES AL DIA/////////////////////////////////
} else if ($con == "CONSUL1") {
    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT
  id_contr, pedido_contr ncontrato,CONCAT(ident_vent, ' - ', nombre_venta) nomti,valcumes_vent valmes,precios_vent valven,conve.saldo,
  MAX(dtv.fvenc) fven,
  TIMESTAMPDIFF(MONTH, MAX(dtv.fvenc), CURDATE()) meses,
  DATEDIFF(MAX(dtv.fvenc), CURDATE()) diav
FROM
  contrato_venta conve
  LEFT JOIN detalles_venta dtv
  ON conve.id_contr=dtv.contrato WHERE ";
        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  pedido_contr, "
                    . "  ' ', "
                    . "  ident_vent, "
                    . "  ' ', "
                    . "  nombre_venta"
                    . ") LIKE '%" . $buscar[$i] . "%' ";
            if (($i) == count($buscar, 1) - 1) {

            } else {
                $consulta .= " AND ";
            }
        }
        $consulta .= " AND DATEDIFF(dtv.fvenc,CURDATE()) > 0 AND conve.estado='ACTIVO' AND conve.fpago_vent='CUOTAS'
  GROUP BY id_contr order by nombre_venta ASC ";
    } else {

        $consulta = "SELECT
  id_contr, pedido_contr ncontrato,CONCAT(ident_vent, ' - ', nombre_venta) nomti,valcumes_vent valmes,precios_vent valven,conve.saldo,
  MAX(dtv.fvenc) fven,
  TIMESTAMPDIFF(MONTH, MAX(dtv.fvenc), CURDATE()) meses,
  DATEDIFF(MAX(dtv.fvenc), CURDATE()) diav
FROM
  contrato_venta conve
  LEFT JOIN detalles_venta dtv
  ON conve.id_contr=dtv.contrato WHERE DATEDIFF(dtv.fvenc,CURDATE()) > 0 AND conve.estado='ACTIVO' AND conve.fpago_vent='CUOTAS'
  GROUP BY id_contr order by nombre_venta ASC  ";
    }
} else if ($con == "CONSUL2") {
    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT
  id_contr, pedido_contr ncontrato,CONCAT(ident_vent, ' - ', nombre_venta) nomti,valcumes_vent valmes,precios_vent valven,conve.saldo,
  MAX(dtv.fvenc) fven,
  TIMESTAMPDIFF(MONTH, MAX(dtv.fvenc), CURDATE()) meses,
  DATEDIFF(MAX(dtv.fvenc), CURDATE()) diav
FROM
  contrato_venta conve
  LEFT JOIN detalles_venta dtv
  ON conve.id_contr=dtv.contrato WHERE ";
        for ($i = 0; $i < count($buscar, 1); $i++) {
            $consulta .= "CONCAT( "
                    . "  pedido_contr, "
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
        $consulta .= " AND dtv.fvenc BETWEEN '" . $_POST["fini"] . "' AND '" . $_POST["ffin"] . "' AND DATEDIFF(CURDATE(),dtv.fvenc) > 30 AND DATEDIFF(CURDATE(),dtv.fvenc) < 60 AND  conve.estado='ACTIVO' AND conve.fpago_vent='CUOTAS'
  GROUP BY id_contr order by nombre_venta ASC ";
    } else {

        $consulta = "SELECT
  id_contr, pedido_contr ncontrato,CONCAT(ident_vent, ' - ', nombre_venta) nomti,valcumes_vent valmes,precios_vent valven,conve.saldo,
  MAX(dtv.fvenc) fven,
  TIMESTAMPDIFF(MONTH, MAX(dtv.fvenc), CURDATE()) meses,
  DATEDIFF(MAX(dtv.fvenc), CURDATE()) diav
FROM
  contrato_venta conve
  LEFT JOIN detalles_venta dtv
  ON conve.id_contr=dtv.contrato WHERE dtv.fvenc BETWEEN '" . $_POST["fini"] . "' AND '" . $_POST["ffin"] . "' AND DATEDIFF(CURDATE(),dtv.fvenc) > 30 AND DATEDIFF(CURDATE(),dtv.fvenc) < 60   AND conve.estado='ACTIVO' AND conve.fpago_vent='CUOTAS'
  GROUP BY id_contr order by nombre_venta ASC ";
    }
} else if ($con == "CONSUL3") {
    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT
  id_contr, pedido_contr ncontrato,CONCAT(ident_vent, ' - ', nombre_venta) nomti,valcumes_vent valmes,precios_vent valven,conve.saldo,
  MAX(dtv.fvenc) fven,
  TIMESTAMPDIFF(MONTH, MAX(dtv.fvenc), CURDATE()) meses,
  DATEDIFF(MAX(dtv.fvenc), CURDATE()) diav
FROM
  contrato_venta conve
  LEFT JOIN detalles_venta dtv
  ON conve.id_contr=dtv.contrato WHERE ";
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
        $consulta .= " AND dtv.fvenc BETWEEN '" . $_POST["fini"] . "' AND '" . $_POST["ffin"] . "' AND DATEDIFF(CURDATE(),dtv.fvenc) > 60 AND DATEDIFF(CURDATE(),dtv.fvenc) < 90 AND conve.estado='ACTIVO' AND conve.fpago_vent='CUOTAS'
  GROUP BY id_contr order by nombre_venta ASC  ";
    } else {

        $consulta = "SELECT
  id_contr, pedido_contr ncontrato,CONCAT(ident_vent, ' - ', nombre_venta) nomti,valcumes_vent valmes,precios_vent valven,conve.saldo,
  MAX(dtv.fvenc) fven,
  TIMESTAMPDIFF(MONTH, MAX(dtv.fvenc), CURDATE()) meses,
  DATEDIFF(MAX(dtv.fvenc), CURDATE()) diav
FROM
  contrato_venta conve
  LEFT JOIN detalles_venta dtv
  ON conve.id_contr=dtv.contrato WHERE dtv.fvenc BETWEEN '" . $_POST["fini"] . "' AND '" . $_POST["ffin"] . "' AND DATEDIFF(CURDATE(),dtv.fvenc) > 60 AND DATEDIFF(CURDATE(),dtv.fvenc) < 90 AND conve.estado='ACTIVO' AND conve.fpago_vent='CUOTAS'
  GROUP BY id_contr order by nombre_venta ASC ";
    }
} else if ($con == "CONSUL4") {

    if ($busq != "") {
        $busq = str_replace("+", " ", $busq);
        $buscar = explode(" ", $busq);

        $consulta = "SELECT
  id_contr, pedido_contr ncontrato,CONCAT(ident_vent, ' - ', nombre_venta) nomti,valcumes_vent valmes,precios_vent valven,conve.saldo,
  MAX(dtv.fvenc) fven,
  TIMESTAMPDIFF(MONTH, MAX(dtv.fvenc), CURDATE()) meses,
  DATEDIFF(MAX(dtv.fvenc), CURDATE()) diav
FROM
  contrato_venta conve
  LEFT JOIN detalles_venta dtv
  ON conve.id_contr=dtv.contrato WHERE ";
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
        $consulta .= " AND dtv.fvenc BETWEEN '" . $_POST["fini"] . "' AND '" . $_POST["ffin"] . "' AND DATEDIFF(CURDATE(),dtv.fvenc) > 90 AND conve.estado='ACTIVO' AND conve.fpago_vent='CUOTAS'
  GROUP BY id_contr order by nombre_venta ASC ";
    } else {

        $consulta = "SELECT
  id_contr, pedido_contr ncontrato,CONCAT(ident_vent, ' - ', nombre_venta) nomti,valcumes_vent valmes,precios_vent valven,conve.saldo,
  MAX(dtv.fvenc) fven,
  TIMESTAMPDIFF(MONTH, MAX(dtv.fvenc), CURDATE()) meses,
  DATEDIFF(MAX(dtv.fvenc), CURDATE()) diav
FROM
  contrato_venta conve
  LEFT JOIN detalles_venta dtv
  ON conve.id_contr=dtv.contrato WHERE dtv.fvenc BETWEEN '" . $_POST["fini"] . "' AND '" . $_POST["ffin"] . "' AND  DATEDIFF(CURDATE(),dtv.fvenc) > 90 AND conve.estado='ACTIVO' AND conve.fpago_vent='CUOTAS'
  GROUP BY id_contr order by nombre_venta ASC  ";
    }
}
//echo $consulta;

$contador = 0;

$consulta2 = "TRUNCATE TABLE consulcartera;";
mysqli_query($link,$consulta2);
$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $contador++;
        $pendi = $fila["valmes"] * $fila["meses"];

        $totalpen = $totalpen + $pendi;

        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $contador . " "
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["ncontrato"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["nomti"] . " "
                . "</td>"
                . "<td class=\"highlight\">$ "
                . number_format($fila["valmes"], 2, ",", ".") . ""
                . "</td>"
                . "<td class=\"highlight\">$ "
                . number_format($fila["valven"], 2, ",", ".") . " "
                . "</td>"
                . "<td class=\"highlight\">$ "
                . number_format($fila["saldo"], 2, ",", ".") . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["fven"] . " "
                . "</td>";
        $dias = "";
        if ($fila["diav"] > 0) {
            $cad .= "<td class=\"highlight\">"
                    . $fila["diav"] . " Restantes";
            $dias = $fila["diav"] . " Restantes";
        } else {
            $cad .= "<td class=\"highlight\" style=\"color:#E52117\"> "
                    . abs($fila["diav"]) . " De Retraso";
            $dias = abs($fila["diav"]) . " De Retraso";
        }

        $cad .= "</td>"
                . "</tr>";

        $consulta3 = "INSERT INTO consulcartera VALUES('" . $contador . "','" . $fila["ncontrato"] . "',"
                . "'" . $fila["nomti"] . "','$ " . number_format($fila["valmes"], 2, ",", ".") . "','$ " . number_format($fila["valven"], 2, ",", ".") . "',"
                . "'$ " . number_format($fila["saldo"], 2, ",", ".") . "','" . $fila["fven"] . "','" . $dias . "'," . $pendi . ")";
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
$salida->totalpen = $totalpen;

echo json_encode($salida);

mysqli_close($link);
?>