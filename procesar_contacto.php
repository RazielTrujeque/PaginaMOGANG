<?php
// Solo procesar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Configuración del destinatario
    $to = "raziel.trujeque@uabc.edu.mx"; // CAMBIA ESTO: Tu email oficial de MO GANG
    $webmaster_email = "mogang.razieltmo.com"; // CAMBIA ESTO: Un email válido del dominio para evitar spam
    
    // 2. Limpieza de datos (seguridad)
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $servicio = htmlspecialchars(trim($_POST['servicio']));
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));

    // 3. Validación simple
    if (empty($nombre) || empty($email) || empty($servicio) || empty($mensaje) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: /error_envio.html'); 
        exit;
    }
    
    // 4. Estructura del email
    $subject = "NUEVO PROYECTO MO GANG - Solicitud de " . $nombre;
    
    $email_body = "Se ha recibido una nueva solicitud de proyecto a través de la web de MO GANG.\n\n";
    $email_body .= "======================================\n";
    $email_body .= "DATOS DEL CLIENTE:\n";
    $email_body .= "Nombre: " . $nombre . "\n";
    $email_body .= "Email: " . $email . "\n";
    $email_body .= "Interesado en: " . $servicio . "\n";
    $email_body .= "======================================\n";
    $email_body .= "DESCRIPCIÓN DEL PROYECTO:\n" . $mensaje . "\n";
    $email_body .= "======================================\n";
    
    // 5. Encabezados del correo
    $headers = "From: " . $webmaster_email . "\r\n" . 
               "Reply-To: " . $email . "\r\n" .
               "Content-Type: text/plain; charset=UTF-8";

    // 6. Envío del correo y redirección
    if (mail($to, $subject, $email_body, $headers)) {
        header('Location: gracias.html'); // Éxito
        exit;
    } else {
        header('Location: error_envio.html'); // Falla
        exit;
    }
} else {
    header('Location: index.html');
    exit;
}
?>