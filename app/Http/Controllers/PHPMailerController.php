<?php

namespace App\Http\Controllers;

use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;

/**
 *
 */
class PHPMailerController extends Controller
{

    /**
     * @param PHPMailer $mail
     * @param $email
     * @return false|string
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function PHPMailerSettings(PHPMailer $mail, $email)
    {
        $message = ob_get_contents();
        ob_end_clean();


        $mail->SMTPSecure = 'tls';
        $mail->Host = "smtp-mail.outlook.com";
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'mars@divtec.ch';
        $mail->Password = '';
        $mail->SetFrom('mars@divtec.ch', 'DIVTEC Mars');
        $mail->AddAddress($email);
        return $message;
    }


    /**
     * @param $email
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendMailWelcome($email)
    {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);


        $user = User::where('email', $email)->first();

        ob_start();
        $name = $user->first_name;
        $lienBase = "https://mars.divtec.ch/user/" . $user->id;

        include('Templates/WelcomeEmailTemplate.php');
        $message = $this->PHPMailerSettings($mail, $email);
        $mail->Subject = 'Bienvenue sur Mars !';

        $mail->MsgHTML($message);
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

    }

    /**
     * @param $email
     * @param $token
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendMailReset($email, $token)
    {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);


        $user = User::where('email', $email)->first();

        ob_start();
        $name = $user->first_name;
        $lienReset = "https://mars.divtec.ch/password-reset?token=" . $token;

        include('Templates/ResetPasswordEmailTemplate.php');
        $message = $this->PHPMailerSettings($mail, $email);
        $mail->Subject = 'Réinitialisation de votre compte';

        $mail->MsgHTML($message);
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

    }

    /**
     * @param $email
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendMailResponsable($email, $password)
    {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);

        $user = User::where('email', $email)->first();

        ob_start();
        $name = $user->first_name;
        $email_resp = $email;
        $mdp_resp = $password;

        include('Templates/ResponsableEmailTemplate.php');
        $message = $this->PHPMailerSettings($mail, $email);
        $mail->Subject = 'Compte Responsable Divtec Mars';

        $mail->MsgHTML($message);
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

    }

}
