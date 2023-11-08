<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();


        
$consulta = "SELECT cli.`Cedula_cliente` ident, CONCAT(cli.`Nombres_cliente`,' ',cli.`Apellidos_cliente`) nom, COUNT(cli.`Cedula_cliente`) benef
FROM cliente cli LEFT JOIN `beneficiario` ben ON cli.`idCliente`=ben.`idCliente_beneficiario` WHERE cli.`idCliente`='" . $_REQUEST["idAfilia"] . "'";
$resultado2 = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado2) > 0) {
    while ($fila = mysqli_fetch_array($resultado2)) {
        $Nomb = $fila["nom"];
        $Ident= $fila["ident"];        
        $conta = $fila["benef"];
    }
}

class PDF extends FPDF {

    //Cabecera de página
    function Header() {
        $this->Image('Img/cabecera_pdf.png', 10, 8, 100);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(100, 25, '', 1, 0, 'C');
        $this->cell(0, 25, utf8_decode(''), 1, 2, 'C');
        $this->SetXY(110, 9);
        $this->cell(0, 25, utf8_decode('CONSULTA DE BENEFICIARIOS POR AFIALIDOS'), 0, 2, 'C');
                $this->SetXY(10, 36);
        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL

        $this->Cell(0, 5, utf8_decode("INDENTIFICACIÓN: ".$GLOBALS['Ident']."     NOMBRE: ".$GLOBALS['Nomb']."     TOTAL BENEFICIARIOS: ".$GLOBALS['conta']), 1, 2, 'L', True); // en orden lo que informan estos parametros es:
        // $this->Line(10, 120.5, 200, 120.5);
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(205, 205, 205);
        $this->Cell(100, 8, utf8_decode('Nombre'), 0, 0, 'L', True);
        $this->Cell(60, 8, utf8_decode('Parentesco'), 0, 0, 'L', True);
        $this->Cell(30, 8, utf8_decode('Estado'), 0, 0, 'L', True);
    }

    function TablaConsulta() {




        //$this->Line(10, 120.5, 200, 120.5);
               

     
            $consulta = "SELECT CONCAT(nombre_beneficiario,' ',apellido_beneficiario) nomb, `parentesco_beneficiario` paren,`estado_beneficiario` estado  FROM  `beneficiario` WHERE `idCliente_beneficiario` ='" . $_REQUEST["idAfilia"] . "' order by nombre_beneficiario ASC";

            //echo $consulta;
            $item = 0;
             $y = 50;
            $resultado = mysqli_query($GLOBALS['link'],$consulta);

            $this->SetFont('Arial', '', 8);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
//                   
                    $this->Cell(100, 3, utf8_decode(acentos($fila['nomb'])), 0,0);
                    $this->Cell(60, 3, utf8_decode(acentos($fila["paren"])), 0,0);
                    $this->Cell(30, 3, acentos($fila["estado"]), 0,0);
                   $this->Ln();

                }
            }

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
$pdf->SetY(53);
$pdf->TablaConsulta();
$pdf->SetFont('Times', '', 12);
//Aquí escribimos lo que deseamos mostrar...
$pdf->Output('I', 'ListadoDeAfiliados.pdf');

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>