<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();

$consulta3 = "SET lc_time_names = 'es_CO';";
//echo $consulta;
mysqli_query($link, $consulta3);

$consulta = "SELECT
  inh.conse conse,
  inh.fecha fec,
  CONCAT(DATE_FORMAT(inh.fecha, '%d'),' DE ',UPPER(DATE_FORMAT(inh.fecha, '%M')),' DEL ',DATE_FORMAT(inh.fecha, '%Y')) fecor,
  inh.ciudad ciu,
  inh.muerto fall,
  inh.ubi ubi,
  inh.posi posi,
  inh.fechexhu fexhu,
  inh.autori auto,
  inh.fecinhuma finh,
  inh.observa obs,
  inh.tprop tprop,
  inh.jefe jefe,
  inh.txt_Trasla trasla,
  inh.cementerio cement,
  cli.inde_cli cedcli,
  cli.nom_cli nomcli,
  CONCAT(cli.dir_cli,' ',cli.barrio) dir,
  cli.tel_cli tel, inh.dir_aut diaut,inh.tel_aut teaut
FROM
  exhumaciones inh
  LEFT JOIN clientes cli
    ON inh.titular = cli.inde_cli
where inh.id='" . $_REQUEST["id"] . "'";
//echo $consulta;
$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $conse = $fila["conse"];
        $fec = $fila["fec"];
        $fecor = $fila["fecor"];
        $ciu = $fila["ciu"];
        $fall = acentos($fila["fall"]);
        $ubi = $fila["ubi"];
        $posi = $fila["posi"];
        $fexhu = $fila["fexhu"];
        $auto = $fila["auto"];
        $finh = $fila["finh"];
        $obs = acentos($fila["obs"]);
        $jefe = $fila["jefe"];
        $cedcli = $fila["cedcli"];
        $nomcli = acentos($fila["nomcli"]);
        $dir = acentos($fila["dir"]);
        $tel = $fila["tel"];
        $tprop = $fila["tprop"];
        $cement = acentos($fila["cement"]);
        $dir_aut = acentos($fila["diaut"]);
        $tel_aut = $fila["teaut"];
        $trasla = acentos($fila["trasla"]);
    }
}

//   $this->Image('Img/cabecera_pdf.png',10,8,100);

class PDF extends FPDF {

    //Cabecera de página
    function Header() {
        if ($GLOBALS['cement'] == "NUEVO") {
            $this->Image('Img/cabecera_pdf_cnuev.png', 60, 8, 90);
        } else {
            $this->Image('Img/cabecera_pdf.png', 60, 8, 90);
        }


//      $this->SetFont('Arial','B',14);
//      $this->Cell(200,25,'',1,0,'C');
//      $this->Cell(0,25,utf8_decode('INHUMACIÓN'),0,2,'C');
//      $this->Cell(0,-10,utf8_decode('N°.: '.$GLOBALS['conse']),0,2,'C');
    }

