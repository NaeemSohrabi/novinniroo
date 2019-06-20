<?php

namespace App\Controllers;

use App\Models\Customer;
use App\Models\Element;
use App\Models\Media;
use App\Models\Menu;
use \Core\View;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Ajax extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function emailAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            # Ex. check the query and serve requested data

            if ($_SESSION['captcha'] == $_POST['code'])
            {

                $mail = new PHPMailer(false);                            // Passing `true` enables exceptions
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'mail.novinniroo.co';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = 'noreply@novinniroo.co';                 // SMTP username
                    $mail->Password = 'Tz]rsO1_$a.5';                           // SMTP password
//                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587;
                    $mail->SMTPAutoTLS = false;// TCP port to connect to
                    $mail->CharSet = "UTF-8";

                    //Recipients
                    $mail->setFrom($_POST['email'], $_POST['name']);
                    $mail->addAddress($_POST['department'], 'ContactUs');     // Add a recipient
//                $mail->addAddress('ellen@example.com');               // Name is optional
//                $mail->addReplyTo('info@example.com', 'Information');
//                $mail->addCC('cc@example.com');
//                $mail->addBCC('bcc@example.com');

                    //Attachments
//                $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//                $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'New Contact us email';
                    $mail->Body = $_POST['message'] . "<br><br>" . "تلفن: " . $_POST['tel'];
//                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
//                    echo 'Message has been sent';
                }

                catch (Exception $e) {
//                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                    return false;
                }
            echo 'success';

            }

        elseif (empty($_POST['code']))
            {
                echo 'empty';

            } elseif ($_SESSION['captcha'] !== $_POST['code'])
            {
                echo 'error';
            }
        }
    }




    public function deleteMediaAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $id = $_POST['id'];
            Media::deleteMedia($id);
            echo 'its ok';
        }
    }

    public function altMediaAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $id = $_POST['id'];
            Media::altMedia($id,$_POST['alt'], $_POST['alt_fa'], $_POST['status']);
            echo 'its ok';
        }
    }
}


