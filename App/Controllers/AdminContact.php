<?php

namespace App\Controllers;

use App\Config;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Media;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class AdminContact extends \Core\Controller
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
        $contacts = Contact::getAll();

        View::renderTemplate('Admin/contact/list.twig', ['contacts' => $contacts]);
    }

    public function InsertAction()
    {

        View::renderTemplate('Admin/contact/insert.twig');
    }

    public function storeAction()
    {

        Contact::insert($_POST['en_name'], $_POST['fa_name'] ,$_POST['phone'],$_POST['fax'],$_POST['mobile'],$_POST['email'],$_POST['web'],$_POST['fa_address'],$_POST['en_address'],$_POST['lat'], $_POST['lng']);
        header("Location: ".Config::URL_BASE."admin/contact/list");
    }

    public function editAction()
    {
        $id = $this->route_params['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $contact = Contact::getContact($id);
            View::renderTemplate('Admin/contact/edit.twig', ['contact' => $contact,]);

        }
    }

    public function updateAction()
    {
        $contact = Contact::getContact($_POST['id']);
        $phone = $_POST['phone'];


        Contact::update($_POST['id'],$_POST['en_name'], $_POST['fa_name'] ,$phone,$_POST['fax'],$_POST['mobile'],$_POST['email'],$_POST['web'],$_POST['fa_address'],$_POST['en_address'],$_POST['lat'], $_POST['lng']);
        header("Location: ".Config::URL_BASE."admin/contact/edit/".$contact['id']);
    }

    public function deleteAction()
    {
        $id = $this->route_params['id'];
        Contact::delete($id);
        header("Location: ".Config::URL_BASE."admin/contact/list");
    }


}
