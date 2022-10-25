<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$template = $_GET['t'];

echo $template;

if ($template == 'welcome') {
    sendMailWelcome();
} elseif ($template == 'reset') {
    sendMailReset();
} elseif ($template == 'responsable') {
    sendMailResponsable();
} else {
    echo "template invalide";
}

    function sendMailReset()
    {
        require_once 'vendor/autoload.php';
        $mail = new PHPMailer(true);

        ob_start();
        $name = $_GET['name'];
        $lienReset = "https://mars.divtec.ch/password-reset?token=" . $_GET['token'];

        include('Templates/ResetPasswordEmailTemplate.php');
        $message = PHPMailerSettings($mail, $_GET['email']);
        $mail->Subject = 'Réinitialisation de votre compte';

        $mail->MsgHTML($message);
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

    }

    function sendMailWelcome()

    {
        require_once 'vendor/autoload.php';
        $mail = new PHPMailer(true);


        $first_name = $_GET['fname'];
        $id = $_GET['id'];
        $user_email = $_GET['email'];

        ob_start();
        $name = $first_name;
        $lienBase = "https://mars.divtec.ch/user/" . $id;
        $email = $user_email;

        include('Templates/WelcomeEmailTemplate.php');
        $message = PHPMailerSettings($mail, $user_email);
        $mail->Subject = 'Bienvenue sur Mars !';

        $mail->MsgHTML($message);
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

    }


    function sendMailResponsable()
    {
        require_once 'vendor/autoload.php';
        $mail = new PHPMailer(true);


        ob_start();
        $name = $_GET['name'];
        $email_resp = $_GET['email'];
        $mdp_resp = $_GET['mdp'];

        include('Templates/ResponsableEmailTemplate.php');
        $message = PHPMailerSettings($mail, $_GET['email']);
        $mail->Subject = 'Compte Responsable Divtec Mars';

        $mail->MsgHTML($message);
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

    }

    function PHPMailerSettings(PHPMailer $mail, $email)
    {
        $message = ob_get_contents();
        ob_end_clean();

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Host = "mail.infomaniak.com";
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = '';
        $mail->SetFrom('', 'DIVTEC Mars');
        $mail->AddAddress($email);
        return $message;
    }


