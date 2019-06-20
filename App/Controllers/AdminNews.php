<?php

namespace App\Controllers;

use App\Models\Brand;
use App\Models\Media;
use App\Models\Meta;
use App\Models\News;
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
class AdminNews extends \Core\Controller
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
        $newses = News::getAll();

        View::renderTemplate('Admin/news/list.twig', ['newses' => $newses]);

    }

    public function InsertAction()
    {
        $newses = News::getAll();
        View::renderTemplate('Admin/news/insert.twig', ['newses' => $newses]);

    }

    public function storeAction()
    {

        $image = upload($_FILES['image']);
        if ($image == false) {
            echo 'upload error!';
        }
        News::insert($_POST['title'], $_POST['fa_title'] ,$_POST['description'], $_POST['fa_description'] , $image, $_POST['alt'], $_POST['alt_fa']);


        header("Location: ".Config::URL_BASE."Admin/news/list");
    }

    public function editAction()
    {
        $id = $this->route_params['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $news = News::getNews($id);
//            $media = Media::getMediaAll('product', $id, 'gallery');
//            $brands = Brand::getAll();
            View::renderTemplate('Admin/news/edit.twig', ['news' => $news]);
        }
    }

    public function updateAction()
    {

        $news = News::getNews($_POST['id']);
        // check file is sent
        if ($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 4) {
            $image = $news['image'];
            echo 'step 1!';
        } else {
            // check upload validation
            $image = upload($_FILES['image']);
            if ($image !== false) {
                if (!empty($news['image'])) {
                    unlink(APP_DIR . '/public/uploads/' . $news['image']);
                    echo 'step 2!';
                }
                echo 'step 3!';
            } else {
                echo 'upload error!';
            }
        }

        News::update($_POST['id'], $_POST['title'], $_POST['fa_title'] ,$_POST['description'], $_POST['fa_description'] ,$image, $_POST['alt'], $_POST['alt_fa']);
        header("Location: " . Config::URL_BASE . "Admin/news/edit/" . $_POST['id']);
    }

    public function deleteAction()
    {
        $id = $this->route_params['id'];
        News::delete($id);
        header("Location: " . Config::URL_BASE . "Admin/news/list");
    }

}
