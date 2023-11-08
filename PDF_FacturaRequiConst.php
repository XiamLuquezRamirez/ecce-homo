<?php

require('fpdf/fpdf.php');

include("Conectar.php");

$link = conectar();


global $cons_constan;



$consulta = "SELECT * FROM facturas_costancias fat LEFT JOIN constancias requi ON fat.constancia=requi.id_constan where fat.id_fact='" . $_REQUEST["id"] . "'";

//echo $consulta;

$resultado = mysqli_query($link,$consulta);

if (mysqli_num_rows($resultado) > 0) {

    while ($fila = mysqli_fetch_array($resultado)) {
        $cons_fact = $fila["cons_fact"];
        $fec_cre = $fila["fec_cre"];
        $ciudad = $fila["ciudad"];
        $inde_cli = $fila["iden"];
        $nom_cli = acentos($fila["nom"]);
        $dir_cli = acentos($fila["dirfact"]);
        $tel_cli = $fila["telfact"];
        $fpago = $fila["fpago"];
        $valor = $fila["valor"];
        $val_letra = $fila["val_letra"];
    }
}

//echo $nom_cli;
//   $this->Image('Img/cabecera_pdf.png',10,8,100);



class PDF extends FPDF {

    //Cabecera de página

    function Header() {



        $this->Image('Img/cabecera_pdf.png', 10, 8, 100);



        $this->SetFont('Arial', 'B', 14);

        $this->Cell(100, 25, '', 1, 0, 'C');

        $this->Cell(0, 25, utf8_decode(''), 1, 2, 'C');

        $this->SetXY(105, 12);

        $this->Cell(100, 5, 'FACTURA DE VENTA', 0, 2, 'C');

        $this->SetXY(105, 15);

        $this->Cell(100, 10, utf8_decode('N°.: ' . $GLOBALS['cons_fact']), 0, 2, 'C');



        $this->Line(110, 22.5, 200, 22.5);

        $this->SetXY(105, 23);

        $this->SetFont('Arial', '', 8);

        $this->Cell(100, 4, utf8_decode('FACTURADA POR COMPUTADOR'), 0, 2, 'C');

        $this->SetFont('Arial', '', 6);

        $this->Cell(100, 4, utf8_decode('RESOLUCIÓN DIAN 13028019618165 FECHA: 2019/10/23'), 0, 2, 'C');

        $this->SetFont('Arial', '', 6);

        $this->Cell(100, 4, utf8_decode('HABILITA DJSF DESDE No. 659  HASTA 10000'), 0, 2, 'C');
    }

    function TablaBasica() {
       
        $this->SetFont('Arial', 'B', 10);
        $this->SetXY(10, 37);
        $this->Cell(100, 11, '', 1, 2, 'C');

        $this->SetXY(10, 38);
          $this->Cell(100, 4, 'REGIMEN TRIBUTARIO ESPECIAL', 0, 2, 'C');
           $this->SetFont('Arial', 'B', 12);
        $this->Cell(100, 3, 'SOMOS ENTIDAD SIN ANIMO DE LUCRO', 0, 2, 'C');
        $this->SetFont('Arial', '', 8);
        $this->Cell(100, 3, utf8_decode('Según ART. IV de la ley 20 de 1974'), 0, 2, 'C');



        //*****

        $this->SetFont('Arial', 'B', 11);

        $this->SetXY(110, 37);

        $this->Cell(30, 5, 'FECHA', 1, 2, 'C');

        $this->SetFont('Arial', '', 12);

        $this->Cell(30, 6, $GLOBALS['fec_cre'], 1, 0, 'C');

        $this->SetXY(140, 37);

        $this->SetFont('Arial', 'B', 11);

        $this->Cell(60, 5, utf8_decode('FORMA DE PAGO'), 1, 2, 'C');

        $this->SetFont('Arial', '', 12);

        $this->Cell(60, 6, $GLOBALS['fpago'], 1, 0, 'C');



//*****

        $this->SetFont('Arial', '', 8);

        $this->SetXY(10, 49);

        $this->Cell(20, 8, 'CLIENTE: ' . utf8_decode($GLOBALS['nom_cli']), 0, 'L');

        $this->SetXY(140, 49);

        $this->Cell(20, 8, 'NIT/C.C: ' . utf8_decode($GLOBALS['inde_cli']), 0, 'L');

        //  $this->Line(10, 55, 200, 55);
//*****

        $this->SetXY(10, 54.5);

        $this->Cell(20, 8, utf8_decode('DIRECCIÓN: ' . $GLOBALS['dir_cli']), 0, 'L');

        $this->SetXY(140, 54.5);

        $this->Cell(20, 8, utf8_decode('TELÉFONO: ' . $GLOBALS['tel_cli']), 0, 'L');

        $this->Line(10, 68.5, 200, 68.5);



        $this->SetXY(10, 60);

        //      $this->Line(10, 68.5, 200, 68.5);
        //*****
    }

