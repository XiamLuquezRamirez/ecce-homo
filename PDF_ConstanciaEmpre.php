<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();


$consulta = "SELECT * FROM constancias_empre  where id_constan='" . $_REQUEST["id"] . "'";
//echo $consulta;
$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $cons_constan = $fila["cons_constan"];
        $fec_cre = $fila["fec_cre"];
        $fec_cons = $fila["fec_cons"];
        $ciudad = $fila["ciudad"];
        $inde_cli = $fila["iden_constan"];
        $nom_cli = acentos($fila["nom_constan"]);
        $dir_cli = acentos($fila["dircons"]);
        $tel_cli = $fila["telcons"];
        $consig_constan = $fila["consig_constan"];
        $valor = $fila["valor"];
        $concepto = $fila["concepto"];
    }
}

$dav = "";
$ban = "";
$tar = "";

if ($consig_constan == "DAVIVIENDA") {
    $dav = "X";
} else if ($consig_constan == "BANCOLOMBIA") {
    $ban = "X";
} else if ($consig_constan == "TARJETA") {
    $tar = "X";
}

//   $this->Image('Img/cabecera_pdf.png',10,8,100);

class PDF extends FPDF {

    //Cabecera de página
    function Header() {

        $this->Image('Img/cabecera_pdf.png', 10, 8, 100);

        $this->SetFont('Arial', 'B', 14);
        $this->Cell(100, 25, '', 1, 0, 'C');
        $this->Cell(0, 25, utf8_decode('CONSTANCIA DE CONSIGNACIÓN'), 1, 2, 'C');
        $this->Cell(0, -10, utf8_decode('N°.: ' . $GLOBALS['cons_constan']), 0, 2, 'C');
    }

    function TablaBasica() {
        $this->SetFont('Arial', '', 8);
        //*****
        $this->SetXY(10, 37);
        $this->Cell(15, 8, 'FECHA: ' . $GLOBALS['fec_cre'], 0, 0, 'L');
        $this->SetXY(60, 37);
        $this->Cell(30, 8, utf8_decode('FECHA DE CONSIGNACIÓN: ' . $GLOBALS['fec_cons']), 0, 0, 'L');
        $this->Line(10, 43.5, 200, 43.5);

//*****
        $this->SetXY(10, 42);
        $this->Cell(20, 8, 'RECIBIMOS DE: ' . utf8_decode($GLOBALS['nom_cli']), 0, 'L');
        $this->SetXY(120, 42);
        $this->Cell(20, 8, 'NIT: ' . utf8_decode($GLOBALS['inde_cli']), 0, 'L');
        $this->Line(10, 48.5, 200, 48.5);
//*****
        $this->SetXY(10, 47);
        $this->Cell(20, 8, utf8_decode('DIRECCIÓN: ' . $GLOBALS['dir_cli']), 0, 'L');
        $this->SetXY(120, 47);
        $this->Cell(20, 8, utf8_decode('TELÉFONO: ' . $GLOBALS['tel_cli']), 0, 'L');
        $this->Line(10, 53.5, 200, 53.5);

        //*****
        $this->SetXY(10, 54);
        $this->Cell(10, 8, 'PAGO:', 0, 0, 'L');
        $this->Cell(20, 8, utf8_decode('DAVIVIENDA '), 0, 'L');
        $this->SetXY(40, 55);
        $this->Cell(5, 5, $GLOBALS['dav'], 1, 1, 'C');

        $this->SetXY(47, 54);
        $this->Cell(20, 8, utf8_decode('BANCOLOMBIA '), 0, 'L');
        $this->SetXY(70, 55);
        $this->Cell(5, 5, $GLOBALS['ban'], 1, 1, 'C');

        $this->SetXY(77, 54);
        $this->Cell(20, 8, utf8_decode('TARJETA '), 0, 'L');
        $this->SetXY(92, 55);
        $this->Cell(5, 5, $GLOBALS['tar'], 1, 1, 'C');

        $this->Line(10, 60.8, 200, 60.8);
    }

    function TablaConceptos() {
        $this->SetFont('Arial', 'B', 10);
        //*****
        $this->SetXY(10, 63);
        $this->Cell(15, 8, 'CONCEPTOS: ', 0, 0, 'L');
        $this->Line(10, 69.5, 200, 69.5);
        $this->Ln(5);
        $this->SetFont('Arial', '', 9);
        $this->Cell(15, 8, 'Item', 0);
        $this->Cell(150, 8, utf8_decode('Concepto'), 0);
        $this->Cell(70, 8, 'Valor', 0);
        $this->Line(10, 74.5, 200, 74.5);


        $item = 0;
        $Y = 75;

        $this->SetXY(10, $Y);
        $item = $item + 1;
        $this->Cell(15, 3, $item, 0);
        $this->MultiCell(100, 3, utf8_decode(acentos($GLOBALS['concepto'])), 0);
        $H = $this->GetY();
        $height = $H - $Y;
        $this->SetXY(175, $Y);
        $this->Cell(40, $height, '$ ' . number_format($GLOBALS['valor'], 2, ",", "."), 0);
        $this->Ln(8);

        //dashed_line(10, y1, 200, y2, dash_length=1, space_length=1);
        $Y = $H;

        $y = $this->GetY();
        $this->SetXY(145, $Y + 1);
        $this->Cell(15, 8, 'TOTAL: ', 0, 0, 'L');


        $this->SetXY(175, $Y + 1);
        $this->Cell(15, 8, '$ ' . number_format($GLOBALS['valor'], 2, ",", "."), 0, 0, 'L');
        $this->Line(175, $Y + 1, 200, $Y + 1);

        $y = $this->GetY();

        $this->SetXY(168, $y + 20);
        $this->Cell(15, 8, 'Recibido ', 0, 0, 'L');
        $this->Line(150, $y + 20, 200, $y + 20);
    }

    //Pie de página
    function Footer() {

        $this->Ln(6);

        $this->SetFont('Arial', 'I', 8);

        $this->Cell(0, 10, utf8_decode('Página Web: www.funerarialaesperanza.org - E-mail: esperanzaeccehomo@hotmail.com'), 0, 0, 'C');
    }

}

//Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetY(40);
$pdf->TablaBasica();
$pdf->TablaConceptos();
$pdf->SetFont('Times', '', 12);
//Aquí escribimos lo que deseamos mostrar...
$pdf->Output('I', 'Constancia_' . $cons_constan . '.pdf');

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>