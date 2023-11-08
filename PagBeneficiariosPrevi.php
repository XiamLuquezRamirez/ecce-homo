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
$salida = new stdClass();

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
        . "<i class=\"fa fa-angle-right\"></i> Nombre"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Parentesco"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Edad"
        . "</th>"
        . "<th>"
        . "<i class=\"fa fa-angle-right\"></i> Tipo Beneficiario"
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

    $consulta = "SELECT * FROM beneficiario WHERE ";

    for ($i = 0; $i < count($buscar, 1); $i++) {
        $consulta .= "CONCAT("
                . "  nombre_beneficiario, "
                . "  ' ', "
                . "  apellido_beneficiario, "
                . "  ' ', "
                . "  estado_beneficiario, "
                . "  ' ', "
                . "  parentesco_beneficiario "
                . ") LIKE '%" . $buscar[$i] . "%' ";
        if (($i) == count($buscar, 1) - 1) {

        } else {
            $consulta .= " AND ";
        }
    }
    $consulta .= " AND idCliente_beneficiario='" . $_POST["codAfil"] . "'  order by apellido_beneficiario ASC LIMIT " . $regemp . "," . $regmos;
} else {

    $consulta = "SELECT * FROM beneficiario WHERE idCliente_beneficiario='" . $_POST["codAfil"] . "'  order by apellido_beneficiario ASC  LIMIT " . $regemp . "," . $regmos;
}

//echo $consulta;

$cuotaTotal = 0;
$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        
        $cod = $fila["idBeneficiario"];
        $cad .= "<tr>"
                . "<td class=\"highlight\">"
                . acentos($fila["apellido_beneficiario"] . " - " . $fila["nombre_beneficiario"]) . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . acentos($fila["parentesco_beneficiario"]) . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . $fila["edad_beneficiario"] . ""
                . "</td>"
                . "<td class=\"highlight\">";
        
                if($fila["tipo_benefi"]=="basico"){
                      $cad .= "Nucleo Familiar Reportado". ""
                        . "</td>";
                }else{
                   $cad .= "Nucleo Familiar Secundario y/o Adicional" . ""
                        . "</td>";   
                }
                            
                $cad .= "<td class=\"highlight\">"
                . $fila["estado_beneficiario"] . ""
                . "</td>"
                . "<td class=\"highlight\">"
                . "<a  onclick=\"$.editDatBenef('" . $cod . "')\"  class=\"btn default btn-xs blue\">"
                . "<i class=\"fa fa-edit\"></i> Editar</a>"
                . "<a onclick=\"$.EliminarBenef('" . $cod . "')\" class=\"btn default btn-xs red\">"
                . "<i class=\"fa fa-trash-o\"></i> Eliminar</a>"
                . "</td>"
                . "</tr>";
    }
}

$consulta = "SELECT * FROM beneficiario WHERE idCliente_beneficiario='" . $_POST["codAfil"] . "' ";
$resultado2 = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado2) > 0) {
    while ($fila = mysqli_fetch_array($resultado2)) {

        $contador += 1;
    }
}

$consulta = "SELECT
  cli.contrato_cliente contra,
  cli.celular_cliente ced,
  CONCAT(
    cli.Apellidos_cliente,
    ' ',
    cli.Nombres_cliente
  ) nom,
  cli.Fecha_ingreso_cliente fec,
  cli.telefono_cliente tel,
  cli.direccion_cliente dir,
  emp.Nombre_empresa nempr,
  cli.Estado_cliente est
FROM
  cliente cli
  LEFT JOIN empresa emp
    ON cli.idEmpresa_cliente = emp.idEmpresa   WHERE cli.idCliente='" . $_POST["codAfil"] . "'";
$resultado2 = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado2) > 0) {
    while ($fila = mysqli_fetch_array($resultado2)) {
        $salida->contra = $fila["contra"];
        $salida->ced = $fila["ced"];
        $salida->nom = $fila["nom"];
        $salida->fec = $fila["fec"];
        $salida->tel = $fila["tel"];
        $salida->dir = $fila["dir"];
        $salida->nempr = $fila["nempr"];
        $salida->est = $fila["est"];
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


$salida->cad = $cad;
$salida->cad2 = $cad2;
$salida->cbp = $cbp;
$salida->contador = $contador;


echo json_encode($salida);

mysqli_close($link);

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>