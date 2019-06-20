<?php

namespace App\Controllers;

use App\Models\Brand;
use App\Models\Media;
use App\Models\News;
use App\Models\Product;
use App\Models\Services;
use \Core\View;
use App\Config;
use App\Models\Menu;
use App\Models\Element;


/**
 * Home controller
 *
 * PHP version 7.0
 */
class AdminServices extends \Core\Controller
{

    public function __construct(array $route_params)
    {
        parent::__construct($route_params);
        if(!isset($_SESSION['islogin'])){

            header("Location: ".Config::URL_BASE."#admin");
        }
    }

    public function ListAction()
    {
        $services = Services::getAll();

        View::renderTemplate('Admin/service/list.twig', ['services' => $services]);

    }

    public function InsertAction()
    {
        $services = Services::getAll();
        $brands = Brand::getAll();
        $products = Product::getAll();
        $pages = \App\Models\Page::getAll();
        View::renderTemplate('Admin/service/insert.twig', ['services' => $services, 'brands' => $brands,'products' => $products,'pages' => $pages  ]);

    }

    public function storeAction()
    {
        $image = upload($_FILES['image']);
        if ($image == false) {
            echo 'upload error!';
        }
        Services::insert($_POST['title'], $_POST['fa_title'] ,$_POST['description'], $_POST['fa_description'], $_POST['link'], $_POST['alt'], $_POST['alt_fa'] , $image);


        header("Location: ".Config::URL_BASE."Admin/service/list");
    }

    public function editAction()
    {
        $id = $this->route_params['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $service = Services::getService($id);
            $brands = Brand::getAll();
            $products = Product::getAll();
            $pages = \App\Models\Page::getAll();
//            $media = Media::getMediaAll('product', $id, 'gallery');
            View::renderTemplate('Admin/service/edit.twig', ['service' => $service, 'brands' => $brands,'products' => $products,'pages' => $pages]);
        }
    }

    public function updateAction()
    {

        $service = Services::getService($_POST['id']);
        // check file is sent
        if ($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 4) {
            $image = $service['image'];
            echo 'step 1!';
        } else {
            // check upload validation
            $image = upload($_FILES['image']);
            if ($image !== false) {
                if (!empty($service['image'])) {
                    unlink(APP_DIR . '/public/uploads/' . $service['image']);
                    echo 'step 2!';
                }
                echo 'step 3!';
            } else {
                echo 'upload error!';
            }
        }

        Services::update($_POST['id'], $_POST['title'], $_POST['fa_title'] ,$_POST['description'], $_POST['fa_description'], $_POST['link'], $_POST['alt'], $_POST['alt_fa'] ,$image , $_POST['status'] , $_POST['priority']);
        header("Location: " . Config::URL_BASE . "Admin/service/edit/" . $_POST['id']);
    }

    public function deleteAction()
    {
        $id = $this->route_params['id'];
        Services::delete($id);
        header("Location: " . Config::URL_BASE . "Admin/service/list");
    }
}
