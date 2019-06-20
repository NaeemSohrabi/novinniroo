<?php

namespace App\Controllers;

use App\Config;
use App\Models\Customer;
use App\Models\Element;
use App\Models\Employee;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class AdminEmployee extends \Core\Controller
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
//        $customers = Customer::getAll();
//        $elements = Element::getAll();
        View::renderTemplate('Admin/about/employee_insert.twig');
    }

    public function storeAction()
    {
        if ($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 4) {
            echo 'file is null !';
        } else {
            $image = upload($_FILES['image']);
            if ($image !== false) {
                Employee::insert($_POST['name'], $_POST['fa_name'] ,$_POST['family'], $_POST['fa_family'] ,$_POST['department'], $_POST['fa_department'] ,$_POST['email'], $_POST['phone'] ,$image);
            } else {
                echo 'upload error!';
            }
        }
        header("Location: " . Config::URL_BASE . "admin/employee/list");
    }

    public function ListAction()
    {
        $employees = Employee::getAll();

        View::renderTemplate('Admin/about/employee_list.twig', ['employees' => $employees]);

    }

    public function editAction()
    {
        $id = $this->route_params['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $employee = Employee::getEmployee($id);
            View::renderTemplate('Admin/about/employee_edit.twig', ['employee' => $employee]);

        }
    }

    public function updateAction()
    {
        $employee = Employee::getEmployee($_POST['id']);
        // check file is sent
        if ($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 4) {
            $image = $employee['image'];
            echo 'step 1!';
        } else {
            // check upload validation
            $image = upload($_FILES['image']);
            if ($image !== false) {
                if (!empty($employee['image'])) {
                    unlink(APP_DIR . '\uploads\\' . $employee['image']);
                    echo 'step 2!';
                }
                echo 'step 3!';
            } else {
                echo 'upload error!';
            }
        }
        Employee::update($_POST['id'], $_POST['name'], $_POST['fa_name'] ,$_POST['family'], $_POST['fa_family'] ,$_POST['department'], $_POST['fa_department'] ,$_POST['email'], $_POST['phone'] ,$image);
        header("Location: " . Config::URL_BASE . "admin/employee/list");
    }

    public function deleteAction()
    {
        $id = $this->route_params['id'];
        Employee::delete($id);
        header("Location: ".Config::URL_BASE."Admin/employee/list");
    }


}
