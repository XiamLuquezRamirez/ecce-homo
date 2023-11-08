<?php
session_start();
include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
$hoy = date("Y");
$titulo = "";
$cementerio = "";
$titulo = "LISTA DE CLIENTES CON CONTRATO DE VENTAS - LOTES Y OSARIOS ";


header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Listado_Contratos_Ventas.xls");
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
            <th class="tg-0lax" colspan="8" rowspan="3"><h2><?php echo $titulo; ?></h2> </th>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>#</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>N° CONTRATO</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>IDENTIFICACION</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>NOMBRE</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>DIRECCIÓN</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>TÉLEFONO</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>TIPO</b></td>
            <td class="tg-1wig" style="border: #000 1px solid;"><b>VALOR</b></td>
        </tr>
        
  

        <?php
        $Conta = 1;

        $sql = "SELECT 
                contven.ident_vent ced,
                contven.nombre_venta nom,
                CONCAT(cli.dir_cli,' ',cli.barrio) dir,
                cli.tel_cli tel,
                 contven.pedido_contr ncont,
                 contven.precios_vent valor,		
                 'VENTA DE LOTE' tip
               FROM
                 venta_deta_lote ventlot 
                 LEFT JOIN contrato_venta contven 
                   ON ventlot.id_venta = contven.id_contr 
                   LEFT JOIN clientes cli
                   ON contven.ident_vent=cli.inde_cli
                   GROUP BY ventlot.id_venta
                   UNION ALL
               SELECT 
                contven.ident_vent ced,
                contven.nombre_venta nom,
                CONCAT(cli.dir_cli,' ',cli.barrio) dir,
                cli.tel_cli tel,
                 contven.pedido_contr ncont,
                 contven.precios_vent valor,		
                 'VENTA DE OSARIO' tip
               FROM
                 venta_deta_osario ventosa 
                 LEFT JOIN contrato_venta contven 
                   ON ventosa.id_venta = contven.id_contr 
                   LEFT JOIN clientes cli
                   ON contven.ident_vent=cli.inde_cli
                   GROUP BY ventosa.id_venta";
        $resultado = mysqli_query($link, $sql);

        while ($data = mysqli_fetch_array($resultado)) {
            ?>
            <tr>
                <td style="vertical-align: middle;border: #000 1px solid;"><?php echo $Conta; ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo utf8_decode(acentos($data['ncont'])); ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo utf8_decode(acentos($data['ced'])); ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;text-align: justify;"><?php echo utf8_decode($data['nom']); ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;"><?php echo utf8_decode(acentos($data['dir'])); ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;"><?php echo utf8_decode(acentos($data['tel'])); ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;"><?php echo utf8_decode($data['tip']); ?></td>
                <td style="vertical-align: middle;border: #000 1px solid;"><?php echo '$ '.number_format($GLOBALS['valor'], 2, ",", "."); ?></td>
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
