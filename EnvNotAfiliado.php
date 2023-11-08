<?php
include "Conectar.php";
date_default_timezone_set('America/Bogota');
$fec = date("d/m/Y");
require 'PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer();

$link = conectar();
mysqli_set_charset($link, 'utf8');

$consulta = "UPDATE cliente SET correo_cliente='" . $_POST['txt_emailAfiNot'] . "' WHERE idCliente='" . $_POST['txt_IdentiAfiNot'] . "'";
mysqli_query($link, $consulta);

///////////////////////
$email = $_POST['txt_emailAfiNot'];

$nom_cli = $_POST['txt_NombreAfiNot'] . " " . $_POST['txt_ApelliAfiNot'];

$mail = new PHPMailer();

//asigna a $body el contenido del correo electrónico
$body = "Contenido del cuerpo del correo";

// Indica que se usará SMTP para enviar el correo
$mail->IsSMTP();

//$mail->SMTPDebug  = 2;
// Activar los mensajes de depuración,
// muy útil para saber el motivo si algo sale mal
// 1 = errores y mensajes
// 2 = solo mensajes entre el servidor u la clase PHPMailer

$mail->SMTPAuth = true;
// Activar autenticación segura a traves de SMTP, necesario para gmail

$mail->SMTPSecure = "tls";
// Indica que la conexión segura se realizará mediante TLS

$mail->Host = "smtp.gmail.com";
// Asigna la dirección del servidor smtp de GMail

$mail->Port = 587;
// Asigna el puerto usado por GMail para conexion con su servidor SMTP

$mail->Username = "eccehomoesperanza@gmail.com";
// Indica el usuario de gmail a traves del cual se enviará el correo

$mail->Password = "esperanza4135";
// GMAIL password

$mail->SetFrom('eccehomoesperanza@gmail.com', 'Funeraria la Esperanza');
//Asignar la dirección de correo y el nombre del contacto que aparecerá cuando llegue el correo

$mail->Subject = "Notificacion Funeraria la Esperanza";
//Asignar el asunto del correo
$mensaje = nl2br("Sr(a). " . $nom_cli . " Cordial Saludo, .<br/> <br/>" . $_POST['txt_mensaje'] . "<br/><br/>Cordialmente,<br/><strong>Funeraria La Eperanza</strong><br/><br/>
    <center> <td  style='color: #7F8282;'><strong>Valledupar -  Cesar</strong><br/>Carrera 18 No. 15 - 108<br/> <strong>Tels:</strong>  571 2873 - 5702689<br/>funerarialaesperanza.org</td></center>");

$mail->MsgHTML($mensaje);
//Si deseas enviar un correo con formato HTML debes descomentar la linea anterior

$mail->AddAddress($email, $nom_cli);
//Indica aquí la dirección que recibirá el correo que será enviado

if (!$mail->Send()) {
    echo "Error enviando correo: " . $mail->ErrorInfo;
} else {
    echo "bien";
}
