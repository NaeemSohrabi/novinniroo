<?php
/**
 * Created by PhpStorm.
 * User: Naeem_Sohrabi
 * Date: 11/2/2017
 * Time: 11:46 PM
 */

namespace App\Controllers;
use \Core\View;



class UserController extends \Core\Controller
{

    public function registerAction()
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST')
            return;

//        $rule = [
//            'name' => required,
//            'password' => required,
//            'confirm_password' => get_required_files()
//
//        ];

        View::renderTemplate('Admin/register.twig');


        var_dump($_POST);die;

    }


}