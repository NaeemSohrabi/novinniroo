<?php

namespace App\Controllers;

use App\Config;
use App\Models\Brand;
use App\Models\Media;
use \Core\View;


/**
 * Home controller
 *
 * PHP version 7.0
 */
class AdminHome extends \Core\Controller
{

    public function __construct(array $route_params)
    {
        parent::__construct($route_params);
        if (!isset($_SESSION['islogin'])) {

            header("Location: " . Config::URL_BASE . "#admin");
        }
    }

    public function slideshowListAction()
    {
        $media = Media::getMediaAll('home', null, 'slideshow');
        $brands = Brand::getAll();
        $products = \App\Models\Product::getAll();
        $pages = \App\Models\Page::getAll();
        View::renderTemplate('Admin/home/home_slideshow_list.twig', ['medias' => $media, 'brands' => $brands, 'products' => $products, 'pages' => $pages]);
    }

    public function slideshowStoreAction()
    {
        // check file is sent
        if ($_FILES['media']['size'] == 0 && $_FILES['media']['error'] == 4) {
            echo '! Ooops file empty';
        } else {
            $media_file = upload($_FILES['media']);
            if ($media_file !== false) {
echo "id : ".$_POST['entity_id'];
                Media::insert($_POST['entity_type'], $_POST['entity_id'], $_POST['entity_position'], $_POST['title'], $_POST['fa_title'], $_POST['description'], $_POST['fa_description'], $_POST['link'], $media_file);
            } else {
                echo 'upload error!';
            }
        }
        header("Location: " . Config::URL_BASE . "admin/home/slideshow/list");
    }

    public function slideshoweditAction()
    {
        $id = $this->route_params['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $brands = Brand::getAll();
            $products = \App\Models\Product::getAll();
            $pages = \App\Models\Page::getAll();
            $media = Media::getMedia($id);
            View::renderTemplate('Admin/home/home_slideshow_edit.twig', ['media' => $media, 'brands' => $brands, 'products' => $products, 'pages' => $pages]);

        }
    }

    public function slideshowupdateAction()
    {
        $media = Media::getMedia($_POST['id']);
        // check file is sent
        if ($_FILES['media']['size'] == 0 && $_FILES['media']['error'] == 4) {
            $media_file = $media['file'];
            echo 'step 1!';
        } else {
            // check upload validation
            $media_file = upload($_FILES['media']);
            if ($media_file !== false) {
                if (!empty($media['media'])) {
                    unlink(APP_DIR . '\uploads\\' . $media['media']);
                    echo 'step 2!';
                }
                echo 'step 3!';
            } else {
                echo 'upload error!';
            }
        }
        Media::update($_POST['id'], $_POST['entity_type'], $_POST['entity_id'], $_POST['entity_position'], $_POST['title'], $_POST['fa_title'], $_POST['description'], $_POST['fa_description'], $_POST['link'], $media_file, $_POST['status'] , $_POST['priority']);

        header("Location: " . Config::URL_BASE . "admin/home/slideshow/edit/" . $media['id']);
    }

    public function slideshowdeleteAction()
    {
        $id = $this->route_params['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $media = Media::getMedia($id);
            unlink(APP_DIR . '\uploads\\' . $media['file']);
            Media::deleteMedia($id);
        }
        header("Location: " . Config::URL_BASE . "admin/home/slideshow/list");
    }

}
