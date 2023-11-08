<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();

$consulta3 = "SET lc_time_names = 'es_CO';";
//echo $consulta;
mysqli_query($link,$consulta3);

$consulta = "SELECT old FROM inhumaciones WHERE id='" . $_REQUEST["id"] . "'";
$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $old = $fila["old"];
    }
}

if ($old == "NO") {
    $consulta = "SELECT
  inh.conse conse,
  inh.fecha fec,
  CONCAT(DATE_FORMAT(inh.fecha, '%d'),' DE ',UPPER(DATE_FORMAT(inh.fecha, '%M')),' DEL ',DATE_FORMAT(inh.fecha, '%Y')) fecor,
  inh.ciudad ciu,
  inh.falle fall,
  inh.fec_falle ffall,
  inh.fec_naci fnac,
  inh.fec_cere fcer,
  fun.nom_fune fune,
  inh.jefe_ceme jef,
  ocup.id_vent idv,
  CONCAT(ocup.id_ocup,'-',ocup.tip) ido,
  ocup.posicion posi,
  cli.inde_cli cedcli,
  cli.nom_cli nomcli,
  CONCAT(cli.dir_cli,' ',cli.barrio) dir,
  cli.tel_cli tel,
  inh.ubic ub
FROM
  inhumaciones inh
  LEFT JOIN clientes cli
    ON inh.titular = cli.inde_cli
  LEFT JOIN ocup_lot_osaid ocup
    ON inh.id=ocup.id_inhum
  LEFT JOIN funerarias fun
    ON inh.funeraria=fun.id_fune
where inh.id='" . $_REQUEST["id"] . "'";
    //echo $consulta;
$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $conse = $fila["conse"];
        $fec = $fila["fec"];
        $fecor = $fila["fecor"];
        $ciu = $fila["ciu"];
        $fall = acentos($fila["fall"]);
        $ffall = $fila["ffall"];
        $fnac = $fila["fnac"];
        $fcer = $fila["fcer"];
        $fune = acentos($fila["fune"]);
        $jef = acentos($fila["jef"]);
        $idv = $fila["idv"];
        $ido = $fila["ido"];
        $posi = $fila["posi"];
        $cedcli = $fila["cedcli"];
        $nomcli = acentos($fila["nomcli"]);
        $dir = acentos($fila["dir"]);
        $tel = $fila["tel"];
        $ub = $fila["ub"];
    }
}
} else {
    $consulta = "SELECT
  inh.conse conse,
  inh.fecha fec,
  CONCAT(DATE_FORMAT(inh.fecha, '%d'),' DE ',UPPER(DATE_FORMAT(inh.fecha, '%M')),' DEL ',DATE_FORMAT(inh.fecha, '%Y')) fecor,
  inh.ciudad ciu,
  inh.falle fall,
  inh.fec_falle ffall,
  inh.fec_naci fnac,
  inh.fec_cere fcer,
  fun.nom_fune fune,
  inh.jefe_ceme jef,
  ocup.posicion posi,
  cli.inde_cli cedcli,
  cli.nom_cli nomcli,
  CONCAT(cli.dir_cli,' ',cli.barrio) dir,
  cli.tel_cli tel,
  inh.ubic ub
FROM
  inhumaciones inh
  LEFT JOIN clientes cli
    ON inh.titular = cli.inde_cli
  LEFT JOIN ocup_lot_osaid_old ocup
    ON inh.id=ocup.id_inhum
  LEFT JOIN funerarias fun
    ON inh.funeraria=fun.id_fune
where inh.id='" . $_REQUEST["id"] . "'";
    //echo $consulta;
$resultado = mysqli_query($link,$consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $conse = $fila["conse"];
        $fec = $fila["fec"];
        $fecor = $fila["fecor"];
        $ciu = $fila["ciu"];
        $fall = acentos($fila["fall"]);
        $ffall = $fila["ffall"];
        $fnac = $fila["fnac"];
        $fcer = $fila["fcer"];
        $fune = acentos($fila["fune"]);
        $jef = acentos($fila["jef"]);
      
        $posi = $fila["posi"];
        $cedcli = $fila["cedcli"];
        $nomcli = acentos($fila["nomcli"]);
        $dir = acentos($fila["dir"]);
        $tel = $fila["tel"];
        $ub = $fila["ub"];
    }
}
}




