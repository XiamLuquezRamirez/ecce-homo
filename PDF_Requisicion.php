<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();
mysqli_set_charset($link, 'utf8');

$consulta = "SELECT TK_ADMIN FROM config_empresa";
$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $admin = $fila['TK_ADMIN'];
    }
}

$consulta = "SELECT
    req.cod_req cod_req,
    req.fech_req fech_req,
    req.ciu_req ciu_req,
    req.ced_contra cedcon,
    req.nom_contr nomcon,
    cli.dir_cli dircon,
    cli.tel_cli telcon,
    req.idfall_req cedfall,
    req.nomfall_req nomfall,
    req.sexfall_req sexfall,
    req.fecnfall_req fenfall,
    fune.nom_fune nomfune,
    req.naut_req nautfun,
    req.serpres serp,
    req.dirser dirp,
    req.telser terp,
    req.ciuserv ciup,
    req.nompad_req npad,
    req.nommad_req nmad,
    igl.nom_igle nigl,
    req.salve_req sala,
    req.velcasa vcasa,
    cem.nom_cem ncem
  FROM
    requisiciones req
    LEFT JOIN clientes cli
      ON req.ced_contra = cli.inde_cli
    LEFT JOIN funerarias fune
      ON req.funau_req=fune.id_fune
    LEFT JOIN iglesias igl
      ON req.igle_req =igl.id_igle
    LEFT JOIN cementerios cem
      ON req.ceme_req=cem.id_cem where id_req='" . $_REQUEST["id"] . "'";

$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $cod_req = $fila["cod_req"];
        $fech_req = $fila["fech_req"];
        $ciu_req = $fila["ciu_req"];
        $cedcon = $fila["cedcon"];
        $nomcon = acentos($fila["nomcon"]);
        $dircon = acentos($fila["dircon"]);
        $telcon = $fila["telcon"];
        $cedfall = $fila["cedfall"];
        $nomfall = acentos($fila["nomfall"]);
        $sexfall = $fila["sexfall"];
        $fenfall = $fila["fenfall"];
        $nomfune = acentos($fila["nomfune"]);
        $nautfun = $fila["nautfun"];
        $serp = $fila["serp"];
        $dirp = $fila["dirp"];
        $terp = $fila["terp"];
        $ciup = $fila["ciup"];
        $npad = acentos($fila["npad"]);
        $nmad = acentos($fila["nmad"]);
        $fnigl = $fila["nigl"];
        $sala = $fila["sala"];
        $ncem = acentos($fila["ncem"]);
        $vcasa = $fila["vcasa"];
    }
}

class PDF extends FPDF {

    //Cabecera de página
    function Header() {

        $this->Image('Img/cabecera_pdf.png', 10, 8, 100);

        $this->SetFont('Arial', 'B', 14);
        $this->Cell(100, 25, '', 1, 0, 'C');
        $this->Cell(0, 25, utf8_decode('REQUISICIÓN INTERNA'), 1, 2, 'C');
        $this->Cell(0, -10, utf8_decode('N°.: ' . $GLOBALS['cod_req']), 0, 2, 'C');
    }

    function TablaBasica() {
        $this->SetFont('Arial', 'B', 10);
        //*****
        $this->SetXY(110, 37);
        $this->Cell(30, 5, 'FECHA', 1, 2, 'C');
        $this->Cell(30, 6, $GLOBALS['fech_req'], 1, 0, 'C');
        $this->SetXY(140, 37);
        $this->Cell(60, 5, utf8_decode('CIUDAD'), 1, 2, 'C');
        $this->Cell(60, 6, $GLOBALS['ciu_req'], 1, 0, 'C');



//*****
        $this->SetXY(10, 50);
        //      $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL
        $this->Cell(95, 8, 'CLIENTE', 1, 2, 'C', True); // en orden lo que informan estos parametros es:
        $this->SetFont('Arial', '', 10);
        $this->Cell(95, 8, utf8_decode('Nombre: ' . $GLOBALS['nomcon']), 0, 2, 'L');
        $this->Line(25.3, 63.4, 100, 63.4);
        $this->Cell(95, 6, utf8_decode('C.C ó NIT: ' . $GLOBALS['cedcon']), 0, 2, 'L');
        $this->Line(28.3, 70.4, 100, 70.4);
        $this->Cell(95, 6, utf8_decode('Dirección: ' . $GLOBALS['dircon']), 0, 2, 'L');
        $this->Line(27.3, 76.5, 100, 76.5);
        $this->Cell(95, 6, utf8_decode('Teléfono: ' . $GLOBALS['telcon']), 0, 0, 'L');
        $this->Line(26.3, 82.5, 100, 82.5);
        $this->SetXY(105, 50);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 8, utf8_decode('FALLECIDO'), 1, 2, 'C', True);
        $this->SetFont('Arial', '', 10);
        $this->Cell(100, 8, utf8_decode('Nombre: ' . $GLOBALS['nomfall']), 0, 2, 'L');
        $this->Line(120.3, 63.4, 200, 63.4);
        $this->Cell(100, 6, utf8_decode('C.C: ' . $GLOBALS['cedfall']), 0, 2, 'L');
        $this->Line(114.3, 70.4, 200, 70.4);
        $this->Cell(100, 6, utf8_decode('Sexo: ' . $GLOBALS['sexfall']), 0, 2, 'L');
        $this->Line(116.3, 76.4, 200, 76.4);
        $this->Cell(100, 6, utf8_decode('Fecha de Fallecimiento: ' . $GLOBALS['fenfall']), 0, 0, 'L');
        $this->Line(141.3, 82.4, 200, 82.4);

