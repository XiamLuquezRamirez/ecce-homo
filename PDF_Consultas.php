<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();

class PDF extends FPDF {

    //Cabecera de página
    function Header() {
        $this->Image('Img/cabecera_pdf.png', 10, 8, 100);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(100, 25, '', 1, 0, 'C');
        $this->cell(0, 25, utf8_decode(''), 1, 2, 'C');
        $this->SetXY(110, 9);
        $this->cell(0, 25, utf8_decode('CONSULTA DE CARTERA'), 0, 2, 'C');
    }

    function TablaConsulta() {


        $this->SetXY(10, 36);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL
        if ($_REQUEST["tcon"] == "") {
            $this->Cell(0, 5, utf8_decode('TODOS LOS CLIENTES'), 1, 2, 'C', True); // en orden lo que informan estos parametros es:  
        } else if ($_REQUEST["tcon"] == "CONSUL1") {
            $this->Cell(0, 5, utf8_decode('CONSULTA DE CARTERA'), 1, 2, 'C', True); // en orden lo que informan estos parametros es:    
        } else if ($_REQUEST["tcon"] == "CONSUL2") {
            $this->Cell(0, 5, utf8_decode('CLIENTES ATRASADOS (1) CUOTA'), 1, 2, 'C', True); // en orden lo que informan estos parametros es:  
        } else if ($_REQUEST["tcon"] == "CONSUL3") {
            $this->Cell(0, 5, utf8_decode('CLIENTES ATRASADOS (2) CUOTA'), 1, 2, 'C', True); // en orden lo que informan estos parametros es:  
        } else if ($_REQUEST["tcon"] == "CONSUL4") {
            $this->Cell(0, 5, utf8_decode('CLIENSTE CON MAS DE (3) CUOTA'), 1, 2, 'C', True); // en orden lo que informan estos parametros es:  
        }


        // $this->Line(10, 120.5, 200, 120.5);
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(205, 205, 205);
        $this->Cell(5, 8, '#', 0, 0, 'L', True);
        $this->Cell(20, 8, utf8_decode('Contrato.'), 0, 0, 'L', True);
        $this->Cell(70, 8, utf8_decode('Titular'), 0, 0, 'L', True);
        $this->Cell(23, 8, utf8_decode('Val. Mensual'), 0, 0, 'L', True);
        $this->Cell(23, 8, 'Val. Anual', 0, 0, 'L', True);
        $this->Cell(20, 8, 'Val. Saldo', 0, 0, 'L', True);
        $this->Cell(15, 8, 'Fec. Venc.', 0, 0, 'L', True);
        $this->Cell(0, 8, 'Dias', 0, 0, 'L', True);
        //$this->Line(10, 120.5, 200, 120.5);

        $consulta = "SELECT * FROM  consulcartera";
        //echo $consulta;
        $item = 0;
        $topend = 0;
        $resultado = mysqli_query($GLOBALS['link'], $consulta);
        $Y = 50;

        $this->SetFont('Arial', '', 7);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $topend = $topend + $fila['c9'];
                $this->SetXY(10, $Y);
                $item = $item + 1;
                $this->Cell(5, 5, $item, 0);
                $this->Cell(20, 5, $fila['c2'], 0);
                $this->MultiCell(70, 5, utf8_decode($fila['c3']), 0);
                $H = $this->GetY();
                $height = $H - $Y;
                $this->SetXY(105, $Y);
                $this->Cell(23, $height, utf8_decode($fila['c4']), 0, 0);
                $this->SetXY(128, $Y);
                $this->Cell(23, $height, utf8_decode($fila['c5']), 0);
                $this->SetXY(151, $Y);
                $this->Cell(20, $height, utf8_decode($fila['c6']), 0, 0);
                $this->SetXY(171, $Y);
                $this->Cell(15, $height, utf8_decode($fila['c7']), 0);
                $this->SetXY(187, $Y);
                $this->Cell(0, $height, utf8_decode($fila['c8']), 0);
                $this->Ln(7);

                $Y = $H;
            }
        }

        $y = $this->GetY();


        $this->SetFont('Arial', 'B', 8);
        $this->Line(10, $y + 1, 205, $y + 1);
        $this->SetXY(160, $y + 3);
        $this->Cell(20, 6, 'Valor Total Cuotas Atrasadas: ', 0, 0, 'R');
        $this->SetXY(178, $y + 3);
        $this->Cell(0, 6, '$ ' . number_format($topend, 2, ",", "."), 0, 0, 'R');
    }

    //Pie de página
    function Footer() {

        $this->SetY(-13);

        $this->SetFont('Arial', 'I', 8);

        $this->Cell(0, 3, utf8_decode('Carrera 18 N° 15 - 108 Tels.: 571 2873 - 570 2689 - Fax: 5600993 - Valledupar - Cesar'), 0, 2, 'C');
        $this->Cell(0, 3, utf8_decode('Página Web: www.funerarialaesperanza.org - E-mail: esperanzaeccehomo@hotmail.com'), 0, 0, 'C');
    }

}

//Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage('P', 'Legal');
$pdf->SetY(40);
$pdf->TablaConsulta();
$pdf->SetFont('Times', '', 12);
//Aquí escribimos lo que deseamos mostrar...
$pdf->Output('I', 'Consultas.pdf');
?>