//   $this->Image('Img/cabecera_pdf.png',10,8,100);

class PDF extends FPDF {

    //Cabecera de página
    function Header() {

        $this->Image('Img/cabecera_pdf.png', 60, 8, 90);

//      $this->SetFont('Arial','B',14);
//      $this->Cell(200,25,'',1,0,'C');
//      $this->Cell(0,25,utf8_decode('INHUMACIÓN'),0,2,'C');
//      $this->Cell(0,-10,utf8_decode('N°.: '.$GLOBALS['conse']),0,2,'C');
    }

    function TablaBasica() {
        $this->SetFont('Arial', 'B', 10);
        //*****
        $this->SetXY(150, 37);
        $this->Cell(25, 5, utf8_decode('INHUMACIÓN:'), 0, 0, 'C');
        $this->Cell(30, 5, $GLOBALS['conse'], 0, 0, 'L');


//*****
        $this->SetXY(10, 50);
        $this->Cell(95, 8, utf8_decode($GLOBALS['fecor']), 0, 2, 'L');

        $this->SetFont('Arial', '', 9);
        $this->SetXY(10, 60);
        $this->MultiCell(190, 5, utf8_decode('SEÑOR ' . $GLOBALS['jef'] . ' JEFE DE CEMENTERIO JARDINES DEL ECCE HOMO DE LA '
                        . 'DIOCESIS DE VALLEDUPAR FAVOR PREPARAR EL:'));
        $this->Cell(95, 8, utf8_decode($GLOBALS['ub'] . ' ' . $GLOBALS['posi']), 0, 2, 'L');
        $this->Ln(4);

        $this->MultiCell(190, 5, utf8_decode('YO: ' . $GLOBALS['nomcli'] . ' C.C ' . $GLOBALS['cedcli'] . ' AUTORIZO A JARDINES DEL ECCE HOMO DE LA DIOCESIS'
                        . 'DE VALLEDUPAR INHUMAR A:'));
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(190, 8, utf8_decode($GLOBALS['fall']), 0, 2, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Ln(4);
        $this->Cell(95, 8, utf8_decode('EL INHUMADO FALLECIÓ EL ' . $GLOBALS['ffall'] . ', HABIA NACIDO EL ' . $GLOBALS['fnac']), 0, 2, 'L');
        $this->Cell(95, 8, utf8_decode('CEREMONIA DE INHUMACIÓN QUE SE REALIZARA EL  ' . $GLOBALS['fcer']), 0, 2, 'L');
        $this->Cell(95, 8, utf8_decode('SERVICIO FUNEBRE PRESTADO POR:  ' . $GLOBALS['fune']), 0, 2, 'L');
        $this->Cell(95, 8, utf8_decode('INFORMACION ADICIONAL: DIRECCIÓN:' . $GLOBALS['dir'] . ' TELÉFONO: ' . $GLOBALS['tel']), 0, 2, 'L');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 9);
        $this->MultiCell(190, 5, utf8_decode('ME COMPROMETO A CUMPLIR LOS REGLAMENTOS INTERNO DEL PARQUE CEMENTERIO Y LAS DISPOSICIONES'
                        . 'AMBIENTALES VIGENTES EMANADAS DEL ORDEN GUBERNAMENTAL RESPECTIVO Y A NO REALIZAR NINGUN MURO O ZANJA EN EL CONTORNO'
                        . 'DEL LOTE DE MI PROPIEDAD QUE IMPIDA EL NORMAL DESPLAZAMIENTO DEL AGUA. ' . $GLOBALS['fec']));


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
$pdf->Output('I', 'OrdenInhumacion_' . $_REQUEST["id"] . '.pdf');

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>