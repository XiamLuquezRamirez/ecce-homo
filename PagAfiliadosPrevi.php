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
        . "<i class=\"fa fa-angle-right\"></i> Cedula"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Nombre"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Fecha de Afiliación"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> PAEE"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Cuota"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Estado"
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

    $consulta = "SELECT * FROM cliente cli LEFT JOIN plan pl ON cli.idPlan_cliente=pl.idPlan  WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT("
                . "  cli.Cedula_cliente, "
                . "  ' ', "
                . "  cli.Nombres_cliente, "
                . "  ' ', "
                . "  pl.Nombre_plan, "
                . "  ' ', "
                . "  cli.Apellidos_cliente "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {

        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND cli.idEmpresa_cliente='" . $_POST["codemp"] . "'  order by cli.Apellidos_cliente ASC LIMIT " . $regemp . "," . $regmos;
} else {

    $consulta = "SELECT * FROM cliente cli LEFT JOIN plan pl ON cli.idPlan_cliente=pl.idPlan WHERE cli.idEmpresa_cliente='" . $_POST["codemp"] . "'  order by cli.Apellidos_cliente ASC  LIMIT " . $regemp . "," . $regmos;
}

//echo $consulta;

$cuotaTotal = 0;
$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $cuotaTotal = $cuotaTotal + $fila["Cuota_cliente"];
        $cod = $fila["idCliente"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . $fila["Cedula_cliente"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . acentos($fila["Apellidos_cliente"] . " - " . $fila["Nombres_cliente"]) . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["Fecha_ingreso_cliente"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["Nombre_plan"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "$ " . number_format($fila["Cuota_cliente"], 2, ",", ".") . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["Estado_cliente"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<a  onclick=\"$.editDatAfil('" . $cod . "')\"  class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-edit\"></i> Editar</a>"
                . "<a  onclick=\"$.DeleteAfil('" . $cod . "')\"  class=\"btn default btn-xs red\">"
                . "<i class=\"fa fa-trash-o\"></i> Eliminar</a>"
                . "<a onclick=\"$.Beneficiarios('" . $cod . "')\" class=\"btn default btn-xs blue-dark\">"
                . "<i class=\"fa fa-plus\"></i> Agregar Beneficiarios</a>"
                . "<a onclick=\"$.PrintContrato('" . $cod . "')\" class=\"btn default btn-xs green-meadow\">"
                . "<i class=\"fa fa-print\"></i> Imprimir Contrato</a>"
                . "<a onclick=\"$.EnvioNotif('" . $cod . "')\" class=\"btn default btn-xs purple\">"
                . "<i class=\"fa fa-info\"></i> Enviar Notificación</a>"
                . "</td>"
                . "</tr>";
    }
}




$consulta = "SELECT Nit_empresa,COUNT(*) conta,Nombre_empresa,SUM(cli.Cuota_cliente) tot FROM empresa emp LEFT JOIN cliente cli ON emp.idEmpresa=cli.idEmpresa_cliente  WHERE emp.idEmpresa='" . $_POST["codemp"] . "' AND cli.Estado_cliente='ACTIVO' ";
$resultado2 = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado2) > 0) {
    while ($fila = mysqli_fetch_array($resultado2)) {
        $NombEmpr = $fila["Nombre_empresa"];
        $Nit_empresa = $fila["Nit_empresa"];
         $cuotaTotal = $fila["tot"];
         $conta = $fila["conta"];
    }
}

$consulta = "SELECT COUNT(*) conta FROM cliente cli LEFT JOIN plan pl ON cli.idPlan_cliente=pl.idPlan WHERE cli.idEmpresa_cliente='" . $_POST["codemp"] . "' ";
$resultado2 = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado2) > 0) {
    while ($fila = mysqli_fetch_array($resultado2)) {
       
        $contador = $fila["conta"];
       
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
$salida->NombEmpr = $NombEmpr;
$salida->contador = $conta;
$salida->Cuota = number_format($cuotaTotal, 2, ",", ".");

echo json_encode($salida);

mysqli_close($link);

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>