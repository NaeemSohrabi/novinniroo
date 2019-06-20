<?php

namespace App\Controllers;

use App\Models\Media;
use \Core\View;
use App\Models\Element;
use App\Models\Menu;
use App\Models\Contact as ContactModel;
use App\Controllers\Captcha;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Contact extends \Core\Controller
{

    public function __construct(array $route_params)
    {
        parent::__construct($route_params);
        if(isset($_COOKIE['language'])){
            $this->language = $_COOKIE['language'];
        }
    }


    public function reviewAction()
    {
//        $slug = $this->route_params['slug'];

        $contacts = ContactModel::getAll();
        if(empty($contacts)){
            redirect('lng/en');
        }
        $menues = Menu::getRecursive();
        $elements = Element::getAll();
//        $captcha = Captcha::$this->$_SESSION['captcha'];

        View::renderTemplate('contact/'.$this->language.'_review.twig' , ['contacts'=>$contacts, 'elements'=>$elements, 'menues'=> $menues]);
    }
}
