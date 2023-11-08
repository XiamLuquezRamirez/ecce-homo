<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();
date_default_timezone_set('America/Bogota');

$consulta = "SELECT TK_ADMIN FROM config_empresa";

$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $admin = $fila['TK_ADMIN'];
    }
}

$consulta3 = "SET lc_time_names = 'es_CO';";
mysqli_query($link, $consulta3);

$consulta = "SELECT OrdInhum,ar.nom_cli,dir_cli,barrio,tel_cli,muerto,cemen,desde,hasta,UPPER(DATE_FORMAT(hasta, '%M')) AS mes,UPPER(DATE_FORMAT(hasta, '%Y')) AS ani,UPPER(DATE_FORMAT(hasta, '%d')) AS dia  FROM contrato_arriendo ar LEFT JOIN clientes cli ON ar.ced_cli=cli.inde_cli WHERE id_arriendo='" . $_REQUEST["id"] . "'";

$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $OrdInhum = $fila["OrdInhum"];
        $nom_cli = acentos($fila["nom_cli"]);
        $dir_cli = acentos($fila["dir_cli"]);
        $barrio = acentos($fila["barrio"]);
        $tel_cli = $fila["tel_cli"];
        $muerto = acentos($fila["muerto"]);
        $desde = $fila["desde"];
        $hasta = $fila["hasta"];
        $mes = $fila["mes"];
        $ani = $fila["ani"];
        $dia = $fila["dia"];
        $cemen = acentos($fila["cemen"]);
    }
}

$edad = calcular_edad($desde, $hasta);
$tiempo = " {$edad->format('%Y')} años y {$edad->format('%m')} meses";

if ($cemen == "NUEVO") {
    $cem = "CEMENTERIO NUEVO";
} else {
    $cem = "JARDINES DEL ECCE HOMO";
}

class PDF extends FPDF {

    //Cabecera de página
    function Header() {

        $this->Image('Img/diocesis.png', 10, 8, 50);
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(60, 10);
        $this->Cell(0, 8, 'DIOCESIS DE VALLEDUPAR ' . $GLOBALS['cem'], 0, 2, 'C');
        $this->Cell(0, 8, 'LA  ESPERANZA Y ECCE HOMO', 0, 2, 'C');
        $this->Cell(0, 8, 'NIT: 892300318-0', 0, 2, 'C');
        $this->SetXY(60, 40);
        $this->Cell(0, 8, 'Valledupar, ' . date('d-m-Y'), 0, 2, 'C');
    }

    function TablaBasica() {

        $this->SetFont('Arial', 'B', 12);

        $this->SetXY(10, 58);
        $this->Cell(20, 5, utf8_decode('Señor(a)'), 0, 2, 'L');
        $this->Cell(20, 5, utf8_decode($GLOBALS['nom_cli']), 0, 2, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(20, 5, utf8_decode($GLOBALS['dir_cli'].' '.$GLOBALS['barrio']), 0, 2, 'L');
        $this->Cell(20, 5, utf8_decode('Tel: ' . $GLOBALS['tel_cli']), 0, 2, 'L');
        $this->Cell(20, 5, utf8_decode('Ciudad'), 0, 2, 'L');

        $this->SetXY(10, 100);
        $this->Cell(20, 5, utf8_decode('Cordial Saludo'), 0, 2, 'L');

        $this->SetFont('Arial', '', 11);
        $this->SetXY(10, 115);
        $this->MultiCell(190, 5, utf8_decode('Nos permitimos informales que los ' . $_REQUEST["tiempo"] . ' '
                        . 'de arriendo ' . $GLOBALS['cem'] . ', para el difunto(a)  ' . $GLOBALS['muerto'] . ' se vencerá el día ' . $GLOBALS['dia'] . '  '
                        . 'de ' . $GLOBALS['mes'] . ' del ' . $GLOBALS['ani'] . ', por lo tanto usted debe presentarse '
                        . 'en la mayor brevedad posible en nuestras oficinas ubicadas en la Carrera 18 No. 14-90 '
                        . 'Celular 314 5961536 - Teléfono 589 84 38; para solucionar el destino final de los restos.  '), 0, 'J', False);
        $this->MultiCell(190, 5, utf8_decode('Al hacer caso omiso de esta notificación la empresa tomará '
                        . 'la desición de realizar la exhumación como lo establece la resolución 5194 del Ministerio '
                        . 'de la Protección Social'), 0, 'J', False);
        $this->MultiCell(190, 5, utf8_decode('ARTICULO 24. EXHUMACIÓN POR INICIATIVA DE LA ADMINISTRACION DEL CEMENTERIO. '
                . 'Si transcurridos quince días contados a partir del cumplimiento del tiempo mínimo de permanencia , '
                . 'los deudos no se presentan a confirmar la fecha de la exhumación del cadáver o los restos óseos, '
                . 'la administración del cementerio procedera   a realizarla.'), 0, 'J', False);

        $this->Ln(4);
        $this->SetFont('Arial', 'B', 11);
        $this->MultiCell(190, 5, utf8_decode('Nota: Tiene plazo de quince (15) días tomando como referencia'
                        . 'la fecha del recibido de la presente comunicación'), 0, 'J', False);


        $this->Ln(7);
        $this->SetFont('Arial', '', 11);
        $this->MultiCell(190, 5, utf8_decode('Agradeciendo su atención'), 0, 'J', False);
        $y = $this->GetY();


        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(10, $y + 30);
        $this->Cell(15, 8, utf8_decode('ADMINISTRACIÓN'), 0, 0, 'L');
        $this->Line(10, $y + 30, 60, $y + 30);
        $this->SetXY(10, $y + 50);
        $this->Cell(15, 8, 'RECIBI ', 0, 2, 'L');
        $this->Cell(15, 3, 'FECHA:', 0, 2, 'L');
        $this->Cell(15, 8, 'OBSERVACIONES:', 0, 2, 'L');
        $this->Line(25, $y + 56, 70, $y + 56);
        $this->Line(47, $y + 66, 150, $y + 66);
    }

    //Pie de página
    function Footer() {

        $this->SetY(-10);

        $this->SetFont('Arial', 'I', 8);

        $this->Cell(0, 10, utf8_decode('Página Web: www.funerarialaesperanza.org - E-mail: esperanzaeccehomo@hotmail.com'), 0, 0, 'C');
    }

}

function calcular_edad($desde, $hasta) {

    $fecha_nac = new DateTime(date('Y/m/d', strtotime($desde))); // Creo un objeto DateTime de la fecha ingresada

    $fecha_hoy = new DateTime(date('Y/m/d', strtotime($hasta))); // Creo un objeto DateTime de la fecha de hoy

    $edad = date_diff($fecha_hoy, $fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto

    return $edad;
}

//Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetY(40);
$pdf->TablaBasica();
$pdf->SetFont('Times', '', 12);
//Aquí escribimos lo que deseamos mostrar...

$pdf->Output('Notificacion_' . $OrdInhum . '.pdf', 'D');

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>