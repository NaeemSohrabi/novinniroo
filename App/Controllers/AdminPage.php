<?php

namespace App\Controllers;

use App\Config;
use App\Models\Meta;
use App\Models\Page;
use App\Models\Media;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class AdminPage extends \Core\Controller
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
        $pages = Page::getAll();

        View::renderTemplate('Admin/page/list.twig', ['pages' => $pages]);
    }

    public function InsertAction()
    {

        View::renderTemplate('Admin/page/insert.twig');
    }

    public function storeAction()
    {

        Page::insert($_POST['title'],$_POST['fa_title'],$_POST['summary'],$_POST['fa_summary'],$_POST['subtitle'],$_POST['fa_subtitle'],$_POST['description'],$_POST['fa_description'],$_POST['slug']);
        header("Location: ".Config::URL_BASE."admin/page/list");
    }

    public function editAction()
    {
        $id = $this->route_params['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $page = Page::getPage($id);
            $media = Media::getMediaAll('page', $id, 'gallery');
            $meta = Meta::getMeta('page', $id);
            View::renderTemplate('Admin/page/edit.twig', ['page' => $page, 'medias' => $media, 'meta' => $meta]);

        }
    }

    public function updateAction()
    {
        $page = Page::getPage($_POST['id']);


        Page::update($_POST['id'],$_POST['title'],$_POST['fa_title'],$_POST['summary'],$_POST['fa_summary'],$_POST['subtitle'],$_POST['fa_subtitle'],$_POST['description'],$_POST['fa_description'],$_POST['slug']);
        header("Location: ".Config::URL_BASE."admin/page/edit/".$page['id']);
    }

    public function deleteAction()
    {
        $id = $this->route_params['id'];
        Page::delete($id);
        header("Location: ".Config::URL_BASE."admin/page/list");
    }

    public function mediastoreAction()

    {
        if ($_FILES['media']['size'] == 0 && $_FILES['media']['error'] == 4) {
            echo 'file is null !';
        }else{
            $media_file = upload($_FILES['media']);
            if ($media_file !== false) {
                Media::insert($_POST['entity_type'], $_POST['entity_id'], $_POST['entity_position'],null, null, null, null,null ,$media_file);
            } else {
                echo 'upload error!';
                print_r($media_file);
            }
        }
        header("Location: ".Config::URL_BASE."admin/".$_POST['entity_type']."/edit/".$_POST['entity_id']);
    }

}
