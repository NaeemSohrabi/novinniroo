<?php
/**
 * Created by PhpStorm.
 * User: Naeem_Sohrabi
 * Date: 11/5/2017
 * Time: 9:39 PM
 */

namespace App\Controllers;


use App\Config;
use App\Models\Meta;
use Core\View;

class AdminMeta extends \Core\Controller
{
    public function __construct(array $route_params)
    {
        parent::__construct($route_params);
        if(!isset($_SESSION['islogin'])){

            header("Location: ".Config::URL_BASE."#admin");
        }
    }



    public function storeAction()
    {
        $meta = Meta::getMeta($_POST['entity_type'], $_POST['entity_id']);
        if(empty($meta)){
            Meta::insert($_POST['entity_type'], $_POST['entity_id'], $_POST['meta_tag'], $_POST['meta_tag_fa'] ,$_POST['meta_description'], $_POST['meta_description_fa']);
        }
        else{
            Meta::update($_POST['entity_type'], $_POST['entity_id'], $_POST['meta_tag'], $_POST['meta_tag_fa'] ,$_POST['meta_description'], $_POST['meta_description_fa']);
        echo 'hi';
        }

        header("Location: ".Config::URL_BASE."admin/".$_POST['entity_type']."/edit/".$_POST['entity_id'] . "#" . $_POST['tab_position']);


    }


}