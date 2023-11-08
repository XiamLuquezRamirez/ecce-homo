<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();
mysqli_set_charset($link, 'utf8');

global $cons_constan;

$consulta = "SELECT
  conse conse,
  fecha fecha,
  valor valor,
  nombre nombre,
  nit iden,
  valletra valletra,
  concepto concepto,
  fpago fpago,
  ncheque ncheque,
  nbanco nbanco
FROM
  recibos_prorrog

WHERE id='" . $_REQUEST["id"] . "'";
//echo $consulta;
$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {

        $conse = $fila["conse"];
        $fecha = $fila["fecha"];
        $valor = '$ ' . number_format($fila["valor"], 2, ",", ".");
        $iden = $fila["iden"];
        $nombre = $fila["nombre"];
        $valletra = $fila["valletra"];
        $concepto = $fila["concepto"];
        $fpago = $fila["fpago"];
        $ncheque = $fila["ncheque"];
        $nbanco = $fila["nbanco"];
    }
}

$fpe = "";
$fpc = "";


if ($fpago == "EFECTIVO") {
    $fpe = "x";
} else if ($fpago == "CHEQUE") {
    $fpc = "x";
}

//   $this->Image('Img/cabecera_pdf.png',10,8,100);

class PDF extends FPDF {

    //Cabecera de página
    function Header() {

        $this->Image('Img/cabecera_pdf_cnuev.png', 10, 8, 100);

        $this->SetFont('Arial', 'B', 14);
        $this->Cell(100, 25, '', 1, 0, 'C');
        $this->Cell(0, 25, utf8_decode('RECIBO DE CAJA'), 1, 2, 'C');
        $this->Cell(0, -10, utf8_decode('N°.: ' . $GLOBALS['conse']), 0, 2, 'C');
    }

    function TablaBasica() {
        $this->SetFont('Arial', '', 10);
        //*****
        $this->SetXY(10, 37);
        $this->Cell(15, 8, 'Fecha: ' . $GLOBALS['fecha'], 0, 0, 'L');
        $this->SetXY(60, 37);
        $this->Cell(30, 8, utf8_decode('Valor: ' . $GLOBALS['valor']), 0, 0, 'L');
        $this->Line(10, 43.5, 200, 43.5);

//*****
        $this->SetXY(10, 43);
        $this->Cell(20, 8, 'Recibimos de: ' . utf8_decode($GLOBALS['nombre']), 0, 'L');
        $this->SetXY(120, 43);
        $this->Cell(20, 8, 'NIT: ' . utf8_decode($GLOBALS['iden']), 0, 'L');
        $this->Line(10, 50.5, 200, 50.5);
//*****
        $this->SetXY(10, 50);
        $this->Cell(20, 8, utf8_decode('La Suma de: ' . $GLOBALS['valletra']), 0, 'L');
        $this->Line(10, 57.5, 200, 57.5);

        //*****
        $this->SetXY(10, 57);
//       
        $this->Cell(20, 8, 'Por concepto de Pago: ', 0, 0, 'L');
          $this->SetXY(10, 63);
           $this->SetFont('Arial', '', 8);
        $this->Cell(20, 8, $GLOBALS['concepto'], 0, 0, 'L');

        //*****
        $this->Line(10, 71.5, 200, 71.5);
        //*****
        $this->SetXY(10, 71);
        $this->Cell(20, 8, 'Forma de Pago:', 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->SetXY(50, 71);
        $this->Cell(20, 8, 'EFECTIVO  ' . $GLOBALS['fpe'] . '    CHEQUE  ' . $GLOBALS['fpc'] . '  ', 0, 0, 'L');
        $this->Line(64, 76, 67, 76);
        $this->Line(79, 76, 82, 76);

        $this->SetFont('Arial', '', 10);
        $this->SetXY(100, 71);
        $this->Cell(20, 8, 'No: ' . $GLOBALS['ncheque'], 0, 0, 'L');
        $this->SetXY(140, 71);
        $this->Cell(20, 8, 'Banco: ' . $GLOBALS['nbanco'], 0, 0, 'L');

        $this->Line(10, 78.5, 200, 78.5);
        $y = $this->GetY();

        $this->SetXY(163, $y + 30);
        $this->Cell(15, 8, 'Representante ', 0, 0, 'L');
        $this->Line(150, $y + 32, 200, $y + 32);
    }

    //Pie de página
    function Footer() {
        $y = $this->GetY();
        $this->SetFont('Arial', 'I', 8);
        $this->SetXY(10, $y + 4);
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
$pdf->Output('I', 'Recibo' . $cons_constan . '.pdf');
?>