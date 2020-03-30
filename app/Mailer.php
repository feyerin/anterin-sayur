<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer extends Model
{
    public static function sendEmail($order = null, $email = null) {

        require 'vendor/autoload.php';// load Composer's autoloader

        $mail = new PHPMailer(true);                            // Passing `true` enables exceptions

        try {
            // Server settings
            $mail->SMTPDebug = 0;                                	// Enable verbose debug output
            $mail->isSMTP();                                     	// Set mailer to use SMTP
            $mail->Host = env('MAIL_HOST');						// Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                              	// Enable SMTP authentication
            $mail->Username = env('MAIL_USERNAME');             // SMTP username
            $mail->Password = env('MAIL_PASSWORD');              // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), 'Mailer');
            $mail->addAddress('zaid.al.anshori@gmail.com', 'Optional name');	// Add a recipient, Name is optional
            $mail->addReplyTo(env('MAIL_FROM_ADDRESS'), 'Mailer');
            // $mail->addCC('his-her-email@gmail.com');
            // $mail->addBCC('his-her-email@gmail.com');

            //Attachments (optional)
            // $mail->addAttachment('/var/tmp/file.tar.gz');			// Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');	// Optional name

            //Content
            $mail->isHTML(true); 																	// Set email format to HTML
            $mail->Subject = 'tes';
            $mail->Body    = 'tes';						// message

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
        
    }
}
