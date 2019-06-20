<?php

namespace App\Controllers;

use App\Config;
use App\Models\Brand;
use App\Models\Brandbranch;
use App\Models\Media;
use App\Models\Meta;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class AdminBrand extends \Core\Controller
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
        $brand = Brand::getAll();

        View::renderTemplate('Admin/brand/brand_list.twig', ['brands' => $brand]);
    }

    public function InsertAction()
    {

        View::renderTemplate('Admin/brand/brand_insert.twig');
    }

    public function storeAction()
    {

        $brand_logo = upload($_FILES['brand_logo']);
        if ($brand_logo !== false) {
            Brand::insert($_POST['fa_title'] ,$_POST['title'], $_POST['fa_description'] ,$_POST['description'], $_POST['fa_branch_text'] ,$_POST['branch_text'], $brand_logo);
        } else {
            echo 'upload error!';
        }
        header("Location: ".Config::URL_BASE."admin/brand/list");
    }

    public function editAction()
    {
        $id = $this->route_params['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $brand = Brand::getBrand($id);
            $media = Media::getMediaAll('brand', $id, 'gallery');
            $branches = Brandbranch::getBrandBranch($id);
            $meta = Meta::getMeta('brand', $id);
            View::renderTemplate('Admin/brand/brand_edit.twig', ['brand' => $brand, 'medias' => $media, 'branches' => $branches, 'meta' => $meta]);

        }
    }

    public function updateAction()
    {
        $brand = Brand::getBrand($_POST['id']);
        // check file is sent
        if ($_FILES['brand_logo']['size'] == 0 && $_FILES['brand_logo']['error'] == 4) {
            $brand_logo = $brand['brand_logo'];
            echo 'step 1!';
        }else{
            // check upload validation
            $brand_logo = upload($_FILES['brand_logo']);
            if ($brand_logo !== false) {
                if(!empty($brand['brand_logo'])){
                    unlink(APP_DIR.'/public/uploads/'.$brand['brand_logo']);
                    echo 'step 2!';
                }
                echo 'step 3!';
            } else {
                echo 'upload error!';
            }
        }
        Brand::update($_POST['id'], $_POST['fa_title'] ,$_POST['title'], $_POST['fa_description'] ,$_POST['description'], $_POST['fa_branch_text'] ,$_POST['branch_text'], $brand_logo);
        header("Location: ".Config::URL_BASE."admin/brand/edit/".$brand['id']);
    }

    public function deleteAction()
    {
        $id = $this->route_params['id'];
        Brand::delete($id);
        header("Location: ".Config::URL_BASE."admin/brand/list");
    }


    public function mediastoreAction()

    {
        if ($_FILES['media']['size'] == 0 && $_FILES['media']['error'] == 4) {
            echo 'file is null !';
        }else{
            $media_file = upload($_FILES['media']);
            if ($media_file !== false) {
                Media::insert($_POST['entity_type'], $_POST['entity_id'], $_POST['entity_position'],null, null, null, null , null,$media_file);
            } else {
                echo 'upload error!';
            }
        }
        header("Location: ".Config::URL_BASE."admin/".$_POST['entity_type']."/edit/".$_POST['entity_id']);
    }

    public function BranchInsertAction()
    {
        $brand_id = $this->route_params['id'];
        $amin= 'amin shakie';
        View::renderTemplate('Admin/branch/branch_insert.twig' , ['brand_id' => $brand_id , 'amin' => $amin]);

    }

    public function BranchStoreAction()
    {

        $image = upload($_FILES['image']);
        if ($image !== false) {
            Brandbranch::insert($_POST['title'], $image, $_POST['brand_id']);
        } else {
            echo 'upload error!';
        }
        header("Location: ".Config::URL_BASE."admin/brand/edit/" . $_POST['brand_id']);
    }

    public function BranchDeleteAction()
    {
        $id = $this->route_params['id'];
        $branch = Brandbranch::getBranch($id);
        Brandbranch::delete($id);
        header("Location: ".Config::URL_BASE."admin/brand/edit/".$branch['brand_id']);
    }

    public function BranchEditAction()
    {
        $id = $this->route_params['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $branch = Brandbranch::getBranch($id);
            View::renderTemplate('Admin/branch/branch_edit.twig', ['branch' => $branch]);
        }
    }

    public function BranchUpdateAction()
    {
        $branch = Brandbranch::getBranch($_POST['id']);
        // check file is sent
        if ($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 4) {
            $image = $branch['image'];
            echo 'step 1!';
        }else{
            // check upload validation
            $image = upload($_FILES['image']);
            if ($image !== false) {
                if(!empty($branch['image'])){
                    unlink(APP_DIR.'/public/uploads/'.$branch['image']);
                    echo 'step 2!';
                }
                echo 'step 3!';
            } else {
                echo 'upload error!';
            }
        }
        Brandbranch::update($_POST['title'], $image, $branch['id']);
        header("Location: ".Config::URL_BASE."admin/brand/branch/edit/".$branch['id']);
    }





}
