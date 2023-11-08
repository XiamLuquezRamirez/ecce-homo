<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();

$consulta = "SELECT TK_ADMIN FROM config_empresa";
$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $admin = $fila['TK_ADMIN'];
    }
}

$consulta = "SELECT * FROM contrato_arriendo contr "
        . "LEFT JOIN clientes cli ON contr.ced_cli=cli.inde_cli "
        . "LEFT JOIN funerarias fun ON contr.funeraria=fun.id_fune "
        . "where contr.id_arriendo='" . $_REQUEST["id"] . "'";

$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $OrdInhum = $fila["OrdInhum"];
        $fec_crea = $fila["fec_crea"];
        $ciuda = $fila["ciuda"];
        $cemen = acentos($fila["cemen"]);
        $boveda = $fila["boveda"];
        $jardin = $fila["jardin"];
        $zona = $fila["zona"];
        $lote = $fila["lote"];
        $muerto = acentos($fila["muerto"]);
        $tiempo = acentos($fila["tiempo"]);
        $desde = $fila["desde"];
        $hasta = $fila["hasta"];
        $fec_falle = $fila["fec_falle"];
        $funeraria = acentos($fila["nom_fune"]);
        $txt_fecha_sepe = $fila["txt_fecha_sepe"];
        $telef = $fila["telef"];
        $dir_cli = $fila["dir_cli"];
        $ced_cli = $fila["ced_cli"];
        $nom_cli = acentos($fila["nom_cli"]);
        $barrio = acentos($fila["barrio"]);
    }
}

if ($cemen == "NUEVO") {
    $cem = "CEMENTERIO NUEVO,";
} else {
    $cem = "JARDINES DEL ECCE HOMO,";
}

class PDF extends FPDF {

    //Cabecera de página
    function Header() {
        if ($GLOBALS['cemen'] == "NUEVO") {
            $this->Image('Img/cabecera_pdf_cnuev.png', 10, 8, 100);
        } else {
            $this->Image('Img/cabecera_pdf.png', 10, 8, 100);
        }
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(100, 25, '', 1, 0, 'C');
        $this->cell(0, 25, utf8_decode('CONTRATO DE ARRIENDO DE BÓVEDA'), 1, 2, 'C');
    }

