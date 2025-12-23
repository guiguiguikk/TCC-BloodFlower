<?php

$start = microtime(true);
// Seu código a ser medido

session_start();

// Se o usuário já estiver logado, redireciona para a home
if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}
include("conexao.php");

$_SESSION["codigo"] = rand(100000, 999999);
$codigo = $_SESSION["codigo"];

$email_recuperaçao = $_POST['email'];

$sql = "SELECT * FROM usuarios WHERE email = '$email_recuperaçao'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) < 1) {
    //header("Location: recuperarSenha.php");
    mysqli_error($conn);

    exit();
}
$usuario = mysqli_fetch_array($result);


//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';



//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'bloodflowertcc@gmail.com';                     //SMTP username
    $mail->Password   = 'afdv cwqx leim usqe';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('bloodflowertcc@gmail.com', 'BloodFlower');
    $mail->addAddress($usuario['email'], $usuario['nome']);     //Add a recipient
    $mail->addReplyTo('bloodflowertcc@gmail.com', 'Information');

    //Optional name

    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';


    $mail->isHTML(true);
    $mail->Subject = '🔐 Recuperação de Senha - BloodFlower';

    $mail->Body = "
    <div style='font-family: Arial, sans-serif; padding: 20px; background: #111; color: #fff; border-radius: 8px;'>
        <h2 style='color: #e63946;'>Recuperação de Senha</h2>
        <p>Olá! Recebemos uma solicitação para redefinir a sua senha no <strong>BloodFlower</strong>.</p>

        <p>Use o código abaixo para continuar com a recuperação:</p>

        <div style='margin: 20px 0; padding: 15px; background: #222; border-left: 4px solid #e63946; display: inline-block;'>
            <span style='font-size: 24px; letter-spacing: 3px; color: #e63946;'><strong>$codigo</strong></span>
        </div>

        <p>Se você <strong>não solicitou</strong> essa recuperação, apenas ignore este e-mail.</p>

        <p style='margin-top: 30px;'>Atenciosamente,<br>
        <strong>Equipe BloodFlower 🖤</strong></p>
    </div>
";

    $mail->AltBody = "Recuperação de Senha - BloodFlower\n\n" .
        "Seu código de verificação é: $codigo\n\n" .
        "Se você não solicitou isso, ignore este e-mail.";


    $mail->send();
    echo 'Message has been sent';

    //guardando email na sessão para usar na próxima etapa
    $_SESSION['email_recuperacao'] = $usuario['email'];

    header("Location: codigoRecuperacao.php");

    //$end = microtime(true);
   // $time_elapsed_secs = $end - $start;
    //echo "Tempo de execução: " . $time_elapsed_secs . " segundos";
    exit;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
