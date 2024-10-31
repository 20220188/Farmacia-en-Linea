<?php
require '../../vendor/autoload.php'; // Ruta del archivo

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Especifica el servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'sportsfusion.contacts@gmail.com'; // Correo de origen
        $mail->Password = 'ztnh jojk rkpq hahv'; // Contraseña del correo de origen
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // Puerto SMTP

        // Destinatarios
        $mail->setFrom('sportsfusion.contacts@gmail.com', 'SportsFusion');
        $mail->addAddress($to);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}