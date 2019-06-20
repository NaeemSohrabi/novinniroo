<?php

namespace App\Controllers;

use App\Config;
use App\Models\Customer;
use App\Models\Element;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class AdminCustomer extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function __construct(array $route_params)
    {
        parent::__construct($route_params);
        if(!isset($_SESSION['islogin'])){

            header("Location: ".Config::URL_BASE."#admin");
        }
    }
    public function insertAction()
    {
        $customers = Customer::getAll();
        $elements = Element::getAll();
        View::renderTemplate('Admin/customer/customer_insert.twig', ['customers' => $customers, 'elements' => $elements]);
    }

    public function storeAction()
    {
        if ($_FILES['logo']['size'] == 0 && $_FILES['logo']['error'] == 4) {
            echo 'file is null !';
        } else {
            $logo = upload($_FILES['logo']);
            if ($logo !== false) {
                Customer::insert($_POST['title'], $_POST['alt'], $_POST['alt_fa'] ,$logo);
            } else {
                echo 'upload error!';
            }
        }
        header("Location: " . Config::URL_BASE . "admin/customer/insert");
    }

    public function editAction()
    {
        $id = $this->route_params['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $customer = Customer::getCustomer($id);
            View::renderTemplate('Admin/customer/customer_edit.twig', ['customer' => $customer]);

        }
    }

    public function updateAction()
    {
        $customer = Customer::getCustomer($_POST['id']);
        // check file is sent
        if ($_FILES['logo']['size'] == 0 && $_FILES['logo']['error'] == 4) {
            $logo = $customer['logo'];
            echo 'step 1!';
        } else {
            // check upload validation
            $logo = upload($_FILES['logo']);
            if ($logo !== false) {
                if (!empty($customer['logo'])) {
                    unlink(APP_DIR . '\uploads\\' . $customer['logo']);
                    echo 'step 2!';
                }
                echo 'step 3!';
            } else {
                echo 'upload error!';
            }
        }
        Customer::update($_POST['id'], $_POST['title'], $_POST['alt'], $_POST['alt_fa'] ,$logo);
        header("Location: " . Config::URL_BASE . "admin/customer/edit/" . $customer['id']);
    }

    public function deleteAction()
    {
        $id = $this->route_params['id'];
        Customer::delete($id);
        header("Location: ".Config::URL_BASE."Admin/customer/insert");
    }


}
