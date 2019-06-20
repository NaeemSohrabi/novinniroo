<?php

namespace App\Controllers;

use App\Models\Brand;
use App\Models\Media;
use App\Models\Meta;
use App\Models\Product;
use \Core\View;
use App\Config;
use App\Models\Menu;
use App\Models\Element;


/**
 * Home controller
 *
 * PHP version 7.0
 */
class AdminProduct extends \Core\Controller
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
        $brands = Brand::getAll();
        $brand_id = @$_POST['filter'];

        if ($brand_id == '') {
            $products = Product::getAll();
            $num = count($products);

        } elseif ($brand_id == '0') {
            $products = Product::getAll();
            $num = count($products);

        } else {
            $products = Product::searchProduct($brand_id);
            $num = count($products);
        }

        View::renderTemplate('Admin/product/product_list.twig', ['products' => $products, 'brands' => $brands, 'num' => $num]);
    }

    public function ArchiveAction()
    {
        View::renderTemplate('Admin/product/product_archive.twig');
    }

    public function InsertAction()
    {
        $brands = Brand::getAll();
        View::renderTemplate('Admin/product/product_insert.twig', ['brands' => $brands]);

    }

    public function storeAction()
    {
        $fa_catalog = upload($_FILES['fa_catalog']);
        if ($fa_catalog == false) {
            echo 'upload error!';
        }
        $catalog = upload($_FILES['catalog']);
        if ($catalog == false) {
            echo 'upload error!';
        }
        $cover = upload($_FILES['cover']);
        if ($cover == false) {
            echo 'upload error!';
        }
        Product::insert($_POST['title'], $_POST['fa_title'] ,$_POST['description'], $_POST['fa_description'] ,$_POST['content'], $_POST['fa_content'] ,$catalog, $fa_catalog ,$_POST['brand_id'], $cover);


        header("Location: ".Config::URL_BASE."Admin/product/edit/" . $_POST['id']);
    }

    public function editAction()
    {
        $id = $this->route_params['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $product = Product::getProduct($id);
            $media = Media::getMediaAll('product', $id, 'gallery');
            $meta = Meta::getMeta('product', $id);
            $brands = Brand::getAll();
            View::renderTemplate('Admin/product/product_edit.twig', ['product' => $product, 'medias' => $media, 'brands' => $brands, 'meta' => $meta]);

        }
    }

    public function updateAction()
    {

        $product = Product::getProduct($_POST['id']);
        // check file is sent
        if ($_FILES['catalog']['size'] == 0 && $_FILES['catalog']['error'] == 4) {
            $catalog = $product['catalog'];
            echo 'step 1!';
        } else {
            // check upload validation
            $catalog = upload($_FILES['catalog']);
            if ($catalog !== false) {
                if (!empty($product['catalog'])) {
                    unlink(APP_DIR . '/public/uploads/' . $product['catalog']);
                    echo 'step 2!';
                }
                echo 'step 3!';
            } else {
                echo 'upload error!';
            }
        }

        if ($_FILES['fa_catalog']['size'] == 0 && $_FILES['fa_catalog']['error'] == 4) {
            $fa_catalog = $product['fa_catalog'];
            echo 'step 1!';
        } else {
            // check upload validation
            $fa_catalog = upload($_FILES['fa_catalog']);
            if ($fa_catalog !== false) {
                if (!empty($product['fa_catalog'])) {
                    unlink(APP_DIR . '/public/uploads/' . $product['fa_catalog']);
                    echo 'step 2!';
                }
                echo 'step 3!';
            } else {
                echo 'upload error!';
            }
        }

        if ($_FILES['cover']['size'] == 0 && $_FILES['cover']['error'] == 4) {
            $cover = $product['cover'];
            echo 'step 1!';
        } else {
            // check upload validation
            $cover = upload($_FILES['cover']);
            if ($cover !== false) {
                if (!empty($product['cover'])) {
                    unlink(APP_DIR . '/public/uploads/' . $product['cover']);
                    echo 'step 2!';
                }
                echo 'step 3!';
            } else {
                echo 'upload error!';
            }
        }

        Product::update($_POST['id'], $_POST['title'], $_POST['fa_title'] ,$_POST['description'], $_POST['fa_description'] ,$_POST['content'], $_POST['fa_content'] ,$catalog , $fa_catalog ,$_POST['brand_id'], $cover);
        header("Location: " . Config::URL_BASE . "Admin/product/edit/" . $_POST['id']);
    }

    public function deleteAction()
    {
        $id = $this->route_params['id'];
        Product::delete($id);
        header("Location: " . Config::URL_BASE . "Admin/product/list");
    }

    public function mediastoreAction()
    {
        if ($_FILES['media']['size'] == 0 && $_FILES['media']['error'] == 4) {
            echo 'file is null !';
        }else{
            $media_file = upload($_FILES['media']);
            if ($media_file !== false) {
                Media::insert($_POST['entity_type'], $_POST['entity_id'], $_POST['entity_position'],null, null, null, null,$link ,$media_file);
            } else {
                echo 'upload error!';
            }
        }
        header("Location: ".Config::URL_BASE."admin/".$_POST['entity_type']."/edit/".$_POST['entity_id'] . "#" . $_POST['entity_position']);
    }

    public function indexAction()
    {
//        $id = $this->route_params['id'];
//
//
//        if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $elements = Element::getAll();
        $menues = Menu::getAll();
//            $brand = Brand::getBrand($id);
//            $products = Product::getAll();
        View::renderTemplate('Product/en_review.twig', ['elements' => $elements, 'menues' => $menues]);
//        , ['elements' => $elements, 'brand' => $brand, 'products' => $products]

    }

    public function downloadAction()
    {

        $id = $this->route_params['id'];
        $product = productModel::getProduct($id);
        print_r($products);

    }

}
