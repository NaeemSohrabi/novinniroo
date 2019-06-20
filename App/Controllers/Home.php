<?php

namespace App\Controllers;

use App\Config;
use App\Models\Customer;
use App\Models\Element;
use App\Models\Employee;
use App\Models\Media;
use App\Models\Menu;
use App\Models\Meta;
use App\Models\Services;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */

    public function __construct(array $route_params)
    {
        parent::__construct($route_params);
        if(isset($_COOKIE['language'])){
            $this->language = $_COOKIE['language'];
        }
    }
//    public function loginAction()
//    {
//        View::renderTemplate('Admin/login.twig');
//    }

    public function introAction()
    {
        setcookie('language', '', time() + (10 * 365 * 24 * 60 * 60));
        function Multiply ($value){
            $value = $value + 10;
            return $value;
        }

//        $retval = Multiply(10);
//
//        print "return value is $retval\n";

//        die();

        View::renderTemplate('Home/admin.twig');
    }

    public function introPageAction()
    {
        setcookie('language', '', time() + (10 * 365 * 24 * 60 * 60));

        View::renderTemplate('Home/intro.twig');
    }

    public function setLanguageAction()
    {
        $language = $this->route_params['lng'];
        if (in_array($language, Config::LANGUAGE)) {
            setcookie("language", $language, time() + (10 * 365 * 24 * 60 * 60), '/');
        } else {
            if(!empty($this->language)) {
                setcookie('language', $this->language);
            }
        }
        $reffer_url = refUrl(@$_SERVER['HTTP_REFERER']);
        header("Location: ".Config::URL_BASE.$reffer_url);
    }

    public function indexAction()
    {
        $menues = Menu::getRecursive();
        $elements = Element::getAll();
        $slideshow = Media::getMediaAll('home', 0, 'slideshow');
        $customers = Customer::getAll();
        $services = Services::getAll();
        $meta = Meta::getMeta('home',0);
        View::renderTemplate('Home/'.$this->language.'_index.twig', ['slideshow' => $slideshow, 'elements' => $elements, 'customers' => $customers, 'menues' => $menues, 'services' => $services, 'meta' => $meta]);
//        View::renderTemplate('Home/intro.twig', ['slideshow' => $slideshow, 'elements' => $elements, 'customers' => $customers, 'menues' => $menues, 'services' => $services, 'meta' => $meta]);
//        View::renderTemplate('Home/updating.twig');
    }

    public function contactAction()
    {
        $menues = Menu::getRecursive();
        $elements = Element::getAll();
        View::renderTemplate('Home/'.$this->language.'_contact.twig', ['elements' => $elements, 'menues' => $menues, 'departments' => Config::DEPARTMENTS]);
    }


    public function aboutAction()
    {
        $menues = Menu::getRecursive();
        $elements = Element::getAll();
        $medias = Media::getMediaAll('about', 'null', 'gallery');
        $employees = Employee::getAll();
        View::renderTemplate($this->language.'_about.twig', ['elements' => $elements, 'menues' => $menues, 'medias' => $medias, 'employees' => $employees]);
    }

    public function aboutmediastoreAction()
    {
        if ($_FILES['media']['size'] == 0 && $_FILES['media']['error'] == 4) {
            echo 'file is null !';
        }else{
            $media_file = upload($_FILES['media']);
            if ($media_file !== false) {
                Media::insert($_POST['entity_type'], $_POST['entity_id'], $_POST['entity_position'],null, null, null, null, null ,$media_file);
            } else {
                echo 'upload error!';
            }
        }
        header("Location: ".Config::URL_BASE."admin/".$_POST['entity_type']."/edit");
    }

}