        // $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(205, 205, 205);
        $this->SetXY(10, 85);
        $this->Cell(150, 8, utf8_decode('Funeraria que Autoriza: ' . $GLOBALS['nomfune']), 0, 0, 'L', True);

        $this->SetXY(150, 85);
        $this->Cell(0, 8, utf8_decode('N°. Autorización: ' . $GLOBALS['nautfun']), 0, 0, 'R', True);

        $this->SetXY(10, 95);
        $this->Cell(90, 8, utf8_decode('Nombre del Padre: ' . $GLOBALS['npad']), 0, 0, 'L');
        $this->SetXY(110, 95);
        $this->Cell(90, 8, utf8_decode('Nombre de la Madre: ' . $GLOBALS['nmad']), 0, 0, 'L');

        $this->Line(10, 100.5, 200, 100.5);
    }

    function TablaNecesidades() {
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(205, 205, 205);
        $this->SetXY(10, 105);
        $this->Cell(0, 8, utf8_decode('NECESIDADES BÁSICAS'), 0, 0, 'C', True);

        //*****
        $this->SetFont('Arial', '', 9);
        $this->SetXY(10, 115);
        $this->Cell(50, 8, utf8_decode('Servicio a Prestar: ' . $GLOBALS['serp']), 0, 0, 'L');
        $this->SetXY(80, 115);
        $this->Cell(15, 8, utf8_decode('Dirección: ' . $GLOBALS['dirp']), 0, 0, 'L');
        $this->SetXY(140, 115);
        $this->Cell(15, 8, utf8_decode('Teléfono: ' . $GLOBALS['terp']), 0, 0, 'L');
        $this->SetXY(170, 115);
        $this->Cell(0, 8, utf8_decode('Ciudad: ' . $GLOBALS['ciup']), 0, 0, 'L');
        // $this->Line(10, 120.5, 200, 120.5);
        $this->Ln(8);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(205, 205, 205);
        $this->Cell(7, 8, 'Item', 0, 0, 'L', True);
        $this->Cell(65, 8, utf8_decode('Descripción'), 0, 0, 'L', True);
        $this->Cell(55, 8, utf8_decode('Observación'), 0, 0, 'L', True);
        $this->Cell(10, 8, utf8_decode('Cant.'), 0, 0, 'C', True);
        $this->Cell(25, 8, 'Valor', 0, 0, 'L', True);
        $this->Cell(0, 8, 'Total', 0, 0, 'L', True);
        //$this->Line(10, 120.5, 200, 120.5);

        $consulta = "SELECT
            serv.desc_serv descr,
            req.obs obs,
            req.cant can,
            req.val va,
            (val*cant) tot
             FROM
            requi_servicios req
            LEFT JOIN servicios serv
              ON req.nece = serv.id_serv
          WHERE
            req.id_req='" . $_REQUEST["id"] . "'";
        //echo $consulta;
        $item = 0;
        $resultado = mysqli_query($GLOBALS['link'],$consulta);
        $Y = 132;
        $gtot = 0;
        $this->SetFont('Arial', '', 7);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $this->SetXY(10, $Y);
                $item = $item + 1;
                $this->Cell(7, 3, $item, 0);
                $this->MultiCell(64.5, 3, utf8_decode(acentos($fila['descr'])), 0);
                $H = $this->GetY();
                $height = $H - $Y;
                $this->SetXY(82, $Y);
                $this->MultiCell(55, $height, utf8_decode(acentos($fila['obs'])), 0);
                $H = $this->GetY();
                $height = $H - $Y;
                $this->SetXY(137, $Y);
                $this->Cell(10, $height, $fila['can'], 0, 0, 'C');
                $this->SetXY(147, $Y);
                $this->Cell(25, $height, '$ ' . number_format($fila["va"], 2, ",", "."), 0);
                $this->SetXY(172, $Y);
                $this->Cell(0, $height, '$ ' . number_format($fila["tot"], 2, ",", "."), 0);
                $this->Ln(3);

                //dashed_line(10, y1, 200, y2, dash_length=1, space_length=1);
                $Y = $H;
                $gtot = $gtot + $fila["tot"];
            }
        }
        $this->SetFont('Arial', 'B', 7);

        $this->SetXY(153, $Y + 1);
        $this->Cell(15, 8, 'Total a Pagar: ', 0, 0, 'L');


        $this->SetXY(172, $Y + 1);
        $this->Cell(0, 8, '$ ' . number_format($gtot, 2, ",", "."), 0, 0, 'L');
        $this->Line(172, $Y + 1, 200, $Y + 1);
