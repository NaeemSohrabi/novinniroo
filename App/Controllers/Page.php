<?php

namespace App\Controllers;

use App\Models\Media;
use App\Models\Meta;
use \Core\View;
use App\Models\Element;
use App\Models\Menu;
use App\Models\Page as PageModel;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Page extends \Core\Controller
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
        $slug = $this->route_params['slug'];

        $page = PageModel::getPageSlug($slug);
        if(empty($page)){
            redirect('lng/en');
        }
        $menues = Menu::getRecursive();
        $elements = Element::getAll();
        $medias = Media::getMediaAll('page', $page['id'], 'gallery');
        $meta = Meta::getMeta('page', $page['id']);
        View::renderTemplate('page/'.$this->language.'_review.twig' , ['page'=>$page, 'elements'=>$elements, 'menues'=> $menues, 'medias'=>$medias, 'meta' => $meta]);
    }
}
