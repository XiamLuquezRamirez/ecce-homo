<?php
// Libreria PHPMailer
require 'PHPMailer/PHPMailerAutoload.php';
 
// Creamos una nueva instancia
$mail = new PHPMailer();
 
// Activamos el servicio SMTP
$mail->isSMTP();
// Activamos / Desactivamos el "debug" de SMTP 
// 0 = Apagado 
// 1 = Mensaje de Cliente 
// 2 = Mensaje de Cliente y Servidor 
$mail->SMTPDebug = 2; 
 
// Log del debug SMTP en formato HTML 
$mail->Debugoutput = 'html'; 
 
// Servidor SMTP (para este ejemplo utilizamos gmail) 
$mail->Host = 'smtp.gmail.com'; 
 
// Puerto SMTP 
$mail->Port = 587; 
 
// Tipo de encriptacion SSL ya no se utiliza se recomienda TSL 
$mail->SMTPSecure = 'tls'; 
 
// Si necesitamos autentificarnos 
$mail->SMTPAuth = true; 
 
// Usuario del correo desde el cual queremos enviar, para Gmail recordar usar el usuario completo (usuario@gmail.com) 
$mail->Username = "codejobs@gmail.com"; 
 
// Contraseña 
$mail->Password = "aprendeaprogramar"; 
 
// Conectamos a la base de datos 
$db = new mysqli('hostname', 'usuario', 'cotraseña', 'basededatos'); 
 
if ($db->connect_errno > 0) { 
    die('Imposible conectar [' . $db->connect_error . ']'); 
} 
 
// Creamos la sentencias SQL 
$result = $db->query("SELECT * FROM personas");
 
// Iniciamos el "bucle" para enviar multiples correos. 
 
while($row = $result->fetch_assoc()) { 
    //Añadimos la direccion de quien envia el corre, en este caso Codejobs, primero el correo, luego el nombre de quien lo envia. 
 
 
    $mail->setFrom('codejobs@gmail.com', 'CodeJobs!'); 
    $mail->addAddress($row['PersonasEmail'], $row['PersonasNombre']); 
 
    //La linea de asunto 
    $mail->Subject = 'Bienvenido a Codejobs!'; 
 
    // La mejor forma de enviar un correo, es creando un HTML e insertandolo de la siguiente forma, PHPMailer permite insertar, imagenes, css, etc. (No se recomienda el uso de Javascript) 
 
    $mail->msgHTML(file_get_contents('contenido.html'), dirname(__FILE__)); 
 
    // Enviamos el Mensaje 
    $mail->send(); 
 
    // Borramos el destinatario, de esta forma nuestros clientes no ven los correos de las otras personas y parece que fuera un único correo para ellos. 
    $mail->ClearAddresses(); 
}  
?>