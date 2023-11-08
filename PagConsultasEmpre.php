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
//$con = $_POST["con"];
$buscar = array();
$cbp = "";

$regemp = 0;
$pagact = 1;
if ($pag != null) {
    $regemp = (intval($pag) - 1) * $regmos;
    $pagact = intval($pag);
}

if ($_POST["cons"] == "mes") {
    $cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> #"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> NOMBRE"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> NO. DE AFILIADOS"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> VALOR"
            . "</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";
} else if ($_POST["cons"] == "empre") {
    $cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> #"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> MES"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> VALOR"
            . "</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";
} else {

    $cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> #"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> NOMBRE"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> VALORS"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> FEC. VENCIMIENTO"
            . "</th>"
            . "<th>"
            . "<i class=\"fa fa-angle-right\"></i> DÍAS"
            . "</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";
}





if ($_POST["cons"] == "mes") {

    $consulta = "SELECT
  idEmpresa_cliente,
  IFNULL(emp.Nit_empresa, '') nit,
  Nombre_empresa,
  (SELECT
    COUNT(*)
  FROM
    cliente
  WHERE idEmpresa_cliente = idEmpresa
    AND estado_cliente = 'ACTIVO') afil,
  cart.Valor_cartera val
FROM
  cliente cli
  LEFT JOIN empresa emp
    ON cli.idEmpresa_cliente = emp.idEmpresa
    LEFT JOIN cartera cart
    ON emp.idEmpresa=cart.idEmpresa_cartera
WHERE cart.anio_cartera='" . $_POST["anio"] . "' AND cart.mes_cartera='" . $_POST["mes"] . "'
GROUP BY idEmpresa_cliente
ORDER BY Nombre_empresa ASC";

    ///////////CONSULTA CLIENTES AL DIA/////////////////////////////////
} else if ($_POST["cons"] == "empre") {
    $consulta = "SELECT
  cart.mes_cartera,

  cart.Valor_cartera val
FROM
  cliente cli
  LEFT JOIN empresa emp
    ON cli.idEmpresa_cliente = emp.idEmpresa
  LEFT JOIN cartera cart
    ON emp.idEmpresa = cart.idEmpresa_cartera
WHERE cart.anio_cartera = '" . $_POST["anio"] . "' AND cart.idEmpresa_cartera='" . $_POST["empre"] . "'
GROUP BY cart.mes_cartera ORDER BY idCartera ASC";
} else {

    $consulta = "SELECT 
 emp.Nombre_empresa nom,cart.Valor_cartera var,cart.Fecha_vence_cartera fvenc,DATEDIFF(cart.Fecha_vence_cartera,CURDATE()) diav
FROM
  cartera cart 
  LEFT JOIN empresa emp 
    ON cart.idEmpresa_cartera = emp.idEmpresa 
WHERE idCartera IN 
  (SELECT 
    MAX(idCartera) 
  FROM
    cartera 
  GROUP BY idEmpresa_cartera)";
}
//echo $consulta;

$contador = 0;
$totalCart = 0;


$consulta2 = "TRUNCATE TABLE consulcartera;";
mysqli_query($link,$consulta2);
$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $contador++;

        if ($_POST["cons"] == "mes") {

            $cad .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $contador . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["Nombre_empresa"] . ""
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["afil"] . " "
                    . "</td>"
                    . "<td class=\"highlight\">$ "
                    . number_format($fila["val"], 2, ",", ".") . ""
                    . "</td>"
                    . "</tr>";

            $consulta3 = "INSERT INTO consulcartera VALUES('" . $contador . "','" . $fila["Nombre_empresa"] . "',"
                    . "'" . $fila["afil"] . "','" . $fila["val"] . "','',"
                    . "'','','','0')";
//            echo $consulta3;
            mysqli_query($link,$consulta3);
        } else if ($_POST["cons"] == "empre") {

            $totalCart = $totalCart + $fila["val"];
            $cad .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $contador . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["mes_cartera"] . ""
                    . "</td>"
                    . "<td class=\"highlight\">$ "
                    . number_format($fila["val"], 2, ",", ".") . ""
                    . "</td>"
                    . "</tr>";

            $consulta3 = "INSERT INTO consulcartera VALUES('" . $contador . "','" . $fila["mes_cartera"] . "',"
                    . "'" . $fila["val"] . "','','',"
                    . "'','','','0')";
            mysqli_query($link,$consulta3);
        } else {
            $cad .= "<tr>"
                    . "<td class=\"highlight\">"
                    . $contador . " "
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["nom"] . ""
                    . "</td>"
                    . "<td class=\"highlight\">$ "
                    . number_format($fila["var"], 2, ",", ".") . ""
                    . "</td>"
                    . "<td class=\"highlight\">"
                    . $fila["fvenc"] . " "
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
        }
    }
}


$cad .= "</tbody>"
        . "</table>";

   $contador = 0;
    $totalCart = 0;
    $totalAfi = 0;

if ($_POST["cons"] == "mes") {
    $consulta = "SELECT
  idEmpresa_cliente,
  IFNULL(emp.Nit_empresa, '') nit,
  Nombre_empresa,
  (SELECT
    COUNT(*)
  FROM
    cliente
  WHERE idEmpresa_cliente = idEmpresa
    AND estado_cliente = 'ACTIVO') afil,
  cart.Valor_cartera val
FROM
  cliente cli
  LEFT JOIN empresa emp
    ON cli.idEmpresa_cliente = emp.idEmpresa
    LEFT JOIN cartera cart
    ON emp.idEmpresa=cart.idEmpresa_cartera
WHERE cart.anio_cartera='" . $_POST["anio"] . "' AND cart.mes_cartera='" . $_POST["mes"] . "'
GROUP BY idEmpresa_cliente";
 
    $resultado2 = mysqli_query($link,$consulta);
    if (mysqli_num_rows($resultado2) > 0) {

        while ($fila = mysqli_fetch_array($resultado2)) {
            $contador += 1;
            $totalCart = $totalCart + $fila["val"];
            $totalAfi = $totalAfi + $fila["afil"];
        }
    }
   } else if ($_POST["cons"] == "empre") {
    $consulta = "SELECT
  COUNT(*) conta
FROM
  empresa emp
  LEFT JOIN cliente cli
    ON emp.idEmpresa = cli.idEmpresa_cliente
WHERE EMP.idEmpresa = '" . $_POST["empre"] . "'
  AND cli.Estado_cliente = 'ACTIVO' ";

    //echo $consulta;

    $resultado2 = mysqli_query($link,$consulta);
    if (mysqli_num_rows($resultado2) > 0) {

        while ($fila = mysqli_fetch_array($resultado2)) {
            $totalAfi = $fila["conta"];
        }
    }
}else{
        $consulta = "SELECT 
 COUNT(*) conta
FROM
  cartera cart 
  LEFT JOIN empresa emp 
    ON cart.idEmpresa_cartera = emp.idEmpresa 
WHERE idCartera IN 
  (SELECT 
    MAX(idCartera) 
  FROM
    cartera 
  GROUP BY idEmpresa_cartera)";
    
}


//echo $consulta;





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
$salida->totalCart = $totalCart;
$salida->totalAfi = $totalAfi;

echo json_encode($salida);

mysqli_close($link);
?>