<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();


$consulta = "SELECT * FROM inhumaciones contr LEFT JOIN funerarias fun ON contr.funeraria=fun.id_fune where id='" . $_REQUEST["id"] . "'";
// echo $consulta;
$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $OrdInhum = $fila["conse"];
        $cemen = acentos($fila["cementerio"]);
        $ubica = acentos($fila["ubic"]);
        $muerto = acentos($fila["falle"]);
        $txt_fecha_sepe = $fila["fec_cere"];
        $nom_fune = acentos($fila["nom_fune"]);
    }
}

$pfechho = explode(" - ", $txt_fecha_sepe);
$fecha = $pfechho[0];
$hora = $pfechho[1];

//   $this->Image('Img/cabecera_pdf.png',10,8,100);

class PDF extends FPDF {

    //Cabecera de página
    function Header() {

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(190, 55, '', 1, 1, 'C');
        $this->SetXY(10, 11);
        if ($GLOBALS['cemen'] == "NUEVO") {
            $this->Cell(190, 4, 'CEMENTERIO NUEVO', 0, 2, 'C');
        } else {
            $this->Cell(190, 4, 'PARQUE CEMENTERIO JARDINES DEL ECCE HOMO', 0, 2, 'C');
        }
        $this->Cell(190, 4, 'REGISTRO DE INHUMACION', 0, 2, 'C');
        $this->Cell(190, 4, utf8_decode('Teléfonos 5712873 - 5838712'), 0, 2, 'C');

        $this->SetFont('Arial', '', 9);

        $this->SetXY(10, 25);
        $this->Cell(10, 8, utf8_decode('UBICACION: ' . $GLOBALS['ubica'] . '      FUNERARIA: ' . $GLOBALS['nom_fune']), 0, 'L');
//        $this->Line(30, 30.5, 40, 30.5);
//        $this->SetXY(45, 25);
//        $this->Cell(10, 8, utf8_decode('FUNERARIA: ' . $GLOBALS['nom_fune']), 0, 'L');
//        $this->Line(65, 30.5, 150, 30.5);


        $this->SetXY(10, 30);
        $this->Cell(10, 8, utf8_decode('DIFUNTO: ' . $GLOBALS['muerto']), 0, 'L');
        $this->Line(26, 35.5, 195, 35.5);

        $this->SetXY(10, 35);
        $this->Cell(10, 8, utf8_decode('FECHA: ' . $GLOBALS['fecha'] . '         HORA:' . $GLOBALS['hora']), 0, 'L');
        $this->Line(23, 40.5, 40, 40.5);
        $this->Line(58, 40.5, 75, 40.5);

        $this->SetXY(10, 50);
        $this->Cell(10, 8, utf8_decode('AUTORIZADO POR:'), 0, 'L');
        $this->Line(40, 55.5, 90, 55.5);
        $this->SetXY(10, 60);
        $this->Cell(190, 4, utf8_decode('"ES INDISPENSABLE LA PUNTUALIDAD EN LA HORA SEÑALADA"'), 0, 2, 'C');
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
//$pdf->TablaBasica();
$pdf->SetFont('Times', '', 12);
//Aquí escribimos lo que deseamos mostrar...
$pdf->Output('I', 'REGISTRO DE INHUMACION ' . $GLOBALS['muerto'] . '.pdf');

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>