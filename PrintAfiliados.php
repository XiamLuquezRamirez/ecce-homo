<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();


        
$consulta = "SELECT Nit_empresa,COUNT(*) conta,Nombre_empresa,SUM(cli.Cuota_cliente) tot FROM empresa emp LEFT JOIN cliente cli ON emp.idEmpresa=cli.idEmpresa_cliente  WHERE emp.idEmpresa='" . $_REQUEST["id_Empre"] . "' AND cli.Estado_cliente='ACTIVO' ";
$resultado2 = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado2) > 0) {
    while ($fila = mysqli_fetch_array($resultado2)) {
        $NombEmpr = $fila["Nombre_empresa"];
        $Nit_empresa = $fila["Nit_empresa"];
         $cuotaTotal = $fila["tot"];
         $conta = $fila["conta"];
    }
}

class PDF extends FPDF {

    //Cabecera de página
    function Header() {
        $this->Image('Img/cabecera_pdf.png', 10, 8, 100);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(100, 25, '', 1, 0, 'C');
        $this->cell(0, 25, utf8_decode(''), 1, 2, 'C');
        $this->SetXY(110, 9);
        $this->cell(0, 25, utf8_decode('CONSULTA DE AFILIADOS POR EMPRESA'), 0, 2, 'C');
                $this->SetXY(10, 36);
        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL

        $this->Cell(0, 5, utf8_decode("NOMBRE: ".$GLOBALS['NombEmpr']."     NUMERO DE AFIALIDOS: ".$GLOBALS['conta']."     VALOR TOTAL: $ ".number_format($GLOBALS['cuotaTotal'], 2, ",", ".")), 1, 2, 'L', True); // en orden lo que informan estos parametros es:
        // $this->Line(10, 120.5, 200, 120.5);
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(205, 205, 205);
        $this->Cell(20, 8, utf8_decode('Cedula.'), 0, 0, 'L', True);
        $this->Cell(60, 8, utf8_decode('Nombre'), 0, 0, 'L', True);
        $this->Cell(30, 8, utf8_decode('Fecha de Afiliación'), 0, 0, 'L', True);
        $this->Cell(40, 8, utf8_decode('PAEE'), 0, 0, 'L', True);
        $this->Cell(20, 8, utf8_decode('Cuota'), 0, 0, 'L', True);
        $this->Cell(25, 8, utf8_decode('Estado'), 0, 1, 'L', True);
    }

    function TablaConsulta() {




        //$this->Line(10, 120.5, 200, 120.5);
               

     
            $consulta = "SELECT * FROM cliente cli LEFT JOIN plan pl "
                    . "ON cli.idPlan_cliente=pl.idPlan WHERE cli.idEmpresa_cliente='" . $_REQUEST["id_Empre"] . "' AND cli.Estado_cliente='ACTIVO'"
                    . " order by cli.Apellidos_cliente ASC";

            //echo $consulta;
            $item = 0;
             $y = 50;
            $resultado = mysqli_query($GLOBALS['link'],$consulta);


            $this->SetFont('Arial', '', 7);
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {

//                    $this->SetXY(10, $y + 3);
                    $this->Cell(20, 3, utf8_decode(acentos($fila['Cedula_cliente'])), 0,0);
//                    $this->SetXY(30, $y + 3);
                    $this->Cell(60, 3, utf8_decode(acentos($fila["Apellidos_cliente"] . " " . $fila["Nombres_cliente"])), 0,0);
                    $this->Cell(30, 3, acentos($fila["Fecha_ingreso_cliente"]), 0,0);
                    $this->Cell(40, 3, acentos($fila["Nombre_plan"]), 0,0);
                    $this->Cell(20, 3, "$ ". number_format($fila["Cuota_cliente"], 2, ",", "."), 0,0);
                    $this->Cell(20, 3, acentos($fila["Estado_cliente"]), 0,1);
                   $this->Ln();
                    
//                   $y = $this->GetY(+20);
//                  
//                    $Y = $H+4;
//                    echo $Y."-";
//                    $this->Line(10, $y, 200, $y);
                }
            }
        

//        $y = $this->GetY();
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