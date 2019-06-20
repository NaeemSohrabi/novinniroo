<?php

namespace App\Controllers;

use App\Models\Customer;
use App\Models\Element;
use App\Models\Media;
use App\Models\Menu;
use \Core\View;
use App\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Captcha extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */

    public function mkcaptchaAction()
    {

        //Set the Content Type
        header('Content-type: image/jpeg');

        // Create Image From Existing File
        $jpg_image = imagecreatefromjpeg(config::URL_BASE . 'images/sunset.jpg');

        // Allocate A Color For The Text
        $white = imagecolorallocate($jpg_image, 0, 0, 0);
//        $black = imagecolorallocate($jpg_image, 0, 0, 0);
        $blue = imagecolorallocate($jpg_image, 51, 199, 255);

        // Set Path to Font File
        $font_path = APP_DIR . '/public/fonts/iransans/iransans.ttf';
//    echo $font_path;

        // Set Text to Be Printed On Image
        $text = $this->generateRandomString(4);

        $_SESSION['captcha'] = $text;

        // Print Text On Image
        imagettftext($jpg_image, 30, 2, 30, 36, $white, $font_path, $text);

        for ($i = 0; $i < 50; $i++) {
            //imagefilledrectangle($im, $i + $i2, 5, $i + $i3, 70, $black);
            imagesetthickness($jpg_image, rand(1, 5));
            imagearc(
                $jpg_image,
                rand(1, 500), // x-coordinate of the center.
                rand(1, 500), // y-coordinate of the center.
                rand(1, 500), // The arc width.
                rand(1, 500), // The arc height.
                rand(1, 500), // The arc start angle, in degrees.
                rand(1, 500), // The arc end angle, in degrees.
                (rand(0, 1) ? $blue : $blue) // A color identifier.
            );
        }

        // Send Image to Browser
        imagejpeg($jpg_image);



        // Clear Memory
        imagedestroy($jpg_image);
//        var_dump($text);
//        die();



    }





    function generateRandomString($length = 4) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
