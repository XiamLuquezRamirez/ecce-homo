<?php

// Libreria PHPMailer
require('fpdf/fpdf.php');
include("Conectar.php");

$link = conectar();
mysqli_set_charset($link, 'utf8');
date_default_timezone_set('America/Bogota');
$fec=date("d/m/Y");
require 'PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer();

///////////////////////


$consulta3 = "SET lc_time_names = 'es_CO';";
mysqli_query($link,$consulta3);

$par = explode("/", $_POST["dat_cli"]);
$tam = count($par);

for ($i = 0; $i < $tam-1; $i++) {
    $email="";
    $pdf = new FPDF();
    $pdf->AddPage();
     $pdf->Image('Img/diocesis.png', 10, 8, 50);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetXY(60, 10);
            $pdf->Cell(0, 8, 'DIOCESIS DE VALLEDUPAR JARDINES DEL ECCE HOMO', 0, 2, 'C');
            $pdf->Cell(0, 8, 'SERVICIOS FUNERARIOS LA ESPERANZA', 0, 2, 'C');
            $pdf->Cell(0, 8, 'NIT: 892300318-0', 0, 2, 'C');
            $pdf->SetXY(60, 40);
            $pdf->Cell(0, 8, 'Valledupar, ' . date('d-m-Y'), 0, 2, 'C');
    

    $consulta = "SELECT OrdInhum,ar.nom_cli,dir_cli,tel_cli,email_cli,muerto,cemen,desde,hasta,UPPER(DATE_FORMAT(hasta, '%M')) AS mes,UPPER(DATE_FORMAT(hasta, '%Y')) AS ani,UPPER(DATE_FORMAT(hasta, '%d')) AS dia  FROM contrato_arriendo ar LEFT JOIN clientes cli ON ar.ced_cli=cli.inde_cli WHERE id_arriendo='" . $par[$i] . "'";

    $resultado = mysqli_query($link,$consulta);
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_array($resultado)) {
            $OrdInhum = $fila["OrdInhum"];
            $nom_cli = $fila["nom_cli"];
            $dir_cli = $fila["dir_cli"];
            $tel_cli = $fila["tel_cli"];
            $email = $fila["email_cli"];
            $muerto = $fila["muerto"];
            $desde = $fila["desde"];
            $hasta = $fila["hasta"];
            $mes = $fila["mes"];
            $ani = $fila["ani"];
            $dia = $fila["dia"];
            $cemen = $fila["cemen"];
        }
    }
    
     if ($cemen == "NUEVO") {
        $cem = "de la bóveda";
    } else {
        $cem = "del lote";
    }
    
    $edad = calcular_edad($desde, $hasta);
    $tiempo = " {$edad->format('%Y')} años y {$edad->format('%m')} meses";
    
    $pdf->SetY(40);
    $pdf->SetFont('Arial', 'B', 12);

            $pdf->SetXY(10, 58);
            $pdf->Cell(20, 5, utf8_decode('Señor(a)'), 0, 2, 'L');
            $pdf->Cell(20, 5, utf8_decode($GLOBALS['nom_cli']), 0, 2, 'L');
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(20, 5, utf8_decode($GLOBALS['dir_cli']), 0, 2, 'L');
            $pdf->Cell(20, 5, utf8_decode('Tel: ' . $GLOBALS['tel_cli']), 0, 2, 'L');
            $pdf->Cell(20, 5, utf8_decode('Ciudad'), 0, 2, 'L');

            $pdf->SetXY(10, 100);
            $pdf->Cell(20, 5, utf8_decode('Cordial Saludo'), 0, 2, 'L');

            $pdf->SetFont('Arial', '', 11);
            $pdf->SetXY(10, 115);
            $pdf->MultiCell(190, 5, utf8_decode('Nos permitimos informales que los ' . $GLOBALS['tiempo'] . ' '
                            . 'de arriendo ' . $GLOBALS['cem'] . ', para el difunto(a)  ' . $GLOBALS['muerto'] . ' se vencerá el día ' . $GLOBALS['dia'] . '  '
                            . 'de ' . $GLOBALS['mes'] . ' del ' . $GLOBALS['ani'] . ', por lo tanto usted debe presentarse '
                            . 'en la mayor brevedad posible en nuestras oficinas ubicadas en la Carrera 18 No. 15 - 108 '
                            . 'Teléfono 571 28 73; para solucionar el destino final de los restos.  '), 0, 'J', False);
            $pdf->MultiCell(190, 5, utf8_decode('Al hacer caso omiso de esta notificación la empresa tomará '
                            . 'la desición de realizar la exhumación como lo establece la resolución 1594 del Ministerio '
                            . 'de la Protección Social'), 0, 'J', False);

            $pdf->Ln(4);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->MultiCell(190, 5, utf8_decode('Nota: Tiene plazo de quince (15) días tomando como referencia'
                            . 'la fecha del recibido de la presente comunicación'), 0, 'J', False);


            $pdf->Ln(6);
            $pdf->SetFont('Arial', '', 11);
            $pdf->MultiCell(190, 5, utf8_decode('Agradeciendo su atención'), 0, 'J', False);
            $y = $pdf->GetY();


            $pdf->SetFont('Arial', 'B', 11);
            $pdf->SetXY(10, $y + 30);
            $pdf->Cell(15, 8, utf8_decode('ADMINISTRACIÓN'), 0, 0, 'L');
            $pdf->Line(10, $y + 30, 60, $y + 30);
            $pdf->SetXY(10, $y + 50);
            $pdf->Cell(15, 8, 'RECIBI ', 0, 2, 'L');
            $pdf->Cell(15, 3, 'FECHA:', 0, 2, 'L');
            $pdf->Cell(15, 8, 'OBSERVACIONES:', 0, 2, 'L');
            $pdf->Line(25, $y + 56, 70, $y + 56);
            $pdf->Line(47, $y + 66, 150, $y + 66);
           
            
             $pdf->SetXY(10, $y + 95);
             
            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(0, 10, utf8_decode('Página Web: www.funerarialaesperanza.org - E-mail: esperanzaeccehomo@hotmail.com'), 0, 0, 'C');
