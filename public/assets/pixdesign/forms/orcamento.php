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
    $name    = $_POST['name'] ?? '';
    $email   = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        http_response_code(400);
        echo "Preencha todos os campos obrigatórios. testt";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configuração do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'pixdesign.com.br';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contato@pixdesign.com.br';
        $mail->Password   = 'Senha001';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('contato@pixdesign.com.br', 'Orcamento pelo site');
        $mail->addReplyTo($email, $name);
        $mail->addAddress('contato@pixdesign.com.br');


        // Conteúdo do email
        $mail->isHTML(false);
        $mail->Subject = "Novo orcamento pelo site";
        $mail->Body = 
            "Nome: $name\n" .
            "E-mail: $email\n" .
            "Telefone: $phone\n\n" .
            "Mensagem:\n$message";

        $mail->send();
        echo "OK"; // para o JS do formulário entender como sucesso
    } catch (Exception $e) {
        http_response_code(500);
        echo "Erro ao enviar: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(405);
    echo "Método não permitido.";
}
