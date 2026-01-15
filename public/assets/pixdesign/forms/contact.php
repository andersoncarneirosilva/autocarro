<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

header('Content-Type: text/plain');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400);
        echo "Preencha todos os campos obrigatórios.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configuração do servidor SMTP
        $mail->isSMTP(); // CORRIGIDO: usar SMTP
        $mail->Host       = 'pixdesign.com.br';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contato@pixdesign.com.br';
        $mail->Password   = 'Senha001'; // Substitua por sua senha segura real
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Remetente e destinatário
        $mail->setFrom('contato@pixdesign.com.br', 'Contato do Site');
        $mail->addReplyTo($email, $name); // Para responder ao cliente
        $mail->addAddress('contato@pixdesign.com.br');

        // Conteúdo do email
        $mail->isHTML(false);
        $mail->Subject = "Novo contato pelo site";
        $mail->Body    = "Nome: $name\nEmail: $email\n\nMensagem:\n$message";

        $mail->send();
        echo "OK"; // resposta esperada pelo JS
    } catch (Exception $e) {
        http_response_code(500);
        echo "Erro ao enviar: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(405);
    echo "Método não permitido.";
}
