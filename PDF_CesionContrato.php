<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();

$consulta3 = "SET lc_time_names = 'es_CO';";
//echo $consulta;
mysqli_query($link, $consulta3);

$consulta = "SELECT
  ces.id id,
  ces.fecha fec,
  CONCAT(DATE_FORMAT( ces.fecha, '%d'),' DE ',UPPER(DATE_FORMAT( ces.fecha, '%M')),' DEL ',DATE_FORMAT( ces.fecha, '%Y')) fecor,
  cli1.inde_cli identit,
  cli1.nom_cli nomtit,
  CONCAT(cli1.dir_cli,' ',cli1.barrio) dirtit,
  cli2.inde_cli indecesi,
  cli2.nom_cli nomcesi,
  CONCAT(cli2.dir_cli,' ',cli2.barrio) dircesi,
  contr.pedido_contr conse,
  ces.textubica ubi,
  ces.documento doc,
  ces.ttraspado tras,
  ces.nota nota,
  ces.contrato contrato,
  ces.tubi tubi,
  contr.fecha_vent fec,
  ces.ntitprop nti
FROM
  cesioncontrato ces
  LEFT JOIN clientes cli1
    ON ces.titular = cli1.inde_cli
  LEFT JOIN clientes cli2
    ON ces.cesionario = cli2.inde_cli
  LEFT JOIN contrato_venta contr
    ON ces.contrato=contr.id_contr
where ces.id='" . $_REQUEST["id"] . "'";
//echo $consulta;
$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $conse = $fila["conse"];
        $fec = $fila["fec"];
        $identit = $fila["identit"];
        $nomtit = acentos($fila["nomtit"]);
        $dirtit = acentos($fila["dirtit"]);
        $indecesi = $fila["indecesi"];
        $nomcesi = acentos($fila["nomcesi"]);
        $dircesi = acentos($fila["dircesi"]);
        $ubi = $fila["ubi"];
        $doc = $fila["doc"];
        $tras = $fila["tras"];
        $nota = acentos($fila["nota"]);
        $tubi = $fila["tubi"];
        $fech = $fila["fec"];
        $contrato = $fila["contrato"];
        $fecor = $fila["fecor"];
        $ntitprop = $fila["nti"];
    }
}


if ($tubi == "lote") {
    $tubi = "lote";
} else {
    $tubi = "osario";
}


if ($doc == "TITULO DE PROPIEDAD") {
    $doc = "del título de propiedad número " . $conse . '.';
} else {
    $doc = "del denuncio por perdida del título de propiedad expedido a mi nombre, a JARDINES DEL ECCE HOMO DE LA DIOCESIS DE VALLEDUPAR.";
}

//   $this->Image('Img/cabecera_pdf.png',10,8,100);

class PDF extends FPDF {

    //Cabecera de página
    function Header() {

        $this->Image('Img/cabecera_pdf.png', 60, 8, 90);
    }

