<?php
session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
$hoy = date("Y");
$titulo = "";
$cementerio = "";
if ($_REQUEST['cemen'] == "NUEVO") {
    $titulo = "LISTA DE CLIENTES NOTIFICADOS - CEMENTERIO NUEVO - " . $_REQUEST['fini'] . " a " . $_REQUEST['ffin'];
    $cementerio = "CementerioNuevo";
} else {
    $cementerio = "JardinesEcceHomo";
    $titulo = "LISTA DE CLIENTES NOTIFICADOS - JARDINES DEL ECCE HOMO - " . $_REQUEST['fini'] . " a " . $_REQUEST['ffin'];
}
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=ListadoClientes" . $cementerio . ".xls");
?>
<meta charset="utf-8"/>
<style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;}
    .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
           overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
           font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg .tg-1wig{font-weight:bold;text-align:left;vertical-align:top}
    .tg .tg-7fle{text-align:center;vertical-align:top;align-items: center;}
    .tg .tg-baqh{text-align:center;vertical-align:top}
    .tg .tg-0lax{background-color:#efefef;font-weight:bold;text-align:center;vertical-align:top}
</style>
<table class="tg">
    <thead>
        <tr>
            <th class="tg-0lax" colspan="6" rowspan="3"><h2><?php echo $titulo; ?></h2> </th>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>#</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>CLIENTE</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>DIRECCIÓN</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>TELÉFONOS</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>DIFUNTO</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>F. VENCIMIENTO</b></td>
        </tr>

        <?php
        $Conta = 1;

        $sql = "SELECT id_arriendo,OrdInhum, arri.muerto muer, CONCAT(arri.ced_cli,' - ',arri.nom_cli) tit, hasta,  DATEDIFF(hasta,CURDATE()) dias,CASE WHEN cli.email_cli='' THEN 'NO REGISTRADO' ELSE cli.email_cli END email, CONCAT(cli.dir_cli,' ',cli.barrio)  dir, cli.tel_cli tel, cemen cementerio FROM contrato_arriendo arri LEFT JOIN clientes cli ON arri.ced_cli=cli.inde_cli "
                . "WHERE arri.estado='ACTIVO' and cemen='" . $_REQUEST['cemen'] . "' AND hasta BETWEEN  '" . $_REQUEST['fini'] . "' AND '" . $_REQUEST['ffin'] . "' order by hasta ASC ";
      
        $resultado = mysqli_query($link, $sql);

        while ($data = mysqli_fetch_array($resultado)) {
            ?>
            <tr>
                <td style="vertical-align: middle;border: #000 1px solid;"><?php echo $Conta; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo utf8_decode(acentos($data['tit'])); ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo utf8_decode(acentos($data['dir'])); ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo utf8_decode($data['tel']); ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;"><?php echo utf8_decode(acentos($data['muer'])); ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;"><?php echo utf8_decode($data['hasta']); ?></td>
            </tr>

            <?php
            $Conta++;
        }
        ?>

    </tbody>
</table>

<?php

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}
?>
