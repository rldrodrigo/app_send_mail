<?php

require "./bibliotecas/PHPMailer/Exception.php";
require "./bibliotecas/PHPMailer/OAuth.php";
require "./bibliotecas/PHPMailer/POP3.php";
require "./bibliotecas/PHPMailer/SMTP.php";
require "./bibliotecas/PHPMailer/PHPMailer.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mensagem
{
    private $para = null;
    private $assunto = null;
    private $mensagem = null;

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function mensagemValida()
    {
        if (empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
            return false;
        }
        return true;
    }
}

$mensagem = new Mensagem();

$mensagem->__set('para', $_POST['para']);
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);


//print_r($mensagemif);
if (!$mensagem->mensagemValida()) {
    echo 'Mensagem não é válida';
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                                       //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'email';         //SMTP username
    $mail->Password   = 'senha';                          //SMTP password
    $mail->SMTPSecure = 'tls';                                  //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('email', 'Rodrigo Lima Remetente');           //Email do Remetente
    $mail->addAddress('email', 'Rodrigo Lima Destinatario');     //Email do Destinatário
    //$mail->addAddress('ellen@example.com');        //Define mais destinatários     //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');   //Define o email padrão para quando responderem
    //$mail->addCC('cc@example.com');       
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Oi, este é o assunto';
    $mail->Body    = 'Oi. este é o conteúdo do <strong> e-mail </strong>'; //Usado para client com renderização HTML
    $mail->AltBody = 'Oi. este é o conteúdo do e-mail ';

    $mail->send();
    echo 'Mensagem enviada';
} catch (Exception $e) {
    echo "Não foi possível enviar este e-mail, por favor tente novamente mais tarde. Detalhes do Erro: {$mail->ErrorInfo}";
}