    function TablaBasica() {
        $this->SetFont('Arial', 'B', 10);
        //*****
        $this->Ln(3);
        // $this->SetXY(0, 37);
        if ($GLOBALS['tras'] == "HERENCIA") {
            $this->Cell(0, 5, utf8_decode('CESIÓN PEDIDO DE CONTRATO'), 0, 0, 'C');
        } else {
            $this->Cell(25, 5, utf8_decode('CESIÓN DE USO Y GOCE DEL CONTRATO:'), 0, 0, 'C');
        }




//*****
        $this->SetXY(10, 55);
        //$this->Cell(95, 8, utf8_decode($GLOBALS['fecor']), 0,2, 'L');

        $this->SetFont('Arial', '', 10);

        $this->SetFont('Arial', '', 10);
        if ($GLOBALS['tras'] == "HERENCIA") {
            $this->MultiCell(190, 5, utf8_decode('El (La) Sucrito(a) ' . $GLOBALS['nomcesi'] . ' identificado(a) con cédula de '
                            . 'ciudadanía número ' . $GLOBALS['indecesi'] . ', con dirección ' . $GLOBALS['dircesi'] . ' declara que através de carta extra juicio'
                            . ' a obtenido PODER por herencia aportando documentación requerida debidamente para adquirir, el ' . $GLOBALS['tubi'] . ' de '
                            . 'propieda de ' . $GLOBALS['nomtit'] . ' identificado(a) con cédula de ciudadania ' . $GLOBALS['identit'] . ', y en consecuencia '
                            . 'las acciones, privilegios, beneficios y obligaciones inherentes a la naturaleza del pedido contrato que por este instrumento '
                            . 'cedo, se transfieren al cesionario, a quien hago entrega del titulo de propiedad número ' . $GLOBALS['ntitprop'] . '. Para que '
                            . 'esta cesión surta la plenitud de los efectos legales, notifico a JARDINES DEL ECCE HOMO DE LA DIOCESIS DE VALLEDUPAR, la seción '
                            . 'que realizo en la fecha ' . $GLOBALS['fech'] . '. En consecuencia, el titulo correspondiente debe ser otorgado a favor del cesionario. quedando autorizadas, '
                            . ' las siguientes personas para ordenar inhumaciones y exhumaciones en el mencionado contrato:'));
        } else {
            $this->MultiCell(190, 5, utf8_decode('El (La) Sucrito(a) ' . $GLOBALS['nomtit'] . ' identificado(a) con cédula de '
                            . 'ciudadanía número ' . $GLOBALS['identit'] . ', con dirección ' . $GLOBALS['dirtit'] . ' manifiesto de manera libre, autónoma y expontánea que '
                            . ' cedo el uso y goce del ,' . $GLOBALS['tubi'] . ' adquirido mediante el contrato número ' . $GLOBALS['conse'] . ' de fecha '
                            . '' . $GLOBALS['fec'] . ', aportando la documentación requerida por la administración del Parque Cementerio JARDINES DEL ECCE HOMO'
                            . 'DE LA DIOCESIS DE VALLEDUPAR, consistentes en un ' . $GLOBALS['tubi'] . ' al señor(a) ' . $GLOBALS['nomcesi'] . ' identifiado(a) con'
                            . ' cédula de ciudadanía numero ' . $GLOBALS['indecesi'] . ', con residencia ' . $GLOBALS['dircesi'] . ', en consecuencia las '
                            . 'las acciones, privilegios, beneficios y obligaciones inherentes a la naturaleza del pedido contrato que por este instrumento '
                            . 'cedo, se transfieren al cesionario, a quien hago entrega' . $GLOBALS['doc'] . ' Para que '
                            . 'esta cesión surta la plenitud de los efectos legales, notifico a JARDINES DEL ECCE HOMO DE LA DIOCESIS DE VALLEDUPAR, la seción '
                            . 'que realizo en la ' . $GLOBALS['fech'] . '. En consecuencia, el TITULO DE PROPIEDAD correspondiente debe ser otorgado a favor del cesionario. quedando autorizadas, '
                            . ' las siguientes personas para ordenar inhumaciones y exhumaciones en el mencionado contrato:'));
        }

        $y = $this->GetY();


        $consulta = "SELECT iden_persocont,nom_persocont FROM personas_contrato_cesion  WHERE idcontr_cesion='" . $_REQUEST['id'] . "'";
        //echo $consulta;
        $item = 0;
        $resultado = mysqli_query($GLOBALS['link'], $consulta);
        $this->SetXY(10, $y);
        $this->SetFont('Arial', 'B', 10);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $item = $item + 1;
                $this->Cell(50, 5, utf8_decode($fila['iden_persocont'] . ' - ' . $fila['nom_persocont']), 0);
                $this->Ln(4);
            }
        }
        $this->Ln(4);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(25, 5, utf8_decode('UN ' . strtoupper($GLOBALS['tubi'] . ' UBICADO EN EL ' . $GLOBALS['ubi'])), 0, 2, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(25, 5, utf8_decode('Para efectos legales, firmo en Valledupar el día ' . $GLOBALS['fecor'] . '.'), 0, 0, 'L');

        $this->Ln(7);
        $this->SetFont('Arial', 'B', 10);
        $this->MultiCell(190, 5, utf8_decode('NOTA ACLARATORIA: '));
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(190, 5, utf8_decode($GLOBALS['nota']));


        $this->Ln(6);
        $this->Cell(190, 8, utf8_decode('FIRMA:'), 0, 2, 'L');

        $this->Ln(3);
        $y = $this->GetY();

        if ($GLOBALS['tras'] == "HERENCIA") {
            $this->SetXY(10, $y + 15);
            $this->Cell(15, 8, utf8_decode('ACEPTO LA CESIÓN:'), 0, 2, 'L');
            $this->Cell(15, 3, 'CC:', 0, 0, 'L');
            $this->Line(10, $y + 15, 60, $y + 15);
            $this->SetXY(150, $y + 15);
        } else {
            $this->SetXY(10, $y + 15);
            $this->Cell(15, 8, 'CESIONARIO ', 0, 2, 'L');
            $this->Cell(15, 3, 'CC:', 0, 0, 'L');
            $this->Line(10, $y + 15, 60, $y + 15);
            $this->SetXY(150, $y + 15);

            $this->Cell(15, 8, utf8_decode('ACEPTO LA CESIÓN'), 0, 2, 'L');
            $this->Line(150, $y + 15, 200, $y + 15);
        }
    }

    //Pie de página
    function Footer() {

        $this->SetY(-15);

        $this->SetFont('Arial', 'I', 8);

        $this->Cell(0, 3, utf8_decode('Página Web: www.funerarialaesperanza.org - E-mail: esperanzaeccehomo@hotmail.com'), 0, 0, 'C');
    }

}

//Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetY(40);
$pdf->TablaBasica();
$pdf->SetFont('Times', '', 12);
//Aquí escribimos lo que deseamos mostrar...
$pdf->Output('I', 'CesionContrato' . $conse . '.pdf');

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>