//
//     $y=$this->GetY();
//
//      $this->SetXY(168, $y+30);
//      $this->Cell(15, 8, 'Recibido ', 0,0, 'L');
//      $this->Line(150, $y+30, 200, $y+30);
//
    }

    function TablaOtrDatos() {
        $y = $this->GetY();
        $this->Line(10, $y + 10, 200, $y + 10);
        $this->SetFont('Arial', '', 10);
        $this->SetXY(10, $y + 10);
        if ($GLOBALS['vcasa'] == "s") {
            $this->Cell(40, 8, utf8_decode('Velación en Casa'), 0, 0, 'L');
        } else {
            $this->Cell(40, 8, utf8_decode('Sala de Velación: ' . $GLOBALS['sala']), 0, 0, 'L');
        }

        $this->SetXY(70, $y + 10);
        $this->Cell(60, 8, utf8_decode('Cementerio: ' . $GLOBALS['ncem']), 0, 0, 'L');
        $this->Line(10, $y + 17, 200, $y + 17);

        $y = $this->GetY();
        $this->SetXY(10, $y + 10);
        $this->Cell(100, 40, '', 1, 0, 'C');
        $this->Cell(0, 40, utf8_decode(''), 1, 0, 'C');
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(10, $y + 12);
        $this->Cell(100, 3, utf8_decode('!IMPORTANTE!'), 0, 2, 'C');
        $this->Cell(100, 3, utf8_decode('LA DIÓCESIS DE VALLEDUPAR!'), 0, 2, 'C');
        $this->Cell(100, 3, utf8_decode('SERVICIOS FUNERARIOS LA ESPERANZA'), 0, 2, 'C');
        $this->Cell(100, 3, utf8_decode('NO ASUME RESPONSABILIDAD'), 0, 2, 'C');

        $this->SetFont('Arial', '', 7);
        $this->MultiCell(100, 3, utf8_decode('A- Si los descuentos aportados por el firmante de esta requisición fueron erróneos.'), 0, 2, False);
        $this->MultiCell(100, 3, utf8_decode('B- Por la identidad de la persona fallecida, de la misma será responsabilidad del firmante de esta requisición.'), 0, 2, False);
        $this->MultiCell(100, 3, utf8_decode('C- Por los valores u Objetos que porte el fallecido.'), 0, 2, False);
        $this->MultiCell(100, 3, utf8_decode('D- Por los daños que resulten, como consecuencia de algún accidente que ocurriere durante el transporte, fuerza mayor, caso fortuito y asonada.'), 0, 2, False);
        $this->Cell(100, 3, utf8_decode('LA ADMINISTRACIÓN'), 0, 1, 'C');



        $this->SetXY(113, $y + 10);
        $this->Cell(15, 7, utf8_decode('Cancelado Según Recibo No. '), 0, 2, 'L');
        $this->Cell(15, 3, 'ACEPTADO. ', 0, 0, 'L');
        $this->Line(113, $y + 15, 195, $y + 15);
        $this->Line(113, $y + 40, 195, $y + 40);
        $this->SetXY(113, $y + 43);
        $this->Cell(15, 3, 'C.C. o NIT. ', 0, 0, 'L');
        $this->Line(127, $y + 46, 195, $y + 46);
    }

    //Pie de página
    function Footer() {

        $this->SetY(-15);

        $this->SetFont('Arial', 'I', 8);

        $this->Cell(0, 3, utf8_decode('Esta Requisición se asimila en todos sus efestos a una letra de cambio, Art. 774 del Código de Comercio'), 0, 2, 'C');
        $this->Cell(0, 3, utf8_decode('Carrera 18 N° 15 - 108 Tels.: 571 2873 - 570 2689 - Fax: 5600993 - Valledupar - Cesar'), 0, 2, 'C');
        $this->Cell(0, 3, utf8_decode('Página Web: www.funerarialaesperanza.org - E-mail: esperanzaeccehomo@hotmail.com'), 0, 0, 'C');
    }

}

//Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetY(40);
$pdf->TablaBasica();
$pdf->TablaNecesidades();
$pdf->TablaOtrDatos();
$pdf->SetFont('Times', '', 12);
//Aquí escribimos lo que deseamos mostrar...
$pdf->Output('I', 'autorizacion_' . $cod_req . '.pdf');

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>