//Aquí escribimos lo que deseamos mostrar...
            
    $pdf->Output('F', 'Notificacion.pdf');
    
    require 'PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer();
    $archivo = 'Notificacion.pdf';
    $mensaje = nl2br("Sr(a). " . $nom_cli . " Cordial Saludo, el prensete correo es para notificarle el pago oportuno del contrato de arriendo. <br/>Cordialmente,<br/><br><strong>Funeraria La Eperanza</strong><br/><br/>
    <center> <td  style='color: #7F8282;'><strong>Valledupar -  Cesar</strong><br/>Carrera 18 No. 15 - 108<br/> <strong>Tels:</strong>  571 2873 - 5702689<br/><a href='http://funerarialaesperanza.org'>funerarialaesperanza.org</a></td></center>");
    $mail->From = "info@funerarialaesperanza.org";
    $mail->FromName = "Funeraria la Esperanza";
    $mail->Subject = "Carta de Notificacion de Vencimiento de Arriendo";
    $mail->Body = $body;
    $mail->MsgHTML(@$mensaje);
    $mail->AddAddress($email, $nom_cli);
    $mail->AddAttachment($archivo, $archivo);
   


if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
    $mail->ClearAddresses();
  
}

function calcular_edad($desde, $hasta) {

        $fecha_nac = new DateTime(date('Y/m/d', strtotime($desde))); // Creo un objeto DateTime de la fecha ingresada

        $fecha_hoy = new DateTime(date('Y/m/d', strtotime($hasta))); // Creo un objeto DateTime de la fecha de hoy

        $edad = date_diff($fecha_hoy, $fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto

        return $edad;
    }
    
      
?>