    function TablaConceptos() {

        $this->SetFont('Arial', 'B', 10);

        //*****

        $this->SetXY(10, 60);

        $this->SetFont('Arial', 'B', 9);

        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL

        $this->Cell(0, 5, utf8_decode('DETALLES'), 1, 2, 'C', True); // en orden lo que informan estos parametros es:



        $this->Ln(2);



        $this->SetFont('Arial', 'B', 8);

        $this->SetFillColor(205, 205, 205);

        $this->Cell(5, 8, '#', 0, 0, 'L', True);

        $this->Cell(60, 8, utf8_decode('Descripción.'), 0, 0, 'L', True);
        
        $this->Cell(60, 8, utf8_decode('Observación.'), 0, 0, 'L', True);

        $this->Cell(15, 8, utf8_decode('Cantidad'), 0, 0, 'L', True);

        $this->Cell(30, 8, utf8_decode('Valor Unitario.'), 0, 0, 'L', True);

        $this->Cell(0, 8, utf8_decode('Valor Total.'), 0, 0, 'L', True);



        $consulta = "SELECT

            serv.desc_serv descr,
            conc.obser obs,

            conc.cant can,

            conc.val val

          FROM

            detalles_facturaconst conc

            LEFT JOIN servicios serv

              ON conc.concep = serv.id_serv

          WHERE

            conse_cons='" . $_REQUEST["id"] . "'";

        //echo $consulta;

        $item = 0;

        $resultado = mysqli_query($GLOBALS['link'],$consulta);

        $Y = 76;

        $this->SetFont('Arial', '', 8);

        if (mysqli_num_rows($resultado) > 0) {

            while ($fila = mysqli_fetch_array($resultado)) {

                $this->SetXY(10, $Y);

                $item = $item + 1;

                $total = $fila["val"] * $fila['can'];

                $this->Cell(5, 3, $item, 0);
                $this->MultiCell(60, 3, utf8_decode(acentos($fila['descr'])), 0);
                $H = $this->GetY();
                $height = $H - $Y;
                $this->SetXY(75, $Y);
                $this->MultiCell(60, 3, utf8_decode(acentos($fila['obs'])), 0);
                $H = $this->GetY();
                $height = $H - $Y;
                $this->SetXY(135, $Y);
                

                $this->Cell(15, $height, $fila['can'], 0, 0, 'C');

                $this->SetXY(140, $Y);

                $this->Cell(30, $height, '$ ' . number_format($fila["val"], 2, ",", "."), 0, 0, 'R');

                $this->SetXY(170, $Y);

                $this->Cell(0, $height, '$ ' . number_format($total, 2, ",", "."), 0, 0, 'R');

                $this->Ln(8);



                //dashed_line(10, y1, 200, y2, dash_length=1, space_length=1);

                $Y = $H;
            }
        }

        $y = $this->GetY();

        $this->SetFont('Arial', 'B', 9);

        $this->SetXY(10, $Y + 1);
               


         $this->MultiCell(145, 4, utf8_decode(acentos('VALOR EN LETRA ' . $GLOBALS['val_letra'])), 0);

        $this->SetXY(155, $Y + 1);

        $this->Cell(15, 4, 'TOTAL: ', 1, 0, 'L');

        $this->SetXY(170, $Y + 1);

        $this->MultiCell(0, 4, '$ ' . number_format($GLOBALS['valor'], 2, ",", "."), 1, 'R');

        // $this->Line(170, $y+1, 200, $y+1);



        $y = $this->GetY();

        $this->SetFont('Arial', '', 7);

        $this->SetXY(10, $y + 8);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 6, utf8_decode('CONSIGNACIÓN: 087300318-13 CUENTA CORRIENTE BANCOLOMBIA'), 1, 2, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 6, utf8_decode('ESTA FACTURA SE ASIMILA EN TODOS SUS EFECTOS A LA LETRA DE CAMBIO ARTICULO 774 DEL CÓDIGO DE COMERCIO. '), 1, 2, 'C');

        $this->SetFont('Arial', 'B', 8);

        $this->MultiCell(0, 4, utf8_decode('SOMOS PRESTADORES DE SERVICIOS EXCLUIDOS, ARTICULO 476 DEL ESTATUTO TRIBUTARIO. NO SOMOS AUTORRETENEDORES NI GRANDES CONTRIBUYENTES. '), 1);
        $this->Cell(0, 25, '', 1, 0, 'C');



        $this->SetXY(15, $y + 30);

        $this->Cell(15, 8, 'AUTORIZADO POR:', 0, 0, 'L');

        $this->SetXY(15, $y + 40);

        $this->Cell(15, 8, 'JARDINES DEL ECCE HOMO', 0, 0, 'L');

        // $this->Line(15, $y + 37, 70, $y + 37);



        $this->SetXY(140, $y + 30);

        $this->Cell(15, 8, 'FIRMA Y SELLO QUIEN RECIBE', 0, 0, 'L');

        $this->SetXY(143, $y + 43);

        $this->Cell(140, 8, 'C.C. No.', 0, 0, 'L');

        $this->Line(140, $y + 44, 190, $y + 44);
    }

    //Pie de página

    function Footer() {
        $this->Ln(9.5);
              $this->SetFont('Arial', 'B', 8);
             $this->Cell(0, 10, utf8_decode('-- Software para la Administración de Procesos de la Funeraria la Esperanza --'), 0, 0, 'C');
        $this->Ln(4);
  
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página Web: www.funerarialaesperanza.org - E-mail: servicios@funerarialaesperanza.org'), 0, 0, 'C');
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