    function TablaBasica() {
        $this->SetFont('Arial', 'B', 12);
        //*****
        $this->SetXY(110, 37);
        $this->Cell(30, 8, 'FECHA', 1, 2, 'C');
        $this->Cell(30, 9, $GLOBALS['fec_crea'], 1, 0, 'C');
        $this->SetXY(140, 37);
        $this->Cell(60, 8, utf8_decode('ORDEN DE INHUMACIÓN'), 1, 2, 'C');
        $this->Cell(60, 9, $GLOBALS['OrdInhum'], 1, 0, 'C');
        // $this->Line(10, 45.5, 200, 45.5);
//*****
        $this->SetXY(10, 37);
        $this->Cell(20, 8, 'Toma en Arriendo: ', 0, 'L');


        if ($GLOBALS['cemen'] == "NUEVO") {
            $this->SetXY(10, 44);
            $this->Cell(10, 8, utf8_decode('Bóveda: ' . $GLOBALS['boveda']), 0, 'L');
            $this->Line(27, 50.5, 97, 50.5);
        } else {
            $this->SetXY(10, 44);
            $this->Cell(10, 8, 'Jardin: ' . utf8_decode($GLOBALS['jardin']), 0, 'L');
            $this->Line(25, 50.5, 35, 50.5);
            $this->SetXY(40, 44);
            $this->Cell(10, 8, 'Zona: ' . utf8_decode($GLOBALS['zona']), 0, 'L');
            $this->Line(53, 50.5, 63, 50.5);
            $this->SetXY(70, 44);
            $this->Cell(10, 8, utf8_decode('Lote N°: ' . $GLOBALS['lote']), 0, 'L');
            $this->Line(87, 50.5, 97, 50.5);
        }



$this->SetFont('Arial', 'B', 11);
        $this->SetXY(10, 59);
        $this->Cell(20, 8, utf8_decode('Contratante: ' . $GLOBALS['ced_cli'].' -  '.$GLOBALS['nom_cli'] ), 0, 'L');
        $this->Line(10, 58.5, 200, 58.5);

        $this->SetXY(10, 65);
        $this->Cell(20, 8, utf8_decode('Dirección: ' . $GLOBALS['dir_cli']. ' '.$GLOBALS['barrio']), 0, 'L');
       
        $this->SetXY(130, 65);
        $this->Cell(20, 8, utf8_decode('Telefono: ' . $GLOBALS['telef']), 0, 'L');
        $this->Line(10, 65.5, 200, 65.5);

        $this->SetXY(10, 72);
        $this->Cell(20, 8, utf8_decode('Para Inhumar a: ' . $GLOBALS['muerto']), 0, 'L');
        $this->Line(10, 71.5, 200, 71.5);

        //*****
        $this->SetXY(10, 79);
        $this->Cell(20, 8, utf8_decode('Por: ' . $GLOBALS['tiempo']), 0, 0, 'L');

        $parfecini = explode("-", $GLOBALS["desde"]);

        $this->SetXY(60, 79);
        $this->Cell(7, 8, utf8_decode('Del día: ') . $parfecini[2], 0, 1, 'C');

        $this->SetXY(80, 79);
        $this->Cell(7, 8, 'Mes: ' . $parfecini[1], 0, 1, 'C');

        $this->SetXY(100, 79);
        $this->Cell(7, 8, utf8_decode('Año: ') . $parfecini[0], 0, 1, 'C');


        $this->SetXY(125, 79);
        $this->Cell(20, 8, utf8_decode('Hasta '), 0, 0, 'L');

        $parfecFin = explode("-", $GLOBALS["hasta"]);
        $this->SetXY(145, 79);
        $this->Cell(7, 8, utf8_decode('El día: ') . $parfecFin[2], 0, 1, 'C');

        $this->SetXY(165, 79);
        $this->Cell(7, 8, 'Mes: ' . $parfecFin[1], 0, 1, 'C');

        $this->SetXY(185, 79);
        $this->Cell(7, 8, utf8_decode('Año: ') . $parfecFin[0], 0, 1, 'C');

        $this->Line(10, 78.5, 200, 78.5);

        $this->SetXY(10, 87);
        $this->Cell(20, 8, utf8_decode('Fecha de Fallecimiento: ' . $GLOBALS['fec_falle']), 0, 'L');

        $this->SetXY(90, 87);
        $this->Cell(0, 8, utf8_decode('Funeraria: ' . $GLOBALS['funeraria']), 0, 'L');
        $this->Line(10, 86.5, 200, 86.5);

        $this->SetXY(10, 93);
        $this->Cell(40, 8, utf8_decode('Hora del Sepelio: ' . $GLOBALS['txt_fecha_sepe']), 0, 'L');
        $this->Line(10, 94, 200, 94);
//      $this->SetXY(150, 86);
//      $this->Cell(0, 8, utf8_decode('Teléfono: '.$GLOBALS['telef']), 0, 'L');
        $this->Line(10, 104, 200, 104);
        // $this->Line(10, 95.5, 200, 95.5);

        $this->SetFont('Arial', '', 10);
        $this->SetXY(10, 105);
        $this->MultiCell(190, 5, utf8_decode('Entre los sucritosa saber ' . $GLOBALS['admin'] . ' '
                        . 'Administrador(a) de ' . $GLOBALS['cem'] . ' debidamente autorizado(a) por el Obispo de '
                        . 'la Diócesis de Valledupar quien en su representante legal y que por este documento '
                        . 'y para todos los efectos de este contrato se denominara el CONTRATANTE, por una parte '
                        . 'y por la otra  ' . $GLOBALS['nom_cli'] . ' con número de identificación ' . $GLOBALS['ced_cli'] . ', mayor de edad y vecino de esta ciudad y que en '
                        . 'adelante se denominara el BENEFICIARIO, hemos convenido celebrar el presente contrato, '
                        . 'el cual rige por los articulos 870 y s.s. del Código Civil y estará regulado por las '
                        . 'siguiemtes cláusulas: PRIMERA: -Objeto- La DIOCESIS DE VALLEDUPAR/' . $GLOBALS['cem'] . ' '
                        . 'transmite al BENEFICIARIO el USO Y GOCE temporal sobre el bien descrito anteriormente, '
                        . 'para inhumar el cadáver de ' . $GLOBALS['muerto'] . '. SEGUNDA. -Duración-. El tiempo de '
                        . 'arriendo de una bóveda para inhumar a un adulto es de ' . $GLOBALS['tiempo'] . ' a partir de la  '
                        . 'fecha del contrato. Cumpliendo el plazo, cesa inmediatamente el derecho de USO Y GOCE del '
                        . 'BENEFICIARIO, es decir los restos depositados deben exhumarse. PARAGRAFO. -EL BENEFICIARIO '
                        . 'deberá comunicar con una antelación no inferior a treinta(30) días al vencimiento del '
                        . 'contrato, sí prorroga el mismo, acogiéndose a las tarifas vigentes al momento de la prorroga. '
                        . 'Si el BENEFICIARIO no manifiesta su voluntad de prórroga, AUTORIZA por este mismo instrumento  '
                        . 'a depositar los restos en fosa común debidamente rotulados. TERCERA.- Obligaciones del '
                        . 'BENEFICIARIO- Los familiares de los difuntos, están en la obligación de una vez cumplido el  '
                        . 'plazo del contrato, efectuar la exhumación y llevar los restos a osario particular. Los  '
                        . 'gastos que ocasionen la exhumacion de los restos,el valor del osario y demás gastos correrán '
                        . 'por cuenta del BENEFICIARIO, quien además se comprometen a cumplir con lo establecido en el  '
                        . 'Reglamento de  ' . $GLOBALS['cem'] . ' en cuanto a las inhumaciones y exhumaciones, colocación de lápidas '
                        . 'y cualquier otra actividad que requiera autorización o pago previo a la Administración, quien no está '
                        . 'en la obligación de llamar o comunicar a los deudos de las personas fallecidas para que se acerquen '
                        . 'a realizar el trámite de la exhumación. Excepto los que tengan póliza individual y/o  empresarial y se encuentren al día en los pagos. CUARTA.- RESPONSABILIDAD DE LAS PARTES- EL BENEFICIARIO '
                        . 'exonera de culpa o responsabilidad al CONTRATANTE por los daños o deterioros producidos por causas '
                        . 'naturales, hechos fortuitos o fuerza mayor, dolosos o culposos de terceros no subordinados a dependientes '
                        . 'del CONTRATANTE, así mismo lo autoriza anticipadamente para el traslado de los restos humanos '
                        . 'a un lugar que garantice la integridad, si la bóveda, sepultura u osario llegare a constituir '
                        . 'ruina o peligro para la salud o seguridad de la comunidad. Cualquier cambio de información '
                        . 'suministrada para su ubicación, debe ser comunicada a la Adminitración. PARAGRAFO -EL BENEFICIARIO '
                        . 'manifiesta que se acoge a lo aquí estipulado y al Reglamento de ' . $GLOBALS['cem'] . ' Para constancia '
                        . 'se suscribe por las partes, hoy ' . $GLOBALS['fec_crea'] . ''));

//

        $y = $this->GetY();

        $this->SetXY(10, $y + 15);
        $this->Cell(15, 8, 'CONTRATANTE ', 0, 0, 'L');
        $this->Line(10, $y + 15, 60, $y + 15);
        $this->SetXY(150, $y + 15);
        $this->Cell(15, 8, 'BENEFICIARIO ', 0, 2, 'L');
        $this->Cell(15, 3, 'CC:', 0, 0, 'L');
        $this->Line(150, $y + 15, 200, $y + 15);
    }

    //Pie de página
    function Footer() {

        $this->SetY(-10);

        $this->SetFont('Arial', 'I', 8);

        $this->Cell(0, 10, utf8_decode('Página Web: www.funerarialaesperanza.org - E-mail: esperanzaeccehomo@hotmail.com'), 0, 0, 'C');
    }

}

//Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetY(40);
$pdf->TablaBasica();
$pdf->SetFont('Times', '', 12);
//Aquí escribimos lo que deseamos mostrar...
$pdf->Output('I', 'CONTRATO DE ARRIENDO DE ' . $GLOBALS['nom_cli'] . '.pdf');

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>