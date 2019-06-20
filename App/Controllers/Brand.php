<?php

namespace App\Controllers;

use App\Models\Brandbranch;
use App\Models\Media;
use App\Models\Meta;
use App\Models\Product;
use \Core\View;
use App\Models\Element;
use App\Models\Menu;
use App\Models\Brand as brandModel;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Brand extends \Core\Controller
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

        View::renderTemplate('Brand/'.$this->language.'_review.twig' , ['elements'=>$elements, 'menues'=>$menues ]);
    }

    public function reviewAction()
    {
        $id = $this->route_params['id'];

        $brand = brandModel::getBrand($id);
        if(empty($brand)){
            redirect('en');
        }
        $products = Product::getBrandProduct($id);
        $menues = Menu::getRecursive();
        $elements = Element::getAll();
        $medias = Media::getMediaAll('brand', $id, 'gallery');
        $branches = Brandbranch::getBrandBranch($id);
        $meta = Meta::getMeta('brand', $id);

        View::renderTemplate('Brand/'.$this->language.'_review.twig' , ['brand'=>$brand, 'products'=> $products,  'elements'=>$elements, 'menues'=> $menues, 'medias'=>$medias, 'branches'=>$branches, 'meta' => $meta]);
    }
}
