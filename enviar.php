<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre  = trim($_POST['nombre']);
    $email   = trim($_POST['email']);
    $mensaje = trim($_POST['mensaje']);

    if(empty($nombre) || empty($email) || empty($mensaje)){
        die("Todos los campos son obligatorios.");
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        die("Email inválido.");
    }

    $mail = new PHPMailer(true);

    try {
        // CONFIGURACIÓN SMTP GMAIL
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'chalus@gmail.com'; 
        $mail->Password   = 'phie vntk vjkk dwnx';    
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // REMITENTE
        $mail->setFrom('TU_EMAIL@gmail.com', 'Transporte GEMA');
        $mail->addAddress('TU_EMAIL@gmail.com'); 

        // RESPUESTA
        $mail->addReplyTo($email, $nombre);

        $mail->isHTML(false);
        $mail->Subject = 'Nuevo mensaje desde la web';
        $mail->Body    = "Nombre: $nombre\nEmail: $email\nMensaje:\n$mensaje";

        $mail->send();

        header("Location: gracias.html");
        exit;

    } catch (Exception $e) {
        echo "Error al enviar: {$mail->ErrorInfo}";
    }
}
?>
