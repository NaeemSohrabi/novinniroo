<?php

namespace App\Controllers;
use App\Models\Media;
use \Core\View;
use App\Models\Element;
use App\Models\Menu;
use App\Models\News as newsModel;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class News extends \Core\Controller
{

    public function __construct(array $route_params)
    {
        parent::__construct($route_params);
        if(isset($_COOKIE['language'])){
            $this->language = $_COOKIE['language'];
        }
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $elements = Element::getAll();
        $menues = Menu::getRecursive();

        View::renderTemplate('Brand/en_review.twig' , ['elements'=>$elements, 'menues'=>$menues ]);
    }

    public function reviewAction()
    {
//        $id = $this->route_params['id'];

        $newses = newsModel::getAll();
        if(empty($newses)){
            redirect('lng/en');
        }
        $newscount =count($newses);
        $menues = Menu::getRecursive();
        $elements = Element::getAll();
//        $medias = Media::getMediaAll('product', $id, 'gallery');
//        $brand = \App\Models\Brand::getBrand('id');
        View::renderTemplate('news/'.$this->language.'_review.twig'  , ['elements'=>$elements, 'menues'=> $menues, 'newses' =>$newses, 'newscount'=>$newscount ]);
    }
}
