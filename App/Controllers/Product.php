<?php

namespace App\Controllers;
use App\Models\Media;
use App\Models\Meta;
use \Core\View;
use App\Models\Element;
use App\Models\Menu;
use App\Models\Product as productModel;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Product extends \Core\Controller
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
        $id = $this->route_params['id'];

        $product = productModel::getProduct($id);
        if(empty($product)){
            redirect('en');
        }
        $menues = Menu::getRecursive();
        $elements = Element::getAll();
        $medias = Media::getMediaAll('product', $id, 'gallery');
        $meta = Meta::getMeta('product', $id);
        $brand = \App\Models\Brand::getBrand('id');
        View::renderTemplate('Product/'.$this->language.'_review.twig'  , ['product'=>$product, 'elements'=>$elements, 'menues'=> $menues, 'medias'=>$medias, 'brand'=>$brand, 'meta'=>$meta]);
    }
}