    function TablaBasica() {
        $this->SetFont('Arial', 'B', 10);
        //*****
        $this->SetXY(150, 37);
        $this->Cell(25, 5, utf8_decode('EXHUMACIÓN:'), 0, 0, 'C');
        $this->Cell(30, 5, $GLOBALS['conse'], 0, 0, 'L');


//*****
        $this->SetXY(10, 50);
        $this->Cell(95, 8, utf8_decode($GLOBALS['fecor']), 0, 2, 'L');

        $this->SetFont('Arial', '', 9);
        $this->SetXY(10, 60);
        if ($GLOBALS['cement'] == "NUEVO") {
            $this->MultiCell(190, 5, utf8_decode('SEÑOR ' . $GLOBALS['jefe'] . ' JEFE DEL CEMENTERIO NUEVO DE LA '
                            . 'DIOCESIS DE VALLEDUPAR FAVOR PREPARAR LA SIGUIENTE EXHUMACIÓN:'));
        } else {
            $this->MultiCell(190, 5, utf8_decode('SEÑOR ' . $GLOBALS['jefe'] . ' JEFE DE CEMENTERIO JARDINES DEL ECCE HOMO DE LA '
                            . 'DIOCESIS DE VALLEDUPAR FAVOR PREPARAR LA SIGUIENTE EXHUMACIÓN:'));
        }
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(190, 6, utf8_decode($GLOBALS['fall']), 0, 2, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(190, 6, utf8_decode($GLOBALS['ubi'] . ' ' . $GLOBALS['posi']), 0, 2, 'C');
        $this->Ln(4);

        $this->Cell(95, 8, utf8_decode('EL DÍA ' . $GLOBALS['fexhu']), 0, 2, 'L');
        $this->Cell(95, 8, utf8_decode('AUTORIZA EL SERVICIO: ' . $GLOBALS['auto']), 0, 2, 'L');
        if ($GLOBALS['tprop'] == "Propio") {
            $this->Cell(95, 8, utf8_decode('PROPIEDAD DE:  ' . $GLOBALS['nomcli'] . ' C.C: ' . $GLOBALS['cedcli']), 0, 2, 'L');
        } else {
            if ($GLOBALS['cement'] == "NUEVO") {
                $this->Cell(95, 8, utf8_decode('PROPIEDAD DE: CEMENTERIO NUEVO  '), 0, 2, 'L');
            } else if ($GLOBALS['cement'] == "JARDINES") {
                $this->Cell(95, 8, utf8_decode('PROPIEDAD DE: JARDINES DEL ECCE HOMO  '), 0, 2, 'L');
            } else {
                $this->Cell(95, 8, utf8_decode('PROPIEDAD DE:  SIN DEFINIR'), 0, 2, 'L');
            }
        }


        $this->Cell(95, 8, utf8_decode('FECHA DE INHUMACIÓN: ' . $GLOBALS['finh']), 0, 2, 'L');
        $this->Cell(95, 8, utf8_decode('PARA TRASLADAR A: ' . $GLOBALS['trasla']), 0, 2, 'L');
        $this->Cell(95, 8, utf8_decode('INFORMACION ADICIONAL: DIRECCIÓN:' . $GLOBALS['dir_aut'] . ' TELÉFONO: ' . $GLOBALS['tel_aut']), 0, 2, 'L');
        $this->Cell(95, 8, utf8_decode($GLOBALS['obs']), 0, 2, 'L');
        $this->Ln(5);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(190, 5, utf8_decode('REGLAMENTACIÓN PARA EL SERVICIO DE EXHUMACIÓN (RESOLUCIÓN. 5194 DE 2010): PARA EL SERVICIO '
                        . 'DE EXHUMACIÓN SE PROHIBE LA ASISTENCIA DE MENORES DE EDAD Y PERSONAS NO AUTORIZADAS AL PROCESOS DE EXHUMACIÓN, '
                        . 'SE PERMITIRÁ A LOS DEUDOS LA ASISTENCIA DE SÓLO UNA PERSONA PARA LA IDENTIFICACIÓN DEL CADÁVER A SUS RESTOS '
                        . 'ÓSEOS; ÉSTE DEBE ASISTIR CON LAS MEDIDAS DE BIOSEGURIDAD, ELEMENTO DE PROTECCIÓN (BATA, TAPABOCAS. GUANTES, GORRO) '
                        . 'TODOS DE MATERIAL DESECHABLES; EL CADÁVER SERÁ EXTRAÍDO O SUS RESTOS A LA SUPERFICIE, REALIZANDO EL PROCEDIMIENTO '
                        . 'ANTERIOR DESCRITO SERÁN ENTREGADOS EN BOLSA PLÁSTICA DE ALTA DENSIDAD O CAJA QUE USTED ADQUIERA.'));

        $this->Ln(5);
        $this->SetFont('Arial', 'B', 9);
        if ($GLOBALS['cement'] == "NUEVO") {
            $this->Cell(190, 8, utf8_decode('--- ABSTENGASE DE CANCELAR SUMAS ADICIONALES EN LAS INSTALACIONES DEL CEMENTERIO NUEVO. ---'), 0, 2, 'C');
        } else {
            $this->Cell(190, 8, utf8_decode('--- ABSTENGASE DE CANCELAR SUMAS ADICIONALES EN LAS INSTALACIONES DEL PARQUE CEMENTERIO. ---'), 0, 2, 'C');
        }

        $this->Ln(4);
        $this->Cell(190, 8, utf8_decode('ATENTAMENTE,'), 0, 2, 'L');

        $this->Ln(4);
        $y = $this->GetY();

        $this->SetXY(10, $y + 15);
        $this->Cell(15, 8, 'NOMBRE ', 0, 2, 'L');
        $this->Cell(15, 3, 'CC:', 0, 0, 'L');
        $this->Line(10, $y + 15, 60, $y + 15);
        $this->SetXY(150, $y + 15);

        $this->Cell(15, 8, utf8_decode('ELABORÓ'), 0, 2, 'L');
        $this->Line(150, $y + 15, 200, $y + 15);
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
$pdf->Output('I', 'OrdenExhumacion_' . $conse . '.pdf');

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>