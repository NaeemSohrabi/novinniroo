<?php

namespace App\Controllers;

use App\Config;
use App\Models\Brand;
use App\Models\Element;
use App\Models\Media;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class AdminFooter extends \Core\Controller
{

    public function __construct(array $route_params)
    {
        parent::__construct($route_params);
        if(!isset($_SESSION['islogin'])){

            header("Location: ".Config::URL_BASE."#admin");
        }
    }
    public function EditAction()
    {
        $elements = Element::getAll();
        View::renderTemplate('Admin/footer/edit.twig', ['elements' => $elements]);
    }


    public function agentsupdateAction()
    {
        $entity_key = $_POST['entity_key'];
        unset($_POST['entity_key']);
        $element = Element::getElement($entity_key);

        // if file image send to server, check and start upload
//        if (isset($_FILES['image'])) {
//            if ($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 4) {
//                echo 'step 1!';
//                $image = null;
//            } else {
//                // check upload validation
//                $image = upload($_FILES['image']);
//                if ($image !== false) {
//                    $element_image = (array)json_decode($element['entity_value']);
//                    if (isset($element_image['image'])) {
//                        if (!empty($element_image['image'])) {
//                            if(file_exists(APP_DIR . '\uploads\\' . $element_image['image'])){
//                                unlink(APP_DIR . '\uploads\\' . $element_image['image']);
//                            }
//                            echo 'step 2!';
//                        }
//                    }
//                    echo 'step 3!';
//                } else {
//                    echo 'upload error!';
//                }
//                $_POST['image'] = $image;
//            }
//        }

        $entity_value = json_encode($_POST);
//        print_r($_POST);
//        echo '<br>';
//        echo '<br>';
//        print_r($entity_value);
//        die();

        if (empty($element)) {
            Element::insert($entity_key, $entity_value);
        } else {
            Element::update($entity_key, $entity_value);
        }
        header("Location: " . Config::URL_BASE . "admin/footer/edit#$entity_key");
    }

    public function servicesupdateAction()
    {
        $entity_key = $_POST['entity_key'];
        unset($_POST['entity_key']);
        $element = Element::getElement($entity_key);

        // if file image send to server, check and start upload
//        if (isset($_FILES['image'])) {
//            if ($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 4) {
//                echo 'step 1!';
//                $image = null;
//            } else {
//                // check upload validation
//                $image = upload($_FILES['image']);
//                if ($image !== false) {
//                    $element_image = (array)json_decode($element['entity_value']);
//                    if (isset($element_image['image'])) {
//                        if (!empty($element_image['image'])) {
//                            if(file_exists(APP_DIR . '\uploads\\' . $element_image['image'])){
//                                unlink(APP_DIR . '\uploads\\' . $element_image['image']);
//                            }
//                            echo 'step 2!';
//                        }
//                    }
//                    echo 'step 3!';
//                } else {
//                    echo 'upload error!';
//                }
//                $_POST['image'] = $image;
//            }
//        }

        $entity_value = json_encode($_POST);
//        print_r($_POST);
//        echo '<br>';
//        echo '<br>';
//        print_r($entity_value);
//        die();

        if (empty($element)) {
            Element::insert($entity_key, $entity_value);
        } else {
            Element::update($entity_key, $entity_value);
        }
        header("Location: " . Config::URL_BASE . "admin/footer/edit#$entity_value");
    }





    public function contactupdateAction()
    {
        $entity_key = $_POST['entity_key'];
        unset($_POST['entity_key']);
        $element = Element::getElement($entity_key);

        // if file image send to server, check and start upload
        if (isset($_FILES['image'])) {
            if ($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 4) {
                echo 'step 1!';
                $image = null;
            } else {
                // check upload validation
                $image = upload($_FILES['image']);
                if ($image !== false) {
                    $element_image = (array)json_decode($element['entity_value']);
                    if (isset($element_image['image'])) {
                        if (!empty($element_image['image'])) {
                            if(file_exists(APP_DIR . '\uploads\\' . $element_image['image'])){
                                unlink(APP_DIR . '\uploads\\' . $element_image['image']);
                            }
                            echo 'step 2!';
                        }
                    }
                    echo 'step 3!';
                } else {
                    echo 'upload error!';
                }
                $_POST['image'] = $image;
            }
        }

        $entity_value = json_encode($_POST);
//        print_r($_POST);
//        echo '<br>';
//        echo '<br>';
//        print_r($entity_value);
//        die();

        if (empty($element)) {
            Element::insert($entity_key, $entity_value);
        } else {
            Element::update($entity_key, $entity_value);
        }
        header("Location: " . Config::URL_BASE . "admin/contact/edit");
    }
    public function aboutupdateAction()
    {
        $entity_key = $_POST['entity_key'];
        unset($_POST['entity_key']);
        $element = Element::getElement($entity_key);

        // if file image send to server, check and start upload
        if (isset($_FILES['image'])) {
            if ($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 4) {
                echo 'step 1!';
                $image = null;
            } else {
                // check upload validation
                $image = upload($_FILES['image']);
                if ($image !== false) {
                    $element_image = (array)json_decode($element['entity_value']);
                    if (isset($element_image['image'])) {
                        if (!empty($element_image['image'])) {
                            if(file_exists(APP_DIR . '\uploads\\' . $element_image['image'])){
                                unlink(APP_DIR . '\uploads\\' . $element_image['image']);
                            }
                            echo 'step 2!';
                        }
                    }
                    echo 'step 3!';
                } else {
                    echo 'upload error!';
                }
                $_POST['image'] = $image;
            }
        }

        $entity_value = json_encode($_POST);
//        print_r($_POST);
//        echo '<br>';
//        echo '<br>';
//        print_r($entity_value);
//        die();

        if (empty($element)) {
            Element::insert($entity_key, $entity_value);
        } else {
            Element::update($entity_key, $entity_value);
        }
        header("Location: " . Config::URL_BASE . "admin/about/edit");
    }



    public function contacteditAction()
    {
        $elements = Element::getAll();
        View::renderTemplate('Admin/contact_edit.twig', ['elements'=>$elements]);
    }
    public function abouteditAction()
    {
        $elements = Element::getAll();
        $medias = Media::getMediaAll('about', 'null', 'gallery');
        View::renderTemplate('Admin/about/about_edit.twig', ['elements'=>$elements, 'medias' => $medias]);
    }

}
