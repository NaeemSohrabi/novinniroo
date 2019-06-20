<?php
/**
 * Created by PhpStorm.
 * User: Naeem_Sohrabi
 * Date: 11/5/2017
 * Time: 9:39 PM
 */

namespace App\Controllers;


use App\Config;
use App\Models\Menu;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Page;
use Core\View;

class AdminMenu extends \Core\Controller
{
    public function __construct(array $route_params)
    {
        parent::__construct($route_params);
        if(!isset($_SESSION['islogin'])){

            header("Location: ".Config::URL_BASE."#admin");
        }
    }

    public function listAction()
    {
        $menues = Menu::getAll();

        View::renderTemplate('Admin/menu/menu_list.twig', ['menues' => $menues]);

    }
    public function insertAction()
    {
        $menues = Menu::getAll();
        $all_menu = Menu::getAll();
        $brands = Brand::getAll();
        $products = Product::getAll();
        $pages = Page::getAll();
        View::renderTemplate('Admin/menu/menu_insert.twig', ['menues' => $menues, 'all_menu'=> $all_menu, 'brands'=>$brands, 'products'=>$products, 'pages'=>$pages ]);

    }
    public function storeAction()
    {
        Menu::insert($_POST['title'], $_POST['fa_title'] ,$_POST['link'], $_POST['parent_id'], $_POST['sort']);

        header("Location: ".Config::URL_BASE."admin/menu/list");


    }
    public function editAction()
    {
        $id = $this->route_params['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $menu = Menu::getMenu($id);
            $all_menu = Menu::getAll();
            $brands = Brand::getAll();
            $pages = Page::getAll();
            $products = Product::getAll();
            View::renderTemplate('Admin/menu/menu_edit.twig', ['menu' => $menu, 'all_menu'=> $all_menu, 'brands'=>$brands, 'products'=>$products, 'pages'=>$pages ]);
        }



    }
    public function updateAction()
    {

//        $menu = Menu::getMenu($_POST['id']);

        Menu::update($_POST['id'], $_POST['title'], $_POST['fa_title'] ,$_POST['link'], $_POST['parent_id'], $_POST['sort']);
        header("Location: ".Config::URL_BASE."admin/menu/list");

    }
    public function deleteAction()
    {
        $id = $this->route_params['id'];

        Menu::delete($id);

        header("Location: ".Config::URL_BASE."admin/menu/list");

    }


}