<?php

namespace App\Controllers;

use App\Config;
use App\Models\Element;
use App\Models\User;
use App\Models\News;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Page;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Admin extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */

    public function __construct(array $route_params)
    {
        parent::__construct($route_params);
        if(!isset($_SESSION['islogin'])){

            header("Location: ".Config::URL_BASE."#admin");
        }
    }

    public function setLanguageAction()
    {
        $language = $this->route_params['lng'];
        if (in_array($language, Config::LANGUAGE)) {
            setcookie("language", $language, time() + 36000000, '/');
        } else {
            if(!isset($_COOKIE['language'])) {
                setcookie('language', 'en');
            }
        }
        header("Location: ".Config::URL_BASE."admin/dashboard");
    }

    public function registerAction()
    {
        View::renderTemplate('Admin/register.twig');

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($_POST['password'] == $_POST['confirm_password']){
                User::insert($_POST['title'], $_POST['username'],$_POST['password'] ,1);
                echo 'ok';
            }else{
                echo 'error';
            }

        }
    }

    public function insertAction()
    {

        View::renderTemplate('Admin/register.twig');
    }

    public function updateAction()
    {

        $user = User::getuser($_POST['id']);
        if(!empty($user['id']))
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($_POST['password'] == $_POST['confirm_password']){
                    User::update($_POST['id'], $_POST['title'], $_POST['username'], $_POST['password'], 1);
                    echo 'ok';
                }else{
                    echo 'error';
                }

            }
            header("Location: ".Config::URL_BASE."/admin/list");
        }
    }

    public function editAction()
    {

        $user_id = $this->route_params['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $user = User::getuser($user_id);

            View::renderTemplate('Admin/admin_edit.twig', ['user' => $user]);

        }

    }

    public function storeAction()
    {
        User::insert($_POST['title'], $_POST['username'], $_POST['password'], $_POST['is_admin'] = 1);

        header("Location: ".Config::URL_BASE."admin/list");
    }

    public function deleteAction()
    {
        $id = $this->route_params['id'];
        User::delete($id);
        header("Location: ".Config::URL_BASE."admin/list");
    }

    public function listAction()
    {
        $users = User::getAll();

        View::renderTemplate('Admin/admin_list.twig', ['users' => $users]);
    }

    public function verifyAction(){
        User::verify($_POST['username'], $_POST['password']);
        if(isset($_SESSION['islogin'])){
            unset($_SESSION['error']);
            if($_SESSION['islogin']->is_admin == 1){
//                var_dump($_SESSION);
//                die();
                header('location: ' .Config::URL_BASE. 'admin/dashboard');
            }else{
                header('location: ' .Config::URL_BASE. 'admin/dashboard');
            }

        }else{
            $_SESSION['error'] = 'Oops. user pass is not valid!';
            header('location: ' .Config::URL_BASE. 'admin/login');
        }
    }
    public function dashboardAction(){

        $countitems[]= [count(News::getAll()),count(Page::getAll()), count(Brand::getAll()), count(Product::getAll()) ];
        $user = User::getuser('id');


        View::renderTemplate('Admin/dashboard.twig' , ['countitems'=>$countitems , 'user'=>$user]);
    }
    public function logout(){
        session_destroy();
        header('location: ' .Config::URL_BASE );
    }



//    public function capchaAction()
//    {
//        session_start();
//        $random = md5(rand());
//        $captcha_vms = substr($random, 0, 6);
//        $_SESSION["captcha_vms"] = $captcha_vms;
//        $target = imagecreatetruecolor(70,30);
//        $captcha_background = imagecolorallocate($target, 255, 78, 19);
//        imagefill($target,0,0,$captcha_background);
//        $captcha_fore_color = imagecolorallocate($target, 0, 0, 0);
//        imagestring($target, 8, 5, 5, $captcha_vms, $captcha_fore_color);
//        header("Content-type: image/jpeg");
//        imagejpeg($target);
//    }



}
